
<script>
    // Función para calcular el tiempo restante hasta la próxima hora en punto y 7 minutos
    const getTimeToNextHourPlusSeven = () => {
        const now = new Date();
        let nextHourPlusSeven;

        if (now.getMinutes() < 7) {
            nextHourPlusSeven = new Date(now.getFullYear(), now.getMonth(), now.getDate(), now.getHours(), 7, 0, 0);
        } else {
            nextHourPlusSeven = new Date(now.getFullYear(), now.getMonth(), now.getDate(), now.getHours() + 7, 7, 0,
                0);
        }

        return nextHourPlusSeven - now;
    };

    // Función para redirigir al dashboard
    const redirectToDashboard = () => {
        window.location.href = '/dashboard'; // Cambia '/dashboard' a la URL de tu dashboard si es diferente
    };

    // Función para recargar la página y luego redirigir al dashboard
    const refreshAndRedirectToDashboard = () => {
        const timeToNextHourPlusSeven = getTimeToNextHourPlusSeven();

        setTimeout(() => {
            redirectToDashboard();
            // Configurar un temporizador para redirigir al dashboard cada hora después de la redirección inicial
            setInterval(() => {
                redirectToDashboard();
            }, 3600000); // 3600000 ms = 1 hora
        }, timeToNextHourPlusSeven);
    };

    // Llamar a la función para iniciar el proceso
    refreshAndRedirectToDashboard();
</script>
