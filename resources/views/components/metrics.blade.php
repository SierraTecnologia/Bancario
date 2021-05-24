

<div class="row">
    @foreach ($metrics as $metric)
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-{{ $metric->getColor() }}"><i class="fa fa-envelope"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">{{ $metric->getName() }}</span>
                    <span class="info-box-number">{{ $metric->getValue() }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    @endforeach
</div>
