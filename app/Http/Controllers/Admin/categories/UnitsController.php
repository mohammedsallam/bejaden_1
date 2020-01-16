<?php

namespace App\Http\Controllers\Admin\categories;

use App\DataTables\UnitsDataTable;
use App\Models\Admin\Units;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UnitsDataTable $table
     * @return Response
     */
    public function index(UnitsDataTable $table)
    {
        return  $table->render('admin.categories.units.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.categories.units.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'Unit_No' => 'required',
            'Unit_NmAr' => 'required',
            'Unit_NmEn' => 'required',
        ], [], [

            'Unit_No' => trans('admin.unit_no'),
            'Unit_NmAr' => trans('admin.name_ar'),
            'Unit_NmEn' => trans('admin.name_en'),
        ]);

        Units::create($data);
        return  redirect()->route('units.index')->with(session()->flash('message', trans('admin.save_success')));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $unit = Units::find($id);
        return view('admin.categories.units.edit', compact(['unit']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'Unit_No' => 'required',
            'Unit_NmAr' => 'required',
            'Unit_NmEn' => 'required',
        ], [], [

            'Unit_No' => trans('admin.unit_no'),
            'Unit_NmAr' => trans('admin.name_ar'),
            'Unit_NmEn' => trans('admin.name_en'),
        ]);

        Units::find($id)->update($data);
        return  redirect()->route('units.index')->with(session()->flash('message', trans('admin.save_success')));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Units::find($id)->delete();
        return  redirect()->route('units.index')->with(session()->flash('message', trans('admin.success_deleted')));


    }
}
