@extends('admin.master')
@section('admin_content')
<div class="admin_land_bg">
<div class="admin_land">
    <div class="admin_land_header">
        <div class="admin_land_btn">
            <button><a href="{{ route('land.create') }}">انشيئ ارض اخري </a></button>
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
                                <th>اسم المدينة</th>
                                <th>ازالة الارض</th>
                                <th>تعديل الارض</th>
                                <th>تقدير سعر البيع</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($landAreas as $key => $landArea)
                            @if ($landArea->show_to_estate == 1)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $landArea->area }}</td>
                                <td>
                                    <form action="{{ route('land.delete', ['land_id' => $landArea->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="delete_button" type="submit" style="border: none; background: none; cursor: pointer;">
                                            <i class="fa-solid fa-trash" ></i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a class="edit_button" href="{{ route('land.edit', ['land_id' => $landArea->id]) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                                </td>
                                <form action="{{ route('estate.store') }}" method="post">
                                    @csrf
                                    @method('post')
                                        <td style="display: grid">
                                            <input name="landArea_id" value="{{ $landArea->id }}" type="number" hidden>
                                            <input name="min_price" type="number" required>

                                        <input style="padding: 5px 5px;" type="submit" value="حفظ" name="" id="">
                                    </td>
                                    </form>
                            </tr>
                            @else

                            @endif
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
