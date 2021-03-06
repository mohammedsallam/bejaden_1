<?php

namespace App\Http\Controllers\Admin\Country;

use App\country;
use App\DataTables\CountryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Up;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CountryDataTable $country)
    {
        return $country->render('admin.countries.index',['title'=>trans('admin.countries')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.countries.create',['title'=> trans('admin.create_new_country')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,country $country)
    {
        $data = $this->validate($request,[
            'country_name_ar' => 'required',
            'country_name_en' => 'required',
            'mob' => 'sometimes',
            'code' => 'sometimes',
            'logo' => 'sometimes',
        ],[],[
            'country_name_ar' => trans('admin.arabic_name'),
            'country_name_en' => trans('admin.english_name'),
            'mob' => trans('admin.mob'),
            'code' => trans('admin.code'),
            'logo' => trans('admin.logo'),
        ]);
        if($request->hasFile('logo')){
            $data['logo'] = Up::upload([
                'request' => 'logo',
                'path'=>'countries',
                'upload_type' => 'single'
            ]);
        }
        $country->create($data);
        return redirect(aurl('countries'))->with(session()->flash('message',trans('admin.success_add')));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = country::findOrFail($id);
        return view('admin.countries.edit',['title'=> trans('admin.edit_country') ,'country'=>$country]);
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
            'country_name_ar' => 'required',
            'country_name_en' => 'required',
            'mob' => 'sometimes',
            'code' => 'sometimes',
            'logo' => 'sometimes',
        ],[],[
            'country_name_ar' => 'Arabic Name',
            'country_name_en' => 'English Name',
            'mob' => 'Mob',
            'code' => 'Code',
            'logo' => 'Logo',
        ]);
        $country = country::findOrFail($id);
        if($request->hasFile('logo')){
            $data['logo'] = Up::upload([
                'request' => 'logo',
                'path'=>'countries',
                'upload_type' => 'single',
                'delete_file'=> $country->logo
            ]);
        }
        $country->update($data);
        return redirect(aurl('countries'))->with(session()->flash('message',trans('admin.success_update')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = country::findOrFail($id);
        Storage::delete($country->logo);
        $country->delete();
        return redirect(aurl('countries'));
    }
}
