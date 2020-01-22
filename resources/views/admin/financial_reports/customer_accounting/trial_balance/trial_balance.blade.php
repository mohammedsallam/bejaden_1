@extends('admin.index')
@section('title', trans('admin.trial_balance'))
@section('content')
    @push('css')
        <style>
            .select2-container--default .select2-selection--multiple .select2-selection__choice{
                background-color: #333;
            }

            .toggleClick{
                color: red;
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
                    $(".details_row").css("display","none");
                    if (this){
                        $.ajax({
                            url: '{{route('show_trial_balance')}}',
                            type:'get',
                            dataType:'html',
                            data:{mainCompany: mainCompany},
                            success: function (data) {
                                $("#loadingmessage-1").css("display","none");
                                $('.details_row').css("display","block").html(data);

                            }
                        });
                    }else{
                        $('.details_row').html('');
                    }
                });



            });
        </script>
        <script>
            $(document).ready(function(){
                $('input[type="checkbox"]').click(function(){
                    $(this).prop("checked",true);

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
                    {{--            placeholder: "{{trans('admin.select')}}",--}}
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

            // number maincompany
            $(document).on('change','.MainCompany',function () {
                var value = $(this).val();

                $('.number_company').val(value);
            });

            $('#reviewBalance').click(function () {
                $('#level_num').attr("disabled", true);
            });
            // $(document).ready(function(){
            //     $('#reviewBalance').click(function() {
            //         if($('#levelBalance').prop('checked') === true){
            //             $(this).prop('checked', false).siblings('label').addClass('toggleClick');
            //             $('#levelBalance').prop('checked', true).siblings('label').removeClass('toggleClick')
            //         } else if ($(this).prop('checked') === true) {
            //             $('#levelBalance').prop('checked', false).siblings('label').addClass('toggleClick')
            //         }else if ($(this).prop('checked') === false) {
            //             $('#levelBalance').siblings('label').removeClass('toggleClick')
            //         }
            //     });
            //
            //     $('#levelBalance').click(function() {
            //         if($('#reviewBalance').prop('checked') === true){
            //             $(this).prop('checked', false).siblings('label').addClass('toggleClick')
            //         } else if ($(this).prop('checked') === true) {
            //             $('#reviewBalance').prop('checked', false).siblings('label').addClass('toggleClick')
            //         }else if ($(this).prop('checked') === false) {
            //             $('#reviewBalance').siblings('label').removeClass('toggleClick')
            //         }
            //
            //     });
            //
            // });
            $(document).on('change','#select_check :checkbox[id=but_sales_check]',function () {

            if($(this).is(':checked')){
                $('#sales_check').removeAttr('disabled');
                calcTax();
            }
            else{
                $('#sales_check').attr('disabled','disabled');

            }

        });

        $('#select_check :checkbox[id=but_state_check]').change(function(){
            if($(this).is(':checked')){
                $('#state_check').removeAttr('disabled');
                calcTax();
            }
            else{
                $('#state_check').attr('disabled','disabled');

            }
        });

        </script>

    @endpush

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{trans('admin.trial_balance_cust')}}</h3>
        </div>
        @include('admin.layouts.message')
        <div class="box-body">

            <div class="row">
                <div class="col-md-6 col-xs-12">
                    {{ Form::label('MainCompany','الشركه', ['class' => 'col-md-2 col-xs-3']) }}
                    {{ Form::select('MainCompany',$MainCompany,null, array_merge(['class' => 'col-md-8 col-xs-9 form-control e2 MainCompany','placeholder'=> trans('admin.select')])) }}
                </div>
                <div class="checkonly col-md-6 col-xs-12">
                    <div class="col-md-6 col-xs-6">
                        <input class="col-xs-2 delegates" name="delegates" type="checkbox" value="1"  >
                        <label>كل المندوبين</label>
                    </div>
                    <div class="col-md-6 col-xs-6">
                        <input class="col-xs-2 mtscustomer" name="mtscustomer" type="checkbox"  value="1" >
                        <label>كل العملاء</label>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="details_row col-md-5 col-xs-12" id="select_check">
                <div class="row">
                    <div class="col-md-9 col-xs-9">
                        <input type="checkbox" class="col-md-1 col-xs-1" id='but_sales_check'>
                        {{ Form::label('sales_select','المندوب ', ['class' => 'col-md-3 col-xs-3']) }}
                        {{ Form::select('sales_select',[],null, array_merge(['class' => 'form-control col-md-8 col-xs-8 e2 ee', 'disabled', 'id'=>'sales_check'])) }}
                    </div>
                    <div class="col-md-3 col-xs-3">
                        {{ Form::text('sales_select_no',null, array_merge(['class' => 'form-control'])) }}
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
                        {{ Form::label('tree','الى حساب', ['class' => 'col-md-3 col-xs-4']) }}
                        {{ Form::select('fromtree',[],null, array_merge(['class' => 'form-control col-md-9 col-xs-8 e2 fromtree ee'])) }}
                    </div>
                    <div class="col-md-3 col-xs-3">
                        {{ Form::text('fromtree',null, array_merge(['class' => 'form-control numberfromtree'])) }}
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-9 col-xs-9">
                        {{ Form::label('tree','من حساب', ['class' => 'col-md-3 col-xs-4']) }}
                        {{ Form::select('totree',[],null, array_merge(['class' => 'form-control col-md-9 col-xs-8 e2 ee totree'])) }}
                    </div>
                    <div class="col-md-3 col-xs-3">
                        {{ Form::text('totree',null, array_merge(['class' => 'form-control numbertotree'])) }}
                    </div>
                </div>

            </div>
            <div class="col-md-7 col-xs-12 well well-sm">
                <div class="col-xs-12">
                    <div class="col-xs-6">
                        {{ Form::label('From', trans('admin.From'), ['class' => 'col-md-2 col-xs-3']) }}
                        {{ Form::text('From',\Carbon\Carbon::today()->format('Y-'.\Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::now()->copy()->addYear()).'-'.\Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::now()->copy()->addYear())), array_merge(['class' => 'col-md-10 col-xs-9 form-control  hijri-date-input','id'=>'froxsate','autocomplete'=>'off'])) }}
                    </div>
                    <div class="col-xs-6">
                        {{ Form::label('To', trans('admin.To'), ['class' => 'col-md-2 col-xs-3']) }}
                        {{ Form::text('To',\Carbon\Carbon::today()->format('Y-m-d'), array_merge(['class' => 'col-md-10 col-xs-9 form-control  hijri-date-input date','id'=>'toDate'])) }}

                    </div>
                </div>
                <br>
                <br>
                <br>
                <div class="col-md-12 col-xs-12 well" style="background-color: #d3d3d3;">
                    <div class="col-md-6 col-xs-6">
                        <div class="col-xs-12 custom-control custom-radio">
                            <input type="radio" class="department" id="total_department" name="department" value="1" checked>
                            <label class="custom-control-label" for="total_department" >جميع الحسابات </label>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="col-xs-12 custom-control custom-radio">
                            <input type="radio" class="department" id="money_department" name="department" value="2">
                            <label for="money_department">  حسابات بارصدة </label>
                        </div>
                        <br>
                        <br>
                        <br>



                    </div>
                    <div class="col-xs-6">
                        <div class="col-xs-12 custom-control custom-radio">
                            <input type="radio" class="department" id="debt_department" name="department" value="3">
                            <label class="custom-control-label" for="debt_department">حسابات مدينه </label>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="col-xs-12 custom-control custom-radio">
                            <input type="radio" class="department" id="credit_department" name="department" value="4">
                            <label for="credit_department">  حسابات دائنه </label>
                        </div>
                        <br>
                        <br>
                        <br>


                    </div>
                </div>

            </div>

        </div>




    <br>
    {{--loader spinner--}}
    <div id='loadingmessage_1' style='display:none; margin-top: 20px' class="text-center">
        <img src="{{ url('/') }}/images/ajax-loader.gif"/>
    </div>
    <div id="report">
        <div class="column_form">

        </div>
    </div>
    <br>
    </div>


@endsection
