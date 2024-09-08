@extends('layouts.app')

@section('title')
    {{ __('global.homepage_title') }}
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
        <div class="card shadow border-secondary">
          <div class="card-body">
            <h5 class="card-title text-center">@lang('global.orders_pie_chart') ( {{ array_sum($city_orders_data['count']) }} )</h5>
            <hr class="mb-2 mt-3">
            <div id="chart-container">
                <canvas id="pieChart"></canvas>
                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        const labels = {!! json_encode($city_orders_data['city']) !!};
                        const data = {!! json_encode($city_orders_data['count']) !!};
                        const backgroundColor = {!! json_encode($city_orders_data['color']) !!};
                        const borderColor = {!! json_encode($city_orders_data['border-color']) !!};

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
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="card shadow border-secondary">
          <div class="card-body">
            <h5 class="card-title text-center"> عدد أوردرات الحالات </h5>
            <hr class="mb-2 mt-3">

            <!-- Bar Chart -->
            <canvas id="barChart" style="max-height: 400px;"></canvas>
            <script>
              document.addEventListener("DOMContentLoaded", () => {
                new Chart(document.querySelector('#barChart'), {
                  type: 'bar',
                  data: {
                    labels: {!! json_encode($status_orders_data['names']) !!},
                    datasets: [{
                      label: '',
                      data: {!! json_encode($status_orders_data['orders_count']) !!},
                      backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                      ],
                      borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 205, 86)',
                        'rgba(255, 99, 132)'
                      ],
                      borderWidth: 1
                    }]
                  },
                  options: {
                    plugins: {
                        legend: {
                            display: false // Hide the legend (label)
                        }
                    },
                    scales: {
                      x: {
                        ticks: {
                        font: {
                            size: 14 // Set font size for x-axis labels
                          }
                        }
                      },
                      y: {
                        beginAtZero: true,
                      }
                    }
                  }
                });
              });
            </script>
            <!-- End Bar CHart -->

          </div>
        </div>
      </div>
   </div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
