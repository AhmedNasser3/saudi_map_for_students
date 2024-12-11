@extends('frontend.master')
@section('content')
 @php
use App\Models\admin\price\Price;
use App\Models\admin\estate\Estate;

$price = Price::first();
@endphp
<div class="office">
    <div class="bid_header" style="direction: rtl">

        <div class="bid_title" >
            <h1>الصكوك</h1>
        </div>
    </div>
    <div class="bid_body">
        <ul>
            <li class="" id="btn-all" data-filter="all" style="border-bottom: 1px solid #36b927;">
                <a href="#">كل الصكوك</a>
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
                    <h3>صك الارض : {{ $landArea->land_deed }} </h3>
                </div>
                <div class="office_price_btn">
                    <div class="office_price_btn_timer">

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

                    <button
                    class="btn_estate"
                    style="background-color: #5b6f8a; border:2px solid#abccf7;color:white"
                    id="btn-estate-{{ $landArea->id }}"
                    data-land-area-id="{{ $landArea->id }}">
                    بيع الارض
                </button>
                @elseif($landArea->show_to_estate == 3)
                <p style="color: #5b6f8a;font-size:1rem;margin:10px 0 0 0;">
                    @php
$estates = Estate::where('landArea_id', $landArea->id)
->orderBy('id', 'desc') // استبدل "created_at" بالعمود الذي ترغب بالترتيب بناءً عليه
->first();
                    @endphp
                    تم تقدير السعر ب {{ floor($estates->min_price) }} ريال
                </p>
                <button
                class="apply-btn"
                data-id="{{ $landArea->id }}"
                style="background-color: rgb(130, 206, 187); border:2px solid #abf7cd;color:white">
                قبول
            </button>
            <button
            class="reject-btn"
            data-id="{{ $landArea->id }}"
            style="background-color: rgb(206, 130, 130); border:2px solid #f7abab;color:white">
            رفض
        </button>
            <br>
                @else
                <button
                style="color:white;background-color: rgb(78, 78, 78);"
               >تم ارسال طلب البيع</button>
                @endif

                </div>
            </div>
        </div>
    </div>
    <div class="office_img">
        <img src="https://www.auctions.com.sa/web/binary/image/?model=auction.auction&field=image&id=15760" alt="">
    </div>
</div>
@endforeach
</div>
</div>
</div>

</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
// إضافة حدث الضغط على زر "بيع الأرض"
document.querySelectorAll('.btn_estate').forEach(button => {
    button.addEventListener('click', function () {
        let landAreaId = this.getAttribute('data-land-area-id');
        let btn = this;

        // إرسال طلب AJAX لتحديث show_to_estate إلى 1
        fetch('/update-land-estate-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                landAreaId: landAreaId,
                showToEstate: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // في حالة النجاح، تحديث الزر أو إجراء آخر
                btn.innerText = "تم بيع الأرض";
                btn.style.backgroundColor = "grey";
                btn.disabled = true; // تعطيل الزر بعد البيع
            } else {
                alert(data.message || "حدث خطأ أثناء بيع الأرض.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('click', '.reject-btn', function(e) {
e.preventDefault();

var landAreaId = $(this).data('id');

$.ajax({
    url: "{{ route('updateState') }}",
    type: "POST",
    data: {
        _token: "{{ csrf_token() }}",
        landArea_id: landAreaId,
        state: 0
    },
    success: function(response) {
        if (response.success) {
            alert('تم تحديث الحالة بنجاح.');
            location.reload();
        } else {
            alert('حدث خطأ أثناء تحديث الحالة.');
        }
    },
    error: function(xhr) {
        alert('حدث خطأ غير متوقع.');
    }
});
});
</script>
<script>
$(document).on('click', '.apply-btn', function(e) {
e.preventDefault();

var landAreaId = $(this).data('id');

$.ajax({
    url: "{{ route('updateState_apply') }}",
    type: "POST",
    data: {
        _token: "{{ csrf_token() }}",
        landArea_id: landAreaId,
        state: 4
    },
    success: function(response) {
        if (response.success) {
            alert('تم تحديث الحالة بنجاح.');
            location.reload();
        } else {
            alert('حدث خطأ أثناء تحديث الحالة.');
        }
    },
    error: function(xhr) {
        alert('حدث خطأ غير متوقع.');
    }
});
});
</script>
@endsection
