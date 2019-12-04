@extends('admin.index')
@section('title',trans('admin.Departments'))
@section('content')
@push('js')

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{trans('admin.delete')}}</h4>
                </div>
                {!! Form::open(['method' => 'DELETE', 'url' => '','id'=>'modal-delete']) !!}
                <div class="modal-body">
                    <p>{{trans('admin.You_Want_You_Sure_Delete_This_Record')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('admin.close')}}</button>
                    {!! Form::submit(trans('admin.delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#jstree').jstree({
                "core" : {
                    'data' : {!! load_dep('parent_id') !!},
                    "themes" : {
                        "variant" : "large"
                    },
                    "multiple" : false,
                    "animation" : 300
                },
                "checkbox" : {
                    "keep_selected_style" : false
                },
                "plugins" : [ "themes","html_data","dnd","ui","types" ]
            });
            $('#jstree').on('loaded.jstree', function() {
                $('#jstree').jstree('open_all');
            });
            $('#jstree').on("changed.jstree", function (e, data) {
                var i, j, r = [];
                var name = [];
                for (i=0,j=data.selected.length;i < j;i++){
                    r.push(data.instance.get_node(data.selected[i]).id);
                    name.push(data.instance.get_node(data.selected[i]).text);
                }
                $('#modal-delete').attr('action','{{aurl('departments')}}/'+r.join(', '));
                $.ajax({
                    url: "{{route('getEditBlade')}}",
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}", Acc_No: r },
                    success: function(data){
                        $('#chart_form').html(data);
                    }
                });

                //handle edit chart

                // if(r.join(', ') != ''){
                //     $('.showbtn_control').removeClass('hidden');
                //     $('.edit_dep').attr('href','{{aurl('departments')}}/'+r.join(', ')+'/edit');
                // }else{
                //     $('.showbtn_control').addClass('hidden');
                // }
            });

            $('#Level_Status').on('change', function(){
                if($(this).val() == 1){
                    $('#main_chart').removeClass('hidden');
                }
                else{
                    $('#main_chart').addClass('hidden');
                    $('#main_chart').val(null);
                }
            });

        });

    </script>
@endpush
    <div class="box">
        {{-- <div class="box-header">
            <h3 class="box-title">{{trans('admin.Departments')}}</h3>
            <a href="{{url('/admin/departments/create')}}" class="btn btn-primary" style="float: left;">{{trans('admin.Create_New_Department')}} </a>
        </div> --}}
        @include('admin.layouts.message')
        @include('admin.layouts.error')
        <!-- /.box-header -->
        <div class="box-body table-responsive" id="create_chart">
            <div class="row">
                <div class="col-md-6">
                    <div class="box-header">
                        <h3 class="box-title">{{$title}}</h3>
                    </div>
                    <div id="jstree" style="margin-top: 20px"></div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body" id="chart_form">
                        {!! Form::open(['method'=>'POST','route' => 'departments.store','files' => true]) !!}
                            {{-- رقم الشركه --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Cmp_No">{{trans('admin.cmp_no')}}</label>
                                    <select name="Cmp_No" id="Cmp_No" class="form-control">
                                        <option value="">{{trans('admin.select')}}</option>
                                        @if(count($cmps) > 0)
                                            @foreach($cmps as $cmp)
                                                <option value="{{$cmp->Cmp_No}}">{{$cmp->{'Cmp_Nm'.ucfirst(session('lang'))} }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            {{-- نهاية رقم الشركه --}}

                            {{-- اسم الحساب عربى --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Acc_NmAr">{{trans('admin.arabic_name')}}</label>
                                    <input type="text" name="Acc_NmAr" id="Acc_NmAr" class="form-control" value="{{old('Acc_NmAr')}}">
                                </div>
                            </div>
                            {{-- نهاية اشم الحساب عربى --}}
                            
                            {{-- اسم الحساب انجليزى --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Acc_NmEn">{{trans('admin.english_name')}}</label>
                                    <input type="text" name="Acc_NmEn" id="Acc_NmEn" class="form-control" value="{{old('Acc_NmEn')}}">
                                </div>
                            </div>
                            {{-- نهاية اسم الحساب انجليزى --}}

                            {{-- تصنيف الحساب --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Level_Status">{{trans('admin.department_type')}}</label>
                                    <select name="Level_Status" id="Level_Status" class="form-control">
                                        <option value="{{null}}">{{trans('admin.select')}}</option>
                                        @foreach(\App\Enums\dataLinks\TypeAccountType::toSelectArray() as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- نهاية تصنيف الحساب --}}

                            {{-- الحساب الرئيسى --}}
                            <div class="col-md-4 hidden" id="main_chart">
                                <div class="form-group">
                                    <label for="Parnt_Acc">{{trans('admin.main_account_chart')}}</label>
                                    <select name="Parnt_Acc" id="Parnt_Acc" class="form-control">
                                        <option value="{{null}}">{{trans('admin.select')}}</option>
                                        @if(count($chart) > 0)
                                            @foreach($chart as $ch)
                                                <option value="{{$ch->Acc_No}}">{{$ch->{'Acc_Nm'.ucfirst(session('lang'))} }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            {{-- نهاية الحساب الرئيسى --}}

                            {{-- نوع الحساب --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Acc_Typ">{{trans('admin.account_type')}}</label>
                                    {{ Form::select('Acc_Typ', \App\Enums\AccountType::toSelectArray() ,old('Acc_Typ'), 
                                        array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                                </div>
                            </div>
                            {{-- نهاية نوع الحساب --}}

                            {{-- التصنيف بالحسابات الختاميه --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Clsacc_No">{{trans('admin.final_counting_classfication')}}</label>
                                    {{ Form::select('Clsacc_No', \App\Enums\dataLinks\IncomeListType::toSelectArray(),old('Clsacc_No'), 
                                        array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                                </div>
                            </div>
                            {{-- نهاية التصنيف بالحسابات الختاميه --}}

                            {{-- مركز التكلفه --}}
                            {{-- <div class="col-md-4" style="padding-top: 30px">
                                <div class="form-group">
                                    {{ Form::label('cc_type',trans('admin.with_cc') , ['class' => 'control-label']) }}
                                    {{ Form::checkbox('cc_type', 1) }}
                                </div>
                            </div> --}}
                            {{-- نهاية مركز التكلفه --}}
        
                            {{-- طبيعة الحساب --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Acc_Ntr">{{trans('admin.category')}}</label>
                                    {{ Form::select('Acc_Ntr', \App\Enums\dataLinks\CategoryAccountType::toSelectArray(), old('Acc_Ntr'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                                </div>
                            </div>
                            {{-- نهاية طبيعة الحساب --}}
        
                            {{-- رصيد اول المده مدين --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Fbal_DB">{{trans('admin.first_date_debtor')}}</label>
                                    <input type="text" name="Fbal_DB" id="Fbal_DB" value=0 class="form-control">
                                </div>
                            </div>
                            {{-- نهايةرصيد اول المده مدين --}}
        
                            {{-- رصيد اول المده دائن --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Fbal_CR">{{trans('admin.first_date_creditor')}}</label>
                                    <input type="text" name="Fbal_CR" id="Fbal_CR" value=0 class="form-control">
                                </div>
                            </div>
                            {{-- نهاية رصيد اول المده دائن --}}
                        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                        {!! Form::close() !!}
                       </div>
                   </div>
                </div>
            </div>
            {{-- <a href="#" class="btn btn-info edit_dep showbtn_control hidden" ><i class="fa fa-edit"></i> {{trans('admin.edit')}}</a>
            <a href="#" class="btn btn-danger delete_dep showbtn_control hidden"  data-toggle="modal" data-target="#myModal"><i class="fa fa-trash"></i> {{trans('admin.delete')}}</a> --}}
        </div>
        <!-- /.box-body -->
    </div>







@endsection
