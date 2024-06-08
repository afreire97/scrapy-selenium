<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">


    <link href="{{ asset('css/vendor.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/default/app.min.css') }}" rel="stylesheet" />
    <!-- ================== END core-css ================== -->

    <!-- ================== BEGIN page-css ================== -->
    <link href="{{ asset('plugins/lightbox2/dist/css/lightbox.css') }}" rel="stylesheet" />



    <div class="container">


    </div>

    <div>



        <div id="options" class="m-3">
            <div class="d-flex flex-wrap text-nowrap mb-n1" id="filter" data-option-key="filter">
                <a href="#show-all" class="btn btn-white btn-sm active border-0 me-1 mb-1" data-option-value="*">Show
                    All</a>
                <a href="#gallery-group-1" class="btn btn-white btn-sm border-0 me-1 mb-1"
                    data-option-value=".gallery-group-1">Vinted</a>
                <a href="#gallery-group-2" class="btn btn-white btn-sm border-0 me-1 mb-1"
                    data-option-value=".gallery-group-2">Wallapop</a>

            </div>
        </div>

        <div class="modal fade" id="modal-dialog-tarea">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #008080; display: flex; justify-content: center; align-items: center;">
                        <h4 class="modal-title">Confirmar Guardar</h4>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que quieres guardar este reloj?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="confirmarGuardar">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="gallery"
            class="gallery row row-cols-1 row-cols-md-3 row-cols-xl-5 row-cols-lg-5 d-flex justify-content-center">


            @if (isset($relojesVinted))
                @foreach ($relojesVinted as $reloj)
                    <div class="col gallery-group-1 mb-3 equal-height">
                        <div class="image-inner" style="width: fit-content">
                            <a href="{{ $reloj->image_src }}" data-lightbox="gallery-group-1">
                                <img src="{{ $reloj->image_src }}" class="border-radius-3"
                                    alt="Imagen de reloj {{ $reloj->brand }}" style="height: 550px; width: 100%">
                            </a>
                            <div class="image-info" style="width: 80%">
                                <h5 class="card-title mb-3 mt-2">{{ $reloj->brand }}</h5>
                                <hr>
                                <div class="desc">
                                    <h5 class="title">{{ $reloj->title }}</h5>
                                    <p class="card-text">Precio: {{ $reloj->price }}</p>
                                    <p class="card-text">Ubicación: {{ $reloj->location }}</p>
                                    <p class="card-text">Vistas: {{ $reloj->views }}</p>
                                    <div class="buttons d-flex justify-content-center p-1">

                                        <a class="btn btn-primary me-2" href="{{ $reloj->url }}" target="_blank">Visitar página</a>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-dialog-tarea">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif


            @if (isset($relojesWallapop))
                @foreach ($relojesWallapop as $watch)
                    <div class="col gallery-group-2 mb-3 equal-height">
                        <div class="image-inner" style="width: fit-content">
                            <a href="{{ $watch->image_src }}" data-lightbox="gallery-group-2">
                                <img src="{{ $watch->image_src }}" class="border-radius-3"
                                    style="height: 550px; width: 100%" alt="Imagen de reloj {{ $watch->brand }}">
                            </a>
                        </div>
                        <div class="image-info" style="max-width: 80%">
                            <h5 class="title">{{ $watch->title }}</h5>
                            <div class="d-flex align-items-center mb-2"></div>
                            <div class="desc">
                                <h5 class="card-title">{{ $watch->brand }}</h5>
                                <p class="card-text">Precio: {{ $watch->price }}</p>
                                <p class="card-text">Ubicación: {{ $watch->location }}</p>
                                <p class="card-text">Vistas: {{ $watch->views }}</p>
                                <a href="{{ $watch->url }}" class="btn btn-primary" target="_blank">Ver más</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif




        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    {{-- <script src="{{asset('js\fetch_data\app.js')}}"></script> --}}







    <!-- ================== BEGIN core-js ================== -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>
    <!-- ================== END core-js ================== -->

    <!-- ================== BEGIN page-js ================== -->
    <script src="{{ asset('plugins/isotope-layout/dist/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('plugins/lightbox2/dist/js/lightbox.min.js') }}"></script>

    <script src="{{ asset('js/demo/gallery.demo.js') }}"></script>

    {{-- @include('scripts.app2') --}}

    <script src="{{ asset('plugins/gritter/js/jquery.gritter.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('plugins/cdn-assets/highlight.min.js') }}"></script>
    <script src="{{ asset('js/modal/render.highlight.js') }}"></script>
    <script src="{{ asset('js/modal/ui-modal-notification.demo.js') }}"></script>


    <script>
        $(document).ready(function() {


            $('#confirmarGuardar').on('click', function() {
                $('#modal-dialog-tarea').modal('show');
            });
        });
    </script>


</x-app-layout>
