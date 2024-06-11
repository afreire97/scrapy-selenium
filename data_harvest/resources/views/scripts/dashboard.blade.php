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


<script src="{{ asset('plugins/gritter/js/jquery.gritter.js') }}"></script>
<script src="{{ asset('plugins/sweetalert/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('plugins/cdn-assets/highlight.min.js') }}"></script>
<script src="{{ asset('js/modal/render.highlight.js') }}"></script>
<script src="{{ asset('js/modal/ui-modal-notification.demo.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Captura el evento de clic en los botones "Guardar"
        document.querySelectorAll('.guardar-reloj').forEach(button => {
            button.addEventListener('click', (event) => {
                let reloj = button.getAttribute('data-reloj');
                console.log("Datos del reloj seleccionado: ", reloj);
                document.getElementById('relojData').value = reloj;
            });
        });

        // Captura el evento de clic en el botón "Confirmar" del modal
        document.getElementById('confirmarGuardar').addEventListener('click', (event) => {
            // Envía el formulario al hacer clic en "Confirmar"
            let form = document.getElementById('guardarRelojForm');
            form.submit();
        });
    });
        </script>

<script>
    // Función para calcular el tiempo restante hasta la próxima hora en punto y 7 minutos
    const getTimeToNextHourPlusSeven = () => {
        const now = new Date();
        let nextHourPlusSeven;

        if (now.getMinutes() < 7) {
            nextHourPlusSeven = new Date(now.getFullYear(), now.getMonth(), now.getDate(), now.getHours(), 7, 0, 0);
        } else {
            nextHourPlusSeven = new Date(now.getFullYear(), now.getMonth(), now.getDate(), now.getHours() + 1, 7, 0, 0);
        }

        return nextHourPlusSeven - now;
    };

    // Función para recargar la página y luego establecer un temporizador para recargas cada hora y 7 minutos
    const refreshAtNextHourPlusSeven = () => {
        const timeToNextHourPlusSeven = getTimeToNextHourPlusSeven();

        setTimeout(() => {
            location.reload();
            // Configurar un temporizador para recargar la página cada hora después de la recarga inicial
            setInterval(() => {
                location.reload();
            }, 3600000); // 3600000 ms = 1 hora
        }, timeToNextHourPlusSeven);
    };

    // Llamar a la función para iniciar el proceso
    refreshAtNextHourPlusSeven();
</script>
