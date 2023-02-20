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
        <div class="col-md-4">
            @component('components.box',['box_class'=>'box-success'])
                <p>@lang('FormBuilder::attributes.form.name'): <b>{!! $form->presenter()['name'] !!}</b></p>
                <p>@lang('FormBuilder::attributes.form.content_short_code'):
                    <br/>
                    {!! $form->present('content_short_code') !!}</p>
                <p>
                    @lang('FormBuilder::attributes.form.blade_short_code'):
                    <br/>
                    {!! $form->present('blade_short_code') !!}
                </p>
                <p>@lang('Corals::attributes.status'): <b>{!! $form->presenter()['status'] !!}</b></p>
                <p>@lang('FormBuilder::attributes.form.is_public'): <b>{!! $form->presenter()['is_public'] !!}</b></p>
                <p>@lang('FormBuilder::attributes.form.embed_form')
                    :<br><small>{!!   \FormBuilder::getFormEmbedCode($form)  !!}</small></p>
            @endcomponent
        </div>
        <div class="col-md-6">
            @component('components.box',['box_class'=>'box-success'])
                <h4>@lang('FormBuilder::labels.form.show.render_form')</h4>
                <hr/>
                <div id="rendered_form">
                    {!!   \Shortcode::compile( 'form',$form->short_code ) !!}

                </div>

            @endcomponent
        </div>
    </div>
@endsection

