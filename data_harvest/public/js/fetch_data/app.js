$(document).ready(function() {
    $('#loadData').click(function(e) {
        e.preventDefault();
        $('#loadingIcon').show();
        requestData();
    });

    function requestData() {
        $.get('{{ route("getWatches") }}', function(response) {
            if (response instanceof Array && response.length > 0) {
                // Si la respuesta es una lista de relojes, renderízala
                renderData(response);
            } else if ('error' in response) {
                // Si la respuesta contiene un mensaje de error, muéstralo en la consola y espera antes de intentar nuevamente
                console.error('Error:', response.error);
            } else {
                // Si la respuesta no es válida o no hay datos, muestra un mensaje de error genérico
                console.error('Respuesta no válida:', response);
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            // Muestra un mensaje de error en la consola en caso de error de la solicitud AJAX
            console.error('Error de solicitud:', textStatus, errorThrown);
        }).always(function() {
            // Oculta el icono de carga después de realizar la solicitud
            $('#loadingIcon').hide();
        });
    }

    // Función para mostrar los datos en el contenedor
    function renderData(watches) {
        // Limpiar el contenido anterior
        $('#dataContainer').empty();

        // Iterar sobre los relojes y mostrarlos como tarjetas
        watches.forEach(function(watch) {
            var cardHtml = `
                <div class="card mb-3 row row-cols-4">
                    <div class="card-body col">
                        <h5 class="card-title">${watch.brand}</h5>
                        <p class="card-text">Precio: ${watch.price}</p>
                        <p class="card-text">Tamaño: ${watch.size}</p>
                        <p class="card-text">Ubicación: ${watch.location}</p>
                        <p class="card-text">Vistas: ${watch.views}</p>
                        <p class="card-text">Personas interesadas: ${watch.interested_people}</p>
                        <a href="${watch.url}" class="btn btn-primary" target="_blank">Ver más</a>
                    </div>
                </div>
            `;
            $('#dataContainer').append(cardHtml);
        });

        // Mostrar los datos en el contenedor
        $('#dataContainer').show();
    }
});
