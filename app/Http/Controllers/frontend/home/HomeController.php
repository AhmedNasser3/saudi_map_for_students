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

        // استرجاع الأرض مع المزايدات والمستخدمين المرتبطين بها
        $landarea = LandArea::with('bids.user')->findOrFail($landId);

        // الحصول على المزايدات الخاصة بالأرض
        $bidders = $landarea->bids;

        // إعادة البيانات بتنسيق JSON مع تضمين معلومات المستخدمين
        return response()->json([
            'bidders' => $bidders
        ]);
    }

    public function getLandDetails(Request $request)
    {
        $landId = $request->get('land_id'); // الحصول على land_id من query string

        // استرجاع الأرض باستخدام landId
        $land = LandArea::findOrFail($landId);

        // إعادة البيانات بتنسيق JSON
        return response()->json([
            'land' => $land
        ]);
    }

    public function index()
    {
        $landarea = LandArea::with('bids.user')->get(); // استرجاع جميع الأراضي مع المزايدات والمستخدمين
        return view('frontend.home.index', compact('landarea'));
    }
}
