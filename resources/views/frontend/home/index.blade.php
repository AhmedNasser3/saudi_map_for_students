@extends('frontend.master')
@section('content')
@php
use App\Models\City;

@endphp
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
{{-- main --}}
<div class="map_main">
    <div class="map_main_container">
        <div class="map_main_data">
            <div class="map_main_content">
                <div class="map_container">
                    <div class="map_img_1">
                    </div>
                    <div id="container"  style=""></div>
                    <div class="map_img_2">
                    </div>
                </div>
                <div class="map_main_titles">
                    <h1>موقع مزاد السعودية</h1>
                    <p>"احصل على أرض أحلامك بسهولة من منزلك عبر أفضل موقع مزادات إلكتروني موثوق وسريع."</p>
                    <div class="map_main_btn">
                        <div class="map_main_btn_1">
                            <button><a href="#info">شاهد التعليمات</a></button>
                        </div>
                        <div class="map_main_btn_2">
                            <button><a href="#bidds">شاهد المزادات</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- banner --}}
<div class="banner">
            <main>
                <div class="slider">
                    <div class="slide-row" id="slide-row">
                        <div class="slide-col">
                            <div class="content_banner">
                                <p>انضم إلى منصتنا التعليمية المتخصصة في ورشات البرمجة، حيث نقدم لك مجموعة متنوعة من الدورات التدريبية في لغات البرمجة المختلفة. تعلم بأسلوب تفاعلي مع معلمين محترفين، واكتسب المهارات اللازمة لتطوير تطبيقات الويب، وتصميم الألعاب،
                                    وتحليل البيانات. ابدأ رحلتك البرمجية اليوم!</p>
                                <h2>1. "استكشف عالم البرمجة مع ورشاتنا"
                                </h2>
                                <p>! منصة تعلم</p>
                            </div>
                            <div class="hero">
                                <img src="https://static.majalla.com/2023-07/155311.jpeg" alt="avatar">
                            </div>
                        </div>

                        <div class="slide-col">
                            <div class="content_banner">
                                <p>سواء كنت مبتدئًا أو متمرسًا، توفر منصتنا ورشات برمجة تناسب جميع المستويات. تعرف على مفاهيم البرمجة الأساسية وتعمق في مجالات مثل تطوير البرمجيات وتعلم الآلة. احصل على تجربة تعليمية مرنة ومتاحة في أي وقت، واجعل البرمجة جزءًا
                                    من مستقبلك المهني.
                                </p>
                                <h2>2. "ورشات برمجة مخصصة للجميع"
                                </h2>
                                <p>! منصة تعلم</p>
                            </div>
                            <div class="hero">
                                <img src="https://static.majalla.com/styles/760x533/public/2023-06/153827.jpeg?h=17c83cad" alt="avatar">
                            </div>
                        </div>

                        <div class="slide-col">
                            <div class="content_banner">
                                <p>استفد من ورشات البرمجة المبتكرة على منصتنا، حيث يجتمع التعلم مع الإبداع. انضم إلينا لتطوير مشاريعك الخاصة، وتحقيق أفكارك، وتعلم أحدث التقنيات البرمجية. نحن نقدم لك الدعم والإشراف من خبراء في المجال، مما يضمن لك تجربة تعليمية
                                    ثرية ومفيدة.

                                </p>
                                <h2>3. "ابتكر وتعلم في ورشات البرمجة"
                                </h2>
                                <p>! منصة تعلم</p>
                            </div>
                            <div class="hero">
                                <img src="https://vid.alarabiya.net/images/2023/08/03/5231d837-cb0d-4aaf-b2df-4c8685b1fd43/5231d837-cb0d-4aaf-b2df-4c8685b1fd43.JPG?crop=4:3&width=1200" alt="avatar">
                            </div>
                        </div>

                        <div class="slide-col">
                            <div class="content_banner">
                                <p>انضم إلى ورشات البرمجة لدينا وابدأ رحلتك نحو تطوير مهاراتك التقنية. نقدم مجموعة متنوعة من الدورات التي تغطي كل شيء من أساسيات البرمجة إلى أحدث التقنيات. تعلم كيفية بناء تطبيقات حقيقية، وتحليل البيانات، وتطوير الألعاب، واستفد
                                    من خبرات معلمين محترفين يوجهونك خطوة بخطوة نحو تحقيق أهدافك.

                                </p>
                                <h2>4. "انطلق نحو المستقبل مع ورشات البرمجة"
                                </h2>
                                <p>! منصة تعلم</p>
                            </div>
                            <div class="hero">
                                <img src="https://static.majalla.com/styles/1200xauto/public/2023-06/154000.jpg" alt="avatar">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="indicator">
                    <span class="btn active"></span>
                    <span class="btn"></span>
                    <span class="btn"></span>
                    <span class="btn"></span>
                </div>

            </main>
        </div>
{{-- Bid --}}
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
                        <li><a href="#">جاري</a></li>
                        <li><a href="#">قادم</a></li>
                        <li><a href="#">منتهي</a></li>
                    </ul>
                </div>
                <div class="bid_cards">
                    <div class="bid_cards_container">
                        <div class="bid_cards_data">
                            @if($landarea && $landarea->count())
                            @foreach ($landarea as $land)
                            <div class="bid_cards_content">
                                <div class="bid_cards_img">
                                    <img src="https://www.auctions.com.sa/web/binary/image/?model=auction.auction&field=image&id=15760" alt="">
                                </div>
                                <div class="bid_cards_timer">
                                    <div class="bid_cards_timer_container">
                                        <div class="bid_cards_timer_title">
                                            <h3>مزايدة حالية تنتهي</h3>
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
{{-- bid pop up --}}
<div class="bid_pop_up_bg"></div> <!-- عنصر الخلفية -->
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
                                <h1>مكان الارض:</h1>
                            </div>
                            <div class="bid_pop_up_land_duration">
                                <h3></h3>
                            </div>
                        </div>
                        <div class="bid_pop_up_header_title">
                            <div class="bid_pop_up_land">
                                <h1>عدد الأمتار:</h1>
                            </div>
                            <div class="bid_pop_up_land_area">
                                <h3> كم</h3>
                            </div>
                        </div>
                        <div class="bid_pop_up_header_title">
                            <div class="bid_pop_up_land">
                                <h1>اقل سعر للمزايدة:</h1>
                            </div>
                            <div class="bid_pop_up_land_price">
                                <h3> ريال</h3>
                            </div>
                        </div>
                        <div class="bid_pop_up_inputs_btn">
                            <div class="bid_pop_up_inputs">
                                <form id="placeBidForm" action="{{ route('placeBid', $land->id) }}" method="POST">
                                    @csrf
                                    <input type="number" name="bid_amount" placeholder="ادخل سعر المزايدة" required>
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
        {{-- نافذة مشاهدة المزايدين --}}
        <div class="bidders_pop_up_bg"></div> <!-- عنصر الخلفية -->
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
                                    @if ($land->bids->count())
                                        @foreach ($land->bids as $bidder)
                                            <li>
                                                <p>اسم المزايد: {{ $bidder->user->name }}</p>
                                                <p>قيمة المزايدة: {{ $bidder->bid_amount }} ريال</p>
                                            </li>
                                        @endforeach
                                    @else
                                        <p>لا توجد مزايدات على هذه الأرض حتى الآن.</p>
                                    @endif
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
        var landId = button.getAttribute("data-id"); // استرجاع ID الأرض
        var bidPopUp = document.querySelector(".bid_pop_up");
        var bidPopUpBg = document.querySelector(".bid_pop_up_bg");

        // جلب معلومات الأرض وتحديث محتويات النافذة
        fetch(`/get-land-details?id=${landId}`)
            .then(response => response.json())
            .then(data => {
                // تحديث جميع الحقول في النافذة بناءً على البيانات القادمة من السيرفر
                document.querySelector(".bid_pop_up_land_area h3").innerText = `${data.land.area} كم`;
                document.querySelector(".bid_pop_up_land_price h3").innerText = `${data.land.starting_price} ريال`;
                document.querySelector(".bid_pop_up_land_duration h3").innerText = `${data.land.duration} أيام`;

                // تحديث action الخاص بالنموذج بناءً على ID الأرض
                var bidForm = document.querySelector("#placeBidForm");
                bidForm.action = `/place-bid/${landId}`;

                // إذا كان هناك زر داخل النموذج (مثل submit)
                var bidButton = document.querySelector("#placeBidButton");
                bidButton.setAttribute("data-id", landId); // تعيين الـ ID للأرض داخل الزر
            });

        bidPopUp.style.display = "flex";
        bidPopUpBg.style.display = "block";
        setTimeout(function() {
            bidPopUp.classList.add("show");
        }, 50);
    });
});


            // مستمع لإغلاق نافذة "عرض المزايدة"
            document.querySelector(".close_button").addEventListener("click", function() {
                var bidPopUp = document.querySelector(".bid_pop_up");
                var bidPopUpBg = document.querySelector(".bid_pop_up_bg");
                bidPopUp.classList.remove("show");
                setTimeout(function() {
                    bidPopUp.style.display = "none";
                    bidPopUpBg.style.display = "none";
                }, 1000);
            });

            // مستمع للأزرار الخاصة بـ "مشاهدة المزايدين"
            document.querySelectorAll(".bidButton2").forEach(function(button) {
                button.addEventListener("click", function() {
                    var landId = button.getAttribute("data-land-id"); // استرجاع ID الأرض
                    openBiddersPopup(landId); // جلب المزايدات للأرض المعينة عند فتح النافذة
                });
            });

            // دالة لجلب المزايدات عندما يتم فتح نافذة المزايدين لأرض معينة
            function openBiddersPopup(landId) {
                var biddersList = document.querySelector(".bidders_pop_up_title ul"); // استهداف مكان عرض المزايدين
                var biddersPopUp = document.querySelector(".bidders_pop_up");
                var biddersPopUpBg = document.querySelector(".bidders_pop_up_bg");

                // إظهار نافذة المزايدين
                biddersPopUp.style.display = "flex";
                biddersPopUpBg.style.display = "block";

                setTimeout(function() {
                    biddersPopUp.classList.add("show");
                }, 50);

                // طلب المزايدات من السيرفر
                fetch(`/get-bidders?land_id=${landId}`)
                    .then(response => response.json())
                    .then(data => {
                        biddersList.innerHTML = ""; // مسح القائمة الحالية للمزايدين
                        if (data.bidders.length > 0) {
                            data.bidders.forEach(function(bidder) {
                                var listItem = document.createElement('li');
                                listItem.innerHTML = `<p>اسم المزايد: ${bidder.user.name}</p><p>قيمة المزايدة: ${bidder.bid_amount} ريال</p>`;
                                biddersList.appendChild(listItem);
                            });
                        } else {
                            biddersList.innerHTML = "<p>لا توجد مزايدات على هذه الأرض حتى الآن.</p>";
                        }
                    });

                // تفعيل الـ Polling لجلب المزايدات بشكل دوري
                const pollingInterval = setInterval(function() {
                    fetch(`/get-bidders?land_id=${landId}`)
                        .then(response => response.json())
                        .then(data => {
                            biddersList.innerHTML = ""; // مسح القائمة الحالية للمزايدين
                            if (data.bidders.length > 0) {
                                data.bidders.forEach(function(bidder) {
                                    var listItem = document.createElement('li');
                                    listItem.innerHTML = `<p>اسم المزايد: ${bidder.user.name}</p><p>قيمة المزايدة: ${bidder.bid_amount} ريال</p>`;
                                    biddersList.appendChild(listItem);
                                });
                            } else {
                                biddersList.innerHTML = "<p>لا توجد مزايدات على هذه الأرض حتى الآن.</p>";
                            }
                        });
                }, 5000); // تحقق كل 5 ثواني للحصول على بيانات جديدة

                // إغلاق الـ Polling عند غلق النافذة
                document.querySelector("#closeBiddersPopUp").addEventListener("click", function() {
                    clearInterval(pollingInterval); // إيقاف الـ Polling
                    biddersPopUp.classList.remove("show");
                    setTimeout(function() {
                        biddersPopUp.style.display = "none";
                        biddersPopUpBg.style.display = "none";
                    }, 1000);
                });
            }

            // مستمع لإغلاق نافذة "مشاهدة المزايدين"
            document.querySelector("#closeBiddersPopUp").addEventListener("click", function() {
                var biddersPopUp = document.querySelector(".bidders_pop_up");
                var biddersPopUpBg = document.querySelector(".bidders_pop_up_bg");

                biddersPopUp.classList.remove("show");
                setTimeout(function() {
                    biddersPopUp.style.display = "none";
                    biddersPopUpBg.style.display = "none";
                }, 1000);
            });

            // مستمع للتحقق من انتهاء المزاد للأزرار الخاصة بـ "عرض المزايدة"
            document.querySelectorAll(".bidButton").forEach(function(button) {
                // استرداد وقت انتهاء المزاد من الخاصية data-endtime
                var endTime = new Date(button.getAttribute("data-endtime")).getTime();

                // تحقق من انتهاء المزاد
                var checkAuctionStatus = function() {
                    var currentTime = new Date().getTime();
                    if (currentTime >= endTime) {
                        // إذا انتهى المزاد، عدّل الزر
                        button.innerHTML = '<span style="color: #fff; font-weight: bold;">المزايدة انتهت</span>';
                        button.style.backgroundColor = "#131313";
                        button.style.pointerEvents = "none"; // تعطيل النقر
                    }
                };

                // قم بالتحقق عند تحميل الصفحة
                checkAuctionStatus();

                // تحقق كل ثانية لتحديث الزر إذا لزم الأمر
                setInterval(checkAuctionStatus, 1000);

                // إضافة مستمع للأحداث إذا كانت المزايدة لم تنتهِ
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
@endforeach
@else
    <p>لا توجد بيانات لعرضها.</p>
@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- q_a --}}
<div class="q_a" id="info">
    <div class="q_a_container">
        <div class="q_a_data">
            <div class="q_a_content">
                <div class="q_a_cards">
                    <div class="q_a_cards_container">
                        <div class="q_a_cards_header">
                            <div class="q_a_cards_header_title" onclick="toggleAccordion(this)">
                                <div class="q_a_cards_header_title_arrow">
                                    <i class="fa-solid fa-angle-down"></i>
                                </div>
                                <h1>تعليمات المزايدة</h1>
                            </div>
                            <div class="q_a_cards_footer" >
                                <div class="q_a_cards_footer_title">
                                    <p>تعد المزادات من أفضل وسائل البيع لعدة أسباب منها :

                                        تحقق المزادات مبدأ العدالة من خلال تمكين المتنافسين من المشاركة في المزاد دون تمييز .

                                        تسهم المزادات في توفير الجهد والوقت على البائع و المشتري حيث تتم المزايدة خلال وقت محدد للوصول لسعر البيع الأعلى.




                                       تعد المزادات من أفضل وسائل البيع لعدة أسباب منها :

                                        تحقق المزادات مبدأ العدالة من خلال تمكين المتنافسين من المشاركة في المزاد دون تمييز .

                                        تسهم المزادات في توفير الجهد والوقت على البائع و المشتري حيث تتم المزايدة خلال وقت محدد للوصول لسعر البيع الأعلى.</p>
                                </div>
                            </div>
                        </div>
                        <div class="q_a_cards_header">
                            <div class="q_a_cards_header_title" onclick="toggleAccordion(this)">
                                <div class="q_a_cards_header_title_arrow">
                                    <i class="fa-solid fa-angle-down"></i>
                                </div>
                                <h1>تعليمات المزايدة</h1>
                            </div>
                            <div class="q_a_cards_footer" >
                                <div class="q_a_cards_footer_title">
                                    <p>تعد المزادات من أفضل وسائل البيع لعدة أسباب منها :

                                        تحقق المزادات مبدأ العدالة من خلال تمكين المتنافسين من المشاركة في المزاد دون تمييز .

                                        تسهم المزادات في توفير الجهد والوقت على البائع و المشتري حيث تتم المزايدة خلال وقت محدد للوصول لسعر البيع الأعلى.




                                       تعد المزادات من أفضل وسائل البيع لعدة أسباب منها :

                                        تحقق المزادات مبدأ العدالة من خلال تمكين المتنافسين من المشاركة في المزاد دون تمييز .

                                        تسهم المزادات في توفير الجهد والوقت على البائع و المشتري حيث تتم المزايدة خلال وقت محدد للوصول لسعر البيع الأعلى.</p>
                                </div>
                            </div>
                        </div>
                        <div class="q_a_cards_header">
                            <div class="q_a_cards_header_title" onclick="toggleAccordion(this)">
                                <div class="q_a_cards_header_title_arrow">
                                    <i class="fa-solid fa-angle-down"></i>
                                </div>
                                <h1>تعليمات المزايدة</h1>
                            </div>
                            <div class="q_a_cards_footer" >
                                <div class="q_a_cards_footer_title">
                                    <p>تعد المزادات من أفضل وسائل البيع لعدة أسباب منها :

                                        تحقق المزادات مبدأ العدالة من خلال تمكين المتنافسين من المشاركة في المزاد دون تمييز .

                                        تسهم المزادات في توفير الجهد والوقت على البائع و المشتري حيث تتم المزايدة خلال وقت محدد للوصول لسعر البيع الأعلى.




                                       تعد المزادات من أفضل وسائل البيع لعدة أسباب منها :

                                        تحقق المزادات مبدأ العدالة من خلال تمكين المتنافسين من المشاركة في المزاد دون تمييز .

                                        تسهم المزادات في توفير الجهد والوقت على البائع و المشتري حيث تتم المزايدة خلال وقت محدد للوصول لسعر البيع الأعلى.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="q_a_title">
                    <h1>تعليمات المزايدة</h1>
                    <p>"تعرف على شروط المزايدة، طرق الدفع، خطوات التسجيل، والقيود لضمان تجربة تنافس آمنة وناجحة."</p>
                    <div class="q_a_title_btn">
                        <button><a href="#">المزيد من التعليمات</a></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (async() => {
        // Fetch Saudi Arabia map data
        const topology = await fetch(
            'https://code.highcharts.com/mapdata/countries/sa/sa-all.topo.json'
        ).then(response => response.json());

        // Data for cities with vibrant colors and emojis
        const data = [{
            'hc-key': 'sa-ri',
            name: 'الرياض 🌆',
            link: 'https://example.com/riyadh',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '#FFD700'],
                    [1, '#FF9800']
                ]
            },
            area: 'مغلقة',
            states: {
                hover: {
                    color: '#FFEB3B'
                }
            },
        }, {
            'hc-key': 'sa-mk',
            name: 'مكة المكرمة 🕋',
            link: 'https://example.com/mecca',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '#ffb99e'],
                    [1, '#FF5722']
                ]
            },
            area: '1200 كم²',
            states: {
                hover: {
                    color: '#FF7043'
                }
            },
        }, {
            'hc-key': 'sa-md',
            name: 'المدينة المنورة 🕌',
            link: 'https://example.com/madina',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '#81C784'],
                    [1, '#4CAF50']
                ]
            },
            area: 'مغلقة',
            states: {
                hover: {
                    color: '#81C784'
                }
            },
        }, {
            'hc-key': 'sa-sh',
            name: 'المنطقة الشرقية 🌊',
            link: 'https://example.com/eastern',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '#64B5F6'],
                    [1, '#2196F3']
                ]
            },
            area: '2500 كم²',
            states: {
                hover: {
                    color: '#64B5F6'
                }
            },
        }, {
            'hc-key': 'sa-as',
            name: 'عسير 🏞️',
            link: 'https://example.com/aseer',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '#CE93D8'],
                    [1, '#9C27B0']
                ]
            },
            area: 'مغلقة',
            states: {
                hover: {
                    color: '#CE93D8'
                }
            },
        }, {
            'hc-key': 'sa-ba',
            name: 'الباحة 🌳',
            link: 'https://example.com/baha',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '#AED581'],
                    [1, '#8BC34A']
                ]
            },
            area: '900 كم²',
            states: {
                hover: {
                    color: '#AED581'
                }
            },
        }, {
            'hc-key': 'sa-jf',
            name: 'الجوف 🌵',
            link: 'https://example.com/jouf',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '#FFB74D'],
                    [1, '#FF9800']
                ]
            },
            area: 'مغلقة',
            states: {
                hover: {
                    color: '#FFB74D'
                }
            },
        }, {
            'hc-key': 'sa-ha',
            name: 'حائل 🏜️',
            link: 'https://example.com/hail',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '#E57373'],
                    [1, '#F44336']
                ]
            },
            area: 'مغلقة',
            states: {
                hover: {
                    color: '#E57373'
                }
            },
        }, {
            'hc-key': 'sa-tb',
            name: 'تبوك ❄️',
            link: 'https://example.com/tabuk',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '#4FC3F7'],
                    [1, '#03A9F4']
                ]
            },
            area: 'مغلقة',
            states: {
                hover: {
                    color: '#4FC3F7'
                }
            },
        }, {
            'hc-key': 'sa-jz',
            name: 'جازان 🦀',
            link: 'https://example.com/jazan',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '#9575CD'],
                    [1, '#673AB7']
                ]
            },
            area: 'مغلقة',
            states: {
                hover: {
                    color: '#9575CD'
                }
            },
        }, {
            'hc-key': 'sa-nj',
            name: 'نجران 🌞',
            link: 'https://example.com/najran',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '#FFF176'],
                    [1, '#FFEB3B']
                ]
            },
            area: '1400 كم²',
            states: {
                hover: {
                    color: '#FFF176'
                }
            },
        }, {
            'hc-key': 'sa-qs',
            name: 'القصيم 🌾',
            link: 'https://example.com/qassim',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '#DCE775'],
                    [1, '#CDDC39']
                ]
            },
            area: 'مغلقة',
            states: {
                hover: {
                    color: '#DCE775'
                }
            },
        }, {
            'hc-key': 'sa-hs',
            name: 'الحدود الشمالية ❄️',
            link: 'https://example.com/northern',
            color: {
                radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '#4DD0E1'],
                    [1, '#00BCD4']
                ]
            },
            area: '2📏 100 كم²',
            states: {
                hover: {
                    color: '#4DD0E1'
                }
            },
        }];

        // Render the map
        Highcharts.mapChart('container', {
            chart: {
                map: topology
            },
            title: {
                text: null // Remove the title
            },
            mapNavigation: {
                enabled: false // Disable zoom and pan buttons
            },
            credits: {
                enabled: false // Disable Highcharts.com credit text
            },
            tooltip: {
                headerFormat: '',
                pointFormat: '<b>{point.name}</b><br>المساحة: {point.area}'
            },
            series: [{
                name: 'خريطة السعودية 🌟',
                data: data,
                borderColor: '#2f4f4f', // لون الحدود (زيتوني داكن)
                borderWidth: 2, // زيادة عرض الحدود
                dataLabels: {
                    enabled: true,
                    formatter: function() {
                        const point = this.point;
                        return `<a href="${point.link}" style="color: white; text-decoration: none;">
                                    ${point.name} <br> مساحة ${point.area}
                                </a>`;
                    },
                    useHTML: true
                }
            }]
        });
    })();
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const timers = document.querySelectorAll("[id^='timer-']");

    timers.forEach(timer => {
        const endTime = new Date(timer.getAttribute("data-endtime"));
        const auctionId = timer.id.split('-')[1]; // استخراج auction_id من معرف العنصر

        function updateTimer() {
            const now = new Date();
            const timeRemaining = endTime - now;

            if (timeRemaining > 0) {
                const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeRemaining % (1000 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                timer.querySelector(".days").textContent = days;
                timer.querySelector(".hours").textContent = hours;
                timer.querySelector(".minutes").textContent = minutes;
                timer.querySelector(".seconds").textContent = seconds;
            } else {
                timer.innerHTML = `<h3>المزاد انتهى</h3>`;

                // إرسال طلب AJAX لتحديث حالة المزاد
                fetch('/update-auction-state', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        auction_id: auctionId, // تمرير معرف المزاد
                        state: 0 // تغيير الحالة إلى 0
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(`تم تحديث حالة المزاد ID ${auctionId}:`, data.message);
                })
                .catch(error => {
                    console.error(`خطأ أثناء تحديث حالة المزاد ID ${auctionId}:`, error);
                });

                // إيقاف التحديث
                clearInterval(interval);
            }
        }

        // تحديث الوقت كل ثانية
        const interval = setInterval(updateTimer, 1000);
        updateTimer(); // استدعاء أولي
    });
});

</script>



<script>
    document.addEventListener("DOMContentLoaded", function() {
    // تأكد من أن جميع العناصر الخاصة بالعد التنازلي قد تم تحميلها
    const bidTimers = document.querySelectorAll('.bid_cards_timer');

    bidTimers.forEach(function(timer) {
        const endTime = timer.querySelector('ul').getAttribute('data-endtime');
        const landId = timer.closest('.bid_cards_content').dataset.landId; // الحصول على id الأرض

        const interval = setInterval(function() {
            const currentTime = new Date().getTime();
            const remainingTime = new Date(endTime).getTime() - currentTime;

            if (remainingTime <= 0) {
                clearInterval(interval);

                // تحديث highest_bid و highest_bidder_id
                fetch(`/update-highest-bid/${landId}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Updated highest bid:', data);
                    // هنا يمكنك تحديث واجهة المستخدم لعرض المزايد الفائز
                })
                .catch(error => console.error('Error:', error));
            }
        }, 1000);
    });
});

</script>
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
@endsection
