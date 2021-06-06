

@if (method_exists($orders,'onEachSide'))
    {{ $orders->onEachSide(10)->links() }}
@endif
@if (empty($orders))
    Nenhuma operação foi ainda realizada
@else
    <table class="table table-striped">
        <thead>
            <tr>
                <td>Cripto Ativo Vendido</td>
                <td>Cripto Ativo Comprado</td>
                <td>Valor Negociado</td>
                <td>Custo das Taxas</td>
                <td>Preço na Hora da Operação</td>
                <td>Hora Negociado</td>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{$order->asset_seller_code}}</td>
                <td>{{$order->asset_buyer_code}}</td>
                <td>{{$order->value}}</td>
                <td>{{$order->taxa}}</td>
                <td>{{$order->price}}</td>
                <td>{{$order->processing_time->diffForHumans()}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
<script type='text/javascript'>
</script>
@if (method_exists($orders,'onEachSide'))
    {{ $orders->onEachSide(10)->links() }}
@endif