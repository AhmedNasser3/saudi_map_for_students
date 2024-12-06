<?php

namespace App\Http\Controllers\admin\land;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\admin\bid\Bid;
use App\Models\admin\price\Price;
use App\Models\admin\land\LandArea;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    public function placeBid(Request $request, $id)
{
    $landArea = LandArea::findOrFail($id);
    $bids = Bid::where('land_area_id', $id)->orderBy('bid_amount', 'desc')->first();
    $bid = Bid::orderBy('bid_amount', 'desc')->first();

    // التحقق من وجود السجل ووجود المستخدم المرتبط به
    if ($bid) {
        // تعديل balance و freeze_balance للمستخدم
        $bid->user->balance += $bid->bid_amount;
        $bid->user->freeze_balance -= $bid->bid_amount;
        // حفظ التعديلات على المستخدم
        $bid->user->save();
    }


    // التحقق إذا كانت المزايدة موجودة
    if ($bids && $bids->user_id == 1423523523532523532) {
        // حذف المزايدة إذا كانت موجودة
        $bids->delete();
    }





    // التحقق من وجود مزايدات
    $price = Price::first(); // إذا كنت تريد تحديث أول سجل فقط. يمكنك تخصيص البحث إذا كان هناك أكثر من سجل

    // التحقق إذا كانت المزايدة الجديدة أكبر من المزايدة الحالية
    if ($bids && $request->bid_amount <= $bids->bid_amount + $price->bid_price) {
        return redirect()->back()->with('error', sprintf('يجب أن تكون المزايدة أعلى من %d.', $bids->bid_amount + $price->bid_price));
    }

    // التحقق من الرصيد المتاح
    $user = Auth::user();
    if ($user->balance < $request->bid_amount) {
        return redirect()->back()->with('error', 'لا يوجد رصيد كافي.');
    }

    // خصم المبلغ من balance ونقله إلى freeze_balance
    $user->balance -= $request->bid_amount;
    $user->freeze_balance += $request->bid_amount;
    $user->update();

    // إنشاء المزايدة الجديدة
    Bid::create([
        'land_area_id' => $landArea->id,
        'user_id' => $user->id,
        'bid_amount' => $request->bid_amount,
    ]);

    return redirect()->back()->with('success', 'تم تقديم المزايدة بنجاح!');
}


    public function payFine(Request $request)
    {
        $landAreaId = $request->input('landAreaId');
        $landArea = LandArea::find($landAreaId);
        if (!$landArea) {
            return response()->json(['success' => false, 'message' => 'المنطقة الأرضية غير موجودة']);
        }

        $user = Auth::user();
        $fineAmount = 100;

        if ($user->balance < $fineAmount) {
            return response()->json(['success' => false, 'message' => 'رصيدك غير كافٍ لدفع الغرامة']);
        }

        $user->balance -= $fineAmount;
        $user->save();

        $landArea->tax_end_time = now()->addDays(7);
        $landArea->tax = 0;
        $landArea->save();

        return response()->json(['success' => true, 'message' => 'تم دفع الغرامة بنجاح']);
    }

    public function payTax(Request $request)
    {
        $landAreaId = $request->input('landAreaId');

        $landArea = LandArea::find($landAreaId);
        if (!$landArea) {
            return response()->json(['success' => false, 'message' => 'المنطقة الأرضية غير موجودة']);
        }

        $user = Auth::user();

        if ($user->balance < 50) {
            return response()->json(['success' => false, 'message' => 'رصيدك غير كافٍ للدفع']);
        }
        $price = Price::first(); // إذا كنت تريد تحديث أول سجل فقط. يمكنك تخصيص البحث إذا كان هناك أكثر من سجل

        $user->balance -= $price->tax_price;
        $user->save();

        if ($landArea->tax == 1 && $landArea->tax_end_time < now()) {
            $landArea->tax_end_time = now()->addDays(7);
        }

        $landArea->tax = 1;
        $landArea->save();

        return response()->json([
            'success' => true,
            'message' => 'تم الدفع بنجاح',
            'tax_end_time' => $landArea->tax_end_time
        ]);
    }

    public function extendTaxTime(Request $request)
    {
        try {
            $landAreaId = $request->landAreaId;
            $newEndTime = $request->newEndTime;

            $landArea = LandArea::find($landAreaId);
            if (!$landArea) {
                return response()->json(['success' => false, 'message' => 'المنطقة الأرضية غير موجودة']);
            }

            $landArea->tax_end_time = Carbon::parse($newEndTime);
            $landArea->tax = 0; // تحديث tax إلى 0
            $landArea->save();

            \Log::info('Land area tax time updated', ['land_area_id' => $landAreaId, 'new_end_time' => $newEndTime]);

            return response()->json(['success' => true, 'message' => 'تم تمديد الرخصة بنجاح!']);
        } catch (\Exception $e) {
            \Log::error("Error extending tax time: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء التمديد: ' . $e->getMessage()]);
        }
    }
 // دالة لتحديث حالة المزاد
 public function updateState(Request $request)
 {
     // تحقق من وجود المعاملات المطلوبة
     $auctionId = $request->input('auction_id');
     $state = $request->input('state');

     // العثور على المزاد حسب الـ auction_id
     $land = LandArea::find($auctionId);

     if ($land) {
         // تحديث حالة المزاد إلى 0
         $land->state = $state;
         $land->save(); // حفظ التغييرات في قاعدة البيانات

         return response()->json(['message' => 'تم تحديث حالة المزاد بنجاح']);
     } else {
         return response()->json(['message' => 'المزاد غير موجود'], 404);
     }
 }
}
