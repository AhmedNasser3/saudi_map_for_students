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

                                    @if ($landArea->tax == 0)
                                        <div>
                                            <button class="renew-license" id="btn-{{ $landArea->id }}" data-land-area-id="{{ $landArea->id }}" style="background-color: green;">تجديد الرخصة ب 50 ريال</button>
                                        </div>
                                    @elseif ($landArea->tax == 1)
                                        <div>
                                            <button class="renew-license" id="btn-{{ $landArea->id }}" style="background-color: grey;" disabled>تم الدفع</button>
                                        </div>
                                    @else
                                        <div>
                                            <button class="renew-license" id="btn-{{ $landArea->id }}" data-land-area-id="{{ $landArea->id }}" style="background-color: red;">دفع غرامة 100 ريال</button>
                                        </div>
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
        // تحديث الوقت المتبقي
        function updateTaxTime() {
            document.querySelectorAll('.days').forEach(function(element) {
                var landAreaId = element.id.split('-')[2]; // استخدام landAreaId بدلاً من bidId
                var endTimeString = element.getAttribute('data-end-time');
                var tax = parseInt(element.getAttribute('data-tax')); // قيمة tax
                var endDate = new Date(endTimeString); // تحويل الوقت إلى تاريخ

                var now = new Date();
                var diffTime = endDate - now; // الفرق بين الوقت الحالي ووقت انتهاء الرخصة

                // إذا انتهى الوقت وكان tax == 1، أضف 7 أيام
                if (diffTime <= 0 && tax == 1) {
                    var newEndDate = new Date(now);
                    newEndDate.setDate(newEndDate.getDate() + 7); // إضافة 7 أيام
                    var newEndTime = newEndDate.toISOString(); // تحويل التاريخ الجديد إلى ISO String

                    // تحديث التاريخ في العنصر
                    element.setAttribute('data-end-time', newEndTime);

                    // إرسال الطلب إلى السيرفر لتحديث تاريخ النهاية
                    fetch('/extend-tax-time', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'  // تأكد من أنك تستخدم {{ csrf_token() }} هنا لتوليد توكن صالح
                        },
                        body: JSON.stringify({
                            landAreaId: landAreaId, // إرسال landAreaId لتحديد السجل
                            newEndTime: newEndTime // إرسال التاريخ الجديد
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
                    // حساب الأيام والساعات والدقائق والثواني
                    var diffDays = Math.floor(diffTime / (1000 * 3600 * 24)); // الأيام
                    var diffHours = Math.floor((diffTime % (1000 * 3600 * 24)) / (1000 * 3600)); // الساعات
                    var diffMinutes = Math.floor((diffTime % (1000 * 3600)) / (1000 * 60)); // الدقائق
                    var diffSeconds = Math.floor((diffTime % (1000 * 60)) / 1000); // الثواني

                    // عرض الوقت بالشكل المناسب
                    element.innerText = `${diffDays} يوم ${diffHours} ساعة ${diffMinutes} دقيقة ${diffSeconds} ثانية`;
                } else {
                    element.innerText = 'انتهت المدة';
                }
            });
        }

        // تحديث الوقت المتبقي كل ثانية
        setInterval(updateTaxTime, 1000); // تحديث الوقت كل ثانية
        updateTaxTime(); // تأكد من التحديث الأول عند تحميل الصفحة
    });

    // تجديد الرخصة أو دفع الغرامة عند الضغط على الزر
    document.querySelectorAll('.renew-license').forEach(button => {
        button.addEventListener('click', function () {
            let landAreaId = this.getAttribute('data-land-area-id'); // استخدم landAreaId بدلاً من bidId
            let btn = document.getElementById('btn-' + landAreaId);

            // تحقق إذا كان هناك landAreaId
            if (!landAreaId) {
                console.error("No landAreaId found!");
                return;
            }

            // إرسال الطلب عبر AJAX
            fetch('/pay-tax', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'  // تأكد من أنك تستخدم {{ csrf_token() }} هنا لتوليد توكن صالح
                },
                body: JSON.stringify({
                    landAreaId: landAreaId // ارسال landAreaId بدلاً من bidId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'تم الدفع بنجاح') {
                    alert(data.message);
                    // تغيير حالة الزر بعد الدفع
                    btn.innerText = "تم الدفع";
                    btn.style.backgroundColor = "grey";
                    btn.disabled = true;
                } else {
                    alert(data.message);
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        });
    });
</script>

@endsection
