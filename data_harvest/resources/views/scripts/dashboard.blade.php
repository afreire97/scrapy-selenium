<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>







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
    $(document).ready(function() {
        // Función para verificar el tiempo
        function checkButtonState() {
            const clickTime = localStorage.getItem('clickTime');
            if (clickTime) {
                const currentTime = new Date().getTime();
                const elapsedTime = currentTime - clickTime;
                const eightMinutes = 8 * 60 * 1000;

                if (elapsedTime < eightMinutes) {
                    $('#run-script-btn').hide();
                    $('#loading-icon').show();

                    // Calcular el tiempo restante para mostrar el botón
                    const remainingTime = eightMinutes - elapsedTime;
                    setTimeout(function() {
                        $('#run-script-btn').show();
                        $('#loading-icon').hide();
                        localStorage.removeItem('clickTime');
                    }, remainingTime);
                } else {
                    $('#run-script-btn').show();
                    $('#loading-icon').hide();
                    localStorage.removeItem('clickTime');
                }
            }
        }

        // Ejecutar la verificación al cargar la página
        checkButtonState();

        $('#run-script-btn').click(function() {
            // Guardar el tiempo del clic en localStorage
            const clickTime = new Date().getTime();
            localStorage.setItem('clickTime', clickTime);

            // Ocultar el botón y mostrar el icono de carga
            $(this).hide();
            $('#loading-icon').show();


            // Comentar la solicitud AJAX para pruebas
            /*
            $.ajax({
                url: '/run-python-script',
                type: 'GET',
                success: function(data) {
                    console.log('Solicitud AJAX exitosa.', data);
                    if (data.success) {
                        $('#output').text(data.output);
                    } else {
                        $('#output').text('Error: ' + data.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                    $('#output').text('Error en la solicitud AJAX: ' + error);
                }
            });
            */

            // Mantener el icono de carga visible y mostrar el botón después de 8 minutos
            setTimeout(function() {
                $('#run-script-btn').show();
                $('#loading-icon').hide();
                localStorage.removeItem('clickTime');
            }, 8 * 60 * 1000); // 8 minutos en milisegundos
        });
    });
</script>
