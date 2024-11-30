@extends('frontend.master')
@section('content')
<div class="office">
    <div class="office_container">
        <div class="office_data">
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
                                        متبقي على تجديد الرخصة:
                                        <span class="days" id="tax-time-{{ $landArea->id }}"
                                              data-end-time="{{ \Carbon\Carbon::parse($landArea->tax_end_time)->toIso8601String() }}"
                                              data-tax="{{ $landArea->tax }}">
                                            <!-- سيتم التحديث هنا بواسطة JavaScript -->
                                        </span>
                                    </div>
                                    <button
                                    data-land-area-id="{{ $landArea->id }}"
                                    class="btn-print-deed"
                                    style="background-color: rgb(91, 138, 127);">
                                    طبع صك الأرض
                                </button>
                                    @if ($landArea->tax == 0 && \Carbon\Carbon::parse($landArea->tax_end_time)->lte(now()))
                                        <!-- يظهر زر دفع الغرامة -->
                                        <button class="pay-fine" id="btn-fine-{{ $landArea->id }}"
                                                data-land-area-id="{{ $landArea->id }}"
                                                style="background-color: red;">
                                            دفع الغرامة 100 ريال
                                        </button>
                                    @elseif ($landArea->tax == 0)
                                        <!-- يظهر زر تجديد الرخصة -->
                                        <button class="renew-license" id="btn-renew-{{ $landArea->id }}"
                                                data-land-area-id="{{ $landArea->id }}"
                                                style="background-color: green;">
                                            تجديد الرخصة ب 50 ريال
                                        </button>
                                    @else
                                        <!-- لا تظهر أزرار إذا تم الدفع -->
                                        <button class="renew-license" id="btn-renew-{{ $landArea->id }}"
                                                style="background-color: grey;" disabled>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
    // استرجاع المدة المختارة من localStorage
    var selectedDays = localStorage.getItem('selectedDays') || 7; // افتراضيًا 7 أيام إذا لم يتم تحديدها مسبقًا

    // تحديث الوقت المتبقي
    function updateTaxTime() {
        document.querySelectorAll('.days').forEach(function(element) {
            var landAreaId = element.id.split('-')[2];
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
                        newEndTime: newEndTime
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
        });
    }

    setInterval(updateTaxTime, 1000);
    updateTaxTime();

    // إضافة حقل الإدخال لاختيار عدد الأيام
    var inputField = document.createElement('input');
    inputField.type = 'number';
    inputField.id = 'duration-input';
    inputField.min = 1;
    inputField.max = 30;
    inputField.value = selectedDays; // القيمة الافتراضية
    inputField.style.width = '60px';

    var saveButton = document.createElement('button');
    saveButton.innerText = 'حفظ المدة';
    saveButton.style.marginLeft = '10px';

    document.body.appendChild(inputField);
    document.body.appendChild(saveButton);

    // حفظ المدة المدخلة في localStorage عند الضغط على زر "حفظ المدة"
    saveButton.addEventListener('click', function() {
        var duration = inputField.value;
        localStorage.setItem('selectedDays', duration); // حفظ القيمة في localStorage
        selectedDays = duration; // تحديث المتغير الذي يحفظ المدة
        alert('تم حفظ المدة: ' + selectedDays + ' يوم');
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
                        // بعد دفع الغرامة: تمديد الوقت وتغيير الزر إلى الأخضر لتجديد الرخصة
                        btn.innerText = "دفع 50 ريال لتجديد الرخصة";
                        btn.style.backgroundColor = "green";
                    } else if (action === 'renew') {
                        // بعد دفع 50 ريال: تغيير الزر إلى رمادي
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

@endsection
