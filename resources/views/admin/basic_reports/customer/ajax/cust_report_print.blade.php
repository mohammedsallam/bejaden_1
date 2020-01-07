<div class="row">

    {!! Form::open(array('route' => 'cust_report_pdf', 'method' => 'POST', 'target' => '_blank')) !!}
    {{Form::hidden('mainCompany',$mainCompany)}}
    {{Form::hidden('MainBranch',$MainBranch)}}
    {{Form::hidden('myradio',$myradio)}}
    {{Form::hidden('selecd_input',$selecd_input)}}
    <div class="col-md-2" style='margin: 47px 102px 0 0;'><button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i></button></div>

    {!! Form::close() !!}

</div>

