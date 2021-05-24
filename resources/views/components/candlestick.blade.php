@extends('layouts.page')

@section('title', 'Pares de Ativos')

@section('content_header')
    <h1>Gráfico - Par de Ativos</h1>
@stop

@section('css')

@stop

@section('js')

@stop

@section('content')

<div class="row">
  <div class="col-12">
    <!-- interactive chart -->
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">
          <i class="far fa-chart-bar"></i>
          Gráfico do par de Ativos
        </h3>
      </div>
      <div class="card-body">
        <div id="app">
          <example-component></example-component>
        </div>
        <div id="chart"></div>
      </div>
      <!-- /.card-body-->
    </div>
    <!-- /.card -->

  </div>
  <!-- /.col -->
</div>
<!-- /.row -->



<div class="row">
  <div class="col-md-8">
    <!-- Line chart -->
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">
          <i class="far fa-chart-bar"></i>
          Métricas
        </h3>
      </div>
      <div class="card-body">

        @include('bancario::components.metrics', [
            'metrics' => $entity->getMetrics()
          ])
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
          Parametros do Gráfico
        </h3>
      </div>
      <div class="card-body">
        @include('pedreiro::form')
      </div>
      <!-- /.card-body-->
    </div>
    <!-- /.card -->

  </div>
  <!-- /.col -->
</div>
<!-- /.row -->


<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
        var options = {
          series: [{
          data: [
            @foreach($tickets as $tick)
                @if($loop->first)
                    {!! $tick !!}
                @else
                    , {!! $tick !!}
                @endif
            @endforeach
          ]
        }],
          chart: {
          type: 'candlestick',
          height: 350
        },
        title: {
          text: '{!! (string) $entity !!}',
          align: 'left'
        },
        xaxis: {
          type: 'datetime'
        },
        yaxis: {
          tooltip: {
            enabled: true
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
      
      </script>
  @endsection