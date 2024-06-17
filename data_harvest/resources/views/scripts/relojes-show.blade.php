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
            let selectedData = 'price';

            const precios = relojesData.map(reloj => reloj.price);
            const vistas = relojesData.map(reloj => reloj.views);

            const ctx = document.getElementById('line-chart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Precio',
                        borderColor: 'rgba(255, 0, 0, 1)',
                        pointBackgroundColor: 'rgba(255, 0, 0, 1)',
                        pointRadius: 4,
                        borderWidth: 2,
                        backgroundColor: 'rgba(255, 0, 0, .3)',
                        data: precios,
                        hidden: selectedData !== 'price'
                    }, {
                        label: 'Vistas',
                        borderColor: 'rgba(0, 128, 255, 1)',
                        pointBackgroundColor: 'rgba(0, 128, 255, 1)',
                        pointRadius: 4,
                        borderWidth: 2,
                        backgroundColor: 'rgba(0, 128, 255, .3)',
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
                                color: '#000000'
                            },
                            grid: {
                                color: '#666666'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#000000'
                            },
                            grid: {
                                color: '#666666'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#000000'
                            }
                        }
                    }
                }
            });

            document.getElementById('chart-container').style.opacity = "1";

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
