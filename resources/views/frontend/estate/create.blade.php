@extends('admin.master')
@section('admin_content')
<div class="admin_land">
    <div class="admin_land_create_container">
        <div class="admin_land_header">
            <div class="admin_land_btn">
                <button><a href="{{ route('landArea.page') }}">رجوع</a></button>
            </div>
            <div class="admin_land_header_title">
                <h1>شيخ العقار</h1>
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
                                    @php
                                    $latestEstate = $estates->last();
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
                                        <input type="text" id="name" name="user_name" value="{{ $landArea->user_id }}" placeholder="المستخدم منشيئ هذا المزاد ..." readonly>
                                        <input type="hidden" name="user_id" value="{{ $landArea->user_id }}">
                                    </td>
                                    <td>
                                        <label for="user_name">: المستخدم منشيئ هذا المزاد</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <input type="submit" value="انشيئ السعر">
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
