@foreach ($landarea as $land)
        <!-- العد التنازلي لوقت go_time -->
        <div hidden class="countdown-container" data-id="{{ $land->id }}" data-stop-time="{{ $land->stop_time }}">
            <h3>سيتم تفعيل العملية في:</h3>
            <p>
                <span class="timer-days">0</span> يوم
                <span class="timer-hours">0</span> ساعة
                <span class="timer-minutes">0</span> دقيقة
                <span class="timer-seconds">0</span> ثانية
            </p>
        </div>

@endforeach

<script>
document.addEventListener("DOMContentLoaded", function() {
    const csrfToken = "{{ csrf_token() }}";

    // معالجة جميع العدادات الموجودة في الصفحة
    document.querySelectorAll(".countdown-container").forEach(container => {
        const id = container.dataset.id;
        const stopTime = new Date(container.dataset.stopTime).getTime();

        let interval = setInterval(() => {
            const now = new Date().getTime();
            const timeRemaining = stopTime - now;

            if (timeRemaining > 0) {
                updateCountdown(container, timeRemaining);
            } else {
                clearInterval(interval);

                // إرسال طلب AJAX لتحديث الحقل stop إلى 1 عندما ينتهي الوقت
                fetch('/land-areas/update-stop', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        // إرسال بيانات الـ ID والوقت
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(`تم تحديث قيمة stop إلى 1`);
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
