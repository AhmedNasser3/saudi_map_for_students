@extends('admin.master')
@section('admin_content')
<div class="admin_land">
    <div class="admin_land_create_container">
        <div class="admin_land_header">
            <div class="admin_land_btn">
                <button><a href="{{ route('landArea.page') }}">رجوع</a></button>
            </div>
            <div class="admin_land_header_title">
                <h1>انشاء مزاد</h1>
            </div>
        </div>
        <div class="admin_land_create_data">
            <div class="admin_land_create_content">
                <div class="admin_land_create_body">
                    <div class="form-container">
                        <form action="{{ route('landArea.store') }}" method="POST" enctype="multipart/form-data">
                            @method('post')
                            @csrf
                            <table>
                                <tr>
                                    <td>
                                        <select id="land_id" name="land_id" class="select_land" required>
                                            <option value="" disabled selected>اختر الأرض...</option>
                                            @foreach($landAreas as $land)
                                                <option value="{{ $land->id }}">{{ $land->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('land_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <label for="land_id">: الأرض</label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="number" class="select_land" id="area" name="area" placeholder="ادخل المساحة ..." value="{{ old('area') }}" required>
                                        @error('area')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                      <label for="area">: المساحة</label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="number" class="select_land" id="starting_price" name="starting_price" placeholder="اقل سعر للبداية ..." value="{{ old('starting_price') }}" required>
                                        @error('starting_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <label for="starting_price">: اقل سعر للبداية</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="datetime-local" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                                        @error('start_time')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <label for="start_time">: وقت بداية المزاد</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="datetime-local" id="auction_end_time" name="auction_end_time" value="{{ old('auction_end_time') }}" required>
                                        @error('auction_end_time')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <label for="auction_end_time">: وقت انتهاء المزاد</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="datetime-local" id="go_time" name="go_time" value="{{ old('go_time') }}" required>
                                        @error('go_time')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <label for="auction_end_time">: وقت عرض متي سيبدأ المزاد</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="datetime-local" id="stop_time" name="stop_time" value="{{ old('stop_time') }}" required>
                                        @error('stop_time')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <label for="auction_end_time">: وقت اختفاء المزاد من الصفحة</label>
                                    </td>
                                </tr>


                                <tr>
                                    <td>
                                        <input type="text" id="name" name="user_name" value="{{ auth()->user()->name }}" placeholder="المستخدم منشيئ هذا المزاد ..." readonly>
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                    </td>
                                    <td>
                                        <label for="user_name">: المستخدم منشيئ هذا المزاد</label>
                                    </td>
                                </tr>



                                <tr>
                                    <td>
                                        <input type="number" hidden value="vaue" class="select_land" id="duration" name="duration" placeholder="ادخل عدد الايام ..." value="{{ old('duration') }}" >
                                        @error('duration')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <label for="duration" hidden >: عدد ايام المزاد</label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input class="land_img_input" type="file" id="img" name="img" accept="image/*" onchange="previewImage(event)">
                                        <label for="img" class="custom-file-upload">اختر صورة</label>
                                        @error('img')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <label for="img">: اختر صورة</label>
                                    </td>
                                </tr>

                                <!-- حقل المعاينة -->
                                <tr>
                                    <td colspan="2">
                                        <img id="img-preview" style="max-width: 200px; margin-top: 10px; display: none;" alt="صورة المعاينة">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <img id="preview" src="" alt="معاينة الصورة" style="max-width: 200px; max-height: 200px; display: none;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="number" hidden class="select_land" id="number_of_auctions" name="number_of_auctions" placeholder="عدد المزادات" value="{{ old('number_of_auctions', 1) }}" required min="1">
                                        @error('number_of_auctions')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td hidden>
                                        <label for="number_of_auctions" hidden>: عدد المزادات</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <input type="submit" value="انشيئ الارض">
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
<script>
    function previewImage(event) {
        // الحصول على العنصر الذي يحتوي على الصورة
        var reader = new FileReader();
        var preview = document.getElementById('img-preview');

        // عندما يتم تحميل الملف
        reader.onload = function() {
            // تحديث المصدر في العنصر <img>
            preview.src = reader.result;
            preview.style.display = 'block'; // إظهار الصورة
        };

        // قراءة الملف
        reader.readAsDataURL(event.target.files[0]);
    }

</script>
@endsection
