<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="_img/icono.png">

        <title>HR - Booking List</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>window.jQuery || document.write(decodeURIComponent('%3Cscript src="js/jquery.min.js"%3E%3C/script%3E'))</script>
        <script src="https://unpkg.com/mustache@4.2.0/mustache.min.js"></script>
        <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/23.2.5/js/dx.all.js"></script>
        <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/23.2.5/css/dx.light.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Exportar a excel -->
      <script src="_js/web/polyfill.min.js"></script>
      <script src="_js/web/exceljs.min.js"></script>
      <script src="_js/web/FileSaver.min.js"></script>
        <script src="_js/app-list-booking.js"></script>
        <style>
            html{
                height: 100%;
            }
            body {                
                
                font-family: Arial, sans-serif;
                text-align: center;                
                color: black;
                height: 100%;
                background-image: url('_img/bg_body_4_1.png');
                background-position: center;
                background-repeat: no-repeat;
                background-color: #05384D;
                background-size: contain;
            }
            .container {
                margin: 10px auto;
                width: 100%;
                padding: 5px;
                border-radius: 10px;                
            }
            h1{
                color: black;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1><b>BOOKING</b></h1>
            <div>
                <div class="form-group row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-2">
                        <label>Start</label> 
                        <input type="date" class="form-control required" id="dtFechaInicial">
                    </div>
                    <div class="col-lg-2">
                        <label>End</label> 
                        <input type="date" class="form-control required" id="dtFechaFinal">
                    </div>
                    <div class="col-lg-1">
                        <br>
                        <button id="btnGenerar"  class="btn btn-outline-warning" >Search</button>                                                
                    </div>
                    <div class="col-lg-1">
                        <br>
                        <button id="btnExportar"  class="btn btn-outline-warning" >Export</button>                                                
                    </div>
                    <div class="col-lg-2">
                        <br>
                        <a id="btnAirportShuttleList" class="btn btn-outline-warning" href="app-list-airport" target="_blank">Airport Shuttle List</a>                                         
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-body">
                        <div id="grdDatos"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

