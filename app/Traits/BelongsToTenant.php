<?php

namespace App\Traits;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function (Model $model) {
            if (auth()->check() && auth()->user()->restaurant_id) {
                if (!$model->restaurant_id) {
                    $model->restaurant_id = auth()->user()->restaurant_id;
                }
            }
        });
    }
}
