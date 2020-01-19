<div class="tab-pane fade show active in" id="cat_data" role="tabpanel" aria-labelledby="home-tab">
    <div class="panel panel-default col-md-4">
        <div class="panel-body">
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
            <div class="panel panel-default">
                <div class="panel-body">
                    <a class="btn btn-primary" id="initChartAcc">{{trans('admin.new_category')}}</a>
                    <div id="parent_name" style="display: inline-block"></div>
                    <div id="jstree" style="margin-top: 20px"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8" id="chart_form">
        {!! Form::open(['method'=>'POST','route' => ['mainCategories.index'], 'id' => 'edit_form','files' => true]) !!}
        {{csrf_field()}}
        {{method_field('PUT')}}
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="" style="display: flex">
                    <div class="form-group">
                        <label for="Itm_No">{{trans('admin.item_no')}}</label>
                        <input style="width: 90%;" type="text" name="Itm_No" id="Itm_No" class="form-control Itm_No">
                    </div>
                   <div class="form-group">
                       <label for="Level_No">{{trans('admin.level_no')}}</label>
                       <input style="width: 90%;" type="text" name="Level_No" id="Level_No" class="form-control Level_No">

                   </div>
                    <div class="col-md-3">
                        <label for="parent">{{trans('admin.parent_cat')}}</label>
                        <input id="parent" checked type="radio" name="Level_Status" value="0">
                    </div>
                    <div class="col-md-3">
                        <label for="child">{{trans('admin.sub_cat')}}</label>
                        <input id="child" type="radio" name="Level_Status" value="1">
                    </div>
                    <div class="col-md-4">
                        <div class="selles">
                            <label for="sells">{{trans('admin.sells')}}</label>
                            <input id="sells" type="checkbox" name="Sale_Active" value="1">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="display: flex; margin-top: 10px">
                        <label style="margin-left: 5px" for="Itm_NmAr">Ar</label>
                        <input type="text" name="Itm_NmAr" class="form-control Itm_NmAr">
                    </div>
                    <div class="col-md-12" style="display: flex; margin-top: 10px">
                        <label style="margin-left: 5px" for="Itm_NmEn">En</label>
                        <input type="text" name="Itm_NmEn" class="form-control Itm_NmEn">
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
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="display: flex; margin-bottom: 10px">
                        <div class="col-md-6" style="border: 1px groove; border-radius: 5px; background: #3c8dbc; color: #fff; padding: 6px; display: flex">
                            <div style="margin-left: 3px">
                                <label for="active_item">{{trans('admin.active_item')}}</label>
                                <input type="checkbox" name="" id="active_item">
                            </div>
                            <div style="margin-left: 3px">
                                <label for="sell">{{trans('admin.sell')}}</label>
                                <input type="checkbox" name="" id="sell">
                            </div>
                            <div style="margin-left: 3px">
                                <label for="stored">{{trans('admin.stored')}}</label>
                                <input type="checkbox" name="" id="stored">
                            </div>
                            <div style="margin-left: 3px">
                                <label for="request">{{trans('admin.request')}}</label>
                                <input type="checkbox" name="" id="request">
                            </div>
                            <div style="margin-left: 3px">
                                <label for="linked">{{trans('admin.linked')}}</label>
                                <input type="checkbox" name="" id="linked">
                            </div>
                        </div>
                        <div class="col-md-6" style="border: 1px groove; border-radius: 5px; background: #3c8dbc; color: #fff; padding: 6px; display: flex">
                            <div style="margin-left: 3px">
                                <label for="general">{{trans('admin.general')}}</label>
                                <input type="checkbox" name="" id="general">
                            </div>
                            <div style="margin-left: 3px">
                                <label for="product_collect">{{trans('admin.product_collect')}}</label>
                                <input type="checkbox" name="" id="product_collect">
                            </div>
                            <div style="margin-left: 3px">
                                <label for="pure_material">{{trans('admin.pure_material')}}</label>
                                <input type="checkbox" name="" id="pure_material">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="col-md-2" for="">{{trans('admin.main')}}</label>
                        <select name="" id="" class="form-control col-md-4">
                            <option value="">asdasd</option>
                            <option value="">asdasd</option>
                            <option value="">asdasd</option>
                        </select>
                        <input class="col-md-1 form-control" type="text">
                        <div class="col-md-5">
                            <label class="col-md-6" for="">{{trans('admin.sells_1')}}</label>
                            <input type="text" class="form-control col-md-6">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="col-md-2" for="">{{trans('admin.buy')}}</label>
                        <select name="" id="" class="form-control col-md-4">
                            <option value="">asdasd</option>
                            <option value="">asdasd</option>
                            <option value="">asdasd</option>
                        </select>
                        <input class="col-md-1 form-control" type="text">
                        <div class="col-md-5">
                            <label class="col-md-6" for="">{{trans('admin.sells_2')}}</label>
                            <input type="text" class="form-control col-md-6">
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class="col-md-12">
                        <label class="col-md-2" for="">{{trans('admin.sell')}}</label>
                        <select name="" id="" class="form-control col-md-4">
                            <option value="">asdasd</option>
                            <option value="">asdasd</option>
                            <option value="">asdasd</option>
                        </select>
                        <input class="col-md-1 form-control" type="text">
                        <div class="col-md-5">
                            <label class="col-md-6" for="">{{trans('admin.piece_price')}}</label>
                            <input type="text" class="form-control col-md-6">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="col-md-2" for="">{{trans('admin.item_barcode')}}</label>
                        <input type="text" class="form-control col-md-6">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label  class="col-md-2" for="">{{trans('admin.reference_no')}}</label>
                        <input type="text" class="form-control col-md-6">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="col-md-2" for="">{{trans('admin.barcode_size')}}</label>
                        <input type="text" class="form-control col-md-6">
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        {{--                                        <form action="{{route('cc.destroy', $chart_item->Costcntr_No? $chart_item->Costcntr_No : null)}}" method="POST" id="delete_form">--}}
        {{--                                            {{csrf_field()}}--}}
        {{--                                            {{method_field('DELETE')}}--}}
        {{--                                        </form>--}}
    </div>
</div>
