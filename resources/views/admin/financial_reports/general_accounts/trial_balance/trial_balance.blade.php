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

            @media (min-width: 576px) {
                 .well{
                     margin-top: 0;
                     padding-top: 0;
                 }
            }


            @media (min-width: 768px) {

            }


            @media (min-width: 992px) {  }

            @media (min-width: 1200px) {
                .NumberTree

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
{{--        <script>--}}
{{--            $(function () {--}}
{{--                'use strict'--}}
{{--                $('.e2').select2({--}}
{{--                    --}}{{--            placeholder: "{{trans('admin.select')}}",--}}
{{--                    dir: '{{direction()}}'--}}
{{--                });--}}
{{--            });--}}
{{--        </script>--}}

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

            // $('#reviewBalance').click(function () {
            //     $('#level_num').attr("disabled", true);
            // });
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


        </script>

    @endpush

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{trans('admin.trial_balance')}}</h3>
        </div>
        @include('admin.layouts.message')
        <div class="box-body">
            <div class="row">
                <div class="col-md-6" >
                    <div style="display: flex">
                        {{ Form::label('MainCompany','الشركه', ['style' => 'width: 10%']) }}
                        {{ Form::select('MainCompany',$MainCompany,null, array_merge(['class' => 'e2 form-control MainCompany','placeholder'=> trans('admin.select')])) }}
                    </div>
                </div>
{{--<<<<<<< HEAD--}}
{{--                <div class="col-md-3" >--}}
{{--                    <div style="display: flex" >--}}
{{--                        {{ Form::label('level','المستوى', ['style' => 'width: 30%']) }}--}}
{{--                        {{ Form::select('level',[],null, array_merge(['class' => 'form-control', 'id'=>'level_num'])) }}--}}
{{--=======--}}
                <div class="checkonly col-xs-6">
                    <div class="col-xs-6">
                        {{ Form::label('level','المستوى', ['class' => 'col-xs-2 control-label']) }}
                        {{ Form::select('level',[],null, array_merge(['class' => 'form-control col-xs-10', 'id'=>'level_num'])) }}

                    </div>
                </div>
                <div class="col-md-3">
                    <div style="display: flex">
                        <input  class="trialBalance_1"  type="checkbox" id="reviewBalance" name="reviewBalance" value="1">
                        <label for="reviewBalance">  ميزان المراجعة لاستاذ المساعد </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div style="display: flex">
                        {{ Form::label('tree','من ', ['style' => 'width:9%']) }}
                        {{ Form::select('fromtree',[],null, array_merge(['class' => 'form-control e2 ee', 'style' => 'width:71%'])) }}
                        {{ Form::text('fromtree',null, array_merge(['class' => 'form-control NumberTree', 'style' => 'width: 20%'])) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div style="display: flex">
                        {{ Form::label('From', trans('admin.From'), ['style' => 'width: 32%']) }}
                        {{ Form::text('From',\Carbon\Carbon::today()->format('Y-'.\Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::now()->copy()->addYear()).'-'.\Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::now()->copy()->addYear())), array_merge(['class' => 'form-control  hijri-date-input','id'=>'froxsate','autocomplete'=>'off'])) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div style="display: flex">
                        <input type="radio" class="custom-control-input" id="defaultChecked" name="defaultExampleRadios">
                        <label class="custom-control-label" for="defaultChecked">حسابات مدينه </label>
                        <input type="radio" class="custom-control-input" id="defaultChecked" name="defaultExampleRadios">
                        <label class="custom-control-input" for="defaultChecked"> حسابات بارصدة </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div style="display: flex">
                        {{ Form::label('tree','الي ', ['style' => 'width:9%']) }}
                        {{ Form::select('fromtree',[],null, array_merge(['class' => 'form-control e2 ee', 'style' => 'width:71%'])) }}
                        {{ Form::text('fromtree',null, array_merge(['class' => 'form-control NumberTree', 'style' => 'width:20%'])) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div style="display: flex">
                        {{ Form::label('To', trans('admin.To'), ['style' => 'width: 32%']) }}
                        {{ Form::text('To',\Carbon\Carbon::today()->format('Y-m-d'), array_merge(['class' => 'form-control  hijri-date-input','id'=>'froxsate','autocomplete'=>'off'])) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div style="display: flex">
                        <input type="radio" class="custom-control-input" id="defaultChecked" name="defaultExampleRadios">
                        <label class="custom-control-input" for="defaultChecked">جميع الحسابات </label>
                        <input type="radio" class="custom-control-input" id="defaultChecked" name="defaultExampleRadios">
                        <label class="custom-control-label" for="defaultChecked">حسابات دائنة </label>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection
