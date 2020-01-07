
    {!! Form::open(array('route' => 'cust_report_pdf', 'method' => 'POST', 'target' => '_blank')) !!}

    {{Form::hidden('name',$name)}}
    {{Form::hidden('value',$value)}}
<div class="button" style="margin: 18px">

    <a class="btn btn-danger" href="javascript:history.back()">الرجوع</a>
    {{ Form::submit(trans('admin.Print_PDF'), array('class' => 'btn btn-primary', 'style' => 'margin-right: 10px;')) }}

</div>
    {!! Form::close() !!}



