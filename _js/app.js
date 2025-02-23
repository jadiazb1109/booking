$(() => {
  document.onmousemove = function(){ localStorage.setItem("currentRideBookingTime", 0); }

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
  const mdPasajero = document.getElementById('mdPasajero');
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

    if(time_sesion > 1){

      if(!aviso){
        var confirm = DevExpress.ui.dialog.confirm("<i>Do you want to continue with the ride?</i>", "Keep");
        aviso = true;
        confirm.done((dialogResult) => {
            if (dialogResult) {
              localStorage.setItem("currentRideBookingTime", 0);
              aviso = false;
            }else{
              localStorage.removeItem("currentRideBooking");
              location.href = "home";
            }
        });
      }      

    }else{
      localStorage.setItem("currentRideBookingTime", (time_sesion * 1) + 1);
    }
  }, 60000);

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
                  <div class="icon-box btn btn-outline-secondary" style="align-content: center;width: 100%;">
                      <b>{{ name }}</b>
                  </div>
              </div>
          </script>
      `);   
      }

      if(cuerrentRide.current_step == "mdServicio"){
        btnRideNext.classList.add("collapse");    
      }

      if(cuerrentRide.current_step == "mdCalendario"){
        btnRideNext.classList.remove("collapse");    
        $('.listDestino').html(`                    
          <script id="property-item-destino" type="text/html">
              <div class="icon-box">
                  <div class="icon-box btn btn-outline-secondary" style="align-content: center;width: 100%;">
                      <b>{{ destiny }}</b>
                  </div>
              </div>
          </script>
      `);
      }

      if(cuerrentRide.current_step == "mdDestino"){
        btnRideNext.classList.add("collapse");    
      }

      if(cuerrentRide.current_step == "mdPasajero"){
        btnRideNext.classList.remove("collapse"); 
        $('.listRecogida').html(`                    
          <script id="property-item-recogida" type="text/html">
              <div class="icon-box">
                  <div class="icon-box btn btn-outline-secondary" style="align-content: center;width: 100%;">
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
                    <div class="icon-box btn btn-outline-secondary" style="align-content: center;width: 100%;">
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
                                <div class="icon-box btn btn-outline-secondary" style="align-content: center;width: 100%;">
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
                      cuerrentRide.room_number= null,
                      txtPassengerQty.textContent = 0;
                      items = 0;
                      cuerrentRide.current_step = "mdCalendario";
                      setDataCurrentRideBooking(cuerrentRide);

                      if(service.type_id == 1 || service.type_id == 2){
                        btnRideBack.classList.remove("collapse");
                        mdServicio.classList.add("collapse");
                        mdCalendario.classList.remove("collapse");
                        btnRideNext.classList.remove("collapse");
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
                            <div class="icon-box btn btn-outline-secondary" style="align-content: center;width: 100%;">
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
                            <div class="icon-box btn btn-outline-secondary" style="align-content: center;width: 100%;">
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
          url: "api/v1/general/pickUpTimeActive/service/" + cuerrentRide.service.id + "/date/" + cuerrentRide.date,
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
                            <div class="icon-box btn btn-outline-secondary" style="align-content: center;width: 100%;">
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
                                <div class="icon-box btn btn-outline-secondary" style="align-content: center;width: 100%;">
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

        if(!txtName.value){
          mtdMostrarMensaje("Enter your name", "error");
          return;
        }
        if(!txtPhone.value){
          mtdMostrarMensaje("Enter your phone", "error");
          return;
        }
        if(!txtEmail.value){
          mtdMostrarMensaje("Enter your email", "error");
          return;
        }

        cuerrentRide.steps.push("mdInformacionContacto"); 
        cuerrentRide.client = {
          name: txtName.value,
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

        if(cuerrentRide.return.return){
          cantMult = 2;
        }

        btnPay.textContent = "PAY " + 
        fnFormatoMoneda(((cuerrentRide.destiny.price * 1) + (cuerrentRide.destiny.additional * 1)) *
           (cuerrentRide.passenger_qty * cantMult)) + " USD";
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
          url: "api/v1/general/pickUpTimeActiveReturn/service/" + cuerrentRide.service.id + "/date/" + departureSelect,
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
                            <div class="icon-box btn btn-outline-secondary" style="align-content: center;width: 100%;">
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
  }

  const txtRoomNumber = document.getElementById("txtRoomNumber");
  const btnBookingAirport = document.getElementById("btnBookingAirport");

  btnBookingAirport.addEventListener('click', btnBookingAirportClick);
  function btnBookingAirportClick(e) {
      e.preventDefault();   

      if(cuerrentRide.current_step == "mdInformacionHabitacion"){

        if(!txtRoomNumber.value){
          mtdMostrarMensaje("Enter your room number", "error");
          return;
        }

        var confirm = DevExpress.ui.dialog.confirm("<i>Do you want to continue with the booking?</i>", "Booking");
        confirm.done((dialogResult) => {
            if (dialogResult) {            

              cuerrentRide.room_number = txtRoomNumber.value;
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

        mtdMostrarMensaje("successful payment!!");
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

        let body = '<div class="caption">Orignin</div>';

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
          body += '<div class="caption">Destiny</div>';
          body += cuerrentRide.destiny.destiny;         
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
          body += cuerrentRide.passenger_qty;
        }

        if(cuerrentRide.destiny && cuerrentRide.passenger_qty){

          body += '<div class="caption">Price</div>';
          body +=  fnFormatoMoneda(cuerrentRide.destiny.price) +' + ('+fnFormatoMoneda(cuerrentRide.destiny.additional)+')';

          let cantMult = 1;

          if(cuerrentRide.return && cuerrentRide.return.return){
            cantMult = 2;
          }

          body += '<div class="caption">Pay</div>';
          body += "<b>" + 
            fnFormatoMoneda(((cuerrentRide.destiny.price * 1) + (cuerrentRide.destiny.additional * 1)) *
             (cuerrentRide.passenger_qty * cantMult)) + " USD</b>";
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

    let direction = "down-push";
    let position = "booton center";

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

});