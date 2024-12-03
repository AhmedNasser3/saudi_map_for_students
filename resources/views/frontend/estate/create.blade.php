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
                        <form action="{{ route('estate.create.landArea', ['landArea_id' => $landArea->id]) }}" method="POST" enctype="multipart/form-data">
                            @method('post')
                            @csrf
                            <table>
                                <tr>
                                    <td>
                                        <input type="text" name="land_id" value="{{ $landArea->land->id }}" id="" >
                                    </td>
                                    <td>
                                        <label for="land_id">: الأرض</label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input readonly ="number" class="select_land" id="area" name="area" value="{{ $landArea->area }}" placeholder="ادخل المساحة ..." value="{{ old('area') }}" required>
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
                                        @php
                                        $latestEstate = $estates->last(); // جلب أحدث Estate
                                    @endphp

                                    @if($latestEstate)
                                        <input readonly type="number" class="select_land" id="starting_price" name="starting_price" placeholder="اقل سعر للبداية ..." value="{{ $latestEstate->min_price }}" required>
                                    @endif
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
                                        <input type="text" id="name" name="user_name" value="{{ auth()->user()->name }}" placeholder="المستخدم منشيئ هذا المزاد ..." readonly>
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                    </td>
                                    <td>
                                        <label for="user_name">: المستخدم منشيئ هذا المزاد</label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input readonly type="number" class="select_land" value="{{ $landArea->final_price }}" id="final_price" name="final_price" placeholder="السعر النهائي ..." value="{{ old('final_price') }}" required>
                                        @error('final_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                      <label for="final_price">: السعر النهائي</label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="text"value="{{ $landArea->day}}" name="day" id="" readonly>
                                    </td>
                                    <td>
                                        <label for="day">: يوم انتهاء المزاد</label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input readonly type="number" class="select_land" id="duration" name="duration" placeholder="ادخل عدد الايام ..." value="{{ $landArea->duration }}" required>
                                        @error('duration')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <label for="duration">: عدد ايام المزاد</label>
                                    </td>
                                </tr>

                                {{-- <tr>
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
                                </tr> --}}
                                <tr>
                                    <td colspan="2">
                                        <img id="preview" src="" alt="معاينة الصورة" style="max-width: 200px; max-height: 200px; display: none;">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <input type="submit" value="انشيئي الارض">
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
@endsection
