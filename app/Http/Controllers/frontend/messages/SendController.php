<?php

namespace App\Http\Controllers\frontend\messages;

use App\Http\Controllers\Controller;
use App\Models\admin\price\Price;
use App\Models\admin\replay\Replay;
use App\Models\frontend\message\Message_User;
use App\Models\frontend\message\messageuser;
use App\Models\frontend\messages\Send;
use App\Models\frontend\messages\Sent;
use Illuminate\Http\Request;

class SendController extends Controller
{
    public function create(){
        $messages = Send::where('user_id', auth()->user()->id);
        return view('frontend.messages.create',compact('messages'));
    }
    public function store(Request $request){
        $sends = $request->validate([
            'title' => 'required',
            'message' => 'required',
            'user_id' => 'required',
        ]);

        // الحصول على رصيد المستخدم
        $balance = auth()->user()->balance;

        // الحصول على السعر من الجدول (أول سجل أو يمكن تخصيص الاستعلام إذا كان لديك عدة سجلات)
        $pay = Price::first(); // استخدم first() للحصول على أول سجل أو يمكنك تخصيص الاستعلام

        // التأكد من وجود سجل للسعر
        if ($pay) {
            // تحديث رصيد المستخدم
            auth()->user()->update(['balance' => $balance - $pay->message_price]);

            // إنشاء الرسالة
            $messages = Send::create($sends);

            return redirect()->route('my.office', ['user_id' => auth()->user()->id])->with('success', 'تم انشاء الرسالة');
        }

        // في حال عدم وجود سجل للسعر
        return redirect()->back()->with('error', 'لم يتم العثور على الأسعار!');
    }


    public function markAsRead(Request $request)
    {
        // التحقق من البيانات
        $request->validate([
            'id' => 'required|integer|exists:sends,id',
        ]);

        // جلب الرسالة المطلوبة
        $message = Send::find($request->id);

        if (!$message) {
            return response()->json(['success' => false, 'message' => 'الرسالة غير موجودة.']);
        }

        // تحديث حالة الرسالة إلى مقروءة
        $message->read = '0'; // 0 تعني مقروءة
        $message->save();

        return response()->json(['success' => true, 'message' => 'تم تحديث الرسالة إلى مقروءة.']);
    }

    public function view($id){
        $messages = Send::where('id', $id)->get();
    $chats = Sent::where('send_id', $id)->get();
    $replays = Replay::where('send_id', $id)->get();
    $all_chats = collect($chats)
    ->merge($replays)
    ->unique() // إزالة العناصر المكررة
    ->sortBy('id') // ترتيب حسب الحقل الذي تريده، مثل id
    ->values(); // إعادة ضبط المفاتيح
    $sortedItems = $all_chats->sortBy('created_at'); // ترتيب تصاعدي (الأقدم فالأحدث)

        return view('frontend.messages.message_page', compact('messages', 'sortedItems'));
    }


    public function sendStore(Request $request)
    {
        $chat = $request->validate([
            'send_id' => 'required|exists:sends,id',
            'text' => 'required|string',
        ]);

        $chat = Sent::create($chat);

        if ($chat) {
            return redirect()->back()->with('success', 'تم إرسال الرسالة بنجاح.');
        }
        return redirect()->back()->with('error', 'فشل إرسال الرسالة. حاول مرة أخرى.');
    }
    public function replayStore(Request $request)
    {
        $chat = $request->validate([
            'send_id' => 'required|exists:sends,id',
            'text' => 'required|string',
        ]);

        $chat = Replay::create($chat);
        if ($chat) {
            return redirect()->back()->with('success', 'تم إرسال الرسالة بنجاح.');
        }

        return redirect()->back()->with('error', 'فشل إرسال الرسالة. حاول مرة أخرى.');
    }

    public function endChat($id){
        $chat = Send::find($id);
        $chat->state = 1;
        $chat->save();
        return redirect()->back();
    }

    // amin viev
    public function adminView(){
        $sends = Send::all();
        return view('admin.messages.index', data: compact('sends'));
    }

    public function adminViewChat($id){
        $messages = Send::where('id', $id)->get();
    $chats = Sent::where('send_id', $id)->get();
    $replays = Replay::where('send_id', $id)->get();
    $all_chats = collect($chats)
    ->merge($replays)
    ->unique() // إزالة العناصر المكررة
    ->sortBy('id') // ترتيب حسب الحقل الذي تريده، مثل id
    ->values(); // إعادة ضبط المفاتيح
    $sortedItems = $all_chats->sortBy('created_at'); // ترتيب تصاعدي (الأقدم فالأحدث)

        return view('admin.messages.create', compact('messages', 'sortedItems'));
    }

}
