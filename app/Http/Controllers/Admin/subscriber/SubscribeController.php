<?php

namespace App\Http\Controllers\Admin\subscriber;

use App\activity_type;
use App\Branches;
use App\city;

use App\country;
use App\DataTables\subcriberDataTable;
use App\Department;
use App\employee;
use App\Http\Controllers\Admin\Country\CountryController;
use App\Models\Admin\Astsupctg;
use App\Models\Admin\AstSalesman;
use App\Models\Admin\MtsChartAc;
use App\Models\Admin\MainCompany;
use App\Models\Admin\AstMarket;
use App\Models\Admin\MTsCustomer;
use App\Models\Admin\MainBranch;
use App\Models\Admin\ActivityTypes;

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
use niklasravnsborg\LaravelPdf\Facades\Pdf;
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
      //  $countries = country::pluck('country_name_'.session('lang'),'id');
        $astsupctg = Astsupctg::pluck('Supctg_Nm'.session('lang'),'ID_No');
        $branches = MainBranch::pluck('Brn_Nm'.ucfirst(session('lang')),'ID_No');
        $activities= ActivityTypes::pluck('Name_'.ucfirst(session('lang')),'ID_No')->toArray();
        //$companies = MainCompany::pluck('Cmp_Nm'.ucfirst(session('lang')),'ID_No')->toArray();
        $countries = country::pluck('country_name_ar','id');

        // return view('admin.subscribers.create1',
        //             ['title'=>trans('admin.create_new_subscriber'),'states'=>$states,'branches'=>$branches,'departments'=>$departments,'countries'=>$countries,'cities'=>$cities,'employees'=>$employees,'activity_type'=>$activity_type,'glccs'=>$glccs]);

        $br = MainBranch::orderBy('ID_No', 'DESC')->first()->ID_No;
        $subscriber = MTsCustomer::get();
        return view('admin.subscribers.create1', compact('subscriber'),['astsupctg' => $astsupctg,'countries' => $countries,'branches' => $branches, 'activities'=>$activities, 'br'=>$br]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,subscription $subscription)
    {

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
        $sub->Cstm_No = $request->Cstm_No;
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
        $countries = country::pluck('country_name_'.session('lang'),'id');
        $astsupctg = Astsupctg::pluck('Supctg_Nm'.session('lang'),'ID_No');
        $branches = Branches::pluck('name_'.session('lang'),'id');
        $activities= ActivityTypes::pluck('Name_'.ucfirst(session('lang')),'ID_No')->toArray();
        $companies = MainCompany::pluck('Cmp_Nm'.ucfirst(session('lang')),'ID_No')->toArray();
        return view('admin.subscribers.show1',compact('subscriber'),['astsupctg' => $astsupctg,'companies' => $companies,'countries' => $countries,'branches' => $branches, 'activities'=>$activities]);
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
        $countries = country::pluck('country_name_'.session('lang'),'id');
        $astsupctg = Astsupctg::pluck('Supctg_Nm'.session('lang'),'ID_No');
        $branches = Branches::pluck('name_'.session('lang'),'id');
        $activities= ActivityTypes::pluck('Name_'.ucfirst(session('lang')),'ID_No')->toArray();
        $companies = MainCompany::pluck('Cmp_Nm'.ucfirst(session('lang')),'ID_No')->toArray();

        return view('admin.subscribers.edit1',compact('subscriber'),['astsupctg' => $astsupctg,'companies' => $companies,'countries' => $countries,'branches' => $branches, 'activities'=>$activities]);
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
    public function customer_report()
    {
        $mainCompany = MainCompany::pluck('Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No');

        return view('admin.basic_reports.customer.customer_report',compact('mainCompany'));
    }
    public function get_mainbranches(Request $request)
    {

        if($request->ajax())
        {
           $mainCompany =  $request->mainCompany;
            $MainBranch = MainBranch::where('Cmp_No',$mainCompany)->pluck('Brn_Nm'.ucfirst(session('lang')), 'Brn_No');

        return view('admin.basic_reports.customer.ajax.get_mainbranches',compact('MainBranch'));
        }

    }
    public function cust_report_form(Request $request)
    {
        if($request->ajax())
        {
            $myradio = $request->myradio;


            if($request->myradio == 1) {
            $mainCompany = MainCompany::pluck('Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No');
            return view('admin.basic_reports.customer.ajax.cust_report_form', ['mainCompany' => $mainCompany,'myradio' => $myradio]);
            }else if($request->myradio == 2)
        {
            $MainBranch = MainBranch::pluck('Brn_Nm'.ucfirst(session('lang')), 'Brn_No');
            return view('admin.basic_reports.customer.ajax.cust_report_form', ['MainBranch' => $MainBranch,'myradio' => $myradio]);

        }
            else if($request->myradio == 3)
        {
            $AstSalesman = AstSalesman::pluck('Slm_Nm'.ucfirst(session('lang')), 'Slm_No');
            return view('admin.basic_reports.customer.ajax.cust_report_form', ['AstSalesman' => $AstSalesman,'myradio' => $myradio]);

        }
            else if($request->myradio == 4)
        {
            $ActivityTypes = ActivityTypes::pluck('Name_'.ucfirst(session('lang')), 'Actvty_No');
            return view('admin.basic_reports.customer.ajax.cust_report_form', ['ActivityTypes' => $ActivityTypes,'myradio' => $myradio]);

        }
            else if($request->myradio == 5)
        {
            $Astsupctg = Astsupctg::pluck('Supctg_Nm'.ucfirst(session('lang')), 'Supctg_No');
            return view('admin.basic_reports.customer.ajax.cust_report_form', ['Astsupctg' => $Astsupctg,'myradio' => $myradio]);

        }
            else if($request->myradio ==6 )
        {
            $country = country::pluck('country_name_'.ucfirst(session('lang')), 'id');
            return view('admin.basic_reports.customer.ajax.cust_report_form', ['country' => $country,'myradio' => $myradio]);

        }
            else if($request->myradio == 7 )
        {
            $city = city::pluck('city_name_'.ucfirst(session('lang')), 'id');
            return view('admin.basic_reports.customer.ajax.cust_report_form', ['city' => $city,'myradio' => $myradio]);

        }
            else if($request->myradio == 9 )
        {
            $MtsChartAc = MtsChartAc::where('Acc_Typ',4)->pluck('Acc_Nm'.ucfirst(session('lang')), 'Cmp_No');
            return view('admin.basic_reports.customer.ajax.cust_report_form', ['MtsChartAc' => $MtsChartAc,'myradio' => $myradio]);

        }
            else if($request->myradio == 10 )
        {
            $AstMarket = AstMarket::pluck('Mrkt_Nm'.ucfirst(session('lang')), 'Mrkt_No');
            return view('admin.basic_reports.customer.ajax.cust_report_form', ['AstMarket' => $AstMarket,'myradio' => $myradio]);

        }
        }

    }
//    public function cust_report_select(Request $request)
//    {
//        if($request->ajax())
//
//        {
//            $name = $request->name;
//            $value = $request->value;
//            if($name == 'company')
//            {
//
//                $MTsCustomer = MTsCustomer::where('Cmp_No',$value)->get();
//                return view('admin.basic_reports.customer.ajax.cust_report_print', ['MTsCustomer' => $MTsCustomer,'value' => $value]);
//
//
//            } if($name == 'MainBranch')
//            {
//
//                $MTsCustomer = MTsCustomer::where('Brn_No',$value)->get();
//                return view('admin.basic_reports.customer.ajax.cust_report_print', ['MTsCustomer' => $MTsCustomer,'value' => $value]);
//
//
//            }if($name == 'AstSalesman')
//            {
//
//                $MTsCustomer = MTsCustomer::where('Slm_No',$value)->get();
//                return view('admin.basic_reports.customer.ajax.cust_report_print', ['MTsCustomer' => $MTsCustomer,'value' => $value]);
//
//
//            }if($name == 'ActivityTypes')
//            {
//
//                $MTsCustomer = MTsCustomer::where('Nutr_No',$value)->get();
//                return view('admin.basic_reports.customer.ajax.cust_report_print', ['MTsCustomer' => $MTsCustomer,'value' => $value]);
//
//
//            }if($name == 'ActivityTypes')
//            {
//
//                $MTsCustomer = MTsCustomer::where('Cstm_Ctg',$value)->get();
//                return view('admin.basic_reports.customer.ajax.cust_report_print', ['MTsCustomer' => $MTsCustomer,'value' => $value]);
//
//
//            }if($name == 'country')
//            {
//
//                $MTsCustomer = MTsCustomer::where('Cntry_No',$value)->get();
//                return view('admin.basic_reports.customer.ajax.cust_report_print', ['MTsCustomer' => $MTsCustomer,'value' => $value]);
//
//
//            }if($name == 'city')
//            {
//
//                $MTsCustomer = MTsCustomer::where('City_No',$value)->get();
//                return view('admin.basic_reports.customer.ajax.cust_report_print', ['MTsCustomer' => $MTsCustomer,'value' => $value]);
//
//
//            }if($name == 'MtsChartAc')
//            {
//
//                $MTsCustomer = MTsCustomer::where('Acc_No',$value)->get();
//                return view('admin.basic_reports.customer.ajax.cust_report_print', ['MTsCustomer' => $MTsCustomer,'value' => $value]);
//
//
//            }if($name == 'AstMarket')
//            {
//
//                $MTsCustomer = MTsCustomer::where('Mrkt_No',$value)->get();
//                return view('admin.basic_reports.customer.ajax.cust_report_print', ['MTsCustomer' => $MTsCustomer,'value' => $value]);
//
//
//            }
//
//        }
//    }
//    public function cust_report_pdf(Request $request)
//    {
//
//        $name = $request->name;
//        $value = $request->value;
//        $MTsCustomer = MTsCustomer::where('Cmp_No',$value)->get();
//
//        $config = ['instanceConfigurator' => function($mpdf) {
//            $mpdf->SetHTMLFooter('
//                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
//                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
//            );
//        }];
//        $pdf = Pdf::loadView('admin.basic_reports.customer.pdf.cust', compact('MTsCustomer'),[], $config);
//        return $pdf->stream();
//    }

    public function cust_report_select(Request $request)
    {
        if($request->ajax())

        {
            $name = $request->name;
            $value = $request->value;

            return view('admin.basic_reports.customer.ajax.cust_report_print', ['name' => $name,'value' => $value]);

        }
    }
    public function cust_report_pdf(Request $request)
    {



            $name = $request->name;
            $value = $request->value;
            if($name == 'company')
            {

                $MTsCustomer = MTsCustomer::where('Cmp_No',$value)->get();

            } if($name == 'MainBranch')
            {

                $MTsCustomer = MTsCustomer::where('Brn_No',$value)->get();//
//
            }if($name == 'AstSalesman')
            {

                $MTsCustomer = MTsCustomer::where('Slm_No',$value)->get();


            }if($name == 'ActivityTypes')
            {
                $MTsCustomer = MTsCustomer::where('Nutr_No',$value)->get();
            }if($name == 'ActivityTypes')
            {
                $MTsCustomer = MTsCustomer::where('Cstm_Ctg',$value)->get();


            }if($name == 'country')
            {
                $MTsCustomer = MTsCustomer::where('Cntry_No',$value)->get();


            }if($name == 'city')
            {
                $MTsCustomer = MTsCustomer::where('City_No',$value)->get();

            }if($name == 'MtsChartAc')
            {

                $MTsCustomer = MTsCustomer::where('Acc_No',$value)->get();


            }if($name == 'AstMarket')
            {
                $MTsCustomer = MTsCustomer::where('Mrkt_No',$value)->get();
            }


        $config = ['instanceConfigurator' => function($mpdf) {
            $mpdf->SetHTMLFooter('
                    <div style="font-size:10px;width:25%;float:right">Print Date: {DATE j-m-Y H:m}</div>
                    <div style="font-size:10px;width:25%;float:left;direction:ltr;text-align:left">Page {PAGENO} of {nbpg}</div>'
            );
        }];
        $pdf = Pdf::loadView('admin.basic_reports.customer.pdf.cust', compact('MTsCustomer'),[], $config);
        return $pdf->stream();
    }

    //For fetching cities
    public function getCities(Request $request)
    {
        $cities = city::where('country_id', $request->country_id)->get();

        return view('admin.subscribers.get_cities',compact('cities'));

    }

    public function getBranches(Request $request)
    {
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
