<script>

    $(function () {
        'use strict';

        // var schedule = $('.schedules').val();
        $('.from,.to').on('change',function () {
            var from = $('.from').val();
            var to = $('.to').val();
            var to_glcc = $('.to_glcc').val();
            var from_glcc = $('.from_glcc').val();

            $("#loadingmessage-2").css("display","block");
            $(".column-data-report").css("display","none");
            if (this){
                $.ajax({
                    url: '{{aurl('cc/report/motioncc/details')}}',
                    type:'get',
                    dataType:'html',
                    data:{from : from,to : to,to_glcc:to_glcc,from_glcc:from_glcc},
                    success: function (data) {
                        $("#loadingmessage-2").css("display","none");
                        $('.column-data-report').css("display","block").html(data);

                    }
                });
            }else{
                $('.column-data-report').html('');
            }
        });
        if("{{$from_glcc,$to_glcc}}"){
            var from = $('.from').val();
            var to = $('.to').val();
            var to_glcc = $('.to_glcc').val();
            var from_glcc = $('.from_glcc').val();
            $("#loadingmessage-2").css("display","block");
            $(".column-data-report").css("display","none");
            if (this){
                $.ajax({
                    url: '{{aurl('cc/report/motioncc/details')}}',
                    type:'get',
                    dataType:'html',
                    data:{from : from,to : to,to_glcc:to_glcc,from_glcc:from_glcc},
                    success: function (data) {
                        $("#loadingmessage-2").css("display","none");
                        $('.column-data-report').css("display","block").html(data);

                    }
                });
            }else{
                $('.column-data-report').html('');
            }

        }

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


<div class="form-group row" style="padding: 0 10px;">

    <div class="col-md-6">
        {{ Form::label('from', trans('admin.From'), ['class' => 'control-label']) }}
        {{ Form::text('from',\Carbon\Carbon::today()->format('Y-').'01-01', array_merge(['class' => 'form-control date from','required'=>'required'])) }}
    </div>
    <div class="col-md-6">
        {{ Form::label('to', trans('admin.To'), ['class' => 'control-label']) }}
        {{ Form::text('to',\Carbon\Carbon::today()->format('Y-m-d'), array_merge(['class' => 'form-control date to','required'=>'required'])) }}
    </div>

</div>
<div id='loadingmessage-2' style='display:none; margin-top: 20px' class="text-center">
    <img src="{{ url('/') }}/images/ajax-loader.gif"/>
</div>
<br>
<div class="column-data-report">


</div>









