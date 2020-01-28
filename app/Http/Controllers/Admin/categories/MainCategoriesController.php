<?php

namespace App\Http\Controllers\Admin\categories;

use App\Models\Admin\ActivityTypes;
use App\Models\Admin\MainCompany;
use App\Models\Admin\MtsItmmfs;
use App\Models\Admin\MtsSuplir;
use App\Models\Admin\Units;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Description;

class MainCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(){

        if (session('Cmp_No') == -1) {
            $cmps = MainCompany::get();
        } else {
            $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->first();
        }

        $activity = ActivityTypes::all();
        $suppliers = MtsSuplir::all();
        $units = Units::all();
        $itemToEdit = null;

        return view('admin.categories.main_categories.index', ['title' => trans('admin.basic_types'),
            'cmps' => $cmps, 'activity' => $activity, 'suppliers' => $suppliers, 'itemToEdit' => $itemToEdit, 'units' => $units]);

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
    public function updateRootOrChildOrCreateChild(Request $request){
        $validation = Validator::make($request->all(), [
            'Cmp_No' => 'required',
            'Actvty_No' => 'required',
            'Itm_No' => 'required',
            'Itm_Parnt' => 'required',
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
        !$item ? MtsItmmfs::create($request->all()) : $item->update($request->all());
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
        if(count($item->children) > 0){
            return response()->json(['status' => 0, 'message' => trans('admin.cant_delete_category')]);
        }
        if($item){
            $item->delete();
            return response()->json(['status' => 1, 'message' => trans('admin.success_deleted')]);
        } else {
            return response()->json(['status' => 0, 'message' => trans('admin.not_found_data')]);
        }


    }

    // Fire when change company number or activity number
    public function getCategoryItem(Request $request){
        if($request->ajax()){
            session(['updatedComNo' => $request->Cmp_No , 'updatedActiveNo' => $request->Actvty_No]);
            $tree = load_item('Itm_Parnt', '', $request->Cmp_No, $request->Actvty_No);
            return $tree;
        }
    }

    // Create child
    public function returnCreateChildBlade(Request $request)
    {
        if ($request->ajax() && $request->parent){
            $item = MtsItmmfs::where('Itm_No', $request->parent)->first();
            if (session('Cmp_No') == -1) {
                $cmps = MainCompany::get();
            } else {
                $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->first();
            }

            $activity = ActivityTypes::all();
            $suppliers = MtsSuplir::all();
            $units  = Units::all();

            $lastChild = null;

            if (count($item->children) > 0){
                $lastChild = $item->children[count($item->children)-1];
            }

            return view('admin.categories.main_categories.create_child.index', compact(['cmps', 'activity', 'suppliers', 'units', 'lastChild', 'item']));



        }
    }

    // get root or child for edit
    public function getRootOrChildForEdit(Request $request)
    {
        if (session('Cmp_No') == -1) {
            $cmps = MainCompany::get();
        } else {
            $cmps = MainCompany::where('Cmp_No', session('Cmp_No'))->first();
        }

        $activity = ActivityTypes::all();
        $suppliers = MtsSuplir::all();
        $units  = Units::all();
        $itemToEdit = null;

        if ($request->ajax() && ($request->Itm_No || $request->parent)){
            $itemToEdit = MtsItmmfs::where('Itm_No', $request->Itm_No)->orWhere('Itm_No', $request->parent)->first();
            return view('admin.categories.main_categories.edit.edit_parent_or_child', ['title' => trans('admin.basic_types'),
                'cmps' => $cmps, 'activity' => $activity, 'suppliers' => $suppliers, 'itemToEdit' => $itemToEdit, 'units' => $units]);
        }
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
