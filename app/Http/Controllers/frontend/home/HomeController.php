<?php
namespace App\Http\Controllers\frontend\home;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\admin\bid\Bid;
use App\Models\admin\land\LandArea;
use App\Http\Controllers\Controller;
use TCPDF;
use setasign\Fpdi\Fpdi;

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
            'bidders' => $bidders
        ]);
    }
    public function index()
    {
        $user = auth()->user();
        $balance = auth()->check() ? auth()->user()->balance : null;
        $meters = $user ? LandArea::where('highest_bidder_id', $user->id)->sum('area') : 0;
        $landarea = LandArea::with('bids.user')->get();
        return view('frontend.home.index', compact('landarea','meters', 'balance'));
    }

    public function myOffice($userId)
    {
        $user = auth()->user(); // الحصول على المستخدم الحالي
        if ($user->id != $userId) {
            return redirect()->route('home')->with('error', 'أنت غير مخول للوصول إلى هذه الصفحة');
        }

        $bids = LandArea::with('bids')
            ->where('highest_bidder_id', $userId)
            ->get();

        foreach ($bids as $landArea) {
            foreach ($landArea->bids as $bid) {
                // إذا كان هناك وقت متبقي في tax_end_time
                if ($bid->tax_end_time && now()->greaterThanOrEqualTo($bid->tax_end_time)) {
                    // فرض غرامة إذا انتهى الوقت
                    $bid->tax = 100; // الغرامة 100 ريال
                    $bid->save();
                }
            }
        }

        return view('frontend.home.my_office', compact('bids'));
    }



    public function printDeed($landId)
    {
        $user = auth()->user();
        $landArea = LandArea::with('bids')->find($landId);

        if (!$landArea) {
            return redirect()->route('home')->with('error', 'Land not found');
        }

        // تحميل الصورة
        $imagePath = public_path('images/صك البورصة copy.jpg'); // استبدل بالمسار الصحيح للصورة

        // التحقق إذا كانت الصورة موجودة
        if (!file_exists($imagePath)) {
            return redirect()->route('home')->with('error', 'Image not found');
        }

        // إعداد TCPDF
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->AddPage();

        // إضافة الصورة
        $pdf->Image($imagePath, 0, 0, 235, 297, 'JPG'); // أبعاد الصورة وتنسيقها حسب الحجم المطلوب

        $fontPath = public_path('fonts/Amiri-Regular.ttf');  // تأكد من أن الخط موجود

        $pdf->SetFont('freeserif', '', 14); // اختيار خط مناسب
        $pdf->SetTextColor(0, 0, 0); // تحديد لون النص

        $pdf->SetRTL(true);

        $pdf->SetXY(50, 50); // تحديد مكان النص
        $text1 = 'صك الأرض: ' . $landArea->land_deed;
        $pdf->MultiCell(0, 10, $text1, 0, 'R'); // الكتابة من اليمين لليسار

        $pdf->SetXY(50, 70);
        $text2 = 'المساحة: ' . $landArea->area . ' متر مربع';
        $pdf->MultiCell(0, 10, $text2, 0, 'R');

        $pdf->SetXY(50, 90);
        $text3 = 'العنوان: ' . $landArea->land->name;
        $pdf->MultiCell(0, 10, $text3, 0, 'R');

        $yPosition = 120;
        foreach ($landArea->bids as $key => $bid) {
            $text4 = 'المبلغ: ' . $bid->bid_amount;
            $text5 = 'اسم المشتري: ' . $user->name;
            $text6 = 'تاريخ العرض: ' . now()->toDateString();

            $pdf->SetXY(50, $yPosition);
            $pdf->MultiCell(0, 10, $text4, 0, 'R'); // الكتابة من اليمين لليسار

            $pdf->SetXY(50, $yPosition + 10);
            $pdf->MultiCell(0, 10, $text5, 0, 'R');

            $pdf->SetXY(50, $yPosition + 20);
            $pdf->MultiCell(0, 10, $text6, 0, 'R');

            // زيادة الـ Y لإضافة العروض التالية
            $yPosition += 40;
        }

        // إخراج PDF
        return response($pdf->Output('S'), 200)->header('Content-Type', 'application/pdf');
    }

}
