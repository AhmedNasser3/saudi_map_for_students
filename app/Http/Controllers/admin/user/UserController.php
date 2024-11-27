<?php

namespace App\Http\Controllers\admin\user;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Imports\UsersImport;


class UserController extends Controller
{
    public function index(){
        $users = User::orderBy('id', 'asc')->get();
        return view('admin.user.index', data: compact('users'));
    }
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            Excel::import(new UsersImport, $request->file('excel_file'));
            return redirect()->route('user.page')->with('success', 'تم استيراد الطلاب بنجاح');
        } catch (\Exception $e) {
            return redirect()->route('user.page')->with('error', 'حدث خطأ أثناء الاستيراد: ' . $e->getMessage());
        }
    }


}
