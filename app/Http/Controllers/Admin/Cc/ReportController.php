<?php

namespace App\Http\Controllers\Admin\Cc;

use App\glcc;
use App\levels;
use App\limitations;
use App\limitationsType;
use App\pjitmmsfl;
use App\receipts;
use App\receiptsType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class ReportController extends Controller
{
    public function motioncc(){
        $title = trans('admin.motion_detection_center_cost');
        $glcc = glcc::where('type','1')->pluck('name_'.session('lang'),'id');
        return view('admin.cc.reports.index',compact('title','glcc'));
    }
    public function show(Request $request){
        if($request->ajax()) {
            $glcc = $request->glcc;
            $contents = view('admin.cc.reports.show', compact('glcc'))->render();
            return $contents;
        }
    }
    public function details(Request $request){
        $glcc = $request->glcc;
        $from = $request->from;
        $to = $request->to;
        $hasTask = limitations::whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->whereHas('limitations_type',function ($query) use ($glcc){
            $query->where('cc_id',$glcc);
        })->exists();
        $hasTask1 = receipts::whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->whereHas('receipts_type',function ($query) use ($glcc){
            $query->where('cc_id',$glcc);
        })->exists();
        $contents = view('admin.cc.reports.details',compact('glcc', 'from', 'to', 'hasTask', 'hasTask1'))->render();
        return $contents;
    }

    //below this comment edited by Ibrahim El Monier

    public function pdf(Request $request) {
            $glcc = $request->glcc;
            $from = $request->from;
            $to = $request->to;
            $receiptsType = receiptsType::where('cc_id', $glcc)->whereHas('receipts',function ($query) use ($from,$to){
                $query->whereDate('created_at','>=', $from)->whereDate('created_at','<=', $to);
            })->get();
            $limitationsType = limitationsType::where('cc_id', $glcc)->whereHas('limitations',function ($query) use ($from,$to){
                $query->whereDate('created_at','>=', $from)->whereDate('created_at','<=', $to);
            })->get();
            $hastask = limitationsType::where('cc_id', $glcc)->whereHas('limitations',function ($query) use ($from,$to){
                $query->whereDate('created_at','>=', $from)->whereDate('created_at','<=', $to);
            })->exists();
            $hastask2 = receiptsType::where('cc_id', $glcc)->whereHas('receipts',function ($query) use ($from,$to){
                $query->whereDate('created_at','>=', $from)->whereDate('created_at','<=', $to);
            })->exists();
            $value_merged = $limitationsType->toBase()->merge($receiptsType);
            $ccname = glcc::where('id',$glcc)->first()['name_ar'];
            $config = ['instanceConfigurator' => function($mpdf) {
                $mpdf->SetHTMLFooter('
                        <div dir="ltr" style="text-align: right">{DATE j-m-Y H:m}</div>
                        <div dir="ltr" style="text-align: center">{PAGENO} of {nbpg}</div>'
                );
            }];
            $pdf = PDF::loadView('admin.cc.reports.pdf.report', compact('value_merged','hastask','hastask2','from','to','ccname'), [], $config);
            return $pdf->stream('glcc_report.pdf');

    }
    public function checkReports(){
        $title = trans('admin.disclosure_of_balances_of_accounts_of_cost_centers');
        $levels = levels::where('type',2)->pluck('levelId','id');
        return view('admin.cc.checkReports.index',compact('levels','title'));
    }
    public function checkShow(Request $request){
        if($request->ajax()) {
            $level = $request->level;
            $glcc = glcc::where('level_id',$level)->pluck('name_'.session('lang'),'id');
            return view('admin.cc.checkReports.show', compact('level','glcc'));
        }
    }
    public function checkDetails(Request $request){
        if($request->ajax()) {
            $from = $request->from;
            $to = $request->to;
            $fromtree = $request->fromtree;
            $totree = $request->totree;
            if ($from != null && $to != null && $fromtree != null && $totree != null){
                $contents = view('admin.cc.checkReports.details',compact('from','to','fromtree','totree'))->render();
                return $contents;
            }

        }
    }
    public function print(Request $request){
            $from = $request->from;
            $to = $request->to;
            $fromtree = $request->fromtree;
            $totree = $request->totree;
        if ($from != null && $to != null && $fromtree != null && $totree != null){
              $glcc = glcc::where('id','>=',$fromtree)->where('id','<=',$totree)->get();
              $config = ['instanceConfigurator' => function($mpdf) {
                 $mpdf->SetHTMLFooter('
                     <div dir="ltr" style="text-align: right">{DATE j-m-Y H:m}</div>
                     <div dir="ltr" style="text-align: center">{PAGENO} of {nbpg}</div>'
                 );
              }];
              $pdf = PDF::loadView('admin.cc.reports.pdf.pdf', compact('glcc','from','to','fromtree','totree'), [], $config);
              return $pdf->stream('glcc_report.pdf');
            }

    }
}
