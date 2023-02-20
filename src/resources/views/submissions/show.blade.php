@extends('layouts.crud.show')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('form_show') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @component('components.box',['box_class'=>'box-success'])

                <table class="table color-table info-table table table-hover table-striped table-condensed">
                    <tbody>
                    <tr>
                    @foreach($form_inputs as $form_input_key => $form_input_label)
                        <tr>
                            <th>{!! $form_input_label !!}</th>
                            <td>{!!  isset($form_data[$form_input_key])  ?   ( is_array($form_data[$form_input_key]) ? formatArrayAsLabels($form_data[$form_input_key], 'info') : $form_data[$form_input_key] ): "-"  !!}</td>
                        </tr>

                    @endforeach

                    </tbody>

                </table>
            @endcomponent
        </div>
    </div>
@endsection

