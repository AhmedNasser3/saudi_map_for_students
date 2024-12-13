@extends('admin.master')
@section('admin_content')
<div class="admin_land">
    <div class="admin_land_create_container">
        <div class="admin_land_header">
            <div class="admin_land_btn">
                <button><a href="{{ route('user.store') }}">رجوع</a></button>
            </div>
            <div class="admin_land_header_title">
                <h1>انشاء مستخدم</h1>
            </div>
        </div>
        <div class="admin_land_create_data">
            <div class="admin_land_create_content">
                <div class="admin_land_create_body">
                    <div class="form-container">
                        <form action="{{ route('user.store') }}" method="POST">
                            @csrf
                            <table>
                                <tr>
                                    <td>
                                        <input type="text" id="name" name="name" placeholder="ادخل اسم المستخدم هنا ..." value="{{ old('name') }}" required>
                                    </td>
                                    <td>
                                        <label for="name">: الأسم</label>
                                    </td>
                                </tr>
                                @error('name')
                                    <tr><td colspan="2" style="color: red;">{{ $message }}</td></tr>
                                @enderror

                                <tr>
                                    <td>
                                        <input type="text" id="phone" name="phone" placeholder="ادخل رقم الهاتف هنا ..." value="{{ old('phone') }}" required>
                                    </td>
                                    <td>
                                        <label for="phone">: رقم الهاتف</label>
                                    </td>
                                </tr>
                                @error('phone')
                                    <tr><td colspan="2" style="color: red;">{{ $message }}</td></tr>
                                @enderror

                                <tr>
                                    <td>
                                        <input type="password" id="password" name="password" placeholder="ادخل كلمة المرور هنا ..." required>
                                    </td>
                                    <td>
                                        <label for="password">: كلمة المرور</label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="تأكيد كلمة المرور ..." required>
                                    </td>
                                    <td>
                                        <label for="password_confirmation">: تأكيد كلمة المرور</label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="text" id="phone_parent" name="phone_parent" placeholder="ادخل رقم هاتف الوالد هنا ..." value="{{ old('phone_parent') }}" required>
                                    </td>
                                    <td>
                                        <label for="phone_parent">: رقم هاتف الوالد</label>
                                    </td>
                                </tr>
                                @error('phone_parent')
                                    <tr><td colspan="2" style="color: red;">{{ $message }}</td></tr>
                                @enderror

                                <tr>
                                    <td>
                                        <select id="level" name="level" required>
                                            <option value="admin" {{ old('level') == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="user" {{ old('level') == 'user' ? 'selected' : '' }}>User</option>
                                        </select>
                                    </td>
                                    <td>
                                        <label for="level">: المستوى</label>
                                    </td>
                                </tr>

                                @error('level')
                                    <tr><td colspan="2" style="color: red;">{{ $message }}</td></tr>
                                @enderror

                                <tr>
                                    <td colspan="2" style="text-align: center;">
                                        <button type="submit">إنشاء المستخدم</button>
                                    </td>
                                </tr>
                            </table>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
