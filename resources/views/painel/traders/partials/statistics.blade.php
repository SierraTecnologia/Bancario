

@if (method_exists($investiments,'onEachSide'))
    {{ $investiments->onEachSide(10)->links() }}
@endif
@if (empty($investiments))
    Nenhum valor foi investido
@else
    <table class="table table-striped">
        <thead>
            <tr>
                <td>Cripto Ativo</td>
                <td>Valor Investido</td>
            </tr>
        </thead>
        <tbody>
            @foreach($investiments as $investiment)
            <tr>
                <td>{{$investiment->asset_code}}</td>
                <td>{{$investiment->total_value}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
<script type='text/javascript'>
</script>

<table class="table table-hover text-nowrap">
    <thead>
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Date</th>
        <th>Status</th>
        <th>Reason</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>183</td>
        <td>John Doe</td>
        <td>11-7-2014</td>
        <td><span class="tag tag-success">Approved</span></td>
        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
    </tr>
    <tr>
        <td>219</td>
        <td>Alexander Pierce</td>
        <td>11-7-2014</td>
        <td><span class="tag tag-warning">Pending</span></td>
        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
    </tr>
    <tr>
        <td>657</td>
        <td>Bob Doe</td>
        <td>11-7-2014</td>
        <td><span class="tag tag-primary">Approved</span></td>
        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
    </tr>
    <tr>
        <td>175</td>
        <td>Mike Doe</td>
        <td>11-7-2014</td>
        <td><span class="tag tag-danger">Denied</span></td>
        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
    </tr>
    </tbody>
</table>