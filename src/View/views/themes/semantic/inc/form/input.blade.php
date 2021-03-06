<?php if (!isset($input)) $input = $column->input; ?>
<?php if (!isset($editable)) $editable = $column->editable; ?>


<?php
$value = $crud->form->getValue($column);
?>


@if($input == 'custom_html')
    {!!$column->input_custom_html!!}
@endif

@if($input == 'select')
    <select multiple id="{{$column->name}}"
            name="{{$column->name}}" {!!$column->inputAttr($value)!!}>
        <option value="">{{$column->input_label}}</option>
        @foreach($crud->form->value($column->options) as $k => $v)
            <option value="{{$k}}" {{$value == $k ? 'selected' : ''}}>{{$v}}</option>
        @endforeach
    </select>
@endif

@if($input == 'chosen')
    <select data-placeholder="{{$column->input_label}}" class="chosen" id="{{$column->name}}"
            name="{{$column->name}}" {!!$column->inputAttr($value)!!}>
        @foreach($crud->form->value($column->options) as $k => $v)
            <option value="{{$k}}" {{$value == $k ? 'selected' : ''}}>{{$v}}</option>
        @endforeach
    </select>
@endif

@if($input == 'chosen-multiple' || $input == 'multiselect')
    <select multiple data-placeholder="{{$column->input_label}}" class="chosen" id="{{$column->name}}"
            name="{{$column->name}}[]" {!!$column->inputAttr($value)!!}>
        @foreach($crud->form->value($column->options) as $k => $v)
            <option value="{{$k}}" {{in_array($k, $value)  ? 'selected' : ''}}>{{$v}}</option>
        @endforeach
    </select>
@endif

@if($input == 'file')
    <div id="filesContainer{{$column->name}}"></div>

    <script type="text/jsx">
        React.render(
                <FilesSlots
                        files="{{$crud->form->row ? $crud->form->row->attachmentsByColumn($column->name)->toJson() : '[]'}}"
                        empty_slots="{{$column->file_empty_slots}}" name="{{$column->name}}"
                        target="{{$crud->config['attachments.upload.url']}}?crudAttachmentsUpload&scope={{get_class($crud->model)}}::{{$column->name}}&_token={{csrf_token()}}"/>,
                document.getElementById('filesContainer{{$column->name}}')
        );
    </script>
@endif

@if($input == 'tags')
    <input class="tags" id="{{$column->name}}"
           name="{{$column->name}}" {!!$column->inputAttr($value)!!}/>
@endif

@if($input == 'textarea')
    <textarea {!!$column->inputAttr($value)!!} id="{{$column->name}}"
              name="{{$column->name}}" {{$column->required ? 'required' : ''}}>{{$value}}</textarea>
@endif

@if($input == 'html')
    <textarea class="html" {!!$column->inputAttr($value)!!} id="{{$column->name}}"
              name="{{$column->name}}" {{$column->required ? 'required' : ''}}>{{$value}}</textarea>
@endif

@if($input == 'checkbox')
    <input {!!$column->inputAttr()!!} {{$value ? 'checked ' : ''}}type="checkbox"
           name="{{$column->name}}">
@endif

@if(in_array($input, ['text', 'date']))
    <div class="ui fluid{{$column->input_action ? ' action' : ''}}{{$column->input_icon ? ' left icon' : ''}}{{$column->input_right_icon ? ' right icon' : ''}}{{$column->labeled ? ' labeled' : ''}}{{$column->labeled_right ? ' right labeled' : ''}} input">
        @if($column->input_icon)
            <i class="{{$column->input_icon}} icon"></i>
        @endif
        @if($column->labeled)
            <div class="ui {{$column->labeled_class}} label">
                {{$column->labeled}}
            </div>
        @endif

        <input
            @if($column->placeholder)placeholder="{{$column->placeholder}}"@endif
            {!!$column->inputAttr($value)!!}
            type="text"
            id="{{$column->name}}"
            name="{{$column->name}}"
            {{$column->required ? 'required' : ''}}
        />

        @if($column->labeled_right)
            <div class="ui {{$column->labeled_class}} label">
                {{$column->labeled_right}}
            </div>
        @endif
        @if($column->input_right_icon)
            <i class="{{$column->input_right_icon}} icon"></i>
        @endif
        {!!$column->input_action!!}
    </div>
@endif

@if($input == 'interval')
    <div class="ui two column grid">
        <div class="column" style="width:20%;">
            <input interval="{{$column->name}}" placeholder="From"
                   {!!$column->inputAttr($value)!!} type="text" id="{{$column->name}}"
                   name="{{$column->name}}[from]" {{$column->required ? 'required' : ''}}/>
        </div>
        <div class="column" style="width:20%;">
            <input interval="{{$column->name}}" placeholder="To"
                   {!!$column->inputAttr($value)!!} type="text" id="{{$column->name}}"
                   name="{{$column->name}}[to]" {{$column->required ? 'required' : ''}}/>
        </div>
    </div>
@endif
