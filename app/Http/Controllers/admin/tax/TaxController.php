<?php

namespace App\Http\Controllers\admin\tax;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\admin\tax\Tax;
use App\Models\admin\land\LandArea;
use App\Http\Controllers\Controller;

class TaxController extends Controller
{
    public function getTaxInfo(Request $request)
{
    $landAreaId = $request->input('land_area_id');

    // جلب بيانات الضرائب حسب land_area_id
    $tax = Tax::where('landArea_id', $landAreaId)->first();

    if ($tax) {
        return response()->json([
            'taxDays' => $tax->taxDays,
        ]);
    } else {
        return response()->json([
            'success' => false,
            'error' => 'لا توجد بيانات للضريبة لهذه المنطقة',
        ]);
    }
}

// تحديث قيمة tax إلى 0 بعد انتهاء الوقت


public function update(Request $request, $id)
{
    $validated = $request->validate([
        'taxDays' => 'required|integer|min:1',
    ]);

    $tax = Tax::findOrFail($id);

    $tax->update([
        'taxDays' => $validated['taxDays'],
    ]);

    return redirect()->back()->with('success', 'تم تحديث عدد الأيام بنجاح!');
}
}
