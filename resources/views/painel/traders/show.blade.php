@extends('layouts.page')

@section('title', 'Trader - '.$trader->name)

@section('css')

@stop

@section('js')

@stop

@section('content')

    @if(session()->get('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}  
      </div><br />
    @endif
    

    <div class="row">

        <div class="col-lg-1 margin-tb">

            <div class="pull-right">

                <a class="btn btn-primary" href="{{ route('painel.bancario.traders.index') }}"> Voltar</a>

            </div>

        </div>
        <div class="col-lg-1 margin-tb">
                <a class="btn btn-primary" href="{{ route('painel.bancario.traders.edit', $trader->id) }}"> Editar</a>
        </div>
        <div class="col-lg-1 margin-tb">
                @if ($trader->is_backtest)
                    <form action="{{ route('painel.bancario.traders.destroy', $trader->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Deletar</button>
                    </form>
                @endif
        </div>
        <div class="col-lg-9 margin-tb">
        
        </div>
    </div>



    <div class="row">
  <div class="col-md-8">
    <!-- Line chart -->
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">
          <i class="far fa-chart-bar"></i>
          Ativos
        </h3>
      </div>
      <div class="card-body">

      </div>
      <!-- /.card-body-->
    </div>
    <!-- /.card -->

  </div>
  <div class="col-md-4">
    <!-- Line chart -->
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">
          <i class="far fa-chart-bar"></i>
          Saldo
        </h3>
      </div>
      <div class="card-body">
        @include('bancario::components.assets', [
            'assets' => $trader->assets
          ])
      </div>
      <!-- /.card-body-->
    </div>
    <!-- /.card -->

  </div>
  <!-- /.col -->
</div>
<!-- /.row -->


    <div class="row">

        <div class="col-xs-8 col-sm-8 col-md-8">
          <div class="box box-solid card card-solid">
              <div class="box-header card-header with-border">
                  <h3 class="box-title card-title">
                      Operações
                  </h3>
              </div>
              <!-- /.box-header card-header -->
              <div class="box-body card-body">
                  @include('bancario::painel.traders.partials.orders', ['orders' => $trader->orders])
              </div>
              <!-- /.box-body card-body -->
          </div>
        </div>



        <div class="col-xs-4 col-sm-4 col-md-4">
          <div class="box box-solid card card-solid">
              <div class="box-header card-header with-border">
                  <h3 class="box-title card-title">
                      Investimento
                  </h3>
              </div>
              <!-- /.box-header card-header -->
              <div class="box-body card-body">
                  @include('bancario::painel.traders.partials.investiments', ['assets' => $trader->assets, 'investiments' => $trader->investiments()])
              </div>
              <!-- /.box-body card-body -->
          </div>
          <div class="box box-solid card card-solid">
              <div class="box-header card-header with-border">
                  <h3 class="box-title card-title">
                      Histórico do Saldo
                  </h3>
              </div>
              <!-- /.box-header card-header -->
              <div class="box-body card-body">
                  @include('bancario::painel.traders.partials.histories', ['histories' => $trader->histories])
              </div>
              <!-- /.box-body card-body -->
          </div>
        </div>
    </div>
    

@endsection