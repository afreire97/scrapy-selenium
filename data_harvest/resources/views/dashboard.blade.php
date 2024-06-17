<x-app-layout>

    @include('styles.dashboard')




    <div id="options" class="m-3 pt-5 ps-5">
        <div class="d-flex flex-wrap text-nowrap mb-n1" id="filter" data-option-key="filter">
            <a href="#show-all" class="btn btn-white btn-sm active border-0 me-1 mb-1" data-option-value="*">Todos</a>
            <a href="#gallery-group-1" class="btn btn-white btn-sm border-0 me-1 mb-1"
                data-option-value=".gallery-group-1">Vinted</a>
            <a href="#gallery-group-2" class="btn btn-white btn-sm border-0 me-1 mb-1"
                data-option-value=".gallery-group-2">Wallapop</a>
        </div>

    </div>

    <div class="modal fade" id="modal-dialog-tarea">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header"
                    style="background-color: #003780; display: flex; justify-content: center; align-items: center;">
                    <h4 class="modal-title text-white">Confirmar Guardar</h4>
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


    <div class="container px-5">




        <div id="gallery"
            class="gallery row row-cols-1 row-cols-md-3 row-cols-xl-4 row-cols-lg-4 d-flex align-items-stretch">
            @if (isset($relojesVinted))
                @foreach ($relojesVinted as $watch)
                    <div class="col gallery-group-1 mb-2 equal-height px-1 gallery-item"
                       >
                        <div class="w-full py-4">
                            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                                <div class="image-inner bg-cover bg-center h-56 p-2 " style="height: 300px;">
                                    <a href="{{ $watch->image_src }}" data-lightbox="gallery-group-1">
                                        <img src="{{ $watch->image_src }}" class="border-radius-3"
                                            style="height: 300px; width: 100%; object-fit: cover;"
                                            alt="Imagen de reloj {{ $watch->brand }}">
                                    </a>
                                </div>
                                <div class="p-2 ">
                                    <hr>
                                    <p class="uppercase tracking-wide text-sm font-bold text-gray-700 mt-2">
                                        {{ $watch->title }}</p>
                                    <hr>
                                    <p class="text-3xl text-gray-900">{{ $watch->price }} €</p>
                                    <p class="text-gray-700"><i class="fas fa-map-marker-alt"></i>
                                        {{ $watch->location }}</p>
                                    <p class="text-gray-700"><i class="fas fa-eye"></i> Vistas: {{ $watch->views }}</p>
                                </div>
                                <div
                                    class="flex p-2 border-t border-gray-300 text-gray-700 d-flex justify-content-between align-items-center">
                                    <div>
                                        <a href="{{ $watch->url }}" class="btn custom-btn" target="_blank">
                                            <i class="fas fa-external-link-alt"></i> Ver más
                                        </a>
                                    </div>
                                    <div>
                                        <button class="btn color-reloj guardar-reloj custom-btn" data-bs-toggle="modal"
                                            data-bs-target="#modal-dialog-tarea" data-reloj="{{ $watch }}">
                                            Guardar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            @if (isset($relojesWallapop))
                @foreach ($relojesWallapop as $watch)
                    <div class="col gallery-group-2 mb-2 equal-height px-1 gallery-item"
                      >
                        <div class="w-full py-4">
                            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                                <div class="image-inner bg-cover bg-center h-56 p-2" style="height: 300px;">
                                    <a href="{{ $watch->image_src }}" data-lightbox="gallery-group-2">
                                        <img src="{{ $watch->image_src }}" class="border-radius-3"
                                            style="height: 300px; width: 100%; object-fit: cover;"
                                            alt="Imagen de reloj {{ $watch->brand }}">
                                    </a>
                                </div>
                                <div class="p-2 ">
                                    <hr>
                                    <p class="uppercase tracking-wide text-sm font-bold text-gray-700 mt-2">
                                        {{ $watch->title }}</p>
                                    <hr>
                                    <p class="text-3xl text-gray-900">{{ $watch->price }} €</p>
                                    <p class="text-gray-700"><i class="fas fa-map-marker-alt"></i>
                                        {{ $watch->location }}</p>
                                    <p class="text-gray-700"><i class="fas fa-eye"></i> Vistas: {{ $watch->views }}</p>
                                </div>
                                <div
                                    class="flex p-2 border-t border-gray-300 text-gray-700 d-flex justify-content-between align-items-center">
                                    <div>
                                        <a href="{{ $watch->url }}" class="btn btn-primary custom-btn" target="_blank">
                                            <i class="fas fa-external-link-alt"></i> Ver más
                                        </a>
                                    </div>
                                    <div>
                                        <button class="btn btn-primary guardar-reloj custom-btn" data-bs-toggle="modal"
                                            data-bs-target="#modal-dialog-tarea" data-reloj="{{ $watch }}">
                                            Guardar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @include('scripts.dashboard')



</x-app-layout>
