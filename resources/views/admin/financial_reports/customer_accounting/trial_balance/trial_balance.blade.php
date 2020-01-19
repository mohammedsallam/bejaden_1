@extends('admin.index')
@section('title', trans('admin.trial_balance'))
@section('content')
    @push('css')
        <style>
            .select2-container--default .select2-selection--multiple .select2-selection__choice{
                background-color: #333;
            }
        </style>

    @endpush
    @push('js')

<script>
    $(function () {
        'use strict'

        $(".MainCompany").on("change",function(){
            var mainCompany = $(this).val();
            $('.column-form').html('');
            $("#loadingmessage-1").css("display","block");
            $(".div_branch").css("display","none");
            if (this){
                $.ajax({
                    url: '{{route('branche_trial_balance')}}',
                    type:'get',
                    dataType:'html',
                    data:{mainCompany: mainCompany},
                    success: function (data) {
                        $("#loadingmessage-1").css("display","none");
                        $('.div_branch').css("display","block").html(data);

                    }
                });
            }else{
                $('.div_branch').html('');
            }
        });



        });
</script>
<script>

    $(function () {
        'use strict';

        $('.reporttype,.kind,.level').on('change',function () {

            var MainCompany = $( ".MainCompany option:selected" ).val();
            var MainBranch = $( ".MainBranch option:selected" ).val();
            var reporttype = $( ".reporttype option:selected" ).val();
            var kind = $( ".kind option:selected" ).val();
            var level = $( ".level option:selected" ).val();



            if (this){
                $("#loadingmessage").css("display","block");
                $(".column-form").css("display","none");
                $.ajax({
                    url: '{{route('trialbalance.show')}}',
                    type:'get',
                    dataType:'html',
                    data:{MainCompany:MainCompany,MainBranch:MainBranch,reporttype:reporttype,kind:kind,level:level},
                    success: function (data) {
                        $("#loadingmessage").css("display","none");
                        $('.column-form').css("display","block").html(data);
                        var minDate = '{{\Carbon\Carbon::today()->format('Y-m-d')}}';
                        $('.datepicker').datepicker({
                            format: 'yyyy-mm-dd',
                            rtl: true,
                            language: '{{session('lang')}}',
                            autoclose:true,
                            todayBtn:true,
                            clearBtn:true,
                        });
                    }
                });
            }else{
                $('.column-form').html('');
            }
        });


    });
</script>
{{--<script>--}}

{{--        $(function () {--}}
{{--            'use strict'--}}
{{--            if ($( ".MainCompany option:selected" ).val() && $( ".MainCompany option:selected" ).val() &&--}}
{{--                $( ".MainCompany option:selected" ).val() && $( ".MainCompany option:selected" ).val()--}}

{{--            )--}}



{{--        });--}}
{{--    </script>--}}



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

<script>
    $("#seeAnotherField").change(function() {

        if ($("#seeAnotherField").val() == 0 &&  $(".MainBranch").val() && $(".MainCompany").val()) {
            $('#otherField').attr('disabled', 'disabled');

        }else if  ($("#seeAnotherField").val() == 1) {
            $('#otherField').removeAttr('disabled');

        }else if($("#seeAnotherField").val() == 0)
        {
            $('#otherField').attr('disabled', 'disabled');
        }

    });

</script>

    @endpush

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{trans('admin.trial_balance')}}</h3>
        </div>
        @include('admin.layouts.message')
        <div class="box-body">

            <div class="form-group row">
                <div class="col-md-6">
                    {{ Form::label('MainCompany','الشركات', ['class' => 'control-label']) }}
                    {{ Form::select('MainCompany',$MainCompany,null, array_merge(['class' => 'form-control e2 ee  MainCompany','placeholder'=> trans('admin.select') ])) }}
                </div>
                <div class="col-md-6 div_branch">

                    {{ Form::label('MainBranch','الفروع', ['class' => 'control-label']) }}
                    {{ Form::select('MainBranch',[],null, array_merge(['class' => 'form-control MainBranch e2 eeerr' ,'placeholder'=> trans('admin.select') ])) }}

                </div>
            </div>

                <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('reporttype',trans('admin.report_type'), ['class' => 'control-label']) }}
                    {{ Form::select('reporttype',\App\Enums\dataLinks\BalanceReviewType::toSelectArray(),null, array_merge(['class' => 'form-control e3 reporttype','placeholder'=> trans('admin.select') , 'id' => 'seeAnotherField' ])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('kind',trans('admin.type'), ['class' => 'control-label']) }}
                    {{ Form::select('kind',\App\Enums\dataLinks\AccountTypeType::toSelectArray(),0, array_merge(['class' => 'form-control kind','placeholder'=> trans('admin.select') ])) }}
                </div>
                <div class="col-md-4" id="otherFieldDiv">
                    {{ Form::label('level',trans('admin.level'), ['class' => 'control-label']) }}
                    {{ Form::selectRange('level',1,7,1, array_merge(['class' => 'form-control level', 'id' => 'otherField'])) }}
                </div>
            </div>
            <br>
            {{--loader spinner--}}
            <div id='loadingmessage_1' style='display:none; margin-top: 20px' class="text-center">
                <img src="{{ url('/') }}/images/ajax-loader.gif"/>
            </div>
            <div id="report">
                <div class="column-form">

                </div>
            </div>
            <br>


        </div>
    </div>
    {{--<button class="btn btn-default" onclick="printPageArea()" id="primaryButton"><i class="fa fa-print"></i> {{trans('admin.print')}} </button>--}}

@endsection
