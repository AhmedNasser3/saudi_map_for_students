<?php
namespace App\Http\Controllers\frontend\home;

use App\Http\Controllers\Controller;
use App\Models\admin\land\LandArea;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getBidders(Request $request)
    {
        $landId = $request->get('land_id'); // الحصول على land_id من query string
        $landarea = LandArea::with('bids.user')->findOrFail($landId); // استرجاع الأرض مع المزايدات والمستخدمين
        $bidders = $landarea->bids;

        // إعادة البيانات بتنسيق JSON
        return response()->json([
            'bidders' => $bidders
        ]);
    }

    public function index()
    {
        $landarea = LandArea::with('bids.user')->get(); // استرجاع جميع الأراضي مع المزايدات والمستخدمين
        return view('frontend.home.index', compact('landarea'));
    }
}
