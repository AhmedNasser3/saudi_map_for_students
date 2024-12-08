<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new User([
            'name' => $row['name'],                 // عمود الاسم
            'phone' => $row['phone'],                 // عمود الاسم
            'level' => $row['level'],               // عمود البريد الإلكتروني
            'password' => Hash::make($row['password']), // عمود كلمة المرور
            'balance' => is_numeric($row['balance']) ? $row['balance'] : 3000, // التحقق من أن الرصيد رقم
        ]);
    }
}
