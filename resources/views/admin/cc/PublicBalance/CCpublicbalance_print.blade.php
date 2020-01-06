{!! Form::open(array('url' => 'admin/cc/report/ccpublicbalance/pdf', 'method' => 'POST', 'target' => '_blank')) !!}



{{Form::hidden('from', $from)}}
{{Form::hidden('to', $to)}}
@if(!empty($glcc))
    {{Form::hidden('glcc', $glcc)}}
@endif

@if(!empty($level))
    {{Form::hidden('level', $level)}}
@endif
<div style="display: none">
    @if($kind ==null)
        {{ $kind = 0}}
    @endif
</div>
    {{Form::hidden('kind', $kind)}}

{{ Form::submit(trans('admin.Print_PDF'), array('class' => 'btn btn-primary', 'style' => 'margin-right: 10px;')) }}


{!! Form::close() !!}



