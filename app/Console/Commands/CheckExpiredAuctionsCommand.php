<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\admin\bid\Bid;
use Illuminate\Console\Command;
use App\Models\admin\land\LandArea;

class CheckExpiredAuctionsCommand extends Command
{
    protected $signature = 'auction:check-expired';
    protected $description = 'Process auctions where state is 0 and determine the winner';

    public function handle()
    {
        // جلب جميع المزادات التي حالتها (state) تساوي 0
        $expiredAuctions = LandArea::where('state', 0)
        ->whereNull('highest_bid')
        ->get();
        foreach ($expiredAuctions as $auction) {
            // الحصول على أعلى مزايدة للمزاد
            $highestBid = Bid::where('land_area_id', $auction->id)
                ->orderBy('bid_amount', 'desc')
                ->first();

            if ($highestBid) {
                // التحقق من أن المستخدم لديه رصيد كافٍ
                $highestBidder = User::find($highestBid->user_id);

                if ($highestBidder && $highestBidder->balance >= $highestBid->bid_amount) {
                    // تحديث بيانات المزاد مع الفائز
                    $auction->highest_bid = $highestBid->bid_amount;
                    $auction->highest_bidder_id = $highestBidder->id;

                    // خصم المبلغ من رصيد المستخدم
                    $highestBidder->balance -= $highestBid->bid_amount;
                    $highestBidder->update();

                    // تغيير حالة المزاد إلى 1 (تمت المعالجة)
                    $auction->state = 1;
                    $auction->update();

                    $this->info("Auction ID: {$auction->id} processed. Winner: User ID: {$highestBidder->id}, Amount: {$highestBid->bid_amount}");
                } else {
                    $this->info("Auction ID: {$auction->id} processed, but the highest bidder does not have enough balance.");
                }
            } else {
                // إذا لم يكن هناك مزايدات، يمكن ترك المزاد بدون فائز
                $this->info("Auction ID: {$auction->id} processed, but no bids were placed.");
            }
        }
    }
}
