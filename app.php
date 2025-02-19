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
                            <h2 class="modal-title col-11 text-center">BOOKING</h2>
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
                                                            <b>{{ name }}</b>
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
                                                <div id="scheduler"></div>
                                            </div>
                                        </div>                                        
                                    </div>                                  
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div>
                                <button id="btnBackToHome" type="button" class="btn btn-sm btn-warning">
                                    <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> 
                                        <path d="M9.15722 20.7714V17.7047C9.1572 16.9246 9.79312 16.2908 10.581 16.2856H13.4671C14.2587 16.2856 14.9005 16.9209 14.9005 17.7047V17.7047V20.7809C14.9003 21.4432 15.4343 21.9845 16.103 22H18.0271C19.9451 22 21.5 20.4607 21.5 18.5618V18.5618V9.83784C21.4898 9.09083 21.1355 8.38935 20.538 7.93303L13.9577 2.6853C12.8049 1.77157 11.1662 1.77157 10.0134 2.6853L3.46203 7.94256C2.86226 8.39702 2.50739 9.09967 2.5 9.84736V18.5618C2.5 20.4607 4.05488 22 5.97291 22H7.89696C8.58235 22 9.13797 21.4499 9.13797 20.7714V20.7714" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    Home
                                </button>
                                <button id="btnRideShow" type="button" class="btn btn-sm btn-primary">
                                    <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.09277 9.40421H20.9167" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M16.442 13.3097H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M12.0045 13.3097H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M7.55818 13.3097H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M16.442 17.1962H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M12.0045 17.1962H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M7.55818 17.1962H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M16.0433 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M7.96515 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.2383 3.5791H7.77096C4.83427 3.5791 3 5.21504 3 8.22213V17.2718C3 20.3261 4.83427 21.9999 7.77096 21.9999H16.229C19.175 21.9999 21 20.3545 21 17.3474V8.22213C21.0092 5.21504 19.1842 3.5791 16.2383 3.5791Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>                            
                                    Ride
                                </button>
                            </div>
                            <div class="actions">
                                <button id="btnRideBack" type="button" class="btn btn-sm btn-warning collapse">
                                    <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2.75024C6.892 2.75024 2.75 6.89124 2.75 12.0002C2.75 17.1082 6.892 21.2502 12 21.2502C17.108 21.2502 21.25 17.1082 21.25 12.0002C21.25 6.89124 17.108 2.75024 12 2.75024Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                    <path d="M13.4424 8.52905L9.95638 12.0001L13.4424 15.4711" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>                                                    
                                    Back
                                </button>
                                <button id="btnRideNext" type="button" class="btn btn-sm btn-warning collapse">
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