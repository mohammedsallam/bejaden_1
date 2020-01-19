<?php

namespace App\Http\Controllers\Admin\categories;

use App\Models\Admin\ActivityTypes;
use App\Models\Admin\MainCompany;
use App\Models\Admin\MtsItmCatgry;
use App\Models\Admin\MtsItmmfs;
use App\Models\Admin\MtsSuplir;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $item = MtsItmCatgry::get(['Itm_Nm'.ucfirst(session('lang')), 'Itm_No']);
        if(count($item) > 0){
            if(session('Cmp_No') == -1){
                $cmps = MainCompany::get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
            }
            else{
                $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No'])->first();
            }

            $nump = MtsItmCatgry::get()->order->Itm_No;

            $activity = ActivityTypes::all();
            $suplirs = MtsSuplir::all();
            return view('admin.categories.MainCategories.index', ['title' => trans('admin.basic_types'),
                'cmps' => $cmps,'activity' => $activity,'suplirs' => $suplirs]);
        }
        else{

            if(session('Cmp_No') == -1){
                $cmps = MainCompany::get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
            }
            else{
                $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No'])->first();

            }
            $Itm_No = $this->createAccNo(0);
            $activity = ActivityTypes::all();
            $suplirs = MtsSuplir::all();
            return view('admin.categories.MainCategories.index', ['title' => trans('admin.basic_types'),
                'cmps' => $cmps,'activity' => $activity,'suplirs' => $suplirs]);
            return view('admin.categories.MainCategories.init_chart', ['title' => trans('admin.basic_types')
                , 'cmps' => $cmps, 'Itm_No' => $Itm_No,'activity' => $activity,'suplirs' => $suplirs]);
        }


        }



    public function createNewAcc(Request $request){
        if($request->ajax()){
            if($request->parent){
                $parent = MtsCostcntr::where('Itm_No', $request->parent)->get(['Itm_No', 'Cmp_No', 'Level_No'])->first();
                $cmps = MainCompany::where('Cmp_No', $parent->Cmp_No)->get(['Cmp_No', 'Cmp_Nm'.ucfirst(session('lang'))])->first();
                $chart = MtsCostcntr::get(['Costcntr_Nm'.ucfirst(session('lang')), 'Itm_No']);
                $Itm_No = $this->createAccNo($parent->Itm_No);
                return view('admin.cc.create', ['title' => trans('admin.cc'),
                    'parent' => $parent, 'cmps' => $cmps, 'chart' => $chart, 'Itm_No' =>  $Itm_No,
                ]);
            }

        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function createAccNo($Parent_Itm){
        if($Parent_Itm == 0){
            $chart = MtsItmCatgry::where('Parent_Itm', 0)->orderBy('Itm_No', 'desc')->get(['Itm_No'])->first();
            if($chart){
                $Itm_No = $chart->Itm_No + 1;
                return $Itm_No;
            }
            else{
                $Itm_No = 1;
                return $Itm_No;
            }
        }
        else{
            $parent = MtsItmCatgry::where('Itm_No', $Parent_Itm)->first();
            if(count($parent->children) > 0){
                $max = MtsItmCatgry::where('Parent_Itm', $parent->Itm_No)
                    ->where('Cmp_No', session('Chart_Cmp_No'))
                    ->orderBy('Itm_No', 'desc')->get(['Itm_No'])->first();
                return $max->Itm_No + 1;
            }
            else{
                $Itm_No = (int)$Parent_Itm.'01';
                return $Itm_No;
            }

        }
    }



    public function getItem(Request $request){
        if($request->ajax()){
            session(['Chart_Cmp_No' => $request->Cmp_No , 'Actvty_No' => $request->Actvty_No]);
            $tree = load_item('Parent_Itm', null, $request->Cmp_No, $request->Actvty_No);
            return $tree;
        }
    }
}
