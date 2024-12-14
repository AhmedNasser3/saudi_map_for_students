@foreach ($landarea as $land)
    @if ($land->go == 0)
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
        <div  class="countdown" data-id="{{ $land->id }}" data-starttime="{{ $land->start_time }}">
            <h3>سوف يبدأ مزاد جديد خلال:</h3>
            <span class="timer-days">0</span> يوم
            <span class="timer-hours">0</span> ساعة
            <span class="timer-minutes">0</span> دقيقة
            <span class="timer-seconds">0</span> ثانية
        </div>

    @endif


@endforeach

<script>
document.addEventListener("DOMContentLoaded", function() {
    const csrfToken = "{{ csrf_token() }}";

    // معالجة جميع العدادات الموجودة في الصفحة
    document.querySelectorAll(".countdown-container").forEach(container => {
        const id = container.dataset.id;
        const goTime = new Date(container.dataset.goTime).getTime();

        let interval = setInterval(() => {
            const now = new Date().getTime();
            const timeRemaining = goTime - now;

            if (timeRemaining > 0) {
                updateCountdown(container, timeRemaining);
            } else {
                clearInterval(interval);

                // عرض رسالة أن العملية تم تفعيلها
                container.querySelector("h3").innerText = "تم تفعيل العملية!";
                container.querySelector("p").innerHTML = "جارٍ تحديث الحالة...";

                // إرسال تحديث AJAX لتغيير go إلى 1
                fetch('/land-areas/update-go', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        land_area_id: id  // إرسال المعرف فقط
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(`تم تحديث قيمة go إلى 1`);
                    } else {
                        console.log('فشل التحديث');
                    }
                });
            }
        }, 1000);

        // دالة لتحديث العد التنازلي
        function updateCountdown(container, timeRemaining) {
            const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

            container.querySelector(".timer-days").innerText = days;
            container.querySelector(".timer-hours").innerText = hours;
            container.querySelector(".timer-minutes").innerText = minutes;
            container.querySelector(".timer-seconds").innerText = seconds;
        }
    });
});
</script>
