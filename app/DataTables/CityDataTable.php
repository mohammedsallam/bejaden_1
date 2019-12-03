<?php

namespace App\DataTables;

use App\city;
use Yajra\DataTables\Services\DataTable;

class CityDataTable extends DataTable
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
                return '<a href="cities/'.$query->id.'/edit" class="btn btn-success edit"><i class="fa fa-edit"></i> '. trans('admin.edit') .'</a>';
            })
            ->addColumn('delete', 'admin.cities.btn.delete')
            ->rawColumns([
                'edit',
                'delete'
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
        return city::query()->orderByDesc('id')->with('country')->select('cities.*');
    }
    public static function lang(){
        $langJson = [
            "sProcessing"=> trans('admin.sProcessing'),
            "sLengthMenu"=> trans('admin.sLengthMenu'),
            "sZeroRecords"=> trans('admin.sZeroRecords'),
            "sEmptyTable"=> trans('admin.sEmptyTable'),
            "sInfo"=> trans('admin.sInfo'),
            "sInfoFiltered"=> trans('admin.sInfoFiltered'),
            "sInfoPostFix"=> trans('admin.sInfoPostFix'),
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
                    [10,25,50,100,-1],[10,25,50,trans('admin.all_record')]
                ],
                'buttons' => [
                    [
                        'text' => '<i class="fa fa-plus"></i> ' . trans('admin.Add_New_City'),
                        'className' => 'btn btn-primary create',
                        'action' => 'function( e, dt, button, config){ 
                             window.location = "cities/create";
                         }',
                    ],
                    ['extend' => 'print','className' => 'btn btn-primary' , 'text' => '<i class="fa fa-print"></i>'],
                    ['extend' => 'excel','className' => 'btn btn-success' , 'text' => '<i class="fa fa-file"></i> ' . trans('admin.EXCEL')],
                    ['extend' => 'reload','className' => 'btn btn-info' , 'text' => '<i class="fa fa-refresh"></i>']
                ],
                "initComplete" => "function () {
                    this.api().columns([0,1,2]).every(function () {
                        var column = this;
                        var input = document.createElement(\"input\");
                        $(input).appendTo($(column.footer()).empty())
                        .on('keyup', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
        
                            column.search(val ? val : '', true, false).draw();
                        });
                    });
                    }",
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
            ['name'=>'city_name_ar','data'=>'city_name_ar','title'=>trans('admin.arabic_name')],
            ['name'=>'city_name_en','data'=>'city_name_en','title'=>trans('admin.english_name')],
            ['name'=>'country_id','data'=>'country.country_name_'.session('lang'),'title'=>trans('admin.country')],
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
        return 'City_' . date('YmdHis');
    }
}
