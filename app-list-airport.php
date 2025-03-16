<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="_img/icono.png">

        <title>HR - Airport Shuttle List</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>window.jQuery || document.write(decodeURIComponent('%3Cscript src="js/jquery.min.js"%3E%3C/script%3E'))</script>
        <script src="https://unpkg.com/mustache@4.2.0/mustache.min.js"></script>
        <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/23.2.5/js/dx.all.js"></script>
        <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/23.2.5/css/dx.light.css">
        <script src="_js/app-list-airport.js"></script>
        <style>
            html{
                height: 100%;
                background-image: url('_img/bg_body_4_1.png');
                background-position: center;
                background-repeat: no-repeat;
                background-color: #05384D;
                background-size: contain;
            }
            body {                
                
                font-family: Arial, sans-serif;
                text-align: center;                
                color: white;
            }
            .container {
                margin: 20px auto;
                width: 70%;
                padding: 5px;
                border-radius: 10px;                
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
                color: white;
                background: rgba(0, 0, 0, 0.7);
            }
            th, td {
                padding: 10px;
                text-align: center;
                border-bottom: 1px solid white;
            }
            th {
                background-color: rgba(51, 51, 51, 0.7);
            }
            h1{
                color: black;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>AIRPORT SHUTTLE</h1>
            <h2><?php  date_default_timezone_set("America/Bogota"); echo date("M  d  Y");?></h2>
            <table>
                <thead>
                    <tr>
                        <th>TIME</th>
                        <th>ROOM #</th>
                        <th>DESTINATION</th>
                        <th>PASSENGERS</th>
                    </tr>
                </thead>
                <tbody class="listReservas">    
                    <script id="property-item-reservas" type="text/html">
                        <tr><td>{{ pick_up_time_format }}</td><td>{{ room_number }}</td><td>{{ destiny }}</td><td>{{ passenger }}</td></tr>
                    </script>   
                </tbody>
            </table>
        </div>
    </body>
</html>

