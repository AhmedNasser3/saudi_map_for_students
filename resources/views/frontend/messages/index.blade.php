<div class="message">
    <div class="message_container">
        <div class="message_data">
            <div class="message_content">
                <div class="message_title">
                    <div class="message_btns">
                        <button><a href="{{ route('message.index') }}">انشاء استشارة</a></button>
                    </div>
                    <h2>الاستشارات</h2>
                </div>
                <div class="message_body">
                    <div class="message_bg">

                        @foreach ($sends as $message)
                        <div class="message_body_title" style="background-color: {{ $message->read == 1 ? '#ffffff' : '#d6d6d6' }}">
                            <!-- البدء بنموذج Form -->
                            <form class="mark-read-form" action="{{ route('messages.markRead') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="id" value="{{ $message->id }}">
                                @if ($message->read == 0  )
                                <button disabled style="border: 1px solid #c4c2c2">
                                    <a style="color: {{ $message->read == 1 ? '#5d9c40' : '#9b9b9b' }}"  >
                                        {{ $message->read == 1 ? 'قراءة' : 'مقروءة' }}
                                    </a>
                                </button>
                                @else
                                <button type="submit" class="mark-read-btn" style="border: 1px solid #5d9c40">
                                    <a href="#" class="mark-read-link" data-id="{{ $message->id }}" style="color: {{ $message->read == 1 ? '#5d9c40' : '#9b9b9b' }}"  >
                                        {{ $message->read == 1 ? 'قراءة' : 'مقروءة' }}
                                    </a>
                                </button>
                                @endif
                            </form>
                            <!-- نهاية النموذج -->
                            <h3>
                                <a href="{{ route('message.view', ['message_id'=> $message->id]) }}" style="color: {{ $message->read == 1 ? '#5d9c40' : '#9b9b9b' }}">
                                    {{ $message->title }}
                                </a>
                            </h3>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // عند الضغط على رابط "قراءة" أو "مقروءة"
        $('.mark-read-link').click(function (e) {
            e.preventDefault(); // منع إعادة تحميل الصفحة

            var link = $(this); // الحصول على الرابط الذي تم الضغط عليه
            var messageId = link.data('id'); // استخراج معرّف الرسالة من خاصية data-id
            var currentStatus = link.text(); // الحصول على النص الحالي (قراءة / مقروءة)

            // إذا كانت الرسالة "قراءة" (أي read == 1)، نقوم بتحديثها إلى "مقروءة" (حالة read = 0)
            if (currentStatus === 'قراءة') {
                // إرسال الطلب عبر AJAX لتحديث حالة الرسالة إلى "مقروءة" (read = 0)
                $.ajax({
                    url: "{{ route('messages.markRead') }}", // المسار الخاص بالـ route
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // إرسال CSRF Token
                        id: messageId, // إرسال معرّف الرسالة
                        read: 0 // تغيير حالة الرسالة إلى "مقروءة" (read = 0)
                    },
                    success: function (response) {
                        if (response.success) {
                            // تحديث النص إلى "مقروءة" مع اللون الرمادي
                            link.css('color', '#9b9b9b').text('مقروءة');
                            link.closest('.message_body_title').css('background-color', '#ffffff'); // تحديث الخلفية
                        } else {
                            alert('حدث خطأ ما.');
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        alert('حدث خطأ أثناء تحديث الحالة.');
                    }
                });
            } else {
                // إذا كانت الرسالة "مقروءة" (أي read == 0)، نقوم بتحديثها إلى "قراءة" (حالة read = 1)
                $.ajax({
                    url: "{{ route('messages.markRead') }}", // المسار الخاص بالـ route
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // إرسال CSRF Token
                        id: messageId, // إرسال معرّف الرسالة
                        read: 1 // تغيير حالة الرسالة إلى "قراءة" (read = 1)
                    },
                    success: function (response) {
                        if (response.success) {
                            // تحديث النص إلى "قراءة" مع اللون الأخضر
                            link.css('color', '#5d9c40').text('قراءة');
                            link.closest('.message_body_title').css('background-color', '#d6d6d6'); // تحديث الخلفية
                        } else {
                            alert('حدث خطأ ما.');
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        alert('حدث خطأ أثناء تحديث الحالة.');
                    }
                });
            }
        });
    });
</script>
