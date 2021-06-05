<?php 
$data = [];
?>

@foreach ($assets as $asset)
    <?php 
    $data[$asset->code] = $asset->pivot->value;
    ?>
@endforeach

@if (method_exists($investiments,'onEachSide'))
    {{ $investiments->onEachSide(10)->links() }}
@endif

@if ($investiments->count())
    Nenhum valor foi investido
@else
    <table class="table table-striped">
        <thead>
            <tr>
                <td>Cripto Ativo</td>
                <td>Valor Investido</td>
                <td>Quantidade Atual</td>
                <td>Quantidade caso vendesse tudo</td>
            </tr>
        </thead>
        <tbody>
            @foreach($investiments as $investiment)
            <tr>
                <td>{{$investiment->asset_code}}</td>
                <td>{{$investiment->total_value}}</td>
                <td>{{$data[$investiment->asset_code]}}</td>
                <td>{{$data[$investiment->asset_code]}}</td>
            </tr>
    <?php 
    dd($data[$investiment->asset_code]);
    ?>
            @endforeach
        </tbody>
    </table>
@endif
<script type='text/javascript'>
</script>
@if (method_exists($investiments,'onEachSide'))
    {{ $investiments->onEachSide(10)->links() }}
@endif