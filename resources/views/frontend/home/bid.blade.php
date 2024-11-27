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
        var landId = button.getAttribute("data-id");
        var bidPopUp = document.querySelector(".bid_pop_up");
        var bidPopUpBg = document.querySelector(".bid_pop_up_bg");

        fetch(`/get-land-details?id=${landId}`)
            .then(response => response.json())
            .then(data => {
                document.querySelector(".bid_pop_up_land_area h3").innerText = `${data.land.area} كم`;
                document.querySelector(".bid_pop_up_land_price h3").innerText = `${data.land.starting_price} ريال`;
                document.querySelector(".bid_pop_up_land_duration h3").innerText = `${data.land.duration} أيام`;

                var bidForm = document.querySelector("#placeBidForm");
                bidForm.action = `/place-bid/${landId}`;

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

                biddersPopUp.style.display = "flex";
                biddersPopUpBg.style.display = "block";

                setTimeout(function() {
                    biddersPopUp.classList.add("show");
                }, 50);

                fetch(`/get-bidders?land_id=${landId}`)
                    .then(response => response.json())
                    .then(data => {
                        biddersList.innerHTML = "";
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
                const pollingInterval = setInterval(function() {
                    fetch(`/get-bidders?land_id=${landId}`)
                        .then(response => response.json())
                        .then(data => {
                            biddersList.innerHTML = "";
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
                }, 5000);
                document.querySelector("#closeBiddersPopUp").addEventListener("click", function() {
                    clearInterval(pollingInterval);
                    biddersPopUp.classList.remove("show");
                    setTimeout(function() {
                        biddersPopUp.style.display = "none";
                        biddersPopUpBg.style.display = "none";
                    }, 1000);
                });
            }
            document.querySelector("#closeBiddersPopUp").addEventListener("click", function() {
                var biddersPopUp = document.querySelector(".bidders_pop_up");
                var biddersPopUpBg = document.querySelector(".bidders_pop_up_bg");

                biddersPopUp.classList.remove("show");
                setTimeout(function() {
                    biddersPopUp.style.display = "none";
                    biddersPopUpBg.style.display = "none";
                }, 1000);
            });
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
