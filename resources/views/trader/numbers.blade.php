<?php 

dd($account);

?>


<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-envelope"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Emails</span>
            <span class="info-box-number">{{$emails}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-phone"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Phones</span>
            <span class="info-box-number">{{$phones}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-anchor"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Addresses</span>
            <span class="info-box-number">{{$addresses}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-calendar"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Trackings</span>
            <span class="info-box-number">{{$trackings}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
