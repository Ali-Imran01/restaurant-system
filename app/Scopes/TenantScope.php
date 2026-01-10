<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // Don't apply scope if we are in console or not logged in
        if (app()->runningInConsole() || !Auth::check()) {
            return;
        }

        $user = Auth::user();
        
        // If the user is a super_admin, we don't filter (they see everything)
        if ($user->role === 'super_admin') {
            return;
        }

        // Otherwise, filter by the user's restaurant_id
        if ($user->restaurant_id) {
            $builder->where($model->getTable() . '.restaurant_id', $user->restaurant_id);
        }
    }
}
