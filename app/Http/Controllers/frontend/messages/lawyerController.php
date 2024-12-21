<?php

namespace App\Http\Controllers\frontend\messages;

use Illuminate\Http\Request;
use App\Models\admin\price\Price;
use App\Http\Controllers\Controller;
use App\Models\frontend\message\LawyerSend;
use App\Models\frontend\message\LawyerSent;
use App\Models\frontend\message\LawyerReplay;

class lawyerController extends Controller
{
    public function create(){
        $messages = LawyerSend::where('user_id', auth()->user()->id);
        return view('frontend.lawyerMessage.create',compact('messages'));
    }

    public function markAsRead(Request $request)
    {
        $request->validate([
'id' => 'required|integer|exists:lawyer_sends,id',
        ]);

        $message = LawyerSend::find($request->id);

        if (!$message) {
            return response()->json(['success' => false, 'message' => 'الرسالة غير موجودة.']);
        }

        $message->read = '0';
        $message->save();

        return response()->json(['success' => true, 'message' => 'تم تحديث الرسالة إلى مقروءة.']);
    }
    public function store(Request $request){
        $sends = $request->validate([
            'title' => 'required',
            'message' => 'required',
            'user_id' => 'required',
        ]);

        $balance = auth()->user()->balance;

        $pay = Price::first();

        if ($pay) {
            auth()->user()->update(['balance' => $balance - $pay->message_price]);

            $messages = LawyerSend::create($sends);

            return redirect()->route('my.office', ['user_id' => auth()->user()->id])->with('success', 'تم انشاء الرسالة');
        }

        return redirect()->back()->with('error', 'لم يتم العثور على الأسعار!');
    }
    public function view($id){
        $messages = LawyerSend::where('id', $id)->get();
    $chats = LawyerSent::where('send_id', $id)->get();
    $replays = LawyerReplay::where('send_id', $id)->get();
    $all_chats = collect($chats)
    ->merge($replays)
    ->unique()
    ->sortBy('id') // ترتيب حسب الحقل الذي تريده، مثل id
    ->values(); // إعادة ضبط المفاتيح
    $sortedItems = $all_chats->sortBy('created_at'); // ترتيب تصاعدي (الأقدم فالأحدث)

        return view('frontend.lawyerMessage.message_page', compact('messages', 'sortedItems'));
    }

    public function sendStore(Request $request)
    {
        $validated = $request->validate([
            'send_id' => 'required|exists:lawyer_sends,id',
            'text' => 'required|string',
        ]);

        // إنشاء الرسالة في جدول LawyerSent
        $chat = LawyerSent::create([
            'send_id' => $validated['send_id'],
            'text' => $validated['text'],
        ]);

        if ($chat) {
            return redirect()->back()->with('success', 'تم إرسال الرسالة بنجاح.');
        }

        return redirect()->back()->with('error', 'فشل إرسال الرسالة. حاول مرة أخرى.');
    }


    public function replayStore(Request $request)
{
    $validated = $request->validate([
        'send_id' => 'required|exists:lawyer_sents,id',
        'text' => 'required|string',
    ]);

    // إنشاء الرد في جدول LawyerReplay
    $chat = LawyerReplay::create([
        'send_id' => $validated['send_id'],
        'text' => $validated['text'],
    ]);

    if ($chat) {
        return redirect()->back()->with('success', 'تم إرسال الرد بنجاح.');
    }

    return redirect()->back()->with('error', 'فشل إرسال الرد. حاول مرة أخرى.');
}


    public function endChat($id){
        $chat = LawyerSend::find($id);
        $chat->state = 1;
        $chat->save();
        return redirect()->back();
    }

    // admin view
    public function adminView(){
        $sends = LawyerSend::all();
        return view('admin.lawyerMessage.index', data: compact('sends'));
    }
    public function adminViewChat($id){
        $messages = LawyerSend::where('id', $id)->get();
    $chats = LawyerSent::where('send_id', $id)->get();
    $replays = LawyerReplay::where('send_id', $id)->get();
    $all_chats = collect($chats)
    ->merge($replays)
    ->unique() // إزالة العناصر المكررة
    ->sortBy('id') // ترتيب حسب الحقل الذي تريده، مثل id
    ->values();
    $sortedItems = $all_chats->sortBy('created_at'); // ترتيب تصاعدي (الأقدم فالأحدث)
        return view('admin.lawyerMessage.create', compact('messages', 'sortedItems'));
    }
}