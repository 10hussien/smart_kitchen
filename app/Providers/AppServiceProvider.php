<?php

namespace App\Providers;

use App\Models\Teacher;
use App\Observers\ApprovedTeacher;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }


    public function boot(): void {}
}
