<script>
    $(function () {
        'use strict'
        if ("{{$fromtree,$totree}}"){
            var MainCompany = '{{isset($MainCompany) ? $MainCompany : null}}';

            var level = '{{isset($level) ? $level : null}}';





            var fromtree = $('.efirst').val();
            var totree = $('.elast').val();
            var radiodepartment =  $('input[name="department"]:checked').val();

            var from =  $('input[name="From"]').val();
            var to =  $('input[name="To"]').val();

            var but_level_check =  $('input[id="but_level_check"]:checked').val();

            $(".print_div").css("display","none");
            if (this) {
                $.ajax({
                    url: '{{route('trialbalance.details')}}',
                    type: 'get',
                    dataType: 'html',
                    data: {MainCompany: MainCompany,
                        level: level,
                        fromtree: fromtree, totree: totree,
                        from: from,
                        to: to,
                        radiodepartment: radiodepartment,
                        but_level_check: but_level_check,
                    },
                    success: function (data) {
                        $("#loadingmessage-2").css("display", "none");
                        $('.print_div').css("display", "block").html(data);

                    }
                });
            }
        }

            {{--$(".fromtree,.totree,.from,.to").on("change",function(){--}}
            {{--    var MainCompany = '{{isset($MainCompany) ? $MainCompany : null}}';--}}
            {{--    var MainBranch = '{{isset($MainBranch) ? $MainBranch : null}}';--}}
            {{--    var level = '{{isset($level) ? $level : null}}';--}}
            {{--    var kind = '{{$kind}}';--}}
            {{--    var fromtree = $('.fromtree').val();--}}
            {{--    var totree = $('.totree').val();--}}
            {{--    var to = $('.to').val();--}}
            {{--    var from = $('.from').val();--}}

            {{--    $("#loadingmessage-2").css("display","block");--}}
            {{--    $(".column-account-date").css("display","none");--}}
            {{--    if (this){--}}
            {{--        $.ajax({--}}
            {{--            url: '{{route('trialbalance.details')}}',--}}
            {{--            type:'get',--}}
            {{--            dataType:'html',--}}
            {{--            data: {MainCompany: MainCompany,MainBranch: MainBranch,level: level, kind: kind, fromtree: fromtree, totree: totree, from: from, to: to},--}}
            {{--            success: function (data) {--}}
            {{--                $("#loadingmessage-2").css("display","none");--}}
            {{--                $('.column-account-date').css("display","block").html(data);--}}

            {{--            }--}}
            {{--        });--}}
            {{--    }else{--}}
            {{--        $('.column-account-date').html('');--}}
            {{--    }--}}
            {{--});--}}





    });
</script>

<script>
    $(function () {
        'use strict'
        $('.e2').select2();
    });

</script>
<div class="row">

    <div class="col-md-12 col-xs-12">
        {{ Form::label('level','المستوى', ['class' => 'col-md-2 control-label']) }}
        {{ Form::text('level',$level,array_merge(['class' => 'form-control col-xs-10', 'id'=>'level_check','disabled'=>'disabled'])) }}
    </div>
</div>
<br>
<div class="row">
    <div class="col-xs-9">
        {{ Form::label('tree','من حساب', ['class' => 'col-xs-3 control-label']) }}
        {{ Form::select('fromtree',$MtsChartAc,$fromtree, array_merge(['class' => 'form-control col-xs-9 e2 efirst'])) }}
    </div>
    <div class="col-xs-3">
        {{ Form::text('number_fromtree',$MtsChartAc3->first(), array_merge(['class' => 'form-control'])) }}
    </div>
</div>
<br>
<div class="row">
    <div class="col-xs-9">
        {{ Form::label('tree','الى حساب', ['class' => 'col-xs-3']) }}
        {{ Form::select('totree',$MtsChartAc,$totree, array_merge(['class' => 'form-control col-xs-9 e2 elast totree'])) }}
    </div>
    <div class="col-xs-3">
        {{ Form::text('number_totree',$MtsChartAc3->last(), array_merge(['class' => 'form-control'])) }}
    </div>
</div>

