<?php

namespace App\Http\Controllers\admin\landarea;

use Illuminate\Http\Request;
use App\Models\admin\land\Land;
use App\Models\admin\land\LandArea;
use App\Http\Controllers\Controller;
use App\Models\admin\tax\Tax;

class MainLandAreaController extends Controller
{

    public function index(){
        $landAreas = LandArea::orderBy('id', 'asc')->get();
        return view('admin.land_areas.index', compact('landAreas'));
    }
    public function create(){
        $landAreas = Land::all();
        return view('admin.land_areas.create', compact('landAreas'));
    }
    public function store(Request $request)
    {
        $LandsAreaStore = $request->validate([
            'land_id' => 'required|integer',
            'area' => 'required|string|max:255',
            'starting_price' => 'required|numeric',
            'auction_end_time' => 'required|date',
            'user_id' => 'required|integer',
            'final_price' => 'nullable|numeric',
            'day' => 'required',
            'duration' => 'required|integer',
            'highest_bidder_id' => 'nullable|integer',
            'highest_bid' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'tax_end_time' => 'nullable|date',
            'start_time' => 'nullable|date',
            'state' => 'nullable|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20048',
            'number_of_auctions' => 'required|integer|min:1',
        ]);
        $numberOfAuctions = $request->number_of_auctions;
        for ($i = 0; $i < $numberOfAuctions; $i++) {
            $landAreaData = $LandsAreaStore;
            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/lands', $imageName);
                $landAreaData['img'] = 'lands/' . $imageName;
            }
            $landArea =  LandArea::create($landAreaData);
        }
        Tax::create(['landArea_id' => $landArea->id]);

        return redirect()->route('landArea.page')->with('success', 'تم إنشاء المزادات بنجاح');
    }

    public function edit($landArea_id)
    {
        // العثور على المزاد باستخدام الـ ID المرسل من الرابط
        $landArea = LandArea::findOrFail($landArea_id);

        // استرجاع جميع الأراضي المتاحة لتكون في الاختيار في الـ dropdown
        $landAreas = Land::all();

        // عرض صفحة التعديل مع إرسال بيانات الأرض والمزاد
        return view('admin.land_areas.edit', compact('landArea', 'landAreas'));
    }

    public function update(Request $request, $landArea_id)
    {
        // التحقق من البيانات المدخلة
        $LandsAreaUpdate = $request->validate([
            'land_id' => 'required|integer',
            'area' => 'required|string|max:255',
            'starting_price' => 'required|numeric',
            'auction_end_time' => 'required|date',
            'user_id' => 'required|integer',
            'final_price' => 'nullable|numeric',
            'day' => 'required',
            'duration' => 'required|integer',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20048',
            'number_of_auctions' => 'required|integer|min:1',
        ]);

        // العثور على المزاد المحدد باستخدام الـ ID
        $landArea = LandArea::findOrFail($landArea_id);

        // تحديث البيانات
        $landArea->update($LandsAreaUpdate);

        // إذا كانت هناك صورة جديدة، يجب تخزينها
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/lands', $imageName);
            $landArea->img = 'lands/' . $imageName;
            $landArea->save();
        }

        // إعادة التوجيه إلى صفحة المزادات مع رسالة نجاح
        return redirect()->route('landArea.page')->with('success', 'تم تحديث المزاد بنجاح');
    }
        public function delete ($id){
        $landArea = LandArea::find($id);
        $landArea->delete();
        return redirect()->route('landArea.page')->with('تم ازالة المزاد بنجاح');
    }
    public function deleteSelected(Request $request)
{
    if ($request->has('selected')) {
        LandArea::whereIn('id', $request->selected)->delete();
        return redirect()->route('landArea.page')->with('success', 'تم حذف المزادات المحددة بنجاح');
    }

    return redirect()->route('landArea.page')->with('error', 'لم يتم اختيار أي مزاد للحذف');
}
public function setRenewDays(Request $request)
{
    $validated = $request->validate([
        'landAreaId' => 'required|exists:land_areas,id',
        'newDays' => 'required|integer|min:1',
    ]);

    $landArea = LandArea::findOrFail($validated['landAreaId']);
    $newEndDate = now()->addDays($validated['newDays']);
    $landArea->tax_end_time = $newEndDate;
    $landArea->save();

    return response()->json([
        'success' => true,
        'message' => 'تم تحديث المدة بنجاح!',
    ]);
}
public function updateShow(Request $request)
{
    $landId = $request->input('land_id');
    $show = $request->input('show');

    $landArea = LandArea::find($landId);
    if ($landArea) {
        // تأكد من أن التغيير يحدث بناءً على start_time وليس before_start_time
        if ($landArea->start_time <= now()) {
            $landArea->show = $show;
            $landArea->save();

            return response()->json(['success' => true, 'message' => 'تم تحديث الحقل show بنجاح']);
        }
    }

    return response()->json(['success' => false, 'message' => 'العنصر غير موجود أو الوقت لم ينتهي بعد']);
}


public function updateBeforeShow(Request $request)
{
    // البحث عن المزاد الذي يكون قبل الوقت الحالي (before_start_time أقل من الآن)
    $currentTimestamp = now();
    $landArea = LandArea::where('before_start_time', '<=', $currentTimestamp)
                        ->where('before_show', 0)
                        ->first();

    if ($landArea) {
        $landArea->before_show = 1;
        $landArea->save();

        return response()->json(['success' => true, 'message' => 'تم التحديث بنجاح.']);
    }

    return response()->json(['success' => false, 'message' => 'لم يتم العثور على المزاد المناسب.']);
}

// في Controller الذي يتعامل مع المزادات

public function updateLandDuration(Request $request)
{
    // التحقق من وجود الـ id و الـ newDays في الطلب
    $request->validate([
        'landId' => 'required|exists:land_areas,id',
        'newDays' => 'required|integer|min:1|max:30',
    ]);

    // العثور على المزاد بناءً على الـ id
    $landArea = LandArea::find($request->landId);

    // تحديث المدة للمزاد
    $landArea->duration = $request->newDays;
    $landArea->save();

    return response()->json([
        'success' => true,
        'message' => 'تم تحديث المدة بنجاح'
    ]);
}
public function updateTax(Request $request)
{
    $landAreaId = $request->input('landAreaId');
    $tax = $request->input('tax');

    // البحث عن الأرض باستخدام الـ ID
    $landArea = LandArea::find($landAreaId);

    if ($landArea) {
        // تحديث قيمة tax إلى 0
        $landArea->tax = $tax;
        $landArea->save();

        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => 'الأرض غير موجودة.']);
    }
}


}

