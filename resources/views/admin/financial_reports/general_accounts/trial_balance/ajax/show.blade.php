<script>
    $(function () {
        'use strict'
        if ("{{$fromtree,$totree}}"){
            var MainCompany = '{{isset($MainCompany) ? $MainCompany : null}}';
            var MainBranch = '{{isset($MainBranch) ? $MainBranch : null}}';
            var level = '{{isset($level) ? $level : null}}';
            var kind = '{{$kind}}';
            var fromtree = $('.fromtree').val();
            var totree = $('.totree').val();
            var to = $('.to').val();
            var from = $('.from').val();

            $("#loadingmessage-2").css("display","block");
            $(".column-account-date").css("display","none");
            if (this) {
                $.ajax({
                    url: '{{route('trialbalance.details')}}',
                    type: 'get',
                    dataType: 'html',
                    data: {MainCompany: MainCompany,MainBranch: MainBranch,level: level, kind: kind, fromtree: fromtree, totree: totree, from: from, to: to},
                    success: function (data) {
                        $("#loadingmessage-2").css("display", "none");
                        $('.column-account-date').css("display", "block").html(data);

                    }
                });
            }
        }

            $(".fromtree,.totree,.from,.to").on("change",function(){
                var MainCompany = '{{isset($MainCompany) ? $MainCompany : null}}';
                var MainBranch = '{{isset($MainBranch) ? $MainBranch : null}}';
                var level = '{{isset($level) ? $level : null}}';
                var kind = '{{$kind}}';
                var fromtree = $('.fromtree').val();
                var totree = $('.totree').val();
                var to = $('.to').val();
                var from = $('.from').val();

                $("#loadingmessage-2").css("display","block");
                $(".column-account-date").css("display","none");
                if (this){
                    $.ajax({
                        url: '{{route('trialbalance.details')}}',
                        type:'get',
                        dataType:'html',
                        data: {MainCompany: MainCompany,MainBranch: MainBranch,level: level, kind: kind, fromtree: fromtree, totree: totree, from: from, to: to},
                        success: function (data) {
                            $("#loadingmessage-2").css("display","none");
                            $('.column-account-date').css("display","block").html(data);

                        }
                    });
                }else{
                    $('.column-account-date').html('');
                }
            });





    });
</script>

<script>
    $(function () {
        'use strict'
        $('.e2').select2();
    });

</script>
<div class="form-group row">
    <div class="col-md-3">
        {{ Form::label('form',trans('admin.from'), ['class' => 'control-label']) }}
        {{ Form::select('fromtree',$MtsChartAc,$fromtree, array_merge(['class' => 'form-control e2 fromtree','placeholder'=> trans('admin.select') ])) }}
    </div>
    <div class="col-md-3">
        {{ Form::label('to', trans('admin.to'), ['class' => 'control-label']) }}
        {{ Form::select('totree',$MtsChartAc,$totree, array_merge(['class' => 'form-control e2 totree','placeholder'=> trans('admin.select') ])) }}
    </div>
    <div class="col-md-3">
        {{ Form::label('From', trans('admin.From'), ['class' => 'control-label']) }}
        {{--        {{ Form::text('From',\Carbon\Carbon::today()->format('Y-'.\Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::now()->copy()->addYear()).'-'.\Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::now()->copy()->addYear())), array_merge(['class' => 'form-control from datepicker','required'=>'required','autocomplete'=>'off'])) }}--}}
        {{ Form::text('From',\Carbon\Carbon::today()->format('Y-'.'01'.'-'.'01')    , array_merge(['class' => 'form-control from datepicker','required'=>'required','autocomplete'=>'off'])) }}
    </div>
    <div class="col-md-3">
        {{ Form::label('To', trans('admin.To'), ['class' => 'control-label']) }}
        {{ Form::text('To',\Carbon\Carbon::today()->format('Y-m-d'), array_merge(['class' => 'form-control to datepicker','required'=>'required','autocomplete'=>'off'])) }}
    </div>
</div>
<div id='loadingmessage-2' style='display:none; margin-top: 20px' class="text-center">
    <img src="{{ url('/') }}/images/ajax-loader.gif"/>
</div>
<div class="column-account-date">

</div>
<br>
