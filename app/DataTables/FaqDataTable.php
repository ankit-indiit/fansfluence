<?php

namespace App\DataTables;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\FaqQues;
use Auth;

class FaqDataTable extends DataTable
{   
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)->addIndexColumn()

            ->editColumn('user', static function (FaqQues $faqQues) {
                return ucfirst($faqQues->user);
            })    
          
            ->editColumn('question', static function (FaqQues $faqQues) {
                return $faqQues->question;
            })            

            ->editColumn('action', static function (FaqQues $faqQues) {
                return '<a href="'.route('faq.edit', $faqQues->id).'" class="btn btn-sm bg-info-light"><i class="far fa-edit mr-1"></i></a><a href="#" class="btn btn-sm bg-danger-light" id="deleteFaq" data-id="'.$faqQues->id.'"><i class="fa fa-trash"></i></a>
                ';
            })                 
           
            ->setRowId(function ($faqQues) {
                return 'payment-'.$faqQues->id;
            })
            ->rawColumns(['action']);
    }
   
    public function query(Request $request, FaqQues $faqQues)
    {        
        return FaqQues::query();
    }
 
    public function html()
    {
        return $this->builder()
            ->setTableId('payment-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addTableClass(['table-hover', 'table-bordered', 'table-md'])
            ->parameters([
                'lengthMenu' => [
                    [ 25, 50, 100, 500],
                    [ '25', '50', '100', '500']
                ],
                // 'dom' => 'Blfrtip',
            ])->orderBy(2);
    }
  
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('Sr. no.')->searchable(false)->orderable(false),
            Column::make('user')->searchable(true)->orderable(true),           
            Column::make('question')->searchable(true)->orderable(true),                                  
            Column::make('action')->searchable(false)->orderable(false),    
        ];
    }
}
