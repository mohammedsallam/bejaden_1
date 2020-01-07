


<script>
    $(document).ready(function(){

        $('.e2').on('change',function(){
            // $("#loadingmessage").css("display","block");
            // $(".column-data").css("display","none");
            var value = $(this).val();
            var name = $(this).attr('name');

            if (this){
                $.ajax({
                    url: '{{route('supp_report_select')}}',
                    type:'get',
                    dataType:'html',
                    data:{name : name,value:value},
                    success: function (data) {
                        $("#loadingmessage").css("display","none");
                        $('.column_details').css("display","block").html(data);

                    }
                });
            }else{
                $('.column_details').html('');
            }


        });
    });
</script>


@if($myradio ==1)


    <div class="row">
        <div class="col-md-5">
            {{ Form::label('company',trans('admin.company'), ['class' => 'control-label']) }}
            {{ Form::select('company',$mainCompany,null, array_merge(['class' => 'form-control e2 company','placeholder'=> trans('admin.select') ])) }}
        </div>

    </div>

@elseif($myradio == 2)

    <div class="row">
        <div class="col-md-5">
            {{ Form::label('MainBranch',trans('admin.branche'), ['class' => 'control-label']) }}
            {{ Form::select('MainBranch',$MainBranch,null, array_merge(['class' => 'form-control e2 from_glcc','placeholder'=> trans('admin.select') ])) }}
        </div>

    </div>
@elseif($myradio == 3)
    <div class="row">
        <div class="col-md-5">
            {{ Form::label('Astsupctg',trans('admin.MtsChartAc_sup'), ['class' => 'control-label']) }}
            {{ Form::select('Astsupctg',$Astsupctg,null, array_merge(['class' => 'form-control e2 from_glcc','placeholder'=> trans('admin.select') ])) }}
        </div>

    </div>
@elseif($myradio == 4)
    <div class="row">
        <div class="col-md-5">
            {{ Form::label('country',trans('admin.country'), ['class' => 'control-label']) }}
            {{ Form::select('country',$country,null, array_merge(['class' => 'form-control e2 from_glcc','placeholder'=> trans('admin.select') ])) }}
        </div>

    </div>
@elseif($myradio == 5)
    <div class="row">
        <div class="col-md-5">
            {{ Form::label('AstCurncy',trans('admin.AstCurncy'), ['class' => 'control-label']) }}
            {{ Form::select('AstCurncy',$AstCurncy,null, array_merge(['class' => 'form-control e2 from_glcc','placeholder'=> trans('admin.select') ])) }}
        </div>

    </div>
@elseif($myradio == 6)
    <div class="row">
        <div class="col-md-5">
            {{ Form::label('MtsChartAc',trans('admin.MtsChartAc'), ['class' => 'control-label']) }}
            {{ Form::select('MtsChartAc',$MtsChartAc,null, array_merge(['class' => 'form-control e2 from_glcc','placeholder'=> trans('admin.select') ])) }}
        </div>

    </div>

@endif
<div class="column_details">

</div>
