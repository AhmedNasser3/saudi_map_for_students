@extends('admin.master')
@section('admin_content')
<div class="admin_land_bg">
    <div class="admin_land">
        <div class="admin_land_header">
            <div class="admin_land_btn">
                <button><a href="{{ route('user.create') }}">انشيئ طالب اخري </a></button>
            </div>
            <div class="admin_land_header_title">
                <h1>عرض الطلاب</h1>
            </div>
        </div>
        <div class="admin_land_container">
            <div class="admin_land_data">
                <div class="admin_land_content">
                    <div class="container mt-5">
                        {{-- زر رفع ملف Excel --}}
                        <form action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="excelFile" class="form-label">رفع ملف Excel</label>
                                <input type="file" name="excel_file" id="excelFile" class="form-control" accept=".xls,.xlsx" required>
                                <label for="excelFile" class="btn-choose-file">اختر الملف</label>

                            </div>
                            <button type="submit" class="btn-upload">رفع الملف</button>
                        </form>


                        <table id="userTable" class="table display nowrap table-striped table-bordered" style="width:100%">
                            <thead class="head_table">
                                <tr>
                                    <th>ID</th>
                                    <th>اسم المستخدم</th>
                                    <th>رقم الطالب</th>
                                    <th>المرحلة</th>
                                    <th>الرصيد</th>
                                    <th>كود الطالب</th>
                                    <th>تغيير باسوورد الطالب الي</th>
                                    <th>ازالة الطالب</th>
                                    <th>تعديل المستخدم</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->level }}</td>
                                    <td>{{ $user->balance }}</td>
                                    <td>{{ $user->unique_number }}</td>
                                    <td>
                                        <form action="{{ route('user.update-passwordId', ['userId' => $user->id]) }}" method="post" style="display: inline;">
                                            @csrf
                                            <div class="form-group">
                                                <label class="group_label" for="new_password">كلمة المرور الجديدة</label><br>
                                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="new_password_confirmation">تأكيد كلمة المرور الجديدة</label><br>
                                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                            </div>
                                            <button type="submit" class="btn_gr">تغيير كلمة المرور</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('user.delete', ['user_id' => $user->id]) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="delete_button" type="submit" style="border: none; background: none; cursor: pointer;">
                                                <i class="fa-solid fa-trash" ></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <a class="edit_button" href="{{ route('user.edit', [ 'userId'=> $user->id]) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
       $('#userTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> استخراج بصيغة CSV',
                className: 'custom-csv'
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> استخراج بصيغة Excel',
                className: 'custom-excel'
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> استخراج بصيغة PDF',
                className: 'custom-pdf'
            }
        ],
        responsive: true,
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        language: {
            search: "Search:",
            paginate: {
                previous: "Prev",
                next: "Next"
            }
        }
    });
    </script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
@endsection
