<?php

namespace App\Http\Controllers\admin\land;

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

    // التحقق من أن المبلغ المعروض أكبر من السعر الحالي للمزاد
    if ($request->bid_amount <= $landArea->highest_bid ?? 0) {
        return redirect()->back()->with('error', 'يجب أن تكون المزايدة أعلى.');
    }

    $user = Auth::user();
    if ($user->balance < $request->bid_amount) {
        return redirect()->back()->with('error', 'لا يوجد رصيد كافي.');
    }

    // إضافة المزايدة
    Bid::create([
        'land_area_id' => $landArea->id,
        'user_id' => $user->id,
        'bid_amount' => $request->bid_amount,
    ]);

    // خصم المبلغ من رصيد المستخدم
    $user->save();

    return redirect()->back()->with('success', 'تم تقديم المزايدة بنجاح!');
}



}
