@if($hasTask || $hasTask1)
    {!! Form::open(array('url' => 'admin/cc/reports/pdf', 'method' => 'POST', 'target' => '_blank')) !!}

    {{Form::hidden('glcc',$glcc)}}
    {{Form::hidden('from',$from)}}
    {{Form::hidden('to',$to)}}


    {{ Form::submit(trans('admin.Print_PDF'), array('class' => 'btn btn-primary', 'style' => 'margin-right: 10px;')) }}

    {!! Form::close() !!}

@else
    <div class="alert alert-danger">{{trans('admin.no_account_between_this_date')}}</div>
@endif


{{-- above this comment edited by Ibrahim El Monier--}}


{{--by level--}}
{{--@if(!empty($value_merged))--}}
    {{--{{dd($value_merged)}}--}}
{{--@endif--}}
