@foreach ($landarea as $land)
    @if ($land->go == 1)
        <!-- العد التنازلي لوقت go_time -->
        <div hidden class="countdown-container" data-id="{{ $land->id }}" data-go-time="{{ $land->go_time }}">
            <h3>سيتم تفعيل العملية في:</h3>
            <p>
                <span class="timer-days">0</span> يوم
                <span class="timer-hours">0</span> ساعة
                <span class="timer-minutes">0</span> دقيقة
                <span class="timer-seconds">0</span> ثانية
            </p>
        </div>
    @else
    <div class="bid_cards_content">
        <div class="bid_cards_img">
            <img src="{{ asset('images/soul.jpeg') }}" alt="">
        </div>
        <div class="bid_cards_timer">
            <div class="bid_cards_timer_container">
                <div class="bid_cards_timer_title">
                    <h3>مزاد سوف يبدأ بعد :</h3>
                </div>
                <div class="bid_cards_timer_body">
                    <ul class="countdown" data-id="{{ $land->id }}" data-starttime="{{ $land->start_time }}">
                        <li>
                            <div class="bid_cards_timer_body_text">
                                <h3 class="timer-days">0</h3>
                                <p>يوم</p>
                            </div>
                        </li>
                        <li>
                            <div class="bid_cards_timer_body_text">
                                <h3 class="timer-hours">0</h3>
                                <p>ساعة</p>
                            </div>
                        </li>
                        <li>
                            <div class="bid_cards_timer_body_text">
                                <h3 class="timer-minutes">0</h3>
                                <p>دقيقة</p>
                            </div>
                        </li>
                        <li>
                            <div class="bid_cards_timer_body_text">
                                <h3 class="timer-seconds">0</h3>
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
            </ul>
        </div>
        <div class="bid_cards_btns">
            <div class="bid_cards_btns_container">
                <button class="bidButton" data-endtime="{{ $land->auction_end_time }}" data-id="{{ $land->id }}" style="color: #a0a0a0">مزايدة</button>
                <div class="bid_cards_btns_2">
                    <button class="bidButton2" data-endtime="{{ $land->auction_end_time }}" data-land-id="{{ $land->id }}" style="color: #a0a0a0; font-size:1.1rem; cursor: pointer;">مشاهدة المزايدين</button>
                </div>
            </div>
        </div>
    </div>

    @endif

@endforeach

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get all countdown containers
        const countdownContainers = document.querySelectorAll(".countdown-container");

        countdownContainers.forEach((container) => {
            const goTime = new Date(container.getAttribute("data-go-time")).getTime();
            const landId = container.getAttribute("data-id");

            const interval = setInterval(() => {
                const now = new Date().getTime();
                const distance = goTime - now;

                if (distance <= 0) {
                    clearInterval(interval);

                    // AJAX request to update go to 0
                    fetch("/update-go-status", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({ id: landId }),
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                console.log(`Land ID ${landId} updated successfully.`);
                                container.style.display = "none"; // Hide the countdown container
                            } else {
                                console.error(`Failed to update Land ID ${landId}.`);
                            }
                        })
                        .catch((error) => console.error("Error:", error));
                } else {
                    // Update countdown display (optional if the container is hidden)
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    container.querySelector(".timer-days").textContent = days;
                    container.querySelector(".timer-hours").textContent = hours;
                    container.querySelector(".timer-minutes").textContent = minutes;
                    container.querySelector(".timer-seconds").textContent = seconds;
                }
            }, 1000);
        });
    });


</script>
