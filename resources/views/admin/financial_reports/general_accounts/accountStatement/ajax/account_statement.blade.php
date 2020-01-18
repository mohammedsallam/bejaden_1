<script>
    $(function () {
        'use strict'

        $(".from,.to,.fromtree,.totree").on("change",function(){

            var maincompany = '{{$mainCompany}}';
            var MainBranch = '{{$MainBranch}}';

            var totree = $('.totree').val();

            var fromtree = $('.ee').val();

            var from = $('.from').val();

            var to = $('.to').val();



            $("#loadingmessage_3").css("display","block");
            $(".button_print").css("display","none");
            if (this){
                $.ajax({
                    url: '{{route('accountStatement.details')}}',
                    type:'get',
                    dataType:'html',
                    data:{maincompany: maincompany,MainBranch: MainBranch,totree: totree,from: from,to : to,fromtree:fromtree},
                    success: function (data) {
                        $("#loadingmessage_3").css("display","none");
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

    <div class="col-md-3">
        {{ Form::label('tree','fromtree', ['class' => 'control-label']) }}
        {{ Form::select('fromtree',$mtschartac,null, array_merge(['class' => 'form-control  e2 ee fromtree','placeholder'=> trans('admin.select') ])) }}
    </div>
    <div class="col-md-3">
        {{ Form::label('tree','totree', ['class' => 'control-label']) }}
        {{ Form::select('totree',$mtschartac,null, array_merge(['class' => 'form-control e2 totree','placeholder'=> trans('admin.select') ])) }}
    </div>
    <div class="col-md-3">
        {{ Form::label('receipts', trans('admin.From'), ['class' => 'control-label']) }}
        {{ Form::text('From',\Carbon\Carbon::today()->format('Y-'.\Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::now()->copy()->addYear()).'-'.\Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::now()->copy()->addYear())), array_merge(['class' => 'form-control from date','required'=>'required','autocomplete'=>'off'])) }}
    </div>
    <div class="col-md-3">
        {{ Form::label('receipts', trans('admin.To'), ['class' => 'control-label']) }}
        {{ Form::text('To',\Carbon\Carbon::today()->format('Y-m-d'), array_merge(['class' => 'form-control to date','required'=>'required','autocomplete'=>'off'])) }}
    </div>

</div>

{{--loader spinner--}}
<div id='loadingmessage_3' style='display:none; margin-top: 20px' class="text-center">
    <img src="{{ url('/') }}/images/ajax-loader.gif"/>
</div>

<br>
