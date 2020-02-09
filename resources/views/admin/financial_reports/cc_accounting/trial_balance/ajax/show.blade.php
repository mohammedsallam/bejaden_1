<script>
    $(document).on('change','.fromtree',function () {
        var fromtree = $(this).val();
        $('.number_fromtree').val(fromtree);
        var MainCompany = '{{isset($MainCompany) ? $MainCompany : null}}';
        var level = $('#level_check').val();
        var radiodepartment =  $('input[name="department"]:checked').val();
        var from =  $('input[name="From"]').val();
        var to =  $('input[name="To"]').val();

        $(".print_div").css("display","none");
        if (this) {
            $.ajax({
                url: '{{route('movementTrialbalance.details')}}',
                type: 'get',
                dataType: 'html',
                data: {MainCompany: MainCompany,
                    level: level,
                    fromtree: fromtree,
                    from: from,
                    to: to,
                    radiodepartment: radiodepartment,
                },
                success: function (data) {
                    $("#loadingmessage-2").css("display", "none");
                    $('.print_div').css("display", "block").html(data);
                }
            });
        }
    });

    $(document).on('change','#level_check',function () {
        var level = $(this).val();
        var MainCompany = '{{isset($MainCompany) ? $MainCompany : null}}';
        var fromtree = $('.fromtree').val();
        $('.number_fromtree').val(fromtree);
        var radiodepartment =  $('input[name="department"]:checked').val();
        var from =  $('input[name="From"]').val();
        var to =  $('input[name="To"]').val();

        $(".print_div").css("display","none");
        if (this) {
            $.ajax({
                url: '{{route('movementTrialbalance.details')}}',
                type: 'get',
                dataType: 'html',
                data: {MainCompany: MainCompany,
                    level: level,
                    fromtree: fromtree,
                    from: from,
                    to: to,
                    radiodepartment: radiodepartment,
                },
                success: function (data) {
                    $("#loadingmessage-2").css("display", "none");
                    $('.print_div').css("display", "block").html(data);

                }
            });
        }

    });

    $(document).on('change','.fromtree',function () {
        var fromtree = $(this).val();
        var MainCompany = '{{isset($MainCompany) ? $MainCompany : null}}';
        $.ajax({
            url: '{{route('get_levels')}}',
            type: 'get',
            dataType: 'html',
            data: {MainCompany: MainCompany, fromtree:fromtree},
            success:function ($data) {
                $('#level_check').html($data)
            }
        });
    });

    $(document).ready(function () {
        if ("{{$fromtree,$totree}}"){
            var MainCompany = '{{isset($MainCompany) ? $MainCompany : null}}';
            var level = $('#level_check').val();
            var fromtree = $('.efirst').val();
            var totree = $('.elast').val();
            var radiodepartment =  $('input[name="department"]:checked').val();
            var from =  $('input[name="From"]').val();
            var to =  $('input[name="To"]').val();
            var but_level_check =  $('input[id="but_level_check"]:checked').val();

            $(".print_div").css("display","none");
            if (this) {
                $.ajax({
                    url: '{{route('movementTrialbalance.details')}}',
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
        $('#toDate,#fromDate').on('blur',function(){
            var to =  $('input[name="To"]').val();
            var MainCompany = '{{isset($MainCompany) ? $MainCompany : null}}';
            var level = $('#level_check').val();
            var fromtree = $('.efirst').val();
            var radiodepartment =  $('input[name="department"]:checked').val();
            var from =  $('input[name="From"]').val();

            $(".print_div").css("display","none");
            if (this) {
                $.ajax({
                    url: '{{route('movementTrialbalance.details')}}',
                    type: 'get',
                    dataType: 'html',
                    data: {MainCompany: MainCompany,
                        level: level,
                        fromtree: fromtree,
                        from: from,
                        to: to,
                        radiodepartment: radiodepartment,
                    },
                    success: function (data) {
                        $("#loadingmessage-2").css("display", "none");
                        $('.print_div').css("display", "block").html(data);

                    }
                });
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
<div class="details_level">
    <div class="row" >
        <div class="col-xs-9">
            {{ Form::label('tree','مراكز التكلفه', ['class' => 'col-xs-3 control-label']) }}
            {{ Form::select('fromtree',$MtsCostcntr,$fromtree, array_merge(['class' => 'form-control col-xs-9 e2 efirst fromtree'])) }}
        </div>
        <div class="col-xs-3">
            {{ Form::text('number_fromtree',$MtsCostcntr3->first(), array_merge(['class' => 'form-control number_fromtree'])) }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-xs-12">
        {{ Form::label('level','المستوى', ['class' => 'col-md-2 control-label']) }}
        <select name="level" class="form-control col-xs-10" id="level_check">
            <option>{{trans('admin.select')}}</option>
        </select>
    </div>
</div>




