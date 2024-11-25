<?php

namespace App\Http\Controllers\admin\land;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\admin\bid\Bid;
use App\Models\admin\land\LandArea;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    public function placeBid(Request $request, $id)
    {
        $landArea = LandArea::findOrFail($id);

        if ($request->bid_amount <= $landArea->highest_bid ?? 0) {
            return redirect()->back()->with('error', 'يجب أن تكون المزايدة أعلى.');
        }

        $user = Auth::user();
        if ($user->balance < $request->bid_amount) {
            return redirect()->back()->with('error', 'لا يوجد رصيد كافي.');
        }

        Bid::create([
            'land_area_id' => $landArea->id,
            'user_id' => $user->id,
            'bid_amount' => $request->bid_amount,
        ]);

        $user->save();

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

        return response()->json(['success' => true, 'message' => 'تم دفع الغرامة وتجديد الرخصة بنجاح']);
    }
    public function payTax(Request $request)
    {
        $landAreaId = $request->input('landAreaId'); // تغيرنا من bidId إلى landAreaId

        $landArea = LandArea::find($landAreaId);
        if (!$landArea) {
            return response()->json(['message' => 'المنطقة الأرضية غير موجودة'], 404);
        }

        // الحصول على المستخدم الحالي
        $user = Auth::user();

        // تحقق من أن الرصيد كافٍ لدفع 50 ريال
        if ($user->balance < 50) {
            return response()->json(['message' => 'رصيدك غير كافٍ للدفع'], 400);
        }

        $user->balance -= 50;
        $user->save();

        if ($landArea->tax == 1 && $landArea->tax_end_time < now()) {
            $landArea->tax_end_time = now()->addDays(7);
        }

        $landArea->tax = 1;
        $landArea->save();

        return response()->json([
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




}
