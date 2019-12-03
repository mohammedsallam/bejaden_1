<?php

namespace App\Http\Controllers\Admin\Cc;

use App\glcc;
use App\levels;
use App\limitationsType;
use App\Project;
use App\receiptsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(glcc $glcc)
    {
        return view('admin.cc.index',['title'=> trans('admin.cc'),'glcc'=>$glcc]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cc.create',['title'=> trans('admin.create_new_cc')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,glcc $glcc)
    {
//        dd($request->all());
        $data = $this->validate($request,[
            'branch_id' => 'sometimes',
            'name_ar' => 'required',
            'name_en' => 'required',
            'level_id' => 'sometimes',
            'levelType' => 'sometimes',
            'code' => 'sometimes',
            'type'=>'required',
            'status'=>'sometimes',
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
        $ccs = $glcc->create($data);
        if($data['parent_id'] == null){
            $count = count(DB::table('glccs')->where('parent_id',null)->get());
            $level_id = levels::where('type',2)->where('levelId',1)->first()->id;
            DB::table('glccs')->where('id',$ccs->id)->update(['code' => $count,'level_id'=>$level_id]);
        }else{
            $parent =  glcc::where('id',$ccs->parent_id)->first();
            if ($parent->levelType != $ccs->levelType){
                $ccs->delete();
                return back()->with(session()->flash('error',trans('admin.cannot_add_branche')));
            }else{
                $count = count(DB::table('glccs')->where('parent_id',$ccs->parent_id)->where('levelType',$ccs->levelType)->get())-1;

                if (levels::where('type',$ccs->levelType)->where('id',$parent->level_id + 1)->exists()){
                    $level_id = levels::where('type',$ccs->levelType)->where('id',$parent->level_id + 1)->first()->id;
                    if($count == null){
                        $length = levels::where('type',$ccs->levelType)->where('id',$parent->level_id + 1)->first()->length;
                        $code = glcc::where('id',$ccs->parent_id)->where('levelType',$ccs->levelType)->first()->code;
                        $code_first = substr(glcc::where('id',$ccs->parent_id)->where('levelType',$ccs->levelType)->first()->code, 0,1);
                        if ($length == 2){
                            DB::table('glccs')->where('id',$ccs->id)->update(['code' => (($code_first.substr($code,1)).'01') ,'level_id'=>$level_id]);
                        }elseif ($length == 3){
                            DB::table('glccs')->where('id',$ccs->id)->update(['code' => (($code_first.substr($code,1)).'001') ,'level_id'=>$level_id]);
                        }elseif ($length == 4){
                            DB::table('glccs')->where('id',$ccs->id)->update(['code' => (($code_first.substr($code,1)).'0001') ,'level_id'=>$level_id]);
                        }elseif ($length == 5){
                            DB::table('glccs')->where('id',$ccs->id)->update(['code' => (($code_first.substr($code,1)).'00001') ,'level_id'=>$level_id]);
                        }

                    }else{

                        $code = DB::table('glccs')->where('parent_id',$ccs->parent_id)->where('levelType',$ccs->levelType)->max('code');
//                        there here an issue may be from table or from model
                        $i = substr($code + 1, -3,1);
                        if (substr($code + 1, -3) == $i.'00') {
                            $ccs->delete();
                            return back()->with(session()->flash('error', trans('admin.cannot_add')));
                        } else {
                            DB::table('glccs')->where('id', $ccs->id)->update(['code' => $code + 1, 'level_id' => $level_id]);
                        }
                        if (substr($code + 1, -3) == ($i.'000')) {
                            $ccs->delete();
                            return back()->with(session()->flash('error', trans('admin.cannot_add')));
                        } else {
                            DB::table('glccs')->where('id', $ccs->id)->update(['code' => $code + 1, 'level_id' => $level_id]);
                        }
                        if (substr($code + 1, -3) == ($i.'0000')) {
                            $ccs->delete();
                            return back()->with(session()->flash('error', trans('admin.cannot_add')));
                        } else {
                            DB::table('glccs')->where('id', $ccs->id)->update(['code' => $code + 1, 'level_id' => $level_id]);
                        }
                        if (substr($code + 1, -3) == ($i.'00000' + 1)) {
                            $ccs->delete();
                            return back()->with(session()->flash('error', trans('admin.cannot_add')));
                        } else {
                            DB::table('glccs')->where('id', $ccs->id)->update(['code' => $code + 1, 'level_id' => $level_id]);
                        }
                    }
                }else{
                    $ccs->delete();
                    return back()->with(session()->flash('error',trans('admin.cannot_add')));
                }
            }
        }
        DB::table('glccs')->where('id',$ccs->parent_id)->update(['type' => '0']);
        DB::table('glccs')->where('id',$ccs->id)->update(['type' => '1']);

        return redirect(aurl('cc'))->with(session()->flash('message',trans('admin.success_add')));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
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
        $cc = glcc::findOrFail($id);
        $parents = $cc->parents->pluck('name_'.session('lang'),'id');
        return view('admin.cc.edit',['title'=> trans('admin.edit_department') ,'cc'=>$cc,'parents'=>$parents]);
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
            'branch_id' => 'sometimes',
            'name_ar' => 'required',
            'name_en' => 'required',
            'level_id' => 'sometimes',
            'levelType' => 'sometimes',
            'code' => 'sometimes',
            'type'=>'sometimes',
            'status'=>'sometimes',
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
        $cc = glcc::findOrFail($id);
        $cc->update($data);
        return redirect(aurl('cc'))->with(session()->flash('message',trans('admin.success_update')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parentExc = glcc::where('parent_id',$id)->exists();
        if ($parentExc){
            return back()->with(session()->flash('error',trans('admin.cannot_delete')));
        }else{
            $cc = glcc::findOrFail($id);
            limitationsType::where('cc_id',$id)->update(['cc_id'=>null]);
            receiptsType::where('cc_id',$id)->update(['cc_id'=>null]);
            Project::where('cc_id',$id)->update(['cc_id'=>null]);
            DB::table('pjitmmsfls')->where('cc_id',$id)->delete();
            $cc->delete();
            return redirect(aurl('cc'));
        }
    }
}
