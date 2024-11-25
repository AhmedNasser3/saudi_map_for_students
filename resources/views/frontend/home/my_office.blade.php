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
                                            <button class="renew-license" id="btn-renew-{{ $landArea->id }}" data-land-area-id="{{ $landArea->id }}" style="background-color: green;">تجديد الرخصة ب 50 ريال</button>
                                            <button class="pay-fine" id="btn-fine-{{ $landArea->id }}" data-land-area-id="{{ $landArea->id }}" style="background-color: red;">دفع الغرامة 100 ريال</button>
                                        </div>
                                    @elseif ($landArea->tax == 1)
                                        <div>
                                            <button class="renew-license" id="btn-renew-{{ $landArea->id }}" style="background-color: grey;" disabled>تم الدفع</button>
                                        </div>
                                    @else
                                        <div>
                                            <button class="pay-fine" id="btn-fine-{{ $landArea->id }}" data-land-area-id="{{ $landArea->id }}" style="background-color: red;">دفع غرامة 100 ريال</button>
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
                var landAreaId = element.id.split('-')[2];
                var endTimeString = element.getAttribute('data-end-time');
                var tax = parseInt(element.getAttribute('data-tax'));
                var endDate = new Date(endTimeString);

                var now = new Date();
                var diffTime = endDate - now;

                if (diffTime <= 0 && tax == 1) {
                    var newEndDate = new Date(now);
                    newEndDate.setDate(newEndDate.getDate() + 7);
                    var newEndTime = newEndDate.toISOString();

                    element.setAttribute('data-end-time', newEndTime);

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

        // تجديد الرخصة أو دفع الغرامة عند الضغط على الزر
        document.querySelectorAll('.renew-license, .pay-fine').forEach(button => {
            button.addEventListener('click', function () {
                let landAreaId = this.getAttribute('data-land-area-id');
                let btn = document.getElementById('btn-' + landAreaId);
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
                    if (data.message) {
                        alert(data.message);
                        if (action === 'renew') {
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
</script>

@endsection
