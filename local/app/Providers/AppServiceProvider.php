<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use App\Models\Facility;
use App\Models\BedroomFacility;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        $data['facilities'] = Facility::orderBy('facility_id')->get();
        $data['bedroom_facilities'] = BedroomFacility::orderBy('bedroom_facility_id')->get();
        view()->share($data);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
