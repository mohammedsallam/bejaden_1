@extends('admin.index')
@section('title',trans('admin.basic_types'))
@section('content')
    @push('js')
        <script>
            var timer = 0;
            var delay = 200;
            var prevent = false;
            $(document).ready(function () {

                $('#parent').click(function () {
                    $('input[type="checkbox"]#sells').prop('checked', true);
                });

                if($('#parent').prop('checked') === true){
                    $('input[type="checkbox"]#sells').prop('checked', true);
                }
                $('#child').click(function () {
                    $('input[type="checkbox"]#sells').prop('checked', false);
                });

                $('input[type="checkbox"]#sells').click(function () {
                    if($('#child').prop('checked') === true){
                        $('input[type="checkbox"]#sells').prop('checked', false);
                    }
                    if($('#parent').prop('checked') === true){
                        $('input[type="checkbox"]#sells').prop('checked', true);
                    }
                });



                $(document).on('change', '#Select_Cmp_No , #Actvty_No', function(){
                    $('#jstree').jstree('destroy');
                    var tree = [];
                    var Cmp_No = $('#Select_Cmp_No').val();
                    var Actvty_No = $('#Actvty_No').val();
                    if(Cmp_No != null){
                        $.ajax({
                            url: "{{route('getCategoryItem')}}",
                            type: "POST",
                            dataType: 'html',
                            data: {"_token": "{{ csrf_token() }}", Cmp_No: Cmp_No, Actvty_No: Actvty_No},
                            success: function(data){

                                dataParse = JSON.parse(data);

                                for(var i = 0; i < dataParse.length; i++){
                                    tree.push(dataParse[i])
                                }

                                $('#jstree').jstree({
                                    "core" : {
                                        // 'data' : "{!! load_cc('parent_id', '', '') !!}",
                                        'data' : tree,
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

                                //close or open all nodes on jstree load -opened by default-
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


                                //handle tree double click event
                                $('#jstree').on("dblclick.jstree", function (e){
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
                        'data' : "{{load_cc('parent_id', '', '')}}",
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


                function handle_click(Itm_No, children){
                    // var node = $(e.target).closest("li");
                    // var type = node.attr('rel');
                    // var Itm_No = node[0].id;
                    $.ajax({
                        url: "{{route('getCcEditBlade')}}",
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Itm_No: Itm_No, children: children },
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
                        url: "{{route('createCcNewAcc')}}",
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
                        url: "{{route('initCcChartAcc')}}",
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}"},
                        success: function(data){
                            $('#chart_form').html(data);
                        }
                    });
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
                            // $('#ClsItm_No1').val(null);
                            $('#ClsItm_No2').val(null);
                            $('#cc_type').val(null);
                        }
                    }
                });

            });

        </script>
    @endpush
    @push('css')
        <style>
            .nav-tabs.nav-justified>.active>a, .nav-tabs.nav-justified>.active>a:focus, .nav-tabs.nav-justified>.active>a:hover{
                border-top: 1px groove black;
                background: #8e8e8e5c;
                border-radius: 0;
                font-weight: bold;
            }

            .input_number{
                width: 100%;
                height: 30px;
                font-size: 14px;
                line-height: 1.42857143;
                text-align: center;
                color: #555;
                background-color: #fff;
                background-image: none;
                border: 1px solid #ccc;
                border-radius: 4px;
                -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
                -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            }
        </style>
    @endpush
    <div class="box">
    @include('admin.layouts.message')
    <!-- /.box-header -->
        <div class="box-body table-responsive" id="create_chart">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" style="display: flex">
                        <label style="width: 25%" for="Cmp_No">{{trans('admin.companies')}}</label>
                        <select name="Cmp_No" id="Select_Cmp_No" class="form-control">
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
                    <div class="form-group" style="display: flex">
                        <label style="width: 25%" for="Actvty_No" >{{trans('admin.activity')}}</label>
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

            {{-- start Ul taps--}}
            <ul class="nav nav-tabs nav-justified" id="myTab1" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link active" id="home-tab1" data-toggle="tab" href="#cat_data" role="tab" aria-controls="home"
                       aria-selected="true">{{trans('admin.cat_data')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab1" data-toggle="tab" href="#weight_measure" role="tab" aria-controls="profile"
                       aria-selected="false">{{trans('admin.weight_measure')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#purchases" role="tab" aria-controls="profile"
                       aria-selected="false">{{trans('admin.purchases')}}</a>
                </li>
            </ul>
            {{-- End Ul taps--}}

            {{----}}
            <div class="tab-content" id="myTabContent1" style="margin-top:1%">
                {{--First tap--}}
                @include('admin.categories.MainCategories.create.cat_data')
                {{--Second tap--}}
                @include('admin.categories.MainCategories.create.weight_measure')
                {{--third tap--}}
                @include('admin.categories.MainCategories.create.purchases')
            </div>
        </div>
    </div>







@endsection
