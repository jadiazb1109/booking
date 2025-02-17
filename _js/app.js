$(() => {
  document.onmousemove = function(){ localStorage.setItem("currentRideBookingTime", 0); }

  if (!localStorage.getItem("currentRideBooking")) {
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

  const btnBackToHome = document.getElementById('btnBackToHome');
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

  let currentHouse;

  DevExpress.setTemplateEngine({
    compile: (element) => $(element).html(),
    render: (template, data) => Mustache.render(template, data),
  });

  const mdOrigen = document.getElementById('mdOrigen');
  $.each(houses, (index, house) => {
    const template = $(Mustache.render($('#property-item-origen').html(), house));

    template.find('.icon-box').on('dxclick', () => {
      currentHouse = house;
      mdOrigen.classList.add("collapse")
      mdServicios.classList.remove("collapse")
    });

    $('.listOrigen').append(template);
  });

  const mdServicios = document.getElementById('mdServicios');
  $.each(houses, (index, house) => {
    const template = $(Mustache.render($('#property-item-servicio').html(), house));

    template.find('.icon-box').on('dxclick', () => {
      currentHouse = house;
      alert(currentHouse.City);
    });

    $('.listServicio').append(template);
  });

});