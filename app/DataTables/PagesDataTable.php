<?php

namespace App\DataTables;
use Illuminate\Http\Request;
use App\Models\Page;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;
use Auth;

class PagesDataTable extends DataTable
{   
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)->addIndexColumn()

            ->editColumn('title', static function (Page $page) {
                return $page->title;
            })

            ->editColumn('content', static function (Page $page) {
                return Str::limit($page->content, 60);
            })     

            ->editColumn('action', static function (Page $page) {
                return '<a href="'.route('page.edit', $page->id).'" class="btn btn-sm bg-info-light"><i class="fa fa-eye"></i></a><a href="#" class="btn btn-sm bg-danger-light deletePage" data-id="'.$page->id.'"><i class="fa fa-trash"></i></a>';
            })                 
           
            ->setRowId(function ($page) {
                return 'payment-'.$page->id;
            })
            ->rawColumns(['action','content']);
    }
   
    public function query(Request $request, Page $page)
    {        
        return Page::query();
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
            Column::make('title')->searchable(true)->orderable(true),        
            Column::make('content')->searchable(false)->orderable(true),            
            Column::make('action')->searchable(false)->orderable(false),    
        ];
    }
}
