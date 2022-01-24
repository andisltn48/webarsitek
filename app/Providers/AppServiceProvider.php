<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Revisi;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('daftarRevisi1', Revisi::where('revisi_tahap', 'Tahap 1')->get());
        View::share('daftarRevisi2', Revisi::where('revisi_tahap', 'Tahap 2')->get());
    }
}
