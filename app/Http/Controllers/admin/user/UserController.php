<?php

namespace App\Http\Controllers\admin\user;

use App\Models\User;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\frontend\parents\Child;


class UserController extends Controller
{
    public function index(){
        $users = User::orderBy('id', 'asc')->get();
        return view('admin.user.index', data: compact('users'));
    }

    public function delete($user_id){
        $user = User::find($user_id);
        $user->delete();
        return redirect()->back()->with('message', 'تم ازالة المستخدم بنجاح');
    }
    public function edit($userId){
        $user = User::find($user_id);
        return view('admin.user.edit', data: compact('user'));
    }
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            Excel::import(new UsersImport, $request->file('excel_file'));
            return redirect()->route('user.page')->with('success', 'تم استيراد الطلاب وحسابات أولياء الأمور بنجاح');
        } catch (\Exception $e) {
            return redirect()->route('user.page')->with('error', 'حدث خطأ أثناء الاستيراد: ' . $e->getMessage());
        }
    }
    public function create()
    {
        return view('admin.user.add_users');
    }
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone',
            'phone_parent', // يجب أن يكون رقم الوالد موجودًا مسبقًا
            'password' => 'required|string|min:8|confirmed',
            'level' => 'required|string|in:admin,user', // التحقق من مستوى المستخدم
            'balance' => 'nullable|numeric|min:0',
        ]);

        try {
            // إنشاء حساب الطالب باستخدام كلمة مرور الطالب
            $studentAccount = User::create([
                'name' => $request->name,
                'phone_parent' => $request->phone_parent,
                'phone' => $request->phone,
                'level' => $request->level, // استخدام المستوى الذي تم اختياره
                'password' => bcrypt($request->password), // كلمة مرور الطالب
                'balance' => $request->balance ?? 3000, // قيمة افتراضية للرصيد
            ]);

            // البحث عن حساب ولي الأمر
            $parentAccount = User::where('phone', $request->phone_parent)->first();

            if (!$parentAccount) {
                // إذا كان ولي الأمر غير موجود، نقوم بإنشاء حساب جديد له
                $parentAccount = User::create([
                    'name' => 'ولي أمر ' . $request->name,  // اسم ولي الأمر سيكون "ولي أمر [اسم الطفل]"
                    'phone' => $request->phone_parent,  // رقم الهاتف
                    'password' => bcrypt($request->password), // نفس كلمة مرور الطفل
                    'level' => 'admin', // يمكن تخصيص مستوى المستخدم لولي الأمر
                ]);
            } else {
                // إذا كان ولي الأمر موجودًا، يمكن تحديث كلمة مروره (اختياري)
                $parentAccount->update([
                    'password' => bcrypt($request->password), // تحديث كلمة مرور ولي الأمر لتكون نفس كلمة مرور الطفل
                ]);
            }

            // تحقق من وجود العلاقة بين الطالب وولي الأمر
            $existingRelationship = Child::where('parent_id', $parentAccount->id)
                ->where('child_id', $studentAccount->id)
                ->first();

            if (!$existingRelationship) {
                // إنشاء العلاقة بين الطالب وولي الأمر
                Child::create([
                    'parent_id' => $parentAccount->id,
                    'child_id' => $studentAccount->id,
                ]);
            }

            return redirect()->route('user.page')->with('success', 'تم إضافة المستخدم وربط العلاقة بنجاح.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function changePassword(Request $request)
{
    // تحقق من صحة البيانات المدخلة
    $request->validate([
        'new_password' => 'required|min:8|confirmed',
    ]);

    // تحديث كلمة المرور
    $user = Auth::user();
    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->back()->with('success', 'تم تغيير كلمة المرور بنجاح');
}
public function changePasswordId(Request $request, $userId)
{
    // تحقق من صحة البيانات المدخلة
    $request->validate([
        'new_password' => 'required|min:8|confirmed',
    ]);

    // العثور على المستخدم باستخدام الـ ID
    $user = User::find($userId);

    if (!$user) {
        return redirect()->back()->with('error', 'المستخدم غير موجود');
    }

    // تحديث كلمة المرور
    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->back()->with('success', 'تم تغيير كلمة المرور بنجاح');
}


}
