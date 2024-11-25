<?php

use App\Models\admin\bid\Bid;
use App\Models\admin\land\LandArea;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\admin\city\CityController;
use App\Http\Controllers\admin\land\LandsController;
use App\Http\Controllers\admin\land\AuctionController;
use App\Http\Controllers\frontend\home\HomeController;
use App\Http\Controllers\admin\land\LandAreasController;
use App\Models\admin\land\Land;

Route::get('/', [HomeController::class, 'index'])->name('home.page');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(LandsController::class)->prefix('land')->group(function(){
    Route::get('/', 'index')->name('admin.land.page');
    Route::get('/create', 'create')->name('admin.land.create');
    Route::post('/store', 'store')->name('admin.land.store');
    Route::get('/edit', 'edit')->name('admin.land.edit');
    Route::put('/update', 'update')->name('admin.land.update');
    Route::delete('/delete', 'delete')->name('admin.land.delete');
});

Route::post('/finalize-auction/{landId}', [LandAreasController::class, 'finalizeAuction'])->name('finalizeAuction');
Route::post('/place-bid/{id}', [AuctionController::class, 'placeBid'])->name('placeBid');

Route::get('/update-highest-bid/{landId}', function($landId) {
    // احصل على أعلى عرض تم وضعه للأرض
    $highestBid = Bid::where('land_area_id', $landId)
                     ->orderBy('bid_amount', 'desc')
                     ->first();

    if ($highestBid) {
        // تحديث highest_bid و highest_bidder_id
        $landArea = LandArea::find($landId);
        $landArea->highest_bid = $highestBid->bid_amount;
        $landArea->highest_bidder_id = $highestBid->user_id;
        $landArea->save();

        return response()->json([
            'highest_bid' => $highestBid->bid_amount,
            'highest_bidder_id' => $highestBid->user_id
        ]);
    }

    return response()->json([
        'message' => 'No bids found'
    ], 404);
});
Route::get('/get-bidders', [HomeController::class, 'getBidders']);
Route::get('/get-land-details', [HomeController::class, 'getLandDetails']);
Route::post('/update-auction-state', action: [AuctionController::class, 'updateState']);
Route::get('/my/{user_id}/office',[HomeController::class, 'MyOffice'])->name('my.office');
Route::post('/pay-tax', [AuctionController::class, 'payTax']);
Route::post('/extend-tax-time', [AuctionController::class, 'extendTaxTime']);

require __DIR__.'/auth.php';
