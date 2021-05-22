<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Models\Setting;
use App\Observers\SettingsObserver;

use App\Models\Product;
use App\Observers\ProductObserver;

use App\Models\RegistrationCode;
use App\Observers\RegistrationCodeObserver;

use App\Models\Member;
use App\Observers\MemberObserver;

use App\Models\Transaction;
use App\Observers\TransactionObserver;

use App\Models\TransactionBonus;
use App\Observers\TransactionBonusObserver;

use App\Models\TransactionEncashment;
use App\Observers\TransactionEncashmentObserver;

use App\Models\MembersEncashmentRequest;
use App\Observers\MembersEncashmentRequestObserver;

use App\Models\HonoraryMember;
use App\Observers\HonoraryMemberObserver;

use App\Models\PaynamicsTransaction;
use App\Observers\PaynamicsTransactionObserver;

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
        RegistrationCode::observe(RegistrationCodeObserver::class);
        Member::observe(MemberObserver::class);
        Transaction::observe(TransactionObserver::class);
        TransactionBonus::observe(TransactionBonusObserver::class);
        TransactionEncashment::observe(TransactionEncashmentObserver::class);
        MembersEncashmentRequest::observe(MembersEncashmentRequestObserver::class);
        HonoraryMember::observe(HonoraryMemberObserver::class);
        PaynamicsTransaction::observe(PaynamicsTransactionObserver::class);
    }
}
