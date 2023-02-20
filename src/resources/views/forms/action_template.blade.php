<div class="panel panel-default template-panel">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#actionAccordion" href="#{{ $panel_id = \Str::random(6) }}">
                {!! '<i class="'.$action['icon'].' m-r-5"></i>'.trans($action['name']) !!}
            </a>
            {!! CoralsForm::button('<i class="fa fa-remove"></i>',['class'=>'btn btn-xs btn-danger pull-right removePanel','data'=>['panel'=>$panel_id]]) !!}
            <div class="clearfix"></div>
        </h4>
    </div>
    <div id="{{ $panel_id  }}" class="panel-collapse collapse {{ $collapsed??'in' }}">
        <div class="panel-body">
            @foreach($action['fields'] as $fieldKey => $field)
                @if(in_array($field['type'],['text','textarea']))
                    {!! CoralsForm::{$field['type']}('form_actions['.$key.']['.$panel_id.']['.$fieldKey.']', $field['label'], $field['required'], $field['value'], array_merge(['class'=>'action-field'],$field['attributes'])) !!}
                @elseif($field['type']=='select')
                    {!! CoralsForm::{$field['type']}('form_actions['.$key.']['.$panel_id.']['.$fieldKey.']', $field['label'], is_array( $field['options']) ?  $field['options'] : eval($field['options']) , $field['required'], $field['value'], array_merge(['class'=>'action-field'],$field['attributes'])) !!}
                @elseif($field['type']=='checkbox')
                    {!! CoralsForm::checkbox('form_actions['.$key.']['.$panel_id.']['.$fieldKey.']', $field['label'],$field['value'],1, array_merge(['class'=>'action-field'],$field['attributes'])) !!}
                @endif
            @endforeach
        </div>
    </div>
</div>