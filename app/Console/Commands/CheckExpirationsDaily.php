<?php

namespace App\Console\Commands;

use App\Http\Controllers\FridgeItemController;
use App\Services\FridgeExpirationService;
use Illuminate\Console\Command;

class CheckExpirationsDaily extends Command
{
    protected $signature = 'fridge:check-expirations';
    protected $description = 'فحص صلاحية مكونات الثلاجة يوميًا';

    public function handle()
    {
        (new FridgeExpirationService)->checkForAll();
        $this->info('تم فحص صلاحيات المنتجات.');
    }
}
