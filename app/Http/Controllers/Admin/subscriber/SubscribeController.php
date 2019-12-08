<?php

namespace App\Http\Controllers\Admin\subscriber;

use App\activity_type;
use App\Branches;
use App\city;
use App\country;
use App\DataTables\subcriberDataTable;
use App\Department;
use App\employee;
use App\Models\Admin\MTsCustomer;
use App\Models\Admin\MainBranch;

use App\Enums\TypeType;
use App\glcc;
use App\Http\Controllers\Controller;
use App\parents;
use App\state;
use App\subscription;
use BenSampo\Enum\Rules\EnumKey;
use BenSampo\Enum\Rules\EnumValue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Up;

class SubscribeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(subcriberDataTable $subcriber)
    {
        return $subcriber->render('admin.subscribers.index', ['title'=> trans('admin.Subscribers')]);
    }


    public function create()
    {
        // $branches = Branches::pluck('name_'.session('lang'),'id');
        // $departments = Department::where('operation_id',2)->where('type','1')->pluck('dep_name_'.session('lang'),'id');
        // $countries = country::pluck('country_name_'.session('lang'),'id');
        // $cities = city::pluck('city_name_'.session('lang'),'id');
        // $states = state::pluck('state_name_'.session('lang'),'id');
        // $employees = employee::where('sales_officer',1)->pluck('name_'.session('lang'),'id');
        // $glccs = glcc::where('type','=','1')->pluck('name_'.session('lang'),'id');
        // $activity_type = activity_type::pluck('name_'.session('lang'),'id');

        // return view('admin.subscribers.create1',
        //             ['title'=>trans('admin.create_new_subscriber'),'states'=>$states,'branches'=>$branches,'departments'=>$departments,'countries'=>$countries,'cities'=>$cities,'employees'=>$employees,'activity_type'=>$activity_type,'glccs'=>$glccs]);

        $subscriber = MTsCustomer::get();
        return view('admin.subscribers.create1', compact('subscriber'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,subscription $subscription)
    {

        //dd($request->all());
        $data = $this->validate($request, [
            'Cmp_No'     => 'sometimes',
            'Brn_No'    => 'sometimes',
            'Cstm_No' => 'sometimes',
            'Cstm_Active' => 'sometimes',
            'Cstm_Ctg' => 'sometimes',
            'Cstm_Refno' => 'sometimes',
            'Acc_No' => 'sometimes',
            'Cstm_NmEn' => 'sometimes',
            'Cstm_NmAr' => 'required',
            'Catg_No' => 'sometimes',
            'Slm_No' => 'sometimes',
            'Mrkt_No' => 'sometimes',
            'Nutr_No' => 'sometimes',
            'Cntry_No' => 'sometimes',
            'City_No' => 'sometimes',
            'Area_No' => 'sometimes',
            'Credit_Value' => 'sometimes',
            'Credit_Days' => 'sometimes',
            'Cstm_Adr' => 'sometimes',
            'Cstm_POBox' => 'sometimes',
            'Cstm_ZipCode' => 'sometimes',
            'Cstm_Rsp' => 'sometimes',
            'Cstm_Othr' => 'sometimes',
            'Cstm_Email' => 'sometimes',
            'Cstm_Tel' => 'sometimes',
            'Cstm_Fax' => 'sometimes',
            'Cntct_Prsn1' => 'sometimes',
            'TitL1' => 'sometimes',
            'TitL2' => 'sometimes',
            'TitL3' => 'sometimes',
            'TitL4' => 'sometimes',
            'TitL5' => 'sometimes',
            'Mobile1' => 'sometimes',
            'Tel1' => 'sometimes',
            'Fbal_Db' => 'sometimes',
            'Mobile' => 'sometimes',
            'Fbal_CR' => 'sometimes',
            'CR11' => 'sometimes',
            'DB11' => 'sometimes',
            'Opn_Date' => 'sometimes',
            'Opn_Time' => 'sometimes',
            'User_ID' => 'sometimes',
            'Updt_Date' => 'sometimes',
            'Cstm_Agrmnt' => 'sometimes',
            'Disc_prct' => 'sometimes',
            'Itm_Sal' => 'sometimes',
            'Linv_No' => 'sometimes',
            'Linv_Dt' => 'sometimes',
            'Linv_Net' => 'sometimes',
            'LRcpt_No' => 'sometimes',
            'LRcpt_Dt' => 'sometimes',
            'LRcpt_Db' => 'sometimes',
            'Notes' => 'sometimes',
            'Tax_No' => 'sometimes',
        ],[
            'Cmp_No' => trans('admin.Cmp_No'),
            'Brn_No' => trans('admin.Brn_No'),
            'Cstm_No' => trans('admin.Cstm_No'),
            'Cstm_Active' => trans('admin.Cstm_Active'),
            'Cstm_Ctg' => trans('admin.Cstm_Ctg'),
            'Cstm_Refno' => trans('admin.Cstm_Refno'),
            'Acc_No' => trans('admin.Acc_No'),
            'Cstm_NmEn' => trans('admin.Cstm_NmEn'),
            'Cstm_NmAr' => trans('admin.Cstm_NmAr'),
            'Catg_No' => trans('admin.Catg_No'),
            'Slm_No' => trans('admin.Slm_No'),
            'Mrkt_No' => trans('admin.Mrkt_No'),
            'Nutr_No' => trans('admin.Nutr_No'),
            'Cntry_No' => trans('admin.Cntry_No'),
            'City_No' => trans('admin.City_No'),
            'Area_No' => trans('admin.Area_No'),
            'Credit_Value' => trans('admin.Credit_Value'),
            'Credit_Days'=>trans ('admin.Credit_Days')

        ]);

        //$input = $request->all();

        MTsCustomer::create($data);

        return redirect(aurl('subscribers'))->with(session()->flash('message',trans('admin.success_add')));


//        dd($request->all());
//         $data = $this->validate($request,[
//             'name_ar' => 'required',
//             'name_en'=>'sometimes',
//             'email'=>'sometimes',
//             'address'=>'sometimes',
//             'branches_id'=>'sometimes',
//             'status'=>'sometimes',
//             'phone_1'=>'sometimes',
//             'phone_2'=>'sometimes',
//             'phone_3'=>'sometimes',
//             'phone_4'=>'sometimes',
//             'per_status'=>'sometimes',
//             'facebook'=>'sometimes',
//             'twitter'=>'sometimes',
//             'tax_num'=>'sometimes',
//             'Discounts'=>'sometimes',
//             'Commissions'=>'sometimes',
//             'note'=>'sometimes',
//             'debtor'=>'required',
//             'creditor'=>'required',
//             'user_id'=>'sometimes',
//             'admin_id'=>'sometimes',
//             'operation_id'=>'sometimes',
//             'countries_id'=>'sometimes',
//             'city_id'=>'sometimes',
//             'employee_id'=>'sometimes',
//             'activity_type_id'=>'sometimes',
//             'state_id'=>'sometimes',
//             'tree_id'=>'required',
//             'credit_limit'=>'sometimes',
//             'repayment_period'=>'sometimes',
//             'discount'=>'sometimes',
//         ],[],[
//             'name_ar' => trans('admin.arabic_name'),
//             'name_en' => trans('admin.english_name'),
//             'email' => trans('admin.email'),
//             'image' => trans('admin.image'),
//             'address' => trans('admin.addriss'),
//             'supervisor' => trans('admin.supervisor'),
//             'pay_status' => trans('admin.pay_status'),
//             'branches_id' => trans('admin.Branches'),
//             'start' => trans('admin.startsub'),
//             'end' => trans('admin.endsub'),
//             'phone_1' => trans('admin.mob'),
//             'phone_2' => trans('admin.phone'),
//             'per_status' => trans('admin.status'),
//             'age' => trans('admin.age'),
//             'gender' => trans('admin.gender'),
//             'facebook' => trans('admin.facebook'),
//             'twitter' => trans('admin.twitter'),
//             'admin_id'=>trans ('admin.assigned_by')
//         ]);

//         if ($request->Discounts){
//             $data['Discounts'] = $request->Discounts;
//         }else{
//             $data['Discounts'] = 0;
//         }

//         if ($request->Commissions){
//             $data['Commissions'] = $request->Commissions;
//         }else{
//             $data['Commissions'] = 0;
//         }

// //        if ($request->cc_type){
// //            $data['cc_type'] = $request->cc_type;
// //        }else{
// //            $data['cc_type'] = 0;
// //        }
//         $subscription->create($data);
//         return redirect(aurl('subscribers'))->with(session()->flash('message',trans('admin.success_add')));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($ID_No)
    {
        $subscriber= MTsCustomer::findOrFail($ID_No);
        return view('admin.subscribers.show1',compact('subscriber'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($ID_No,state $state)
    {


        /*$departments = Department::where('operation_id',2)->where('type','1')->pluck('dep_name_'.session('lang'),'id');
        $branches = Branches::pluck('name_'.session('lang'),'id');
        $countries = country::pluck('country_name_'.session('lang'),'id');
        $cities = city::pluck('city_name_'.session('lang'),'id');
        $states = state::pluck('state_name_'.session('lang'),'id');
        $employees = employee::where('sales_officer',1)->pluck('name_'.session('lang'),'id');
        $activity_type = activity_type::pluck('name_'.session('lang'),'id');
        $glccs = glcc::where('type','=','1')->pluck('name_'.session('lang'),'id');
        $subscriber = subscription::findOrFail($id);
        return view('admin.subscribers.edit',['title'=>trans('admin.Edit_Subscriber'),'states'=>$states,'branches'=>$branches,'subscriber'=>$subscriber,'state'=>$state,'departments'=>$departments,'countries'=>$countries,'cities'=>$cities,'employees'=>$employees,'activity_type'=>$activity_type,'glccs'=>$glccs]);*/

        $subscriber = MTsCustomer::findOrFail($ID_No);



         return view('admin.subscribers.edit1',compact('subscriber'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ID_No)
    {
//        dd($request->all());

        $validator=$this->validate($request, [
            'Cmp_No'     => 'sometimes',
            'Brn_No'    => 'sometimes',
            'Cstm_No' => 'sometimes',
            'Cstm_Active' => 'sometimes',
            'Cstm_Ctg' => 'sometimes',
            'Cstm_Refno' => 'sometimes',
            'Acc_No' => 'sometimes',
            'Cstm_NmEn' => 'sometimes',
            'Cstm_NmAr' => 'sometimes',
            'Catg_No' => 'sometimes',
            'Slm_No' => 'sometimes',
            'Mrkt_No' => 'sometimes',
            'Nutr_No' => 'sometimes',
            'Cntry_No' => 'sometimes',
            'City_No' => 'sometimes',
            'Area_No' => 'sometimes',
            'Credit_Value' => 'sometimes',
            'Credit_Days' => 'sometimes',
            'Cstm_Adr' => 'sometimes',
            'Cstm_POBox' => 'sometimes',
            'Cstm_ZipCode' => 'sometimes',
            'Cstm_Rsp' => 'sometimes',
            'Cstm_Othr' => 'sometimes',
            'Cstm_Email' => 'sometimes',
            'Cstm_Tel' => 'sometimes',
            'Cstm_Fax' => 'sometimes',
            'Cntct_Prsn1' => 'sometimes',
            'TitL1' => 'sometimes',
            'TitL2' => 'sometimes',
            'TitL3' => 'sometimes',
            'TitL4' => 'sometimes',
            'TitL5' => 'sometimes',
            'Mobile1' => 'sometimes',
            'Tel1' => 'sometimes',
            'Fbal_Db' => 'sometimes',
            'Mobile' => 'sometimes',
            'Fbal_CR' => 'sometimes',
            'CR11' => 'sometimes',
            'DB11' => 'sometimes',
            'Opn_Date' => 'sometimes',
            'Opn_Time' => 'sometimes',
            'User_ID' => 'sometimes',
            'Updt_Date' => 'sometimes',
            'Cstm_Agrmnt' => 'sometimes',
            'Disc_prct' => 'sometimes',
            'Itm_Sal' => 'sometimes',
            'Linv_No' => 'sometimes',
            'Linv_Dt' => 'sometimes',
            'Linv_Net' => 'sometimes',
            'LRcpt_No' => 'sometimes',
            'LRcpt_Dt' => 'sometimes',
            'LRcpt_Db' => 'sometimes',
            'Notes' => 'sometimes',
            'Tax_No' => 'sometimes',
        ],[
            'Cmp_No' => trans('admin.Cmp_No'),
            'Brn_No' => trans('admin.Brn_No'),
            'Cstm_No' => trans('admin.Cstm_No'),
            'Cstm_Active' => trans('admin.Cstm_Active'),
            'Cstm_Ctg' => trans('admin.Cstm_Ctg'),
            'Cstm_Refno' => trans('admin.Cstm_Refno'),
            'Acc_No' => trans('admin.Acc_No'),
            'Cstm_NmEn' => trans('admin.Cstm_NmEn'),
            'Cstm_NmAr' => trans('admin.Cstm_NmAr'),
            'Catg_No' => trans('admin.Catg_No'),
            'Slm_No' => trans('admin.Slm_No'),
            'Mrkt_No' => trans('admin.Mrkt_No'),
            'Nutr_No' => trans('admin.Nutr_No'),
            'Cntry_No' => trans('admin.Cntry_No'),
            'City_No' => trans('admin.City_No'),
            'Area_No' => trans('admin.Area_No'),
            'Credit_Value' => trans('admin.Credit_Value'),
            'Credit_Days'=>trans ('admin.Credit_Days')

        ]);
        $input = $request->all();
        $subscriber = MTsCustomer::find($ID_No);
        $subscriber->update($input);

        return redirect(aurl('subscribers'))->with(session()->flash('message',trans('admin.success_update')));
//         $data = $this->validate($request,[
//             'name_ar' => 'required',
//             'name_en'=>'sometimes',
//             'email'=>'sometimes',
//             'address'=>'sometimes',
//             'branches_id'=>'sometimes',
//             'status'=>'sometimes',
//             'phone_1'=>'sometimes',
//             'phone_2'=>'sometimes',
//             'phone_3'=>'sometimes',
//             'phone_4'=>'sometimes',
//             'per_status'=>'sometimes',
//             'facebook'=>'sometimes',
//             'twitter'=>'sometimes',
//             'tax_num'=>'sometimes',
//             'Discounts'=>'sometimes',
//             'Commissions'=>'sometimes',
//             'note'=>'sometimes',
//             'debtor'=>'sometimes',
//             'creditor'=>'sometimes',
//             'user_id'=>'sometimes',
//             'admin_id'=>'sometimes',
//             'operation_id'=>'sometimes',
//             'countries_id'=>'sometimes',
//             'city_id'=>'sometimes',
//             'employee_id'=>'sometimes',
//             'activity_type_id'=>'sometimes',
//             'state_id'=>'sometimes',
//             'tree_id'=>'required',
//             'credit_limit'=>'sometimes',
//             'repayment_period'=>'sometimes',
//             'discount'=>'sometimes',
//         ],[],[
//             'name_ar' => trans('admin.arabic_name'),
//             'name_en' => trans('admin.english_name'),
//             'email' => trans('admin.email'),
//             'image' => trans('admin.image'),
//             'address' => trans('admin.addriss'),
//             'supervisor' => trans('admin.supervisor'),
//             'pay_status' => trans('admin.pay_status'),
//             'branches_id' => trans('admin.Branches'),
//             'start' => trans('admin.startsub'),
//             'end' => trans('admin.endsub'),
//             'phone_1' => trans('admin.mob'),
//             'phone_2' => trans('admin.phone'),
//             'per_status' => trans('admin.status'),
//             'age' => trans('admin.age'),
//             'gender' => trans('admin.gender'),
//             'facebook' => trans('admin.facebook'),
//             'twitter' => trans('admin.twitter'),
//             'admin_id'=>trans ('admin.assigned_by')
//         ]);

//         if ($request->Discounts){
//             $data['Discounts'] = $request->Discounts;
//         }else{
//             $data['Discounts'] = 0;
//         }

//         if ($request->Commissions){
//             $data['Commissions'] = $request->Commissions;
//         }else{
//             $data['Commissions'] = 0;
//         }
// //
// //        if ($request->cc_type){
// //            $data['cc_type'] = $request->cc_type;
// //        }else{
// //            $data['cc_type'] = 0;
// //        }
//         $subscriber->update($data);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ID_No)
    {
        $subscriber = MTsCustomer::findOrFail($ID_No);
        $subscriber->delete();
        return redirect(aurl('subscribers'))->with(session()->flash('message',trans('admin.success_deleted')));
    }

    //For fetching all countries
    public function getCounties()
    {
        $countries= DB::table("countries")->get();
        return view('index')->with('countries',$countries);
    }

    //For fetching cities
    public function getCities(Request $request)
    {

        $cities = city::where('country_id', $request->country_id)->get();

        return view('admin.subscribers.get_cities',compact('cities'));

    }

    public function getBranches(Request $request)
    {
        dd($request->Cmp_No);
        $branches = MainBranch::where('Cmp_No', $request->Cmp_No)->get();

        return view('admin.subscribers.get_branches', compact('branches'));
    }


}
