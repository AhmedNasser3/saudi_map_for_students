<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\admin\land\LandArea;
use Carbon\Carbon;

class UpdateLandGoStatus extends Command
{
    protected $signature = 'landareas:update-go';
    protected $description = 'تحديث قيمة go للمناطق التي انتهى وقتها';

    public function handle()
    {
        // الحصول على جميع السجلات التي تحتاج إلى تحديث
        $lands = LandArea::where('go', 0)
                         ->where('go_time', '<=', Carbon::now())
                         ->get();

        foreach ($lands as $land) {
            // تحديث قيمة go إلى 1
            $land->go = 1;
            $land->save();
            $this->info("تم تحديث العملية للمزرعة {$land->id} إلى 1");
        }

        $this->info('تم إتمام تحديث العمليات.');
    }
}
