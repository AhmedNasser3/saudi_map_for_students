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
            <button><a href="#">مشاهدة جميع الصكوك</a></button>
        </div>
        <div class="bid_title">
            <h1>شيخ العقار</h1>
        </div>
    </div>
    <div class="bid_body">
        <ul>
            <li class="filter-item" id="btn-all" data-filter="all" style="border-bottom: 1px solid #36b927;">
                <a href="#">شيخ العقار</a>
            </li>
        </ul>
    </div>
    <div class="office_container" style="display: flex;justify-content: center;flex-wrap: wrap;gap: 1px;">
<div class="office_data" id="content-all" style="display: flex; margin:2% 0 0 0;">
<div class="beard">
    <div class="beard_container">
        <div class="beard_content">
            <div class="beard_data">
                <div class="beard_cn">
                    <a href="{{ route('message.home', ['userId' => auth()->user()->id]) }}">
                    <div class="beard_bg">
                        <div class="beard_bg_title">
                            <div class="beard_bg_img">
                                <img src="{{ asset('images/question-mark-icon-free-vector.png') }}" alt="">
                            </div>
                                <h3>طلب استشارة </h3>
                        </div>
                    </div>
                    </a>
                    <a href="{{ route('home.rate', ['userId' =>auth()->user()->id]) }}">
                        <div class="beard_bg">
                            <div class="beard_bg_title">
                                <div class="beard_bg_img">
                                    <img src="{{ asset('images/portrait-elderly-arab-man-white-260nw-2450117663.png') }}" alt="">
                                </div>
                                <h3>طلب تقييم </h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>
</div>
</div>
        @endsection
