<x-app-layout>

    @include('styles.gallery')

    <x-slot name="header">


    <a class="btn btn-warning">Actualizar datos</a>




</x-slot>



    <div id="options" class="m-3">
        <div class="d-flex flex-wrap text-nowrap mb-n1" id="filter" data-option-key="filter">
            <a href="#show-all" class="btn btn-white btn-sm active border-0 me-1 mb-1" data-option-value="*">Show All</a>
            <a href="#gallery-group-1" class="btn btn-white btn-sm border-0 me-1 mb-1"
                data-option-value=".gallery-group-1">Vinted</a>
            <a href="#gallery-group-2" class="btn btn-white btn-sm border-0 me-1 mb-1"
                data-option-value=".gallery-group-2">Wallapop</a>
        </div>
    </div>
 <!-- Modal para confirmar guardar reloj -->
 <div class="modal fade" id="modal-dialog-tarea">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #008080; display: flex; justify-content: center; align-items: center;">
                <h4 class="modal-title">Confirmar Guardar</h4>
            </div>
            <form id="guardarRelojForm" action="{{ route('guardar-reloj') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="relojData" name="relojData">
                    ¿Estás seguro de que quieres guardar este reloj?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button id="confirmarGuardar" type="button" class="btn btn-primary">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Si hay un mensaje de error -->
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <div id="gallery"
        class="gallery row row-cols-1 row-cols-md-2 row-cols-xl-4 row-cols-lg-4 d-flex justify-content-center align-content-center">
        @if (isset($relojesVinted))
            @foreach ($relojesVinted as $watch)
                <div class="col gallery-group-1 mb-3 equal-height">
                    <div class="image-inner" style="width: fit-content">
                        <a href="{{ $watch->image_src }}" data-lightbox="gallery-group-1">
                            <img src="{{ $watch->image_src }}" class="border-radius-3"
                                alt="Imagen de reloj {{ $watch->brand }}" style="height: 550px; width: 100%">
                        </a>
                        <div class="image-info" style="width: 80%">
                            <h5 class="card-title mb-3 mt-2">{{ $watch->brand }}</h5>
                            <hr>
                            <div class="desc">
                                <h5 class="title">{{ $watch->title }}</h5>
                                <p class="card-text">Precio: {{ $watch->price }}</p>
                                <p class="card-text">Ubicación: {{ $watch->location }}</p>
                                <p class="card-text">Vistas: {{ $watch->views }}</p>
                                <div class="buttons d-flex justify-content-center p-1">
                                    <a class="btn btn-primary me-2" href="{{ $watch->url }}" target="_blank">Visitar
                                        página</a>
                                    <button class="btn btn-primary guardar-reloj" data-bs-toggle="modal"
                                        data-bs-target="#modal-dialog-tarea"
                                        data-reloj="{{$watch }}">Guardar</button>

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
                            <button class="btn btn-primary guardar-reloj" data-bs-toggle="modal" data-bs-target="#modal-dialog-tarea"
                                data-reloj="{{ $watch }}">Guardar</button>

                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    @include('scripts.dashboard')
</x-app-layout>

