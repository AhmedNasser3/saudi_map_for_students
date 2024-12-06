<?php

use App\Models\admin\bid\Bid;
use App\Models\admin\land\Land;
use App\Models\admin\land\LandArea;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\role\RoleMiddleware;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\admin\tax\TaxController;
use App\Http\Controllers\admin\city\CityController;
use App\Http\Controllers\admin\user\UserController;
use App\Http\Controllers\admin\land\LandsController;
use App\Http\Controllers\admin\land\AuctionController;
use App\Http\Controllers\frontend\home\HomeController;
use App\Http\Controllers\admin\estate\EstateController;
use App\Http\Controllers\admin\land\MainLandController;
use App\Http\Controllers\admin\land\LandAreasController;
use App\Http\Controllers\frontend\messages\SendController;
use App\Http\Controllers\admin\add_discount\DiscountController;
use App\Http\Controllers\admin\landarea\MainLandAreaController;
use App\Http\Controllers\admin\add_discount\AddDiscountController;
use App\Http\Controllers\admin\price\PriceController;
use App\Http\Controllers\frontend\messages\lawyerController;

use App\Http\Controllers\frontend\product\ProductController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// ========================================================== Home Controller ==========================================================
Route::controller(HomeController::class)->group(function(){
    Route::get('/',  'index')->name('home.page');
    Route::get('/get-bidders',  'getBidders');
    Route::get('/get-land-details',  'getLandDetails');
    Route::get('/my/{user_id}/office', 'MyOffice')->name('my.office');
    Route::get('/print-deed/{landId}',  'printDeed');
});
// ========================================================== AuctionController Controller ==========================================================
Route::controller(AuctionController::class)->group(function(){
    Route::post('/update-auction-state',   'updateState');
    Route::post('/pay-tax',  'payTax');
    Route::post('/extend-tax-time',  'extendTaxTime');
    Route::post('/pay-fine',  'payFine');
    Route::post('/adjust-balance',  'adjustBalance');
    Route::post('/place-bid/{id}',  'placeBid')->name('placeBid');
});
// ========================================================== LandArea Controller ==========================================================
Route::post('/set-renew-days',  [MainLandAreaController::class, 'setRenewDays']);
Route::post('/extend-tax-time', [MainLandAreaController::class, 'extendTaxTime']);
Route::post('/set-tax-end-time', [MainLandAreaController::class, 'updateTaxEndTime']);
Route::post('/update-show', [MainLandAreaController::class, 'updateShow'])->name('update.show');
Route::post('/finalize-auction/{landId}', [LandAreasController::class, 'finalizeAuction'])->name('finalizeAuction');
// ========================================================== users Controller ==========================================================
Route::get('/admin/users', function(){
    return view(view: 'admin.users.add_users');
});
// ========================================================== chat Controller ==========================================================
Route::get('/create/message' ,[SendController::class, 'create'])->name('message.index');
Route::post('/create/message' ,[SendController::class, 'store'])->name('message.create');
Route::get('/message/{message_id}/view' ,[SendController::class, 'view'])->name('message.view');
Route::post('/messages/mark-read', [SendController::class, 'markAsRead'])->name('messages.markRead');
Route::post('/create/message/chat/store' , [SendController::class, 'sendStore'])->name('message.sendStore');
Route::post('/message/chat/store' , [SendController::class, 'replayStore'])->name('message.replay');
Route::put('/chat/{id}/update', [SendController::class, 'endChat'])->name('end.chat');


// ========================================================== lawyerMessage Controller ==========================================================
Route::get('/create/lawyerMessage' ,[lawyerController::class, 'create'])->name('lawyerMessage.index');
Route::post('/create/lawyerMessage' ,[lawyerController::class, 'store'])->name('lawyerMessage.create');
Route::get('/lawyerMessage/{lawyerMessage_id}/view' ,[lawyerController::class, 'view'])->name('lawyerMessage.view');
Route::post('/lawyerMessages/mark-read', [lawyerController::class, 'markAsRead'])->name('lawyerMessages.markRead');
Route::post('/create/lawyerMessage/chat/store' , [lawyerController::class, 'sendStore'])->name('lawyerMessage.sendStore');
Route::post('/lawyerMessage/chat/store' , [lawyerController::class, 'replayStore'])->name('lawyerMessage.replay');
Route::put('/lawyerChat/{id}/update', [lawyerController::class, 'endChat'])->name('lawyerMessage.end.chat');
// ========================================================== tax Controller ==========================================================

Route::get('/get-tax-info', [TaxController::class, 'getTaxInfo'])->name('get.tax.info');
Route::post('/update-tax-status', [TaxController::class, 'updateTaxStatus']);
Route::post('/extend-tax-time', [TaxController::class, 'extendTaxTime']);
Route::post('/update-tax-status', [TaxController::class, 'updateTaxStatus']);
Route::get('/taxTimeUpdate/{id}', [TaxController::class, 'update'])->name('tax.update.time');
// ========================================================== estate Controller ==========================================================
Route::post('/update-land-estate-status', [EstateController::class, 'updateLandEstateStatus']);
Route::post('/estate/store', [EstateController::class, 'store'])->name('estate.store');
Route::get('/estate/{landArea_id}/create', [EstateController::class, 'create'])->name('estate.create');
Route::post('/estate/{landArea_id}/create', [EstateController::class, 'storeLandArea'])->name('estate.create.landArea');
// ========================================================== products Controller ==========================================================
Route::post('/get/bonus/area', [ProductController::class, 'store'])->name('product.store');
// admin
Route::middleware([RoleMiddleware::class.':admin'])->prefix('admin')->group(function () {
// ========================================================== Land Controller ==========================================================
    Route::controller(MainLandController::class)->prefix('land')->group(function(){
        Route::get('/', 'index')->name('land.page');
        Route::get('/create', 'create')->name('land.create');
        Route::post('/store', 'store')->name('land.store');
        Route::get('/edit/{land_id}/', 'edit')->name('land.edit');
        Route::put('/{land_id}/update', 'update')->name('land.update');
        Route::delete('/{land_id}/delete', 'delete')->name('land.delete');
    });
// ========================================================== LandArea Controller ==========================================================

Route::controller(MainLandAreaController::class)->prefix('landArea')->group(function(){
    Route::get('/', 'index')->name('landArea.page');
    Route::get('/create', 'create')->name('landArea.create');
    Route::post('/store', 'store')->name('landArea.store');
    Route::get('/edit/{landArea_id}/', 'edit')->name('landArea.edit');
    Route::put('/{landArea_id}/update', 'update')->name('landArea.update');
    Route::delete('/{landArea_id}/delete', 'delete')->name('landArea.delete');

});

// ========================================================== users Controller ==========================================================

Route::controller(UserController::class)->prefix('user')->group(function(){
    Route::get('/', 'index')->name('user.page');
    Route::post('/users/import',  'import')->name('user.import');
});
// ========================================================== add and minus balance Controller ==========================================================
Route::controller(AddDiscountController::class)->group(callback: function(){

Route::get('/minus-balance', 'minusAdditions')->name('minus_balance.form');
Route::get('/add-balance', 'showAdditions')->name('add_balance.form');
Route::post('/add-balance', 'addBalance')->name('add_balance');
});
Route::post('/minus-balance', [DiscountController::class, 'minusBalance'])->name('minus_balance');

// ========================================================== chat Controller ==========================================================
Route::get('/chat/replay',[SendController::class, 'adminView'])->name('admin.chat.view');
Route::get('/message/{message_id}/chat/view' ,[SendController::class, 'adminViewChat'])->name('message.view.admin');

// ========================================================== lawyerMessage Controller ==========================================================
Route::get('/lawyerMessage/chat/replay',[lawyerController::class, 'adminView'])->name('admin.lawyerMessage.chat.view');
Route::get('/lawyerMessage/{LawyerMessage_id}/chat/view' ,[lawyerController::class, 'adminViewChat'])->name('lawyer.view.admin');
// ========================================================== estate Controller ==========================================================
Route::get('/estate', [EstateController::class, 'index'])->name('estate.index');
// ========================================================== price Controller ==========================================================
Route::post('/price/store', [PriceController::class, 'store'])->name('price.store');
Route::controller(PriceController::class)->prefix('price')->group(function(){
    Route::get('/', 'index')->name('price.page');
    Route::post('/update', 'update')->name('price.update');
});

});












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

Route::post('/update-state', function (Request $request) {
    $request->validate([
        'landArea_id' => 'required|exists:land_areas,id',
        'state' => 'required|integer',
    ]);

    $landArea = LandArea::find($request->landArea_id);

    if ($landArea) {
        $landArea->show_to_estate = $request->state;
        $landArea->save();

        return response()->json(['success' => true, 'message' => 'تم تحديث الحالة بنجاح.']);
    }

    return response()->json(['success' => false, 'message' => 'لم يتم العثور على العنصر.']);
})->name('updateState');

Route::post('/update-state_apply', function (Request $request) {
    $request->validate([
        'landArea_id' => 'required|exists:land_areas,id',
        'state' => 'required|integer',
    ]);
    $landArea = LandArea::find($request->landArea_id);

    if ($landArea) {
        $landArea->show_to_estate = $request->state;
        $landArea->save();

        return response()->json(['success' => true, 'message' => 'تم تحديث الحالة بنجاح.']);
    }

    return response()->json(['success' => false, 'message' => 'لم يتم العثور على العنصر.']);
})->name('updateState_apply');

require __DIR__.'/auth.php';
