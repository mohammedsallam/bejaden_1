@extends('admin.index')
@section('title',trans('admin.projects'))
@inject('customers', 'App\Models\Admin\MTsCustomer')
@inject('delegates', 'App\Models\Admin\AstSalesman')
@section('content')
@push('js')
    <script>
        var timer = 0;
        var delay = 200;
        var prevent = false;
        $(document).ready(function () {
            // var Selected_Cmp_No = $('#Select_Cmp_No').children('option:selected').val();\
            $(document).on('change', '#Select_Cmp_No', function(){
                $('#jstree').jstree('destroy');
                var tree = [];
                var Cmp_No = $('#Select_Cmp_No').val();
                if(Cmp_No != null){
                    $.ajax({
                        url: "{{route('getTreePrj')}}",
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Cmp_No: Cmp_No},
                        success: function(data){

                            dataParse = JSON.parse(data);

                            for(var i = 0; i < dataParse.length; i++){
                                tree.push(dataParse[i])
                            }

            $('#jstree').jstree({
                "core" : {
                    //'data' : {!! load_prj('parent_id', '', '') !!},
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
            //     timer = setTimeout(function() {
            //     if (!prevent) {
            //         handle_click(e);
            //     }
            //     prevent = false;
            //     }, delay);
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
                    url: "{{route('getEditBladePrj')}}",
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}", Prj_No: Prj_No, children: children },
                    success: function(data){
                        $('#chart_form').html(data);
                    }
                });
            }}

            function handle_dbclick(e){
                var node = $(e.target).closest("li");
                var type = node.attr('rel');
                var Prj_No = node[0].id;
                $.ajax({
                    url: "{{route('createNewAccPrj')}}",
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}", Prj_No: Prj_No },
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
                        $('#Costcntr_No').val(null);
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
                <div class="col-md-6">
                    <div id="parent_name" style="display: inline-block"></div>
                    <div class="box-header">
                        <div class="form-group row">
                            <h3 class="box-title col-md-3">{{$title}}</h3>
                            <select name="Select_Cmp_No" id="Select_Cmp_No" class="form-control col-md-9">
                                <option value="">{{trans('admin.select_Cmp')}}</option>
                                @if(count($cmps) > 0)
                                    @foreach($cmps as $cmp)
                                        <option value="{{$cmp->Cmp_No}}">{{$cmp->{'Cmp_Nm'.ucfirst(session('lang'))} }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div id="jstree" style="margin-top: 20px"></div>
                </div>
                <div class="col-md-6" id="chart_form">
                    {!! Form::open(['method'=>'POST','route' => ['projects.store'], 'id' => 'edit_form', 'files' => true]) !!}
                        {{csrf_field()}}
                        {{-- Parnt_Acc --}}
                        <input type="text" name="Prj_Parnt" id="Prj_Parnt" value="{{0}}" hidden>
                        <input type="text" name="Level_No" id="Level_No" value="{{1}}" hidden>
                        {{-- Prj_Parnt ebd --}}

                        <div class="row">
                            <div class="col-md-1 pull-left">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                            </div>

                            {{-- رقم المشروع --}}
                            <label for="Prj_No" class="col-md-2">{{trans('admin.project_number')}}:</label>
                            <input type="text" name="Prj_No" id="Prj_No" class="form-control col-md-1" value="{{$Prj_No}}">
                            {{-- نهاية رقم المشروع --}}
                            {{-- تصنيف الحساب --}}
                            <input type="text" value="{{0}}" name="Level_Status" hidden>
                            {{-- نهاية تصنيف الحساب --}}
                        </div>
                            {{-- العميل --}}
                            <div class="form-group row">
                                <label class="col-md-2" for="Cstm_No">{{trans('admin.subscriper')}}:</label>
                                <div class="col-md-9">{!!Form::select('Cstm_No', $customers->pluck('Cstm_Nm'.ucfirst(session('lang')),'ID_No')->toArray(),null,[
                                        'class'=>'form-control', 'placeholder'=>trans('admin.select')
                                    ])!!}</div>
                            </div>
                            {{-- نهاية العميل --}}

                            {{-- المندوب --}}
                            <div class="form-group row">
                                <label class="col-md-2" for="Slm_No">{{trans('admin.slm_no')}}:</label>
                                <div class="col-md-9">{!!Form::select('Slm_No', $delegates->pluck('Slm_Nm'.ucfirst(session('lang')),'ID_No')->toArray(),null,[
                                        'class'=>'form-control', 'placeholder'=>trans('admin.select')
                                    ])!!}</div>
                            </div>



                        {{-- اسم الحساب عربى --}}
                        <div class="form-group row">
                            <label class="col-md-2" for="Prj_NmAr">{{trans('admin.project_name')}}:</label>
                                <input type="text" name="Prj_NmAr" id="Prj_NmAr" class="col-md-9 form-control">
                            </div>
                        {{-- نهاية اشم الحساب عربى --}}

                        {{-- اسم الحساب انجليزى --}}
                        <div class="form-group row">
                            <label class="col-md-2" for="Prj_NmEn">{{trans('admin.project_name_en')}}:</label>
                            <input type="text" name="Prj_NmEn" id="Prj_NmEn" class=" col-md-9 form-control">
                        </div>
                        {{-- نهاية اسم الحساب انجليزى --}}

                        <div class="col-md-6">
                            <div class="row">
                                {{-- طبيعة الحساب --}}
                                <div class="form-group col-md-12 branch hidden">
                                    <label for="Acc_Ntr" style="margin-left:15px;">{{trans('admin.category')}}:</label>
                                    @foreach(\App\Enums\dataLinks\CategoryAccountType::toSelectArray() as $key => $value)
                                        <input class="checkbox-inline" type="radio"
                                            name="Acc_Ntr" id="Acc_Ntr" value="{{$key}}"
                                            style="margin: 3px;">
                                        <label>{{$value}}</label>
                                    @endforeach
                                </div>
                                {{-- نهاية طبيعة الحساب --}}

                                {{-- رصيد اول المده مدين --}}
                                <div class="col-md-12 branch hidden">
                                    <div class="form-group row">
                                        <label for="Fbal_DB" class="col-md-5">{{trans('admin.first_date_debtor')}}</label>
                                        <input type="text" name="Fbal_DB" id="Fbal_DB" value='{{0}}' class="form-control col-md-7">
                                    </div>
                                </div>
                                {{-- نهايةرصيد اول المده مدين --}}

                                {{-- رصيد اول المده دائن --}}
                                <div class="col-md-12 branch hidden">
                                    <div class="form-group row">
                                        <label for="Fbal_CR" class="col-md-5">{{trans('admin.first_date_creditor')}}</label>
                                        <input type="text" name="Fbal_CR" id="Fbal_CR" value='{{0}}' class="form-control col-md-7">
                                    </div>
                                </div>
                                {{-- نهاية رصيد اول المده دائن --}}

                                {{-- رصيد  تقديرى --}}
                                <div class="col-md-12 branch hidden">
                                    <div class="form-group row">
                                        <label for="Cr_Blnc" class="col-md-5">{{trans('admin.credit_balance')}}</label>
                                        <input type="text" name="Cr_Blnc" id="Cr_Blnc" value='{{0}}' class="form-control col-md-7">
                                    </div>
                                </div>
                                {{-- نهاية رصيد  تقديرى --}}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                {{-- نوع الحساب --}}
                                <div class="col-md-12 branch hidden">
                                    <label for="Clsacc_No1" class="col-md-5 col-md-offset-1">{{trans('admin.account_type')}}</label>
                                    <div class="form-group">
                                        <select name="Acc_Typ" id="Acc_Typ" class="form-control col-md-6">
                                            <option value="{{null}}">{{trans('admin.select')}}</option>
                                            @foreach(\App\Enums\AccountType::toSelectArray() as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- نهاية نوع الحساب --}}

                                {{-- حسابات ختاميه --}}
                                <div class="col-md-12 branch hidden">
                                    <input class="checkbox-inline col-md-1" type="checkbox" id='Clsacc_No1_Check'>
                                    <label for="Clsacc_No1" class="col-md-5">{{trans('admin.Clsacc_No1')}}</label>

                                    <div class="form-group">
                                        <select name="Clsacc_No1" id="Clsacc_No1" class="form-control col-md-6 hidden">
                                            <option value="{{null}}">{{trans('admin.select')}}</option>
                                            {{-- @foreach(\App\Enums\dataLinks\IncomeListType::toSelectArray() as $key => $value)
                                                <option value="{{$key}}" @if($chart_item->Clsacc_No == $key) selected @endif>{{$value}}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                                {{-- نهاية الحسابات الختاميه --}}

                                {{-- حسابات قائمة الدخل --}}
                                <div class="col-md-12 branch hidden">
                                    <input class="checkbox-inline col-md-1 checks" type="checkbox" id='Clsacc_No2_Check'>
                                    <label for="Clsacc_No2" class="col-md-5">{{trans('admin.Clsacc_No2')}}</label>

                                    <div class="form-group">
                                        <select name="Clsacc_No2" id="Clsacc_No2" class="form-control col-md-6 hidden">
                                            <option value="{{null}}">{{trans('admin.select')}}</option>
                                            {{-- @foreach(\App\Enums\dataLinks\IncomeListType::toSelectArray() as $key => $value)
                                                <option value="{{$key}}" @if($chart_item->Clsacc_No == $key) selected @endif>{{$value}}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                                {{-- نهاية الحسابات قائمة الدخل --}}


                                {{-- مركز التكلفه --}}
                                <div class="col-md-12 branch hidden">
                                    <input class="checkbox-inline col-md-1 checks" type="checkbox" id='cc_type_Check'>
                                    <label for="cc_type" class="col-md-5">{{trans('admin.with_cc')}}</label>

                                    <div class="form-group">
                                        <select name="cc_type" id="cc_type" class="form-control col-md-6 hidden">
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
                                    0.00
                                </td>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">فبراير</th>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">مارس</th>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">ابريل</th>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">مايو</th>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">يونيو</th>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">يوليو</th>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">اغسطس</th>

                                <td>
                                    0.0
                                </td>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">سبتمبر</th>

                                <td>
                                    0.00
                                </td>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">أكتوبر</th>

                                <td>
                                    0.00
                                </td>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">نوفمبر</th>

                                <td>
                                    0.00
                                </td>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">ديسمبر</th>

                                <td>
                                    0.00
                                </td>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0
                                </td>
                            </tr>

                            <tr style="background-color: #d3d9df">
                                <th scope="row">الإجمالى</th>

                                <td>
                                    0
                                </td>
                                <td>
                                    0
                                </td>
                                <td>
                                    0
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- نهاية الحركات --}}
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>







@endsection
