@extends('admin.master')

@section('admin_content')
<div class="admin_land_bg">
    <div class="admin_land">
        <div class="admin_land_header">
            <div class="admin_land_btn">
                <button><a href="{{ route('user.page') }}">رجوع إلى صفحة المستخدمين</a></button>
            </div>
            <div class="admin_land_header_title">
                <h1>تعديل بيانات المستخدم</h1>
            </div>
        </div>
        <div class="admin_land_container">
            <div class="admin_land_data">
                <div class="admin_land_content">
                    <div class="container mt-5">
                        <form action="{{ route('user.update', ['userId' => $user->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">اسم المستخدم</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">رقم الهاتف</label>
                                <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="level" class="form-label">المستوى</label>
                                <select class="form-control" name="level" id="level" required>
                                    <option value="admin" {{ $user->level == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="user" {{ $user->level == 'user' ? 'selected' : '' }}>User</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="balance" class="form-label">الرصيد</label>
                                <input type="number" class="form-control" name="balance" id="balance" value="{{ old('balance', $user->balance) }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">تحديث البيانات</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
