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
use App\Rules\VerifyAvailablePosition;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class ValidatorServiceProvider  extends ServiceProvider {

    public function boot()
    {
        $verfPasswd = new VerifyPassword();
        $this->app['validator']->extend('verifypassword', function ($attribute, $value, $parameters) use ($verfPasswd) {
            return $verfPasswd->passes($attribute, $value);
        }, $verfPasswd->message());
        
        
        Validator::extend('verifyavailableposition', function ($attribute, $value, $parameters, $validator) {
            $placementUser = Arr::get($validator->getData(), $parameters[0], null);
            $vap= new VerifyAvailablePosition($placementUser);
            return $vap->passes($attribute, $value);
        });
    }

    public function register()
    {
        //
    }
}