$(() => {
  document.onmousemove = function(){     
    if (localStorage.getItem("currentRideBookingTime") > 10) {
      localStorage.setItem("currentRideBookingTime", 90);
    }
  }

  var cuerrentRide = {};

  function getDataCurrentRideBooking() {
    cuerrentRide = JSON.parse(localStorage.getItem("currentRideBooking"));
    return cuerrentRide;
  }

  function setDataCurrentRideBooking(cuerrentRide) {
    localStorage.setItem("currentRideBooking", JSON.stringify(cuerrentRide));
  }

  const mdOrigen = document.getElementById('mdOrigen');
  const mdServicio = document.getElementById('mdServicio');
  const mdCalendario = document.getElementById('mdCalendario');
  const mdDestino = document.getElementById('mdDestino');
  const mdDestinoGrupo = document.getElementById('mdDestinoGrupo');
  const mdInformacionImportante = document.getElementById('mdInformacionImportante');
  const mdInformacionTerminos = document.getElementById('mdInformacionTerminos');
  const pInformacionImportante = document.getElementById('pInformacionImportante');
  const pInformacionTerminos = document.getElementById('pInformacionTerminos');
  const mdPasajero = document.getElementById('mdPasajero');
  const mdPasajeroGrupo = document.getElementById('mdPasajeroGrupo');
  const mdRecogida = document.getElementById('mdRecogida');
  const mdRegreso = document.getElementById('mdRegreso');
  const mdCalendarioRegreso = document.getElementById('mdCalendarioRegreso');
  const mdRecogidaRegreso = document.getElementById('mdRecogidaRegreso');
  const mdInformacionHabitacion = document.getElementById('mdInformacionHabitacion');
  const mdInformacionContacto = document.getElementById('mdInformacionContacto');
  const mdInformacionTarjeta = document.getElementById('mdInformacionTarjeta');

  const hMdDestino = document.getElementById('hMdDestino');
  const btnBackToHome = document.getElementById('btnBackToHome');
  const btnRideShow = document.getElementById('btnRideShow');
  const btnRideBack = document.getElementById('btnRideBack');
  const btnRideNext = document.getElementById('btnRideNext');

  if(getDataCurrentRideBooking()){   
    mdOrigen.classList.remove("collapse");
  }else{
    location.href = "home";
  }

  var aviso = false;
  setInterval(function() {
    var time_sesion = localStorage.getItem("currentRideBookingTime");   

    if(time_sesion < 11){

      if(!aviso){
        var confirm = DevExpress.ui.dialog.confirm('<div class="text-center"><i>Due to inactivity. <br>You will be redirected back home in <br> <b id="divCounter" style="font-size: 35px;">10</b><br> seconds</div></i>', "Are you still there?");
        aviso = true;
        const divCounter = document.getElementById('divCounter');
        confirm.done((dialogResult) => {
            if (dialogResult) {
              localStorage.setItem("currentRideBookingTime", 90);
              aviso = false;
            }else{
              localStorage.removeItem("currentRideBooking");
              location.href = "home";
            }
        });

      }else{

        divCounter.textContent = time_sesion;

        if (time_sesion == 0) {
          localStorage.removeItem("currentRideBooking");
          location.href = "home";
        }
      }

      localStorage.setItem("currentRideBookingTime", (time_sesion * 1) - 1);      

    }else{
      localStorage.setItem("currentRideBookingTime", (time_sesion * 1) - 1);
    }
  }, 1000);

  btnBackToHome.addEventListener('click', btnBackToHomeClick);
  function btnBackToHomeClick(e) {
      e.preventDefault();   
      var confirm = DevExpress.ui.dialog.confirm("<i>Do you want to go out?</i>", "Exit");

      confirm.done((dialogResult) => {
          if (dialogResult) {
            localStorage.removeItem("currentRideBooking");
            location.href = "home";
          }
      }); 
  }

  btnRideBack.addEventListener('click', btnRideBackClick);
  function btnRideBackClick(e) {
      e.preventDefault(); 

      let elementByIdStep = cuerrentRide.steps[cuerrentRide.steps.length - 1]
      let elementByIdStepCurrent = cuerrentRide.current_step;
      $('#'+elementByIdStep).removeClass("collapse");
      $('#'+elementByIdStepCurrent).addClass("collapse");

      cuerrentRide.current_step = elementByIdStep;
      cuerrentRide.steps.pop();
      setDataCurrentRideBooking(cuerrentRide);

      if(cuerrentRide.current_step == "mdOrigen"){
        btnRideBack.classList.add("collapse");  
        $('.listServicio').html(`                    
          <script id="property-item-servicio" type="text/html">
              <div class="icon-box">
                  <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                      <b>{{ name }}</b>
                  </div>
              </div>
          </script>
      `);   
      }

      if(cuerrentRide.current_step == "mdServicio"){
        btnRideNext.classList.add("collapse");    
        if(elementByIdStepCurrent == "mdDestinoGrupo"){
          $('.listDestinoGrupo').html(`                    
            <script id="property-item-destino-grupo" type="text/html">
                <div class="icon-box">
                    <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                        <b>{{ destiny }}</b>
                    </div>
                </div>
            </script>
          `);
        }
      }

      if(cuerrentRide.current_step == "mdCalendario" && (cuerrentRide.service.type_id == 1 || cuerrentRide.service.type_id == 2 || cuerrentRide.service.type_id == 3)){
        btnRideNext.classList.remove("collapse");    
        $('.listDestino').html(`                    
          <script id="property-item-destino" type="text/html">
              <div class="icon-box">
                  <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                      <b>{{ destiny }}</b>
                  </div>
              </div>
          </script>
      `);
      }

      if(cuerrentRide.current_step == "mdCalendario" && cuerrentRide.service.type_id == 4){
        btnRideNext.classList.remove("collapse");    
        $('.listPasajeroGrupo').html(`                    
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
      `);
      }

      if(cuerrentRide.current_step == "mdDestino" || cuerrentRide.current_step == "mdDestinoGrupo"){
        btnRideNext.classList.add("collapse");    
      }

      if(cuerrentRide.current_step == "mdPasajero"){
        btnRideNext.classList.remove("collapse"); 
        $('.listRecogida').html(`                    
          <script id="property-item-recogida" type="text/html">
              <div class="icon-box">
                  <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                      <b>{{ time_format }}</b>
                  </div>
              </div>
          </script>
      `);   
      }

      if(cuerrentRide.current_step == "mdRecogida"){  
        btnRideNext.classList.add("collapse");
      }

      if(cuerrentRide.current_step == "mdRegreso"){  
        btnRideNext.classList.add("collapse"); 
      }

      if(cuerrentRide.current_step == "mdCalendarioRegreso"){  
        btnRideNext.classList.remove("collapse"); 
        $('.listRecogidaRegreso').html(`                    
            <script id="property-item-recogidaRegreso" type="text/html">
                <div class="icon-box">
                    <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                        <b>{{ time_format }}</b>
                    </div>
                </div>
            </script>
        `);
      }

      if(cuerrentRide.current_step == "mdRecogidaRegreso"){  
        btnRideNext.classList.add("collapse");
      }

      if(cuerrentRide.current_step == "mdInformacionContacto"){ 
        btnRideNext.classList.remove("collapse"); 
      }
  }

  DevExpress.setTemplateEngine({
    compile: (element) => $(element).html(),
    render: (template, data) => Mustache.render(template, data),
  });


  $.ajax({
    url: "api/v1/general/originActive",
    type: "GET",
    crossDomain: true,
    dataType: 'json',
    error: function() { 
        mtdMostrarMensaje("Could not complete request to server", "warning");     }
  }).done((resultado) => {
      if (resultado["state"] === 'ok') {
        $.each(resultado["data"], (index, origin) => {
          const template = $(Mustache.render($('#property-item-origen').html(), origin));
      
          template.find('.icon-box').on('dxclick', () => {
            cuerrentRide.steps = [];
            cuerrentRide.steps.push("mdOrigen");
            cuerrentRide.origin = origin;
            cuerrentRide.service= null,
            cuerrentRide.destiny= null,
            cuerrentRide.date= null,
            cuerrentRide.passenger_qty= null,
            cuerrentRide.passenger_group =null,
            cuerrentRide.pick_up_time= null,
            cuerrentRide.return= null,            
            cuerrentRide.client= null,
            cuerrentRide.room_number= null,
            txtPassengerQty.textContent = 0;
            items = 0;
            cuerrentRide.current_step = "mdServicio",
            setDataCurrentRideBooking(cuerrentRide);
            btnRideBack.classList.remove("collapse");
            mdOrigen.classList.add("collapse");
            mdServicio.classList.remove("collapse");

            $.ajax({
              url: "api/v1/general/serviceActive/origin/" + cuerrentRide.origin.id,
              type: "GET",
              crossDomain: true,
              dataType: 'json',
              error: function() { 
                  mtdMostrarMensaje("Could not complete request to server", "warning");               }
            }).done((resultado) => {
                if (resultado["state"] === 'ok') {
                  if (resultado["data"].length == 0) {
                    mtdMostrarMensaje(resultado["message"], "warning"); 
                  
                    $('.listServicio').html(`                    
                        <script id="property-item-servicio" type="text/html">
                            <div class="icon-box">
                                <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                                    <b>{{ name }}</b>
                                </div>
                            </div>
                        </script>
                    `);
                  }
                  $.each(resultado["data"], (index, service) => {
                    const template = $(Mustache.render($('#property-item-servicio').html(), service));
                
                    template.find('.icon-box').on('dxclick', () => {
                      cuerrentRide.steps.push("mdServicio");
                      cuerrentRide.service = service;
                      cuerrentRide.passenger_qty= null,
                      cuerrentRide.passenger_group =null,
                      cuerrentRide.room_number= null,
                      txtPassengerQty.textContent = 0;
                      items = 0;                      

                      if(service.type_id == 1 || service.type_id == 2 || service.type_id == 3){
                        cuerrentRide.current_step = "mdCalendario";
                        setDataCurrentRideBooking(cuerrentRide);
                        btnRideBack.classList.remove("collapse");
                        mdServicio.classList.add("collapse");
                        mdCalendario.classList.remove("collapse");
                        btnRideNext.classList.remove("collapse");
                      }    
                      if(service.type_id == 4){
                        cuerrentRide.current_step = "mdDestinoGrupo";
                        setDataCurrentRideBooking(cuerrentRide);
                        btnRideBack.classList.remove("collapse");
                        mdServicio.classList.add("collapse");
                        mdDestinoGrupo.classList.remove("collapse");
                        btnRideNext.classList.add("collapse");

                        $.ajax({
                          url: "api/v1/general/destinyUnionActive/service/" + cuerrentRide.service.id + "/date/null",
                          type: "GET",
                          crossDomain: true,
                          dataType: 'json',
                          error: function() { 
                              mtdMostrarMensaje("Could not complete request to server", "warning");               }
                        }).done((resultado) => {
                            if (resultado["state"] === 'ok') {
                              if (resultado["data"].length == 0) {
                                mtdMostrarMensaje(resultado["message"], "warning"); 
                              
                                $('.listDestinoGrupo').html(`                    
                                    <script id="property-item-destino-grupo" type="text/html">
                                        <div class="icon-box">
                                            <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                                                <b>{{ destiny }}</b>
                                            </div>
                                        </div>
                                    </script>
                                `);
                              }
                              $.each(resultado["data"], (index, destiny) => {
                                const template = $(Mustache.render($('#property-item-destino-grupo').html(), destiny));
                            
                                template.find('.icon-box').on('dxclick', () => {
                
                                  cuerrentRide.steps.push("mdDestinoGrupo");
                                  cuerrentRide.destiny = destiny;
                                  cuerrentRide.current_step = "mdCalendario";
                                  setDataCurrentRideBooking(cuerrentRide);
                                  btnRideBack.classList.remove("collapse");
                                  mdDestinoGrupo.classList.add("collapse");
                                  mdCalendario.classList.remove("collapse");
                                  btnRideNext.classList.remove("collapse");
                                  txtNameDestiny.value = null;
                                });
                            
                                $('.listDestinoGrupo').append(template);
                              });
                            }
                            if (resultado["state"] === 'ko') {
                                mtdMostrarMensaje(resultado["message"], "error");
                            }
                        });
                      }                     
                    });
                
                    $('.listServicio').append(template);
                  });
                }
                if (resultado["state"] === 'ko') {
                    mtdMostrarMensaje(resultado["message"], "error");
                }
            });


          });
      
          $('.listOrigen').append(template);
        });
      }
      if (resultado["state"] === 'ko') {
          mtdMostrarMensaje(resultado["message"], "error");
      }
  });

  const calendar = $('#calendar').dxCalendar({
    value: new Date(),
    disabled: false,
    firstDayOfWeek: 0,
    showWeekNumbers: false,
    weekNumberRule: 'auto',
    zoomLevel: 'month',
    min:new Date(),
  }).dxCalendar('instance');

  const calendarReturn = $('#calendarReturn').dxCalendar({
    value: new Date(),
    disabled: false,
    firstDayOfWeek: 0,
    showWeekNumbers: false,
    weekNumberRule: 'auto',
    zoomLevel: 'month',
    min:new Date(),
  }).dxCalendar('instance');

  const calendarGrupo = $('#calendarGrupo').dxCalendar({
    value: new Date(),
    disabled: false,
    firstDayOfWeek: 0,
    showWeekNumbers: false,
    weekNumberRule: 'auto',
    zoomLevel: 'month',
    min:new Date(),
  }).dxCalendar('instance');


  const divNameDistiny = document.getElementById("divNameDistiny");
  const lblNameDestiny = document.getElementById("lblNameDestiny");
  const txtNameDestiny = document.getElementById("txtNameDestiny");
  const txtName = document.getElementById("txtName");
  const txtPhone = document.getElementById("txtPhone");
  const txtEmail = document.getElementById("txtEmail");

  btnRideNext.addEventListener('click', btnRideNextClick);
  function btnRideNextClick(e) {
      e.preventDefault();   

      if(cuerrentRide.current_step == "mdCalendario" && cuerrentRide.service.type_id == 1){
        
        hMdDestino.textContent = "CRUISE";
        let departureSelect = fnFechaFormatear(calendar.option('value'));
        
        cuerrentRide.steps.push("mdCalendario");      
        cuerrentRide.date = departureSelect;
        cuerrentRide.current_step = "mdDestino";
        setDataCurrentRideBooking(cuerrentRide);
        btnRideBack.classList.remove("collapse");
        mdCalendario.classList.add("collapse");
        mdDestino.classList.remove("collapse");
        btnRideNext.classList.add("collapse");
        
        $.ajax({
          url: "api/v1/general/destinyUnionActive/service/" + cuerrentRide.service.id + "/date/" + departureSelect,
          type: "GET",
          crossDomain: true,
          dataType: 'json',
          error: function() { 
              mtdMostrarMensaje("Could not complete request to server", "warning");               }
        }).done((resultado) => {
            if (resultado["state"] === 'ok') {
              if (resultado["data"].length == 0) {
                mtdMostrarMensaje(resultado["message"], "warning"); 
              
                $('.listDestino').html(`                    
                    <script id="property-item-destino" type="text/html">
                        <div class="icon-box">
                            <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                                <b>{{ destiny }}</b>
                            </div>
                        </div>
                    </script>
                `);
              }
              $.each(resultado["data"], (index, destiny) => {
                const template = $(Mustache.render($('#property-item-destino').html(), destiny));
            
                template.find('.icon-box').on('dxclick', () => {

                  cuerrentRide.steps.push("mdDestino");
                  cuerrentRide.destiny = destiny;
                  cuerrentRide.current_step = "mdPasajero";
                  setDataCurrentRideBooking(cuerrentRide);
                  btnRideBack.classList.remove("collapse");
                  mdDestino.classList.add("collapse");
                  mdPasajero.classList.remove("collapse");
                  btnRideNext.classList.remove("collapse");
                });
            
                $('.listDestino').append(template);
              });
            }
            if (resultado["state"] === 'ko') {
                mtdMostrarMensaje(resultado["message"], "error");
            }
        });
      }

      if(cuerrentRide.current_step == "mdCalendario" && cuerrentRide.service.type_id == 2){

        hMdDestino.textContent = "AIRLINE";
        let departureSelect = fnFechaFormatear(calendar.option('value'));
        
        cuerrentRide.steps.push("mdCalendario");      
        cuerrentRide.date = departureSelect;
        cuerrentRide.current_step = "mdDestino";
        setDataCurrentRideBooking(cuerrentRide);
        btnRideBack.classList.remove("collapse");
        mdCalendario.classList.add("collapse");
        mdDestino.classList.remove("collapse");
        btnRideNext.classList.add("collapse");
        
        $.ajax({
          url: "api/v1/general/destinyUnionActive/service/" + cuerrentRide.service.id + "/date/null",
          type: "GET",
          crossDomain: true,
          dataType: 'json',
          error: function() { 
              mtdMostrarMensaje("Could not complete request to server", "warning");               }
        }).done((resultado) => {
            if (resultado["state"] === 'ok') {
              if (resultado["data"].length == 0) {
                mtdMostrarMensaje(resultado["message"], "warning"); 
              
                $('.listDestino').html(`                    
                    <script id="property-item-destino" type="text/html">
                        <div class="icon-box">
                            <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                                <b>{{ destiny }}</b>
                            </div>
                        </div>
                    </script>
                `);
              }
              $.each(resultado["data"], (index, destiny) => {
                const template = $(Mustache.render($('#property-item-destino').html(), destiny));
            
                template.find('.icon-box').on('dxclick', () => {

                  cuerrentRide.steps.push("mdDestino");
                  cuerrentRide.destiny = destiny;
                  cuerrentRide.current_step = "mdPasajero";
                  setDataCurrentRideBooking(cuerrentRide);
                  btnRideBack.classList.remove("collapse");
                  mdDestino.classList.add("collapse");
                  mdPasajero.classList.remove("collapse");
                  btnRideNext.classList.remove("collapse");
                });
            
                $('.listDestino').append(template);
              });
            }
            if (resultado["state"] === 'ko') {
                mtdMostrarMensaje(resultado["message"], "error");
            }
        });
      }

      if(cuerrentRide.current_step == "mdCalendario" && cuerrentRide.service.type_id == 4){

        let departureSelect = fnFechaFormatear(calendar.option('value'));
        
        cuerrentRide.steps.push("mdCalendario");      
        cuerrentRide.date = departureSelect;
        cuerrentRide.current_step = "mdPasajeroGrupo";
        setDataCurrentRideBooking(cuerrentRide);
        btnRideBack.classList.remove("collapse");
        mdCalendario.classList.add("collapse");
        mdPasajeroGrupo.classList.remove("collapse");
        btnRideNext.classList.add("collapse");
        
        $.ajax({
          url: "api/v1/general/passengerGroupActive/destiny/" + cuerrentRide.destiny.id,
          type: "GET",
          crossDomain: true,
          dataType: 'json',
          error: function() { 
              mtdMostrarMensaje("Could not complete request to server", "warning");               }
        }).done((resultado) => {
            if (resultado["state"] === 'ok') {
              if (resultado["data"].length == 0) {
                mtdMostrarMensaje(resultado["message"], "warning"); 
              
                $('.listPasajeroGrupo').html(`                    
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
                `);
              }
              $.each(resultado["data"], (index, passenger) => {
                const template = $(Mustache.render($('#property-item-pasajero-grupo').html(), passenger));
            
                template.find('.icon-box').on('dxclick', () => {

                  cuerrentRide.steps.push("mdPasajeroGrupo");
                  cuerrentRide.passenger_qty = 1;
                  cuerrentRide.passenger_group = passenger;
                  cuerrentRide.current_step = "mdRecogida";
                  setDataCurrentRideBooking(cuerrentRide);
                  btnRideBack.classList.remove("collapse");
                  mdPasajeroGrupo.classList.add("collapse");
                  mdRecogida.classList.remove("collapse");
                  btnRideNext.classList.add("collapse"); 

                  $.ajax({
                    url: "api/v1/general/pickUpTimeActive/origin/" + cuerrentRide.origin.id + "/service/" + cuerrentRide.service.id + "/date/" + cuerrentRide.date,
                    type: "GET",
                    crossDomain: true,
                    dataType: 'json',
                    error: function() { 
                      mtdMostrarMensaje("Could not complete request to server", "warning");
                    }
                  }).done((resultado) => {
                      if (resultado["state"] === 'ok') {
                        if (resultado["data"].length == 0) {
                          mtdMostrarMensaje(resultado["message"], "warning"); 
                        
                          $('.listRecogida').html(`                    
                              <script id="property-item-recogida" type="text/html">
                                  <div class="icon-box">
                                      <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                                          <b>{{ time_format }}</b>
                                      </div>
                                  </div>
                              </script>
                          `);
                        }
                        $.each(resultado["data"], (index, pickUpTime) => {
                          const template = $(Mustache.render($('#property-item-recogida').html(), pickUpTime));
                      
                          template.find('.icon-box').on('dxclick', () => {
                            cuerrentRide.steps.push("mdRecogida");
                            cuerrentRide.pick_up_time = pickUpTime;
                            cuerrentRide.current_step = "mdInformacionContacto";
                            setDataCurrentRideBooking(cuerrentRide);  
                            btnRideBack.classList.remove("collapse");
                            mdRecogida.classList.add("collapse");
                            mdInformacionContacto.classList.remove("collapse");
                            btnRideNext.classList.remove("collapse");

                            divNameDistiny.classList.remove("collapse");

                            if (cuerrentRide.destiny.destiny.includes("AIRPORT")) {
                              lblNameDestiny.innerHTML = "<strong>Airline Name</strong>";
                            }else{
                              lblNameDestiny.innerHTML = "<strong>Cruise Ship Name<strong>";
                            }                                    
                            
                          });
                      
                          $('.listRecogida').append(template);
                        });
                      }
                      if (resultado["state"] === 'ko') {
                          mtdMostrarMensaje(resultado["message"], "error");
                      }
                  });



                });
            
                $('.listPasajeroGrupo').append(template);
              });
            }
            if (resultado["state"] === 'ko') {
                mtdMostrarMensaje(resultado["message"], "error");
            }
        });
      }

      if(cuerrentRide.current_step == "mdPasajero"){

        if (txtPassengerQty.textContent == 0) {
          mtdMostrarMensaje("select the number of passengers", "error");
          return;
        }       

        cuerrentRide.steps.push("mdPasajero");      
        cuerrentRide.passenger_qty = txtPassengerQty.textContent;
        cuerrentRide.current_step = "mdRecogida";
        setDataCurrentRideBooking(cuerrentRide);
        btnRideBack.classList.remove("collapse");
        mdPasajero.classList.add("collapse");
        mdRecogida.classList.remove("collapse");
        btnRideNext.classList.add("collapse");

        $.ajax({
          url: "api/v1/general/pickUpTimeActive/origin/" + cuerrentRide.origin.id + "/service/" + cuerrentRide.service.id + "/date/" + cuerrentRide.date,
          type: "GET",
          crossDomain: true,
          dataType: 'json',
          error: function() { 
            mtdMostrarMensaje("Could not complete request to server", "warning");
          }
        }).done((resultado) => {
            if (resultado["state"] === 'ok') {
              if (resultado["data"].length == 0) {
                mtdMostrarMensaje(resultado["message"], "warning"); 
              
                $('.listRecogida').html(`                    
                    <script id="property-item-recogida" type="text/html">
                        <div class="icon-box">
                            <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                                <b>{{ time_format }}</b>
                            </div>
                        </div>
                    </script>
                `);
              }
              $.each(resultado["data"], (index, pickUpTime) => {
                const template = $(Mustache.render($('#property-item-recogida').html(), pickUpTime));
            
                template.find('.icon-box').on('dxclick', () => {

                  if (pickUpTime.passenger_max && txtPassengerQty.textContent > pickUpTime.passenger_max) {
                    mtdMostrarMensaje("Maximum number of passengers are " + pickUpTime.passenger_max, "error");
                    return;
                  }

                  cuerrentRide.steps.push("mdRecogida");
                  cuerrentRide.pick_up_time = pickUpTime;                  
                 
                  if (cuerrentRide.service.type_id == 1) {
                    if(cuerrentRide.service.return == 1){
                      cuerrentRide.current_step = "mdRegreso";
                      setDataCurrentRideBooking(cuerrentRide);  
                      btnRideBack.classList.remove("collapse");
                      mdRecogida.classList.add("collapse");
                      mdRegreso.classList.remove("collapse");
                      btnRideNext.classList.add("collapse");
  
                      $('.listRegreso').html(`                    
                        <script id="property-item-regreso" type="text/html">
                            <div class="icon-box">
                                <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                                    <b>{{ option }}</b>
                                </div>
                            </div>
                        </script>
                    `);
  
                      $.each(dataSourcerReturnRide, (index, returns) => {
                        const template = $(Mustache.render($('#property-item-regreso').html(), returns));
                    
                        template.find('.icon-box').on('dxclick', () => {
                          btnRideBack.classList.remove("collapse");
                          mdRegreso.classList.add("collapse");                        
                          btnRideNext.classList.remove("collapse");
                          cuerrentRide.steps.push("mdRegreso");
                          cuerrentRide.return = returns;
                          if (returns.return) {
                            mdCalendarioRegreso.classList.remove("collapse");
                            cuerrentRide.current_step = "mdCalendarioRegreso";                                                  
                            setDataCurrentRideBooking(cuerrentRide);
                            
                          }else{
                            mdInformacionContacto.classList.remove("collapse");
                            cuerrentRide.current_step = "mdInformacionContacto";   
                            setDataCurrentRideBooking(cuerrentRide);
                          }                                    
                          
                        });
                    
                        $('.listRegreso').append(template);
                      });
  
                    }
                  }                 
                  
                  if (cuerrentRide.service.type_id == 2) {                    

                    if(cuerrentRide.service.room_number == 1){
                      cuerrentRide.current_step = "mdInformacionHabitacion";
                      setDataCurrentRideBooking(cuerrentRide);  
                      btnRideBack.classList.remove("collapse");
                      mdRecogida.classList.add("collapse");
                      mdInformacionHabitacion.classList.remove("collapse");
                      btnRideNext.classList.add("collapse");
                    }
                    
                  }

                  if (cuerrentRide.service.type_id == 3) {
                      cuerrentRide.current_step = "mdInformacionTerminos";
                      pInformacionTerminos.innerHTML = cuerrentRide.destiny.terms_and_conditions;
                      setDataCurrentRideBooking(cuerrentRide);  
                      btnRideBack.classList.remove("collapse");
                      mdRecogida.classList.add("collapse");
                      mdInformacionTerminos.classList.remove("collapse");
                      btnRideNext.classList.remove("collapse");                    
                  }
                  
                });
            
                $('.listRecogida').append(template);
              });
            }
            if (resultado["state"] === 'ko') {
                mtdMostrarMensaje(resultado["message"], "error");
            }
        });

      }

      if(cuerrentRide.current_step == "mdInformacionContacto"){

        if (cuerrentRide.destiny.type == "GROUPS") {
          if(!txtNameDestiny.value){
            mtdMostrarMensaje("Enter your destiny", "error");
            txtNameDestiny.focus();
            return;
          }
        }
        if(!txtName.value){
          mtdMostrarMensaje("Enter your name", "error");
          txtName.focus();
          return;
        }
        if(!txtPhone.value){
          mtdMostrarMensaje("Enter your phone", "error");
          txtPhone.focus();
          return;
        }
        if(!txtEmail.value){
          mtdMostrarMensaje("Enter your email", "error");
          txtEmail.focus();
          return;
        }

        if (!fnValidarFromatoCorreo(txtEmail.value)) {
          mtdMostrarMensaje("Enter a valid email", "error");
          txtEmailA.focus();
          return;
        }

        cuerrentRide.steps.push("mdInformacionContacto"); 
        cuerrentRide.client = {
          destiny: txtNameDestiny.value ? txtNameDestiny.value.toUpperCase() : null,
          name: txtName.value.toUpperCase(),
          phone: txtPhone.value,
          email: txtEmail.value
        }
        cuerrentRide.current_step = "mdInformacionTarjeta";
        setDataCurrentRideBooking(cuerrentRide);
        btnRideBack.classList.remove("collapse");
        mdInformacionContacto.classList.add("collapse");
        mdInformacionTarjeta.classList.remove("collapse");
        btnRideNext.classList.add("collapse");

        let cantMult = 1;

        if(cuerrentRide.return){
          if(cuerrentRide.return.return){
            cantMult = 2;
          }          
        }

        let currentPay = 0;

        currentPay = (((cuerrentRide.destiny.price * 1) + (cuerrentRide.destiny.additional * 1)) *
        (cuerrentRide.passenger_qty * cantMult));

        if(cuerrentRide.passenger_group){    
          
          currentPay = (((cuerrentRide.passenger_group.price * 1) + (cuerrentRide.passenger_group.additional * 1)) *
          (cuerrentRide.passenger_qty * cantMult));

        }
        
        if(cuerrentRide.destiny.promo_one_x_two == 1){  

          currentPay = (((cuerrentRide.destiny.price * 1) + (cuerrentRide.destiny.additional * 1)) * 1);

        }

        if(cuerrentRide.destiny.promo_next_pass > 0 && cuerrentRide.passenger_qty > cuerrentRide.destiny.promo_next_pass){  

          currentPay =  currentPay + ((cuerrentRide.destiny.promo_next_pass_preci * 1) * (cuerrentRide.passenger_qty - cuerrentRide.destiny.promo_next_pass));

        }

        btnPay.textContent = "PAY " +  fnFormatoMoneda(currentPay) + " USD";

        cuerrentRide.pay = currentPay;
        setDataCurrentRideBooking(cuerrentRide);

      }

      if(cuerrentRide.current_step == "mdCalendarioRegreso"){
        let departureSelect = fnFechaFormatear(calendarReturn.option('value'));
        
        cuerrentRide.steps.push("mdCalendarioRegreso");      
        cuerrentRide.return.date = departureSelect;
        cuerrentRide.current_step = "mdRecogidaRegreso";
        setDataCurrentRideBooking(cuerrentRide);
        btnRideBack.classList.remove("collapse");
        mdCalendarioRegreso.classList.add("collapse");
        mdRecogidaRegreso.classList.remove("collapse");
        btnRideNext.classList.add("collapse");
        
        $.ajax({
          url: "api/v1/general/pickUpTimeActiveReturn/origin/" + cuerrentRide.origin.id + "/service/" + cuerrentRide.service.id + "/date/" + departureSelect,
          type: "GET",
          crossDomain: true,
          dataType: 'json',
          error: function() { 
              mtdMostrarMensaje("Could not complete request to server", "warning");               }
        }).done((resultado) => {
            if (resultado["state"] === 'ok') {
              if (resultado["data"].length == 0) {
                mtdMostrarMensaje(resultado["message"], "warning"); 
              
                $('.listRecogidaRegreso').html(`                    
                    <script id="property-item-recogidaRegreso" type="text/html">
                        <div class="icon-box">
                            <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                                <b>{{ time_format }}</b>
                            </div>
                        </div>
                    </script>
                `);
              }
              $.each(resultado["data"], (index, pickUpTimeReturn) => {
                const template = $(Mustache.render($('#property-item-recogidaRegreso').html(), pickUpTimeReturn));
            
                template.find('.icon-box').on('dxclick', () => {

                  cuerrentRide.steps.push("mdRecogidaRegreso");
                  cuerrentRide.return.pick_up_time = pickUpTimeReturn;
                  cuerrentRide.current_step = "mdInformacionContacto";
                  setDataCurrentRideBooking(cuerrentRide);
                  btnRideBack.classList.remove("collapse");
                  mdRecogidaRegreso.classList.add("collapse");
                  mdInformacionContacto.classList.remove("collapse");
                  btnRideNext.classList.remove("collapse");
                });
            
                $('.listRecogidaRegreso').append(template);
              });
            }
            if (resultado["state"] === 'ko') {
                mtdMostrarMensaje(resultado["message"], "error");
            }
        });
      }

      if(cuerrentRide.current_step == "mdCalendario" && cuerrentRide.service.type_id == 3){

        hMdDestino.textContent = "TOURS";
        let departureSelect = fnFechaFormatear(calendar.option('value'));
        
        cuerrentRide.steps.push("mdCalendario");      
        cuerrentRide.date = departureSelect;
        cuerrentRide.current_step = "mdDestino";
        setDataCurrentRideBooking(cuerrentRide);
        btnRideBack.classList.remove("collapse");
        mdCalendario.classList.add("collapse");
        mdDestino.classList.remove("collapse");
        btnRideNext.classList.add("collapse");
        
        $.ajax({
          url: "api/v1/general/destinyUnionActive/service/" + cuerrentRide.service.id + "/date/null",
          type: "GET",
          crossDomain: true,
          dataType: 'json',
          error: function() { 
              mtdMostrarMensaje("Could not complete request to server", "warning");               }
        }).done((resultado) => {
            if (resultado["state"] === 'ok') {
              if (resultado["data"].length == 0) {
                mtdMostrarMensaje(resultado["message"], "warning"); 
              
                $('.listDestino').html(`                    
                    <script id="property-item-destino" type="text/html">
                        <div class="icon-box">
                            <div class="icon-box btn btn-outline-warning" style="align-content: center;width: 100%;">
                                <b>{{ destiny }}</b>
                            </div>
                        </div>
                    </script>
                `);
              }
              $.each(resultado["data"], (index, destiny) => {
                const template = $(Mustache.render($('#property-item-destino').html(), destiny));
            
                template.find('.icon-box').on('dxclick', () => {

                  cuerrentRide.steps.push("mdDestino");
                  cuerrentRide.destiny = destiny;
                  pInformacionImportante.innerHTML = destiny.important_information_initial;
                  cuerrentRide.current_step = "mdInformacionImportante";
                  setDataCurrentRideBooking(cuerrentRide);
                  btnRideBack.classList.remove("collapse");
                  mdDestino.classList.add("collapse");
                  mdInformacionImportante.classList.remove("collapse");
                  btnRideNext.classList.remove("collapse");
                });
            
                $('.listDestino').append(template);
              });
            }
            if (resultado["state"] === 'ko') {
                mtdMostrarMensaje(resultado["message"], "error");
            }
        });
      }

      if(cuerrentRide.current_step == "mdInformacionImportante"){

        cuerrentRide.steps.push("mdInformacionImportante");
        cuerrentRide.current_step = "mdPasajero";
        setDataCurrentRideBooking(cuerrentRide);
        btnRideBack.classList.remove("collapse");
        mdInformacionImportante.classList.add("collapse");
        mdPasajero.classList.remove("collapse");
        btnRideNext.classList.remove("collapse");

      }

      if(cuerrentRide.current_step == "mdInformacionTerminos"){

        cuerrentRide.steps.push("mdInformacionTerminos");
        cuerrentRide.current_step = "mdInformacionContacto";
        setDataCurrentRideBooking(cuerrentRide);
        btnRideBack.classList.remove("collapse");
        mdInformacionTerminos.classList.add("collapse");
        mdInformacionContacto.classList.remove("collapse");
        btnRideNext.classList.remove("collapse");

      }
  }

  const txtRoomNumber = document.getElementById("txtRoomNumber");
  const txtNameA = document.getElementById("txtNameA");
  const txtPhoneA = document.getElementById("txtPhoneA");
  const txtEmailA = document.getElementById("txtEmailA");
  const btnBookingAirport = document.getElementById("btnBookingAirport");

  btnBookingAirport.addEventListener('click', btnBookingAirportClick);
  function btnBookingAirportClick(e) {
      e.preventDefault();   

      if(cuerrentRide.current_step == "mdInformacionHabitacion"){

        if(!txtRoomNumber.value){
          mtdMostrarMensaje("Enter your room number", "error");
          txtRoomNumber.focus();
          return;
        }

        if(!txtNameA.value){
          mtdMostrarMensaje("Enter your name", "error");
          txtNameA.focus();
          return;
        }
        if(!txtPhoneA.value){
          mtdMostrarMensaje("Enter your phone", "error");
          txtPhoneA.focus();
          return;
        }
        if(!txtEmailA.value){
          mtdMostrarMensaje("Enter your email", "error");
          txtEmailA.focus();
          return;
        }

        if (!fnValidarFromatoCorreo(txtEmailA.value)) {
          mtdMostrarMensaje("Enter a valid email", "error");
          txtEmailA.focus();
          return;
        }

        var confirm = DevExpress.ui.dialog.confirm("<i>Do you want to continue with the booking?</i>", "Booking");
        confirm.done((dialogResult) => {
            if (dialogResult) {            

              cuerrentRide.room_number = txtRoomNumber.value;
              cuerrentRide.pay = 0;
              cuerrentRide.client = {
                destiny: null,
                name: txtNameA.value.toUpperCase(),
                phone: txtPhoneA.value,
                email: txtEmailA.value
              }
              setDataCurrentRideBooking(cuerrentRide);

              mtdActivarLoad(btnBookingAirport, "schedule...");

              $.ajax({
                url: "api/v1/general/booking/ride",
                type: "POST",
                dataType: 'json',
                crossDomain: true,
                data: JSON.stringify({
                  currentRideBooking: cuerrentRide
                }),
                error: function() {
                  mtdDesactivarLoad(btnBookingAirport, "Booking Ride");
                  mtdMostrarMensaje("Could not complete request to server", "warning");
                },
              }).done((respuesta) => {                 

                  if (respuesta["state"] === 'ok') {
                      cuerrentRide.state = "SCHEDULER";
                      setDataCurrentRideBooking(cuerrentRide);
                      setTimeout(() => { location.href = "home"; }, 1000);                      
                  }
                  if (respuesta["state"] === 'ko') {
                      mtdDesactivarLoad(btnBookingAirport, "Booking Ride");
                      mtdMostrarMensaje(respuesta["message"], "error");
                  }
              });
            }
        });
      }
  }

  const txtCardNumber = document.getElementById("txtCardNumber");
  const btnPay = document.getElementById("btnPay");

  btnPay.addEventListener('click', btnPayClick);
  function btnPayClick(e) {
      e.preventDefault();   

      if(cuerrentRide.current_step == "mdInformacionTarjeta"){

        if(!txtCardNumber.value){
          mtdMostrarMensaje("Enter your card number", "error");
          return;
        }

        var confirm = DevExpress.ui.dialog.confirm("<i>Do you want to continue with the booking?</i>", "Booking");
        confirm.done((dialogResult) => {
            if (dialogResult) {            

              cuerrentRide.room_number = txtRoomNumber.value;
              setDataCurrentRideBooking(cuerrentRide);

              let buttonText = btnPay.textContent;

              mtdActivarLoad(btnPay, "schedule...");

              $.ajax({
                url: "api/v1/general/booking/ride",
                type: "POST",
                dataType: 'json',
                crossDomain: true,
                data: JSON.stringify({
                  currentRideBooking: cuerrentRide
                }),
                error: function() {
                  mtdDesactivarLoad(btnPay, buttonText);
                  mtdMostrarMensaje("Could not complete request to server", "warning");
                },
              }).done((respuesta) => {                 

                  if (respuesta["state"] === 'ok') {
                      cuerrentRide.state = "SCHEDULER";
                      setDataCurrentRideBooking(cuerrentRide);
                      setTimeout(() => { location.href = "home"; }, 1000);                      
                  }
                  if (respuesta["state"] === 'ko') {
                      mtdDesactivarLoad(btnPay, buttonText);
                      mtdMostrarMensaje(respuesta["message"], "error");
                  }
              });
            }
        });
      }
  }

  btnRideShow.addEventListener('click', btnRideShowClick);
  function btnRideShowClick(e) {
    e.preventDefault();   
    getDataCurrentRideBooking();
    mdtActualizarTemplate(popupWithScrollView);
    popupWithScrollView.show();
  }

  const popupWithScrollView = $('#popup-with-scrollview').dxPopup({
    visible: false,
    title: 'Booking',
    hideOnOutsideClick: false,
    showCloseButton: true
  }).dxPopup('instance');

  function mdtActualizarTemplate(component) {
    component.option({contentTemplate() 
      {
        const $scrollView = $('<div/>');

        let body = '<div class="caption">Origin</div>';

        if(cuerrentRide.origin){
          body += cuerrentRide.origin.name;
        }

        if(cuerrentRide.service){
          body += '<div class="caption">Service</div>';
          body += '('+cuerrentRide.service.type+') - '+cuerrentRide.service.name;
        }

        if(cuerrentRide.date){
          body += '<div class="caption">Departure Day</div>';
          body += cuerrentRide.date;
        }

        if(cuerrentRide.destiny){

          let destinyClient = txtNameDestiny.value ? " ( "+txtNameDestiny.value.toUpperCase()+" )" : "";

          body += '<div class="caption">Destiny</div>';
          body += cuerrentRide.destiny.destiny +  destinyClient ;         
        }

        if(cuerrentRide.pick_up_time){
          body += '<div class="caption">Pick Up Time</div>';
          body += cuerrentRide.pick_up_time.time_format;
        }

        if(cuerrentRide.return){

          if (cuerrentRide.return.return) {
            body += '<div class="caption">Return</div>';
            body += cuerrentRide.return.to + " / "+ cuerrentRide.return.date + " / "+ cuerrentRide.return.pick_up_time.time_format;
          }          
        }

        if(cuerrentRide.room_number){
          body += '<div class="caption">Room Number</div>';
          body += cuerrentRide.room_number;
        }

        if(cuerrentRide.passenger_qty){
          body += '<div class="caption">Passenger</div>';

          if(cuerrentRide.passenger_group){
            body += cuerrentRide.passenger_group.passenger_min + " - "+ cuerrentRide.passenger_group.passenger_max;
          }else{
            body += cuerrentRide.passenger_qty;
          }          
        }

        if(cuerrentRide.destiny && cuerrentRide.passenger_qty){

          body += '<div class="caption">Price</div>';
          if(cuerrentRide.passenger_group){
            body +=  fnFormatoMoneda(cuerrentRide.passenger_group.price) +' + ('+fnFormatoMoneda(cuerrentRide.passenger_group.additional)+')';
          }else{
            body +=  fnFormatoMoneda(cuerrentRide.destiny.price) +' + ('+fnFormatoMoneda(cuerrentRide.destiny.additional)+')';
          }  
                   
          let cantMult = 1;

          if(cuerrentRide.return && cuerrentRide.return.return){
            cantMult = 2;
          }

          let currentPay = 0;

          currentPay = (((cuerrentRide.destiny.price * 1) + (cuerrentRide.destiny.additional * 1)) *
          (cuerrentRide.passenger_qty * cantMult));

          if(cuerrentRide.passenger_group){    
            
            currentPay = (((cuerrentRide.passenger_group.price * 1) + (cuerrentRide.passenger_group.additional * 1)) *
            (cuerrentRide.passenger_qty * cantMult));

          }
          
          if(cuerrentRide.destiny.promo_one_x_two == 1){  

            currentPay = (((cuerrentRide.destiny.price * 1) + (cuerrentRide.destiny.additional * 1)) * 1);
            body += '<div class="caption">Promo</div>';
            body += "2 x 1 <br>";

          }

          if(cuerrentRide.destiny.promo_next_pass > 0 && cuerrentRide.passenger_qty > cuerrentRide.destiny.promo_next_pass){  

            currentPay =  currentPay + ((cuerrentRide.destiny.promo_next_pass_preci * 1) * (cuerrentRide.passenger_qty - cuerrentRide.destiny.promo_next_pass));
            body += '<div class="caption">Promo</div>';
            body += "Greater than " + cuerrentRide.destiny.promo_next_pass + "  passengers x " + fnFormatoMoneda(cuerrentRide.destiny.promo_next_pass_preci) + " USD ";

          }

          body += '<div class="caption">Pay</div>';
          body += "<b>";
          body += fnFormatoMoneda(currentPay) + " USD</b>";         
        }

        if(cuerrentRide.client){
          body += '<div class="caption">Contact Information</div>';
          body += cuerrentRide.client.name + " / "+ cuerrentRide.client.phone + " / "+ cuerrentRide.client.email;
        }
    

        $scrollView.append($('<div/>').html(body));

        $scrollView.dxScrollView({
          width: '100%',
          height: '100%',
        });

        return $scrollView;
      }
    });
  }

  const txtPassengerQty = document.getElementById("txtPassengerQty");
  const btnIncrementar = document.getElementById("btnIncrementar");
  const btnDecrementar = document.getElementById("btnDecrementar");
  let items = 0;

  function increaseItem() {
    items++;
    txtPassengerQty.textContent = items;
  }

  function decreaseItem(){
    if(items > 0) items--;
    txtPassengerQty.textContent = items;
  }
  
  btnIncrementar.addEventListener("click", increaseItem);
  btnDecrementar.addEventListener("click",decreaseItem);

  function mtdMostrarMensaje(mensaje, tipo = "success", time = 3000) {

    let direction = "up-push";
    let position = "bottom center";

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

  function fnFechaFormatear(fecha) {
    var d = new Date(fecha);

    var dia = d.getDate();
    var mes = (d.getMonth() + 1);
    var anno = d.getFullYear();

    if (mes < 10) {
        mes = "0" + mes;
    }
    if (dia < 10) {
        dia = "0" + dia;
    }

    return anno + "-" + mes + "-" + dia;
  }

  function fnFormatoMoneda(number) {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 2 }).format(number);
  }

  function mtdActivarLoad(boton,texto = "cargando... ") {
    boton.innerHTML ='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' + texto ;
    boton.disabled = true;
  }

  function mtdDesactivarLoad(boton,texto = "Cargar") {
      boton.textContent = texto;
      boton.disabled = false;
  }

  function fnValidarFromatoCorreo(correo) {
    var validRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (correo.match(validRegex)) {return true;}         
    return false;
}

});