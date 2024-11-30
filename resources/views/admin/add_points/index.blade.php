@extends('admin.master')
@section('admin_content')
<div class="admin_land_bg">
<div class="admin_land">
    <div class="admin_land_header">
        <div class="admin_land_header_title">
            <h1>عرض المستخدمين</h1>
        </div>
    </div>
    <div class="admin_land_container">
        <div class="admin_land_data">
            <div class="admin_land_content">
                <div class="container mt-5">
                    <table id="userTable" class="table display nowrap table-striped table-bordered" style="width:100%">
                        <thead class="head_table">
                            <tr>
                                <th>ID</th>
                                <th>اسم المستخدم</th>
                                <th>إضافة رصيد</th>
                                <th>سبب الإضافة</th>
                                <th>خصم رصيد</th>
                                <th>سبب الخصم</th>
                                <th>تنفيذ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userAdditions as $key => $user)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
                                    <input type="number" id="addition_{{ $user->id }}" placeholder="أضف الرصيد" class="form-control">
                                </td>
                                <td>
                                    <input style="width: 250px" type="text" id="title_add_{{ $user->id }}" placeholder="أضف سبب الإضافة" class="form-control">
                                </td>
                                <td>
                                    <input type="number" id="discount_{{ $user->id }}" placeholder="خصم الرصيد" class="form-control">
                                </td>
                                <td>
                                    <input style="width: 250px" type="text" id="title_discount_{{ $user->id }}" placeholder="أضف سبب الخصم" class="form-control">
                                </td>
                                <td>
                                    <button class="btn btn-primary" onclick="addBalance({{ $user->id }})">إضافة رصيد</button>
                                    <button class="btn btn-danger" onclick="minusBalance({{ $user->id }})">خصم رصيد</button>
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
    // إضافة رصيد
    function addBalance(userId) {
    const addition = document.getElementById(`addition_${userId}`).value;
    const title = document.getElementById(`title_add_${userId}`).value;

    if (!addition || !title) {
        alert("يرجى ملء جميع الحقول.");
        return;
    }

    // إرسال الطلب لإضافة الرصيد
    $.ajax({
        url: '{{ route('add_balance') }}',
        type: 'POST',
        data: {
            user_id: userId,
            addition: addition,
            title: title,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            alert('تم إضافة الرصيد بنجاح');
            location.reload(); // إعادة تحميل الصفحة بعد إضافة الرصيد
        },
        error: function(xhr) {
            alert('حدث خطأ أثناء إضافة الرصيد.');
        }
    });
}


    // خصم رصيد
    function minusBalance(userId) {
    const discount = document.getElementById(`discount_${userId}`).value;
    const title = document.getElementById(`title_discount_${userId}`).value;

    if (!discount || !title) {
        alert("يرجى ملء جميع الحقول.");
        return;
    }

    // إرسال الطلب لخصم الرصيد
    $.ajax({
        url: '{{ route('minus_balance') }}',
        type: 'POST',
        data: {
            user_id: userId,
            discount: discount,
            title: title,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                alert(response.success);  // عرض رسالة النجاح
                location.reload(); // إعادة تحميل الصفحة بعد خصم الرصيد
            } else {
                alert('حدث خطأ غير متوقع');
            }
        },
        error: function(xhr, status, error) {
            // عرض الخطأ بشكل واضح
            const errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'حدث خطأ أثناء خصم الرصيد.';
            alert(errorMessage);  // عرض رسالة الخطأ
        }
    });
}


    // تهيئة جدول البيانات
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
