@extends('layouts.crud.create_edit')

@section('css')
    {!! Html::style('assets/corals/plugins/formbuilder/css/jquery.rateyo.min.css') !!}
    {!! Html::style('assets/corals/plugins/formbuilder/css/jquery-ui.css') !!}
    <style type="text/css">
        .form-actions {
            color: white;
            font-weight: bold;
        }

        .form-builder-overlay {
            z-index: 999;
        }

        .form-builder-dialog {
            z-index: 9999;
        }

        .c-red {
            color: #dd4b39 !important;
        }

        .form-wrap.form-builder {
            background-color: #9E9E9E;
            padding: 5px;
        }
    </style>
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('form_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    @component('components.box')
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="nav-item active">
                            <a href="#form" class="nav-link active" data-toggle="tab">
                                <i class="fa fa-list-alt fa-fw"></i>@lang('FormBuilder::labels.form.tabs.builder')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#actions" class="nav-link" data-toggle="tab">
                                <i class="fa fa-briefcase fa-fw"></i>@lang('FormBuilder::labels.form.tabs.action')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#submission" class="nav-link" data-toggle="tab">
                                <i class="fa fa-send fa-fw"></i>@lang('FormBuilder::labels.form.tabs.submission')
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="form">
                            {!! CoralsForm::openForm($form, ['id'=>'create_edit_form', 'class'=>'']) !!}
                            <div class="row">
                                <div class="col-md-3">
                                    {!! CoralsForm::text('name', 'FormBuilder::attributes.form.name', true) !!}
                                </div>
                                <div class="col-md-3">
                                    {!! CoralsForm::text('short_code', 'FormBuilder::attributes.form.short_code', true) !!}
                                </div>
                                <div class="col-md-2">
                                    {!! CoralsForm::radio('status','Corals::attributes.status', true, trans('Corals::attributes.status_options')) !!}
                                </div>
                                <div class="col-md-2">
                                    <div class="m-t-20 p-t-5">
                                        {!! CoralsForm::checkbox('is_public', 'FormBuilder::attributes.form.is_public_form', $form->is_public) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="m-t-20 p-t-5">
                                        {!! CoralsForm::checkbox('properties[has_captcha]', 'FormBuilder::attributes.form.has_captcha', $form->getProperty('has_captcha', false)) !!}
                                    </div>
                                </div>
                            </div>
                            {!! CoralsForm::customFields($form) !!}
                            @if($form->exists)
                                <div class="row">
                                    <div class="col-md-12">

                                        <p>Embed Form:<br>
                                            {!!   \FormBuilder::getFormEmbedCode($form)  !!}
                                        </p>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-4">
                                    <h3>Form builder area</h3>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group text-right m-t-20">
                                        {!! CoralsForm::button('FormBuilder::labels.form.action.preview',['class'=>'btn btn-info showRenderedForm']) !!}
                                        {!! CoralsForm::button(trans('Corals::labels.save',['title' => $title_singular]),['class'=>'btn btn-success laddaBtn','id' => 'saveBtn'],'button') !!}
                                        {!! CoralsForm::link(url($resource_url),'Corals::labels.cancel',['class'=>'btn btn-warning']) !!}
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            {!! CoralsForm::closeForm($form) !!}

                            <form action="" id="build-wrap">
                                <ul id="tabs">
                                    <li id="add-page-tab"><a href="#new-page">+ Page</a></li>
                                </ul>
                                <div id="new-page"></div>

                            </form>


                            <hr/>
                        </div>
                        <div class="tab-pane" id="actions">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! CoralsForm::label('add_action','FormBuilder::labels.form.action.add_new_action') !!}
                                    <div class="form-group hidden">
                                        {!! CoralsForm::hidden('form_actions',null) !!}
                                    </div>
                                    <br/>

                                    @foreach(config('form_builder.models.form.form_actions') as $key => $action)
                                        @if (user()->hasPermissionTo('FormBuilder::form.action_'.$key))
                                            {!! CoralsForm::button('<i class="'.$action['icon'].' m-r-5"></i>'. trans($action['name']),['class'=>'btn btn-primary btn-sm m-r-5 actionBtn','id'=>$key.'Btn','data'=>['template'=>$key]]) !!}
                                        @endif
                                    @endforeach
                                    <hr/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">

                                    <div id="actionAccordion" class="panel-group">
                                        @foreach($form->actions??[] as $key => $actions)
                                            @if (user()->hasPermissionTo('FormBuilder::form.action_'.$key))
                                                @foreach($actions as $data)
                                                    @include('FormBuilder::forms.action_template',[
                                                        'action' => FormBuilder::fillActionData(\Arr::get(config('form_builder.models.form.form_actions'), $key, null),$data),
                                                        'collapsed' => true
                                                    ])
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="submission">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>@lang('FormBuilder::labels.form.submission.on_success')</h3>
                                    <hr/>
                                    {!! CoralsForm::radio('submission[on_success][action]','FormBuilder::attributes.form_submission.action',true, trans('FormBuilder::attributes.form_submission.action_type'),
                                    \FormBuilder::getSubmissionValue($form->submission,'on_success','action'),
                                    ['class'=>'submission-field']) !!}

                                    {!! CoralsForm::textarea('submission[on_success][content]', 'FormBuilder::attributes.form_submission.content', true,
                                    \FormBuilder::getSubmissionValue($form->submission,'on_success','content'),
                                    ['class'=>'submission-field']) !!}
                                </div>
                                <div class="col-md-6">
                                    <h3>@lang('FormBuilder::labels.form.submission.on_failure')</h3>
                                    <hr/>
                                    {!! CoralsForm::radio('submission[on_failure][action]','FormBuilder::attributes.form_submission.action',true, trans('FormBuilder::attributes.form_submission.action_type'),
                                    \FormBuilder::getSubmissionValue($form->submission,'on_failure','action'),
                                    ['class'=>'submission-field']) !!}

                                    {!! CoralsForm::textarea('submission[on_failure][content]', 'FormBuilder::attributes.form_submission.content', true,
                                    \FormBuilder::getSubmissionValue($form->submission,'on_failure','content'),
                                    ['class'=>'submission-field']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @lang('FormBuilder::labels.form.submission.content_add_value_url')
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-right">
                                    {!! CoralsForm::button('FormBuilder::labels.form.action.preview',['class'=>'btn btn-info showRenderedForm']) !!}
                                    {!! CoralsForm::button(trans('Corals::labels.save',['title' => $title_singular]),['class'=>'btn btn-success laddaBtn','id' => 'saveBtn'],'button') !!}
                                    {!! CoralsForm::link(url($resource_url),'Corals::labels.cancel',['class'=>'btn btn-warning']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcomponent
    @component('components.modal',['id'=>'form-preview','hideHeader'=>true])
        <div id="rendered_form">
            <form id="fb-render">

            </form>
        </div>
        @if($form->exists)
            <div class="row">
                <div class="col-md-12">
                    <hr/>
                    <code id="embed_code"></code>

                    <a href="#" onclick="event.preventDefault();" class="copy-button"
                       data-clipboard-target="#embed_code"><i class="fa fa-clipboard"></i> Copy to Clipboard</a>
                </div>
            </div>
        @endif
        @slot('footer')
            <button type="button" class="btn btn-warning" data-dismiss="modal">
                <i class="fa fa-remove"></i> @lang('FormBuilder::labels.form.action.close')
            </button>
        @endslot
    @endcomponent
@endsection

@section('js')



    {!! Html::script('assets/corals/plugins/formbuilder/js/sizzle.min.js') !!}
    {!! Html::script('assets/corals/plugins/formbuilder/js/jquery-ui.min.js') !!}
    {!! Html::script('assets/corals/plugins/formbuilder/js/form-builder.min.js') !!}
    {!! Html::script('assets/corals/plugins/formbuilder/js/form-render.min.js') !!}
    {!! Html::script('assets/corals/plugins/formbuilder/js/jquery.rateyo.min.js') !!}

    <script type="text/javascript">


        /**
         * Fix Custom Checked Box Form Builder.
         *
         * @param {type} fld
         * @returns {undefined}
         */
        function fixCheckedPropForField(fld, fieldName) {
            // Retrieve the Checkbox as a jQuery object
            $checkbox = $(".fld-" + fieldName, fld);
            // According to the value of the attribute "value", check or uncheck
            if ($checkbox.val() == "true") {
                $checkbox.attr("checked", true);
            } else {
                $checkbox.attr("checked", false);
            }
        };

        $(document).ready(function () {
            var fields = [
                {
                    label: 'Star Rating',
                    attrs: {
                        type: 'starRating'
                    },
                    icon: '<i class="fa fa-star-half-o"></i>'
                }
            ];

            var replaceFields = [
                {
                    type: 'textarea',
                    subtype: 'tinymce',
                    label: 'tinyMCE',
                    required: true,
                }
            ];

            var actionButtons = [];

            var templates = {
                starRating: function (fieldData) {
                    return {
                        field: '<span id="' + fieldData.name + '">',
                        onRender: function () {
                            $(document.getElementById(fieldData.name)).rateYo({rating: 3.6});
                        }
                    };
                }
            };

            var disabledAttrs = ['access'];

            var available_types = [{type: 'text'}, {type: 'button'}, {type: 'select'}, {type: 'button'}, {type: 'checkbox-group'}, {type: 'date'}, {type: 'file'}, {type: 'header'}, {type: 'hidden'}, {type: 'paragraph'}, {type: 'number'}, {type: 'radio-group'}, {type: 'select'}, {type: 'text'}, {type: 'starRating'}, {type: 'autocomplete'}, {type: 'textarea'}];
            var typeUserAttrs = {};
            var typeUserEvents = {};
            for (e in available_types) {
                typeUserAttrs[available_types[e].type] = {
                    showInListing: {
                        label: 'Show in listing',
                        type: 'checkbox',
                    }
                };

                typeUserEvents[available_types[e].type] = {
                    onadd: function (fld) {
                        fixCheckedPropForField(fld, "showInListing");
                    }
                }
            }

            var fbOptions = {
                subtypes: {text: ['datetime-local']},
                stickyControls: {enable: true},
                sortableControls: true,
                fields: fields,
                disabledAttrs: disabledAttrs,
                templates: templates,
                disableInjectedStyle: false,
                actionButtons: actionButtons,
                disabledActionButtons: ['data', 'clear', 'save'],
                replaceFields: replaceFields,
                typeUserAttrs: typeUserAttrs,
                // Register Event onAdd
                typeUserEvents: typeUserEvents,
                i18n: {
                    // TODO::Corals locale switcher
                    locale: '{{ config('form_builder.locale_mapping.'.config('app.locale')) }}'
                }
            };

            var formData = {!! $form->content ??  '[]' !!};


            var $fbPages = $(document.getElementById("build-wrap"));
            var $addPageTab = $("#add-page-tab");
            var fbInstances = [];

            $fbPages.tabs({
                beforeActivate: function (event, ui) {
                    if (ui.newPanel.selector === "#new-page") {
                        return false;
                    }
                }
            });

            $addPageTab.on('click', function () {
                addNewTab('');

            });

            if (formData.length > 0) {
                for (var i = 0; i < formData.length; i++) {
                    var formTab = formData[i];
                    addNewTab(JSON.stringify(formTab));

                }
            } else {
                addNewTab('');

            }


            function addNewTab(FormBilderData) {
                var tabCount = $("#tabs li").length;
                tabId = "page-" + tabCount.toString(),
                    $newPageTemplate = $("#new-page"),
                    $newPage = $newPageTemplate
                        .clone()
                        .attr("id", tabId)
                        .addClass("fb-editor"),
                    $newTab = $addPageTab.clone().removeAttr("id"),

                    $tabLink = $("a", $newTab)
                        .attr("href", "#" + tabId)
                        .text("Page " + tabCount);


                $newPage.insertBefore($newPageTemplate);
                $newTab.insertBefore($addPageTab);
                $fbPages.tabs("refresh");
                $fbPages.tabs("option", "active", tabCount - 1);

                fbOptions.formData = FormBilderData;

                fbInstances.push($newPage.formBuilder(fbOptions));


            }

            //fbInstances.push($(".fb-editor").formBuilder(fbOptions));


            $(".showRenderedForm").on("click", function() {

                var active_tab = $fbPages.tabs('option', 'active');
                formBuilder = fbInstances[active_tab];

                var formData = formBuilder.actions.getData('json', true);

                var fbRender = document.getElementById('fb-render');

                var formRenderOpts = {formData: formData, dataType: 'json', templates: templates};

                $(fbRender).formRender(formRenderOpts);

                initThemeElements();

                $('#form-preview').modal('show');
            });


            $("#create_edit_form").on("submit", function (event) {
                event.preventDefault();

                $('.has-error .help-block').html('');

                $('.form-group').removeClass('has-error');

                $('.nav.nav-tabs li a').removeClass('c-red');

                $form = $(this);

                var builderData = '[';
                for (var i = 0; i < fbInstances.length; i++) {
                    formBuilder = fbInstances[i];
                    builderData += formBuilder.actions.getData('json');
                    if ((i + 1) != fbInstances.length) {
                        builderData += ',';
                    }
                }
                builderData += ']';

                var formData = new FormData($form.get(0));
                formData.append('content', builderData);

                var $actionsFields = $("#actionAccordion .action-field,.submission-field");

                $.each($actionsFields, function (index, object) {
                    var input = $(this);

                    if (input.attr('type') === 'radio' && !input.prop('checked')) {
                        return true;
                    } else {
                        formData.append(input.attr('name'), input.val());
                    }
                });

                var url = $form.attr('action');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (response, textStatus, jqXHR) {
                        Ladda.stopAll();
                        if (response.message) {
                            themeNotify(data);
                        }
                        if (response.action) {

                            window[response.action](response);
                        }
                    },
                    error: function (response, textStatus, jqXHR) {
                        if (response.status === 422) {
                            var errors = $.parseJSON(response.responseText)['errors'];
                            // Iterate through errors object.
                            $.each(errors, function (field, message) {
                                //console.error(field+': '+message);
                                //handle arrays
                                if (field.indexOf('.') !== -1) {
                                    field = field.replace('.', '[');
                                    //handle multi dimensional array
                                    for (i = 1; i <= (field.match(/./g) || []).length; i++) {
                                        field = field.replace('.', '][');
                                    }
                                    field = field + "]";
                                }

                                var formGroup = $('[name="' + field + '"]').closest('.form-group');
                                //Try array name
                                if (formGroup.length === 0) {
                                    formGroup = $('[name="' + field + '[]"]').closest('.form-group');
                                }
                                var tabIndex = formGroup.closest('.tab-pane').index();
                                var panel = formGroup.closest('.panel').find('.panel-title').addClass('c-red');
                                if (tabIndex >= 0) {
                                    $('.nav.nav-tabs li').eq(tabIndex).find('a').addClass('c-red');
                                }
                                formGroup.removeClass('hidden');
                                formGroup.addClass('has-error').append('<p class="help-block">' + message + '</p>');
                            });
                        }
                        var data = {};
                        data.message = $.parseJSON(response.responseText)['message'];
                        data.level = 'error';
                        themeNotify(data);
                        Ladda.stopAll();
                    }
                });
            })
        });

        $(document).on('click', '#saveBtn', function () {
            $("#create_edit_form").submit();
        });

        $(document).on('click', '.actionBtn', function () {
            var $ele = $(this);

            if ($ele.data('template')) {
                var url = '{{ url('form-builder/forms/get-action-template') }}' + "/" + $ele.data('template');

                $.get(url).done(function (html) {
                    $(".panel-collapse").removeClass('in');
                    $("#actionAccordion").prepend(html);
                    initThemeElements();
                });
            } else {
                themeNotify({
                    level: 'error',
                    message: 'Invalid action template'
                })
            }
        });

        $(document).on('click', '.removePanel', function () {
            var $ele = $(this);
            var panel = $ele.closest("div.template-panel");

            panel.remove();
        });
    </script>
@endsection
