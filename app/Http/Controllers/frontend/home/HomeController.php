<?php
namespace App\Http\Controllers\frontend\home;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\admin\bid\Bid;
use App\Models\admin\land\LandArea;
use App\Http\Controllers\Controller;

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
        $landarea = LandArea::with('bids.user')->get();
        return view('frontend.home.index', compact('landarea'));
    }

    public function myOffice($userId)
    {
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


}
