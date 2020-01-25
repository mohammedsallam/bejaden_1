@extends('admin.index')
@section('title',trans('admin.basic_types'))
@section('content')
    @push('js')
        <script>

            $(document).ready(function () {

                var timer = 0;
                var delay = 200;
                var prevent = false;

                $(document).on('change', '.Cmp_No , .Actvty_No', function(){
                    $('#jstree').jstree('destroy');
                    var tree = [];
                    var Cmp_No = $('.Cmp_No').val();
                    var Actvty_No = $('.Actvty_No').val();
                    if(Cmp_No != null){
                        $.ajax({
                            url: "{{route('getCategoryItem')}}",
                            type: "post",
                            dataType: 'html',
                            data: {
                                _token: "{{ csrf_token() }}",
                                Cmp_No: Cmp_No,
                                Actvty_No: Actvty_No
                            },
                            success: function(data){
                                let dataParse = JSON.parse(data);

                                for(var i = 0; i < dataParse.length; i++){
                                    tree.push(dataParse[i])
                                }

                                $('#jstree').jstree({
                                    "core" : {
                                        'data' : {!!  load_item('Itm_Parnt', '', session('updatedComNo'), session('updatedActiveNo')) !!},
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

                                    handle_click(r[0], result);

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
                        'data' : {!!  load_item('Itm_Parnt', '', session('updatedComNo'), session('updatedActiveNo')) !!},
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
                    // timer = setTimeout(function () {
                    //     handle_click(r[0], result);
                    //     prevent = false;
                    // }, 200)

                    handle_click(r[0], result);

                    $('#jstree').on("dblclick.jstree", function (e){
                        clearTimeout(timer);
                        prevent = true;
                        handle_dbclick(e);
                    });



                    // }
                    // prevent = false;
                    // }, delay);
                });

                // handle tree double click event
                // $('#jstree').on("dblclick.jstree", function (e){
                //     clearTimeout(timer);
                //     prevent = true;
                //     handle_dbclick(e);
                // });


                // handle click event
                function handle_click(Itm_No, children){
                    // console.log(Costcntr_No)
                    // var node = $(e.target).closest("li");
                    // var type = node.attr('rel');
                    // var Costcntr_No = node[0].id;
                    $.ajax({
                        url: "{{route('getRootForEdit')}}",
                        type: "get",
                        dataType: 'html',
                        data: {
                            _token: "{{ csrf_token() }}",
                            Itm_No: Itm_No,
                            children: children
                        },
                        success: function(data){
                            $('#myTabContent1').html(data);
                            $('.editRootOrChildLink ').removeClass('hidden');
                            $('.deleteRootOrChildLink  ').removeClass('hidden');
                        }
                    });
                }

                function handle_dbclick(e){
                    var node = $(e.target).closest("li");
                    var type = node.attr('rel');
                    var parent = node[0].id;
                    $.ajax({
                        url: "{{route('getChildForEdit')}}",
                        type: "post",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", parent: parent },
                        success: function(data){
                            $('#myTabContent1').html(data);
                        }
                    });
                }

                /**
                 * Separate
                 */


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

                $('.Sup_No').change(function () {
                    $('.Sup_No_show').val($(this).val())
                });

                $('.addRootOrChild').click(function () {
                    var Itm_No = $('.Itm_No').val();
                   $.ajax({
                       url: "{{route('mainCategories.store')}}",
                       type: "post",
                       dataType: 'json',
                       data: {
                           _token: "{{csrf_token()}}",
                           Cmp_No: $('.Cmp_No').val(),
                           Actvty_No: $('.Actvty_No').val(),
                           Itm_No: Itm_No,
                           Level_No: $('.Level_No').val(),
                           Level_Status: $('input[type=radio].Level_Status:checked').val(),
                           Itm_NmAr: $('.Itm_NmAr').val(),
                           Sup_No: $('.Sup_No').val(),
                       },
                       success: function (data) {
                           if(data.status === 0){
                               $('.error_message').removeClass('hidden').html(data.message);
                               $('.success_message').addClass('hidden')
                           } else {
                               $('.Itm_No').val(parseInt($('.Itm_No').val())+1);
                               $('.success_message').removeClass('hidden').html(data.message);
                               $('.error_message').addClass('hidden');
                               window.location.reload();
                           }
                       }
                   })
                });

                var lastItemNo = $('.Itm_No ').val();
                $('.editRootOrChildLink').click(function () {
                    var Itm_No = $('.Itm_No').val();
                    $.ajax({
                        url: "{{route('updateRootOrChild')}}",
                        type: "post",
                        dataType: 'json',
                        data: {
                            _token: "{{csrf_token()}}",
                            Cmp_No: $('.Cmp_No').val(),
                            Actvty_No: $('.Actvty_No').val(),
                            Itm_No: Itm_No,
                            Level_No: $('.Level_No').val(),
                            Level_Status: $('input[type=radio].Level_Status:checked').val(),
                            Itm_NmAr: $('.Itm_NmAr').val(),
                            Itm_NmEn: $('.Itm_NmEn').val(),
                            Sup_No: $('.Sup_No').val(),
                        },
                        success: function (data) {
                            if(data.status === 0){
                                $('.error_message').removeClass('hidden').html(data.message);
                                $('.success_message').addClass('hidden')
                            } else {
                                $('.Itm_No').val(parseInt($('.Itm_No').val())+1);
                                $('.success_message').removeClass('hidden').html(data.message);
                                $('.error_message').addClass('hidden');
                                    $('.Itm_No').val(lastItemNo);
                                    $('.Level_No').val(1);
                                    $('.Itm_NmAr').val('');
                                    $('.Itm_NmEn').val('');
                                    window.location.reload();
                            }
                        }
                    });

                });

                $('.deleteRootOrChildLink').click(function () {
                    $.ajax({
                        url: "{{route('deleteRootOrChild')}}",
                        type: "post",
                        dataType: 'json',
                        data: {
                            _token: "{{csrf_token()}}",
                            Itm_No: $('.Itm_No').val(),
                        },
                        success: function (data) {
                            if(data.status === 0){
                                $('.error_message').removeClass('hidden').html(data.message);
                                $('.success_message').addClass('hidden')
                            } else {
                                $('.Itm_No').val(parseInt($('.Itm_No').val())+1);
                                $('.success_message').removeClass('hidden').html(data.message);
                                $('.error_message').addClass('hidden');
                                $('.Itm_No').val(lastItemNo);
                                $('.Level_No').val(1);
                                $('.Itm_NmAr').val('');
                                $('.Itm_NmEn').val('');
                                $('.jstree-clicked').parent('li').remove();
                                $('#parent_name').html('')
                            }
                        }
                    });

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
                <div class="col-md-12">
                    <div class="alert alert-danger error_message hidden"></div>
                </div>
                <div class="col-md-12">
                    <div class="alert alert-success success_message hidden"></div>
                </div>
            </div>
            <div class="row text-left" style="margin-bottom: 5px">
                <div class="col-md-4 pull-left">
                    <a class="btn btn-info editRootOrChildLink hidden" href="#"><i class="fa fa-floppy-o"></i></a>
                    <a class="btn btn-danger deleteRootOrChildLink hidden" href="#"><i class="fa fa-trash"></i></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" style="display: flex">
                        <label style="width: 25%" for="Cmp_No">{{trans('admin.companies')}}</label>
                        {{--@if($cmp->ID_No == session('updatedComNo')) selected @endif--}}
                        <select name="Cmp_No" id="Cmp_No" class="form-control Cmp_No">
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
                    {{--@if($active->ID_No == session('updatedActiveNo')) selected @endif--}}
                    <div class="form-group" style="display: flex">
                        <label style="width: 25%" for="Actvty_No" >{{trans('admin.activity')}}</label>
                        <select name="Actvty_No" id="Actvty_No" class="form-control Actvty_No">
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


            <div class="panel panel-default col-md-4" style="margin-top:1%; overflow: auto">
                <div class="panel-body">
                    <a class="btn btn-primary addRootOrChild" id="addRootOrChild">{{trans('admin.new_category')}}</a>
                    <div id="parent_name" style="display: inline-block"></div>
                    <div id="jstree" style="margin-top: 20px"></div>
                </div>
            </div>
            {{----}}
                <div class="tab-content" id="myTabContent1" style="margin-top:1%">

                {{--First tap--}}
                @include('admin.categories.main_categories.create_parent.cat_data')
                {{--Second tap--}}
                @include('admin.categories.main_categories.create_parent.weight_measure')
                {{--third tap--}}
                @include('admin.categories.main_categories.create_parent.purchases')
            </div>
        </div>
    </div>

@endsection
