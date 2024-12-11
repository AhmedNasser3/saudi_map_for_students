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
    // جلب جميع المزادات التي حالتها (state) تساوي 0 وأعلى مزايدة غير موجودة
    $expiredAuctions = LandArea::where('state', 0)->whereNull('highest_bid')->get();

    foreach ($expiredAuctions as $auction) {
        // الحصول على أعلى مزايدة للمزاد
        $highestBid = Bid::where('land_area_id', $auction->id)
            ->orderBy('bid_amount', 'desc')
            ->first();

        // جميع المزايدات على هذا المزاد
        $bids = Bid::where('land_area_id', $auction->id)->get();

        if ($highestBid) {
            $highestBidder = User::find($highestBid->user_id);

            // معالجة جميع المزايدين الآخرين
            foreach ($bids as $bid) {
                $bidder = User::find($bid->user_id);

                if ($bidder->id !== $highestBidder->id) {
                    // إرجاع المبلغ للمستخدمين الذين لم يفوزوا بالمزاد
                    $bidder->balance += $bid->bid_amount;
                    $bidder->freeze_balance -= $bid->bid_amount;
                    $bidder->save();
                }
            }

            // تحديث رصيد البائع (المستخدم المرتبط بـ `landArea`)
            $seller = User::find($auction->user_id); // افتراض أن `user_id` هو البائع
            if ($seller) {
                $seller->balance += $highestBid->bid_amount; // إضافة أعلى مزايدة
                $seller->save();

                // إضافة سجل جديد في جدول additions
                \DB::table('additions')->insert([
                    'user_id' => $seller->id,
                    'addition' => $highestBid->bid_amount,
                    'title' => 'ارض تم بيعها',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // تحديث بيانات المزاد
            $auction->highest_bid = $highestBid->bid_amount;
            $auction->highest_bidder_id = $highestBidder->id;
            $auction->state = 1; // المزاد انتهى
            $auction->save();

            $this->info("Auction ID: {$auction->id} processed. Winner: User ID: {$highestBidder->id}, Amount: {$highestBid->bid_amount}");
        } else {
            // إذا لم يكن هناك أي مزايدة
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
