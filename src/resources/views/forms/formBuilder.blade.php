@isset($form)
    <div id="fb-status-{{ $form->hashed_id }}" class="alert alert-success"
         style="display: none;font-weight:bold;text-align:center;padding: 10px;"></div>

    <form method="POST" enctype="multipart/form-data" style="padding: 10px 10px 30px"
          action="{{ $form->is_public?url('forms/public/'.$form->hashed_id):url('forms/'.$form->hashed_id) }}"
          id="fb-{{ $form->hashed_id }}">

        @php $steps = json_decode($form->content) @endphp

        <style>

            .form-group.has-error label {
                color: #dd4b39;
            }

            .form-group.has-error .form-control,
            .form-group.has-error .input-group-addon {
                border-color: #dd4b39;
                box-shadow: none;
            }

            .form-group.has-error .help-block {
                color: #dd4b39;
            }

            @if(count($steps )==1)
                .step-anchor, .sw-toolbar {
                display: none !important;
            }
            @endif

        </style>
        <!-- SmartWizard html -->
        <div id="smartWizard-{{$form->hashed_id}}">
            <ul>
                @foreach($steps as $step)
                    <li><a href="#form-step-{{ $loop->index + 1 }}">Step {{ $loop->index + 1 }}<br/>
                            <small></small>
                        </a></li>
                @endforeach
            </ul>

            <div>
                @foreach($steps as $step)
                    <div id="form-step-{{ $loop->index + 1 }}" style="padding-top:10px" data-toggle="validator"></div>

                @endforeach
            </div>

        </div>
    </form>
@section('js')
    @parent
    <script type="text/javascript">
                @php
                    $dataArray = request()->all()  ?? [];

                @endphp
        var dataPassed = @json($dataArray);

        function redirectTo(data) {
            setTimeout(function () {
                window.location.replace(data.url);
            }, 1000);
        }

        $(document).ready(function () {
            // Smart Wizard
            $('#smartWizard-{{$form->hashed_id}}').smartWizard({
                selected: 0,
                ajaxSettings: {'data': '_token={{ csrf_token() }}', 'type': 'GET'},
                theme: 'arrows',
                useURLhash: false,
                showStepURLhash: false,
                keyNavigation: true,
                contentCache: false,
                transitionEffect: 'fade',
                toolbarSettings: {
                    toolbarPosition: 'bottom'
                },
                lang: {
                    next: '{{ trans('Corals::labels.next') }}',
                    previous: '{{ trans('Corals::labels.previous') }}'
                },
            });

            if (typeof embed !== 'undefined') {
                setTimeout(function () {
                    var embedChild = new embed.Child();
                    embedChild.sendHeight()

                }, 500);


            }

            $('#smartWizard-{{$form->hashed_id}}').on("showStep", function (e, anchorObject, stepNumber, stepDirection) {
                if (typeof embed !== 'undefined') {
                    setTimeout(function () {
                        var embedChild = new embed.Child();
                        embedChild.sendHeight()

                    }, 500);

                    window.scrollTo(0, $('#smartWizard-{{$form->hashed_id}}').offset());
                }
            });

            $('#smartWizard-{{$form->hashed_id}}').on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {
                var elmForm = $("#smartWizard-{{$form->hashed_id}} #form-step-" + (stepNumber + 1));
                // stepDirection === 'forward' :- this condition allows to do the form validation
                // only on forward navigation, that makes easy navigation on backwards still do the validation when going next


                if (stepDirection === 'forward' && elmForm) {
                    elmForm.validator('validate');
                    if (elmForm.data('bs.validator').validate().hasErrors()) {
                        return false;

                    }

                }
                return true;
            });


            var rateFields = [];

            var templates = {
                starRating: function (fieldData) {
                    return {
                        field: '<span id="' + fieldData.name + '">',
                        onRender: function () {
                            rateFields.push([fieldData.name, $(document.getElementById(fieldData.name)).rateYo({rating: 3.6})]);
                        }
                    };
                }
            };

            var formDataJson = {!! $form->content ?? '[]' !!};


            for (var i = 0; i < formDataJson.length; i++) {
                var formData = formDataJson[i];
                var fbRender = $('#fb-{{ $form->hashed_id }} #form-step-' + (i + 1));
                var formRenderOpts = {
                    formData:formData, dataType: 'json', templates: templates,
                    onRender: function () {
                        if (typeof embed !== 'undefined') {
                            var embedChild = new embed.Child();
                            embedChild.sendHeight();
                            $.each(dataPassed, function (key, value) {
                                $("[name='" + key + "']").val(value);
                            });
                        }

                    }
                };

                $(fbRender).formRender(formRenderOpts);


            }


            @if(!isset($extend))
            initThemeElements();
            @endif
            $(document).on('submit', '#fb-{{ $form->hashed_id }}', function (event) {
                event.preventDefault();

                var $form = $(this);

                var form_status = $('#fb-status-{{ $form->hashed_id }}');
                form_status.removeClass('alert-success');
                form_status.removeClass('alert-warning');
                form_status.removeClass('alert-danger');

                var formData = new FormData($form.get(0));

                $.each(rateFields, function (index, $rateYo) {
                    formData.append($rateYo[0], $rateYo[1].rateYo("rating"))
                });

                formData.append('_token', "{{ csrf_token() }}");

                var url = $form.attr('action');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    beforeSend: function () {
                        form_status.html('<p><i class="fa fa-spinner fa-fw fa-spin"></i></p>').fadeIn();
                    },
                    success: function (response, textStatus, jqXHR) {
                        if (response.message) {
                            form_status.html(response.message).addClass(response.class).delay(3000).fadeOut();
                        }
                        if (response.action) {

                            window[response.action](response);
                        }

                        if (typeof embed !== 'undefined') {

                            var embedChild = new embed.Child();
                            embedChild.sendHeight();
                        }
                        $('input', $form).val("");
                        $('textarea', $form).val("");
                        $('select', $form).val("");
                        $('input[type="checkbox"]', $form).val(1);
                        @if(!isset($extend))
                        if (typeof iCheck !== 'undefined') {
                            $('input[type="checkbox"]', $form).iCheck('uncheck');
                        }
                        @endif

                        if (typeof grecaptcha !== 'undefined') {
                            grecaptcha.reset();
                        }

                        $('input[type="checkbox"]', $form).prop('checked', false);
                    },
                    error: function (response, textStatus, jqXHR) {
                        if (typeof embed !== 'undefined') {
                            var embedChild = new embed.Child();
                            embedChild.sendHeight();
                        }

                        var message = $.parseJSON(response.responseText)['message'];
                        form_status.removeClass('alert-success');
                        form_status.html(message).addClass('alert-danger');
                    },
                    complete: function (jqXHR, status) {
                        $('html, body').animate({
                            scrollTop: form_status.offset().top - 20
                        }, 1000);
                    }
                });
            });
                    @if($form->getProperty('has_captcha', false))
            let recaptchaHtml = '{!! NoCaptcha::display() !!}';

            $("[type=submit]").parent().prepend(recaptchaHtml);

            if (typeof embed !== 'undefined') {
                var embedChild = new embed.Child();
                embedChild.sendHeight();
            }
            @endif
        });
    </script>
    @if($form->getProperty('has_captcha', false))
        {!! NoCaptcha::renderJs() !!}
    @endif
@endsection
@else
    <p class="text-center text-danger">
        <strong>{{trans('FormBuilder::labels.form.builder.form_can_not_found',['code' => $short_code])}}</strong></p>
@endisset()
