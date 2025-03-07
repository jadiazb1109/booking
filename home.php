<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="_img/icono.png">

        <title>HR - Home</title>

        <!-- Bootstrap core CSS -->
        <link href="_css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/node-uuid/1.4.7/uuid.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>window.jQuery || document.write(decodeURIComponent('%3Cscript src="js/jquery.min.js"%3E%3C/script%3E'))</script>

        <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/23.2.5/js/dx.all.js"></script>
        <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/23.2.5/css/dx.light.css">

        <!-- Custom styles for this template -->
        <link href="_css/index.css" rel="stylesheet">
    </head>

    <body class="text-center">
        <div class="cover-container d-flex h-100 p-3 mx-auto flex-column" id="btnBookRide" style="cursor: pointer;">
            <header class="masthead mb-auto">
                <div class="inner">
                    <h3 class="masthead-brand"></h3>
                </div>
            </header>

            <main role="main" class="inner cover">
            </main>

            <footer class="mastfoot mt-auto">
                <div class="inner">
                    <p>All rights reserved &copy; ORBE, INC.</p>
                </div>
            </footer>
        </div>
    </body>
</html>

<script>
    const btnBookRide = document.getElementById('btnBookRide');

    btnBookRide.addEventListener('click', btnBookRideClick);

    function btnBookRideClick(e) {
        e.preventDefault();   
        localStorage.setItem("currentRideBooking", JSON.stringify({
            uuid: uuid.v4(),
            current_step: "mdOrigen",
            steps: [],
            origin: null,
            service: null,
            destiny: null,
            date: null,
            passenger_qty: null,
            passenger_group: null,
            pick_up_time: null,
            room_number: null,
            return: null,            
            client: null,
            pay: null,
            state: null
        }));
        localStorage.setItem("currentRideBookingTime", 0);
        location.href = "app";
    }

    document.addEventListener('DOMContentLoaded', () => {

        if (localStorage.getItem("currentRideBooking")) {

            if (JSON.parse(localStorage.getItem("currentRideBooking")).state) {
                mtdMostrarMensaje("successful booking");
                localStorage.removeItem("currentRideBooking");
            }else{
                location.href = "app";
            }            
        }        

        function mtdMostrarMensaje(mensaje, tipo = "success", time = 3000) {
            let direction = "up-push";
            let position = "top center";

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
</script>