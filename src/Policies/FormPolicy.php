<?php

namespace Corals\Modules\FormBuilder\Policies;

use Corals\Foundation\Policies\BasePolicy;
use Corals\User\Models\User;
use Corals\Modules\FormBuilder\Models\Form;

class FormPolicy extends BasePolicy
{
    protected $administrationPermission = 'Administrations::admin.formbuilder';

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('FormBuilder::form.view')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('FormBuilder::form.create');
    }

    /**
     * @param User $user
     * @param Form $form
     * @return bool
     */
    public function update(User $user, Form $form)
    {
        if ($user->can('FormBuilder::form.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Form $form
     * @return bool
     */
    public function destroy(User $user, Form $form)
    {
        if ($user->can('FormBuilder::form.delete')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Form $form
     * @return bool
     */
    public function submissions(User $user, Form $form)
    {
        return \Arr::has($form->actions, 'database');
    }

}
