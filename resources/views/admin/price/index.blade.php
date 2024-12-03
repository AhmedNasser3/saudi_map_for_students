@extends('admin.master')
@section('admin_content')
<div class="admin_land_bg">
<div class="admin_land">
    <div class="admin_land_header">
        <div class="admin_land_btn">
        </div>
        <div class="admin_land_header_title">
            <h1>عرض الاسعار</h1>
        </div>
    </div>
    <div class="admin_land_container">
        <div class="admin_land_data">
            <div class="admin_land_content">
                <div class="container mt-5">
                    @if ($prices && $prices->isEmpty())
                    <form action="{{ route('price.store') }}" method="POST">
                        @csrf
                    <table id="userTable" class="table display nowrap table-striped table-bordered" style="width:100%">
                        <thead class="head_table">
                            <tr>
                                <th>ID</th>
                                <th>سعر الغرامات</th>
                                <th>سعر المهلة</th>
                                <th>سعر ما بعد المزايدة</th>
                                <th>سعر الاستشارة</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><input type="text" name="tax_price" value="0"></td>
                                    <td><input type="text" name="fine_price" value="0"></td>
                                    <td><input type="text" name="bid_price" value="0"></td>
                                    <td><input type="text" name="message_price" value="0"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" style="padding: 10px 20px;border:none;background:#729279;color:white;border-radius:10px;" class="btn btn-primary">إنشاء الأسعار</button>
                </form>
                @else
                @foreach ($prices as $price)
                <form action="{{ route('price.update') }}" method="POST">
                    @csrf
                <table id="userTable" class="table display nowrap table-striped table-bordered" style="width:100%">
                    <thead class="head_table">
                        <tr>
                            <th>ID</th>
                            <th>سعر الغرامات</th>
                            <th>سعر المهلة</th>
                            <th>سعر ما بعد المزايدة</th>
                            <th>سعر الاستشارة</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td>1</td>
                                <td><input type="text" name="tax_price" value="{{ $price->tax_price }}"></td>
                                <td><input type="text" name="fine_price" value="{{ $price->fine_price }}"></td>
                                <td><input type="text" name="bid_price" value="{{ $price->bid_price }}"></td>
                                <td><input type="text" name="message_price" value="{{ $price->message_price }}"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="submit" style="padding: 10px 20px;border:none;background:#729279;color:white;border-radius:10px;" class="btn btn-primary">تحديث الأسعار</button>
            </form>
            @endforeach

                @endif
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
