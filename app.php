<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" href="_img/icono.png">
        <title>HR - Booking</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>window.jQuery || document.write(decodeURIComponent('%3Cscript src="js/jquery.min.js"%3E%3C/script%3E'))</script>

        <script src="https://unpkg.com/mustache@4.2.0/mustache.min.js"></script>
        <script src="_js/modal/libs.min.js"></script>
        <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/23.2.5/js/dx.all.js"></script>
        <link rel="stylesheet" href="_css/modal/libs.min.css">  
        <link rel="stylesheet" href="_css/modal/hope-ui.min.css?v=4.0.0">
        <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/23.2.5/css/dx.light.css">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="_css/app.css" />
        <script src="_js/app.js"></script>
        <script src="_js/data.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        
    </head>
    <body>
        <div class="container">
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title col-12 text-center">Let’s book your ride</h2>
                        </div>
                        <div id="popup-with-scrollview"></div>
                        <div class="modal-body">
                            <div class="collapse" id="mdOrigen">
                                <div class="card">      
                                    <div class="card-header text-center">
                                        <h3>ORIGIN</h3>
                                        <hr>
                                    </div>                              
                                    <div class="card-body">
                                        <div class="card-text" id="cdOrigen">
                                            <div class="icon-grid row row-cols-xl-8 listOrigen" style="padding-left: 50px;padding-right: 50px;">
                                                <script id="property-item-origen" type="text/html">
                                                    <div class="icon-box">
                                                        <div class="icon-box btn btn-outline-warning" title="{{ notes }}" style="align-content: center;width: 100%;">
                                                            <b>{{ name }}</b><br>
                                                        </div>
                                                    </div>
                                                </script>
                                            </div>
                                        </div>                                        
                                    </div>                                  
                                </div>
                            </div>
                            <div class="collapse" id="mdServicio">
                                <div class="card">      
                                    <div class="card-header text-center">
                                        <h3>SERVICES</h3>
                                        <hr>
                                    </div>                              
                                    <div class="card-body">
                                        <div class="card-text" id="cdServicio">
                                            <div class="icon-grid row row-cols-xl-8 listServicio" style="padding-left: 50px;padding-right: 50px;">
                                                <script id="property-item-servicio" type="text/html">
                                                    <div class="icon-box">
                                                        <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                                                            <b>{{ name }}</b>
                                                        </div>
                                                    </div>
                                                </script>
                                            </div>
                                        </div>                                        
                                    </div>                                  
                                </div>
                            </div>
                            <div class="collapse" id="mdCalendario">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h3>DEPARTURE DAY</h3>
                                        <hr>
                                    </div>                              
                                    <div class="card-body">
                                        <div class="card-text" id="cdCalendario">
                                            <div class="icon-grid row row-cols-xl-8 listCalendario" style="padding-left: 50px;padding-right: 50px;">
                                                <div id="calendar"></div>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" id="mdDestino">
                                <div class="card">      
                                    <div class="card-header text-center">
                                        <h3 id="hMdDestino">CRUISE</h3>
                                        <hr>
                                    </div>                              
                                    <div class="card-body">
                                        <div class="card-text" id="cdDestino">
                                            <div class="icon-grid row row-cols-xl-8 listDestino" style="padding-left: 50px;padding-right: 50px;">
                                                <script id="property-item-destino" type="text/html">
                                                    <div class="icon-box">
                                                        <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                                                            <b>{{ destiny }}</b>
                                                        </div>
                                                    </div>
                                                </script>
                                            </div>
                                        </div>                                        
                                    </div>                                  
                                </div>
                            </div>
                            <div class="collapse" id="mdDestinoGrupo">
                                <div class="card">      
                                    <div class="card-header text-center">
                                        <h3>SELECT DESTINATION</h3>
                                        <hr>
                                    </div>                              
                                    <div class="card-body">
                                        <div class="card-text" id="cdDestinoGrupo">
                                            <div class="icon-grid row row-cols-xl-8 listDestinoGrupo" style="padding-left: 50px;padding-right: 50px;">
                                                <script id="property-item-destino-grupo" type="text/html">
                                                    <div class="icon-box">
                                                        <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                                                            <b>{{ destiny }}</b>
                                                        </div>
                                                    </div>
                                                </script>
                                            </div>
                                        </div>                                        
                                    </div>                                  
                                </div>
                            </div>
                            <div class="collapse" id="mdInformacionImportante">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h3>IMPORTANT INFORMATION</h3>
                                        <hr>
                                    </div>                              
                                    <div class="card-body">
                                        <div class="card-text" id="cdInformacionImportante">
                                            <div class="icon-grid row row-cols-xl-8 listInformacionImportante" style="padding-left: 50px;padding-right: 50px;">
                                                <div class="row">
                                                    <p class="text-center class-p">THE COST PER PERSON IS ADULTS AND KIDS</p>
                                                    <p class="class-p" id="pInformacionImportante">
                                                        HERE IMPORTANT INFORMATION
                                                    </p>                                   
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>                                  
                                </div>
                            </div>
                            <div class="collapse" id="mdInformacionTerminos">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h3>IMPORTANT INFORMATION</h3>
                                        <hr>
                                    </div>                              
                                    <div class="card-body">
                                        <div class="card-text" id="cdInformacionTerminos">
                                            <div class="icon-grid row row-cols-xl-8 listInformacionTerminos" style="padding-left: 50px;padding-right: 50px;">
                                                <div class="row">
                                                    <p class="text-center class-p"><b>TERMS AND CONDITIONS – WAIVER</b></p>
                                                    <p class="text-center class-p"><b>WAIVER, INDEMNITY, AND RELEASE OF LIABILITY</b></p>
                                                    <p class="class-p" id="pInformacionTerminos">
                                                        HERE TERMS AND CONDITIONS
                                                    </p>                                  
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>                                  
                                </div>
                            </div>
                            <div class="collapse" id="mdPasajeroGrupo">
                                <div class="card">      
                                    <div class="card-header text-center">
                                        <h3>NUMBER OF PASSENGERS</h3>
                                        <hr>
                                    </div>                              
                                    <div class="card-body">
                                        <div class="card-text" id="cdPasajeroGrupo">
                                            <div class="icon-grid row row-cols-xl-8 listPasajeroGrupo" style="padding-left: 50px;padding-right: 50px;">
                                                <script id="property-item-pasajero-grupo" type="text/html">
                                                    <div class="icon-box">
                                                        <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                                                            <b>
                                                                {{ passenger_min }} - {{ passenger_max }} PASSENGERS <br>
                                                                $ {{ price }} ONE WAY
                                                            </b>
                                                        </div>
                                                    </div>
                                                </script>
                                            </div>
                                        </div>                                        
                                    </div>                                  
                                </div>
                            </div>
                            <div class="collapse" id="mdPasajero">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h3>NUMBER OF PASSENGERS</h3>
                                        <hr>
                                    </div>                              
                                    <div class="card-body">
                                        <div class="card-text" id="cdPasajero">
                                            <div class="icon-grid row row-cols-xl-8 listPasajero" style="padding-left: 50px;padding-right: 50px;">
                                                <div class="row">
                                                    <div class="col-md-5" style="display: flex; justify-content: flex-end">
                                                        <button type="button" value="-" id="btnDecrementar" class="btn btn-sm btn-outline-warning" >
                                                            <svg class="icon-64" width="100" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7366 2.76176H8.08455C6.00455 2.75276 4.29955 4.41076 4.25055 6.49076V17.3398C4.21555 19.3898 5.84855 21.0808 7.89955 21.1168C7.96055 21.1168 8.02255 21.1168 8.08455 21.1148H16.0726C18.1416 21.0938 19.8056 19.4088 19.8026 17.3398V8.03976L14.7366 2.76176Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M14.4731 2.75V5.659C14.4731 7.079 15.6221 8.23 17.0421 8.234H19.7961" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M14.2926 13.7471H9.39258" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>                            
                                                        </button>
                                                    </div>
                                                    <div class="col-md-2 text-center">
                                                        <h1 id="txtPassengerQty" style="font-size: 7rem;">0</h1>
                                                    </div>
                                                    <div class="col-md-5" style="display: flex;">
                                                        <button type="button" id="btnIncrementar" class="btn btn-sm btn-outline-warning">
                                                            <svg class="icon-64" width="100" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M12.0001 8.32739V15.6537" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M15.6668 11.9904H8.3335" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.6857 2H7.31429C4.04762 2 2 4.31208 2 7.58516V16.4148C2 19.6879 4.0381 22 7.31429 22H16.6857C19.9619 22 22 19.6879 22 16.4148V7.58516C22 4.31208 19.9619 2 16.6857 2Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>                            
                                                        </button>
                                                    </div>                                                
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>                                  
                                </div>
                            </div>
                            <div class="collapse" id="mdRecogida">
                                <div class="card">      
                                    <div class="card-header text-center">
                                        <h3>PICK UP TIME</h3>
                                        <hr>
                                    </div>                              
                                    <div class="card-body">
                                        <div class="card-text" id="cdRecogida">
                                            <div class="icon-grid row row-cols-xl-8 listRecogida" style="padding-left: 50px;padding-right: 50px;">
                                                <script id="property-item-recogida" type="text/html">
                                                    <div class="icon-box">
                                                        <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                                                            <b>{{ time_format }}</b>
                                                        </div>
                                                    </div>
                                                </script>
                                            </div>
                                        </div>                                        
                                    </div>                                  
                                </div>
                            </div>
                            <div class="collapse" id="mdRegreso">
                                <div class="card">      
                                    <div class="card-header text-center">
                                        <h3>DO YOU NEED A RETURN RIDE AFTER THE CRUISE?</h3>
                                        <hr>
                                    </div>                              
                                    <div class="card-body">
                                        <div class="card-text" id="cdRegreso">
                                            <div class="icon-grid row row-cols-xl-8 listRegreso" style="padding-left: 50px;padding-right: 50px;">
                                                <script id="property-item-regreso" type="text/html">
                                                    <div class="icon-box">
                                                        <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                                                            <b>{{ option }}</b>
                                                        </div>
                                                    </div>
                                                </script>
                                            </div>
                                        </div>                                        
                                    </div>                                  
                                </div>
                            </div>
                            <div class="collapse" id="mdCalendarioRegreso">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h3>RETURN DAY</h3>
                                        <hr>
                                    </div>                              
                                    <div class="card-body">
                                        <div class="card-text" id="cdCalendarioRegreso">
                                            <div class="icon-grid row row-cols-xl-8 listCalendarioRegreso" style="padding-left: 50px;padding-right: 50px;">
                                                <div id="calendarReturn"></div>
                                            </div>
                                        </div>                                        
                                    </div>                                  
                                </div>
                            </div>
                            <div class="collapse" id="mdRecogidaRegreso">
                                <div class="card">      
                                    <div class="card-header text-center">
                                        <h3>PICK UP TIME RETURN</h3>
                                        <hr>
                                    </div>                              
                                    <div class="card-body">
                                        <div class="card-text" id="cdRecogidaRegreso">
                                            <div class="icon-grid row row-cols-xl-8 listRecogidaRegreso" style="padding-left: 50px;padding-right: 50px;">
                                                <script id="property-item-recogidaRegreso" type="text/html">
                                                    <div class="icon-box">
                                                        <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                                                            <b>{{ time_format }}</b>
                                                        </div>
                                                    </div>
                                                </script>
                                            </div>
                                        </div>                                        
                                    </div>                                  
                                </div>
                            </div>
                            <div class="collapse" id="mdInformacionHabitacion">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h3>ROOM INFORMATION</h3>
                                        <hr>
                                    </div>                              
                                    <div class="card-body">
                                        <div class="card-text" id="cdInformacionHabitacion">
                                            <div class="icon-grid row row-cols-xl-8 listInformacionHabitacion" style="padding-left: 50px;padding-right: 50px;">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="form-label" for="txtRoomNumber"><strong>Room Number</strong></label>
                                                        <input type="text" class="form-control" id="txtRoomNumber" placeholder="Enter your room number">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label" for="txtNameA"><strong>Name</strong></label>
                                                        <input type="text" class="form-control" id="txtNameA" placeholder="Enter your name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label" for="txtPhoneA"><strong>Phone</strong></label>
                                                        <input type="text" class="form-control" id="txtPhoneA" placeholder="Enter your phone">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label" for="txtEmailA"><strong>Email</strong></label>
                                                        <input type="email" class="form-control" id="txtEmailA" placeholder="Enter your email">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group text-center row row-cols-xl-8" style="padding-left: 50px;padding-right: 40px;">
                                                        <button id="btnBookingAirport" type="button" class="btn btn-success">Booking Ride</button>
                                                    </div>                                          
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>                                  
                                </div>
                            </div>
                            <div class="collapse" id="mdInformacionContacto">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h3>CONTACT INFORMATION</h3>
                                        <hr>
                                    </div>                              
                                    <div class="card-body">
                                        <div class="card-text" id="cdInformacionContacto">
                                            <div class="icon-grid row row-cols-xl-8 listInformacionContacto" style="padding-left: 50px;padding-right: 50px;">
                                                <div class="row">
                                                    <div class="form-group collapse" id="divNameDistiny">
                                                        <label class="form-label" for="txtName" id="lblNameDestiny"><strong>Name</strong></label>
                                                        <input type="text" class="form-control" id="txtNameDestiny" placeholder="Enter your destiny">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label" for="txtName"><strong>Name</strong></label>
                                                        <input type="text" class="form-control" id="txtName" placeholder="Enter your name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label" for="txtPhone"><strong>Phone</strong></label>
                                                        <input type="text" class="form-control" id="txtPhone" placeholder="Enter your phone">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label" for="txtEmail"><strong>Email</strong></label>
                                                        <input type="email" class="form-control" id="txtEmail" placeholder="Enter your email">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>                                  
                                </div>
                            </div>
                            <div class="collapse" id="mdInformacionTarjeta">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h3>CARD INFORMATION</h3>
                                        <hr>
                                    </div>                              
                                    <div class="card-body">
                                        <div class="card-text" id="cdInformacionTarjeta">
                                            <div class="icon-grid row row-cols-xl-8 listInformacionTarjeta" style="padding-left: 50px;padding-right: 50px;">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="form-label" for="txtCardNumber"><strong>Card Number</strong></label>
                                                        <input type="text" class="form-control" id="txtCardNumber" placeholder="Enter your card number">
                                                    </div>                                         
                                                </div>
                                                <div class="row">
                                                    <div class="form-group text-center row row-cols-xl-8" style="padding-left: 50px;padding-right: 40px;">
                                                        <button id="btnPay" type="button" class="btn btn-success">PAY </button>
                                                    </div>                                          
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>                                  
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div>
                                <button id="btnBackToHome" type="button" class="btn btn-sm btn-outline-danger">
                                    <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> 
                                        <path d="M9.15722 20.7714V17.7047C9.1572 16.9246 9.79312 16.2908 10.581 16.2856H13.4671C14.2587 16.2856 14.9005 16.9209 14.9005 17.7047V17.7047V20.7809C14.9003 21.4432 15.4343 21.9845 16.103 22H18.0271C19.9451 22 21.5 20.4607 21.5 18.5618V18.5618V9.83784C21.4898 9.09083 21.1355 8.38935 20.538 7.93303L13.9577 2.6853C12.8049 1.77157 11.1662 1.77157 10.0134 2.6853L3.46203 7.94256C2.86226 8.39702 2.50739 9.09967 2.5 9.84736V18.5618C2.5 20.4607 4.05488 22 5.97291 22H7.89696C8.58235 22 9.13797 21.4499 9.13797 20.7714V20.7714" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    Home
                                </button>
                                <button id="btnRideShow" type="button" class="btn btn-sm btn-outline-warning">
                                    <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.09277 9.40421H20.9167" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M16.442 13.3097H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M12.0045 13.3097H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M7.55818 13.3097H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M16.442 17.1962H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M12.0045 17.1962H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M7.55818 17.1962H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M16.0433 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M7.96515 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.2383 3.5791H7.77096C4.83427 3.5791 3 5.21504 3 8.22213V17.2718C3 20.3261 4.83427 21.9999 7.77096 21.9999H16.229C19.175 21.9999 21 20.3545 21 17.3474V8.22213C21.0092 5.21504 19.1842 3.5791 16.2383 3.5791Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>                            
                                    Ride
                                </button>
                            </div>
                            <div class="actions">
                                <button id="btnRideBack" type="button" class="btn btn-sm btn-outline-warning collapse">
                                    <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2.75024C6.892 2.75024 2.75 6.89124 2.75 12.0002C2.75 17.1082 6.892 21.2502 12 21.2502C17.108 21.2502 21.25 17.1082 21.25 12.0002C21.25 6.89124 17.108 2.75024 12 2.75024Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M13.4424 8.52905L9.95638 12.0001L13.4424 15.4711" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>                                                    
                                    Back
                                </button>
                                <button id="btnRideNext" type="button" class="btn btn-sm btn-outline-warning collapse">
                                    Next
                                    <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21.2498C17.108 21.2498 21.25 17.1088 21.25 11.9998C21.25 6.89176 17.108 2.74976 12 2.74976C6.892 2.74976 2.75 6.89176 2.75 11.9998C2.75 17.1088 6.892 21.2498 12 21.2498Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M10.5576 15.4709L14.0436 11.9999L10.5576 8.52895" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>                                                    
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
        <script>
            $(document).ready(function() {
                $('#staticBackdrop').modal('show');
            });
        </script>
    </body>
</html>