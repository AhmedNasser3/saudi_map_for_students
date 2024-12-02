@extends('frontend.master')
@section('content')
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
@endsection
