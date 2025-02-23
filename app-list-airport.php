<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="_img/icono.png">

        <title>HR - List</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>window.jQuery || document.write(decodeURIComponent('%3Cscript src="js/jquery.min.js"%3E%3C/script%3E'))</script>
        <script src="https://unpkg.com/mustache@4.2.0/mustache.min.js"></script>
        <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/23.2.5/js/dx.all.js"></script>
        <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/23.2.5/css/dx.light.css">
        <script src="_js/app-list-airport.js"></script>
        <style>
            body {
                background-image: url('_img/ways-bg.2b326add.jpg');
                background-size: cover;
                background-position: center;
                font-family: Arial, sans-serif;
                text-align: center;
                color: white;
            }
            .container {
                margin: 50px auto;
                width: 70%;
                padding: 20px;
                border-radius: 10px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                color: white;
            }
            th, td {
                padding: 10px;
                text-align: center;
                border-bottom: 1px solid white;
            }
            th {
                background-color: rgba(51, 51, 51, 0.7);
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

