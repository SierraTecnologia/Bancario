@if (method_exists($histories,'onEachSide'))
    {{ $histories->onEachSide(10)->links() }}
@endif
<table class="table table-striped">
    <thead>
        <tr>
            <td>Tipo de Operação</td>
            <td>Cripto Ativo</td>
            <td>Valor da Operação</td>
            <td>Data da Operação</td>
        </tr>
    </thead>
    <tbody>
        @foreach($histories as $history)
        <tr>
            <td>{{$history->type}}</td>
            <td>{{$history->asset_code}}</td>
            <td>{{$history->value}}</td>
            <td>{{$history->processing_time->diffForHumans()}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<script type='text/javascript'>
</script>
@if (method_exists($histories,'onEachSide'))
    {{ $histories->onEachSide(10)->links() }}
@endif