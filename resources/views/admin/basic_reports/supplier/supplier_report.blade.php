@extends('admin.index')
@section('title',trans('admin.report_client'))
@section('content')
    @push('css')
        <style>


            .myradio__input {
                opacity: 0;
                position: absolute;
            }
            .myradio__label {
                border-radius: 9999px;
                padding: 5px 15px 5px 40px;
                cursor: pointer;
                position: relative;
                transition: all .5s;
            }
            .myradio__label::before, .myradio__label::after {
                content: "";
                border-radius: 9999px;
                width: 16px;
                height: 16px;
                margin: 3px 0;
                position: absolute;
                z-index: 1;
            }
            .myradio__label::before {
                background-color: #FFFFFF;
                border: 2px solid #DCDCDC;
                top: 4px;
                left: 10px;
                transition: all .5s;
            }
            .myradio__label::after {
                background-color: transparent;
                top: 6px;
                left: 12px;
                transition: all .2s;
                transition-timing-function: ease-out;
            }
            .myradio__label:hover::after {
                background-color: rgba(51, 170, 221, 0.08);
                transform: scale(2.5);
            }
            .myradio__input:checked ~ .myradio__label::before {
                background-color: #FFFFFF;
                border: 2px solid #33aadd;
            }
            .myradio__input:checked ~ .myradio__label::after {
                background-color: #33aadd;
                border: 2px solid transparent;
                top: 4px;
                left: 10px;
                transform: scale(0.6);
            }
            .myradio__input:checked ~ .myradio__label:hover::after {
                transform: scale(0.6);
            }

            .container {
                display: grid;
                grid-template-rows: 1fr auto;
                height: 95vh;
                min-height: 10rem;
                text-align: center;
            }

            .form {
                margin: 0;
            }

            .form {
                font-size: 1.8rem;
                margin: 5rem 0;
            }
        </style>
    @endpush
    <?php $to_glcc_select = null;?>
    @push('js')
        <script>
            $(document).ready(function() {

                $(".e2").select2({
                    placeholder: "{{trans('admin.select')}}",
                    // allowClear: true,
                    dir: '{{direction()}}'
                });
            });

        </script>
    @endpush

    @push('js')

        <script>
            $(document).ready(function(){

                $('.myradio__input').on('click',function(){
                    $("#loadingmessage").css("display","block");
                    $(".column-data").css("display","none");
                    var myradio = $(this).val();
                    console.log(myradio);
                    if (this){
                        $.ajax({
                            url: '{{route('cust_report_radio')}}',
                            type:'get',
                            dataType:'html',
                            data:{myradio : myradio},
                            success: function (data) {
                                $("#loadingmessage").css("display","none");
                                $('.column-data').css("display","block").html(data);

                            }
                        });
                    }else{
                        $('.column-data').html('');
                    }


                });
            });
        </script>

        {{--        <script>--}}

        {{--                $('#one').on('click',function () {--}}


        {{--                    $("#loadingmessage").css("display","block");--}}
        {{--                    $(".column-data").css("display","none");--}}

        {{--                    if (this){--}}
        {{--                        $.ajax({--}}
        {{--                            url: '{{aurl('cc/report/motioncc/show')}}',--}}
        {{--                            type:'get',--}}
        {{--                            dataType:'html',--}}
        {{--                            data:{from_glcc : from_glcc,to_glcc : to_glcc},--}}
        {{--                            success: function (data) {--}}
        {{--                                $("#loadingmessage").css("display","none");--}}
        {{--                                $('.column-data').css("display","block").html(data);--}}

        {{--                            }--}}
        {{--                        });--}}
        {{--                    }else{--}}
        {{--                        $('.column-data').html('');--}}
        {{--                    }--}}
        {{--                });--}}


        {{--            });--}}
        {{--        </script>--}}


    @endpush


    <div class="box">
        @include('admin.layouts.message')
        @include('admin.layouts.error')
        <div class="box-header">
            <h3 class="box-title">{{trans('admin.report_client')}}</h3>
        </div>
        <div class="box-body">



            {{--    {{ Form::label('date', trans('admin.account_statement').' '.session_lang($operation->name_en,$operation->name_ar), ['class' => 'control-label text-center']) }}--}}
            <div class="row">
                <div class="col-md-2">
                    <input  value="1" type="radio" name="myRadio" id="one" class="myradio__input" >
                    <label for="one" class="myradio__label">الشركة</label>
                </div>
                <div class="col-md-2">
                    <input   value="2" type="radio" name="myRadio" id="two" value="branches" class="myradio__input" >
                    <label for="two" class="myradio__label">الفرع</label>
                </div>
                <div class="col-md-2">
                    <input  value="3"  value="city" type="radio" name="myRadio" id="three" class="myradio__input">
                    <label for="three" class="myradio__label">المندوب</label>
                </div>

                <div class="col-md-2">
                    <input value="4" type="radio" name="myRadio" id="four" class="myradio__input">
                    <label for="four" class="myradio__label">نوع النشاط</label>
                </div>
                <div class="col-md-2">
                    <input value="5" type="radio" name="myRadio" id="five" class="myradio__input">
                    <label for="five" class="myradio__label">تصنيف العملاء</label>
                </div>
                <div class="col-md-2">
                    <input value="6" type="radio" name="myRadio" id="sex" class="myradio__input">
                    <label for="sex" class="myradio__label">الدولة</label>
                </div>
                <div class="col-md-2">
                    <input value="7" type="radio" name="myRadio" id="seven" class="myradio__input">
                    <label for="seven" class="myradio__label">المدينة</label>
                </div>
                <div class="col-md-2">
                    <input value="8" type="radio" name="myRadio" id="eight" class="myradio__input">
                    <label for="eight" class="myradio__label">المنطقة</label>
                </div>
                <div class="col-md-2">
                    <input value="9" type="radio" name="myRadio" id="nine" class="myradio__input">
                    <label for="nine" class="myradio__label">تصنيف الحسابات</label>
                </div>
                <div class="col-md-2">
                    <input value="10" type="radio" name="myRadio" id="ten" class="myradio__input">
                    <label for="ten" class="myradio__label">مشرف المبيعات</label>
                </div>
            </div>


            <div id='loadingmessage' style='display:none; margin-top: 20px' class="text-center">
                <img src="{{ url('/') }}/images/ajax-loader.gif"/>
            </div>

            <div class="column-data">


            </div>

        </div>


    {{--<button class="btn btn-default" onclick="printPageArea()" id="primaryButton"><i class="fa fa-print"></i> {{trans('admin.print')}} </button>--}}



@endsection
