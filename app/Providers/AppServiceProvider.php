<?php

namespace App\Providers;

use App\Models\Presensi;
use App\Models\Siswa;
use App\Observers\PresensiObserver;
use App\Observers\SiswaObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Siswa::observe(SiswaObserver::class);
        Presensi::observe(PresensiObserver::class);
    }
}
