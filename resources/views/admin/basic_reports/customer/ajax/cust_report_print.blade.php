
{!! Form::open(array('url' => 'admin/accountStatement/pdf', 'method' => 'POST', 'target' => '_blank')) !!}
{{Form::hidden('mainCompany',$mainCompany)}}
{{Form::hidden('MainBranch',$MainBranch)}}
{{Form::hidden('myradio',$myradio)}}

{{ Form::submit(trans('admin.Print_PDF'), array('class' => 'btn btn-primary', 'style' => 'margin: 47px 102px 0 0;')) }}

{!! Form::close() !!}


