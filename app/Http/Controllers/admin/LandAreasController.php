<?php

namespace App\Http\Controllers\admin\land;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\admin\bid\Bid;
use App\Jobs\ProcessAuctionEnd;
use App\Models\admin\land\Land;
use App\Models\admin\land\LandArea;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;

class LandAreasController extends Controller
{
    public function finalizeAuction($landAreaId)
{
        $landArea = LandArea::find($landAreaId);

    if ($landArea->auction_end_time < now()) {
        $highestBid = Bid::where('land_area_id', $landAreaId)
                         ->orderByDesc('bid_amount')
                         ->first();

        if ($highestBid) {
            $user = User::find($highestBid->user_id);
            if ($user->balance >= $highestBid->bid_amount) {
                $user->balance -= $highestBid->bid_amount;
                $user->save();
                $landArea->highest_bid = $highestBid->bid_amount;
                $landArea->highest_bidder_id = $user->id;
                $landArea->save();
            }
        }
    }
}


public function index(){
    $landAreas = LandArea::all();
}
public function create(){}
public function store(Request $request){
    $LandsArea = $request->validate([
        'land_id' => 'required|exists:lands,id',
        'area' => 'required|numeric',
        'starting_price' => 'required|numeric',
        'auction_end_time' => 'required|date',
        'user_id' => 'nullable|exists:users,id',
        'final_price' => 'nullable|numeric',
        'day' => 'required|string',
        'duration' => 'required|string',
    ]);
    if ($request->hasFile('img')) {
        $path = $request->file('img')->store('images/land_areas', 'public');
        $validated['img'] = $path;
    }
$landArea = LandArea::create($LandsArea);
ProcessAuctionEnd::dispatch($landArea->id)
    ->delay(Carbon::parse($landArea->auction_end_time));
}
public function  edit($landArea){
    $landArea = LandArea::find($landArea);

}
public function update(Request $request, $LandsArea)
{
$landArea = LandArea::findOrFail($LandsArea);

$validated = $request->validate([
    'land_id' => 'required|exists:lands,id',
    'area' => 'required|numeric',
    'starting_price' => 'required|numeric',
    'auction_end_time' => 'required|date',
    'user_id' => 'nullable|exists:users,id',
    'final_price' => 'nullable|numeric',
    'day' => 'required|string',
    'duration' => 'required|string',
]);
if ($request->hasFile('img')) {
    if ($landArea->img && \Storage::disk('public')->exists($landArea->img)) {
        \Storage::disk('public')->delete($landArea->img);
    }
    $path = $request->file('img')->store('images/land_areas', 'public');
    $validated['img'] = $path;
}
$landArea->update($validated);
}
public function delete($LandsArea)
{
$landArea = LandArea::findOrFail($LandsArea);

$landArea->delete();

return response()->json(['message' => 'Land area deleted successfully.'], 200);
}
}
