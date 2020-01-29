@extends('admin.index')
@section('title','القيود اليومية للحسابات العامة')

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
    <script>
        $(function () {
            'use strict'

            $(".date_limition").on("change",function(){
                var MainCompany = $('.MainCompany').val();
                var type = $('.type').val();
                var date_limition = $('.date_limition').val();
                // var mainCompany = $(this).val();
                alert(date_limition);

                $("#loadingmessage-1").css("display","block");
                $(".column_account").css("display","none");
                if (this){
                    $.ajax({
                        url: '{{route('branche')}}',
                        type:'get',
                        dataType:'html',
                        data:{mainCompany: mainCompany},
                        success: function (data) {
                            $("#loadingmessage-1").css("display","none");
                            $('.column_account').css("display","block").html(data);

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
    <script>
        $(function () {
            'use strict'
            $('.e2').select2({
                placeholder: "{{trans('admin.select')}}",
                dir: '{{direction()}}'
            });
        });

    </script>

@endpush
<div class="box">
    <div class="box-header">
        <h3 class="box-title">القيود اليومية للحسابات العامة</h3>
    </div>
    <div class="box-body">
        <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12" style="display: flex; flex-direction: row">
                            {{ Form::label('maincompany','الشركات', ['class' => 'control-label','style'=>'margin:1%']) }}
                            {{ Form::select('MainCompany',$MainCompany,null, array_merge(['class' => 'form-control MainCompany','placeholder'=> trans('admin.select') ])) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="display: flex; flex-direction: row; margin-top: 2%">
                            {{ Form::label('type',trans('admin.TypeOfConstraintOrBond'), ['class' => 'control-label','style'=>'margin:1%']) }}

                            {{ Form::select('type', $limitationReceipts,null, array_merge(['class' => 'form-control type','placeholder'=>trans('admin.select')])) }}
                        </div>
                    </div>
                </div>

        </div>


          <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        {{ Form::label('date_limition',trans('admin.date'), ['class' => 'control-label','style'=>'margin:1%']) }}
                        {{ Form::radio('date_limition','0') }}


                    </div>
                    <div class="col-md-6">
                        {{ Form::label('date_limition',trans('admin.limitation'), ['class' => 'control-label','style'=>'margin:1%']) }}

                        {{ Form::radio('date_limition','1') }}

                    </div>

                </div>

          </div>




        </div>
        <br>
        <br>
        <br>
        <div class="row details_row">

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
