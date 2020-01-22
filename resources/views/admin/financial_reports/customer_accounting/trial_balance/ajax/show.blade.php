<script>
    if('{{$MainCompany}}')
    {


        var MainCompany = '{{$MainCompany}}';
        var sales_check = $('#sales_check').val();

        var but_sales_check =  $('input[id="but_sales_check"]:checked').val();

        var fromtree = $('.fromtree').val();
        var numberfromtree = $('.numberfromtree').val();
        var totree = $('.totree').val();
        var numbertotree = $('.numbertotree').val();
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

        $('.delegates,.mtscustomer,#but_sales_check,.department').on("click",function(){
            var MainCompany = '{{$MainCompany}}';
            var sales_check = $('#sales_check').val();
            var state_check = $('#state_check').val();
            var but_sales_check =  $('input[id="but_sales_check"]:checked').val();

            var fromtree = $('.fromtree').val();
            var numberfromtree = $('.numberfromtree').val();
            var totree = $('.totree').val();
            var numbertotree = $('.numbertotree').val();
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

    });
</script>
    <div class="row">
        <div class="col-md-9 col-xs-9">
            <input type="checkbox" class="col-md-1 col-xs-1" id='but_sales_check' value="1">
            {{ Form::label('sales_select','المندوب ', ['class' => 'col-md-3 col-xs-3']) }}
            {{ Form::select('sales_select',$AstSalesman,null, array_merge(['class' => 'form-control col-md-8 col-xs-8  e2 ee ', 'disabled', 'id'=>'sales_check'])) }}
        </div>
        <div class="col-md-3 col-xs-3">
            {{ Form::text('sales_select_no',$AstSalesman2->first(), array_merge(['class' => 'form-control sales_select_no'])) }}
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
            {{ Form::text('state_no',null, array_merge(['class' => 'form-control'])) }}
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-9 col-xs-9">
            {{ Form::label('tree','من حساب', ['class' => 'col-md-3 col-xs-4']) }}
            {{ Form::select('fromtree',$MtsChartAc,$MtsChartAc2->first(), array_merge(['class' => 'form-control col-md-9 col-xs-8 e2 ee fromtree'])) }}
        </div>
        <div class="col-md-3 col-xs-3">
            {{ Form::text('fromtree',$MtsChartAc2->first(), array_merge(['class' => 'form-control numberfromtree'])) }}
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-9 col-xs-9">
            {{ Form::label('tree','الي  حساب', ['class' => 'col-md-3 col-xs-4']) }}
            {{ Form::select('totree',$MtsChartAc,$MtsChartAc2->last(), array_merge(['class' => 'form-control col-md-9 col-xs-8 e2 ee totree'])) }}
        </div>
        <div class="col-md-3 col-xs-3">
            {{ Form::text('totree',$MtsChartAc2->last(), array_merge(['class' => 'form-control numbertotree'])) }}
        </div>
    </div>


