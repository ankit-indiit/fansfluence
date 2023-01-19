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
use App\Models\ContactUs;
use Auth;

class ContactUsDataTable extends DataTable
{   
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)->addIndexColumn()

            ->editColumn('name', static function (ContactUs $contactUs) {
                return $contactUs->name;
            })->filterColumn('name', function ($query, $keyword) {
               $query->whereRaw("name like ?", ["%$keyword%"]);
            })
          
            ->editColumn('email', static function (ContactUs $contactUs) {
                return $contactUs->email;
            })

            ->editColumn('reason', static function (ContactUs $contactUs) {
                if ($contactUs->reaching_out_us == 'reason-issue') {
                    return 'I have an issue';
                }
                                                            
                if ($contactUs->reaching_out_us == 'reason-question') {
                    return 'I have a question';
                }
            })

            ->editColumn('date', static function (ContactUs $contactUs) {
                return $contactUs->created_at;
            })

            ->editColumn('action', static function (ContactUs $contactUs) {
                return '<a href="#" class="btn btn-sm bg-info-light contactDesc" data-id="'.$contactUs->id.'" data-toggle="modal" data-target="#contactUsMessage"><i class="far fa-eye mr-1"></i></a>';/*<a href="javascript: void(0)" id="deleteContact" data-id="'.$contactUs->id.'" class="btn btn-sm bg-danger-light delete_review_comment"><i class="far fa-trash-alt"></i></a>;*/
            })                 
           
            ->setRowId(function ($contactUs) {
                return 'payment-'.$contactUs->id;
            })
            ->rawColumns(['action']);
    }
   
    public function query(Request $request, ContactUs $contactUs)
    {
        return ContactUs::query();
    }
 
    public function html()
    {
        return $this->builder()
            // ->setTableId('contact-us-table')
            ->columns($this->getColumns())
            // ->minifiedAjax()
            // ->addTableClass(['table-hover', 'table-bordered', 'table-md'])
            ->parameters([                
                'lengthMenu' => [
                    [ 25, 50, 100, 500],
                    [ '25', '50', '100', '500']
                ],
                'order' => [
                    1, 'desc'
                ]
                // 'dom' => 'Blfrtip',
            ]);
    }
  
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('Sr. no.')->searchable(false)->orderable(false),
            Column::make('name')->orderable(true), 
            Column::make('email')->orderable(true),            
            Column::make('reason')->searchable(false)->orderable(false),            
            Column::make('date')->searchable(false)->orderable(false),            
            Column::make('action')->searchable(false)->orderable(false),    
        ];
    }
}
