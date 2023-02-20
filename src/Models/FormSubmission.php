<?php

namespace Corals\Modules\FormBuilder\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class FormSubmission extends BaseModel
{
    use PresentableTrait, LogsActivity;

    protected $casts = [
        'content' => 'json',
    ];
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'form_builder.models.form_submission';

    protected $guarded = ['id'];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
