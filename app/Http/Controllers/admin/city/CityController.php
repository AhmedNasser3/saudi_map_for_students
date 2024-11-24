<?php

namespace App\Http\Controllers\admin\city;

use App\Models\City;
use App\Models\CityArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with('areas')->get();
        return view('admin.cities.index', compact('cities'));
    }

    // إضافة مدينة جديدة
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:cities']);
        City::create(['name' => $request->name]);
        return redirect()->back()->with('success', 'تم إضافة المدينة بنجاح!');
    }

    // إضافة مساحة لمدينة
    public function addArea(Request $request, $cityId)
    {
        $request->validate(['meters' => 'required|integer']);
        CityArea::create(['city_id' => $cityId, 'meters' => $request->meters]);
        return redirect()->back()->with('success', 'تمت إضافة المساحة بنجاح!');
    }
}
