<x-app-layout>
    @include('styles.relojes-show')



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <input type="hidden" id="tipoReloj" value="{{ $tipo }}">

    @if (!count($relojesViejos) > 0)
        <div class="container align-items-center justify-content-center">
            <h3 class="m-5">No se ha encontrado ninguna versión anterior de este reloj.</h3>
        </div>

        @else
        <div id="chart-container" style="width: 80%;height: auto; margin: auto; display: flex; justify-content: center;">
            <canvas id="line-chart"></canvas>
        </div>

    @endif


@include('scripts.relojes-show')

</x-app-layout>
