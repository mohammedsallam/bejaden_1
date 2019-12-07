@extends('admin.index')
@inject('branches', 'App\Models\Admin\MainBranch')


@section('title',trans('admin.show_profile_to') .session_lang($supervisor->Mrkt_NmEn,$supervisor->Mrkt_NmAr))
@section('content')
    @push('js')
        <script>

        $(document).ready(function(){

            $('#type').select2({
                    placeholder: "Select a State",
                    allowClear: true,
                    dir : '{{direction()}}'
                });

            $('#departments a').click(function (e) {
              e.preventDefault()
              $(this).tab('show')
            });

             $("#countries").change(function(){
                //get governorates
                var country_id = $(this).val();

                 if(country_id){
                        $.ajax({
                        url : "{{route('getCities')}}",
                        type : 'get',
                        dataType:'html',
                        data:{country_id:country_id},
                        success : function(res){
                            $('#cities').html(res)
                        }
                    })
                 }


            });

         // $(document).on('change', "#cities", function(){
         //    alert($(this).val())
         // })

         // $("#cities").change(function(){
         //    alert($(this).val())
         // })

         $("#companies").change(function(){
                //get governorates
                var company_id = $(this).val();

                 if(company_id){
                        $.ajax({
                            url : "{{route('getBranches')}}",
                            type : 'get',
                            dataType:'html',
                            data:{Cmp_No:Cmp_No},
                            success : function(res){
                                $('#branches').html(res)
                        }
                    })
                 }


            });



        })


        </script>

    @endpush

    @push('css')
    <style>
        @if(session('lang') == 'ar')
            .datepicker{
            direction: rtl;
        }
        @endif
    </style>
    @endpush
<div class="box">
    @include('admin.layouts.message')
    <div class="box-header">
        <h3 class="box-title"></h3> {{-- {{$title}} --}}
    </div>
    <div>

  {{Form::model($supervisor,['method'=>'PUT','route'=>['supervisors.update',$supervisor->ID_No],'class'=>'form-group','files'=>true])}}
        <div class="box-body">

            @can('single')


                <div class="col-md-6">

                <div class="form-group row col-md-12">

                    <div class="form-group">
                        <div class="col-md-1" style="left: 8px;">
                            {!!Form::label('Brn_No', trans('admin.branche'))!!}
                        </div>
                        <div class="col-md-11" style="margin-bottom: 10px; padding-left: 41px; left: -5px;">
                            {!!Form::text('Brn_No', null, ['class'=>'form-control', 'readonly'=>'true'])!!}

                        </div>

                    </div>

                </div>
                <div class="form-group row">
                    <div class="form-group row col-md-6">
                        <div class="col-md-3" style="left: 2px;">{!!Form::label('Mrkt_No', trans('admin.Mrkt_No'))!!}</div>
                        <div class="col-md-9" style="margin-bottom: 10px;">{!!Form::text('Mrkt_No', null, ['class'=>'form-control', 'readonly'=>'true'])!!}</div>
                    </div>

                </div>
                <div class="form-group row col-md-12">
                    <div class="col-md-12">
                        <div class="col-md-1" style="margin-right: -47px;left: -18px;">{!!Form::label('Mrkt_NmAr', trans('admin.subscriber_name_ar'))!!}</div>
                        <div class="col-md-11" style="margin-bottom: 10px;right: 27px;">{!!Form::text('Mrkt_NmAr', null, ['class'=>'form-control', 'readonly'=>'true'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-1" style="margin-right: -47px;left: -18px;">{!!Form::label('Mrkt_NmrEn', trans('admin.subscriber_name_en'))!!}</div>
                        <div class="col-md-11" style="margin-bottom: 10px;right: 27px;">{!!Form::text('Mrkt_NmEn', null, ['class'=>'form-control', 'readonly'=>'true'])!!}</div>
                    </div>
                </div>

            </div>

            <div class="col-md-6">


            @else
                <div class="alert alert-danger">{{trans('admin.you_cannt_see_invoice_because_you_dont_have_role_to_access')}}</div>

            @endcan
            </div>


    </div>


</div>
@endsection
