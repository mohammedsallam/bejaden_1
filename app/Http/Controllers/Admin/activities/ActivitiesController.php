<?php

namespace App\Http\Controllers\Admin\activities;

use App\activities;
use App\DataTables\ActivitiesDataTable;
use App\subscription;
use App\Models\Admin\AstNutrbusn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ActivitiesDataTable $activities)
    {
        return $activities->render('admin.activities.index',['title'=>trans('admin.types_of_activities')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.activities.create',['title'=> trans('admin.add_type_of_activitie')]);
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
            'Short_Arb'=>'sometimes',
            'Short_Eng'=>'sometimes',
            'Nutr_NmAr'=>'required',
            'Nutr_NmEn'=>'required',
        ]);
        AstNutrbusn::create($data);
        return redirect(aurl('activities'))->with(session()->flash('message',trans('admin.success_add')));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\activities  $activities
     * @return \Illuminate\Http\Response
     */
    public function show(AstNutrbusn $activities)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\activities  $activities
     * @return \Illuminate\Http\Response
     */
    public function edit(AstNutrbusn $activities,$id)
    {
        $activitie  = AstNutrbusn::where('ID_No',$id)->first();
        return view('admin.activities.edit',['title'=> trans('admin.edit_type_of_activitie'),'activitie'=>$activitie]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\activities  $activities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)

    {

        $activitie  = AstNutrbusn::where('ID_No',$id)->first();

          $activitie->Nutr_No= $request->Nutr_No;
          $activitie->Short_Arb = $request->Short_Arb;
          $activitie->Short_Eng = $request->Short_Eng;
          $activitie->Nutr_NmAr  = $request->Nutr_NmAr;
          $activitie->Nutr_NmEn = $request->Nutr_NmEn;


          $activitie->save();


        return redirect(aurl('activities'))->with(session()->flash('message',trans('admin.success_update')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\activities  $activities
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activitie  = AstNutrbusn::findOrFail($id);
        subscription::where('AstNutrbusn_id',$id)->update(['AstNutrbusn_id'=>null]);
        $activitie->delete();
        return redirect(aurl('activities'));
    }
}
