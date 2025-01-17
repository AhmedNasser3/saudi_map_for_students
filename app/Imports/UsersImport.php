<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\frontend\parents\Child;
use App\Models\admin\addition\Addition;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // تحقق إذا كان الحقل id موجودًا في الملف
        if (!empty($row['id'])) {
            $user = User::find($row['id']); // ابحث عن المستخدم بناءً على id
            if ($user) {
                // إذا كان هناك مبلغ (balance) في الملف، قم بإضافته إلى الرصيد الحالي
                if (!empty($row['balance']) && is_numeric($row['balance'])) {
                    $additionAmount = $row['balance']; // المبلغ الجديد
                    $newBalance = $user->balance + $additionAmount; // الرصيد الجديد

                    // تحديث الرصيد في جدول users
                    $user->update([
                        'balance' => $newBalance,
                    ]);

                    // تسجيل العملية في جدول additions
                    Addition::create([
                        'user_id' => $user->id,
                        'addition' => $additionAmount, // المبلغ المضاف
                        'title' => $row['title'] ?? 'No Title Provided', // السبب
                    ]);
                }

                // قم بتحديث باقي التفاصيل (بدون تعديل الرصيد)
                $user->update([
                    'name' => $row['name'] ?? $user->name,
                    'phone' => $row['phone'] ?? $user->phone,
                    'level' => $row['level'] ?? $user->level,
                    'password' => !empty($row['password']) ? Hash::make($row['password']) : $user->password,
                ]);

                return null; // العودة وعدم إنشاء سجل جديد
            }
        }

        // في حالة عدم وجود id أو عدم العثور على المستخدم
        if (empty($row['phone']) || empty($row['phone_parent'])) {
            return null; // تخطي الصف إذا كانت الحقول فارغة
        }

        // إنشاء حساب الطالب
        $studentAccount = User::create([
            'name' => $row['name'],
            'phone' => (string)$row['phone'],
            'level' => $row['level'],
            'password' => Hash::make($row['password']),
            'balance' => 0, // اترك الرصيد صفرًا عند الإنشاء
        ]);

        // تحقق إذا كان رقم ولي الأمر موجودًا مسبقًا
        $parentAccount = User::firstOrCreate(
            ['phone' => (string)$row['phone_parent']],
            [
                'name' => $row['name'] . ' - ولي الأمر',
                'level' => $row['level'],
                'password' => Hash::make($row['password']),
                'balance' => 0,
            ]
        );

        // تحديث اسم ولي الأمر ليشمل أسماء الطلاب
        $relatedChildren = Child::where('parent_id', $parentAccount->id)
            ->with('child')
            ->get();

        $childNames = $relatedChildren->map(fn($relation) => $relation->child->name)->toArray();
        $childNames[] = $studentAccount->name;
        $parentAccount->update([
            'name' => implode(', ', $childNames) . ' - ولي الأمر',
        ]);

        // تحقق من وجود العلاقة في جدول children لتجنب التكرار
        $existingChildRelationship = Child::where('parent_id', $parentAccount->id)
            ->where('child_id', $studentAccount->id)
            ->first();

        if (!$existingChildRelationship) {
            Child::create([
                'parent_id' => $parentAccount->id,
                'child_id' => $studentAccount->id,
            ]);
        }

        return $studentAccount;
    }
}
