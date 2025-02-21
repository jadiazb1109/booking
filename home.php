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
            pick_up_time: null,
            round_trip: false,            

        }));
        localStorage.setItem("currentRideBookingTime", 0);
        location.href = "app";
    }

    if (localStorage.getItem("currentRideBooking")) {
        location.href = "app";
    }
</script>