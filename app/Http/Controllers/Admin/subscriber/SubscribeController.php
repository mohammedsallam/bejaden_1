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
        $sub = new MTsCustomer();
        $sub->Cmp_No = $request->Cmp_No;
        //$sub->Cstm_No = $this->createCstmNo($sub->Brn_No);
        $sub->Brn_No = $request->Brn_No;
        $sub->Cstm_Active = $request->Cstm_Active;
        $sub->Cstm_Ctg = $request->Cstm_Ctg;
        $sub->Cstm_Refno = $request->Cstm_Refno;
        $sub->Acc_No = $request->Acc_No;
        $sub->Cstm_NmEn = $request->Cstm_NmEn;
        $sub->Cstm_NmAr = $request->Cstm_NmAr;
        $sub->Catg_No = $request->Catg_No;
        $sub->Slm_No = $request->Slm_No;
        $sub->Mrkt_No = $request->Mrkt_No;
        $sub->Nutr_No = $request->Nutr_No;
        $sub->Cntry_No = $request->Cntry_No;
        $sub->City_No = $request->City_No;
        $sub->Area_No = $request->Area_No;
        $sub->Credit_Value = $request->Credit_Value;
        $sub->Credit_Days = $request->Credit_Days;

        $sub->save();



        return redirect(aurl('subscribers'))->with(session()->flash('message',trans('admin.success_add')));


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($ID_No)
    {
        $subscriber= MTsCustomer::findOrFail($ID_No); //id

//        $subcriber = MTsCustomer::orderBy('ID_No', 'DESC')->latest()->first(); //latest record
//        if($subcriber){
//            MTsCustomer::create([
//                $cstm_No = cstm_No+1
//            ]);
//        }
//        $brn =  $subscriber->Brn_No;
//        //dd($brn);
//        $brn_no =$brn*1000; //1*1000 = 1000
//        $sub = $brn_no . $subscriber->ID_No; //رقم العميل
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
        //dd($request->Cmp_No);
        $branches = MainBranch::where('Cmp_No', $request->Cmp_No)->get();

        return view('admin.subscribers.get_branches', compact('branches'));
    }

    public function createCstmNo(Request $request){
        if($request->ajax()){
            $last_no = 0;
            if(count(MTsCustomer::all()) == 0){
//                return 'first';
                //no records
                $last_no = $request->Brn_No * 10000;
            }else{
                $last_cstm = MTsCustomer::where('Brn_No',  $request->Brn_No)->orderBy('Cstm_No', 'desc')->first();
                if($last_cstm == null){
//                    return 'else first';
                    $last_no = $request->Brn_No * 10000;
                }
                else{
//                    return 'else second';
                    $last_no = $last_cstm->Cstm_No;
                }
            }
            return $last_no + 1;
        }
    }



}
