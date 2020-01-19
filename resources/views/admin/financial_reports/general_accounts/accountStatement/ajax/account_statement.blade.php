<script>
    $(function () {
        'use strict'

        $(function(){
            $('.select').change(function(){ // when one changes
                var selected = $('.select').children('option:selected').text();

                $('.totree').val($('.select').val()); // they all change
            });
        })
        $(".from,.to,.fromtree,.totree,.acc_fromtree,.acc_totree").on("change",function(){

            var maincompany = '{{$mainCompany}}';


            var totree = $('.totree').val();

            var fromtree = $('.ee').val();
            var acc_fromtree = $('.acc_fromtree').val();
            var acc_totree = $('.acc_totree').val();

            var from = $('.from').val();

            var to = $('.to').val();



            $("#loadingmessage_1").css("display","block");
            $(".button_print").css("display","none");
            if (this){
                $.ajax({
                    url: '{{route('accountStatement.details')}}',
                    type:'get',
                    dataType:'html',
                    data:{maincompany: maincompany,totree: totree,from: from,to : to,fromtree:fromtree,acc_fromtree:acc_fromtree,acc_totree:acc_totree},
                    success: function (data) {
                        $("#loadingmessage_1").css("display","none");
                        $('.button_print').css("display","block").html(data);

                    }
                });
            }else{
                $('.button_print').html('');
            }
        });




    });
</script>
<script>
    $(document).ready(function(){
        var minDate = '{{\Carbon\Carbon::today()->format('Y-m-d')}}';
        console.log(minDate);
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            rtl: true,
            language: '{{session('lang')}}',
            autoclose:true,
            todayBtn:true,
            clearBtn:true,
        });
    });
</script>
<script>
    $(function () {
        'use strict'
        $('.e2').select2({
            placeholder: "{{trans('admin.select')}}",
            dir: '{{direction()}}'
        });
    });

</script>


<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        background-color: #333;
    }
    @if(session('lang') == 'ar')
                .datepicker{
        direction: rtl
    }
    @endif

</style>


<div class="row">
    <div class="col-md-10">
        {{ Form::label('tree','من حساب', ['class' => 'col-md-3']) }}
        {{ Form::select('fromtree',$mtschartac,null, array_merge(['class' => 'col-md-8  form-control select e2  ee','placeholder'=> trans('admin.select') ])) }}
    </div>

    <div class="col-md-2">
        {{ Form::select('fromtree_Acc_No',$mtschartac_Acc_No,null, array_merge(['class' => 'form-control e2 acc_fromtree','placeholder'=> trans('admin.select') ])) }}

    </div>
</div>
<br>
<div class="row">
    <div class="col-md-10">
        {{ Form::label('tree','الى حساب', ['class' => 'col-md-3']) }}
        {{ Form::select('totree',$mtschartac,null, array_merge(['class' => 'col-md-8  form-control  e2 select totree','placeholder'=> trans('admin.select') ])) }}
    </div>

    <div class="col-md-2">
        {{ Form::select('totree_Acc_No',$mtschartac_Acc_No,null, array_merge(['class' => 'form-control e2 acc_totree','placeholder'=> trans('admin.select') ])) }}

    </div>
</div>
