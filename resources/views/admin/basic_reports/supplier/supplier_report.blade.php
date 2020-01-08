@extends('admin.index')
@section('title',trans('admin.report_supplier'))
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

            $(document).ready(function(){

                $('.mainCompany').on('change',function(){
                    $("#loadingmessage").css("display","block");
                    $(".column-data").css("display","none");
                    var mainCompany = $('.mainCompany').val();

                    if (this){
                        $.ajax({
                            url: '{{route('get_branches')}}',
                            type:'get',
                            dataType:'html',
                            data:{mainCompany : mainCompany},
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

    @endpush

    <div class="box">
        @include('admin.layouts.message')
        @include('admin.layouts.error')

    <div class="box-body">

        <form action="{{route('activities.store')}}" method="POST">
            {{ csrf_field() }}
            <div class="panel panel-primary" style="width:100%; margin:auto auto;">
                <div class="panel-heading">
                    <div class="panel-title">
                        {{trans('admin.report_supplier')}}
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                            {{ Form::label('mainCompany','الشركة', ['class' => 'col-md-2']) }}
                            {{ Form::select('mainCompany',$mainCompany,null, array_merge(['class' => 'form-control e2 mainCompany col-md-9','placeholder'=> trans('admin.select') ])) }}

                    </div>
                    <div class="row">
                        <br>
                        {{ Form::label('MainBranch','الفرع', ['class' => 'col-md-2']) }}
                        <div class="column-data">
                        {{ Form::select('MainBranch',[],null, array_merge(['class' => 'form-control e2 MainBranch col-md-9','placeholder'=> trans('admin.select') ])) }}

                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>


    </div>


    <div id='loadingmessage' style='display:none; margin-top: 20px' class="text-center">
        <img src="{{ url('/') }}/images/ajax-loader.gif"/>
    </div>



    {{--<button class="btn btn-default" onclick="printPageArea()" id="primaryButton"><i class="fa fa-print"></i> {{trans('admin.print')}} </button>--}}



@endsection
