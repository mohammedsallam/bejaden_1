
{!! Form::open(array('route' => 'accountStatement.acc_pdf', 'method' => 'POST', 'target' => '_blank')) !!}
{{Form::hidden('maincompany',$maincompany)}}
{{Form::hidden('MainBranch',$MainBranch)}}
{{Form::hidden('fromtree',$fromtree)}}
{{Form::hidden('totree',$totree)}}

{{Form::hidden('from',$from)}}
{{Form::hidden('to',$to)}}


{{ Form::submit(trans('admin.Print_PDF'), array('class' => 'btn btn-primary', 'style' => 'margin-right: 10px;')) }}

{!! Form::close() !!}

