<?php

namespace App\Http\Controllers\Admin\categories;

use App\Models\Admin\ActivityTypes;
use App\Models\Admin\MainCompany;
use App\Models\Admin\MtsItmCatgry;
use App\Models\Admin\MtsItmmfs;
use App\Models\Admin\MtsSuplir;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MainCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        $item = MtsItmmfs::get(['Itm_Nm' . ucfirst(session('lang')), 'Itm_No']);
        if (session('Cmp_No') == -1) {
            $cmps = MainCompany::get();
        } else {
            $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->first();
        }

        $activity = ActivityTypes::all();
        $suplirs = MtsSuplir::all();
        $itemToEdit = null;

        if ($request->ajax() && $request->Itm_No){
            $itemToEdit = MtsItmmfs::where('Itm_No', $request->Itm_No)->first();
            return view('admin.categories.MainCategories.edit.index', ['title' => trans('admin.basic_types'),
                'cmps' => $cmps, 'activity' => $activity, 'suplirs' => $suplirs, 'itemToEdit' => $itemToEdit]);
        }


        return view('admin.categories.MainCategories.index', ['title' => trans('admin.basic_types'),
            'cmps' => $cmps, 'activity' => $activity, 'suplirs' => $suplirs, 'itemToEdit' => $itemToEdit]);


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
        $validation = Validator::make($request->all(), [
            'Cmp_No' => 'required',
            'Actvty_No' => 'required',
            'Itm_No' => 'required',
            'Level_No' => 'required',
            'Level_Status' => 'required',
            'Sup_No' => 'required',
            'Itm_NmAr' => 'required',
            'Itm_NmEn' => 'sometimes',
        ],[], [
            'Cmp_No' => trans('admin.na_Comp'),
            'Actvty_No' => trans('admin.activity'),
            'Itm_No' => trans('admin.item_no'),
            'Level_No' => trans('admin.level_no'),
            'Level_Status' => trans('admin.level_number'),
            'Sup_No' => trans('admin.Suppliers'),
            'Itm_NmAr' => trans('admin.name_ar'),
            'Itm_NmEn' => trans('admin.name_en'),
        ]);

        if ($validation->fails()){
            return  response()->json(['status' => 0, 'message' => $validation->getMessageBag()->first()]);
        }

        $itemIfExist = MtsItmmfs::where('Itm_No', $request->Itm_No)->first();

        if ($itemIfExist){
            return response()->json(['status' => 0, 'message' => trans('admin.found_data')]);
        }

        $item = MtsItmmfs::create($request->all());
        $item->update(['Level_Status' => 0, 'Level_No' => 1]);
        session(['updatedComNo', $request->Cmp_No,'updatedActiveNo', $request->Actvty_No]);
        return response()->json(['status' => 1, 'message' => trans('admin.success_add')]);

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

    // Update child or root
    public function updateRootOrChild(Request $request){

        $validation = Validator::make($request->all(), [
            'Cmp_No' => 'required',
            'Actvty_No' => 'required',
            'Itm_No' => 'required',
            'Level_No' => 'required',
            'Level_Status' => 'required',
            'Sup_No' => 'required',
            'Itm_NmAr' => 'required',
            'Itm_NmEn' => 'sometimes',
        ],[], [
            'Cmp_No' => trans('admin.na_Comp'),
            'Actvty_No' => trans('admin.activity'),
            'Itm_No' => trans('admin.item_no'),
            'Level_No' => trans('admin.level_no'),
            'Level_Status' => trans('admin.level_number'),
            'Sup_No' => trans('admin.Suppliers'),
            'Itm_NmAr' => trans('admin.name_ar'),
            'Itm_NmEn' => trans('admin.name_en'),
        ]);

        if ($validation->fails()){
            return  response()->json(['status' => 0, 'message' => $validation->getMessageBag()->first()]);
        }
        $item = MtsItmmfs::where('Itm_No', $request->Itm_No)->first();
        if (!$item){
            return response()->json(['status' => 0, 'message' => trans('admin.not_found_data')]);
        }
        $item->update($request->all());
        session(['updatedComNo', $request->Cmp_No,'updatedActiveNo', $request->Actvty_No]);
        return response()->json(['status' => 1, 'message' => trans('admin.success_add')]);

    }

    // Delete child or root
    public function deleteRootOrChild(Request $request){

        $validation = Validator::make($request->all(), [
            'Itm_No' => 'required',
        ],[], [
            'Itm_No' => trans('admin.item_no'),
        ]);

        if ($validation->fails()){
            return  response()->json(['status' => 0, 'message' => $validation->getMessageBag()->first()]);
        }
        $item = MtsItmmfs::where('Itm_No', $request->Itm_No)->first();
        if($item){
            $item->delete();
            return response()->json(['status' => 1, 'message' => trans('admin.success_deleted')]);
        } else {
            return response()->json(['status' => 0, 'message' => trans('admin.not_found_data')]);
        }


    }

    // Fire when change company number or activity number
    public function getItem(Request $request){
        if($request->ajax()){
            session(['updatedComNo' => $request->Cmp_No , 'updatedActiveNo' => $request->Actvty_No]);
            $tree = load_item('Parent_Itm', null, $request->Cmp_No, $request->Actvty_No);
            return $tree;
        }
    }

    // Create child
    public function createChild(Request $request)
    {

    }

    // Generate Child number depend on parent number
    public function generateChildNo(Request $request){
        $parentId = $request->parent;
        $parent = MtsItmmfs::where('Itm_No', $parentId)->first();
        if($parent){

            if (count($parent->children) > 0){
                // last + 1 if has children
                $index = count($parent->children)-1;
                session(['ItemNoGenerated' => $parent->children[$index]->Itm_No+1]);
                return $parent->children[$index]->Itm_No+1;
            } else {
                return (int)$parentId.'001';
            }


        }
    }
}
