<?php

namespace App\DataTables;

use App\Branches;
use App\Enums\GenderType;
use App\Enums\PayType;
use App\Enums\TypeType;
use App\subscription;
use App\Models\Admin\MTsCustomer;
use Yajra\DataTables\Services\DataTable;

class subcriberDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('edit', function ($query) {
                return '<a  href="subscribers/'.$query->ID_No.'/edit" class="btn btn-success edit"><i class="fa fa-edit"></i>' . trans('admin.edit') .'</a>';
            })
            ->addColumn('branches', function ($query) {
                return session_lang($query->branches['name_en'],$query->branches['name_ar']);
            })
//            ->addColumn('departs', function ($query) {
//                    return session_lang($query->departs['state_name_en'],$query->departs['state_name_ar']);
//            })
//            ->addColumn('desnames', function ($query) {
//                    return session_lang($query->desnames['state_name_en'],$query->desnames['state_name_ar']);
//            })
            ->addColumn('details', function ($query) {
                return '<a href="subscribers/'.$query->ID_No.'" class="btn btn-primary"><i class="fa fa-info"></i> ' . trans('admin.information_details') .' </a>';
            })
//            ->addColumn('cart', function ($query) {
//                if(subscription::where('id',$query->id)->first()->status == 1) {
//                    return '<a href = "cart/'.$query->id.'" class="btn btn-info remove-record" ><i class="fa fa-credit-card" ></i > ' . trans('admin.receipt') . '</a>';
//                }elseif (subscription::where('id',$query->id)->first()->status == 0) {
//                    return '<a href = "cart/'.$query->id.'" class="btn btn-success remove-record" ><i class="fa fa-shopping-cart" ></i > ' . trans('admin.issuance_receipts') . ' </a >';
//                }
//            })

            ->addColumn('delete', 'admin.subscribers.btn.delete')
            ->addColumn('status', 'admin.subscribers.status')
            ->addColumn('type', function ($query) {
                return TypeType::getDescription($query->type);
            })
//            ->addColumn('pay_status', function ($query) {
//                if (PayType::getDescription($query->pay_status) == 'complete' || PayType::getDescription($query->pay_status) == 'كامل'){
//                return '<div class="badge" style="background-color: #27ae60">'.PayType::getDescription($query->pay_status).'</div>';
//                }else{
//                    return '<div class="badge" style="background-color: #c0392b">'.PayType::getDescription($query->pay_status).'</div>';
//                }
//            })
            ->addColumn('gender',  function ($query) {
                return GenderType::getDescription($query->gender);
            })
            ->rawColumns([
                'edit',
                'delete',
                'details',
//                'cart',
                'parent',
                'parent_phone',
//                'pay_status',
                'branches',
            ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
            return MTsCustomer::query()->orderByDesc('ID_No');


        // if (auth()->guard('admin')->user()->branches_id == $branches->first()->id){
        // }else{
        //     return MTsCustomer::query()->orderByDesc('id')->where('branches_id','=',auth()->guard('admin')->user()->branches_id);
        // }
    }
    public static function lang(){
        $langJson = [
            "sProcessing"=> trans('admin.sProcessing'),
            "sZeroRecords"=> trans('admin.sZeroRecords'),
            "sEmptyTable"=> trans('admin.sEmptyTable'),
            "sInfoFiltered"=> trans('admin.sInfoFiltered'),
            "sSearch"=> trans('admin.sSearch'),
            "sUrl"=> trans('admin.sUrl'),
            "sInfoThousands"=> trans('admin.sInfoThousands'),
            "sLoadingRecords"=> trans('admin.sLoadingRecords'),
            "oPaginate"=> [
                "sFirst"=> trans('admin.sFirst'),
                "sLast"=> trans('admin.sLast'),
                "sNext"=> trans('admin.sNext'),
                "sPrevious"=> trans('admin.sPrevious')
            ],
            "oAria"=> [
                "sSortAscending"=> trans('admin.sSortAscending'),
                "sSortDescending"=> trans('admin.sSortDescending')
            ]
        ];
        return $langJson;
    }
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {

        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'dom' => 'Blfrtip',
                'lengthMenu' => [
                    [5,10,25,50,100,-1],[5,10,25,50,trans('admin.all_record')]
                ],
                'buttons' => [
                    [
                        'text' => '<i class="fa fa-plus"></i> ' . trans('admin.Add_New_Subscriber'),
                        'className' => 'btn btn-primary create',
                        'action' => 'function( e, dt, button, config){
                             window.location = "subscribers/create";
                         }',
                    ],[
                        'text' => '<i class="fa fa-flag"></i> ' . trans('admin.relatedness'),
                        'className' => 'btn btn-primary',
                        'action' => 'function( e, dt, button, config){
                             window.location = "relatedness";
                         }',
                    ],
                    ['extend' => 'print','className' => 'btn btn-primary' , 'text' => '<i class="fa fa-print"></i>'],
                    ['extend' => 'excel','className' => 'btn btn-success' , 'text' => '<i class="fa fa-file"></i> ' . trans('admin.EXCEL')],
                    ['extend' => 'reload','className' => 'btn btn-info' , 'text' => '<i class="fa fa-refresh"></i>']
                ],
                "language" =>  self::lang(),

            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['name'=>'ID_No','data'=>'ID_No','title'=>trans('admin.id')],
            ['name'=>'Cstm_Nm'.ucfirst(session('lang')),'data'=>'Cstm_Nm'.ucfirst(session('lang')),'title'=>trans('admin.name')],
            ['name'=>'Brn_No','data'=>'Brn_No','title'=>trans('admin.Branches')],
            ['name'=>'Cmp_No','data'=>'company.Cmp_Nm'.ucfirst(session('lang')),'title'=>trans('admin.company')],
            ['name'=>'Cstm_No','data'=>'Cstm_No','title'=>trans('admin.subscriber_no')],
            ['name'=>'Cstm_Active','data'=>'Cstm_Active','title'=>trans('admin.active')],
            ['name'=>'Cstm_Ctg','data'=>'Cstm_Ctg','title'=>trans('admin.customer_catg')],
            ['name'=>'Cstm_Refno','data'=>'Cstm_Refno','title'=>trans('admin.customer_Ref_no')],
            ['name'=>'Internal_Invoice','data'=>'Internal_Invoice','title'=>trans('admin.Internal_Invoice')],
            ['name'=>'Acc_No','data'=>'Acc_No','title'=>trans('admin.account_number')],
            ['name'=>'Catg_No','data'=>'Catg_No','title'=>trans('admin.classification_by_dealing')],
            ['name'=>'Slm_No','data'=>'Slm_No','title'=>trans('admin.slm_no')],
            ['name'=>'Mrkt_No','data'=>'Mrkt_No','title'=>trans('admin.mrkt_no')],
            ['name'=>'Nutr_No','data'=>'Nutr_No','title'=>trans('admin.Nutr_No')],
            ['name'=>'Cntry_No','data'=>'country.country_name_'.session('lang'),'title'=>trans('admin.country')],
            ['name'=>'City_No','data'=>'City_No','title'=>trans('admin.city')],
            ['name'=>'Area_No','data'=>'Area_No','title'=>trans('admin.area')],
            ['name'=>'Credit_Value','data'=>'Credit_Value','title'=>trans('admin.credit_value')],
            ['name'=>'Credit_Days','data'=>'Credit_Days','title'=>trans('admin.credit_days')],
            ['name'=>'Cstm_Adr','data'=>'Cstm_Adr','title'=>trans('admin.address')],
            ['name'=>'Cstm_POBox','data'=>'Cstm_POBox','title'=>trans('admin.mail_box')],
            ['name'=>'Cstm_ZipCode','data'=>'Cstm_ZipCode','title'=>trans('admin.mail_area')],
            ['name'=>'Cstm_Rsp','data'=>'Cstm_Rsp','title'=>trans('admin.person_rsp')],
            ['name'=>'Cstm_Othr','data'=>'Cstm_Othr','title'=>trans('admin.other_note')],
            ['name'=>'Cstm_Email','data'=>'Cstm_Email','title'=>trans('admin.email')],
            ['name'=>'Cstm_Tel','data'=>'Cstm_Tel','title'=>trans('admin.tel')],
            ['name'=>'Cstm_Fax','data'=>'Cstm_Fax','title'=>trans('admin.fax')],
            ['name'=>'Cntct_Prsn1','data'=>'Cntct_Prsn1','title'=>trans('admin.person_dep_1')],
            ['name'=>'Cntct_Prsn2','data'=>'Cntct_Prsn2','title'=>trans('admin.person_dep_1')],
            ['name'=>'Cntct_Prsn3','data'=>'Cntct_Prsn3','title'=>trans('admin.person_dep_1')],
            ['name'=>'Cntct_Prsn4','data'=>'Cntct_Prsn4','title'=>trans('admin.person_dep_1')],
            ['name'=>'Cntct_Prsn5','data'=>'Cntct_Prsn5','title'=>trans('admin.person_dep_1')],
            ['name'=>'TitL1','data'=>'TitL1','title'=>trans('admin.Title_1')],
            ['name'=>'TitL2','data'=>'TitL2','title'=>trans('admin.Title_1')],
            ['name'=>'TitL3','data'=>'TitL3','title'=>trans('admin.Title_1')],
            ['name'=>'TitL4','data'=>'TitL4','title'=>trans('admin.Title_1')],
            ['name'=>'TitL5','data'=>'TitL5','title'=>trans('admin.Title_1')],
            ['name'=>'Mobile1','data'=>'Mobile1','title'=>trans('admin.mobile_1')],
            ['name'=>'Mobile2','data'=>'Mobile2','title'=>trans('admin.mobile_1')],
            ['name'=>'Mobile3','data'=>'Mobile3','title'=>trans('admin.mobile_1')],
            ['name'=>'Mobile4','data'=>'Mobile4','title'=>trans('admin.mobile_1')],
            ['name'=>'Mobile5','data'=>'Mobile5','title'=>trans('admin.mobile_1')],
            ['name'=>'Email1','data'=>'Email1','title'=>trans('admin.email_1')],
            ['name'=>'Email2','data'=>'Email2','title'=>trans('admin.email_1')],
            ['name'=>'Email3','data'=>'Email3','title'=>trans('admin.email_1')],
            ['name'=>'Email4','data'=>'Email4','title'=>trans('admin.email_1')],
            ['name'=>'Email5','data'=>'Email5','title'=>trans('admin.email_1')],
            ['name'=>'Tel1','data'=>'Tel1','title'=>trans('admin.tel_1')],
            ['name'=>'Tel2','data'=>'Tel2','title'=>trans('admin.tel_2')],
            ['name'=>'Tel3','data'=>'Tel3','title'=>trans('admin.tel_3')],
            ['name'=>'Mobile','data'=>'Mobile','title'=>trans('admin.main_mobile')],
            ['name'=>'Fbal_Db','data'=>'Fbal_Db','title'=>trans('admin.Fbal_Db')],
            ['name'=>'Fbal_CR','data'=>'Fbal_CR','title'=>trans('admin.Fbal_CR')],


            ['name'=>'Opn_Date','data'=>'Opn_Date','title'=>trans('admin.Opn_Date')],
            ['name'=>'Opn_Time','data'=>'Opn_Time','title'=>trans('admin.Opn_Time')],
            ['name'=>'User_ID','data'=>'User_ID','title'=>trans('admin.User_ID')],
            ['name'=>'Updt_Date','data'=>'Updt_Date','title'=>trans('admin.Updt_Date')],
            ['name'=>'Cstm_Agrmnt','data'=>'Cstm_Agrmnt','title'=>trans('admin.Cstm_Agrmnt')],
            ['name'=>'Disc_prct','data'=>'Disc_prct','title'=>trans('admin.Disc_prct')],
            ['name'=>'Itm_Sal','data'=>'Itm_Sal','title'=>trans('admin.Itm_Sal')],
            ['name'=>'Linv_No','data'=>'Linv_No','title'=>trans('admin.Linv_No')],
            ['name'=>'Linv_Dt','data'=>'Linv_Dt','title'=>trans('admin.Linv_Dt')],
            ['name'=>'Linv_Net','data'=>'Linv_Net','title'=>trans('admin.Linv_Net')],
            ['name'=>'LRcpt_No','data'=>'LRcpt_No','title'=>trans('admin.LRcpt_No')],
            ['name'=>'LRcpt_Dt','data'=>'LRcpt_Dt','title'=>trans('admin.LRcpt_Dt')],
            ['name'=>'LRcpt_Db','data'=>'LRcpt_Db','title'=>trans('admin.LRcpt_Db')],
            ['name'=>'LRcpt_Dt','data'=>'LRcpt_Dt','title'=>trans('admin.LRcpt_Dt')],
            ['name'=>'Tax_No','data'=>'Tax_No','title'=>trans('admin.Tax_No')],
            ['name'=>'Notes','data'=>'Notes','title'=>trans('admin.Notes')],

            ['name'=>'created_at','data'=>'created_at','title'=>trans('admin.created_at')],
            ['name'=>'updated_at','data'=>'updated_at','title'=>trans('admin.updated_at')],
            ['name'=>'details','data'=>'details','title'=>trans('admin.details'),'printable'=>false,'exportable'=>false,'orderable'=>false,'searchable'=>false],
            ['name'=>'edit','data'=>'edit','title'=>trans('admin.edit'),'printable'=>false,'exportable'=>false,'orderable'=>false,'searchable'=>false],
            ['name'=>'delete','data'=>'delete','title'=>trans('admin.delete'),'printable'=>false,'exportable'=>false,'orderable'=>false,'searchable'=>false],

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'subscriber_' . date('YmdHis');
    }
}
