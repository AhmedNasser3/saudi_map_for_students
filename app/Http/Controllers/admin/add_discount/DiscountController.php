<?php

namespace App\Http\Controllers\admin\add_discount;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\admin\addition\Addition;
use App\Models\admin\discount\Discount;

class DiscountController extends Controller
{
    public function minusBalance(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'discount' => 'required|numeric|min:0',
            'title' => 'required|string|max:255',
        ]);

        // استرجاع بيانات المستخدم
        $user = User::find($request->user_id);

        // التأكد من أن الرصيد كافٍ للسحب
        if ($user->balance < $request->discount) {
            return response()->json(['error' => 'الرصيد غير كافٍ للسحب']);
        }

        // خصم الرصيد من المستخدم
        $user->balance -= $request->discount;
        $user->save();

        // إنشاء سجل جديد مع سبب الخصم
        Discount::create([
            'user_id' => $user->id,
            'discount' => $request->discount,
            'title' => $request->title,
        ]);

        return response()->json(['success' => 'تم خصم الرصيد بنجاح']);
    }


}
