@extends('layouts.page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
  @foreach ($trader->exchangeAccounts as $account)
      @include('bancario::trader.numbers', [
          'account' => $account,
      ])
  @endforeach



<div class="row">
    <div class="col-md-8">
        <div class="box card box-info card-info card card-info">
            <div class="box-header card-header with-border">
            <h3 class="box-title">Latest Orders</h3>

            <div class="box-tools card-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
            </div>
            <!-- /.box-header card-header -->
            <div class="box-body card-body">
            <div class="table-responsive">
                    @include('admin.orders.table', ['orders' => $lastsOrders, 'minimo' => true])
            </div>
            <!-- /.table-responsive -->
            </div>
            <!-- /.box-body card-body -->
            <div class="box-footer clearfix">
            {{-- <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a> --}}
            <a href="/orders" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div>
            <!-- /.box-footer -->
        </div>
    </div>

    <div class="col-md-4">
      <!-- LINE CHART -->
      <div class="box card box-info card-info card card-info">
        <div class="box-header card-header with-border">
          <h3 class="box-title">Vendas</h3>

          <div class="box-tools card-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body card-body chart-responsive">
          <div class="chart" id="line-chart" style="height: 300px;"></div>
        </div>
        <!-- /.box-body card-body -->
      </div>
      <!-- /.box -->
    </div>

@stop
</div>