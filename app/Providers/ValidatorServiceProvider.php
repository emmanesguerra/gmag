<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Providers;

/**
 * Description of ValidatorServiceProvider
 *
 * @author alvin
 */

use Illuminate\Support\ServiceProvider;
use App\Rules\VerifyPassword;

class ValidatorServiceProvider  extends ServiceProvider {

    public function boot()
    {
        $verify = new VerifyPassword();
        $this->app['validator']->extend('verifypassword', function ($attribute, $value, $parameters) use ($verify) {
            return $verify->passes($attribute, $value);
        }, $verify->message());
    }

    public function register()
    {
        //
    }
}