<script>

       if('{{$level}}'){
            var MainCompany = '{{isset($MainCompany) ? $MainCompany : null}}';
            var level = $('#level_check').val();

            // alert(3);

            var fromtree = $('.efirst2').val();

            // alert(fromtree);

            var totree = $('.elast2').val();

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
        };






</script>


<div class="row" >
    <div class="col-xs-9">
        {{ Form::label('tree','من حساب', ['class' => 'col-xs-3 control-label']) }}
        {{ Form::select('fromtree',$MtsChartAc,$fromtree, array_merge(['class' => 'form-control col-xs-9 e2 efirst2'])) }}
    </div>
    <div class="col-xs-3">
        {{ Form::text('number_fromtree',$MtsChartAc3->first(), array_merge(['class' => 'form-control'])) }}
    </div>
</div>
<br>
<div class="row">
    <div class="col-xs-9">
        {{ Form::label('tree','الى حساب', ['class' => 'col-xs-3']) }}
        {{ Form::select('totree',$MtsChartAc,$totree, array_merge(['class' => 'form-control col-xs-9 e2 elast2 totree2'])) }}
    </div>
    <div class="col-xs-3">
        {{ Form::text('number_totree',$MtsChartAc3->last(), array_merge(['class' => 'form-control'])) }}
    </div>
</div>
