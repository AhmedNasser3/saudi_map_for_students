<?php

namespace App\Http\Controllers\admin\price;

use Illuminate\Http\Request;
use App\Models\admin\price\Price;
use App\Http\Controllers\Controller;

class PriceController extends Controller
{
    public function index(){
        $prices = Price::all();
        return view('admin.price.index', compact('prices'));
    }
    public function store(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $data = $request->validate([
            'tax_price' => 'required',
            'fine_price' => 'required',
            'bid_price' => 'required',
            'message_price' => 'required',
        ]);

        // إنشاء سجل جديد في قاعدة البيانات
        Price::create($data);

        // إعادة التوجيه مع إشعار النجاح
        return redirect()->back()->with('success', 'تم إنشاء الأسعار بنجاح!');
    }

    public function update(Request $request)
    {
        // التحقق من صحة البيانات
        $data = $request->validate([
            'tax_price' => 'required|numeric',
            'fine_price' => 'required|numeric',
            'bid_price' => 'required|numeric',
            'message_price' => 'required|numeric',
        ]);

        // البحث عن السعر الذي تريد تحديثه (على سبيل المثال أول سجل)
        $price = Price::first(); // إذا كنت تريد تحديث أول سجل فقط. يمكنك تخصيص البحث إذا كان هناك أكثر من سجل

        // إذا كنت ترغب في تحديث كل السجلات، يمكنك استخدام Price::all() ومن ثم التكرار على السجلات

        if ($price) {
            // تحديث السجل
            $price->update($data);

            // إعادة التوجيه للصفحة السابقة مع إشعار النجاح
            return redirect()->back()->with('success', 'تم تحديث الأسعار بنجاح!');
        }

        // في حال عدم العثور على سجل
        return redirect()->back()->with('error', 'لم يتم العثور على البيانات!');
    }

}
