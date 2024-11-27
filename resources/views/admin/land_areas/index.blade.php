@extends('admin.master')
@section('admin_content')
<div class="admin_land_bg">
    <div class="admin_land">
        <div class="admin_land_header">
            <div class="admin_land_btn">
                <button><a href="{{ route('landArea.create') }}">انشيئ مزاد اخر </a></button>
            </div>
            <div class="admin_land_header_title">
                <h1>عرض المزادات</h1>
            </div>
        </div>
        <div class="admin_land_container">
            <div class="admin_land_data">
                <div class="admin_land_content">
                    <div class="container mt-5">
                        <form action="{{ route('landArea.deleteSelected') }}" method="POST" id="deleteForm">
                            @csrf
                            <button type="submit" class="delete_btn_header" id="deleteSelectedButton" disabled >حذف المزادات المحددة</button>
                            <table id="userTable" class="table display nowrap table-striped table-bordered" style="width:100%">
                                <thead class="head_table">
                                    <tr>
                                        <th>ID</th>
                                        <th>اسم المدينة</th>
                                        <th>السماحة</th>
                                        <th>السعر يبدأ من</th>
                                        <th>انتهاء المزاد في</th>
                                        <th>منشيئ المزاد</th>
                                        <th>السعر النهائي</th>
                                        <th>يوم الانتهاء</th>
                                        <th>مدة المزاد</th>
                                        <th>رابح المزاد</th>
                                        <th>سعر الرابح</th>
                                        <th>صورة المزاد</th>
                                        <th>حالة المزاد</th>
                                        <th>ازالة المزاد</th>
                                        <th><input type="checkbox" id="selectAll"> تحديد الكل</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($landAreas as $key => $landArea)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $landArea->land_id }}</td>
                                        <td>{{ $landArea->area }}</td>
                                        <td>{{ $landArea->starting_price }}</td>
                                        <td>{{ $landArea->auction_end_time }}</td>
                                        <td>{{ $landArea->user_id }}</td>
                                        <td>{{ $landArea->final_price }}</td>
                                        <td>{{ $landArea->day }}</td>
                                        <td>{{ $landArea->duration }}</td>
                                        <td>{{ $landArea->highest_bidder_id }}</td>
                                        <td>{{ $landArea->highest_bid }}</td>
                                        <td><img src="{{ asset('storage/' . $landArea->img) }}" alt="صورة الأرض"></td>
                                        <td>{{ $landArea->state }}</td>
                                        <td><div class="office_duration_control">
                                            <label for="renew-days-{{ $landArea->id }}">أدخل عدد الأيام:</label>
                                            <input type="number" id="renew-days-{{ $landArea->id }}" min="1" max="30" value="7" style="width: 60px;">
                                            <button class="set-duration" data-land-area-id="{{ $landArea->id }}" style="background-color: blue;">
                                                تحديث المدة
                                            </button>
                                        </div>
                                        </td>
                                        <td><input type="checkbox" class="selectLand" name="selected[]" value="{{ $landArea->id }}"></td>
                                        <td>
                                            <form action="{{ route('landArea.delete', ['landArea_id' => $landArea->id]) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="delete_button" type="submit" style="border: none; background: none; cursor: pointer;">
                                                    <i class="fa-solid fa-trash" ></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        // Enable/Disable the "Delete Selected" button based on checkboxes
        document.querySelectorAll('.selectLand').forEach((checkbox) => {
            checkbox.addEventListener('change', () => {
                const anyChecked = document.querySelectorAll('.selectLand:checked').length > 0;
                document.getElementById('deleteSelectedButton').disabled = !anyChecked;
            });
        });

        // Select or deselect all checkboxes
        document.getElementById('selectAll').addEventListener('change', (event) => {
            const isChecked = event.target.checked;
            document.querySelectorAll('.selectLand').forEach((checkbox) => {
                checkbox.checked = isChecked;
            });
            document.getElementById('deleteSelectedButton').disabled = !isChecked;
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    // إضافة معالج لزر التحكم في المدة
    document.querySelectorAll('.set-duration').forEach(button => {
        button.addEventListener('click', function () {
            let landAreaId = this.getAttribute('data-land-area-id');
            let inputField = document.getElementById(`renew-days-${landAreaId}`);
            let newDays = parseInt(inputField.value);

            if (isNaN(newDays) || newDays <= 0) {
                alert("يرجى إدخال عدد أيام صحيح (1 أو أكثر).");
                return;
            }

            fetch('/set-renew-days', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    landAreaId: landAreaId,
                    newDays: newDays
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`تم تحديث المدة إلى ${newDays} أيام بنجاح!`);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});

    </script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
@endsection
