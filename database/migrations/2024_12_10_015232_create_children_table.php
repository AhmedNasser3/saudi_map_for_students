<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\frontend\parents\Child;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // تحقق من صحة البيانات
        if (empty($row['phone']) || empty($row['phone_parent'])) {
            return null; // تخطي الصف إذا كان الحقلان فارغين
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
                'name' => $row['name'] . ' - ولي الأمر',
                'level' => $row['level'],
                'password' => Hash::make($row['password']),
                'balance' => is_numeric($row['balance']) ? $row['balance'] : 3000,
            ]
        );

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
