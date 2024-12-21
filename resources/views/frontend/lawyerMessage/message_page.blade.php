@extends('frontend.master')
@section('content')
<div class="message_box">
    <div class="message_box_container">
        <div class="message_box_data">
            <div class="message_box_content">
                <div class="message_box_title">
                    <h2>القضايا</h2>
                    <div class="message_box_title_btn">
                        @foreach ($messages as $message)
                        <form action="{{ route('lawyerMessage.end.chat', $message->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            @if ($message->state == 0)
                            <button type="submit" class="btn btn-danger">إنهاء القضية</button>
                            @else
                            <button type="submit" class="btn btn-danger" disabled>تم إنهاء القضية</button>
                            @endif
                        </form>
                        @endforeach
                    </div>
                </div>
                <div class="message_box_body">
                    <div class="message_box_bg">
                        <div class="message_box_bg_text">
                            @foreach ($messages as $message)
                            <h1>{{ $message->title }}</h1>
                            <p>{{ $message->message }}</p>
                            @endforeach
                        </div>
                        <div class="chat-container">
                            @foreach ($sortedItems as $chat)
                            <div class="chat-message {{ $chat instanceof \App\Models\frontend\message\LawyerSent ? 'sent' : 'replay' }}">
                                <p>{{ $chat->text }}</p>
                                <small>{{ $chat->created_at->format('h:i A') }}</small>
                            </div>
                            @endforeach
                        </div>
                        @if ($message->state == 0)
                        <form action="{{ route('lawyerMessage.sendStore') }}" method="post" class="chat-form">
                            @csrf
                            <input type="hidden" name="send_id" value="{{ $message->id }}">
                            <input type="text" name="text" placeholder="اكتب رسالتك هنا..." required>
                            <button type="submit">إرسال</button>
                        </form>
                        @else
                        <form class="chat-form">
                            <input disabled type="hidden" name="send_id" value="{{ $message->id }}">
                            <input disabled type="text" value="تم إنهاء القضية" style="text-align: center" placeholder="لا يمكن إرسال رسائل">
                            <button disabled hidden>تم الإنهاء</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .chat-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        max-width: 600px;
        margin: auto;
    }

    .chat-message {
        padding: 10px;
        border-radius: 10px;
        max-width: 70%;
        position: relative;
    }

    .chat-message.sent {
        align-self: flex-end;
        background-color: #d1f7d1;
    }

    .chat-message.replay {
        align-self: flex-start;
        background-color: #f1f1f1;
    }

    .chat-message small {
        display: block;
        font-size: 12px;
        color: #888;
        text-align: right;
    }

    .chat-form {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .chat-form input {
        flex: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .chat-form button {
        padding: 10px 20px;
        border: none;
        background-color: #4caf50;
        color: white;
        border-radius: 5px;
        cursor: pointer;
    }

    .chat-form button:hover {
        background-color: #45a049;
    }
</style>
<script>
    $(document).ready(function () {
        $('.chat-form').on('submit', function (e) {
            e.preventDefault();

            let form = $(this);
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function (response) {
                    if (response.success) {
                        $('.chat-container').append(`
                            <div class="chat-message sent">
                                <p>${response.text}</p>
                                <small>${response.created_at}</small>
                            </div>
                        `);
                        form.find('input[name="text"]').val('');
                    } else {
                        alert('حدث خطأ أثناء إرسال الرسالة.');
                    }
                },
                error: function () {
                    alert('حدث خطأ أثناء إرسال الرسالة.');
                }
            });
        });
    });

</script>
@endsection
