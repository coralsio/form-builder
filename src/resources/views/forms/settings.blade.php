@extends('layouts.master')

@section('title', $title_singular)

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('form_settings') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        @if(count($settings))
            <div class="col-md-10">
                @component('components.box',['box_class'=>'box-success'])
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs">
                                @foreach($settings as $setting_key => $setting)
                                    <li class="nav-item {{ $loop->first ? 'active':'' }}">
                                        <a data-toggle="tab" class="{{ $loop->first ? 'active':'' }} nav-link"
                                           href="#{{ $setting_key }}">{{  trans($setting['name']) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="tab-content">
                                @foreach($settings as $setting_key => $setting)
                                    <div id="{{ $setting_key }}"
                                         class="tab-pane {{ $loop->first ? 'active':'' }}">
                                        {!! CoralsForm::openForm() !!}
                                        @foreach($setting['settings'] as $key => $setting)
                                            @if($setting['type'] == 'text')
                                                {!! CoralsForm::text($setting_key.'_'.$key,$setting['label'],$setting['required'],\Settings::get($setting_key.'_'.$key,'')) !!}
                                            @elseif($setting['type'] == 'boolean')
                                                {!! CoralsForm::boolean($setting_key.'_'.$key,$setting['label'],false,\Settings::get($setting_key.'_'.$key,'true')) !!}
                                            @endif
                                        @endforeach
                                        {!! CoralsForm::formButtons(trans('Corals::labels.save',['title' => $title_singular]),[],['href'=>url('dashboard')]) !!}

                                        {!! CoralsForm::closeForm() !!}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endcomponent
            </div>
        @else
            <div class="col-md-4">
                <div class="alert alert-warning">
                    <h4>@lang('FormBuilder::labels.form.no_setting_found')</h4>
                </div>
            </div>
        @endif
    </div>
@endsection