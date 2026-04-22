@extends('admin.layouts.appClean')

@section('content')
    <main>


        <!-- Main page content-->
        <div class="container-xl px-4 mt-5">
            <!-- Custom page header alternative example-->
            <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                <div class="me-4 mb-3 mb-sm-0">
                    <h1 class="mb-0">Mi Suscripcion </h1>
                    <div class="small">
                        <span class="fw-500 text-primary">Friday</span>
                        &middot; September 20, 2021 &middot; 12:16 PM
                    </div>
                </div>
                <!-- Date range picker example-->
                <div class="input-group input-group-joined border-0 shadow" style="width: 16.5rem">
                    <span class="input-group-text"><i data-feather="calendar"></i></span>
                    <input class="form-control ps-0 pointer" id="litepickerRangePlugin"
                        placeholder="Select date range..." />
                </div>
            </div>
            <!-- Illustration dashboard card example-->
            <div class="card card-waves mb-4 mt-5">
                <div class="card-body p-5">
                    <div class="row align-items-center justify-content-between">
                        <div class="col">
                            <h2 class="text-primary">¡Bienvenido de nuevo, tu panel de administración está listo!</h2>
                            <p class="text-gray-700">Tu panel de suscripción está disponible para gestionar tus
                                Suscripciones y preferencias, revisar tus suscripciones activas y mucho más. También puedes
                                acceder a nuestra colección de artículos exclusivos y guías.</p>
                            <a class="btn btn-primary p-3" href="{{ route('articles.index') }}">
                                Visitar Artículos
                                <i class="ms-1" data-feather="arrow-right"></i>
                            </a>
                        </div>
                        <div class="col d-none d-lg-block mt-xxl-n4">
                            <img class="img-fluid px-xl-4 mt-xxl-n5"
                                src="{{ asset('assets/panel/assets/img/illustrations/statistics.svg') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <!-- Dashboard info widget 1-->
                    <div class="card border-start-lg border-start-primary h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small fw-bold text-primary mb-1">Earnings (monthly)</div>
                                    <div class="h5">$4,390</div>
                                    <div class="text-xs fw-bold text-success d-inline-flex align-items-center">
                                        <i class="me-1" data-feather="trending-up"></i>
                                        12%
                                    </div>
                                </div>
                                <div class="ms-2"><i class="fas fa-dollar-sign fa-2x text-gray-200"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <!-- Dashboard info widget 2-->
                    <div class="card border-start-lg border-start-secondary h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small fw-bold text-secondary mb-1">Average sale price</div>
                                    <div class="h5">$27.00</div>
                                    <div class="text-xs fw-bold text-danger d-inline-flex align-items-center">
                                        <i class="me-1" data-feather="trending-down"></i>
                                        3%
                                    </div>
                                </div>
                                <div class="ms-2"><i class="fas fa-tag fa-2x text-gray-200"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <!-- Dashboard info widget 3-->
                    <div class="card border-start-lg border-start-success h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small fw-bold text-success mb-1">Clicks</div>
                                    <div class="h5">11,291</div>
                                    <div class="text-xs fw-bold text-success d-inline-flex align-items-center">
                                        <i class="me-1" data-feather="trending-up"></i>
                                        12%
                                    </div>
                                </div>
                                <div class="ms-2"><i class="fas fa-mouse-pointer fa-2x text-gray-200"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <!-- Dashboard info widget 4-->
                    <div class="card border-start-lg border-start-info h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small fw-bold text-info mb-1">Conversion rate</div>
                                    <div class="h5">1.23%</div>
                                    <div class="text-xs fw-bold text-danger d-inline-flex align-items-center">
                                        <i class="me-1" data-feather="trending-down"></i>
                                        1%
                                    </div>
                                </div>
                                <div class="ms-2"><i class="fas fa-percentage fa-2x text-gray-200"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <!-- Illustration card example-->
                    <div class="card mb-4">
                        <div class="card-body text-center p-5">
                            <img class="img-fluid mb-5" src="{{ asset('/landing-v1/public/img/img.icons8.png') }}" />
                            <h4>Cancelar la suscripción</h4>
                            <p class="mb-4">¿Estás seguro de que deseas cancelar tu suscripción a nuestra lista?</p>

                            <!-- Button trigger modal -->
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">Cancelar suscripción</button>

                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" tabindex="-1"
                                role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Confirmación de cancelación</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Estás seguro de que deseas cancelar tu suscripción? Esta acción no se puede deshacer.
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Cerrar</button>

                                      <!-- Formulario para confirmar la cancelación -->
                                    <form action="" method="POST">
                                        @csrf <!-- Si usas Laravel, esto es necesario para proteger el formulario -->
                                        <button class="btn btn-danger" type="submit">Confirmar cancelación</button>
                                    </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <a class="btn btn-red p-3" href="#!">Confirmar Baja</a> --}}
                        </div>
                    </div>

                    <!-- Report summary card example-->

                </div>
                <div class="col-lg-8 mb-4">
                    <!-- Area chart example-->

                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Bar chart example-->

                        </div>
                        <div class="col-lg-6">
                            <!-- Pie chart example-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    const btn = e.submitter || this.querySelector('button:not([type="button"]), input[type="submit"]');
                    if (btn) {
                        setTimeout(function() {
                            btn.disabled = true;
                            btn.setAttribute('aria-busy', 'true');
                            // Keep existing content but add text if it's text-only, or append spinner.
                            // For simplicity and safety, just change text if there are no icons, otherwise just dim it.
                            btn.innerHTML = 'Procesando...';
                            btn.style.opacity = '0.7';
                            btn.style.cursor = 'not-allowed';
                        }, 0);
                    }
                });
            });
        });
    </script>
@endsection
