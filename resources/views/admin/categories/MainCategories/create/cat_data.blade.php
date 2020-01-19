<div class="tab-pane fade show active in" id="cat_data" role="tabpanel" aria-labelledby="home-tab">
    <div class="panel panel-default col-md-4">
        <div class="panel-body">
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
                    <div style="display: flex">
                        <label style="width: 26%" for="Itm_No">{{trans('admin.item_no')}}</label>
                        <input style="width: 41%;" type="text" name="Itm_No" id="Itm_No" class="Itm_No form-control">

                        <label style="width: 20%; margin-right: 3px" for="Level_No">{{trans('admin.level_no')}}</label>
                        <input style="width: 17%;" type="text" name="Level_No" id="Level_No" class="Level_No form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="parent">{{trans('admin.parent_cat')}}</label>
                        <input id="parent" checked type="radio" name="Level_Status" value="0">
                    </div>
                    <div class="col-md-3">
                        <label for="child">{{trans('admin.sub_cat')}}</label>
                        <input id="child" type="radio" name="Level_Status" value="1">
                    </div>
                    <div class="col-md-6" style="display: flex; justify-content: space-between">
                        <div class="selles">
                            <input id="sells" type="checkbox" name="Sale_Active" value="1">
                            <label for="sells">{{trans('admin.sells')}}</label>
                        </div>
                        <div style="margin-left: 3px">
                            <input type="checkbox" name="Itm_Active" id="active_item" value="1" checked>
                            <label for="active_item">{{trans('admin.active_item')}}</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="col-md-12" style="display: flex; margin-top: 10px">
                            <label style="margin-left: 5px" for="Itm_NmAr">Ar</label>
                            <input type="text" name="Itm_NmAr" class="form-control Itm_NmAr">
                        </div>
                        <div class="col-md-12" style="display: flex; margin-top: 10px">
                            <label style="margin-left: 5px" for="Itm_NmEn">En</label>
                            <input type="text" name="Itm_NmEn" class="form-control Itm_NmEn">
                        </div>
                        <div class="col-md-12" style="display: flex; margin-top: 10px">
                            <label for="Sup_No">{{trans('admin.Suppliers')}}</label>
                            <select class="form-control col-md-8" name="Sup_No" id="Sup_No" style="margin-right: 4px">
                                <option value="" >{{trans('admin.select')}}</option>
                                @foreach($suplirs as $suplir)
                                    <option value="{{$suplir->Id_No}}" >{{$suplir->{'Sup_Nm'.ucfirst(session('lang'))} }}</option>
                                @endforeach
                            </select>
                            <input type="text" class="form-control col-md-3">
                        </div>
                        <div class="col-md-12" style="display: flex; margin-top: 10px">
                            <div style="display: flex">
                                <label style="width: 100%" for="bounce">{{trans('admin.bounce')}}</label>
                                <input min="1" type="number" name="Prct_SalBouns" class="form-control col-md-12" id="bounce">
                            </div>
                            <div style="display: flex">
                                <label style="width: 100%" for="additional_ax">{{trans('admin.additional_tax')}}</label>
                                <input min="1" type="number" name="Taxp_Extra" class="form-control col-md-12" id="additional_ax">
                            </div>
                            <div style="display: flex">
                                <label style="width: 100%" for="request_limit">{{trans('admin.request_limit')}}</label>
                                <input min="1" type="number" name="Req_Limit" class="form-control col-md-12" id="request_limit">
                            </div>
                        </div>

                        <div class="col-md-12" style="display: flex; justify-content: space-between; margin-top: 10px">
                            <div style="display: flex">
                                <input type="checkbox" name="Prct_Discount" class="checkbox-inline" id="discount">
                                <label style="width: 100%" for="discount">{{trans('admin.discount')}}</label>
                            </div>
                            <div style="display: flex">
                                <label style="width: 100%" for="max_sells_quantity">{{trans('admin.max_sells_quantity')}}</label>
                                <input type="text" name="MaxQty_SaL" class="form-control" id="max_sells_quantity">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3" style="margin-bottom: 10px; float: left">
                        <div class="col-md-12" style="border: 1px groove; border-radius: 5px; background: #3c8dbc; color: #fff; padding: 6px">

{{--                            <div style="margin-left: 3px">--}}
{{--                                <label for="sell">{{trans('admin.sell')}}</label>--}}
{{--                                <input type="checkbox" name="Sale_Active" id="sell" value="1">--}}
{{--                            </div>--}}
                            <div style="margin-left: 3px">
                                <input type="checkbox" name="Invt_Active" id="stored" value="1">
                                <label for="stored">{{trans('admin.stored')}}</label>
                            </div>
                            <div style="margin-left: 3px">
                                <input type="checkbox" name="Itm_Req" id="request" value="1">
                                <label for="request">{{trans('admin.request')}}</label>
                            </div>
                            <div style="margin-left: 3px">
                                <input type="checkbox" name="Itm_Relation" id="linked" value="1">
                                <label for="linked">{{trans('admin.linked')}}</label>
                            </div>
                        </div>
                        <div class="col-md-12" style="border: 1px groove; border-radius: 5px; background: #3c8dbc; color: #fff; padding: 6px">
                            <div style="margin-left: 3px">
                                <input type="checkbox" name="Measure_Grp" id="general" value="0">
                                <label for="general">{{trans('admin.general')}}</label>
                            </div>
                            <div style="margin-left: 3px">
                                <input type="checkbox" name="Measure_Grp" id="product_collect"value="1">
                                <label for="product_collect">{{trans('admin.product_collect')}}</label>
                            </div>
                            <div style="margin-left: 3px">
                                <input type="checkbox" name="Measure_Grp" id="pure_material" value="2">
                                <label for="pure_material">{{trans('admin.pure_material')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">

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
                            <input type="text" name="Itm_Sal1" class="form-control col-md-6">
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
                            <input type="text" name="Itm_Sal1" class="form-control col-md-6">
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
                            <input type="text" name="Itm_Sal3" class="form-control col-md-6">
                        </div>
                    </div>
                </div>
{{--                <div class="row">--}}
{{--                    <div class="col-md-12">--}}
{{--                        <label class="col-md-2" for="">{{trans('admin.item_barcode')}}</label>--}}
{{--                        <input type="text" name="Item_BarCode" class="form-control col-md-6">--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="row">
                    <div class="col-md-12">
                        <label  class="col-md-2" for="">{{trans('admin.reference_no')}}</label>
                        <input type="text" name="Ref_No" class="form-control col-md-6">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="col-md-2" for="">{{trans('admin.barcode_size')}}</label>
                        <input type="text" name="Label_No" class="form-control col-md-6">
                    </div>
                </div>
            </div>
        </div>

{{--        <div class="panel panel-default">--}}
{{--            <table class="tab">--}}
{{--                <tr>--}}
{{--                    <th></th>--}}
{{--                    <th></th>--}}
{{--                    <th></th>--}}
{{--                    <th>{{trans('admin.package')}}</th>--}}
{{--                    <th>{{trans('admin.sells_price')}}</th>--}}
{{--                    <th>{{trans('admin.buy_price')}}</th>--}}
{{--                    <th>{{trans('admin.coast')}}</th>--}}
{{--                    <th>{{trans('admin.factory_barcode')}}</th>--}}
{{--                </tr>--}}
{{--                <tbody>--}}
{{--                <tr>--}}
{{--                    <td>{{trans('admin.main_unit')}}</td>--}}
{{--                    <td>--}}
{{--                        <select name="" id="">--}}
{{--                            <option value="">asd</option>--}}
{{--                            <option value="">asd</option>--}}
{{--                            <option value="">asd</option>--}}
{{--                        </select>--}}
{{--                    </td>--}}
{{--                    <td><input type="text"></td>--}}
{{--                    <td><input type="text"></td>--}}
{{--                    <td><input type="text"></td>--}}
{{--                    <td><input type="text"></td>--}}
{{--                    <td><input type="text"></td>--}}
{{--                    <td><input type="text"></td>--}}
{{--                </tr>--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}
        <div class="panel panel-default col-md-12">
            <div class="panel-body">
                <div class="row" style="display: flex; justify-content: space-between">
                    <label class="col-md-2" for=""></label>
                    <label class="col-md-2" for=""></label>
                    <label class="col-md-2" for=""></label>
                    <label class="col-md-2" for="">{{trans('admin.package')}}</label>
                    <label class="col-md-2" for="">{{trans('admin.sells_price')}}</label>
                    <label class="col-md-2" for="">{{trans('admin.buy_price')}}</label>
                    <label class="col-md-2" for="">{{trans('admin.coast')}}</label>
                    <label class="col-md-2" for="">{{trans('admin.factory_barcode')}}</label>
                </div>
                <div class="row" style="display: flex; justify-content: flex-start">
                    <span>{{trans('admin.main_unit')}}</span>
                    <select class=" form-control" name="" id="">
                        <option value="">asd</option>
                        <option value="">asd</option>
                        <option value="">asd</option>
                    </select>
                    <input class="col-md-5 form-control" type="text">
                    <input class=" form-control" type="text">
                    <input class=" form-control" type="text">
                    <input class=" form-control" type="text">
                    <input class=" form-control" type="text">
                    <input class=" form-control" type="text">

                </div>
                <div class="row" style="display: flex; justify-content: flex-start">
                    <span>{{trans('admin.unit_1')}}</span>
                    <select class=" form-control" name="" id="">
                        <option value="">asd</option>
                        <option value="">asd</option>
                        <option value="">asd</option>
                    </select>
                    <input class="col-md-5 form-control" type="text">
                    <input class=" form-control" type="text">
                    <input class=" form-control" type="text">
                    <input class=" form-control" type="text">
                    <input class=" form-control" type="text">
                    <input class=" form-control" type="text">

                </div>
                <div class="row" style="display: flex; justify-content: flex-start">
                    <span>{{trans('admin.unit_2')}}</span>
                    <select class=" form-control" name="" id="">
                        <option value="">asd</option>
                        <option value="">asd</option>
                        <option value="">asd</option>
                    </select>
                    <input class=" form-control" type="text">
                    <input class=" form-control" type="text">
                    <input class=" form-control" type="text">
                    <input class=" form-control" type="text">
                    <input class=" form-control" type="text">
                    <input class=" form-control" type="text">

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
