@extends('admin.index')
@section('title',trans('admin.account_statement'))

@section('content')
@push('css')
<style>
    .bg-warning {
        background-color: #ffc107!important;

    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        background-color: #333;
    }
    @if(session('lang') == 'ar')
                .datepicker{
        direction: rtl
    }
    @endif
</style>




{{--    Date Hijri--}}
<link rel="stylesheet" href="{{url('/')}}/adminlte/dateHijri/dist/css/bootstrap-datetimepicker.min.css">

@endpush

@push('js')
    <script src="{{url('/')}}/adminlte/dateHijri/dist/js/bootstrap-hijri-datepicker.min.js"></script>

    <script>












        $(function () {
            'use strict'
            $('.e2').select2({
                placeholder: "{{trans('admin.select')}}",
                dir: '{{direction()}}'
            });
        });

        $(function () {
            'use strict'

            $(".MainCompany").on("change",function(){
                var mainCompany = $(this).val();


                $("#loadingmessage-1").css("display","block");
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

        $(".hijri-date-input").hijriDatePicker(
            {
                hijri : false,
                format: "YYYY-MM-DD",
                hijriFormat: 'iYYYY-iMM-iDD',
                showTodayButton:true,
            });

        {{--$(document).ready(function(){--}}
        {{--    var minDate = '{{\Carbon\Carbon::today()->format('Y-m-d')}}';--}}
        {{--    console.log(minDate);--}}
        {{--    $('.date').datepicker({--}}
        {{--        format: 'yyyy-mm-dd',--}}
        {{--        rtl: true,--}}
        {{--        language: '{{session('lang')}}',--}}
        {{--        autoclose:true,--}}
        {{--        todayBtn:true,--}}
        {{--        clearBtn:true,--}}
        {{--    });--}}
        {{--});--}}
</script>


@endpush
<div class="box">
    <div class="box-header">
        <h3 class="box-title">كشف حساب للحسابات العامة</h3>
    </div>
    <div class="box-body row">
      <div class="col-md-6">
          <div class="row">
              <div class="col-md-12">
                  {{ Form::label('maincompany','الشركات', ['class' => 'col-md-2']) }}
                  {{ Form::select('MainCompany',$MainCompany,null, array_merge(['class' => 'col-md-10 form-control MainCompany e2 fromtree','placeholder'=> trans('admin.select') ])) }}


              </div>

          </div>
          <br>
            <div class="details_row">
          <div class="row">
              <div class="col-md-10">
                  {{ Form::label('tree','من حساب', ['class' => 'col-md-3']) }}
                  {{ Form::select('fromtree',[],null, array_merge(['class' => 'col-md-8  form-control  e2 ee fromtree','placeholder'=> trans('admin.select') ])) }}
              </div>

              <div class="col-md-2">
                  {{ Form::select('fromtree',[],null, array_merge(['class' => 'form-control e2 fromtree','placeholder'=> trans('admin.select') ])) }}

              </div>
          </div>
          <br>
          <div class="row">
              <div class="col-md-10">
                  {{ Form::label('tree','الى حساب', ['class' => 'col-md-3']) }}
                  {{ Form::select('totree',[],null, array_merge(['class' => 'col-md-8  form-control  e2 ee totree','placeholder'=> trans('admin.select') ])) }}
              </div>

              <div class="col-md-2">
                  {{ Form::select('totree',[],null, array_merge(['class' => 'form-control e2 totree','placeholder'=> trans('admin.select') ])) }}

              </div>
          </div>
            </div>




      </div>
    <div class="col-md-6">

{{--        <div class="row">--}}
{{--            <div class="col-md-6">--}}
{{--                <label class="radio-inline" ><input type="radio" name="date" checked>التاريخ الميلادي</label>--}}


{{--            </div>--}}
{{--            <div class="col-md-6">--}}

{{--                <label class="radio-inline" ><input class="" type="radio" name="date" >التاريخ الهجري</label>--}}

{{--            </div>--}}
{{--        </div>--}}
        <br>



        <div class="row">
            <div class="col-md-12">
                {{ Form::label('From', trans('admin.From'), ['class' => 'col-md-2']) }}
                {{ Form::text('From',\Carbon\Carbon::today()->format('Y-'.\Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::now()->copy()->addYear()).'-'.\Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::now()->copy()->addYear())), array_merge(['class' => 'col-md-8 form-control from hijri-date-input','required'=>'required','autocomplete'=>'off'])) }}
            </div>
        </div>
        <br>
        <div class="row">
                <div class="col-md-12">
                    {{ Form::label('To', trans('admin.To'), ['class' => 'col-md-2']) }}
                    {{ Form::text('To',\Carbon\Carbon::today()->format('Y-m-d'), array_merge(['class' => 'col-md-8 form-control to hijri-date-input date','required'=>'required'])) }}
                </div>
        </div>



        </div>



    </div>


    <div class="row">
        <div class="button_print">

        </div>
        <div>
            <a class="btn btn-danger" href="javascript:history.back()">الرجوع</a>

        </div>

    </div>



{{--    loader spinner--}}
    <div id='loadingmessage-1' style='display:none; margin-top: 20px' class="text-center">
        <img src="{{ url('/') }}/images/ajax-loader.gif"/>
    </div>





</div>



@endsection
