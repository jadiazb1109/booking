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

  const btnBackToHome = document.getElementById('btnBackToHome');
  const btnRideShow = document.getElementById('btnRideShow');
  const btnRideBack = document.getElementById('btnRideBack');
  const btnRideNext = document.getElementById('btnRideNext');

  if (!localStorage.getItem("currentRideBooking")) {
    location.href = "home";
  }

  if(getDataCurrentRideBooking()){
   
    if(cuerrentRide.current_step == "mdOrigen"){
      mdOrigen.classList.remove("collapse");      
    }
    if(cuerrentRide.current_step == "mdServicio"){
      mdServicio.classList.remove("collapse");
      btnRideBack.classList.remove("collapse");     
    }
    if(cuerrentRide.current_step == "mdCalendario"){
      mdCalendario.classList.remove("collapse");
      btnRideBack.classList.remove("collapse"); 
      btnRideNext.classList.remove("collapse");   
    }
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
      }

      if(cuerrentRide.current_step == "mdServicio"){
        btnRideNext.classList.add("collapse");    
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
            cuerrentRide.steps.push("mdOrigen");
            cuerrentRide.origin = origin;
            cuerrentRide.service = null,
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
                      cuerrentRide.date = null;
                      cuerrentRide.current_step = "mdCalendario",
                      setDataCurrentRideBooking(cuerrentRide);
                      btnRideBack.classList.remove("collapse");
                      mdServicio.classList.add("collapse");
                      mdCalendario.classList.remove("collapse");
                      btnRideNext.classList.remove("collapse"); 
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
          mtdMostrarMensaje(resultado["mensaje"], "error");
      }
  });

  $('#scheduler').dxScheduler({
    timeZone: 'America/Los_Angeles',
    views: ['month'],
    currentView: 'month',
    currentDate: new Date(),
    adaptivityEnabled: true,
    editing: {
      allowAdding: false,
      allowDeleting: false,
      allowUpdating: false,
      allowResizing: false,
      allowDragging: false,
    },
    onCellClick(e){
      console.log("doble clic");
    }
  });


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
    

        $scrollView.append($('<div/>').html(body));

        $scrollView.dxScrollView({
          width: '100%',
          height: '100%',
        });

        return $scrollView;
      }
    });
  }

  function mtdMostrarMensaje(mensaje, tipo = "success", time = 3000) {

    let direction = "down-push";
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