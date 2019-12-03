<?php

namespace App\Http\Controllers\Admin\limitations;

use App\Branches;
use App\DataTables\limitationsDataTable;
use App\DataTables\noticedebtDataTable; 
use App\Department;
use App\Http\Controllers\Controller;
use App\limitationReceipts;
use App\limitations;
use App\limitationsData;
use App\limitationsType;
use App\operation;
use App\pjitmmsfl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Matrix\Exception;

class LimitationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(limitationsDataTable $limitations)
    {
        return $limitations->render('admin.limitations.invoice.index',['title'=>trans('admin.limitations')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        DB::table('limitations_type')->where('status',0)->delete();
        DB::table('limitations')->where('status',0)->delete();
        DB::table('limitations_datas')->where('limitations_id',null)->delete();
        $limitationReceipts = limitationReceipts::where('type',1)->pluck('name_'.session('lang'),'id');
        $title = trans('admin.create_limitations');
        $branches = Branches::pluck('name_'.session('lang'),'id');
        return view('admin.limitations.create',compact('title','branches','limitationReceipts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            $type = $request->type;
            $limitations = $request->limitations;
            $invoice = $request->invoice;
            $operation = operation::where('id',$type)->first();
            $data = limitationsType::where('invoice_id',$request->invoice)->get();
                    if ($type == 4){
                        $tree = Department::where('levelType','=',1)->pluck('dep_name_'.session('lang'),'id');
                    }elseif ($type == 1){
                            $tree = $operation->suppliers->pluck('name_'.session('lang'),'id');
                    }elseif ($type == 2){
                            $tree = $operation->subscribers->pluck('name_'.session('lang'),'id');
                    }elseif ($type == 5){
                        $tree = $operation->drivers->pluck('name_'.session('lang'),'id');
                    }
            $contents = view('admin.limitations.detailsselect', ['data'=>$data,'invoice'=>$invoice,'limitations'=>$limitations,'type'=>$type,'operation'=>$operation,'tree'=>$tree])->render();
            return $contents;
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        if($request->ajax()){
            $branches_id = $request->branches;
            $date = $request->date;
            $invoice = $request->invoice;
            $limitations_id = $request->limitations;
            if($branches_id != null && $date != null && $limitations_id != null){
                $limitationsId = limitationReceipts::where('id',$request->limitations)->first()->limitationReceiptsId;
                $branches = Branches::where('id',$branches_id)->first();
                $operations = operation::whereIn('receipt',[1,2])->pluck('name_'.session('lang'),'id');
                DB::table('limitations_type')->where('status', 0)->delete();
                $contents = view('admin.limitations.show', ['limitationsId'=>$limitationsId,'invoice'=>$invoice, 'branches' => $branches, 'date' => $date, 'limitations_id' => $limitations_id, 'operations' => $operations])->render();
                return $contents;
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
        DB::table('limitations_type')->where('status',0)->delete();
        DB::table('limitations')->where('status',0)->delete();
        DB::table('limitations_datas')->where('limitations_id',null)->delete();

        $limitations = limitations::findOrFail($id);
        $title = trans('admin.edit_limitations');
        $operations = operation::whereIn('receipt',[1,2])->pluck('name_'.session('lang'),'id');
        $data = limitationsType::where('limitations_id',$limitations->id)->get();
        $limitationsData = limitationsData::where('limitations_id',$limitations->id)->first();
        return view('admin.limitations.edit.show',compact('limitations','operations','title','data','limitationsData'));
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
        $limitations = limitations::findOrFail($id);
        $limitationsData = limitationsData::where('invoice_id',$limitations->invoice_id)->where('limitations_id',$id)->first();
        $limitationsType = limitationsType::where('invoice_id',$limitations->invoice_id)->where('limitations_id',$id)->get();


        if (!empty($limitationsData->limitationsType)){
//                for receiptsType departement
            if (limitationsType::where('invoice_id',$limitations->invoice_id)->where('limitations_id',$id)->exists()){
                $operations = limitationsType::where('invoice_id',$limitations->invoice_id)->pluck('operation_id');
                $tree_id = limitationsType::where('invoice_id',$limitations->invoice_id)->whereIn('operation_id',$operations)->pluck('tree_id');
                $limitationsTypetree = limitationsType::where('invoice_id', $limitations->invoice_id)->where('limitations_id',$id)->whereIn('tree_id', $tree_id)->get();
                foreach ($limitationsTypetree as $type){
                    DB::table('departments')->where('id',$type->tree_id)->update(['debtor' => DB::raw('debtor - '.$type->debtor),'creditor' => DB::raw('creditor - '.$type->creditor)]);
                    getSitioPadre($type->tree_id,-$type->debtor,-$type->creditor);
                }
//                for receiptsType glcc
                $cc_id = limitationsType::where('invoice_id',$limitations->invoice_id)->where('cc_id','!=',null)->whereIn('operation_id',$operations)->pluck('cc_id');
                $limitationsTypecc = limitationsType::where('invoice_id', $limitations->invoice_id)->whereIn('cc_id',$cc_id)->get();
                foreach ($limitationsTypecc as $type){
                    DB::table('glccs')->where('id',$type->cc_id)->update(['debtor' => DB::raw('debtor - '.$type->debtor),'creditor' => DB::raw('creditor - '.$type->creditor)]);
                    getSitiocc($type->cc_id,-$type->debtor,-$type->creditor);
                }
            }
        }
//        dd($limitationsData->limitationsType);

        $limitationsData->limitationsType()->detach($limitationsType);

        $limitationsData->debtor = $limitationsType->sum('debtor');
        $limitationsData->creditor = $limitationsType->sum('creditor');
        $limitationsData->save();
        $limitationsData->limitationsType()->attach($limitationsType);

        DB::table('limitations_type')->where('invoice_id',$limitations->invoice_id)->update(['limitations_id'=>$limitations->id,'status'=>1]);
        DB::table('limitations_datas')->where('invoice_id',$limitations->invoice_id)->update(['status'=>1,'limitations_id'=>$limitations->id]);
        $data = $limitations->limitations_type;
//        dd($data);
//        $operations = limitationsType::where('invoice_id',$limitations->invoice_id)->pluck('operation_id');
        $tree_id2 = limitationsType::where('invoice_id',$limitations->invoice_id)->pluck('tree_id');
        $limitationsTypetree2 = limitationsType::where('invoice_id', $limitations->invoice_id)->whereIn('tree_id', $tree_id2)->get();
        foreach ($limitationsTypetree2 as $type){
            DB::table('departments')->where('id',$type->tree_id)->update(['debtor' => DB::raw('debtor + '.$type->debtor),'creditor' => DB::raw('creditor + '.$type->creditor)]);
            getSitioPadre($type->tree_id,$type->debtor,$type->creditor);
        }
//                for receiptsType glcc
        $cc_id2 = limitationsType::where('invoice_id',$limitations->invoice_id)->pluck('cc_id');
        $limitationsTypecc2 = limitationsType::where('invoice_id', $limitations->invoice_id)->whereIn('cc_id',$cc_id2)->get();
        foreach ($limitationsTypecc2 as $type){
            DB::table('glccs')->where('id',$type->cc_id)->update(['debtor' => DB::raw('debtor + '.$type->debtor),'creditor' => DB::raw('creditor + '.$type->creditor)]);
            getSitiocc($type->cc_id,$type->debtor,$type->creditor);
        }
//        $limitationsData->debtor = $limitationsType->sum('debtor');
//        $limitationsData->creditor = $limitationsType->sum('creditor');
//        $limitationsData->save();
        return view('admin.limitations.invoice.show',compact('limitationsData','data','limitations'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $limitations = limitations::findOrFail($id);
        $operations = limitationsType::where('invoice_id',$limitations->invoice_id)->pluck('operation_id');
        DB::beginTransaction();
        try{
            //                for receiptsType departement
            $tree_id = limitationsType::where('invoice_id',$limitations->invoice_id)->whereIn('operation_id',$operations)->pluck('tree_id');
            $limitationsTypetree = limitationsType::where('invoice_id',$limitations->invoice_id)->whereIn('tree_id',$tree_id)->get();
            foreach ($limitationsTypetree as $type){
//                $minusdep = DB::table('departments')->where('id',$type->tree_id)->update(['debtor' => DB::raw('debtor - '.$type->debtor),'creditor' => DB::raw('creditor - '.$type->creditor)]);
                pjitmmsfl::where('tree_id',$type->tree_id)->where('month',date('n',strtotime($type->limitations->created_at)))->where('year',date('Y',strtotime($type->limitations->created_at)))->update(['debtor' => DB::raw('debtor - '.$type->debtor),'creditor' => DB::raw('creditor - '.$type->creditor)]);
                $minusgetSitioPadre = getSitioPadre($type->tree_id,-$type->debtor,-$type->creditor,$type->limitations->created_at);
            }
//                for receiptsType glcc
            $cc_id = limitationsType::where('invoice_id',$limitations->invoice_id)->whereIn('operation_id',$operations)->pluck('cc_id');
            $limitationsTypecc = limitationsType::where('invoice_id', $limitations->invoice_id)->whereIn('cc_id',$cc_id)->get();
            foreach ($limitationsTypecc as $type){
                $minuscc = DB::table('glccs')->where('id',$type->cc_id)->update(['debtor' => DB::raw('debtor - '.$type->debtor),'creditor' => DB::raw('creditor - '.$type->creditor)]);
                pjitmmsfl::where('cc_id',$type->cc_id)->where('month',date('n',strtotime($type->limitations->created_at)))->where('year',date('Y',strtotime($type->limitations->created_at)))->update(['debtor' => DB::raw('debtor - '.$type->debtor),'creditor' => DB::raw('creditor - '.$type->creditor)]);
                $minusgetSitiocc = getSitiocc($type->cc_id,-$type->debtor,-$type->creditor,$type->limitations->created_at);
            }
            if ($limitations->status == 0){
                $delete = $limitations->delete();
            }else{
                $limitationType = limitationsType::where('limitations_id',$id)->get();
                $limitationsData = limitationsData::where('limitations_id',$id)->first();
                $limitationsData->limitationsType()->detach($limitationType);
                $limitationsDatadel = $limitationsData->delete();
                $limitationsTypedel = limitationsType::where('limitations_id',$id)->delete();
                $delete = $limitations->delete();
            }
            DB::commit();
        }catch (Exception $e){
            return $e;
            DB::rollBack();
        }
        $minusgetSitioPadre;
        $minusgetSitiocc;
        $delete;
        $limitationsDatadel;
        $limitationsTypedel;

        return redirect()->route('limitations.index');
    }

    //Edit by: Norhan Hesham Foda
    public function noticedebt(noticedebtDataTable $limitations)
    {
        return $limitations->render('admin.limitations.invoice.index',['title'=>trans('admin.limitations')]);
    }

    public function debt()
    {
        DB::table('limitations_type')->where('status',0)->delete();
        DB::table('limitations')->where('status',0)->delete();
        DB::table('limitations_datas')->where('limitations_id',null)->delete();
        $limitationReceipts = limitationReceipts::where('type',1)->where('limitationReceiptsId',1)->pluck('name_'.session('lang'),'id');
        $title = trans('admin.create_limitations');
        $branches = Branches::pluck('name_'.session('lang'),'id');
        return view('admin.banks.debt.create',compact('title','branches','limitationReceipts'));
    }
}
