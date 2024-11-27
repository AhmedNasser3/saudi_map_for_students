<?php

namespace App\Http\Controllers\admin\land;

use Illuminate\Http\Request;
use App\Models\admin\land\Land;
use App\Http\Controllers\Controller;
use App\Models\admin\land\LandArea;

class LandsController extends Controller
{
    public function index()
    {
        $lands = Land::all();
        return view('admin.land.index', compact('lands'));
    }
    public function create(){
        return view('admin.land.create');
    }
    public function store(Request $request){
        $land = $request->validate(['name' => 'required']);
        Land::create($land);
        return redirect()->route('admin.land.index');
    }
    public function edit ($land) {
        return view('admin.land.edit', compact('land'));
    }
    public function update (Request $request,Land $land){
        $land->update($request->validate(['name' => 'required']));
        return redirect()->route('admin.land.index');
    }

}
