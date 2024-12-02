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
            ->get();
        foreach ($expiredAuctions as $auction) {
            // الحصول على أعلى مزايدة للمزاد
            $highestBid = Bid::where('land_area_id', $auction->id)
                ->orderBy('bid_amount', 'desc')
                ->first();

            // جميع المزايدات على هذا المزاد
            $bids = Bid::where('land_area_id', $auction->id)->get();

            if ($highestBid) {
                $highestBidder = User::find($highestBid->user_id);

                foreach ($bids as $bid) {
                    $bidder = User::find($bid->user_id);

                    if ($bidder->id !== $highestBidder->id) {
                        // إرجاع جميع المبالغ إلى balance إذا لم يفز المستخدم بأي مزايدة
                        $bidder->balance += $bid->bid_amount;
                        $bidder->freeze_balance -= $bid->bid_amount;
                        $bidder->save();
                    }
                }

                // إذا كان الفائز لديه رصيد كافٍ
                if ($highestBidder && $highestBidder->freeze_balance >= $highestBid->bid_amount) {
                    // تحديث المزاد
                    $auction->highest_bid = $highestBid->bid_amount;
                    $auction->highest_bidder_id = $highestBidder->id;

                    // خصم المبلغ النهائي
                    $highestBidder->freeze_balance -= $highestBid->bid_amount;
                    $highestBidder->save();

                    // تحديث حالة المزاد
                    $auction->state = 1;
                    $auction->save();

                    // إرجاع باقي المزايدات إلى رصيد الفائز
                    $userBids = Bid::where('land_area_id', $auction->id)
                        ->where('user_id', $highestBidder->id)
                        ->where('id', '!=', $highestBid->id)
                        ->get();

                    foreach ($userBids as $userBid) {
                        $highestBidder->balance += $userBid->bid_amount;
                        $highestBidder->freeze_balance -= $userBid->bid_amount;
                        $highestBidder->save();
                    }

                    $this->info("Auction ID: {$auction->id} processed. Winner: User ID: {$highestBidder->id}, Amount: {$highestBid->bid_amount}");
                } else {
                    $this->info("Auction ID: {$auction->id} processed, but the highest bidder does not have enough freeze_balance.");
                }
            } else {
                // إذا لم يكن هناك أي مزايدة، إرجاع جميع المبالغ للمستخدمين
                foreach ($bids as $bid) {
                    $bidder = User::find($bid->user_id);
                    $bidder->balance += $bid->bid_amount;
                    $bidder->freeze_balance -= $bid->bid_amount;
                    $bidder->save();
                }
                $this->info("Auction ID: {$auction->id} processed, but no bids were placed.");
            }
        }
    }
}
