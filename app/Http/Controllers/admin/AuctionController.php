<?php

namespace App\Http\Controllers\admin\land;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\admin\bid\Bid;
use Illuminate\Support\Facades\DB;
use App\Models\admin\land\LandArea;
use App\Http\Controllers\Controller;
use App\Models\admin\price\Price;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    public function placeBid(Request $request, $id)
    {
        $landArea = LandArea::findOrFail($id);

        // التحقق من قيمة المزايدة
        if ($request->bid_amount <= $landArea->highest_bid ?? 0) {
            return redirect()->back()->with('error', 'يجب أن تكون المزايدة أعلى.');
        }

        $user = Auth::user();

        // خصم المبلغ من balance ونقله إلى freeze_balance
        $user->balance -= $request->bid_amount;
        $user->freeze_balance += $request->bid_amount;
        $user->update();
        // التحقق من الرصيد المتاح
        if ($user->balance < $request->bid_amount) {
            return redirect()->back()->with('error', 'لا يوجد رصيد كافي.');
        }


        // إنشاء المزايدة
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

        $price = Price::all();
        if ($user->balance < $price->tax_price) {
            return response()->json(['success' => false, 'message' => 'رصيدك غير كافٍ للدفع']);
        }

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
// AuctionController
public function adjustBalance(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'bid_amount' => 'required|numeric|min:0',
        'action' => 'required|string|in:return',
    ]);

    $user = User::find($validated['user_id']);

    try {
        DB::beginTransaction(); // بدء المعاملة

        if ($validated['action'] === 'return') {
            if ($user->freeze_balance >= $validated['bid_amount']) {
                // تحديث الرصيد داخل المعاملة
                $user->balance += $validated['bid_amount'];
                $user->freeze_balance -= $validated['bid_amount'];
                $user->save();

                DB::commit(); // تأكيد العملية
                return response()->json(['success' => true, 'message' => 'تم تعديل الرصيد بنجاح']);
            } else {
                DB::rollBack(); // إلغاء العملية في حالة خطأ
                return response()->json(['success' => false, 'error' => 'رصيد التجميد غير كافٍ']);
            }
        }

        DB::rollBack(); // إلغاء العملية لأي إجراء غير مدعوم
        return response()->json(['success' => false, 'error' => 'إجراء غير مدعوم']);
    } catch (\Exception $e) {
        DB::rollBack(); // إلغاء العملية في حالة حدوث خطأ
        return response()->json(['success' => false, 'error' => 'حدث خطأ أثناء تعديل الرصيد: ' . $e->getMessage()]);
    }
}

}
