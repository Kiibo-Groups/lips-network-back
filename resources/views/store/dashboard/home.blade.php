@extends('store.layout.main')

@section('title') Bienvenido(a) ! {{ Auth::user()->name }} @endsection

@section('icon') mdi-home @endsection


@section('content')

<div class="container pull-up">

<div class="row">
    <div class="col m-b-30">
        <div class="card ">
            <div class="text-center card-body">
                <div class="text-success">
                    <div class="avatar avatar-sm ">
                        <span class="avatar-title rounded-circle badge-soft-success">
                            <i class="mdi mdi-chart-bar mdi-18px"></i> 
                        </span>
                    </div>
                        <h6 class="m-t-5 m-b-0">&nbsp;</h6>
                </div>

                <div class=" text-center">
                    
                    @if($overview['saldos'] > 0)
                    <!-- Saldo a favor -->
                    <h3 style="font-size: 19px">Tienes un saldo a favor de:</h3>
                    @else 
                    <!-- Saldo que debe -->
                    <h3 style="font-size: 19px">Tienes un saldo deudor de:</h3>
                    @endif
                </div>
                <div class="text-overline ">
                @if($overview['saldos'] > 0)
                <!-- Saldo a favor -->
                <h1 style="color:green;">{{$currency}}{{ number_format($overview['saldos'],2) }} <i class="mdi mdi-trending-up"></i></h1>
                @else 
                <!-- Saldo que debe -->
                <?php
                    $sal = str_replace('-','',$overview['saldos']);
                ?>
                <h1 style="color:red;">{{$currency}}{{ number_format($sal,2) }} <i class="mdi mdi-trending-down"></i> </h1>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('store.dashboard.overview')

@include('store.dashboard.chart')


</div>

@endsection

@section('js')

<script src="{{ Asset('assets/vendor/apexchart/apexcharts.min.js') }}"></script>

<script type="text/javascript">

(function ($) {
    'use strict';

    if ($("#chart-01").length) {

        var options = {
            colors: colors,
            chart: {

                type: 'bar',
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    endingShape: 'rounded',
                    columnWidth: '55%',
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{
                name: 'Cancelled Orders',
                data: [<?php echo $admin->chart(6,1)['cancel']; ?>, <?php echo $admin->chart(5,1)['cancel']; ?>, <?php echo $admin->chart(4,1)['cancel']; ?>, <?php echo $admin->chart(3,1)['cancel']; ?>, <?php echo $admin->chart(2,1)['cancel']; ?>, <?php echo $admin->chart(1,1)['cancel']; ?>, <?php echo $admin->chart(0,1)['cancel']; ?>]
            },
            {
                name: 'Completed Orders',
                data: [<?php echo $admin->chart(6,1)['order']; ?>, <?php echo $admin->chart(5,1)['order']; ?>, <?php echo $admin->chart(4,1)['order']; ?>, <?php echo $admin->chart(3,1)['order']; ?>, <?php echo $admin->chart(2,1)['order']; ?>, <?php echo $admin->chart(1,1)['order']; ?>, <?php echo $admin->chart(0,1)['order']; ?>]
            }, 
            

            

            ],
            xaxis: {
                categories: ['<?php echo $admin->getMonthName(6); ?>', '<?php echo $admin->getMonthName(5); ?>', '<?php echo $admin->getMonthName(4); ?>', '<?php echo $admin->getMonthName(3); ?>', '<?php echo $admin->getMonthName(2); ?>', '<?php echo $admin->getMonthName(1); ?>', '<?php echo $admin->getMonthName(0); ?>'],
            },
            yaxis: {
                title: {
                    text: ''
                }
            },
            fill: {
                opacity: 1

            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val
                    }
                }
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#chart-01"),
            options
        );

        chart.render();
    }

   
})(window.jQuery);
</script>

@endsection