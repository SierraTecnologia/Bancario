<?php
namespace Bancario\Modules\Logic\DataTables;

use Bancario\Modules\Logic\DataTables\UsersDataTable;
use App\Http\Requests;
use App\Models\Shopping\Order;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class OrdersDataTable extends DataTable
{
    public function query()
    {
        $query = Order::with('user', 'gateway', 'customer', 'credit_card', 'money')->select('orders.*');

        return $this->applyScopes($query);

        //     return Datatables::of($query)->addColumn('action', function ($order) {
        //         return '<a href="'.route('admin.orders.show',$order->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-eye"></i> Show</a>';
        //     })->setRowId('id')->editColumn('created_at', function ($user) {
        //         return $user->updated_at->format('h:m:s d/m/Y');
        //     })
        //     ->setRowClass(function ($order) {
        //         return $order->status == Order::$STATUS_APPROVED ? 'alert-success' : 'alert-warning';
        //     })
        //     ->setRowData([
        //         'id' => 'test',
        //     ])
        //     ->setRowAttr([
        //         'color' => 'red',
        //     ])->make(true);

        //     return $this->dataTable->eloquent($query)->make(true);
    }

    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->make(true);
    }

    public function html()
    {
        return $this->builder()
            ->columns(
                [
                'id',
                'name',
                'email',
                'created_at',
                'updated_at',
                ]
            )
            ->parameters(
                [
                'dom' => 'Bfrtip',
                'buttons' => ['csv', 'excel', 'pdf', 'print', 'reset', 'reload'],
                ]
            );
    }
}