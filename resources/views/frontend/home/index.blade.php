@extends('frontend.master')
@section('content')
@php
use App\Models\admin\price\Price;
use App\Models\admin\estate\Estate;

$price = Price::first();
@endphp
@if(!auth()->check() || auth()->user()->children->isEmpty())
@if (session('success'))
    <div class="notification-card success" id="success-alert">
        ✅ {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="notification-card error" id="error-alert">
        ❌ {{ session('error') }}
    </div>
@endif
@if (auth()->check())
{{-- banner --}}
<div style="padding: 10% 0 0 0">
    @include('frontend.home.banner')
</div>
{{-- Bid --}}
@include('frontend.home.bid')
{{-- QA --}}
@include('frontend.home.QA')
@else
{{-- map --}}
@include('frontend.home.map')
{{-- banner --}}
@include('frontend.home.banner')
{{-- QA --}}
@include('frontend.home.QA')
@endif
{{-- map --}}
{{-- @include('frontend.home.map') --}}
{{-- banner --}}
{{-- @include('frontend.home.banner') --}}
{{-- Bid --}}
{{-- @include('frontend.home.bid') --}}
{{-- QA --}}
{{-- @include('frontend.home.QA') --}}
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const timers = document.querySelectorAll("[id^='timer-']");
        timers.forEach(timer => {
            const endTime = new Date(timer.getAttribute("data-endtime")).getTime(); // تحويل إلى timestamp
            const auctionId = timer.id.split('-')[1];

            function updateTimer() {
                const now = Date.now(); // وقت الحالي بوحدات milliseconds
                const timeRemaining = endTime - now;

                if (timeRemaining > 0) {
                    const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                    timer.querySelector(".days").textContent = days.toString().padStart(2, '0');
                    timer.querySelector(".hours").textContent = hours.toString().padStart(2, '0');
                    timer.querySelector(".minutes").textContent = minutes.toString().padStart(2, '0');
                    timer.querySelector(".seconds").textContent = seconds.toString().padStart(2, '0');
                } else {
                    timer.innerHTML = `<h3>المزاد انتهى</h3>`;
                    fetch('/update-auction-state', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            auction_id: auctionId,
                            state: 0
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(`تم تحديث حالة المزاد ID ${auctionId}:`, data.message);
                    })
                    .catch(error => {
                        console.error(`خطأ أثناء تحديث حالة المزاد ID ${auctionId}:`, error);
                    });
                    clearInterval(interval);
                }
            }

            const interval = setInterval(updateTimer, 1000);
            updateTimer(); // استدعاء أولي لتجنب التأخير
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const bidTimers = document.querySelectorAll('.bid_cards_timer');
    bidTimers.forEach(function(timer) {
        const endTime = timer.querySelector('ul').getAttribute('data-endtime');
        const landId = timer.closest('.bid_cards_content').dataset.landId;
        const interval = setInterval(function() {
            const currentTime = new Date().getTime();
            const remainingTime = new Date(endTime).getTime() - currentTime;
            if (remainingTime <= 0) {
                clearInterval(interval);
                fetch(`/update-highest-bid/${landId}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Updated highest bid:', data);
                })
                .catch(error => console.error('Error:', error));
            }
        }, 1000);
    });
});
</script>
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
@else
<div class="office">
    <div class="bid_header" style="direction: rtl">
        {{-- <div class="bid_btn">
            <button><a href="#">مشاهدة الجميع </a></button>
        </div> --}}
        <div class="bid_title" >
            <h1>الاراضي</h1>
        </div>
    </div>
    <div class="bid_body">
        <ul>
            <li class="" id="btn-all" data-filter="all" style="border-bottom: 1px solid #36b927;">
                <a href="#">كل الاراضي</a>
            </li>
        </ul>
    </div>
    <div class="office_container" style="display: flex;justify-content: center;flex-wrap: wrap;gap: 1px;">
<div class="office_data" id="content-all" style="display: flex; margin:2% 0 0 0;justify-content: center;">
@foreach ($bids as $landArea)
<div class="office_content" data-land-area-id="{{ $landArea->id }}">
    <div class="office_titles">
        <div class="office_titles_main">
            <div class="office_header">
                <h2>ارض في تبوك</h2>
                <p>مساحة {{ $landArea->area }} كم</p>
            </div>
            <div class="office_price">
                <div class="office_price_titles">
                    <h3>{{ $landArea->highest_bid }} ريال</h3>
                    <p>تم خصمهم من رصيدك</p>
                </div>
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


                </div>
            </div>
        </div>
    </div>
    <div class="office_img">
        <img src="https://www.auctions.com.sa/web/binary/image/?model=auction.auction&field=image&id=15760" alt="">
    </div>
</div>
@if (auth()->check() && auth()->user()->children->isNotEmpty())
    <h1>أبناؤك</h1>
    <ul>
        @foreach (auth()->user()->children as $child)
            <li>{{ $child->child->name }}</li>
        @endforeach
    </ul>
@else
    <p>ليس لديك أبناء مسجلين.</p>
@endif
@endforeach
</div>
</div>
</div>

</div>
@endif
@endsection
