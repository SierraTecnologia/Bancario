@if (method_exists($traders,'onEachSide'))
    {{ $traders->onEachSide(10)->links() }}
@endif
<table class="table table-striped">
    <thead>
        <tr>
            <td>ID</td>
            <td>Nome</td>
            <td>Exchange</td>
            <td>É Backtest ?</td>
            <td>Ultimo Processamento</td>
            <td colspan="2">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($traders as $trader)
        <tr>
            <td>{{$trader->id}}</td>
            <td>{{$trader->name}}</td>
            <td>{{$trader->exchange_code}}</td>
            <td>{{$trader->is_backtest}}</td>
            <td>{{$trader->processing_time->diffForHumans()}}</td>
            <td>
                <a href="{{ route('painel.bancario.traders.show',$trader->id)}}" class="btn btn-primary">Visualizar</a>
                <form action="{{ route('painel.bancario.traders.destroy', $trader->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Deletar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<script type='text/javascript'>
</script>
@if (method_exists($traders,'onEachSide'))
    {{ $traders->onEachSide(10)->links() }}
@endif