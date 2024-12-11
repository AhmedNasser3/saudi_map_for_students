<?php

namespace App\Imports;

use App\Models\User;
use App\Models\frontend\parents\Child;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // تحقق من صحة البيانات
        if (empty($row['phone']) || empty($row['phone_parent'])) {
            return null; // تخطي الصف إذا كانت الحقول فارغة
        }

        // إنشاء حساب الطالب
        $studentAccount = User::create([
            'name' => $row['name'],
            'phone' => $row['phone'],
            'level' => $row['level'],
            'password' => Hash::make($row['password']),
            'balance' => is_numeric($row['balance']) ? $row['balance'] : 3000,
        ]);

        // تحقق إذا كان رقم ولي الأمر موجودًا مسبقًا
        $parentAccount = User::firstOrCreate(
            ['phone' => $row['phone_parent']], // تحقق من وجود الرقم
            [
                'name' => $row['name'] . ' - ولي الأمر', // اسم ولي الأمر مبدئيًا
                'level' => $row['level'],
                'password' => Hash::make($row['password']),
                'balance' => is_numeric($row['balance']) ? $row['balance'] : 3000,
            ]
        );

        // تحديث اسم ولي الأمر ليشمل أسماء الطلاب
        $relatedChildren = Child::where('parent_id', $parentAccount->id)
            ->with('child')
            ->get();

        $childNames = $relatedChildren->map(fn($relation) => $relation->child->name)->toArray();
        $childNames[] = $studentAccount->name; // إضافة اسم الطالب الحالي
        $parentAccount->update([
            'name' => implode(', ', $childNames) . ' - ولي الأمر', // تحديث الاسم
        ]);

        // تحقق من وجود العلاقة في جدول children لتجنب التكرار
        $existingChildRelationship = Child::where('parent_id', $parentAccount->id)
            ->where('child_id', $studentAccount->id)
            ->first();

        if (!$existingChildRelationship) {
            // إضافة العلاقة بين الطالب وولي الأمر
            Child::create([
                'parent_id' => $parentAccount->id,
                'child_id' => $studentAccount->id,
            ]);
        }

        return $studentAccount; // إرجاع حساب الطالب
    }
}
