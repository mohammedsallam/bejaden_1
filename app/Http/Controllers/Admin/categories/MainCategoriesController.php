<?php

namespace App\Http\Controllers\Admin\categories;

use App\Http\Controllers\Controller;
use App\Models\Admin\ActivityTypes;
use App\Models\Admin\MainCompany;
use App\Models\Admin\MtsItmmfs;
use App\Models\Admin\MtsSuplir;
use App\Models\Admin\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = MtsItmmfs::get(['Itm_Nm'.ucfirst(session('lang')), 'Itm_No']);
        $activity = ActivityTypes::all();
        $units = Units::all();
        $suppliers = MtsSuplir::all();
        if(count($item) > 0){
            if(session('Cmp_No') == -1){
                $cmps = MainCompany::all();
            }
            else{
                $cmps = MainCompany::where('Cmp_No', session('ComNoSession'))->get();
            }

            $firstItem = MtsItmmfs::first();
            return view('admin.categories.main_categories.index', ['title' => trans('admin.basic_types'),
                'cmps' => $cmps, 'activity' => $activity, 'units' => $units, 'suppliers' => $suppliers, 'firstItem' => $firstItem]);
        }
        else{
            if(session('Cmp_No') == -1){
                $cmps = MainCompany::all();
            }
            else{
                $cmps = MainCompany::where('Cmp_No', session('ComNoSession'))->get();
            }
            $Itm_No = $this->createItmNo(0);
            return view('admin.categories.main_categories.edit.parent_index', ['title' => trans('admin.basic_types')
                , 'cmps' => $cmps, 'Itm_No' => $Itm_No, 'activity' => $activity, 'units' => $units, 'suppliers' => $suppliers]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        dd($request->all());
        if($request->Level_Status == 0){
            $validation = Validator::make($request->all(),[
                'Cmp_No' => 'required',
                'Actvty_No' => 'required',
                'Itm_No' => 'required',
                'Level_No' => 'required',
                'Level_Status' => 'required',
                'Itm_NmAr' => 'required',
                'Itm_NmEn' => 'sometimes',
                'Sup_No' => 'required',
            ],[],[
                'Cmp_No' => trans('admin.Cmp_No'),
                'Actvty_No' => trans('admin.activity_type'),
                'Itm_No' => trans('admin.item_no'),
                'Level_No' => trans('admin.level_no'),
                'Level_Status' => trans('admin.level_status'),
                'Itm_NmAr' => trans('admin.name_ar'),
                'Itm_NmEn' => trans('admin.name_en'),
                'Sup_No' => trans('admin.Suppliers'),
            ]);

            if ($validation->fails()){
                return  response()->json(['status' => 0, 'message' => $validation->errors()->first()]);
            }

            $item = MtsItmmfs::create($request->all());
            $item->update(['Level_No' => 1, 'Level_Status' => 0]);

            session(['ComNoSession' => $request->Cmp_No, 'ActiveNoSession' => $request->Actvty_No]);
        }
        else if($request->Level_Status == 1){
            $data = $this->validate($request,[
                'Cmp_No' => 'required',
                'Costcntr_Nmar' => 'required',
                'Costcntr_Nmen' => 'required',

            ],[],[
                'Cmp_No' => trans('admin.cmp_no'),
                'Costcntr_Nmar' => trans('admin.arabic_name'),
                'Costcntr_Nmen' => trans('admin.english_name'),
            ]);

            // return $request;
            $chart = new MtsCostcntr;
            $chart->Cmp_No = $request->Cmp_No;
            $chart->Costcntr_Nmar = $request->Costcntr_Nmar;
            $chart->Costcntr_Nmen = $request->Costcntr_Nmen;
            $chart->Level_Status = $request->Level_Status;
            $parent = MtsCostcntr::where('Costcntr_No', $request->Parnt_Acc)->get(['Level_No'])->first();
            $chart->Level_No = $parent->Level_No + 1;
            $chart->Parnt_Acc = $request->Parnt_Acc;
            $chart->Fbal_DB = $request->Fbal_DB;
            $chart->Fbal_CR = $request->Fbal_CR;
//            $chart->User_Id = Auth::user()->id;
            // $chart->Costcntr_No = $this->createAccNo($chart->Parnt_Acc);
            $chart->Costcntr_No = $request->Costcntr_No;
            $chart->save();
//            $chart->Acc_Dt = $chart->created_at;
//            $chart->Acc_DtAr = date('Y-m-d',strtotime(\GeniusTS\HijriDate\Hijri::convertToHijri($chart->Acc_Dt)));
            $chart->Updt_Time = $chart->updated_at;
            $chart->save();
            $parent_level = MtsCostcntr::where('Costcntr_No', $request->Parnt_Acc)->first();
            if($parent_level){
                $parent_level->Level_Status = 0;
                $parent_level->save();
            }
            return redirect(aurl('cc'))->with(session()->flash('message',trans('admin.success_add')));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->ajax()){
            $search = $request->search;
            if ($search != null){
                if ($search == 0){
                    $max_count = DB::table('cc')->max('level_id');
                    $contents = view('admin.cc.reports.show', compact('max_count','search'))->render();
                    return $contents;
                }
                if ($search == '1'){
                    $max_count = MtsCostcntr::where('type',1)->pluck('Costcntr_Nm'.session('lang'),'id');
                    $contents = view('admin.cc.reports.show', compact('max_count','search'))->render();
                    return $contents;
                }else{
                    $contents = view('admin.cc.reports.details',compact('search'))->render();
                    return $contents;
                }
            }

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $ccs = glcc::where('type','1')->pluck('name_'.session('lang'),'id');
        // $department = Department::findOrFail($id);
        // $parents = $department->parents->pluck('Costcntr_Nm'.session('lang'),'id');
        // $operations = operation::pluck('name_'.session('lang'),'id');
        // return view('admin.cc.edit',['title'=> trans('admin.edit_department') ,'department'=>$department,'parents'=>$parents,'operations'=>$operations,'ccs'=>$ccs]);
    }

    public function getEditBlade(Request $request){
        if($request->ajax()){
            if(session('Cmp_No') == -1){
                $cmps = MainCompany::get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
            }
            else{
                $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
            }
            $chart = MtsCostcntr::get(['Costcntr_Nm'.ucfirst(session('lang')), 'Costcntr_No']);
            $chart_item =MtsCostcntr::where('Costcntr_No', $request->Costcntr_No)
                ->where('Cmp_No', session('Chart_Cmp_No'))
                ->first();
            $total = $this->getTotalTransaction($chart_item);
            return view('admin.cc.edit', ['title' => trans('admin.cc'),
                'chart' => $chart, 'cmps' => $cmps, 'chart_item' => $chart_item, 'total' => $total,
            ]);
        }
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

        $chart = MtsCostcntr::where('Costcntr_No', $id)->where('Cmp_No', session('Chart_Cmp_No'))->first();
        if($chart->Level_Status == 0){

            $data = $this->validate($request,[
                'Cmp_No' => 'required',
                'Costcntr_Nmar' => 'required',
                'Costcntr_Nmen' => 'sometimes',
            ],[],[
                'Cmp_No' => trans('admin.cmp_no'),
                'Costcntr_Nmar' => trans('admin.arabic_name'),
                'Costcntr_Nmen' => trans('admin.english_name'),
            ]);

            $chart->Cmp_No = $request->Cmp_No;
            $chart->Costcntr_Nmar = $request->Costcntr_Nmar;
            $chart->Costcntr_Nmen = $request->Costcntr_Nmen;
            $chart->Costcntr_No = $request->Costcntr_No;
            $chart->save();
//            $chart->Acc_Dt = $chart->created_at;
//            $chart->Acc_DtAr = date('Y-m-d',strtotime(\GeniusTS\HijriDate\Hijri::convertToHijri($chart->Acc_Dt)));
            $chart->Updt_Time = $chart->updated_at;
            $chart->save();
            return redirect(aurl('cc'))->with(session()->flash('message',trans('admin.success_update')));
        }
        else{
            $data = $this->validate($request,[
                'Cmp_No' => 'required',
                'Costcntr_Nmar' => 'required',
                'Costcntr_Nmen' => 'sometimes',

            ],[],[
                'Cmp_No' => trans('admin.cmp_no'),
                'Costcntr_Nmar' => trans('admin.arabic_name'),
                'Costcntr_Nmen' => trans('admin.english_name'),

            ]);

            $chart->Cmp_No = $request->Cmp_No;
            $chart->Costcntr_Nmar = $request->Costcntr_Nmar;
            $chart->Costcntr_Nmen = $request->Costcntr_Nmen;
//            $chart->Acc_Typ = $request->Acc_Typ;
            $chart->Fbal_DB = $request->Fbal_DB;
            $chart->Fbal_CR = $request->Fbal_CR;
//            $chart->User_Id = Auth::user()->id;
            $chart->save();
//            $chart->Acc_Dt = $chart->created_at;
//            $chart->Acc_DtAr = date('Y-m-d',strtotime(\GeniusTS\HijriDate\Hijri::convertToHijri($chart->Acc_Dt)));
            $chart->Updt_Time = $chart->updated_at;
            $chart->save();

            return redirect(aurl('cc'))->with(session()->flash('message',trans('admin.success_update')));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chart = MtsCostcntr::where('Costcntr_No', $id)->first();
        if(count($chart->children) > 0){
            return back()->with(session()->flash('error',trans('admin.chart_has_children')));
        }
        else{
            $chart->delete();
            return redirect(aurl('cc'))->with(session()->flash('message',trans('admin.success_deleted')));
        }
    }


    //print tree
    public function getTree(Request $request){
        $mainCompany = MainCompany::pluck('Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No');
        return view('admin.basic_reports.CC.gotree',compact('mainCompany'));
    }

    //create new item number
    public function createItmNo($Itm_Parnt){
        if($Itm_Parnt == null){
            $item = MtsItmmfs::where('Itm_Parnt', null)->orderBy('Itm_No', 'desc')->get(['Itm_No'])->first();
            if($item){
                return $item->Itm_No + 1;
            }
            else{
                $item = 1;
                return $item;
            }
        } else{
            $parent = MtsItmmfs::where('Itm_No', $Itm_Parnt)->first();
            if(count($parent->children) > 0){
                $max = MtsItmmfs::where('Itm_Parnt', $parent->Itm_No)
                    ->where('Cmp_No', session('ComNoSession'))
                    ->orderBy('Itm_No', 'desc')->get(['Itm_No'])->first();
                return $max->Costcntr_No + 1;
            }
            else{
                $Itm_No = (int) $Itm_Parnt.'001';
                return $Itm_No;
            }

        }
    }

    public function getCategoryItem(Request $request){
        if($request->ajax()){
            session(['ComNoSession' => $request->Cmp_No, 'ActiveNoSession' => $request->Actvty_No]);
            $tree = load_item('Itm_Parnt', null, $request->Cmp_No, $request->Actvty_No);
            return $tree;
        }
    }

    public function createNewAcc(Request $request){
        if($request->ajax()){
            if($request->parent){
                $parent = MtsCostcntr::where('Costcntr_No', $request->parent)->get(['Costcntr_No', 'Cmp_No', 'Level_No'])->first();
                $cmps = MainCompany::where('Cmp_No', $parent->Cmp_No)->get(['Cmp_No', 'Cmp_Nm'.ucfirst(session('lang'))])->first();
                $chart = MtsCostcntr::get(['Costcntr_Nm'.ucfirst(session('lang')), 'Costcntr_No']);
                $Costcntr_No = $this->createAccNo($parent->Costcntr_No);
                return view('admin.cc.create', ['title' => trans('admin.cc'),
                    'parent' => $parent, 'cmps' => $cmps, 'chart' => $chart, 'Costcntr_No' =>  $Costcntr_No,
                ]);
            }

        }
    }

    public function initChartAcc(){
        if(session('Cmp_No') == -1){
            $cmps = MainCompany::get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No']);
        }
        else{
            $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->get(['Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No'])->first();
        }
        $Costcntr_No = $this->createAccNo(0);
        return view('admin.cc.create_main_chart', ['title' => trans('admin.cc')
            , 'cmps' => $cmps, 'Costcntr_No' => $Costcntr_No]);
    }

}

