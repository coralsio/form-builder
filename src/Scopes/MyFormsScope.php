<?php

namespace Corals\Modules\FormBuilder\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class MyFormsScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $user = user();

        if ($user && ! $user->hasPermissionTo('FormBuilder::form.access_all_forms')) {
            $builder->where('created_by', $user->id);
        }
    }
}
