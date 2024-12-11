<div class="bid" id="bidds">
    <div class="bid_container">
        <div class="bid_data">
            <div class="bid_content">
                <div class="bid_header">
                    <div class="bid_btn">
                        <button><a href="#">مشاهدة جميع المزادات</a></button>
                    </div>
                    <div class="bid_title">
                        <h1>المزادات</h1>
                    </div>
                </div>
                <div class="bid_body">
                    <ul>
                        <li style="    border-bottom: 1px solid #36b927;"><a href="#" style="    color: #36b927;">الكل</a></li>
                    </ul>
                </div>
                <div class="bid_cards">
                    <div class="bid_cards_container">
                        <div class="bid_cards_data">
                            @if($landarea && $landarea->count())
                            @foreach ($landarea as $land)
                            @if ($land->show == 0)
                            <div class="bid_cards_content">
                                <div class="bid_cards_img">
                                    <img src="https://www.auctions.com.sa/web/binary/image/?model=auction.auction&field=image&id=15760" alt="">
                                </div>
                                <div class="bid_cards_timer">
                                    <div class="bid_cards_timer_container">
                                        <div class="bid_cards_timer_title">
                                            <h3>المزايدة الحالية تنتهي بعد</h3>
                                        </div>
                                        <div class="bid_cards_timer_body">
                                            <ul id="timer-{{ $land->id }}" data-endtime="{{ $land->auction_end_time }}">
                                                <li>
                                                    <div class="bid_cards_timer_body_text">
                                                        <h3 class="days">0</h3>
                                                        <p>يوم</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="bid_cards_timer_body_text">
                                                        <h3 class="hours">0</h3>
                                                        <p>ساعة</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="bid_cards_timer_body_text">
                                                        <h3 class="minutes">0</h3>
                                                        <p>دقيقة</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="bid_cards_timer_body_text">
                                                        <h3 class="seconds">0</h3>
                                                        <p>ثانية</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="bid_cards_footer">
                                    <ul>
                                        <li><a href="#"><i style="color: rgb(255, 217, 0)" class="fa-solid fa-ruler"></i>&nbsp;&nbsp;{{ floor($land->area) }} كم</a></li>
                                        <li><a href="#"><i class="fa-solid fa-money-bill" style="color: rgb(47, 187, 47);"></i>&nbsp;&nbsp;تبدأ من {{ floor($land->starting_price) }} ريال</a></li>
                                        <li><a href="#"><i class="fa-solid fa-clock" style="color: rgb(89, 20, 20);"></i>&nbsp;&nbsp; {{ $land->duration }} أيام</a></li>
                                        <li><a href="#"><i class="fa-solid fa-hourglass-end" style="color: rgb(80, 73, 73);"></i>&nbsp;&nbsp;ينتهي يوم {{ $land->day }}</a></li>
                                    </ul>
                                </div>
                                <div class="bid_cards_btns">
                                    <div class="bid_cards_btns_container">
                                        <button class="bidButton" data-endtime="{{ $land->auction_end_time }}" data-id="{{ $land->id }}" style="color: white">مزايدة</button>


                                        <div class="bid_cards_btns_2">
                                            <button class="bidButton2" data-endtime="{{ $land->auction_end_time }}" data-land-id="{{ $land->id }}" style="color: white; font-size:1.1rem;cursor: pointer;">مشاهدة المزايدين</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div hidden class="countdown" data-id="{{ $land->id }}" data-starttime="{{ $land->start_time }}">
                                <span   class="timer-days">0</span> يوم
                                <span   class="timer-hours">0</span> ساعة
                                <span   class="timer-minutes">0</span> دقيقة
                                <span   class="timer-seconds">0</span> ثانية
                            </div>
                            <div   hidden class="bid_cards_content">
                                <div class="bid_cards_img">
                                    <img src="https://www.auctions.com.sa/web/binary/image/?model=auction.auction&field=image&id=15760" alt="">
                                </div>
                                <div class="bid_cards_timer">
                                    <div class="bid_cards_timer_container">
                                        <div class="bid_cards_timer_title">
                                            <h3>المزايدة الحالية تنتهي بعد</h3>
                                        </div>
                                        <div class="bid_cards_timer_body">
                                            <ul id="timer-{{ $land->id }}" data-endtime="{{ $land->auction_end_time }}">
                                                <li>
                                                    <div class="bid_cards_timer_body_text">
                                                        <h3 class="days">0</h3>
                                                        <p>يوم</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="bid_cards_timer_body_text">
                                                        <h3 class="hours">0</h3>
                                                        <p>ساعة</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="bid_cards_timer_body_text">
                                                        <h3 class="minutes">0</h3>
                                                        <p>دقيقة</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="bid_cards_timer_body_text">
                                                        <h3 class="seconds">0</h3>
                                                        <p>ثانية</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="bid_cards_footer">
                                    <ul>
                                        <li><a href="#"><i style="color: rgb(255, 217, 0)" class="fa-solid fa-ruler"></i>&nbsp;&nbsp;{{ floor($land->area) }} كم</a></li>
                                        <li><a href="#"><i class="fa-solid fa-money-bill" style="color: rgb(47, 187, 47);"></i>&nbsp;&nbsp;تبدأ من {{ floor($land->starting_price) }} ريال</a></li>
                                        <li><a href="#"><i class="fa-solid fa-clock" style="color: rgb(89, 20, 20);"></i>&nbsp;&nbsp; {{ $land->duration }} أيام</a></li>
                                        <li><a href="#"><i class="fa-solid fa-hourglass-end" style="color: rgb(80, 73, 73);"></i>&nbsp;&nbsp;ينتهي يوم {{ $land->day }}</a></li>
                                    </ul>
                                </div>
                                <div class="bid_cards_btns">
                                    <div class="bid_cards_btns_container">
                                        <button class="bidButton" data-endtime="{{ $land->auction_end_time }}" data-id="{{ $land->id }}" style="color: white">مزايدة</button>


                                        <div class="bid_cards_btns_2">
                                            <button class="bidButton2" data-endtime="{{ $land->auction_end_time }}" data-land-id="{{ $land->id }}" style="color: white; font-size:1.1rem;cursor: pointer;">مشاهدة المزايدين</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div hidden class="countdown" data-id="{{ $land->id }}" data-starttime="{{ $land->before_start_time }}">
                                <span class="timer-days">0</span> يوم
                                <span class="timer-hours">0</span> ساعة
                                <span class="timer-minutes">0</span> دقيقة
                                <span class="timer-seconds">0</span> ثانية
                            </div>
<div class="bid_pop_up_bg"></div>

<div class="bid_pop_up">
    <div class="bid_pop_up_container">
        <div class="bid_pop_up_data">
            <div class="bid_pop_up_content">
                <div class="bid_pop_up_header">
                    <button id="closeBidPopUp" class="close_button"><i class="fa-solid fa-arrow-right"></i></button>
                </div>
                <div class="bid_pop_up_cn">
                    <div class="bid_pop_up_title">
                        <div class="bid_pop_up_header_title">
                            <div class="bid_pop_up_land">
                                <h3>صك الارض:</h3>
                            </div>
                            <div class="bid_pop_up_land_duration">
                                <h3></h3>
                            </div>
                        </div>
                        <div class="bid_pop_up_header_title">
                            <div class="bid_pop_up_land">
                                <h3>عدد الأمتار:</h3>
                            </div>
                            <div class="bid_pop_up_land_area">
                                <h3> كم</h3>
                            </div>
                        </div>
                        <div class="bid_pop_up_header_title">
                            <div class="bid_pop_up_land">
                                <h3>اقل سعر للمزايدة:</h3>
                            </div>
                            <div class="bid_pop_up_land_price">
                                <h3> ريال</h3>
                            </div>
                        </div>
                        <div class="bid_pop_up_inputs_btn">
                            <div class="bid_pop_up_inputs">
                                <form id="placeBidForm" action="{{ route('placeBid', $land->id) }}" method="POST">
                                    @csrf
                                    <input type="number" name="bid_amount" placeholder="ادخل سعر المزايدة" required >
                                </div>
                                <div class="bid_pop_up_btn">
                                    <button id="placeBidButton" type="submit" style="cursor: pointer;">اضف مزايدة</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bidders_pop_up_bg"></div>
<div class="bidders_pop_up">
    <div class="bidders_pop_up_container">
        <div class="bidders_pop_up_data">
            <div class="bidders_pop_up_content">
                <div class="bidders_pop_up_header">
                    <button id="closeBiddersPopUp" class="close_button"><i class="fa-solid fa-arrow-right"></i></button>
                </div>
                <div class="bidders_pop_up_cn">
                    <div class="bidders_pop_up_title">
                        <h2>قائمة المزايدين</h2>
                        <ul>
                            <p>جاري تحميل المزايدات...</p>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


        <script>
document.querySelectorAll(".bidButton").forEach(function(button) {
    button.addEventListener("click", function() {
        var landId = button.getAttribute("data-id");
        var bidPopUp = document.querySelector(".bid_pop_up");
        var bidPopUpBg = document.querySelector(".bid_pop_up_bg");

        fetch(`/get-land-details?id=${landId}`)
        .then(response => response.json())
.then(data => {
    document.querySelector(".bid_pop_up_land_area h3").innerText = `${data.land.area} كم`;
    document.querySelector(".bid_pop_up_land_price h3").innerText = `${data.land.starting_price} ريال`;
    document.querySelector(".bid_pop_up_land_duration h3").innerText = `${data.land.land_deed} `;

    var bidForm = document.querySelector("#placeBidForm");
    bidForm.action = `/place-bid/${landId}`;

 // إضافة min تلقائيًا
 var inputField = document.querySelector('input[name="bid_amount"]');
        if (inputField) {
            inputField.setAttribute("min", data.land.starting_price);  // إضافة min تلقائيًا
        }

        var bidButton = document.querySelector("#placeBidButton");
        bidButton.setAttribute("data-id", landId);
    });

        bidPopUp.style.display = "flex";
        bidPopUpBg.style.display = "block";
        setTimeout(function() {
            bidPopUp.classList.add("show");
        }, 50);
    });
});


document.querySelector(".close_button").addEventListener("click", function() {
    var bidPopUp = document.querySelector(".bid_pop_up");
    var bidPopUpBg = document.querySelector(".bid_pop_up_bg");
    bidPopUp.classList.remove("show");
    setTimeout(function() {
        bidPopUp.style.display = "none";
        bidPopUpBg.style.display = "none";
    }, 1000);
});

document.querySelectorAll(".bidButton2").forEach(function(button) {
    button.addEventListener("click", function() {
        var landId = button.getAttribute("data-land-id");
        openBiddersPopup(landId);
    });
});
function openBiddersPopup(landId) {
    var biddersList = document.querySelector(".bidders_pop_up_title ul");
    var biddersPopUp = document.querySelector(".bidders_pop_up");
    var biddersPopUpBg = document.querySelector(".bidders_pop_up_bg");

    // عرض نافذة المزايدين
    biddersPopUp.style.display = "flex";
    biddersPopUpBg.style.display = "block";

    setTimeout(function () {
        biddersPopUp.classList.add("show");
    }, 50);
    // دالة لتحديث قائمة المزايدين
    function updateBiddersList(data) {
        biddersList.innerHTML = "";

        if (data.bidders.length > 0) {
            if (Number(data.state) === 0) {
                // عرض المزايد الأعلى فقط عند state == 0
                var highestBidder = data.bidders.sort((a, b) => b.bid_amount - a.bid_amount)[0]; // أعلى مزايد
                var listItem = document.createElement('li');
                listItem.style.color = "#28a745"; // النص باللون الأخضر
                listItem.innerHTML = `
                    <p>اسم المزايد: ${highestBidder.user.name}👑</p>
                    <p>قيمة المزايدة: ${highestBidder.bid_amount} ريال</p>
                    <p style="font-weight: bold; color: #28a745;">المشتري</p>
                `;
                biddersList.appendChild(listItem);
            } else {
                // عرض جميع المزايدين عند state == 1 بترتيب تصاعدي
                data.bidders.sort((a, b) => a.bid_amount - b.bid_amount); // ترتيب تصاعدي
                data.bidders.forEach(function (bidder) {
                    var listItem = document.createElement('li');
                    listItem.innerHTML = `
                        <p>اسم المزايد: ${bidder.user.name}</p>
                        <p>قيمة المزايدة: ${bidder.bid_amount} ريال</p>
                    `;
                    biddersList.appendChild(listItem);
                });
            }
        } else {
            // إذا لم تكن هناك مزايدات
            biddersList.innerHTML = "<p>لا توجد مزايدات على هذه الأرض حتى الآن.</p>";
        }
    }

    // جلب المزايدين للمرة الأولى
    fetch(`/get-bidders?land_id=${landId}`)
        .then(response => response.json())
        .then(updateBiddersList);

    // استعلام دوري لتحديث المزايدين كل 5 ثوانٍ
    const pollingInterval = setInterval(function () {
        fetch(`/get-bidders?land_id=${landId}`)
            .then(response => response.json())
            .then(updateBiddersList);
    }, 5000);

    // إغلاق النافذة عند النقر على زر الإغلاق
    document.querySelector("#closeBiddersPopUp").addEventListener("click", function () {
        clearInterval(pollingInterval); // إيقاف الاستعلام الدوري
        biddersPopUp.classList.remove("show");
        setTimeout(function () {
            biddersPopUp.style.display = "none";
            biddersPopUpBg.style.display = "none";
        }, 1000);
    });
}



// التأكد من تعطيل الزر بعد انتهاء المزاد
document.querySelectorAll(".bidButton").forEach(function(button) {
    var endTime = new Date(button.getAttribute("data-endtime")).getTime();
    var checkAuctionStatus = function() {
        var currentTime = new Date().getTime();
        if (currentTime >= endTime) {
            button.innerHTML = '<span style="color: #fff; font-weight: bold;">المزايدة انتهت</span>';
            button.style.backgroundColor = "#131313";
            button.style.pointerEvents = "none";
        }
    };
    checkAuctionStatus();
    setInterval(checkAuctionStatus, 1000);
    if (new Date().getTime() < endTime) {
        button.addEventListener("click", function() {
            var bidPopUp = document.querySelector(".bid_pop_up");
            var bidPopUpBg = document.querySelector(".bid_pop_up_bg");

            bidPopUp.style.display = "flex";
            bidPopUpBg.style.display = "block";

            setTimeout(function() {
                bidPopUp.classList.add("show");
            }, 50);
        });
    }
});
            </script>
            <script>
document.querySelectorAll(".countdown").forEach(function (countdownElement) {
    const landId = countdownElement.getAttribute("data-id");
    const startTime = new Date(countdownElement.getAttribute("data-starttime")).getTime();

    function updateTimer() {
        const currentTime = new Date().getTime();
        const timeRemaining = startTime - currentTime;

        if (timeRemaining > 0) {
            const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

            countdownElement.querySelector(".timer-days").innerText = days;
            countdownElement.querySelector(".timer-hours").innerText = hours;
            countdownElement.querySelector(".timer-minutes").innerText = minutes;
            countdownElement.querySelector(".timer-seconds").innerText = seconds;
        } else {
            clearInterval(timerInterval);
            countdownElement.innerHTML = "<span style='color: red;'>الوقت انتهى!</span>";

            // Update `show` field in database via AJAX
            fetch(`/update-show`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({ land_id: landId, show: 0 })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(`تم تحديث العرض بنجاح للأرض ${landId}`);
                    } else {
                        console.error(`فشل التحديث للأرض ${landId}`);
                    }
                })
                .catch(error => {
                    console.error("خطأ في الطلب:", error);
                });
        }
    }

    const timerInterval = setInterval(updateTimer, 1000);
    updateTimer(); // Call immediately to initialize
});
            </script>

            <style>
                /* الحركة الافتراضية للعناصر المخفية */
.bid_cards_content {
    opacity: 0;
    transform: translateX(100%); /* تبدأ العناصر من اليمين */
    transition: transform 1s ease-out, opacity 1s ease-out;
}

/* عند إضافة الكلاس .visible سيتم تحريك العناصر إلى اليسار وتظهر */
.bid_cards_content.visible {
    opacity: 1;
    transform: translateX(0); /* تنتقل إلى الموضع الطبيعي */
}

            </style>
            <script>// دالة للكشف عن التمرير وإظهار العناصر
                function handleScroll() {
                    // التحقق من العناصر في الصفحة
                    const cards = document.querySelectorAll('.bid_cards_content');

                    cards.forEach(card => {
                        // الحصول على المسافة بين العنصر وأعلى الصفحة
                        const cardPosition = card.getBoundingClientRect().top;
                        const windowHeight = window.innerHeight;

                        // إذا كان العنصر في شاشة المستخدم (داخل النطاق المرئي)
                        if (cardPosition < windowHeight - 100) {
                            // إضافة الكلاس "visible" لتفعيل الحركة
                            card.classList.add('visible');
                        }
                    });
                }

                // الاستماع لحدث التمرير
                window.addEventListener('scroll', handleScroll);

                // استدعاء الدالة عند تحميل الصفحة للتأكد من إضافة الحركة إذا كانت العناصر مرئية
                document.addEventListener('DOMContentLoaded', handleScroll);
                </script>
@endforeach
@else
    <p>لا توجد مزادات لعرضها.</p>
@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const countdowns = document.querySelectorAll('.countdown');

    countdowns.forEach(function (countdown) {
        const id = countdown.dataset.id;
        const startTime = new Date(countdown.dataset.starttime).getTime();

        const timerInterval = setInterval(function () {
            const now = new Date().getTime();
            const distance = startTime - now;

            if (distance < 0) {
                clearInterval(timerInterval);

                // إرسال طلب Ajax لتحديث before_show إلى 1
                updateBeforeShow();
            } else {
                // تحديث العد التنازلي
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                countdown.querySelector('.timer-days').textContent = days;
                countdown.querySelector('.timer-hours').textContent = hours;
                countdown.querySelector('.timer-minutes').textContent = minutes;
                countdown.querySelector('.timer-seconds').textContent = seconds;
            }
        }, 1000);
    });

    // دالة إرسال طلب Ajax
    function updateBeforeShow() {
        fetch('/update-before-show', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Land area updated successfully!');
                } else {
                    console.error('No matching land area found.');
                }
            })
            .catch(error => console.error('Error:', error));
    }
});

</script>

