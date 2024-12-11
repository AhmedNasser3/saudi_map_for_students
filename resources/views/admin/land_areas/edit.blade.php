@extends('admin.master')

@section('admin_content')
<div class="admin_land">
    <div class="admin_land_create_container">
        <div class="admin_land_header">
            <div class="admin_land_btn">
                <button><a href="{{ route('landArea.page') }}">رجوع</a></button>
            </div>
            <div class="admin_land_header_title">
                <h1>تعديل مزاد</h1>
            </div>
        </div>
        <div class="admin_land_create_data">
            <div class="admin_land_create_content">
                <div class="admin_land_create_body">
                    <div class="form-container">
                        <form action="{{ route('landArea.update', ['landArea_id' => $landArea->id]) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <table>
                                <tr>
                                    <td>
                                        <select id="land_id" name="land_id" class="select_land" required>
                                            <option value="{{ $landArea->land_id }}" selected>{{ $landArea->land->name }}</option>
                                            @foreach($landAreas as $land)
                                                <option value="{{ $land->id }}" {{ old('land_id', $landArea->land_id) == $land->id ? 'selected' : '' }}>{{ $land->name }}</option>
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
                                        <input type="number" class="select_land" id="area" name="area" placeholder="ادخل المساحة ..." value="{{ old('area', $landArea->area) }}" required>
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
                                        <input type="number" class="select_land" id="starting_price" name="starting_price" placeholder="اقل سعر للبداية ..." value="{{ old('starting_price', $landArea->starting_price) }}" required>
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
                                        <input type="datetime-local" id="start_time" name="start_time" value="{{ old('start_time', $landArea->start_time) }}" required>
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
                                        <input type="datetime-local" id="auction_end_time" name="auction_end_time" value="{{ old('auction_end_time', $landArea->auction_end_time) }}" required>
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
                                        <input type="number" class="select_land" id="final_price" name="final_price" placeholder="السعر النهائي ..." value="{{ old('final_price', $landArea->final_price) }}" required>
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
                                        <select id="day" name="day" class="select_land" required>
                                            <option value="" disabled>اختر اليوم...</option>
                                            <option value="الأحد" {{ old('day', $landArea->day) == 'الأحد' ? 'selected' : '' }}>الأحد</option>
                                            <option value="الأثنين" {{ old('day', $landArea->day) == 'الأثنين' ? 'selected' : '' }}>الأثنين</option>
                                            <option value="الثلاثاء" {{ old('day', $landArea->day) == 'الثلاثاء' ? 'selected' : '' }}>الثلاثاء</option>
                                            <option value="الأربعاء" {{ old('day', $landArea->day) == 'الأربعاء' ? 'selected' : '' }}>الأربعاء</option>
                                            <option value="الخميس" {{ old('day', $landArea->day) == 'الخميس' ? 'selected' : '' }}>الخميس</option>
                                            <option value="الجمعة" {{ old('day', $landArea->day) == 'الجمعة' ? 'selected' : '' }}>الجمعة</option>
                                            <option value="السبت" {{ old('day', $landArea->day) == 'السبت' ? 'selected' : '' }}>السبت</option>
                                        </select>
                                        @error('day')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <label for="day">: يوم انتهاء المزاد</label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="number" class="select_land" id="duration" name="duration" placeholder="ادخل عدد الايام ..." value="{{ old('duration', $landArea->duration) }}" required>
                                        @error('duration')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <label for="duration">: عدد ايام المزاد</label>
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
                                <tr>
                                    <td colspan="2">
                                        <img id="preview" src="{{ asset('storage/'.$landArea->img) }}" alt="معاينة الصورة" style="max-width: 200px; max-height: 200px;">
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="number" class="select_land" id="number_of_auctions" name="number_of_auctions" placeholder="عدد المزادات" value="{{ old('number_of_auctions', $landArea->number_of_auctions) }}" required min="1">
                                        @error('number_of_auctions')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <label for="number_of_auctions">: عدد المزادات</label>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <input type="submit" value="تحديث المزاد">
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
