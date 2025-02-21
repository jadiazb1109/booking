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
  const mdInformacionContacto = document.getElementById('mdInformacionContacto');
  const mdInformacionTarjeta = document.getElementById('mdInformacionTarjeta');

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
        var confirm = DevExpress.ui.dialog.confirm("<i>Deseas continuar con la reserva</i>", "¿Desea continuar?");
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
      var confirm = DevExpress.ui.dialog.confirm("<i>Seguro que desea salir</i>", "¿Desea salir?");

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
            cuerrentRide.client= null
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
                      cuerrentRide.current_step = "mdCalendario";
                      setDataCurrentRideBooking(cuerrentRide);

                      if(service.type_id == 1){
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


  const txtName = document.getElementById("txtName");
  const txtPhone = document.getElementById("txtPhone");
  const txtEmail = document.getElementById("txtEmail");

  btnRideNext.addEventListener('click', btnRideNextClick);
  function btnRideNextClick(e) {
      e.preventDefault();   

      if(cuerrentRide.current_step == "mdCalendario"){
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
              mtdMostrarMensaje("Could not complete request to server", "warning");               }
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
                  cuerrentRide.current_step = "mdRegreso";
                  setDataCurrentRideBooking(cuerrentRide);

                  if(cuerrentRide.service.return == 1){

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
                        mdInformacionContacto.classList.remove("collapse");
                        btnRideNext.classList.remove("collapse");

                        cuerrentRide.steps.push("mdRegreso");
                        cuerrentRide.current_step = "mdInformacionContacto";
                        cuerrentRide.return = returns;                        
                        setDataCurrentRideBooking(cuerrentRide);             
                        
                      });
                  
                      $('.listRegreso').append(template);
                    });

                  }else{

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

        btnPay.textContent = "PAY $ " + 
            (((cuerrentRide.destiny.price * 1) + (cuerrentRide.destiny.additional * 1)) * (cuerrentRide.passenger_qty * cantMult)) + " USD"
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

        mtdMostrarMensaje("Pago realizado!!");
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

          body += '<div class="caption">Price</div>';
          body +=  '$ '+cuerrentRide.destiny.price +' + ($ '+cuerrentRide.destiny.additional+')';
        }

        if(cuerrentRide.passenger_qty){
          body += '<div class="caption">Passenger</div>';
          body += cuerrentRide.passenger_qty;
        }

        if(cuerrentRide.pick_up_time){
          body += '<div class="caption">Pick Up Time</div>';
          body += cuerrentRide.pick_up_time.time_format;
        }

        if(cuerrentRide.return){

          if (cuerrentRide.return.return) {
            body += '<div class="caption">Return</div>';
            body += cuerrentRide.return.to + " - "+ cuerrentRide.return.date + " - "+ cuerrentRide.return.time;
          }          
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

});