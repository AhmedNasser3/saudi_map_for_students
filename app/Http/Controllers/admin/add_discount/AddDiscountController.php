<?php

namespace App\Http\Controllers\admin\add_discount;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\admin\addition\Addition;

class AddDiscountController extends Controller
{
    public function showAdditions()
    {
        $userAdditions =User::all();
        return view('admin.add_points.index',compact('userAdditions'));
    }
    public function minusAdditions()
    {
        $userAdditions =User::all();
        return view('admin.add_points.add',compact('userAdditions'));
    }

    public function addBalance(Request $request)
    {
        $userId = $request->input('user_id');
        $addition = $request->input('addition');
        $title = $request->input('title');

        // التحقق من المدخلات
        if (!$addition || !$title) {
            return response()->json(['error' => 'المدخلات غير كاملة.']);
        }

        // التحقق إذا كان المستخدم موجودًا
        $user = User::find($userId);
        if ($user) {
            // إضافة الرصيد
            $user->balance += $addition;
            $user->save();

            // إضافة سجل جديد
            Addition::create([
                'user_id' => $user->id,
                'addition' => $addition,
                'title' => $title,
            ]);

            return response()->json(['success' => 'تم إضافة الرصيد بنجاح']);
        } else {
            return response()->json(['error' => 'المستخدم غير موجود']);
        }
    }


}
