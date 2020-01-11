<?php

namespace App\Http\Controllers\Admin\AstNutrbusn;

use App\DataTables\AstNutrbusnDataTable;
use App\Models\Admin\AstNutrbusn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

class AstNutrbusnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AstNutrbusnDataTable $AstNutrbusn)
    {
        $id = AstNutrbusn::where('Name_Ar','=',null)->orWhere('Name_Ar','=','')->pluck('ID_No');
        DB::table('astnutrbusns')->where('Name_En',null)->where('Name_Ar',null)->orWhere('Name_Ar','=','')->delete();

        return $AstNutrbusn->render('admin.AstNutrbusn.index',['title'=>trans('admin.types_of_AstNutrbusn')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $last = AstNutrbusn::orderBy('ID_No', 'desc')->latest()->first(); //latest record
        if(!empty($last) || $last || $last < 0){
            $last = $last->ID_No+1;
        }else{
            $last =  1;
        }
        return view('admin.AstNutrbusn.create',['title'=> trans('admin.add_type_of_activitie')], compact('last'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request,[
            'Nutr_No'  =>'sometimes',
            'Name_Ar'=>'required',
            'Name_En'=>'required',
        ]);
        $act = AstNutrbusn::create($data);
        return redirect(aurl('AstNutrbusn'))->with(session()->flash('message',trans('admin.success_add')));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AstNutrbusn  $AstNutrbusn
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $act= AstNutrbusn::findOrFail($id);
        return view('admin.AstNutrbusn.show',compact('act'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AstNutrbusn  $AstNutrbusn
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $act= AstNutrbusn::findOrFail($id);
        return view('admin.AstNutrbusn.edit',['title'=> trans('admin.edit_type_of_activitie'),'act'=>$act]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AstNutrbusn  $AstNutrbusn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request,[
            'ID_No'  =>'sometimes',
            'Name_Ar'=>'required',
            'Name_En'=>'required',
        ]);
        $act  = AstNutrbusn::where('ID_No',$id)->first();
        $act->update($data);
        return redirect(aurl('AstNutrbusn'))->with(session()->flash('message',trans('admin.success_update')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AstNutrbusn  $AstNutrbusn
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activitie  = AstNutrbusn::where('ID_No',$id);
        $activitie->delete();
        return redirect(aurl('AstNutrbusn'));
    }
}
