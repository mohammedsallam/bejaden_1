@extends('admin.index')
@section('title',trans('admin.account_statement'))

@section('content')
@push('css')
<style>
    .bg-warning {
        background-color: #ffc107!important;

    }

</style>

<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        background-color: #333;
    }
    @if(session('lang') == 'ar')
                .datepicker{
        direction: rtl
    }
    @endif

</style>
@endpush
@push('js')
{{--    <script>--}}
{{--        $(function () {--}}
{{--            'use strict'--}}

{{--            $(".MainCompany").on("change",function(){--}}
{{--                var mainCompany = $(this).val();--}}
{{--                var mainCompany = $(this).val();--}}

{{--                $("#loadingmessage-1").css("display","block");--}}
{{--                $(".column_account").css("display","none");--}}
{{--                if (this){--}}
{{--                    $.ajax({--}}
{{--                        url: '{{route('branche')}}',--}}
{{--                        type:'get',--}}
{{--                        dataType:'html',--}}
{{--                        data:{mainCompany: mainCompany},--}}
{{--                        success: function (data) {--}}
{{--                            $("#loadingmessage-1").css("display","none");--}}
{{--                            $('.column_account').css("display","block").html(data);--}}

{{--                        }--}}
{{--                    });--}}
{{--                }else{--}}
{{--                    $('.column_account').html('');--}}
{{--                }--}}
{{--            });--}}


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
        $(function () {
            'use strict'

            $(".MainCompany").on("change",function(){
                var mainCompany = $(this).val();


                $("#loadingmessage-2").css("display","block");
                $(".details_row").css("display","none");
                if (this){
                    $.ajax({
                        url: '{{route('acc_state')}}',
                        type:'get',
                        dataType:'html',
                        data:{mainCompany: mainCompany},
                        success: function (data) {
                            $("#loadingmessage-1").css("display","none");
                            $('.details_row').css("display","block").html(data);

                        }
                    });
                }else{
                    $('.column_account').html('');
                }
            });


        });
    </script>

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
@endpush
<div class="box">
    <div class="box-header">
        <h3 class="box-title">كشف حساب للحسابات العامة</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                {{ Form::label('maincompany','الشركات', ['class' => 'control-label']) }}
                {{ Form::select('MainCompany',$MainCompany,null, array_merge(['class' => 'form-control MainCompany e2 fromtree','placeholder'=> trans('admin.select') ])) }}
            </div>
            <div class="details_row">
            <div class="col-md-2 ">
                {{ Form::label('tree','من حساب', ['class' => 'control-label']) }}
                {{ Form::select('fromtree',[],null, array_merge(['class' => 'form-control  e2 ee fromtree','placeholder'=> trans('admin.select') ])) }}
            </div>
            <div class="col-md-2">
                {{ Form::label('tree','من', ['class' => 'control-label']) }}
                {{ Form::select('fromtree',[],null, array_merge(['class' => 'form-control  e2 ee fromtree','placeholder'=> trans('admin.select') ])) }}
            </div>
            <div class="col-md-2">
                {{ Form::label('tree','الي حساب', ['class' => 'control-label']) }}
                {{ Form::select('totree',[],null, array_merge(['class' => 'form-control e2 totree','placeholder'=> trans('admin.select') ])) }}
            </div>
              <div class="col-md-2">
                {{ Form::label('tree','الي', ['class' => 'control-label']) }}
                {{ Form::select('totree',[],null, array_merge(['class' => 'form-control e2 totree','placeholder'=> trans('admin.select') ])) }}
            </div>

            </div>





                </div>

        <div class="row">

                <div class="col-md-6">
                    {{ Form::label('From', trans('admin.From'), ['class' => 'control-label']) }}
                    {{ Form::text('From',\Carbon\Carbon::today()->format('Y-'.\Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::now()->copy()->addYear()).'-'.\Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::now()->copy()->addYear())), array_merge(['class' => 'form-control from date','required'=>'required','autocomplete'=>'off'])) }}
                </div>
                <div class="col-md-6">
                    {{ Form::label('To', trans('admin.To'), ['class' => 'control-label']) }}
                    {{ Form::text('To',\Carbon\Carbon::today()->format('Y-m-d'), array_merge(['class' => 'form-control to date','required'=>'required','autocomplete'=>'off'])) }}
                </div>

            </div>
        </div>


       <br>



    {{--loader spinner--}}
    <div id='loadingmessage-1' style='display:none; margin-top: 20px' class="text-center">
        <img src="{{ url('/') }}/images/ajax-loader.gif"/>
    </div>

    <br>

        <div class="row">
            <div class="button_print" style="position: absolute; right: 60px;">

            </div>
            <div class="back">
                <a class="btn btn-danger" href="javascript:history.back()">الرجوع</a>

            </div>

        </div>


</div>
</div>


@endsection
