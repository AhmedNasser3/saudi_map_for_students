<?php
namespace App\Http\Controllers\frontend\home;

use TCPDF;
use Carbon\Carbon;
use setasign\Fpdi\Fpdi;
use Illuminate\Http\Request;
use App\Models\admin\bid\Bid;
use App\Models\admin\land\LandArea;
use App\Http\Controllers\Controller;
use App\Models\frontend\messages\Send;
use App\Models\admin\addition\Addition;
use App\Models\admin\discount\Discount;
use App\Models\frontend\expandArea\ExpandArea;
use App\Models\frontend\message\LawyerSend;

class HomeController extends Controller
{
    public function getLandDetails(Request $request)
    {
        $landId = $request->get('id');
        $landarea = LandArea::find($landId);

        if (!$landarea) {
            return response()->json(['error' => 'Land not found'], 404);
        }
        return response()->json([
            'land' => $landarea
        ]);
    }


    public function getBidders(Request $request)
    {
        $landId = $request->get('land_id');

        $landarea = LandArea::with('bids.user')->findOrFail($landId);

        $bidders = $landarea->bids;

        return response()->json([
            'bidders' => $bidders,
            'state' => $landarea->state
        ]);
    }
    public function index()
    {
        $user = auth()->user();
        if (auth()->check()) {
            $bids = LandArea::with('bids')
            ->whereHas('user', function ($query) {
                $query->where('id', auth()->id())
                      ->orWhereIn('id', auth()->user()->children->pluck('child_id'));
            })
            ->get();
        } else {
            $bids = LandArea::all();
        }
        foreach ($bids as $landArea) {
            foreach ($landArea->bids as $bid) {
                if ($bid->tax_end_time && now()->greaterThanOrEqualTo($bid->tax_end_time)) {
                    $bid->tax = 50;
                    $bid->save();
                }
            }
        }
        $bonusAreas = ExpandArea::all();
        $balance = auth()->check() ? auth()->user()->balance : null;
        $meters = $user ? LandArea::where('highest_bidder_id', $user->id)->sum('area') : 0;
        $landarea = LandArea::with('bids.user')->get();
        return view('frontend.home.index', compact('landarea','meters', 'balance','bids', ));
    }
    public function myOffice($userId)
    {
        $user = auth()->user();
        if ($user->id != $userId) {
            return redirect()->route('home')->with('error', 'أنت غير مخول للوصول إلى هذه الصفحة');
        }

        $bids = LandArea::with('bids')
            ->where('highest_bidder_id', $userId)
            ->get();

        foreach ($bids as $landArea) {
            foreach ($landArea->bids as $bid) {
                if ($bid->tax_end_time && now()->greaterThanOrEqualTo($bid->tax_end_time)) {
                    $bid->tax = 50;
                    $bid->save();
                }
            }
        }

        $additions = Addition::where('user_id', auth()->user()->id)->get();
        $discounts = Discount::where('user_id', auth()->user()->id)->get();

        $landAreasBids = LandArea::where('highest_bidder_id', auth()->user()->id)->get();

        $allItems = collect($landAreasBids)
            ->merge($additions)
            ->merge($discounts)
            ->unique()
            ->sortBy('id')
            ->values();
        $sortedItems = $allItems->sortByDesc('created_at');
        $sends = Send::where('user_id', auth()->user()->id)->get();
        $lawyerSends = LawyerSend::where('user_id', auth()->user()->id)->get();
        $bonusAreas = ExpandArea::all();
        return view('frontend.home.my_office', compact('bids', 'additions','discounts','sortedItems','landAreasBids','sends','lawyerSends','bonusAreas'));
    }

    public function message($userId){
        $user = auth()->user();
        if ($user->id != $userId) {
            return redirect()->route('home')->with('error', 'أنت غير مخول للوصول إلى هذه الصفحة');
        }

        $bids = LandArea::with('bids')
            ->where('highest_bidder_id', $userId)
            ->get();

        foreach ($bids as $landArea) {
            foreach ($landArea->bids as $bid) {
                if ($bid->tax_end_time && now()->greaterThanOrEqualTo($bid->tax_end_time)) {
                    $bid->tax = 50;
                    $bid->save();
                }
            }
        }

        $additions = Addition::where('user_id', auth()->user()->id)->get();
        $discounts = Discount::where('user_id', auth()->user()->id)->get();

        $landAreasBids = LandArea::where('highest_bidder_id', auth()->user()->id)->get();

        $allItems = collect($landAreasBids)
            ->merge($additions)
            ->merge($discounts)
            ->unique()
            ->sortBy('id')
            ->values();
        $sortedItems = $allItems->sortByDesc('created_at');
        $sends = Send::where('user_id', auth()->user()->id)->get();
        $lawyerSends = LawyerSend::where('user_id', auth()->user()->id)->get();
        $bonusAreas = ExpandArea::all();
        return view('frontend.messages.index', compact('bids', 'additions','discounts','sortedItems','landAreasBids','sends','lawyerSends','bonusAreas'));

    }

    public function history($userId){
        $user = auth()->user();
        if ($user->id != $userId) {
            return redirect()->route('home')->with('error', 'أنت غير مخول للوصول إلى هذه الصفحة');
        }

        $bids = LandArea::with('bids')
            ->where('highest_bidder_id', $userId)
            ->get();

        foreach ($bids as $landArea) {
            foreach ($landArea->bids as $bid) {
                if ($bid->tax_end_time && now()->greaterThanOrEqualTo($bid->tax_end_time)) {
                    $bid->tax = 50;
                    $bid->save();
                }
            }
        }

        $additions = Addition::where('user_id', auth()->user()->id)->get();
        $discounts = Discount::where('user_id', auth()->user()->id)->get();

        $landAreasBids = LandArea::where('highest_bidder_id', auth()->user()->id)->get();

        $allItems = collect($landAreasBids)
            ->merge($additions)
            ->merge($discounts)
            ->unique()
            ->sortBy('id')
            ->values();
        $sortedItems = $allItems->sortByDesc('created_at');
        $sends = Send::where('user_id', auth()->user()->id)->get();
        $lawyerSends = LawyerSend::where('user_id', auth()->user()->id)->get();
        $bonusAreas = ExpandArea::all();
        return view('frontend.home.history', compact('bids', 'additions','discounts','sortedItems','landAreasBids','sends','lawyerSends','bonusAreas'));

    }
    public function secret($userId){
        $user = auth()->user();
        if ($user->id != $userId) {
            return redirect()->route('home')->with('error', 'أنت غير مخول للوصول إلى هذه الصفحة');
        }

        $bids = LandArea::with('bids')
            ->where('highest_bidder_id', $userId)
            ->get();

        foreach ($bids as $landArea) {
            foreach ($landArea->bids as $bid) {
                if ($bid->tax_end_time && now()->greaterThanOrEqualTo($bid->tax_end_time)) {
                    $bid->tax = 50;
                    $bid->save();
                }
            }
        }

        $additions = Addition::where('user_id', auth()->user()->id)->get();
        $discounts = Discount::where('user_id', auth()->user()->id)->get();

        $landAreasBids = LandArea::where('highest_bidder_id', auth()->user()->id)->get();

        $allItems = collect($landAreasBids)
            ->merge($additions)
            ->merge($discounts)
            ->unique()
            ->sortBy('id')
            ->values();
        $sortedItems = $allItems->sortByDesc('created_at');
        $sends = Send::where('user_id', auth()->user()->id)->get();
        $lawyerSends = LawyerSend::where('user_id', auth()->user()->id)->get();
        $bonusAreas = ExpandArea::all();
        return view('frontend.products.index', data: compact('bids', 'additions','discounts','sortedItems','landAreasBids','sends','lawyerSends','bonusAreas'));

    }
    public function lawyer($userId){
        $user = auth()->user();
        if ($user->id != $userId) {
            return redirect()->route('home')->with('error', 'أنت غير مخول للوصول إلى هذه الصفحة');
        }

        $bids = LandArea::with('bids')
            ->where('highest_bidder_id', $userId)
            ->get();

        foreach ($bids as $landArea) {
            foreach ($landArea->bids as $bid) {
                if ($bid->tax_end_time && now()->greaterThanOrEqualTo($bid->tax_end_time)) {
                    $bid->tax = 50;
                    $bid->save();
                }
            }
        }

        $additions = Addition::where('user_id', auth()->user()->id)->get();
        $discounts = Discount::where('user_id', auth()->user()->id)->get();

        $landAreasBids = LandArea::where('highest_bidder_id', auth()->user()->id)->get();

        $allItems = collect($landAreasBids)
            ->merge($additions)
            ->merge($discounts)
            ->unique()
            ->sortBy('id')
            ->values();
        $sortedItems = $allItems->sortByDesc('created_at');
        $sends = Send::where('user_id', auth()->user()->id)->get();
        $lawyerSends = LawyerSend::where('user_id', auth()->user()->id)->get();
        $bonusAreas = ExpandArea::all();
        return view('frontend.lawyerMessage.index', data: compact('bids', 'additions','discounts','sortedItems','landAreasBids','sends','lawyerSends','bonusAreas'));

    }
    public function beard($userId){
        $user = auth()->user();
        if ($user->id != $userId) {
            return redirect()->route('home')->with('error', 'أنت غير مخول للوصول إلى هذه الصفحة');
        }

        $bids = LandArea::with('bids')
            ->where('highest_bidder_id', $userId)
            ->get();

        foreach ($bids as $landArea) {
            foreach ($landArea->bids as $bid) {
                if ($bid->tax_end_time && now()->greaterThanOrEqualTo($bid->tax_end_time)) {
                    $bid->tax = 50;
                    $bid->save();
                }
            }
        }

        $additions = Addition::where('user_id', auth()->user()->id)->get();
        $discounts = Discount::where('user_id', auth()->user()->id)->get();

        $landAreasBids = LandArea::where('highest_bidder_id', auth()->user()->id)->get();

        $allItems = collect($landAreasBids)
            ->merge($additions)
            ->merge($discounts)
            ->unique()
            ->sortBy('id')
            ->values();
        $sortedItems = $allItems->sortByDesc('created_at');
        $sends = Send::where('user_id', auth()->user()->id)->get();
        $lawyerSends = LawyerSend::where('user_id', auth()->user()->id)->get();
        $bonusAreas = ExpandArea::all();
        $user = auth()->user();
        $balance = auth()->check() ? auth()->user()->balance : null;
        $meters = $user ? LandArea::where('highest_bidder_id', $user->id)->sum('area') : 0;
        $landarea = LandArea::with('bids.user')->get();
        return view('frontend.beard.index', data: compact('bids', 'additions','discounts','sortedItems','landAreasBids','sends','lawyerSends','bonusAreas','landarea'));

    }
    public function rate($userId){
        $user = auth()->user();
        if ($user->id != $userId) {
            return redirect()->route('home')->with('error', 'أنت غير مخول للوصول إلى هذه الصفحة');
        }

        $bids = LandArea::with('bids')
            ->where('highest_bidder_id', $userId)
            ->get();

        foreach ($bids as $landArea) {
            foreach ($landArea->bids as $bid) {
                if ($bid->tax_end_time && now()->greaterThanOrEqualTo($bid->tax_end_time)) {
                    $bid->tax = 50;
                    $bid->save();
                }
            }
        }
        $additions = Addition::where('user_id', auth()->user()->id)->get();
        $discounts = Discount::where('user_id', auth()->user()->id)->get();

        $landAreasBids = LandArea::where('highest_bidder_id', auth()->user()->id)->get();

        $allItems = collect($landAreasBids)
            ->merge($additions)
            ->merge($discounts)
            ->unique()
            ->sortBy('id')
            ->values();
        $sortedItems = $allItems->sortByDesc('created_at');
        $sends = Send::where('user_id', auth()->user()->id)->get();
        $lawyerSends = LawyerSend::where('user_id', auth()->user()->id)->get();
        $bonusAreas = ExpandArea::all();
        $user = auth()->user();
        $balance = auth()->check() ? auth()->user()->balance : null;
        $meters = $user ? LandArea::where('highest_bidder_id', $user->id)->sum('area') : 0;
        $landarea = LandArea::with('bids.user')->get();
        return view('frontend.beard.rate.index', data: compact('bids', 'additions','discounts','sortedItems','landAreasBids','sends','lawyerSends','bonusAreas','landarea'));

    }
    public function land($userId){
        $user = auth()->user();
        if ($user->id != $userId) {
            return redirect()->route('home')->with('error', 'أنت غير مخول للوصول إلى هذه الصفحة');
        }

        $bids = LandArea::with('bids')
            ->where('highest_bidder_id', $userId)
            ->get();

        foreach ($bids as $landArea) {
            foreach ($landArea->bids as $bid) {
                if ($bid->tax_end_time && now()->greaterThanOrEqualTo($bid->tax_end_time)) {
                    $bid->tax = 50;
                    $bid->save();
                }
            }
        }
        $additions = Addition::where('user_id', auth()->user()->id)->get();
        $discounts = Discount::where('user_id', auth()->user()->id)->get();

        $landAreasBids = LandArea::where('highest_bidder_id', auth()->user()->id)->get();

        $allItems = collect($landAreasBids)
            ->merge($additions)
            ->merge($discounts)
            ->unique()
            ->sortBy('id')
            ->values();
        $sortedItems = $allItems->sortByDesc('created_at');
        $sends = Send::where('user_id', auth()->user()->id)->get();
        $lawyerSends = LawyerSend::where('user_id', auth()->user()->id)->get();
        $bonusAreas = ExpandArea::all();
        $user = auth()->user();
        $balance = auth()->check() ? auth()->user()->balance : null;
        $meters = $user ? LandArea::where('highest_bidder_id', $user->id)->sum('area') : 0;
        $landarea = LandArea::with('bids.user')->get();
        return view('frontend.home.lands', data: compact('bids', 'additions','discounts','sortedItems','landAreasBids','sends','lawyerSends','bonusAreas','landarea'));

    }

    public function printDeed($landId)
    {
        $user = auth()->user();
        $landArea = LandArea::with('bids')->find($landId);

        if (!$landArea) {
            return redirect()->route('home')->with('error', 'Land not found');
        }

        $imagePath = public_path('images/صك البورصة copy.jpg');

        if (!file_exists($imagePath)) {
            return redirect()->route('home')->with('error', 'Image not found');
        }

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->AddPage();

        $pdf->Image($imagePath, 0, 0, 235, 297, 'JPG');

        $fontPath = public_path('fonts/Amiri-Regular.ttf');

        $pdf->SetFont('freeserif', '', 14);
        $pdf->SetTextColor(69, 151, 80);

        $pdf->SetRTL(true);

        $pdf->SetXY(62, 130);
        $text1 = $landArea->land_deed;
        $pdf->MultiCell(0, 10, $text1, 0, 'R');

        $pdf->SetXY(62, 138.5);
        $text2 = $landArea->area;
        $pdf->MultiCell(0, 10, $text2, 0, 'R');

        $pdf->SetXY(62, 147.5);
        $text3 = $landArea->land->name;
        $pdf->MultiCell(0, 10, $text3, 0, 'R');

        // استخراج أكبر قيمة bid_amount
        if ($landArea->bids->isNotEmpty()) {
            $maxBid = $landArea->bids->max('bid_amount'); // العثور على أكبر عرض
        } else {
            $maxBid = null;
        }

        if ($maxBid) {
            // عرض أكبر عرض فقط
            $pdf->SetXY(62, 157);
            $text4 = $maxBid;
            $pdf->MultiCell(0, 10, $text4, 0, 'R'); // الكتابة من اليمين لليسار
        }

        // إضافة باقي المعلومات مثل المشتري وتاريخ العرض بناءً على أكبر عرض
        $text5 = $user->name;
        $pdf->SetXY(62, 119.5);
        $pdf->MultiCell(0, 10,  $text5, 0, 'R');

        $text6 = now()->toDateString();
        $pdf->SetXY(62, 199.5);
        $pdf->MultiCell(0, 10, $text6, 0, 'R');

        // إخراج PDF
        return response($pdf->Output('deed.pdf', 'D'), 200)->header('Content-Type', 'application/pdf');
    }
}
