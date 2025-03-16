document.addEventListener('DOMContentLoaded', () => {

    setInterval(function() { reload() }, 5000);

    reload();

    function reload() {
        $.ajax({
            url: "api/v1/general/listBooking/type/2",
            type: "GET",
            crossDomain: true,
            dataType: 'json',
            error: function() { 
                mtdMostrarMensaje("Could not complete request to server", "warning");               }
        }).done((resultado) => {
            if (resultado["state"] === 'ok') {
                if (resultado["data"].length == 0) {
                    mtdMostrarMensaje(resultado["message"], "warning"); 
                }
    
                $('.listReservas').html(`                    
                    <script id="property-item-reservas" type="text/html">
                        <tr><td>{{ pick_up_time_format }}</td><td>{{ room_number }}</td><td>{{ destiny }}</td><td>{{ passenger }}</td></tr>
                    </script> 
                `);
    
                $.each(resultado["data"], (index, item) => {
    
                    const template = $(Mustache.render($('#property-item-reservas').html(), item));
                
                    $('.listReservas').append(template);
                });
            }
            if (resultado["state"] === 'ko') {
                mtdMostrarMensaje(resultado["message"], "error");
            }
        });
    }

    function mtdMostrarMensaje(mensaje, tipo = "success", time = 3000) {

        let direction = "up-push";
        let position = "bottom right";
    
        DevExpress.ui.notify({
            message: mensaje,
            width: 400,
            type: tipo,
            displayTime: time,
        }, {
            position,
            direction
        });
    }

});