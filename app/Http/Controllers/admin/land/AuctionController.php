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
        $currentHighestBid = Bid::where('land_area_id', $id)->orderBy('bid_amount', 'desc')->first();

        $price = Price::first(); // إذا كنت تريد تحديث أول سجل فقط. يمكنك تخصيص البحث إذا كان هناك أكثر من سجل.

        $user = Auth::user();

        // تحديد الحد الأدنى للمزايدة المطلوبة
        $minimumBidAmount = $currentHighestBid ? $currentHighestBid->bid_amount + $price->bid_price : $price->bid_price;

        // التحقق إذا كانت المزايدة الجديدة أعلى من المبلغ المطلوب
        if ($request->bid_amount < $minimumBidAmount) {
            return redirect()->back()->with('error', sprintf('يجب أن تكون المزايدة أعلى من %d.', $minimumBidAmount));
        }

        // التحقق إذا كان لدى المستخدم مزايدة سابقة على نفس المزاد
        $userHighestBid = Bid::where('land_area_id', $id)
            ->where('user_id', $user->id)
            ->orderBy('bid_amount', 'desc')
            ->first();

        // التحقق من الرصيد الكافي قبل استرجاع مبلغ المزايدة السابقة
        $totalAvailableBalance = $user->balance + ($userHighestBid ? $userHighestBid->bid_amount : 0);
        if ($totalAvailableBalance < $request->bid_amount) {
            return redirect()->back()->with('error', 'لا يوجد رصيد كافي.');
        }

        if ($userHighestBid) {
            // إعادة أعلى مزايدة سابقة للمستخدم من freeze_balance إلى balance
            $user->balance += $userHighestBid->bid_amount;
            $user->freeze_balance -= $userHighestBid->bid_amount;
            $user->save();
        }

        // خصم المبلغ الجديد من balance وإضافته إلى freeze_balance
        $user->balance -= $request->bid_amount;
        $user->freeze_balance += $request->bid_amount;
        $user->save();

        // إنشاء المزايدة الجديدة
        Bid::create([
            'land_area_id' => $landArea->id,
            'user_id' => $user->id,
            'bid_amount' => $request->bid_amount,
        ]);

        return redirect()->back()->with('success', 'تم تقديم المزايدة بنجاح!');
    }




    public function payTax(Request $request)
    {
        // استلام معرف المنطقة الأرضية
        $landAreaId = $request->input('landAreaId');

        // العثور على المنطقة الأرضية
        $landArea = LandArea::find($landAreaId);
        if (!$landArea) {
            return response()->json(['success' => false, 'message' => 'المنطقة الأرضية غير موجودة']);
        }

        // الحصول على المستخدم الحالي
        $user = Auth::user();

        // الحصول على أول سجل للسعر
        $price = Price::first(); // تعديل لاختيار أول سجل فقط
        if (!$price) {
            return response()->json(['success' => false, 'message' => 'لم يتم العثور على سعر الضريبة']);
        }

        // التحقق من رصيد المستخدم
        if ($user->balance < $price->tax_price) {
            return response()->json(['success' => false, 'message' => 'رصيدك غير كافٍ للدفع']);
        }

        // خصم السعر من رصيد المستخدم
        $user->balance -= $price->tax_price;
        $user->save();

        // تحديث بيانات المنطقة الأرضية
        if ($landArea->tax == 1 && $landArea->tax_end_time < now()) {
            $landArea->tax_end_time = now()->addDays(7);
        }
        $landArea->tax = 1;
        $landArea->save();

        // إعادة استجابة JSON عند النجاح
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

            // التحقق إذا كان لدى المستخدم رصيد كافٍ
            $user = auth()->user();
            $price = Price::first(); // إذا كنت تريد تخصيص السعر من جدول الأسعار

            if ($user->balance < $price->tax_price) {
                return response()->json(['success' => false, 'message' => 'رصيدك غير كافٍ للدفع']);
            }

            // خصم المبلغ من رصيد المستخدم
            $user->balance -= $price->tax_price;
            $user->save();

            // تمديد الوقت وتحديث حالة الضريبة
            $landArea->tax_end_time = Carbon::parse($newEndTime);
            $landArea->tax = 0; // تعيين tax إلى 0 بعد تمديد الوقت
            $landArea->save();

            // تسجيل العملية في السجل
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







 public function updateGoTime(Request $request)
 {
     // التحقق من أن البيانات صحيحة
     $validated = $request->validate([
         'land_area_id' => 'required|exists:land_areas,id',
     ]);

     $landArea = LandArea::find($validated['land_area_id']);
     if ($landArea) {
         // التحقق إذا كانت قيمة go_time قد مرت
         if ($landArea->go_time <= now()) {
             // تحديث قيمة go إلى 1
             $landArea->update(['go' => 1]);

             return response()->json(['success' => true]);
         } else {
             return response()->json(['success' => false, 'message' => 'الوقت لم ينته بعد']);
         }
     }

     return response()->json(['success' => false, 'message' => 'المنطقة غير موجودة']);
 }

public function updateStop(Request $request)
{
    $landArea = LandArea::where('stop', false)  // تأكد من أن stop = 0 فقط
                         ->whereNotNull('stop_time') // تأكد من وجود stop_time
                         ->get();

    foreach ($landArea as $area) {
        // التحقق إذا كان الوقت الحالي قد مرّ على stop_time
        if (now() > $area->stop_time) {
            // إذا مر الوقت، يتم تحديث stop إلى 1
            $area->stop = 1;
            $area->save();
        }
    }

    return response()->json(['success' => true, 'message' => 'تم تحديث الحقل stop بنجاح']);
}

public function updateGoStatus(Request $request)
{
    $land = LandArea::find($request->id);

    if ($land) {
        $land->go = 1;
        $land->save();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'Land not found']);
}
}