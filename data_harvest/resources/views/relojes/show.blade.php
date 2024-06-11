<x-app-layout>
    @include('styles.gallery')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <input type="hidden" id="tipoReloj" value="{{ $tipo }}">

    @if (!count($relojesViejos) > 0)
     <div class="container align-items-center justify-content-center">
            <h3 class="m-5">No se ha encontrado ninguna versión anterior de este reloj.</h3>
        </div>


    @endif



    <div id="chart-container" style="width: 80%;height: auto; margin: auto; display: flex; justify-content: center;">
        <canvas id="line-chart" ></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const relojId = window.location.pathname.split('/').pop();
            const tipoReloj = document.getElementById('tipoReloj').value;

            async function fetchRelojesData() {
                let url = '';
                if (tipoReloj === '1') {
                    url = `{{ route('datosRelojesViejosVinted', ':reloj') }}`.replace(':reloj', relojId);
                } else if (tipoReloj === '2') {
                    url = `{{ route('datosRelojesViejosWallapop', ':reloj') }}`.replace(':reloj', relojId);
                } else {
                    throw new Error('Tipo de reloj desconocido');
                }

                const response = await fetch(url);
                if (!response.ok) {
                    throw new Error('Error retrieving data');
                }
                return await response.json();
            }

            async function initializeChart() {
                const relojesData = await fetchRelojesData();
                const labels = relojesData.map(reloj => reloj.created_at);
                let selectedData = 'price'; // Valor predeterminado

                const precios = relojesData.map(reloj => reloj.price);
                const vistas = relojesData.map(reloj => reloj.views);

                const ctx = document.getElementById('line-chart').getContext('2d');
                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Precio',
                            borderColor: 'rgba(0, 0, 255, 1)',
                            pointBackgroundColor: 'rgba(0, 0, 255, 1)',
                            pointRadius: 4,
                            borderWidth: 2,
                            backgroundColor: 'rgba(0, 0, 255, .3)',
                            data: precios,
                            hidden: selectedData !== 'price'
                        }, {
                            label: 'Vistas',
                            borderColor: 'rgba(255, 0, 0, 1)',
                            pointBackgroundColor: 'rgba(255, 0, 0, 1)',
                            pointRadius: 4,
                            borderWidth: 2,
                            backgroundColor: 'rgba(255, 0, 0, .3)',
                            data: vistas,
                            hidden: selectedData !== 'views'
                        }]
                    },
                    options: {
                        animation: {
                            duration: 1500
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: '#767676'
                                },
                                grid: {
                                    color: '#e0e0e0'
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#767676'
                                },
                                grid: {
                                    color: '#e0e0e0'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: '#767676'
                                }
                            }
                        }
                    }
                });

                document.getElementById('chart-container').style.opacity = "1";

                // Cambiar los datos mostrados cuando cambia la selección del usuario
                document.querySelectorAll('input[name="dataSelector"]').forEach((elem) => {
                    elem.addEventListener('change', function() {
                        if (this.checked) {
                            selectedData = this.value;
                        }
                        chart.data.datasets.forEach((dataset) => {
                            if (dataset.label === selectedData) {
                                dataset.hidden = false;
                            } else {
                                dataset.hidden = true;
                            }
                        });
                        chart.update();
                    });
                });
            }

            initializeChart();
        });
        </script>


</x-app-layout>
