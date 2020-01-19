@extends('admin.index')
@section('title',trans('admin.basic_types'))
@section('content')
@push('js')
    <script>
        var timer = 0;
        var delay = 200;
        var prevent = false;
        $(document).ready(function () {


            $(document).on('change', '#Cmp_No', function(){
                let jsTree = $('#jsTree');
                jsTree.jstree('destroy');
                let tree = [];
                let Cmp_No = $('#Cmp_No').val();
                if(Cmp_No != null){
                    $.ajax({
                        url: "{{route('getCategoryItem')}}",
                        type: "post",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Cmp_No: Cmp_No},
                        success: function(data){
                            let dataParse = JSON.parse(data);
                            for(let i = 0; i < dataParse.length; i++){
                                tree.push(dataParse[i])
                            }

                            jsTree.jstree({
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
                            $('#jsTree').on("dblclick.jstree", function (e){
                                clearTimeout(timer);
                                prevent = true;
                                handle_dbclick(e);
                            });
                        }
                    });
                }
            });


            $('#jstree').jstree({
                "core" : {
                    //'data' : {!! load_cc('parent_id', '', '') !!},
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
                $('#modal-delete').attr('action','{{aurl('cc')}}/'+r.join(', '));
                $('#parent_name').text(name);
            });

            //handle tree click vent
            $('#jstree').on("click.jstree", function (e){
                timer = setTimeout(function() {
                if (!prevent) {
                    handle_click(e);
                }
                prevent = false;
                }, delay);
            });

            //handle tree double click event
            $('#jstree').on("dblclick.jstree", function (e){
                clearTimeout(timer);
                prevent = true;
                handle_dbclick(e);
            });


            function handle_click(e){
                var node = $(e.target).closest("li");
                var type = node.attr('rel');
                var Itm_No = node[0].id;
                $.ajax({
                    url: "{{route('getCcEditBlade')}}",
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}", Itm_No: Itm_No },
                    success: function(data){
                        $('#chart_form').html(data);
                    }
                });
            }

            function handle_dbclick(e){
                var node = $(e.target).closest("li");
                var type = node.attr('rel');
                var Itm_No = node[0].id;
                $.ajax({
                    url: "{{route('createCcNewAcc')}}",
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}", Itm_No: Itm_No },
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
            {!! Form::open(['method'=>'POST','route' => ['cc.store'], 'id' => 'edit_form', 'files' => true]) !!}
            {{csrf_field()}}
        <div class="box-body table-responsive" id="create_chart">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="Prj_Parnt" id="Prj_Parnt" value="{{0}}" hidden>
{{--                    <input type="text" name="Level_No" id="Level_No" value="{{1}}" hidden>--}}
                    <div class="col-md-12">
                        <div id="parent_name" style="display: inline-block"></div>
                        <div class="box-header">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Cmp_No">{{trans('admin.companies')}}</label>
                                        <select name="Cmp_No" id="Cmp_No" class="form-control col-md-10">
                                            <option value="">{{trans('admin.select')}}</option>
                                            @if(count($cmps) > 0)
                                                @foreach($cmps as $cmp)
                                                    <option value="{{$cmp->ID_No}}">{{$cmp->{'Cmp_Nm'.ucfirst(session('lang'))} }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Actvty_No">{{trans('admin.activity_type')}}</label>
                                        <select name="Actvty_No" id="Actvty_No" class="form-control">
                                            <option value="">{{trans('admin.select')}}</option>
                                            @if(count($activity) > 0)
                                                @foreach($activity as $active)
                                                    <option value="{{$active->ID_No}}">{{$active->{'Name_'.ucfirst(session('lang'))} }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="jsTree" style="margin-top: 20px"></div>
                    </div>
                </div>

                <div id="parent_name" style="display: inline-block"></div>

                <div class="col-md-6" id="chart_form">
                    <div class="clearfix">
                        <button style="float: left" type="submit" class="btn btn-primary "><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                    </div>
                        {{-- Parnt_Acc --}}
                        <input type="text" name="Parent_Itm" id="Parent_Itm" value="{{0}}" hidden>
                        <input type="text" name="Level_No" id="Level_No" value="{{1}}" hidden>
                        {{-- Parnt_Acc ebd --}}
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-6" style="display: flex">
                            <label for="Level_No">{{trans('admin.level_no')}}</label> {{--[10101010]--}}
{{--                            <input style="width: 50%; margin-right: 4px" type="text" name="Level_No" id="Level_No" value="{{$Itm_No}}" class="form-control Level_No">--}}
                        </div>
                        <div class="col-md-5" style="display: flex">
                            <label for="Itm_No">{{trans('admin.item_no')}}</label>
                            <input style="width: 50%; margin-right: 4px" type="text" name="Itm_No" id="Itm_No" class="form-control Itm_No">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="display: flex; margin-top: 10px">
                            <label for="Itm_NmAr">Ar</label>
                            <input style="margin-right: 4px" type="text" name="Itm_NmAr" class="form-control Itm_NmAr">
                        </div>
                        <div class="col-md-12" style="display: flex; margin-top: 10px">
                            <label for="Itm_NmEn">En</label>
                            <input style="margin-right: 4px" type="text" name="Itm_NmEn" class="form-control Itm_NmEn">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="display: flex; margin-top: 10px">
                            <label for="Sup_No">{{trans('admin.Suppliers')}}</label>
                            <select class="form-control" name="Sup_No" id="Sup_No" style="margin-right: 4px">
                                <option value="" >{{trans('admin.select')}}</option>
                                @foreach($suplirs as $suplir)
                                    <option value="{{$suplir->Id_No}}" >{{$suplir->{'Sup_Nm'.ucfirst(session('lang'))} }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    {!! Form::close() !!}

                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>







@endsection
