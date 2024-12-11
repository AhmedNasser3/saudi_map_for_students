@extends('frontend.master')
@section('content')
 @php
use App\Models\admin\price\Price;
use App\Models\admin\estate\Estate;

$price = Price::first();
@endphp
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
@endforeach
</div>
</div>
</div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
// استرجاع المدة المختارة من الخادم بناءً على landAreaId
document.querySelectorAll('.days').forEach(function(element) {
var landAreaId = element.id.split('-')[2]; // استخراج landArea_id من الـ id

fetch(`/get-tax-info?land_area_id=${landAreaId}`)
    .then(response => response.json())
    .then(data => {
        var selectedDays = data.taxDays || 7; // إذا لم توجد مدة، يتم تعيين 7 أيام افتراضيًا

        // تحديث الوقت المتبقي بناءً على selectedDays
        function updateTaxTime() {
            var endTimeString = element.getAttribute('data-end-time');
            var tax = parseInt(element.getAttribute('data-tax'));
            var endDate = new Date(endTimeString);
            var now = new Date();
            var diffTime = endDate - now;

            if (diffTime <= 0 && tax == 1) {
                var newEndDate = new Date(now);
                newEndDate.setDate(newEndDate.getDate() + parseInt(selectedDays)); // تمديد الوقت حسب المدة المختارة
                var newEndTime = newEndDate.toISOString();

                element.setAttribute('data-end-time', newEndTime);

                // تمديد الرخصة تلقائيًا بعد دفع الغرامة
                fetch('/extend-tax-time', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        landAreaId: landAreaId,
                        newEndTime: newEndTime,
                        addedDays: selectedDays // إرسال الأيام المضافة إلى الخادم
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('تم تمديد الرخصة بنجاح!');
                    } else {
                        alert('حدث خطأ أثناء التمديد.');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                });

                // تحديث قيمة tax إلى 0 بعد انتهاء الوقت
                fetch(`/update-tax-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        landAreaId: landAreaId,
                        taxStatus: 0 // تعيين tax إلى 0
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(`تم تحديث قيمة tax إلى 0 للمنطقة ${landAreaId}`);
                    } else {
                        console.error('حدث خطأ أثناء تحديث tax');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }

            if (diffTime > 0) {
                var diffDays = Math.floor(diffTime / (1000 * 3600 * 24));
                var diffHours = Math.floor((diffTime % (1000 * 3600 * 24)) / (1000 * 3600));
                var diffMinutes = Math.floor((diffTime % (1000 * 3600)) / (1000 * 60));
                var diffSeconds = Math.floor((diffTime % (1000 * 60)) / 1000);

                element.innerText = `${diffDays} يوم ${diffHours} ساعة ${diffMinutes} دقيقة ${diffSeconds} ثانية`;
            } else {
                element.innerText = 'انتهت المدة';
            }
        }

        setInterval(updateTaxTime, 1000);
        updateTaxTime();
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

// تجديد الرخصة أو دفع الغرامة عند الضغط على الزر
document.querySelectorAll('.renew-license, .pay-fine').forEach(button => {
button.addEventListener('click', function () {
    let landAreaId = this.getAttribute('data-land-area-id');
    let btn = this;
    let action = this.classList.contains('renew-license') ? 'renew' : 'fine';

    fetch('/pay-tax', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            landAreaId: landAreaId,
            action: action
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (action === 'fine') {
                btn.innerText = "دفع 50 ريال لتجديد الرخصة";
                btn.style.backgroundColor = "green";
            } else if (action === 'renew') {
                btn.innerText = "تم الدفع";
                btn.style.backgroundColor = "grey";
                btn.disabled = true;
            }
        } else {
            alert(data.message);
        }
    }).catch(error => {
        console.error('Error:', error);
    });
});
});
});


document.addEventListener("DOMContentLoaded", function() {
document.querySelectorAll('.btn-print-deed').forEach(button => {
button.addEventListener('click', function () {
    let landAreaId = this.getAttribute('data-land-area-id');

    // فتح نافذة جديدة لعرض الـ PDF للطباعة
    window.open('/print-deed/' + landAreaId, '_blank');
});
});
});
</script>
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
