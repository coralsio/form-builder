<?php

namespace Corals\Modules\FormBuilder\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\FormBuilder\Models\Form;
use Corals\Modules\FormBuilder\Transformers\FormTransformer;
use Yajra\DataTables\EloquentDataTable;

class FormsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('form_builder.models.form.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new FormTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Form $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Form $model)
    {
        return $model->newQuery();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['visible' => false],
            'name' => ['title' => trans('FormBuilder::attributes.form.name')],
            'blade_short_code' => [
                'title' => trans('FormBuilder::attributes.form.blade_short_code'),
                'searchable' => false,
                'orderable' => false,
            ],
            'content_short_code' => [
                'title' => trans('FormBuilder::attributes.form.content_short_code'),
                'searchable' => false,
                'orderable' => false,
            ],
            'status' => ['title' => trans('Corals::attributes.status')],
            'is_public' => ['title' => trans('FormBuilder::attributes.form.is_public')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
