@extends('frontend.master')
@section('content')
 @php
use App\Models\admin\price\Price;
use App\Models\admin\estate\Estate;

$price = Price::first();
@endphp
<div class="office">
    <div class="bid_header">
        <div class="bid_btn">
            <button><a href="#">مشاهدة جميع المنتجات</a></button>
        </div>
        <div class="bid_title">
            <h1>الدرج السري</h1>
        </div>
    </div>
    <div class="bid_body">
        <ul>
            <li class="" id="btn-all" data-filter="all" style="border-bottom: 1px solid #36b927;">
                <a href="#">الدرج السري</a>
            </li>
        </ul>
    </div>
    <div class="office_container" style="display: flex;justify-content: center;flex-wrap: wrap;gap: 1px;">
<div class="office_data" id="content-all" style="display: flex; margin:2% 0 0 0;justify-content: center;">
<div class="products">
    <div class="products_container">
        <div class="products_data">
            <div class="products_content">
                <div class="products_title">
                </div>
                <div class="products_bg_container">
                    @foreach ($bonusAreas as $bonusArea)
                    <form action="{{ route('product.store') }}" method="post">
                        @csrf <!-- إضافة الحماية -->
                        <div class="products_bg">
                            <div class="products_bg_title">
                                <h3>مساحة أرض للبيع</h3>
                                <div class="products_bg_area">
                                    <input type="hidden" name="bonus_area" value="{{ $bonusArea->area }}">
                                    <p>{{ floor($bonusArea->area) }} @if($bonusArea->state == 1 )
                                    كم
                                    @else
                                    %
                                    @endif</p>
                                </div>
                            </div>
                            <div class="products_bg_des">
                                <div>
                                    <p>مساحة أرض متوفرة </p>
                                    <p>X{{ $bonusArea->number_products }}</p>
                                </div>
                                <div class="products_bg_btn">
                                    <select name="landArea_id" id="locations" required>
                                        @foreach ($bids as $landArea)
                                        <option value="{{ $landArea->id }}">{{ $landArea->land_deed }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="bonus_area_price" value="{{ $bonusArea->bonus_area_price }}" id="" hidden>
                                    <input type="text" name="state" value="{{ $bonusArea->state }}" id="" hidden>
                                    <button type="submit" style="color: white">شراء واحدة بسعر {{ floor($bonusArea->bonus_area_price) }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endforeach
                    {{-- @foreach ($bids as $landArea)
                    <div class="office_content" data-land-area-id="{{ $landArea->id }}">
                        <div class="office_titles">
                            <div class="office_titles_main">
                                <div class="office_header">
                                </div>
                                <div class="office_price">
                                    <div class="office_price_btn">
                                        <div class="office_price_btn_timer">
                                            <h3>
                                                متبقي على تجديد الرخصة:

                                            </h3>
                                            <span class="days" id="tax-time-{{ $landArea->id }}"
                                                data-end-time="{{ \Carbon\Carbon::parse($landArea->tax_end_time)->toIso8601String() }}"
                                                data-tax="{{ $landArea->tax }}">
                                                <!-- سيتم التحديث هنا بواسطة JavaScript -->
                                            </span>
                                        </div>
                                        <button
                                            data-land-area-id="{{ $landArea->id }}"
                                            class="btn-print-deed"
                                            style="background-color: rgb(91, 138, 127);border:2px solid#8ac7c4;color:white" >
                                            طبع صك الأرض
                                        </button>
                                        @if ($landArea->show_to_estate == 0)
                                    @elseif($landArea->show_to_estate == 3)
                                <br>
                                    @else
                                    <button
                                    style="color:white;background-color: rgb(78, 78, 78);"
                                   >تم ارسال طلب البيع</button>
                                    @endif
                                        @if ($landArea->tax == 0 && \Carbon\Carbon::parse($landArea->tax_end_time)->lte(now()))
                                            <!-- يظهر زر دفع الغرامة -->
                                            <button class="pay-fine" id="btn-fine-{{ $landArea->id }}"
                                                    data-land-area-id="{{ $landArea->id }}"
                                                    style="background-color: rgb(153, 37, 37);border:2px solid#f09797;color:white">
                                                دفع الغرامة 100 ريال
                                            </button>
                                        @elseif ($landArea->tax == 0)
                                            <!-- يظهر زر تجديد الرخصة -->
                                            <button class="renew-license" id="btn-renew-{{ $landArea->id }}"
                                                    data-land-area-id="{{ $landArea->id }}"
                                                    style="background-color: green; border:2px solid#acf097;color:white">

                                                تجديد الرخصة ب {{ $price->tax_price }} ريال
                                            </button>
                                        @else
                                            <!-- لا تظهر أزرار إذا تم الدفع -->
                                            <button class="renew-license" id="btn-renew-{{ $landArea->id }}"
                                                    style="background-color: grey; border:2px solid#e7e7e7;color:white" disabled>
                                                تم الدفع
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="office_img">
                            <img src="https://www.auctions.com.sa/web/binary/image/?model=auction.auction&field=image&id=15760" alt="">
                        </div>
                    </div>
                    @endforeach --}}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection
