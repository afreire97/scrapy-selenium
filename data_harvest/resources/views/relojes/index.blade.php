<x-app-layout>


    @include('styles.relojes-index')


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
                <div class="modal-header"
                style="background-color: #003780; display: flex; justify-content: center; align-items: center;">
                <h4 class="modal-title text-white">Confirmar Guardar</h4>
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


    <div id="options" class="m-3 pt-5 ps-5">
        <div class="d-flex flex-wrap text-nowrap mb-n1" id="filter" data-option-key="filter">
            <a href="#show-all" class="btn btn-white btn-sm active border-0 me-1 mb-1" data-option-value="*">Todos</a>
            <a href="#gallery-group-1" class="btn btn-white btn-sm border-0 me-1 mb-1"
                data-option-value=".gallery-group-1">Vinted</a>
            <a href="#gallery-group-2" class="btn btn-white btn-sm border-0 me-1 mb-1"
                data-option-value=".gallery-group-2">Wallapop</a>
        </div>

    </div>


    <div class="container px-5">

    <div id="gallery"
        class="gallery row row-cols-1 row-cols-md-3 row-cols-xl-4 row-cols-lg-4 d-flex align-items-stretch">

        @if (isset($relojesVinted))
            @foreach ($relojesVinted as $watch)
                <div class="col gallery-group-1 mb-2 equal-height px-1">
                    <div class="w-full py-4">
                        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                            <div class="image-inner bg-cover bg-center h-56 p-2 " style="height: 300px;">
                                <a href="{{ $watch->image_src }}" data-lightbox="gallery-group-1">
                                    <img src="{{ $watch->image_src }}" class="border-radius-3"
                                        style="height: 300px; width: 100%; object-fit: cover;"
                                        alt="Imagen de reloj {{ $watch->title }}">
                                </a>
                            </div>
                            <div class="p-2">
                                <hr>
                                <p class="uppercase tracking-wide text-sm font-bold text-gray-700 mt-2">
                                    {{ $watch->title }}</p>
                                <hr>
                                <p class="text-3xl text-gray-900">
                                    @php
                                        $relojViejoMasReciente = $watch->relojesViejos()->oldest('created_at')->first();
                                    @endphp
                                    @if (isset($relojViejoMasReciente))
                                        @if ($watch->price > $relojViejoMasReciente->price)
                                            <span style="color: green;">{{ $watch->price }}</span>
                                            <img src="{{ asset('icons/incrementar.png') }}" class="inline-block w-7"
                                                alt="Icono Precio Subió">
                                            <span
                                                style="color: green;">(+{{ $watch->price - $relojViejoMasReciente->price }})</span>
                                        @elseif ($watch->price < $relojViejoMasReciente->price)
                                            <span style="color: red;">{{ $watch->price }}</span>
                                            <img src="{{ asset('icons/disminucion.png') }}" class="inline-block w-7"
                                                alt="Icono Precio Disminuyó">
                                            <span
                                                style="color: red;">(-{{ $relojViejoMasReciente->price - $watch->price }})</span>
                                        @else
                                            <span style="color: black;">{{ $watch->price }}</span>
                                        @endif
                                    @else
                                        <span style="color: black;">{{ $watch->price }}</span>
                                    @endif
                                    €
                                </p>
                                <p class="text-gray-700"><i class="fas fa-map-marker-alt"></i> {{ $watch->location }}
                                </p>
                                <p class="text-gray-700"><i class="fas fa-eye"></i> Vistas:
                                    @php
                                        $relojViejoMasViejo = $watch->relojesViejos()->oldest('created_at')->first();
                                    @endphp
                                    @if (isset($relojViejoMasViejo))
                                        @if ($watch->views > $relojViejoMasViejo->views)
                                            <span style="color: green;">{{ $watch->views }}</span>
                                            <img src="{{ asset('icons/incrementar.png') }}" class="inline-block w-7"
                                                alt="Icono Precio Subió">
                                            <span>antes ({{ $relojViejoMasViejo->views }})</span>
                                        @else
                                            {{ $watch->views }}
                                        @endif
                                    @else
                                        {{ $watch->views }}
                                    @endif
                                </p>

                            <p class="text-gray-700"><i class="fas fa-calendar"></i> Última actualización: {{$watch->updated_at}}</p>
                            <p class="text-gray-700"><i class="fas fa-calendar"></i> Fecha de obtención: {{$watch->fecha_obtencion}}</p>
                            </div>
                            <div class="p-3  justify-content-center  row row-cols-3 ">

                                    <a href="{{ $watch->url }}" class="custom-btn mr-2  col " target="_blank">Ver</a>
                                    <a class="custom-btn mr-2  col" href="{{ route('relojesViejosV', ['reloj' => $watch]) }}" target="_blank">
                                        Información
                                    </a>

                                    <button class="btn-danger eliminar-reloj px-3 col" data-bs-toggle="modal" data-bs-target="#modal-dialog-tarea" data-reloj="{{ $watch->id }}">
                                        Eliminar
                                    </button>

                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        @if (isset($relojesWallapop))
        @foreach ($relojesWallapop as $watch)
            <div class="col gallery-group-2 mb-2 equal-height px-1">
                <div class="w-full py-4">
                    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                        <div class="image-inner bg-cover bg-center h-56 p-2" style="height: 300px;">
                            <a href="{{ $watch->image_src }}" data-lightbox="gallery-group-2">
                                <img src="{{ $watch->image_src }}" class="border-radius-3"
                                    style="height: 300px; width: 100%; object-fit: cover;"
                                    alt="Imagen de reloj {{ $watch->title }}">
                            </a>
                        </div>
                        <div class="p-2">
                            <hr>
                            <p class="uppercase tracking-wide text-sm font-bold text-gray-700 mt-2">
                                {{ $watch->title }}</p>
                            <hr>
                            <p class="text-3xl text-gray-900">
                                @php
                                    $relojViejoMasReciente = $watch->relojesViejos()->oldest('created_at')->first();
                                @endphp
                                @if (isset($relojViejoMasReciente))
                                    @if ($watch->price > $relojViejoMasReciente->price)
                                        <span style="color: green;">{{ $watch->price }}</span>
                                        <img src="{{ asset('icons/incrementar.png') }}" class="inline-block w-7"
                                            alt="Icono Precio Subió">
                                        <span
                                            style="color: green;">(+{{ $watch->price - $relojViejoMasReciente->price }})</span>
                                    @elseif ($watch->price < $relojViejoMasReciente->price)
                                        <span style="color: red;">{{ $watch->price }}</span>
                                        <img src="{{ asset('icons/disminucion.png') }}" class="inline-block w-7"
                                            alt="Icono Precio Disminuyó">
                                        <span
                                            style="color: red;">(-{{ $relojViejoMasReciente->price - $watch->price }})</span>
                                    @else
                                        <span style="color: black;">{{ $watch->price }}</span>
                                    @endif
                                @else
                                    <span style="color: black;">{{ $watch->price }}</span>
                                @endif
                                €
                            </p>
                            <p class="text-gray-700"><i class="fas fa-map-marker-alt"></i> {{ $watch->location }}
                            </p>
                            <p class="text-gray-700"><i class="fas fa-eye"></i> Vistas:
                                @php
                                    $relojViejoMasViejo = $watch->relojesViejos()->oldest('created_at')->first();
                                @endphp
                                @if (isset($relojViejoMasViejo))
                                    @if ($watch->views > $relojViejoMasViejo->views)
                                        <span style="color: green;">{{ $watch->views }}</span>
                                        <img src="{{ asset('icons/incrementar.png') }}" class="inline-block w-7"
                                            alt="Icono Precio Subió">
                                        <span>antes ({{ $relojViejoMasViejo->views }})</span>
                                    @else
                                        {{ $watch->views }}
                                    @endif
                                @else
                                    {{ $watch->views }}
                                @endif
                            </p>

                            <p class="text-gray-700"><i class="fas fa-calendar"></i> Última actualización: {{$watch->updated_at}}</p>
                            <p class="text-gray-700"><i class="fas fa-calendar"></i> Fecha de obtención: {{$watch->fecha_obtencion}}</p>
                        </div>
                        <div class="p-3  justify-content-center  row row-cols-3 ">

                            <a href="{{ $watch->url }}" class="custom-btn mr-2  col " target="_blank">Ver</a>
                            <a class="custom-btn mr-2  col" href="{{ route('relojesViejosW', ['reloj' => $watch]) }}" target="_blank">
                                Información
                            </a>

                            <button class="btn-danger eliminar-reloj px-3 col" data-bs-toggle="modal" data-bs-target="#modal-dialog-tarea" data-reloj="{{ $watch->id }}">
                                Eliminar
                            </button>

                    </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    </div>
    </div>








</x-app-layout>

@include('scripts.relojes-index')

