<?php

namespace App\Http\Controllers\admin\land;

use App\Http\Controllers\Controller;
use App\Models\admin\land\Land;
use Illuminate\Http\Request;

class MainLandController extends Controller
{
    public function index(){
        $lands = Land::orderBy('id', 'asc')->get();
        return view('admin.land.index',compact('lands'));
    }
    public function create(){
        return view('admin.land.create');
    }
    public function store(Request $request){
        $landNew = $request->validate([
            'name' => 'required'
        ]);
        Land::create($landNew);
        return redirect()->route('land.page')->with('success', 'تم انشاء الارض بنجاح');
    }
    public function edit($landNew){
        $lands = Land::find($landNew);
        return view('admin.land.edit', compact('lands'));
    }
    public function update(Request $request, $landNew) {
        $lands = Land::find($landNew);
        $landUpdate = $request->validate(['name' => 'required|string|max:255']);
        $lands->update($landUpdate);
        return redirect()->route('land.page')->with('success', 'تم تحديث الارض بنجاح');
    }
    public function delete($landNew){
        $lands = Land::find($landNew);
        $lands->delete();
        return redirect()->route('land.page')->with('success', 'تم ازالة الارض بنجاح');
    }
}
