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
            <button><a href="#">مشاهدة السجل </a></button>
        </div>
        <div class="bid_title">
            <h1>السجل المالي</h1>
        </div>
    </div>
    <div class="bid_body">
        <ul>
            <li class="filter-item" id="btn-all" data-filter="all" style="border-bottom: 1px solid #36b927;">
                <a href="#">السجل المالي</a>
            </li>
        </ul>
    </div>
    <div class="office_container" style="display: flex;justify-content: center;flex-wrap: wrap;gap: 1px;">
<div class="office_data" id="content-all" style="display: flex; margin:2% 0 0 0;">
    <div class="office_data" id="content-ongoing" >
    <div class="office_additions_all"  >
        @foreach ($sortedItems as $item)
        <div class="office_additions"  style="display: grid">
        @if ($item instanceof App\Models\admin\land\LandArea)
            <div class="office_additions_title">
                <h3 style="color: #770e00d5">ارض تم شرائها:&nbsp;&nbsp;</h3>
                <h3 style="color: #df4b37">{{ $item->highest_bid}}-</h3>
            </div>
            <div class="office_additions_history">
                <p>{{ $item->created_at->format('d') }}/{{ $item->created_at->format('m') }}/{{ $item->created_at->format('Y') }}</p>
            </div>
            @elseif ($item instanceof App\Models\admin\addition\Addition)
            <div class="office_additions_title">
                <h3 style="color: #36b927">{{ $item->title }}: &nbsp;&nbsp;</h3>
                <h3 style="color: #36b927">{{ $item->addition }}+</h3>
            </div>
            <div class="office_additions_history">
                <p>{{ $item->created_at->format('d') }}/{{ $item->created_at->format('m') }}/{{ $item->created_at->format('Y') }}</p>
            </div>
            @elseif ($item instanceof App\Models\admin\discount\Discount)
            <div class="office_additions_title">
                <h3 style="color: #ad2310d5">{{ $item->title }}:&nbsp;&nbsp;</h3>
                <h3 style="color: #ad2310d5">{{ $item->discount }}-</h3>
            </div>
            <div class="office_additions_history">
                <p>{{ $item->created_at->format('d') }}/{{ $item->created_at->format('m') }}/{{ $item->created_at->format('Y') }}</p>
            </div>
            @endif
        </div>
    @endforeach

</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // عند الضغط على رابط "قراءة" أو "مقروءة"
        $('.mark-read-link').click(function (e) {
            e.preventDefault(); // منع إعادة تحميل الصفحة

            var link = $(this); // الحصول على الرابط الذي تم الضغط عليه
            var messageId = link.data('id'); // استخراج معرّف الرسالة من خاصية data-id
            var currentStatus = link.text(); // الحصول على النص الحالي (قراءة / مقروءة)

            // إذا كانت الرسالة "قراءة" (أي read == 1)، نقوم بتحديثها إلى "مقروءة" (حالة read = 0)
            if (currentStatus === 'قراءة') {
                // إرسال الطلب عبر AJAX لتحديث حالة الرسالة إلى "مقروءة" (read = 0)
                $.ajax({
                    url: "{{ route('messages.markRead') }}", // المسار الخاص بالـ route
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // إرسال CSRF Token
                        id: messageId, // إرسال معرّف الرسالة
                        read: 0 // تغيير حالة الرسالة إلى "مقروءة" (read = 0)
                    },
                    success: function (response) {
                        if (response.success) {
                            // تحديث النص إلى "مقروءة" مع اللون الرمادي
                            link.css('color', '#9b9b9b').text('مقروءة');
                            link.closest('.message_body_title').css('background-color', '#ffffff'); // تحديث الخلفية
                        } else {
                            alert('حدث خطأ ما.');
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        alert('حدث خطأ أثناء تحديث الحالة.');
                    }
                });
            } else {
                // إذا كانت الرسالة "مقروءة" (أي read == 0)، نقوم بتحديثها إلى "قراءة" (حالة read = 1)
                $.ajax({
                    url: "{{ route('messages.markRead') }}", // المسار الخاص بالـ route
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // إرسال CSRF Token
                        id: messageId, // إرسال معرّف الرسالة
                        read: 1 // تغيير حالة الرسالة إلى "قراءة" (read = 1)
                    },
                    success: function (response) {
                        if (response.success) {
                            // تحديث النص إلى "قراءة" مع اللون الأخضر
                            link.css('color', '#5d9c40').text('قراءة');
                            link.closest('.message_body_title').css('background-color', '#d6d6d6'); // تحديث الخلفية
                        } else {
                            alert('حدث خطأ ما.');
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        alert('حدث خطأ أثناء تحديث الحالة.');
                    }
                });
            }
        });
    });
</script>
</div>
</div>
<div class="office_data" id="content-product" style="display: none;">
    <div class="office_additions_all" style="display: grid">
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
document.addEventListener('DOMContentLoaded', function () {
const filterItems = document.querySelectorAll('.filter-item');
const contentSections = document.querySelectorAll('.office_data');

filterItems.forEach(item => {
    item.addEventListener('click', function () {
        const filter = this.getAttribute('data-filter');

        // إخفاء جميع الصفحات
        contentSections.forEach(section => {
            section.style.display = 'none';
        });

        // عرض الصفحة المطلوبة
        const targetSection = document.getElementById('content-' + filter);
        targetSection.style.display = 'flex';

        // تحديث الزر المحدد
        filterItems.forEach(i => i.style.borderBottom = 'none');
        this.style.borderBottom = '1px solid #36b927';
    });
});

// تعيين الفلتر الافتراضي (الكل)
const defaultFilter = 'all';
filterItems.forEach(i => {
    if (i.getAttribute('data-filter') === defaultFilter) {
        i.style.borderBottom = '1px solid #36b927';
    }
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
