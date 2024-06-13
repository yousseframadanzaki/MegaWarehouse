@extends('layouts.app')

@section('title')
    {{ __('homepage_title') }}
@endsection

@section('content')
<style>
    #chart-container {
        width: 100%;
        height: 100%;
        direction: ltr;
        overflow: auto; /* Enable scrolling */
        position: relative;
    }
    #pieChart {
        display: block;
        /* Initially no width or height specified */
    }
</style>

   <!--<h1>This is Dashbaord</h1>-->
   <div class="row my-3">
    <div class="col-lg-5">
        <div class="card shadow-sm bg-white">
          <div class="card-body">
            <center><h4 class="card-title">@lang('orders_pie_chart') ( {{ array_sum($data['count']) }} )</h4></center>
            <hr class="mb-2 mt-3">
            <div id="chart-container">
                <canvas id="pieChart"></canvas>
            </div>
          </div>
        </div>
      </div>
   </div>
@endsection
@section('script')

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const labels = {!! json_encode($data['city']) !!};
        const data = {!! json_encode($data['count']) !!};
        const backgroundColor = {!! json_encode($data['color']) !!};
        const borderColor = {!! json_encode($data['border-color']) !!};

        const container = document.getElementById('chart-container');
        const canvas = document.getElementById('pieChart');
        const ctx = canvas.getContext('2d');

        // Set the canvas size
        if (data.filter(element => element != '').length <= 14)
            canvas.width = container.clientWidth;
        else
            canvas.width = container.clientWidth * 1.5;

        canvas.height = 400;

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'عدد الأوردرات',
                    data: data,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false, // Disable responsive resizing
                maintainAspectRatio: false, // Disable aspect ratio maintenance
                layout: {
                        padding: {
                            left: 10,
                            right: 10,
                            top: 5,
                            bottom: 5
                        }
                    },
                plugins: {
                    tooltip: {
                        padding: 10, // Increase padding
                        backgroundColor: 'rgba(0, 0, 0, 0.7)', // Customize background color
                        bodyFont: {
                            size: 16 // Increase font size
                        },
                    },
                    legend: {
                        display: true,
                        rtl: true,
                        position: 'right',
                        labels: {
                            font: {
                                size: 17 // Adjust the label size here
                            },
                            textDirection: 'rtl', // Ensure text direction is RTL
                            usePointStyle: false, // Use point style for better visual
                        }
                    }
                }
            }
        });
    });
</script>

@endsection
