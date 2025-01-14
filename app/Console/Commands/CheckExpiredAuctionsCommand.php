<?php

namespace App\Console\Commands;

use DB;
use Carbon\Carbon;
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
        // Get all land areas that need updating
        $lands = LandArea::where('go', 0)
                         ->where('start_time', '<=', Carbon::now())
                         ->get();

        foreach ($lands as $land) {
            // Update go to 1
            $land->go = 1;
            $land->save();
            $this->info("Land ID: {$land->id} updated to go = 1");
        }

        $this->info('Operations update completed.');
        // Get all land areas that need updating
        $lands = LandArea::where('stop', operator: 1)
                         ->where('stop_time', '<=', Carbon::now())
                         ->get();

        foreach ($lands as $land) {
            // Update go to 1
            $land->go = 1;
            $land->save();
            $this->info("Land ID: {$land->id} updated to go = 1");
        }

        $this->info('Operations update completed.');

        // Get all expired auctions with state 0 and no highest bid
        $expiredAuctions = LandArea::where('state', 0)
                                   ->whereNull('highest_bid')
                                   ->get();

        foreach ($expiredAuctions as $auction) {
            // Get the highest bid for the auction
            $highestBid = Bid::where('land_area_id', $auction->id)
                             ->orderBy('bid_amount', 'desc')
                             ->first();

            // Get all bids for this auction
            $bids = Bid::where('land_area_id', $auction->id)->get();

            if ($highestBid) {
                $highestBidder = User::find($highestBid->user_id);

                // Deduct the bid amount from the winner's freeze_balance
                $highestBidder->freeze_balance -= $highestBid->bid_amount;
                $highestBidder->save();

                // Process all other bidders
                foreach ($bids as $bid) {
                    $bidder = User::find($bid->user_id);

                    if ($bidder->id !== $highestBidder->id) {
                        // Refund the amount to non-winning bidders
                        $bidder->balance += $bid->bid_amount;
                        $bidder->freeze_balance -= $bid->bid_amount;
                        $bidder->save();
                    }
                }

                // Update the seller's balance
                $seller = User::find($auction->user_id); // Assume `user_id` is the seller
                if ($seller) {
                    $seller->balance += $highestBid->bid_amount; // Add the highest bid
                    $seller->save();

                    // Add a record in the additions table
                    \DB::table('additions')->insert([
                        'user_id' => $seller->id,
                        'addition' => $highestBid->bid_amount,
                        'title' => 'Land sold',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Update auction data
                $auction->highest_bid = $highestBid->bid_amount;
                $auction->highest_bidder_id = $highestBidder->id;
                $auction->state = 1; // Auction ended
                $auction->save();

                $this->info("Auction ID: {$auction->id} processed. Winner: User ID: {$highestBidder->id}, Amount: {$highestBid->bid_amount}");
            } else {
                // If no bids were placed
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