<?php

namespace App\DataTables;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Auth;

class ManagePaymentsDataTable extends DataTable
{   
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)->addIndexColumn()
            ->setRowClass(function ($order) {
                    return '';
            })

            ->addColumn('id', static function (Order $order) {
                return $order->id;
            })

            ->addColumn('customer_id', static function (Order $order) {
                return $order->customer_id;
            })

            ->addColumn('buyer', static function (Order $order) {                
                return $order->user_id;
            })->filterColumn('name', function($query, $keyword) {
                $sql = "CONCAT(Orders.ordert_name,'-',users.last_name)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })

            ->addColumn('seller', static function (Order $order) {
                return $order->user_id;
            })->filterColumn('email', function($query, $keyword) {
                $sql = "users.email like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })            

            ->addColumn('date', static function (Order $order) {
                return $order->created_at;
            })

            ->addColumn('status', static function (Order $order) {
                return $order->payment_status;
            })

            ->addColumn('action', static function (Order $order) {
                return '                    
                    <a href="'.route('patient-reports', $order->id).'" data-bs-toggle="tooltip" data-bs-placement="top" title="" class="btn-success btn-action" data-bs-original-title="Reports" aria-label="Reports"><i class="fa fa-file-alt"></i></a>
                ';
            })                 
           
            ->setRowId(function ($order) {
                return 'user-'.$order->id;
            })
            ->rawColumns(['action','image']);
    }
   
    public function query(Order $order)
    {
        return Order::orderBy('id', 'DESC')->newQuery();
    }
 
    public function html()
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addTableClass(['table-hover', 'table-bordered', 'table-sm'])
            ->parameters([
                'lengthMenu' => [
                    [ 25, 50, 100, 500],
                    [ '25', '50', '100', '500']
                ],
                // 'dom' => 'Blfrtip',
            ]);
    }
  
    protected function getColumns()
    {
        return [
            // Column::make('checkbox')->title(''),
            Column::make('id')->title('ID'),
            Column::make('customer_id'),        
            Column::make('buyer'),    
            Column::make('seller'),    
            Column::make('status'),    
            Column::make('date'),   
            Column::make('status'),    
            Column::make('action'),    
        ];
    }
}
