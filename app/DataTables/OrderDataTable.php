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
use App\Models\Order;
use Auth;

class OrderDataTable extends DataTable
{   
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)->addIndexColumn()
            
            ->editColumn('order_id', static function (Order $order) {
                return $order->order_id;
            })

            ->editColumn('product', static function (Order $order) {
                return $order->product .' '. $order->mark;
            })
          
            ->editColumn('status', static function (Order $order) {
                // $tab = '';
                switch ($order->status) {
                    case 'pending':
                        $tab = 'primary';
                    break;
                    case 'accept':
                        $tab = 'secondary';
                    break;
                    case 'decline':
                        $tab = 'danger';
                    break;
                    case 'completed':
                        $tab = 'success';
                    break;  
                    case 'delivered':
                        $tab = 'info';
                    break;     
                }
                return '<span class="badge badge-'.$tab.'">'.ucfirst($order->status).'</span>';
            })

            ->editColumn('user_id', static function (Order $order) {
                return getUserNameById($order->user_id);
            })

            ->editColumn('created_at', static function (Order $order) {
                return $order->created_at;
            })

            ->editColumn('action', static function (Order $order) {
                return '<a href="'.route('order.show', $order->id).'" class="btn btn-sm bg-info-light"><i class="fa fa-eye"></i></a>';
            })                 
           
            ->setRowId(function ($order) {
                return 'payment-'.$order->id;
            })
            ->rawColumns(['action','status']);
    }
   
    public function query(Request $request, Order $order)
    {
        return Order::where('id', '!=', '')->newQuery();
    }
 
    public function html()
    {
        return $this->builder()
            ->setTableId('order-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addTableClass(['table-hover', 'table-bordered', 'table-md'])
            ->parameters([
                'lengthMenu' => [
                    [ 25, 50, 100, 500],
                    [ '25', '50', '100', '500']
                ],                
                // 'dom' => 'Blfrtip',
            ])->orderBy(4);
    }
  
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('Sr. no.')->searchable(false)->orderable(false),
            // Column::make('order_id')->searchable(false)->orderable(false),
            Column::make('product')->title('Name')->searchable(true)->orderable(true),           
            Column::make('status')->orderable(false),            
            Column::make('user_id')->title('User')->orderable(true),            
            Column::make('created_at')->title('Date')->orderable(true),            
            Column::make('action')->searchable(false)->orderable(false),    
        ];
    }
}
