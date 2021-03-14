<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductObserver
{
    //
    /**
     * Listen to the Product creating event.
     *
     * @param  \App\Models\Product  $args
     * @return void
     */
    public function creating(Product $args)
    {
        $args->slug = Str::slug($args->name);
        $args->created_by = Auth::id();
    }
    
    /**
     * Listen to the Product updating event.
     *
     * @param  \App\Models\Product  $args
     * @return void
     */
    public function updating(Product $args)
    {
        $args->slug = Str::slug($args->name);
        $args->updated_by = Auth::id();
    }
}
