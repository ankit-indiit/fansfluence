<?php

namespace App\DataTables;
use Illuminate\Http\Request;
use App\Models\Order;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\User;
use Auth;

class ManagePaymentsDataTable extends DataTable
{   
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)->addIndexColumn()            

            ->editColumn('order_id', static function (Order $order) {
                return $order->order_id;
            })

            ->editColumn('customer_id', static function (Order $order) {
                return $order->customer_id;
            })

            ->editColumn('user_id', static function (Order $order) {                
                return getUserNameById($order->user_id);
            })->filterColumn('user_id', function($query, $keyword) {
                $userIds = User::where('name', 'like', '%' . $keyword  . '%')->pluck('id')->toArray();
                $query->whereIn('user_id', $userIds);
            })

            ->editColumn('seller', static function (Order $order) {
                return getUserNameById($order->orderDetail->influencer_id);
            })->filterColumn('seller', function($query, $keyword) {
                $userIds = User::where('name', 'like', '%' . $keyword  . '%')->pluck('id')->toArray();
                $orderIds = OrderDetail::whereIn('influencer_id', $userIds)->pluck('order_id')->toArray();
                $query->whereIn('id', $orderIds);
            })

            ->editColumn('created_at', static function (Order $order) {
                return $order->created_at;
            })

            ->editColumn('status', static function (Order $order) {
                switch ($order->status) {
                    case 'pending':
                        return '<span class="badge badge-primary">Pending</span>';
                    break;
                    case 'accept':
                        return '<span class="badge badge-success">Accept</span>';
                    break;
                    case 'decline':
                        return '<span class="badge badge-info">Decline</span>';
                    break;
                    case 'completed':
                        return '<span class="badge badge-secondary">Completed</span>';
                    break;
                    case 'delivered':
                        return '<span class="badge badge-warning">Delivered</span>';
                    break;
                }
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
        if (isset($request->start_date) && isset($request->end_date)) {
            return Order::whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)
                ->orderBy('id', 'DESC')
                ->newQuery();
        }
        return Order::query();
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
            Column::make('order_id')->searchable(false)->orderable(true),        
            Column::make('customer_id')->searchable(true)->orderable(true),        
            Column::make('user_id')->title('Buyer')->searchable(true)->orderable(false),    
            Column::make('seller')->searchable(false)->orderable(false),    
            Column::make('status'),    
            Column::make('created_at')->title('Date')->searchable(false)->orderable(true),   
            Column::make('action')->searchable(false)->orderable(false),    
        ];
    }
}
