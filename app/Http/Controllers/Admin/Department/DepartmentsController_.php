<?php

namespace App\Http\Controllers\Admin\Department;


use App\Branches;
use App\Project;
use App\Contractors;

use App\employee;
use App\Department;
use App\glcc;
use App\limitations;
use App\Http\Controllers\Controller;
use App\levels;
use App\limitationReceipts;
use App\limitationsType;
use App\operation;
use App\pjitmmsfl;
use App\receipts;
use App\receiptsData;
use App\receiptsType;
use App\supplier;
use App\Models\Admin\MtsChartAc;
use App\Models\Admin\MainCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Up;


class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Department $department)
    {
        return view('admin.departments.index',['title'=> trans('admin.Departments'),'department'=>$department]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Department $department)
    {
        $ccs = glcc::where('type','1')->pluck('name_'.session('lang'),'id');
        $operations = operation::pluck('name_'.session('lang'),'id');
        return view('admin.departments.create_',['title'=> trans('admin.create_new_department'),'operations' => $operations,'ccs' => $ccs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Department $department)
    {
        $data = $this->validate($request,[
            'branch_id' => 'sometimes',
            'dep_name_ar' => 'required',
            'dep_name_en' => 'required',
            'levelType' => 'sometimes',
            'cc_type' => 'sometimes',
            'level_id' => 'sometimes',
            'code' => 'sometimes',
            'type'=>'required',
            'status'=>'sometimes',
            'operation_id'=>'sometimes',
            'category'=>'sometimes',
            'cc_id'=>'sometimes',
            'budget'=>'sometimes',
            'creditor'=>'sometimes',
            'debtor'=>'sometimes',
            'estimite'=>'sometimes',
            'description'=>'sometimes|nullable|max:190',
            'parent_id'=>'sometimes',
        ],[],[
            'name_ar' => trans('admin.arabic_name'),
            'name_en' => trans('admin.english_name'),
            'description' => trans('admin.description'),
            'parent_id' => trans('admin.Parent'),
        ]);
        if ($request->cc_type){
            $data['cc_type'] = $request->cc_type;
        }else{
            $data['cc_type'] = 0;
        }
        $departments = $department->create($data);
        if($data['parent_id'] == null){
            $count = count(DB::table('departments')->where('parent_id',null)->where('levelType',$departments->levelType)->get());
            $level_id = levels::where('type',$departments->levelType)->where('levelId',1)->first()->id;
            DB::table('departments')->where('id',$departments->id)->update(['code' => $count,'level_id'=>$level_id]);
        }else{
            $parent =  Department::where('id',$departments->parent_id)->first();
            if ($parent->levelType != $departments->levelType){
                $departments->delete();
                return back()->with(session()->flash('error',trans('admin.cannot_add_branche')));
            }else{
                $count = count(DB::table('departments')->where('parent_id',$departments->parent_id)->where('levelType',$departments->levelType)->get())-1;
                if (levels::where('type',$departments->levelType)->where('levelId',$parent->level_id + 1)->exists()){
                    $level_id = levels::where('type',$departments->levelType)->where('levelId',$parent->level_id + 1)->first()->id;
                    if($count == null){
                        $length = levels::where('type',$departments->levelType)->where('levelId',$parent->level_id + 1)->first()->length;
                        $code = Department::where('id',$departments->parent_id)->where('levelType',$departments->levelType)->first()->code;
                        $code_first = substr(Department::where('id',$departments->parent_id)->where('levelType',$departments->levelType)->first()->code, 0,1);
                        if ($length == 2){
                            DB::table('departments')->where('id',$departments->id)->update(['code' => (($code_first.substr($code,1)).'01') ,'level_id'=>$level_id]);
                        }elseif ($length == 3){
                            DB::table('departments')->where('id',$departments->id)->update(['code' => (($code_first.substr($code,1)).'001') ,'level_id'=>$level_id]);
                        }elseif ($length == 4){
                            DB::table('departments')->where('id',$departments->id)->update(['code' => (($code_first.substr($code,1)).'0001') ,'level_id'=>$level_id]);
                        }elseif ($length == 5){
                            DB::table('departments')->where('id',$departments->id)->update(['code' => (($code_first.substr($code,1)).'00001') ,'level_id'=>$level_id]);
                        }
                    }else{
                        $code = DB::table('departments')->where('parent_id',$departments->parent_id)->where('levelType',$departments->levelType)->max('code');
                            $i = substr($code + 1, -3,1);
                            if (substr($code + 1, -3) == $i.'00') {
                                $departments->delete();
                                return back()->with(session()->flash('error', trans('admin.cannot_add')));
                            } else {
                                DB::table('departments')->where('id', $departments->id)->update(['code' => $code + 1, 'level_id' => $level_id]);
                            }
                            if (substr($code + 1, -3) == ($i.'000')) {
                                $departments->delete();
                                return back()->with(session()->flash('error', trans('admin.cannot_add')));
                            } else {
                                DB::table('departments')->where('id', $departments->id)->update(['code' => $code + 1, 'level_id' => $level_id]);
                            }
                            if (substr($code + 1, -3) == ($i.'0000')) {
                                $departments->delete();
                                return back()->with(session()->flash('error', trans('admin.cannot_add')));
                            } else {
                                DB::table('departments')->where('id', $departments->id)->update(['code' => $code + 1, 'level_id' => $level_id]);
                            }
                            if (substr($code + 1, -3) == ($i.'00000' + 1)) {
                                $departments->delete();
                                return back()->with(session()->flash('error', trans('admin.cannot_add')));
                            } else {
                                DB::table('departments')->where('id', $departments->id)->update(['code' => $code + 1, 'level_id' => $level_id]);
                            }
                    }
                }else{
                    $departments->delete();
                    return back()->with(session()->flash('error',trans('admin.cannot_add')));
                }
            }

        }

        DB::table('departments')->where('id',$departments->parent_id)->update(['type' => '0']);
        DB::table('departments')->where('id',$departments->id)->update(['type' => '1']);
        return redirect(aurl('departments'))->with(session()->flash('message',trans('admin.success_add')));

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
                    $max_count = DB::table('departments')->max('level_id');
                    $contents = view('admin.departments.reports.show', compact('max_count','search'))->render();
                    return $contents;
                }
                if ($search == '1'){
                    $max_count = Department::where('type',1)->pluck('dep_name_'.session('lang'),'id');
                    $contents = view('admin.departments.reports.show', compact('max_count','search'))->render();
                    return $contents;
                }else{
                    $contents = view('admin.departments.reports.details',compact('search'))->render();
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
        $ccs = glcc::where('type','1')->pluck('name_'.session('lang'),'id');
        $department = Department::findOrFail($id);
        $parents = $department->parents->pluck('dep_name_'.session('lang'),'id');
        $operations = operation::pluck('name_'.session('lang'),'id');
        return view('admin.departments.edit',['title'=> trans('admin.edit_department') ,'department'=>$department,'parents'=>$parents,'operations'=>$operations,'ccs'=>$ccs]);
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
        $data = $this->validate($request,[
            'dep_name_ar' => 'required',
            'dep_name_en' => 'required',
            'levelType' => 'sometimes',
            'cc_type' => 'sometimes',
            'level_id' => 'sometimes',
            'type'=>'sometimes',
            'status'=>'sometimes',
            'operation_id'=>'sometimes',
            'category'=>'sometimes',
            'cc_id'=>'sometimes',
            'budget'=>'sometimes',
            'creditor'=>'sometimes',
            'debtor'=>'sometimes',
            'estimite'=>'sometimes',
            'description'=>'sometimes|nullable|max:190',
            'parent_id'=>'sometimes',
        ],[],[
            'name_ar' => 'Arabic Name',
            'name_en' => 'English Name',
            'description' => 'Description',
        ]);
        $department = Department::findOrFail($id);
        if ($request->cc_type){
            $data['cc_type'] = $request->cc_type;
        }else{
            $data['cc_type'] = 0;
        }
        $department->update($data);
        return redirect(aurl('departments'))->with(session()->flash('message',trans('admin.success_update')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $department = Department::findOrFail($id);
        if(limitationsType::where('tree_id','=',$id)->exists() || receiptsType::where('tree_id','=',$id)->exists() || receiptsData::where('tree_id','=',$id)->exists())
        {
            return back()->with(session()->flash('error',trans('admin.cannot_delete')));
        }elseif(count($department->children) == 0)
        {
            $department->delete();
            return redirect(aurl('departments'));
        }else{
            return back()->with(session()->flash('error',trans('admin.x')));
        }
    }

    public function reports()
    {
        $title = trans('admin.Departments_reports');
        return view('admin.departments.reports.index',compact('title'));
    }
    public function print()
    {

//        $departments = sumdepartment(15);
        $departments = Department::orderBy('code')->get();

//        dd($departments);
        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
            );
        }];
        $pdf = Pdf::loadView('admin.departments.print', compact('departments'),[], $config);
        return $pdf->stream();
    }
    public function details(Request $request)
    {
        if($request->ajax()){
            $typeRange = $request->typeRange;
            $type = $request->type;
            if ($typeRange != null){
                $contents = view('admin.departments.reports.details', compact('typeRange', 'type'))->render();
                return $contents;

            }

            if ($type != null){

                $contents = view('admin.departments.reports.details', compact('typeRange', 'type'))->render();
                return $contents;
            }
        }
    }

    public function pdf(Request $request) {
        $typeRange = $request->typeRange;
        $type = $request->type;
        $search = $request->search;
        if ($search == 6){
            $departments = Department::where('cc_id','!=',null)->get();
            $config = ['instanceConfigurator' => function($mpdf) {
                $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                        <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                );
            }];
            $pdf = PDF::loadView('admin.departments.reports.pdf.report', compact('departments'), [], $config);
            return $pdf->stream();
        }
        if ($typeRange != null){
            $departments = Department::where('level_id',$typeRange)->get();
            $config = ['instanceConfigurator' => function($mpdf) {
                $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                        <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                );
            }];
            $pdf = PDF::loadView('admin.departments.reports.pdf.report', compact('departments'), [], $config);
            return $pdf->stream();
        }
        if ($type != null){
                $products = [];
                $departments = Department::where('id',$type)->get();
                while(count($departments) > 0){
                    $nextCategories = [];
                    foreach ($departments as $category) {
                        $products = array_merge($products, $category->children->all());
                        $nextCategories = array_merge($nextCategories, $category->children->all());
                    }
                    $departments = $nextCategories;
                }
            $config = ['instanceConfigurator' => function($mpdf) {
                $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                        <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                );
            }];
            $pdf = PDF::loadView('admin.departments.reports.pdf.report', compact('products'), [], $config);
            return $pdf->stream();
        }

            if ($search == '2'){
                $departments = Department::where('category','0')->get();
            }elseif ($search == '3'){
                $departments = Department::where('category','1')->get();
            }elseif ($search == '4'){
                $departments = Department::where('type','0')->get();
            }elseif ($search == '5'){
                $departments = Department::where('type','1')->get();
            }elseif ($search == '6'){
                $departments = glcc::where('type','1')->get();
                $config = ['instanceConfigurator' => function($mpdf) {
                    $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                    );
                }];
                $pdf = PDF::loadView('admin.departments.reports.pdf.cc', compact('departments'), [], $config);
                return $pdf->stream();
            }
            $config = ['instanceConfigurator' => function($mpdf) {
                $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
                );
            }];
            $pdf = PDF::loadView('admin.departments.reports.pdf.report', compact('departments'), [], $config);
            return $pdf->stream();
    }
  public function Review( )
    {
//        $operations = operation::whereIn('receipt',[1,2])->pluck('name_'.session('lang'),'id');
//        $branches = Branches::pluck('name_'.session('lang'),'id');
        $limitationReceipts = limitationReceipts::pluck('name_'.session('lang'),'id');
        $title = trans('admin.daily_report');
            return view('admin.departments.review',compact('limitationReceipts'));
    }

    public function reviewdepartment(Request $request)
    {
        $type = $request->type;
        $startdate = $request->startdate;
        $enddate = $request->enddate;

        $limitations_1 = [];
        $limitations_2 = [];
        $limitations_3 = [];

        $receipts_1 = [];
        $receipts_2 = [];
        $receipts_3= [];
//dd(dep_name_ar != name_ar);
        $limitations_1 = limitationsType::where('operation_id', '=', 4)
            ->where('limitations_type.tree_id', '=', \DB::raw('limitations_type.relation_id'))
            ->whereHas('departments', function ($qu) {

                $qu->where('dep_name_ar', '!=', \DB::raw('limitations_type.name_ar'));
            })->whereHas('limitations',
                function ($q) use ($type) {

                    $q->where('limitationsType_id', '=', $type);
                })->get();

//dd($limitations_1);

        $limitations_2 = limitationsType::where('operation_id', '=', 4)->where('limitations_type.tree_id', '!=', \DB::raw('limitations_type.relation_id'))->whereHas('limitations',
            function ($query) use ($type) {
                $query->where('limitationsType_id', '=', $type);


            })->get();


//        $limitations_2 = limitationsType::where('operation_id', '=', 4)->where('limitations_type.tree_id', '!=', \DB::raw('limitations_type.relation_id'))->whereHas('limitations',
//            function ($query) use ($type) {
//                $query->where('limitationsType_id', '=', $type);
//
//
//            })->get();

//dd(tree_id  != relation_id);


        $Errorlimitations_3 = limitationsType::whereHas('limitations',
            function ($query) use ($type) {
                $query->where('limitationsType_id', '=', $type);


            })->get();

        foreach ($Errorlimitations_3 as $one) {

            if ($one->operation_id == 1) {
                $tree = supplier::where('id', $one->relation_id)->first()['tree_id'];

                $limitations_3 = limitationsType::where('operation_id', '=', 1)->where('tree_id', '!=', $tree)->whereHas('limitations',
                    function ($query) use ($type) {
                        $query->where('limitationsType_id', '=', $type);


                    })->get();

            } elseif ($one->operation_id == 3) {
                $tree = Project::where('id', $one->relation_id)->first()['tree_id'];

                $limitations_3 = limitationsType::where('operation_id', '=', 3)->where('tree_id', '!=', $tree)->whereHas('limitations',
                    function ($query) use ($type) {
                        $query->where('limitationsType_id', '=', $type);


                    })->get();

            } elseif ($one->operation_id == 5) {
                $tree = employee::where('id', $one->relation_id)->first()['tree_id'];

                $limitations_3 = limitationsType::where('operation_id', '=', 5)->where('tree_id', '!=', $tree)->whereHas('limitations',
                    function ($query) use ($type) {
                        $query->where('limitationsType_id', '=', $type);


                    })->get();

            } elseif ($one->operation_id == 10) {
                $tree = Contractors::where('id', $one->relation_id)->first()['tree_id'];

                $limitations_3 = limitationsType::where('operation_id', '=', 10)->where('tree_id', '!=', $tree)->whereHas('limitations',
                    function ($query) use ($type) {
                        $query->where('limitationsType_id', '=', $type);


                    })->get();


            }


        }
        $receipts_1 = receiptsType::where('operation_id', '=', 4)
            ->where('receipts_type.tree_id', '!=', \DB::raw('receipts_type.relation_id'))->whereHas('receipts',
            function ($query) use ($type) {
                $query->where('receiptsType_id', '=', $type);


            })->get();


        $receipts_2 = receiptsType::where('operation_id', '=', 4)
            ->where('receipts_type.tree_id', '=', \DB::raw('receipts_type.relation_id'))
            ->whereHas('departments', function ($qu) {

                $qu->where('dep_name_ar', '!=', \DB::raw('receipts_type.name_ar'));
            })->whereHas('receipts',
                function ($q) use ($type) {

                    $q->where('receiptsType_id', '=', $type);
                })->get();
//dd($receipts);




        $Errorreceipts_3 = receiptsType::whereHas('receipts',
            function ($query) use ($type) {
                $query->where('receiptsType_id', '=', $type);


            })->get();

        foreach ($Errorreceipts_3 as $one) {

            if ($one->operation_id == 1) {
                $tree = supplier::where('id', $one->relation_id)->first()['tree_id'];

                $receipts_3 = receiptsType::where('operation_id', '=', 1)->where('tree_id', '!=', $tree)->whereHas('receipts',
                    function ($query) use ($type) {
                        $query->where('receiptsType_id', '=', $type);


                    })->get();

            } elseif ($one->operation_id == 3) {
                $tree = Project::where('id', $one->relation_id)->first()['tree_id'];

                $receipts_3 = receiptsType::where('operation_id', '=', 3)->where('tree_id', '!=', $tree)->whereHas('receipts',
                    function ($query) use ($type) {
                        $query->where('receiptsType_id', '=', $type);


                    })->get();

            } elseif ($one->operation_id == 5) {
                $tree = employee::where('id', $one->relation_id)->first()['tree_id'];

                $receipts_3 = receiptsType::where('operation_id', '=', 5)->where('tree_id', '!=', $tree)->whereHas('receipts',
                    function ($query) use ($type) {
                        $query->where('receiptsType_id', '=', $type);


                    })->get();

            } elseif ($one->operation_id == 10) {
                $tree = Contractors::where('id', $one->relation_id)->first()['tree_id'];

                $receipts_3 = receiptsType::where('operation_id', '=', 10)->where('tree_id', '!=', $tree)->whereHas('receipts',
                    function ($query) use ($type) {
                        $query->where('receiptsType_id', '=', $type);


                    })->get();


            }


        }

        return view('admin.departments.ajax.error', compact('receipts_1','receipts_2','receipts_3', 'limitations_1', 'limitations_2', 'limitations_3'))->render();


    }

}

