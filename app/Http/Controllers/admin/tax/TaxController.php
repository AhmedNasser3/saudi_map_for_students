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
// تمديد مدة الرخصة
public function extendTaxTime(Request $request)
{
    try {
        $landAreaId = $request->landAreaId;
        $newEndTime = $request->newEndTime;
        $selectedDays = $request->addedDays; // الأيام التي تم إضافتها من الواجهة الأمامية

        $landArea = LandArea::find($landAreaId);
        if (!$landArea) {
            return response()->json(['success' => false, 'message' => 'المنطقة الأرضية غير موجودة']);
        }

        // تمديد الوقت بناءً على الأيام المختارة
        $currentEndTime = Carbon::parse($landArea->tax_end_time);
        $newEndTime = $currentEndTime->addDays($selectedDays); // إضافة الأيام المختارة

        $landArea->tax_end_time = $newEndTime;
        $landArea->tax = 0; // تحديث tax إلى 0 بعد الدفع
        $landArea->save();

        \Log::info('تم تمديد وقت الضريبة بنجاح', ['land_area_id' => $landAreaId, 'new_end_time' => $newEndTime]);

        return response()->json(['success' => true, 'message' => 'تم تمديد الرخصة بنجاح!']);
    } catch (\Exception $e) {
        \Log::error("خطأ أثناء تمديد وقت الضريبة: " . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء التمديد: ' . $e->getMessage()]);
    }
}


// تحديث قيمة tax إلى 0 بعد انتهاء الوقت
public function updateTaxStatus(Request $request)
{
    $validated = $request->validate([
        'landAreaId' => 'required|string|exists:taxes,landArea_id',
        'taxStatus' => 'required|integer|in:0', // فقط 0 مسموح
    ]);

    $tax = Tax::where('landArea_id', $validated['landAreaId'])->first();

    if ($tax) {
        // تحديث قيمة tax إلى 0
        $tax->tax = $validated['taxStatus'];
        $tax->save();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'error' => 'المنطقة غير موجودة']);
}

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
