@extends('admin.master')
@section('admin_content')
<div class="admin_land_bg">
    <div class="admin_land">
        <div class="admin_land_header">
            <div class="admin_land_btn">
                <button><a href="{{ route('landArea.create') }}">انشيئ ارض اخر </a></button>
            </div>
            <div class="admin_land_header_title">
                <h1>عرض الاراضي</h1>
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
                                        <th>تغيير الوقت الرخصة</th>
                                        <th>اسم المدينة</th>
                                        <th>صك الارض</th>
                                        <th>المساحة</th>
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
                                        <th>تعديل المزاد</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($landAreas as $key => $landArea)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            @if ($landArea->taxD->isNotEmpty())
                                            @foreach ($landArea->taxD as $tax)
                                            <form action="{{ route('tax.update.time', ['id' => $tax->id]) }}" method="put">
                                                @csrf
                                                @method('put')
                                                <div class="btns_land" style="display: grid">
                                                    <input type="number" name="taxDays" value="{{ $tax->taxDays }}" >
                                                    <input type="submit">
                                                </div>
                                            </form>
                                                @endforeach
                                            @else
                                                <p>لا توجد بيانات ضرائب</p>
                                            @endif                                            </form>
                                        </td>
                                        <td>{{ $landArea->land->name }}</td>
                                        <td>{{ $landArea->land_deed }}</td>
                                        <td>{{ $landArea->area }}</td>
                                        <td>{{ $landArea->starting_price }}</td>
                                        <td>{{ $landArea->auction_end_time }}</td>
                                        <td>{{ $landArea->user->name }}</td>
                                        <td>{{ $landArea->final_price }}</td>
                                        <td>{{ $landArea->day }}</td>
                                        <td>{{ $landArea->duration }}</td>
                                        <td>{{ $landArea->highest_bidder_id }}</td>
                                        <td>{{ $landArea->highest_bid }}</td>
                                        <td><img src="{{ asset('storage/' . $landArea->img) }}" alt="صورة الأرض" style="max-width: 200px;">
                                        </td>
                                        <td>{{ $landArea->state }}</td>
                                        <td>
                                            <form action="{{ route('landArea.delete', ['landArea_id' => $landArea->id]) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="delete_button" type="submit" style="border: none; background: none; cursor: pointer;">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <a class="edit_button" href="{{ route('landArea.edit', ['landArea_id' => $landArea->id]) }}"><i class="fa-solid fa-pen-to-square"></i></a>
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
    // إظهار حقل الإدخال عندما يتم الضغط على زر "تغيير الوقت الافتراضي"
    document.querySelectorAll('.changeDurationBtn').forEach(button => {
        button.addEventListener('click', function () {
            const landId = this.getAttribute('data-land-id');
            document.getElementById('daysInputContainer-' + landId).style.display = 'block';
        });
    });

    // حفظ الأيام الجديدة
    document.querySelectorAll('.saveNewDaysButton').forEach(button => {
        button.addEventListener('click', function () {
            const landId = this.getAttribute('data-land-id');
            const newDays = document.getElementById('newDaysInput-' + landId).value;

            if (isNaN(newDays) || newDays <= 0) {
                alert("يرجى إدخال عدد أيام صحيح (1 أو أكثر).");
                return;
            }

            // إرسال التحديث إلى الخادم
            fetch('/update-land-duration', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    landId: landId,
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
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>


@endsection
