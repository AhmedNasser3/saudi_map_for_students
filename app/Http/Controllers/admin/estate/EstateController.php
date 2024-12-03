<?php

namespace App\Http\Controllers\admin\estate;

use Illuminate\Http\Request;
use App\Models\admin\land\LandArea;
use App\Http\Controllers\Controller;
use App\Models\admin\bid\Bid;
use App\Models\admin\estate\Estate;

class EstateController extends Controller
{
    // في الـController الخاص بك
public function updateLandEstateStatus(Request $request)
{
    $landArea = LandArea::find($request->landAreaId);

    if (!$landArea) {
        return response()->json(['success' => false, 'message' => 'الأرض غير موجودة']);
    }

    // تحديث show_to_estate إلى 1
    $landArea->show_to_estate = $request->showToEstate;
    $landArea->save();

    return response()->json(['success' => true]);
}



// view
public function index(){
    $landAreas = LandArea::all();
    return view('admin.estate.index',compact('landAreas'));
}
public function store(Request $request)
{
    $data = $request->validate([
        'min_price' => 'required|numeric|min:0',  // يجب أن يكون السعر رقماً
        'landArea_id' => 'required|exists:land_areas,id',  // التحقق من وجود landArea_id في جدول land_areas
    ]);

    // إنشاء سجل جديد في جدول Estate
    Estate::create([
        'min_price' => $data['min_price'],
        'landArea_id' => $data['landArea_id'],
    ]);

    LandArea::where('id', $data['landArea_id'])->update([
        'show_to_estate' => 3,  // تحديث show_to_estate إلى 0
    ]);

    return redirect()->back()->with('success', 'تم إضافة العقار وتحديث العرض بنجاح!');
}

public function create(Request $request, $landAreaId){
    $landArea = LandArea::find($landAreaId);
    $estates = Estate::where('landArea_id', $landAreaId)->get();
    return view('frontend.estate.create', compact('landArea', 'estates'));
}
public function storeLandArea(Request $request,$LandAreaId)
{
    $landAreas = LandArea::find($LandAreaId);
    // التحقق من صحة البيانات
    $LandsAreaStore = $request->validate([
        'land_id' => '|integer',
        'area' => '|string|max:255',
        'starting_price' => '|numeric',
        'auction_end_time' => '|date',
        'user_id',
        'final_price' => 'nullable|numeric',
        'day' => '',
        'duration' => '|integer',
        'highest_bidder_id' => 'nullable|integer',
        'highest_bid' => 'nullable|numeric',
        'tax' => 'nullable|numeric',
        'tax_end_time' => 'nullable|date',
        'start_time' => 'nullable|date',
        'state' => 'nullable|string|max:255',
        'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20048',
        'show_to_estate'  => 'nullable|string|max:255',
        'number_of_auctions' => '|integer|min:1',
        'add_balance_to_seller',
    ]);

    // إذا لم يتم توفير معلومات العطاء، قم بتعيينها إلى null
    if (!$request->has('highest_bidder_id')) {
        $LandsAreaStore['highest_bidder_id'] = null;
    }

    if (!$request->has('highest_bid')) {
        $LandsAreaStore['highest_bid'] = null;
    }
    $bids = Bid::where('land_area_id', $landAreas->id)->get();
    $bids->each(function ($bid) {
        $bid->delete();
    });

    // تعيين الحالة إلى 1
    $LandsAreaStore['state'] = 1;

    // تعيين الحالة إلى 1
    $LandsAreaStore['state'] = 1;
    // تعيين الحالة إلى 0
    $LandsAreaStore['add_balance_to_seller'] = 1;


    $bids_amount = Bid::create([
        'land_area_id' => $landAreas->id, // استخدم معرف قطعة الأرض هنا
        'user_id' => 1, // استخدم معرف المستخدم
        'bid_amount' => $LandsAreaStore['starting_price'], // استخدم السعر الابتدائي
        'state' => 1, // الحالة الافتراضية للعطاء
    ]);

    $landAreas->update($LandsAreaStore);



    return redirect()->route('home.page')->with('success', 'تم تحديث المزادات بنجاح');
}

}
