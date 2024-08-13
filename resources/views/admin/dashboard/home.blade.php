@extends('admin.layout.main')
@section('title') Bienvenido(a) ! {{ Auth::guard('admin')->user()->name }} @endsection

@section('content')
<div class="container pull-up">
    @include('admin.dashboard.overview')
    @include('admin.dashboard.chart')
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
                    name: 'Pedidos Cancelados',
                    data: [5, 7, 9, 10, 4, 2, 1]
                },
                {
                    name: 'Pedidos Completos',
                    data: [10, 7, 8, 10, 8, 4, 6]
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

        if ($("#chart-02").length) {
            var options = {
                chart: {

                    type: 'bar',
                },
                colors: colors[8],
                plotOptions: {
                    bar: {
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                series: [{
                    data: [3,4,6]
                }],
                xaxis: {
                    categories: ['Amazon','Oxxo','Demo'],
                },
                yaxis: {},
                tooltip: {}
            };

            var chart = new ApexCharts(
                document.querySelector("#chart-02"),
                options
            );

            chart.render();

        }
        
    })(window.jQuery);

</script>
@endsection