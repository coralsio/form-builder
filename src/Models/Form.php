<?php

namespace Corals\Modules\FormBuilder\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Traits\ModelPropertiesTrait;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\Modules\FormBuilder\Scopes\MyFormsScope;
use Spatie\Activitylog\Traits\LogsActivity;

class Form extends BaseModel
{
    use PresentableTrait, LogsActivity, ModelPropertiesTrait;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new MyFormsScope());
    }

    protected $casts = [
        'actions' => 'json',
        'properties' => 'json',
        'submission' => 'json',
        'is_public' => 'boolean',
    ];
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'form_builder.models.form';

    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }
}
