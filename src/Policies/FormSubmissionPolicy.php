<?php

namespace Corals\Modules\FormBuilder\Policies;

use Corals\Foundation\Policies\BasePolicy;
use Corals\Modules\FormBuilder\Models\FormSubmission;
use Corals\User\Models\User;

class FormSubmissionPolicy extends BasePolicy
{

    protected $administrationPermission = 'Administrations::admin.formbuilder';
    protected $skippedAbilities = ['create'];
    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('FormBuilder::form_submission.view')) {
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
        return $user->can('FormBuilder::form_submission.create');
    }

    /**
     * @param User $user
     * @param Form $form
     * @return bool
     */
    public function update(User $user, FormSubmission $form_submission)
    {
        if ($user->can('FormBuilder::form_submission.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Form $form
     * @return bool
     */
    public function destroy(User $user, FormSubmission $form_submission)
    {
        if ($user->can('FormBuilder::form_submission.delete')) {
            return true;
        }
        return false;
    }

}
