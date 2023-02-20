<?php

$forms = \Corals\Modules\FormBuilder\Models\Form::all();

foreach ($forms as $form) {
    $form->content = '[' . $form->content . ']';
    $form->save();
}

