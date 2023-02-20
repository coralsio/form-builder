<?php

namespace Corals\Modules\FormBuilder\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\FormBuilder\Models\FormSubmission;
use Corals\Modules\FormBuilder\Transformers\FormSubmissionTransformer;
use Yajra\DataTables\EloquentDataTable;

class FormSubmissionsDataTable extends BaseDataTable
{
    private $form = null;

    public function __construct()
    {
        $this->form = request()->route('form');
        parent::__construct();
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new FormSubmissionTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param FormSubmission $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(FormSubmission $model)
    {
        if (! $this->form) {
            abort('404');
        }

        return $model->newQuery()->where('form_id', $this->form->id);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = [
            'id' => ['visible' => false],
        ];

        $visible_form_inputs = collect(\FormBuilder::getFormFieldsLabel($this->form, true));

        $visible_form_inputs = $visible_form_inputs->mapWithKeys(function ($item) use ($visible_form_inputs) {
            return [array_search($item, $visible_form_inputs->toArray()) => ['title' => $item, 'searchable' => false, 'orderable' => false]];
        });

        $invisible_form_inputs = collect(\FormBuilder::getFormFieldsLabel($this->form, false));
        $invisible_form_inputs = $invisible_form_inputs->mapWithKeys(function ($item) use ($invisible_form_inputs) {
            return [array_search($item, $invisible_form_inputs->toArray()) => ['visible' => false, 'title' => $item, 'searchable' => false, 'orderable' => false]];
        });

        return array_merge($columns, $visible_form_inputs->toArray(), $invisible_form_inputs->toArray(), ['created_at' => ['title' => trans('Corals::attributes.created_at')],]);
    }
}
