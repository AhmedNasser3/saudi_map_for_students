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
                    @if ($bonusArea->number_products > 0)

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
                                        @if ($bids->isEmpty())
                                            <option value="#">ليس لديك أرض لشراء منتج</option>
                                        @else
                                            @foreach ($bids as $landArea)
                                                <option value="{{ $landArea->id }}">{{ $landArea->land_deed }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <input type="text" name="bonus_area_price" value="{{ $bonusArea->bonus_area_price }}" id="" hidden>
                                    <input type="text" name="state" value="{{ $bonusArea->state }}" id="" hidden>
                                    <input type="hidden" id="bonus-area-id-{{ $bonusArea->id }}" value="{{ $bonusArea->id }}">
                                    @php
                                    $isButtonShown = false; // متغير لتتبع إذا تم عرض الزر بالفعل
                                @endphp

                                @foreach ($bids as $landArea)
                                    @if (!$isButtonShown) <!-- تحقق إذا لم يتم عرض الزر بعد -->
                                        @if (auth()->user()->balance < $bonusArea->bonus_area_price)
                                            <button style="color: white">
                                                رصيدك غير كاف
                                            </button>
                                        @else
                                            <button type="submit" class="buy-btn" data-id="{{ $bonusArea->id }}" style="color: white">
                                                شراء واحدة بسعر {{ floor($bonusArea->bonus_area_price) }}
                                            </button>
                                        @endif

                                        @php
                                            $isButtonShown = true; // بعد عرض الزر، قم بتحديث المتغير لمنع تكرار الزر
                                        @endphp
                                    @endif
                                @endforeach


                                </div>
                            </div>
                        </div>
                    </form>
                    @else
                    <form  method="post">
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
                                    <input type="hidden" id="bonus-area-id-{{ $bonusArea->id }}" value="{{ $bonusArea->id }}">
                                    <button disabled type="submit" class="buy-btn" data-id="{{ $bonusArea->id }}" style="color: rgb(214, 214, 214);background:#696969">
                                        نفذ المنتج
                                    </button>                                </div>
                            </div>
                        </div>
                    </form>
                    @endif
                    @endforeach

                </div>
                <h3 style="text-align: center;margin:30px 0 0 0;color:#477938;font-size:1.2rem">تجديد الرخص</h3>
            </div>
            @foreach ($bids as $landArea)
                    <div class="office_content" style="width:320px;margin:30px 0 0 0;" data-land-area-id="{{ $landArea->id }}">
                        <div class="office_titles">
                            <div class="office_titles_des">
                            </div>
                            <div class="office_titles_main">
                                <div class="office_header">
                                    <h2>ارض في تبوك</h2>
                                    <p>مساحة {{ $landArea->area }} كم</p>
                                </div>
                                <div class="office_price">
                                    <div class="office_price_titles">
                                        <h3> صك الارض :{{ $landArea->land_deed }}</h3>
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
                    </div>
                    @endforeach
        </div>
    </div>
</div>
</div>
</div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const buttons = document.querySelectorAll('.buy-btn');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const bonusAreaId = this.getAttribute('data-id');
                const productNumberSpan = document.getElementById(`product-number-${bonusAreaId}`);

                // إرسال طلب AJAX لتحديث العدد
                fetch(`/update-product/${bonusAreaId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ id: bonusAreaId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // تحديث العدد في الواجهة
                        productNumberSpan.textContent = data.newNumber;
                        alert('تم الشراء بنجاح!');
                    } else {
                        alert('حدث خطأ أثناء الشراء.');
                    }
                })

            });
        });
    });
</script>
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
