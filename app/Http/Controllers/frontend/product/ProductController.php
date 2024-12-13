<?php

namespace App\Http\Controllers\frontend\product;

use App\Models\Product;
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
    public function edit($productId)
    {
        // جلب المنتج باستخدام ID
        $product = ExpandArea::findOrFail($productId);

        // إرجاع العرض مع بيانات المنتج
        return view('admin.expandArea.edit', compact('product'));
    }


    public function update(Request $request, $productId)
    {
        // جلب المنتج باستخدام ID
        $product = ExpandArea::findOrFail($productId);

        // التحقق من المدخلات وتحديث البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'number_products' => 'required|integer',
            'area' => 'required|string',
            'state' => 'required|integer',
            'bonus_area_price' => 'required|numeric',
        ]);

        // تحديث البيانات
        $product->update([
            'name' => $request->name,
            'number_products' => $request->number_products,
            'area' => $request->area,
            'state' => $request->state,
            'bonus_area_price' => $request->bonus_area_price,
        ]);

        // إرجاع إلى الصفحة السابقة أو أي صفحة أخرى مع رسالة نجاح
        return redirect()->route('admin.view.product')->with('success', 'تم تحديث المنتج بنجاح');
    }

    public function delete($id){
        $product = ExpandArea::findOrFail($id);
        $product->delete();
        return redirect()->back();
    }

    public function AdminStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'number_products' => 'required|integer|min:1',
            'bonus_area_price' => 'required|integer|min:1',
            'area' => 'required|numeric|min:0',
            'state' => 'required|string|max:255',
        ]);

        ExpandArea::create($data);

        return redirect()->route('admin.view.product')->with('success', 'تم إضافة زيادة مساحة الأرض بنجاح.');
    }


}
