@extends('admin.master')
@section('admin_content')
<div class="admin_land_bg">
<div class="admin_land">
    <div class="admin_land_header">
        <div class="admin_land_btn">
        </div>
        <div class="admin_land_header_title">
            <h1 style="color: rgb(73, 119, 94);">شيخ العقار</h1>
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
                                <th>مساحة الارض</th>
                                <th>السعر الذي اشترا به الطالب الارض</th>
                                <th>السعر الذي يجب ان لا يقل عنه بيع هذه الارض</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($landAreas as $key => $landArea)
                            @if ($landArea->show_to_estate == 1)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $landArea->area }}</td>
                                <td>{{ $landArea->highest_bid }}</td>


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
                            @elseif($landArea->show_to_estate == 4)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $landArea->area }}</td>
                                <td>{{ $landArea->highest_bid }}</td>
                                <td>
                                    <button style="padding: 5px 10px;background-color: #6aa181; border:none;border-radius:5px;"><a href="{{ route('estate.create', ['landArea_id' => $landArea->id]) }}" style="color: white">لقد قبل صاحب الارض البيع</a></button>
                                </td>
                            </tr>
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
