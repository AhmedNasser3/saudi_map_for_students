<?php

use App\Models\admin\bid\Bid;
use App\Models\admin\land\Land;
use App\Models\admin\land\LandArea;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\ProfileController;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\admin\city\CityController;
use App\Http\Controllers\admin\user\UserController;
use App\Http\Controllers\admin\land\LandsController;
use App\Http\Controllers\admin\land\AuctionController;
use App\Http\Controllers\frontend\home\HomeController;
use App\Http\Controllers\admin\land\MainLandController;
use App\Http\Controllers\admin\land\LandAreasController;
use App\Http\Controllers\admin\landarea\MainLandAreaController;
use App\Http\Controllers\admin\add_discount\AddDiscountController;
use App\Http\Controllers\admin\add_discount\DiscountController;

Route::get('/', [HomeController::class, 'index'])->name('home.page');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/get-bidders', [HomeController::class, 'getBidders']);
Route::get('/get-land-details', [HomeController::class, 'getLandDetails']);
Route::post('/update-auction-state', action: [AuctionController::class, 'updateState']);
Route::get('/my/{user_id}/office',[HomeController::class, 'MyOffice'])->name('my.office');
Route::post('/pay-tax', [AuctionController::class, 'payTax']);
Route::post('/extend-tax-time', [AuctionController::class, 'extendTaxTime']);
Route::post('/pay-fine', [AuctionController::class, 'payFine']);




Route::get('/update-highest-bid/{landId}', function($landId) {
    $highestBid = Bid::where('land_area_id', $landId)
                     ->orderBy('bid_amount', 'desc')
                     ->first();

    if ($highestBid) {
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




Route::get('/admin/users', function(){
    return view(view: 'admin.users.add_users');
});



Route::middleware([RoleMiddleware::class.':admin'])->prefix('admin')->group(function () {
});

Route::controller(MainLandController::class)->prefix('land')->group(function(){
    Route::get('/', 'index')->name('land.page');
    Route::get('/create', 'create')->name('land.create');
    Route::post('/store', 'store')->name('land.store');
    Route::get('/edit/{land_id}/', 'edit')->name('land.edit');
    Route::put('/{land_id}/update', 'update')->name('land.update');
    Route::delete('/{land_id}/delete', 'delete')->name('land.delete');
});

Route::controller(MainLandAreaController::class)->prefix('landArea')->group(function(){
    Route::get('/', 'index')->name('landArea.page');
    Route::get('/create', 'create')->name('landArea.create');
    Route::post('/store', 'store')->name('landArea.store');
    Route::get('/edit/{landArea_id}/', 'edit')->name('landArea.edit');
    Route::put('/{landArea_id}/update', 'update')->name('landArea.update');
    Route::delete('/{landArea_id}/delete', 'delete')->name('landArea.delete');
    Route::delete('/land-area/delete-selected', action: 'deleteSelected')->name('landArea.deleteSelected');

});
Route::controller(UserController::class)->prefix('user')->group(function(){
    Route::get('/', 'index')->name('user.page');
    Route::post('/users/import',  'import')->name('user.import');
});
Route::post('/set-renew-days', action: [MainLandAreaController::class, 'setRenewDays']);
Route::post('/extend-tax-time', [MainLandAreaController::class, 'extendTaxTime']);
Route::post('/set-tax-end-time', [MainLandAreaController::class, 'updateTaxEndTime']);
Route::post('/update-show', [MainLandAreaController::class, 'updateShow'])->name('update.show');
Route::post('/finalize-auction/{landId}', [LandAreasController::class, 'finalizeAuction'])->name('finalizeAuction');
Route::post('/place-bid/{id}', [AuctionController::class, 'placeBid'])->name('placeBid');




Route::get('/add-balance', [AddDiscountController::class, 'showAdditions'])->name('add_balance.form');
Route::post('/add-balance', [AddDiscountController::class, 'addBalance'])->name('add_balance');
Route::post('/minus-balance', [DiscountController::class, 'minusBalance'])->name('minus_balance');
Route::get('/print-deed/{landId}', [HomeController::class, 'printDeed']);

require __DIR__.'/auth.php';
