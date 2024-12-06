<?php

namespace App\Http\Controllers\frontend\product;

use Illuminate\Http\Request;
use App\Models\admin\land\LandArea;
use App\Http\Controllers\Controller;
use App\Models\frontend\expand\BuyArea;
use App\Models\frontend\expandArea\ExpandArea;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'landArea_id' => 'required|exists:land_areas,id',
            'bonus_area' => 'required|numeric|min:0',
        ]);

        $user = auth()->user();
        $landArea = LandArea::find($data['landArea_id']);
        $bonusAreaPrice = $request->input('bonus_area_price');

        if (!$landArea) {
            return redirect()->back()->with('error', 'لا يوجد أرض بهذا الاسم.');
        }

        if ($user->balance < $bonusAreaPrice) {
            return redirect()->back()->with('error', 'رصيدك غير كافٍ لإتمام العملية.');
        }

        if ($request->input('state') == 1) {
            $user->balance -= $bonusAreaPrice;
        } else {
            $user->balance -= $bonusAreaPrice;
        }

        $user->save();

        if ($request->input('state') == 1) {
            $landArea->area += $data['bonus_area'];
            $landArea->save();
        } else {
            $landArea->area *= $data['bonus_area'];
            $landArea->save();
        }
        BuyArea::create($data);

        return redirect()->back()->with('success', 'قمت بشراء زيادة مساحة الأرض بنجاح!');
    }

    public function adminView(){
        $products = ExpandArea::all();
        return view('admin.expandArea.index', compact('products'));
    }

    public function create(){
        return view('admin.expandArea.create');
    }

    public function AdminStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'number_products' => 'required|integer|min:1',
            'area' => 'required|numeric|min:0',
            'state' => 'required|string|max:255',
        ]);

        ExpandArea::create($data);

        return redirect()->route('admin.view.product')->with('success', 'تم إضافة زيادة مساحة الأرض بنجاح.');
    }


}
