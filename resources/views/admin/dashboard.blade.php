@extends('admin.layouts.app')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-bar-chart">
                                        <line x1="12" y1="20" x2="12" y2="10"></line>
                                        <line x1="18" y1="20" x2="18" y2="4"></line>
                                        <line x1="6" y1="20" x2="6" y2="16"></line>
                                    </svg></div>
                                Charts
                            </h1>
                            <div class="page-header-subtitle">Interactive charts to display your data, powered by Chart.js,
                                customized for SB Admin Pro</div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-n10">
            <!-- Area chart example-->
            <div class="card mb-4">
                <div class="card-header">Area Chart Example</div>
                <div class="card-body">
                    <div class="chart-area">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div><canvas id="myAreaChart" width="1347" height="240" class="chartjs-render-monitor"
                            style="display: block; width: 1347px; height: 240px;"></canvas>
                    </div>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <!-- Bar chart example-->
                    <div class="card mb-4">
                        <div class="card-header">Bar Chart Example</div>
                        <div class="card-body">
                            <div class="chart-bar">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div><canvas id="myBarChart" width="639" height="240" class="chartjs-render-monitor"
                                    style="display: block; width: 639px; height: 240px;"></canvas>
                            </div>
                        </div>
                        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- Pie chart example-->
                    <div class="card mb-4">
                        <div class="card-header">Pie Chart Example</div>
                        <div class="card-body">
                            <div class="chart-pie">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div><canvas id="myPieChart" width="639" height="240" class="chartjs-render-monitor"
                                    style="display: block; width: 639px; height: 240px;"></canvas>
                            </div>
                        </div>
                        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                    </div>
                </div>
            </div>
            <!-- Third party docs message-->
            <div class="card card-icon mb-4">
                <div class="row g-0">
                    <div class="col-auto card-icon-aside bg-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-alert-triangle text-white-50">
                            <path
                                d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                            </path>
                            <line x1="12" y1="9" x2="12" y2="13"></line>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg></div>
                    <div class="col">
                        <div class="card-body py-5">
                            <h5 class="card-title">Third-Party Documentation Available</h5>
                            <p class="card-text">Chart.js is a third party plugin that is used to generate the charts in
                                this template. The charts above have been customized to fit the style of the SB Admin Pro
                                theme. For further customization options, please visit the official Chart.js documentation.
                            </p>
                            <a class="btn btn-primary btn-sm" href="https://www.chartjs.org/docs/latest/"
                                target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-external-link me-1">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                    <polyline points="15 3 21 3 21 9"></polyline>
                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                </svg>
                                Visit Chart.js Docs
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/panel/assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/panel/assets/demo/chart-bar-demo.js') }}"></script>
    <script src="{{ asset('assets/panel/assets/demo/chart-pie-demo.js') }}"></script>
@endsection
