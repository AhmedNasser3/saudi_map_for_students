<?php

namespace App\Http\Controllers\admin\landarea;

use Illuminate\Http\Request;
use App\Models\admin\land\Land;
use App\Models\admin\land\LandArea;
use App\Http\Controllers\Controller;

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
            LandArea::create($landAreaData);
        }

        return redirect()->route('landArea.page')->with('success', 'تم إنشاء المزادات بنجاح');
    }

    public function edit(Request $request, LandArea $landArea){

    }
    public function update(){}
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
            $landArea->show = $show;
            $landArea->save();

            return response()->json(['success' => true, 'message' => 'تم تحديث الحقل show بنجاح']);
        }

        return response()->json(['success' => false, 'message' => 'العنصر غير موجود']);
    }
}
