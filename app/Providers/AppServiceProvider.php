<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Models\Setting;
use App\Observers\SettingsObserver;

use App\Models\Product;
use App\Observers\ProductObserver;

use App\Models\MembersRegistrationCode;
use App\Observers\MembersRegistrationCodeObserver;

use App\Models\Member;
use App\Observers\MemberObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        Setting::observe(SettingsObserver::class);
        Product::observe(ProductObserver::class);
        MembersRegistrationCode::observe(MembersRegistrationCodeObserver::class);
        Member::observe(MemberObserver::class);
    }
}
