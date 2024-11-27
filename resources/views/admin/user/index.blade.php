@extends('admin.master')
@section('admin_content')
<div class="admin_land_bg">
    <div class="admin_land">
        <div class="admin_land_header">
            <div class="admin_land_btn">
                <button><a href="{{ route('land.create') }}">انشيئ ارض اخري </a></button>
            </div>
            <div class="admin_land_header_title">
                <h1>عرض الطلاب</h1>
            </div>
        </div>
        <div class="admin_land_container">
            <div class="admin_land_data">
                <div class="admin_land_content">
                    <div class="container mt-5">
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
                                    <th>الايميل</th>
                                    <th>الرصيد</th>
                                    <th>كود الطالب</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->balance }}</td>
                                    <td>{{ $user->unique_number }}</td>
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
