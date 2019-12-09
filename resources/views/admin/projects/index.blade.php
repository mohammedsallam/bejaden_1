@extends('admin.index')
@inject('customer', 'App\Models\Admin\MTsCustomer')
@section('title',trans('admin.projects'))
@section('content')
@push('js')
    <script>
        var timer = 0;
        var delay = 200;
        var prevent = false;
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

            //close or open all nodes on jstree load -closed by default-
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
                $('#parent_name').text(name);

                //get all direct and undirect children of selected node
                var currentNode = data.node;
                var allChildren = $(this).jstree(true).get_children_dom(currentNode);
                // var result = [currentNode.id];
                var result = [];
                allChildren.find('li').addBack().each(function(index, element) {
                    if ($(this).jstree(true).is_leaf(element)) {
                        // result.push(element.textContent);
                        result.push(parseInt(element.id));
                    } else {
                        var nod = $(this).jstree(true).get_node(element);
                        // result.push(nod.text);
                        result.push(parseInt(nod.id));
                    }
                });

                //handle click event
                // timer = setTimeout(function() {
                // if (!prevent) {
                    handle_click(r[0], result);
                // }
                // prevent = false;
                // }, delay);
            });

            //handle tree click vent
            // $('#jstree').on("click.jstree", function (e){
                // timer = setTimeout(function() {
                // if (!prevent) {
                //     handle_click(e);
                // }
                // prevent = false;
                // }, delay);
            // });

            //handle tree double click event
            $('#jstree').on("dblclick.jstree", function (e){
                clearTimeout(timer);
                prevent = true;
                handle_dbclick(e);
            });

            function handle_click(Prj_No, children){
                // alert(children);
                // console.log(Prj_No);
                // var node = $(e.target).closest("li");
                // var type = node.attr('rel');
                // var Prj_No = node[0].id;
                $.ajax({
                    url: "{{route('getEditBlade')}}",
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}", Prj_No: Prj_No, children: children },
                    success: function(data){
                        $('#chart_form').html(data);
                    }
                });
            }

            function handle_dbclick(e){
                var node = $(e.target).closest("li");
                var type = node.attr('rel');
                var parent = node[0].id;
                $.ajax({
                    url: "{{route('createNewAcc')}}",
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}", parent: parent },
                    success: function(data){
                        $('#chart_form').html(data);
                    }
                });
            }

            $('#Level_Status').on('change', function(){
                if($(this).val() == 1){
                    $('#main_chart').removeClass('hidden');
                }
                else{
                    $('#main_chart').addClass('hidden');
                    $('#main_chart').val(null);
                }
            });

            $('#delete_button').click(function(e){
                e.preventDefault();
                $('#delete_form').submit()
            });

            $('#initChartAcc').on('click', function(){
                $.ajax({
                    url: "{{route('initChartAcc')}}",
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}"},
                    success: function(data){
                        $('#chart_form').html(data);
                    }
                });
            });

            $(document).on('change' ,'#Clsacc_No1_Check' , function(){
                if($(this).is(':checked')){
                    $('#Clsacc_No1').removeClass('hidden');
                }
                else{
                    $('#Clsacc_No1').addClass('hidden');
                    $('#Clsacc_No1').val(null);
                }
            });

            $(document).on('change', '#Clsacc_No2_Check', function(){
                if($(this).is(':checked')){
                    $('#Clsacc_No2').removeClass('hidden');
                }
                else{
                    $('#Clsacc_No2').addClass('hidden');
                    $('#Clsacc_No2').val(null);
                }
            });

            $(document).on('change', '#cc_type_Check', function(){
                if($(this).is(':checked')){
                    $('#cc_type').removeClass('hidden');
                }
                else{
                    $('#cc_type').addClass('hidden');
                    $('#cc_type').val(null);
                }
            });

            $(document).on('change', '#edit_form :radio[id=Level_Status]', function(){
                if($(this).is(':checked')){
                    if($(this).val() == 1){
                        $('.branch').removeClass('hidden');
                    }
                    else{
                        $('.branch').addClass('hidden');
                        $('#Acc_Ntr').val(null);
                        $('#Fbal_DB').val(0);
                        $('#Fbal_CR').val(0);
                        $('#Cr_Blnc').val(0);
                        $('#Acc_Typ').val(null);
                        $('#Clsacc_No1').val(null);
                        $('#Clsacc_No2').val(null);
                        $('#cc_type').val(null);
                    }
                }
            });

        });

    </script>
@endpush
    <div class="box">
        @include('admin.layouts.message')
        <!-- /.box-header -->
        <div class="box-body table-responsive" id="create_chart">
            <div class="row">

                {{-- chart tree start --}}
                <div class="col-md-6">
                    <div class="box-header">
                        <h3 class="box-title" style="display: inline-block">{{$title}}</h3>
                        @if(count($cmps) > 0)
                            @foreach($cmps as $cmp)
                                @if($cmp->Cmp_No == $chart_item->Cmp_No)
                                    <div id="Cmp_No" style="display: inline-block">{{$cmp->{'Cmp_Nm'.ucfirst(session('lang'))} }}</div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <a class="btn btn-primary" id="initChartAcc">{{trans('admin.Create_New_project')}}</a>
                            <div id="parent_name" style="display: inline-block"></div>
                            <div id="jstree" style="margin-top: 20px"></div>
                        </div>
                    </div>
                </div>
                {{-- chart tree end --}}

                {{-- form start --}}
                <div class="col-md-6" id="chart_form">
                    {!! Form::open(['method'=>'POST','route' => ['projects.update', $chart_item->Prj_No? $chart_item->Prj_No : null], 'id' => 'edit_form','files' => true]) !!}
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                    <form action="{{route('projects.destroy', $chart_item->Prj_No? $chart_item->Prj_No : null)}}" method="POST" id="delete_form">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                    </form>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#main_data" aria-controls="home" role="tab" data-toggle="tab">{{trans('admin.main_data')}}</a></li>
                            <li role="presentation"><a href="#responsible_persons" aria-controls="profile" role="tab" data-toggle="tab">{{trans('admin.responsible_persons')}}</a></li>
                        </ul>

                        <!-- Tab panes -->

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="main_data">

                                @foreach($children as $child)
                                    <input type="hidden" name="children[]" value='{{$child}}'>
                                @endforeach

                                <div class="col-md-3 pull-left">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                    <button type="submit" class="btn btn-danger" id="delete_button"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                </div>

                                {{-- رقم الحساب --}}
                                <label for="Prj_No" class="col-md-2">{{trans('admin.project_number')}}:</label>
                                <input type="text" name="Prj_No" id="Prj_No" class="form-control col-md-1" value="{{$chart_item->Prj_No}}">
                                {{-- رقم الحساب --}}

                                {{-- تصنيف الحساب --}}
                                <div class="form-group">
                                   <div class="row">
                                       <div class="col-md-4">
                                            @foreach(\App\Enums\dataLinks\TypeAccountType::toSelectArray() as $key => $value)
                                                <input class="checkbox-inline" type="radio"
                                                    name="Level_Status" id="Level_Status" value="{{$key}}"
                                                    style="margin: 3px;" disabled
                                                    @if ($chart_item->Level_Status == $key) checked @endif>
                                                <label>{{$value}}</label>
                                            @endforeach
                                       </div>
                                   </div>
                                </div>
                                {{-- نهاية تصنيف الحساب --}}

                                {{-- رقم الشركه --}}
                                {{-- <input type="text" name="Cmp_No" id="Cmp_No" value="{{$chart_item->Cmp_No}}" hidden> --}}
                                <div class="form-group row">
                                    <label for="Cmp_No" class="col-md-2">{{trans('admin.cmp_no')}}</label>
                                    <select name="Cmp_No" id="Cmp_No" class="form-control col-md-9">
                                        <option value="">{{trans('admin.select')}}</option>
                                        @if(count($cmps) > 0)
                                            @foreach($cmps as $cmp)
                                                <option value="{{$cmp->Cmp_No? $cmp->Cmp_No : null}}" @if($chart_item->Cmp_No == $cmp->Cmp_No) selected @endif>{{$cmp->{'Cmp_Nm'.ucfirst(session('lang'))} }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                {{-- نهاية رقم الشركه --}}

                            {{-- رقم الفرع و المستودع --}}

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="Brn_No" class="col-md-1">{{trans('admin.Brn_No')}}</label>
                                    <select name="Brn_No" id="Brn_No" class="form-control col-md-8">
                                        <option value="">{{trans('admin.select')}}</option>
                                        @if(count($cmps) > 0)
                                            @foreach($cmps as $cmp)
                                                <option value="{{$cmp->Brn_No? $cmp->Brn_No : null}}" @if($chart_item->Brn_No == $cmp->Brn_No) selected @endif>{{$cmp->{'Cmp_Nm'.ucfirst(session('lang'))} }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="Dlv_Stor" class="col-md-2">{{trans('admin.Dlv_Stor')}}</label>
                                    <select name="Dlv_Stor" id="Dlv_Stor" class="form-control col-md-9">
                                        <option value="">{{trans('admin.select')}}</option>
                                        @if(count($cmps) > 0)
                                            @foreach($cmps as $cmp)
                                                <option value="{{$cmp->Dlv_Stor? $cmp->Dlv_Stor : null}}" @if($chart_item->Dlv_Stor == $cmp->Dlv_Stor) selected @endif>{{$cmp->{'Cmp_Nm'.ucfirst(session('lang'))} }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            {{-- نهاية رقم الشركه --}}

                                {{-- اسم الحساب عربى --}}
                                <div class="form-group row">
                                    <label class="col-md-2" for="Prj_NmAr">{{trans('admin.project_name')}}:</label>
                                        <input type="text" name="Prj_NmAr" id="Prj_NmAr" class="col-md-9 form-control"
                                        value="{{$chart_item->Prj_NmAr? $chart_item->Prj_NmAr : null}}">
                                    </div>
                                {{-- نهاية اشم الحساب عربى --}}

                                {{-- اسم الحساب انجليزى --}}
                                <div class="form-group row">
                                    <label class="col-md-2" for="Prj_NmEn">{{trans('admin.project_name_en')}}:</label>
                                    <input type="text" name="Prj_NmEn" id="Prj_NmEn" class=" col-md-9 form-control"
                                        value="{{$chart_item->Prj_NmEn? $chart_item->Prj_NmEn : null}}">
                                </div>
                                {{-- نهاية اسم الحساب انجليزى --}}

                                {{-- العميل --}}
                                <div class="form-group row">
                                    <label class="col-md-2" for="Cstm_No">{{trans('admin.subscriper')}}:</label>
                                    <select name="Cstm_No" id="Cstm_No" class=" col-md-9 form-control"
                                           value="">

                                    </select>
                                </div>
                                {{-- نهاية العميل --}}

                                {{-- العنوان --}}
                                <div class="form-group row">
                                    <label class="col-md-2" for="Prj_Adr">{{trans('admin.Prj_Adr')}}:</label>
                                    <input type="text" name="Prj_Adr" id="Prj_Adr" class=" col-md-9 form-control"
                                           value="{{$chart_item->Prj_Adr? $chart_item->Prj_Adr : null}}">
                                </div>
                                {{-- نهاية العنوان --}}

                                <div class="col-md-6">
                                    <div class="row">
                                        {{-- طبيعة الحساب --}}
        {{--                                <div class="form-group col-md-12 branch">--}}
        {{--                                    <label for="Acc_Ntr" style="margin-left:15px;">{{trans('admin.category')}}:</label>--}}
        {{--                                    @foreach(\App\Enums\dataLinks\CategoryAccountType::toSelectArray() as $key => $value)--}}
        {{--                                        <input class="checkbox-inline" type="radio"--}}
        {{--                                            name="Acc_Ntr" id="Acc_Ntr" value="{{$key}}"--}}
        {{--                                            style="margin: 3px;"--}}
        {{--                                            @if($chart_item->Level_No == 1) disabled @endif--}}
        {{--                                            @if ($chart_item->Acc_Ntr == $key) checked @endif>--}}
        {{--                                        <label>{{$value}}</label>--}}
        {{--                                    @endforeach--}}
        {{--                                </div>--}}
                                        {{-- نهاية طبيعة الحساب --}}

                                        {{-- رصيد اول المده مدين --}}
                                        <div class="col-md-12 branch">
                                            <div class="form-group row">
                                                <label for="Fbal_DB" class="col-md-5">{{trans('admin.first_date_debtor')}}</label>
                                                <input type="text" name="Fbal_DB" id="Fbal_DB" value='{{$chart_item->Fbal_DB? $chart_item->Fbal_DB : 0}}'
                                                class="form-control col-md-7"
                                                @if($chart_item->Level_No == 1) disabled @endif>
                                            </div>
                                        </div>
                                        {{-- نهايةرصيد اول المده مدين --}}

                                        {{-- رصيد اول المده دائن --}}
                                        <div class="col-md-12 branch">
                                            <div class="form-group row">
                                                <label for="Fbal_CR" class="col-md-5">{{trans('admin.first_date_creditor')}}</label>
                                                <input type="text" disabled name="Fbal_CR" id="Fbal_CR" value='{{$chart_item->Fbal_CR? $chart_item->Fbal_CR : 0}}'
                                                class="form-control col-md-7"
                                                @if($chart_item->Level_No == 1) disabled @endif>
                                            </div>
                                        </div>
                                        {{-- نهاية رصيد اول المده دائن --}}

                                        {{-- حساب المصاريف للمشاريع --}}
                                        <div class="col-md-12 branch">
                                            <div class="form-group row">
                                                <label for="Acc_DB" class="col-md-5">{{trans('admin.Acc_DB')}}</label>
                                                <input type="text" disabled name="Acc_DB" id="Acc_DB" value='{{$chart_item->Acc_DB? $chart_item->Acc_DB : 0}}'
                                                       class="form-control col-md-7"
                                                       @if($chart_item->Level_No == 1) disabled @endif>
                                            </div>
                                        </div>
                                        {{-- نهاية حساب المصاريف للمشاريع --}}

                                        {{-- حساب الايرادات للمشاريع --}}
                                        <div class="col-md-12 branch">
                                            <div class="form-group row">
                                                <label for="Acc_CR" class="col-md-5">{{trans('admin.Acc_CR')}}</label>
                                                <input type="text" disabled name="Acc_CR" id="Acc_CR" value='{{$chart_item->Acc_CR? $chart_item->Acc_CR : 0}}'
                                                       class="form-control col-md-7"
                                                       @if($chart_item->Level_No == 1) disabled @endif >
                                            </div>
                                        </div>
                                        {{-- نهاية حساب الايرادات للمشاريع --}}

                                        {{-- رصيد اول المده دائن --}}
        {{--                                <div class="col-md-12 branch">--}}
        {{--                                    <div class="form-group row">--}}
        {{--                                        <label for="Cr_Blnc" class="col-md-5">{{trans('admin.credit_balance')}}</label>--}}
        {{--                                        <input type="text" disabled name="Cr_Blnc" id="Cr_Blnc" value='{{$chart_item->Cr_Blnc? $chart_item->Cr_Blnc : 0}}'--}}
        {{--                                        class="form-control col-md-7"--}}
        {{--                                        @if($chart_item->Level_No == 1) disabled @endif>--}}
        {{--                                    </div>--}}
        {{--                                </div>--}}
                                        {{-- نهاية رصيد اول المده دائن --}}
                                    </div>
                                </div>

                                {{-- الحساب الرئيسى --}}
        {{--                        <div class="col-md-4 hidden" id="main_chart">--}}
        {{--                            <div class="form-group">--}}
        {{--                                <label for="Prj_Parnt">{{trans('admin.main_account_chart')}}</label>--}}
        {{--                                <select name="Prj_Parnt" id="Prj_Parnt" class="form-control">--}}
        {{--                                    <option value="{{null}}">{{trans('admin.select')}}</option>--}}
        {{--                                    @if(count($chart) > 0)--}}
        {{--                                        @foreach($chart as $ch)--}}
        {{--                                            <option value="{{$ch->Prj_No? $ch->Prj_No : null}}" @if($chart_item->Prj_Parnt == $ch->Prj_No) selected @endif>{{$ch->{'Acc_Nm'.ucfirst(session('lang'))} }}</option>--}}
        {{--                                        @endforeach--}}
        {{--                                    @endif--}}
        {{--                                </select>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
                                {{-- نهاية الحساب الرئيسى --}}

                                <div class="col-md-6">
                                    <div class="row">
                                        {{-- رقم المرجع المشروع --}}
                                        <div class="col-md-12 branch">
                                            <label for="Prj_Refno" class="col-md-5 col-md-offset-1">{{trans('admin.Prj_Refno')}}</label>
                                            <input type="text" name="Prj_Refno" id="Prj_Refno" class="col-md-9 form-control"
                                                   value="{{$chart_item->Prj_Refno? $chart_item->Prj_Refno : null}}">
                                        </div>
                                        {{-- نهاية رقم المرجع المشروع --}}


                                        {{-- فئة المشروع --}}
                                        <div class="col-md-12 branch">
                                            <label for="Prj_Categ" class="col-md-5 col-md-offset-1">{{trans('admin.Prj_Categ')}}</label>
                                            <div class="form-group">
                                                <select name="Prj_Categ" id="Prj_Categ" class="form-control col-md-6"
                                                    @if($chart_item->Level_No == 1) disabled @endif>
                                                    <option value="{{null}}">{{trans('admin.select')}}</option>
                                                    @foreach(\App\Enums\AccountType::toSelectArray() as $key => $value)
                                                        <option value="{{$key}}"
                                                            @if($chart_item->Prj_Categ == $key) selected @endif>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{-- نهاية فئة المشروع --}}

                                        {{-- قيمة المشروع --}}
                                        <div class="col-md-12 branch">
                                            <input class="checkbox-inline col-md-1" type="checkbox" id='Clsacc_No1_Check'
                                                @if($chart_item->Level_No == 1) disabled @endif>
                                            <label for="Prj_Value" class="col-md-5">{{trans('admin.Prj_Value')}}</label>

                                            <div class="form-group">
                                                <select name="Prj_Value" id="Prj_Value" class="form-control col-md-6"
                                                    @if($chart_item->Level_No == 1) disabled @endif>
                                                    <option value="{{null}}">{{trans('admin.select')}}</option>
                                                    {{-- @foreach(\App\Enums\dataLinks\IncomeListType::toSelectArray() as $key => $value)
                                                        <option value="{{$key}}" @if($chart_item->Clsacc_No == $key) selected @endif>{{$value}}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                        </div>
                                        {{-- نهاية قيمة المشروع --}}

                                        {{-- حسابات قائمة الدخل --}}
                                        <div class="col-md-12 branch">
                                            <input class="checkbox-inline col-md-1 checks" type="checkbox" id='Clsacc_No2_Check'
                                                @if($chart_item->Level_No == 1) disabled @endif>
                                            <label for="Clsacc_No2" class="col-md-5">{{trans('admin.Clsacc_No2')}}</label>

                                            <div class="form-group">
                                                <select name="Clsacc_No2" id="Clsacc_No2" class="form-control col-md-6"
                                                    @if($chart_item->Level_No == 1) disabled @endif>
                                                    <option value="{{null}}">{{trans('admin.select')}}</option>
                                                    {{-- @foreach(\App\Enums\dataLinks\IncomeListType::toSelectArray() as $key => $value)
                                                        <option value="{{$key}}" @if($chart_item->Clsacc_No == $key) selected @endif>{{$value}}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                        </div>
                                        {{-- نهاية الحسابات قائمة الدخل --}}


                                        {{-- مركز التكلفه --}}
                                        <div class="col-md-12 branch">
                                            <input class="checkbox-inline col-md-1 checks" type="checkbox" id='cc_type_Check'
                                                @if($chart_item->Level_No == 1) disabled @endif>
                                            <label for="cc_type" class="col-md-5">{{trans('admin.with_cc')}}</label>

                                            <div class="form-group">
                                                <select name="cc_type" id="cc_type" class="form-control col-md-6"
                                                    @if($chart_item->Level_No == 1) disabled @endif>
                                                    <option value="{{null}}">{{trans('admin.select')}}</option>
                                                    {{-- @foreach(\App\Enums\dataLinks\IncomeListType::toSelectArray() as $key => $value)
                                                        <option value="{{$key}}" @if($chart_item->Clsacc_No == $key) selected @endif>{{$value}}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                        </div>
                                        {{-- نهاية مركز التكلفه --}}
                                    </div>
                                </div>

                            {!! Form::close() !!}
                            {{-- الحركات --}}
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">الشهر</th>
                                        <th scope="col">الحركة مدين</th>
                                        <th scope="col">الحركة دائن</th>
                                        <th scope="col">الرصيد الحالى</th>
                                        <th scope="col"> رصيد تقديرى</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <th scope="row">يناير</th>
                                        <td>
                                            @if($chart_item->DB11 == null)
                                                0.00
                                            @else
                                                {{$chart_item->DB11}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($chart_item->CR11 == null )
                                                0.00
                                            @else
                                                {{$chart_item->CR11}}
                                            @endif
                                        </td>
                                        <td>
                                            {{$chart_item->DB11 - $chart_item->CR11}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">فبراير</th>
                                        <td>
                                            @if($chart_item->DB12 == null )
                                                0.00
                                            @else
                                                {{$chart_item->DB12}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($chart_item->CR12 == null )
                                                0.00
                                            @else
                                                {{$chart_item->CR12}}
                                            @endif
                                        </td>
                                        <td>
                                            {{$chart_item->DB12 - $chart_item->CR12}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">مارس</th>
                                        <td>
                                            @if($chart_item->DB13 == null )
                                                0.00
                                            @else
                                                {{$chart_item->DB13}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($chart_item->CR13 == null )
                                                0.00
                                            @else
                                                {{$chart_item->CR13}}
                                            @endif
                                        </td>
                                        <td>
                                            {{$chart_item->DB13 - $chart_item->CR13}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">ابريل</th>
                                        <td>
                                            @if($chart_item->DB14 == null )
                                                0.00
                                            @else
                                                {{$chart_item->DB14}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($chart_item->CR14 == null )
                                                0.00
                                            @else
                                                {{$chart_item->CR14}}
                                            @endif
                                        </td>
                                        <td>
                                            {{$chart_item->DB14 - $chart_item->CR14}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">مايو</th>
                                        <td>
                                            @if($chart_item->DB15 == null )
                                                0.00
                                            @else
                                                {{$chart_item->DB15}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($chart_item->CR15 == null )
                                                0.00
                                            @else
                                                {{$chart_item->CR15}}
                                            @endif
                                        </td>
                                        <td>
                                            {{$chart_item->DB15 - $chart_item->CR15}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">يونيو</th>
                                        <td>
                                            @if($chart_item->DB16 == null )
                                                0.00
                                            @else
                                                {{$chart_item->DB16}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($chart_item->CR16 == null )
                                                0.00
                                            @else
                                                {{$chart_item->CR16}}
                                            @endif
                                        </td>
                                        <td>
                                            {{$chart_item->DB16 - $chart_item->CR16}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">يوليو</th>
                                        <td>
                                            @if($chart_item->DB17 == null )
                                                0.00
                                            @else
                                                {{$chart_item->DB17}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($chart_item->CR17 == null )
                                                0.00
                                            @else
                                                {{$chart_item->CR17}}
                                            @endif
                                        </td>
                                        <td>
                                            {{$chart_item->DB17 - $chart_item->CR17}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">اغسطس</th>

                                        <td>
                                            @if($chart_item->DB18 == null )
                                                0.00
                                            @else
                                                {{$chart_item->DB18}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($chart_item->CR18 == null )
                                                0.00
                                            @else
                                                {{$chart_item->CR18}}
                                            @endif
                                        </td>
                                        <td>
                                            {{$chart_item->DB18 - $chart_item->CR18}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">سبتمبر</th>

                                        <td>
                                            @if($chart_item->DB19 == null )
                                                0.00
                                            @else
                                                {{$chart_item->DB19}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($chart_item->CR19 == null )
                                                0.00
                                            @else
                                                {{$chart_item->CR19}}
                                            @endif
                                        </td>
                                        <td>
                                            {{$chart_item->DB19 - $chart_item->CR19}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">أكتوبر</th>

                                        <td>
                                            @if($chart_item->DB20 == null )
                                                0.00
                                            @else
                                                {{$chart_item->DB20}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($chart_item->CR20 == null )
                                                0.00
                                            @else
                                                {{$chart_item->CR20}}
                                            @endif
                                        </td>
                                        <td>
                                            {{$chart_item->DB20 - $chart_item->CR20}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">نوفمبر</th>

                                        <td>
                                            @if($chart_item->DB21 == null )
                                                0.00
                                            @else
                                                {{$chart_item->DB21}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($chart_item->CR21 == null )
                                                0.00
                                            @else
                                                {{$chart_item->CR21}}
                                            @endif
                                        </td>
                                        <td>
                                            {{$chart_item->DB21 - $chart_item->CR21}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">ديسمبر</th>

                                        <td>
                                            @if($chart_item->DB22 == null )
                                                0.00
                                            @else
                                                {{$chart_item->DB22}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($chart_item->CR22 == null )
                                                0.00
                                            @else
                                                {{$chart_item->CR22}}
                                            @endif
                                        </td>
                                        <td>
                                            {{$chart_item->DB22 - $chart_item->CR22}}
                                        </td>
                                    </tr>

                                    <tr style="background-color: #d3d9df">
                                        <th scope="row">الإجمالى</th>

                                        <td>
                                            {{count($total) > 0? $total[0]->total_debit : 0.00}}
                                        </td>
                                        <td>
                                            {{count($total) > 0? $total[0]->total_credit : 0.00}}

                                        </td>
                                        <td>
                                            {{count($total) > 0? $total[0]->total_balance : 0.00}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            {{-- نهاية الحركات --}}
                        </div>
                        <div role="tabpanel" class="tab-pane active" id="responsible_persons">
                            <div>
                                <div class="box-body">

                                    @can('single')



                                        <div class="form-group row col-md-6">
                                            <div class="col-md-12" style="text-align: center;">
                                                {!!Form::label('Cntct_Prsn1', trans('admin.person_dep_1'))!!}
                                                <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Cntct_Prsn1', old('Cntct_Prsn1'), ['class'=>'form-control'])!!}</div>
                                            </div>
                                            <div class="col-md-12">

                                                <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Cntct_Prsn2', null, ['class'=>'form-control'])!!}</div>
                                            </div>
                                        </div>
                                        <div class="form-group row col-md-6">
                                            <div class="col-md-12" style="text-align: center;">
                                                {!!Form::label('TitL1', trans('admin.Title_1'))!!}
                                                <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('TitL1', null, ['class'=>'form-control'])!!}</div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('TitL2', null, ['class'=>'form-control'])!!}</div>
                                            </div>

                                        </div>
                                        <div class="form-group row col-md-6">
                                            <div class="col-md-12" style="text-align: center;">
                                                {!!Form::label('Mobile1', trans('admin.mobile_1'))!!}
                                                <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Mobile1', null, ['class'=>'form-control'])!!}</div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Mobile2', null, ['class'=>'form-control'])!!}</div>
                                            </div>
                                        </div>
                                        <div class="form-group row col-md-6">
                                            <div class="col-md-12" style="text-align: center;">
                                                {!!Form::label('Email1', trans('admin.email_1'))!!}
                                                <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::email('Email1', null, ['class'=>'form-control'])!!}</div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::email('Email2', null, ['class'=>'form-control'])!!}</div>
                                            </div>
                                        </div>


                                </div>


                                {{Form::close()}}
                                @else
                                    <div class="alert alert-danger">{{trans('admin.you_cannt_see_invoice_because_you_dont_have_role_to_access')}}</div>

                                @endcan


                            </div>
                        </div>
                    </div>


                </div>
                {{-- form end --}}

            </div>
        </div>
        <!-- /.box-body -->
    </div>







@endsection
