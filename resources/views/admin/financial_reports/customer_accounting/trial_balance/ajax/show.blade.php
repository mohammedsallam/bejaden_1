<script>
    if('{{$MainCompany}}') {
        var MainCompany = '{{$MainCompany}}';
        var sales_check = $('#sales_check').val();
        var state_check = $('#state_check').val();
        var but_sales_check =  $('input[id="but_sales_check"]:checked').val();
        var but_state_check =  $('input[id="but_state_check"]:checked').val();
        var fromtree = $('.fromtree').val();
        var numberfromtree = $('.numberfromtree').val();
        var totree = $('.totree').val();
        var numbertotree = $('.numbertotree').val();
        var radioDepartment =  $('input[name="department"]:checked').val();
        var delegates =  $('input[name="delegates"]:checked').val();
        var mtscustomer =  $('input[name="mtscustomer"]:checked').val();

        var From =  $('input[name="From"]').val();
        var to = $('input[name = "To"]').val();


        if (this){
            $("#loadingmessage").css("display","block");
            $(".column_form").css("display","none");
            $.ajax({
                url: '{{route('details_trial_balance')}}',
                type:'get',
                dataType:'html',
                data:{
                    MainCompany:MainCompany,
                    but_sales_check:but_sales_check,
                    sales_check:sales_check,
                    fromtree:fromtree,
                    numberfromtree:numberfromtree,
                    totree:totree,
                    numbertotree:numbertotree,
                    radioDepartment:radioDepartment,
                    delegates:delegates,
                    mtscustomer:mtscustomer,
                    From:From,
                    to:to,

                },
                success: function (data) {

                    $('.column_form').css("display","block").html(data);

                }
            });
        }else{
            $('.column_form').html('');
        }

    }

    $(document).ready(function () {
        if ("{{$fromtree,$totree}}"){
            var MainCompany = '{{isset($MainCompany) ? $MainCompany : null}}';
            var sales_check = $('#sales_check').val();
            var state_check = $('#state_check').val();
            var but_sales_check =  $('input[id="but_sales_check"]:checked').val();
            var fromtree = $('.fromtree').val();
            var numberfromtree = $('.numberfromtree').val();
            var totree = $('.totree').val();
            var numbertotree = $('.numbertotree').val();
            var radioDepartment =  $('input[name="department"]:checked').val();
            var delegates =  $('input[name="delegates"]:checked').val();
            var mtscustomer =  $('input[name="mtscustomer"]:checked').val();

            var From =  $('input[name="From"]').val();
            var to = $('input[name = "To"]').val();

            $(".print_div").css("display","none");
            if (this) {
                $.ajax({
                    url: '{{route('details_trial_balance')}}',
                    type: 'get',
                    dataType: 'html',
                    data: {MainCompany: MainCompany,fromtree: fromtree, totree: totree,
                        From: From,to: to,radioDepartment: radioDepartment,but_level_check: but_level_check,
                        delegates:delegates, mtscustomer:mtscustomer, sales_check:sales_check, state_check:state_check,
                        but_sales_check:but_sales_check
                    },
                    success: function (data) {
                        $("#loadingmessage-2").css("display", "none");
                        $('.print_div').css("display", "block").html(data);

                    }
                });
            }
        }

    });
    $('#toDate,#fromDate').on('blur',function(){
        var MainCompany = '{{$MainCompany}}';
        var sales_check = $('#sales_check').val();
        var state_check = $('#state_check').val();
        var but_sales_check =  $('input[id="but_sales_check"]:checked').val();
        var fromtree = $('.fromtree').val();
        // var numberfromtree = $('.numberfromtree').val();
        var totree = $('.totree').val();
        // var numbertotree = $('.numbertotree').val();
        var radioDepartment =  $('input[name="department"]:checked').val();
        var delegates =  $('input[name="delegates"]:checked').val();
        var mtscustomer =  $('input[name="mtscustomer"]:checked').val();
        var From =  $('input[name="From"]').val();
        var to = $('input[name = "To"]').val();

        $(".print_div").css("display","none");
        if (this) {
            $.ajax({
                url: '{{route('details_trial_balance')}}',
                type: 'get',
                dataType: 'html',
                data: {MainCompany: MainCompany,
                    fromtree: fromtree, totree: totree,
                    From: From, to: to,
                    radioDepartment: radioDepartment,
                    but_level_check: but_level_check,
                    sales_check:sales_check, state_check:state_check,
                    delegates:delegates, mtscustomer:mtscustomer,
                    but_sales_check:but_sales_check

        },
                success: function (data) {
                    $("#loadingmessage-2").css("display", "none");
                    $('.print_div').css("display", "block").html(data);

                }
            });
        }
    });
    $('.delegates,.mtscustomer,#but_sales_check,.department').on("change",function(){
            var MainCompany = '{{$MainCompany}}';
            var sales_check = $('#sales_check').val();
            var state_check = $('#state_check').val();
            var but_sales_check =  $('input[id="but_sales_check"]:checked').val();
            var fromtree = $('.fromtree').val();
            var numberfromtree = $('.numberfromtree').val();
            var totree = $('.totree').val();
            var numbertotree = $('.numbertotree').val();
            var radioDepartment =  $('input[name="department"]:checked').val();
            var delegates =  $('input[name="delegates"]:checked').val();
            var mtscustomer =  $('input[name="mtscustomer"]:checked').val();
            var From =  $('input[name="From"]').val();
            var to = $('input[name = "To"]').val();


            if (this){
                $("#loadingmessage").css("display","block");
                $(".column_form").css("display","none");
                $.ajax({
                    url: '{{route('details_trial_balance')}}',
                    type:'get',
                    dataType:'html',
                    data:{
                        MainCompany:MainCompany,
                        but_sales_check:but_sales_check,
                        sales_check:sales_check,
                        state_check:state_check,
                        fromtree:fromtree,
                        numberfromtree:numberfromtree,
                        totree:totree,
                        numbertotree:numbertotree,
                        radioDepartment:radioDepartment,
                        delegates:delegates,
                        mtscustomer:mtscustomer,
                        From:From,
                        to:to,


                    },
                    success: function (data) {

                        $('.column_form').css("display","block").html(data);

                    }
                });
            }else{
                $('.column_form').html('');
            }

    });
</script>
    <div class="row">
        <div class="col-md-9 col-xs-9">
            <input type="checkbox" class="col-md-1 col-xs-1" id='but_sales_check' value="1">
            {{ Form::label('sales_select','المندوب ', ['class' => 'col-md-3 col-xs-3']) }}
            {{ Form::select('sales_select',$AstSalesman,null, array_merge(['class' => 'form-control col-md-8 col-xs-8  e2 ee ', 'disabled', 'id'=>'sales_check'])) }}
        </div>
        <div class="col-md-3 col-xs-3">
            {{ Form::text('sales_select_no',$AstSalesman2->first(), array_merge(['class' => 'form-control sales_select_no', 'disabled', 'id'=>'sales_check_num'])) }}
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-9 col-xs-9">
            <input type="checkbox" class="col-md-1 col-xs-1" id='but_state_check'>
            {{ Form::label('state','المنطقه', ['class' => 'col-md-3 col-xs-3']) }}
            {{ Form::select('state',[],null, array_merge(['class' => 'form-control col-md-8 col-xs-8 e2 ee', 'disabled', 'id'=>'state_check'])) }}
        </div>
        <div class="col-md-3 col-xs-3">
            {{ Form::text('state_no',null, array_merge(['class' => 'form-control', 'disabled', 'id'=>'state_check_num'])) }}
        </div>
    </div>
    <br>

<div class="row" >
    <div class="col-xs-9">
        {{ Form::label('tree','من حساب', ['class' => 'col-xs-3 control-label']) }}
        {{ Form::select('fromtree',$MtsChartAc,$fromtree, array_merge(['class' => 'form-control col-xs-9 e2 efirst'])) }}
    </div>
    <div class="col-xs-3">
        {{ Form::text('number_fromtree',$fromtree, array_merge(['class' => 'form-control'])) }}
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


