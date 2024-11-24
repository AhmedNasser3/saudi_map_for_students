<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\admin\bid\Bid;
use Illuminate\Console\Command;
use App\Models\admin\land\LandArea;

class CheckExpiredAuctionsCommand extends Command
{
    protected $signature = 'auction:check-expired';
    protected $description = 'Close expired auctions and choose the winner';

    public function handle()
    {
        $expiredAuctions = LandArea::where('auction_end_time', '<', Carbon::now()->toDateTimeString())
            ->whereNull('highest_bidder_id')
            ->get();

        foreach ($expiredAuctions as $auction) {
            $highestBid = Bid::where('land_area_id', $auction->id)
                ->orderBy('bid_amount', 'desc')
                ->first();

            if ($highestBid) {
                $highestBidder = User::find($highestBid->user_id);

                if ($highestBidder && $highestBidder->balance >= $highestBid->bid_amount) {
                    $auction->highest_bid = $highestBid->bid_amount;
                    $auction->highest_bidder_id = $highestBidder->id;

                    $highestBidder->balance -= $highestBid->bid_amount;
                    $highestBidder->update();

                    $auction->update();

                    $this->info("Auction ID: {$auction->id} closed. Winner: User ID: {$highestBidder->id}, Amount: {$highestBid->bid_amount}");
                } else {
                    $this->info("Auction ID: {$auction->id} closed, but the highest bidder does not have enough balance.");
                }
            } else {
                $this->info("Auction ID: {$auction->id} closed, but no bids were placed.");
            }
        }
    }
}
