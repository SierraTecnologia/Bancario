

<div class="row">
    @foreach ($assets as $asset)
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-{{ $asset->getColor() }}"><i class="fa fa-envelope"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">{{ $asset->getName() }}</span>
                    <span class="info-box-number">{{ $asset->pivot->value }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    @endforeach
</div>
