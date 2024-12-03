<?php

namespace App\Http\Controllers\admin\delay;

use App\Http\Controllers\Controller;
use App\Models\admin\delay\Delay;
use Illuminate\Http\Request;

class DelayController extends Controller
{
    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'delayDays' => 'required|integer|min:1',
    ]);

    $delay = Delay::findOrFail($id);

    $delay->update([
        'delayDays' => $validated['delayDays'],
    ]);

    return redirect()->back()->with('success', 'تم تحديث عدد الأيام بنجاح!');
}
}
