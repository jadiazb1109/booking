async function SquarePaymentFlow() {

  // Create card payment object and attach to page
  CardPay(document.getElementById('card-container'), document.getElementById('card-button'));

}

var cuerrentRide = {};

window.getDataCurrentRideBooking = function() {
  cuerrentRide = JSON.parse(localStorage.getItem("currentRideBooking"));
  return cuerrentRide;
}

window.setDataCurrentRideBooking = function (cuerrentRide) {
  localStorage.setItem("currentRideBooking", JSON.stringify(cuerrentRide));
}


window.payments = Square.payments(window.applicationId, window.locationId);

window.paymentFlowMessageEl = document.getElementById('payment-flow-message');

window.showSuccess = function(message) {
  window.paymentFlowMessageEl.classList.add('success'); 
  window.paymentFlowMessageEl.classList.remove('error');
  window.paymentFlowMessageEl.innerText = message;
}

window.showError = function(message) {
  window.paymentFlowMessageEl.classList.add('error');
  window.paymentFlowMessageEl.classList.remove('success');
  window.paymentFlowMessageEl.innerText = message;
}

window.createPayment = async function(token, button, buttonText) {

  getDataCurrentRideBooking();

  const dataJsonString = JSON.stringify({
    token,
    idempotencyKey: uuid.v4(),
    amountMoney: {
      "amount": cuerrentRide.pay * 100,
      "currency": "EUR"
    },
  });

  try {
    const response = await fetch('square/process-payment.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: dataJsonString
    });

    const data = await response.json();

    if (data.errors && data.errors.length > 0) {
      if (data.errors[0].detail) {
        window.mtdMostrarMensaje(data.errors[0].detail, "error");
      } else {
        window.mtdMostrarMensaje('Payment Failed.', "error");
      }
      window.mtdDesactivarLoad(button, buttonText);
    } else {

      cuerrentRide.room_number = txtRoomNumber.value;
      cuerrentRide.client.pay =  data;
      window.setDataCurrentRideBooking(cuerrentRide);
      
      window.mtdActivarLoad(button, "schedule...");

      const result = await $.ajax({
        url: "api/v1/general/booking/ride",
        type: "POST",
        dataType: 'json',
        crossDomain: true,
        data: JSON.stringify({
          currentRideBooking: cuerrentRide
        }),
        error: function() {
          window.mtdDesactivarLoad(button, buttonText);
          window.mtdMostrarMensaje("Could not complete request to server", "warning");
        },
      }).done((respuesta) => {                 

          if (respuesta["state"] === 'ok') {
              cuerrentRide.state = "SCHEDULER";
              window.setDataCurrentRideBooking(cuerrentRide);
              setTimeout(() => { location.href = "home"; }, 1000);                      
          }
          if (respuesta["state"] === 'ko') {
            window.mtdDesactivarLoad(button, buttonText);
            window.mtdMostrarMensaje(respuesta["message"], "error");
          }
      });
    } 

    const dataRide = await result.json();
    
  } catch (error) {
    console.error('Error:', error);
  }
}

SquarePaymentFlow();

window.mtdMostrarMensaje = function(mensaje, tipo = "success", time = 3000) {

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

window.mtdActivarLoad = function(boton,texto = "cargando... ") {
  boton.innerHTML ='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' + texto ;
  boton.disabled = true;
}

window.mtdDesactivarLoad = function(boton,texto = "Cargar") {
    boton.textContent = texto;
    boton.disabled = false;
}