<x-app-layout>


    @include('styles.gallery')


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

<div class="modal fade" id="modal-dialog-tarea">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #008080; display: flex; justify-content: center; align-items: center;">
                <h4 class="modal-title text-white">Confirmar eliminación</h4>
            </div>
            <form id="eliminarRelojForm" action="{{ route('relojes.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input type="hidden" id="relojId" name="relojId">
                   <p class="card-text"> ¿Estás seguro de que quieres eliminar este reloj?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button id="confirmarEliminacion" type="button" class="btn btn-danger">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="options" class="m-3">
    <div class="d-flex flex-wrap text-nowrap mb-n1" id="filter" data-option-key="filter">
        <a href="#show-all" class="btn btn-white btn-sm active border-0 me-1 mb-1" data-option-value="*">Show All</a>
        <a href="#gallery-group-1" class="btn btn-white btn-sm border-0 me-1 mb-1"
            data-option-value=".gallery-group-1">Vinted</a>
        <a href="#gallery-group-2" class="btn btn-white btn-sm border-0 me-1 mb-1"
            data-option-value=".gallery-group-2">Wallapop</a>
    </div>
</div>


    <div id="gallery"
    class="gallery row row-cols-1 row-cols-md-2 row-cols-xl-4 row-cols-lg-4 d-flex justify-content-center align-content-center">
    @if (isset($relojesVinted))
        @foreach ($relojesVinted as $watch)
            <div class="col gallery-group-1 mb-3 equal-height">
                <h3> {{$watch->updated_at}}</h3>

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
                                <button class="btn btn-danger eliminar-reloj" data-bs-toggle="modal"
                                    data-bs-target="#modal-dialog-tarea"
                                    data-reloj="{{$watch->id }}">Eliminar</button>

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
                <h3> {{$watch->updated_at}}</h3>

                <div class="image-inner" style="width: fit-content">
                    <a href="{{ $watch->image_src }}" data-lightbox="gallery-group-2">
                        <img src="{{ $watch->image_src }}" class="border-radius-3"
                            style="height: 550px; width: 100%" alt="Imagen de reloj {{ $watch->brand }}">
                    </a>
                </div>
                <div class="image-info " style="max-width: 80%">
                    <h5 class="title">{{ $watch->title }}</h5>
                    <div class="d-flex align-items-center mb-2"></div>
                    <div class="desc">
                        <h5 class="card-title">{{ $watch->brand }}</h5>
                        <p class="card-text">Precio: {{ $watch->price }}</p>
                        <p class="card-text">Ubicación: {{ $watch->location }}</p>
                        <p class="card-text">Vistas: {{ $watch->views }}</p>
                        <a href="{{ $watch->url }}" class="btn btn-primary" target="_blank">Visitar página</a>
                        <button class="btn btn-danger eliminar-reloj" data-bs-toggle="modal"
                        data-bs-target="#modal-dialog-tarea"
                        data-reloj="{{$watch->id }}">Eliminar</button>

                    </div>
                </div>
            </div>
        @endforeach
    @endif
    </div>








</x-app-layout>

@include('scripts.relojes-index')

<script>
        document.addEventListener('DOMContentLoaded', () => {




        // Captura el evento de clic en los botones "Guardar"
        document.querySelectorAll('.eliminar-reloj').forEach(button => {
            button.addEventListener('click', (event) => {
                const reloj = button.getAttribute('data-reloj');
                document.getElementById('relojId').value = reloj;
            });
        });

        // Captura el evento de clic en el botón "Confirmar" del modal
        document.getElementById('confirmarEliminacion').addEventListener('click', (event) => {
            // Envía el formulario al hacer clic en "Confirmar"
            const form = document.getElementById('eliminarRelojForm');
            form.submit();
        });




    });
</script>
