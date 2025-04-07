async function CardPay(fieldEl, buttonEl) {
  // Create a card payment object and attach to page
  const card = await window.payments.card({
    style: {
      '.input-container.is-focus': {
        borderColor: '#006AFF'
      },
      '.message-text.is-error': {
        color: '#BF0020'
      }
    }
  });
  await card.attach(fieldEl);

  async function eventHandler(event) {
    // Clear any existing messages
    window.paymentFlowMessageEl.innerText = '';
    let buttonText = buttonEl.innerText;
    window.mtdActivarLoad(buttonEl, "paying ... ");

    try {
      const result = await card.tokenize();
      if (result.status === 'OK') {
        // Use global method from sq-payment-flow.js
        window.createPayment(result.token, buttonEl, buttonText);
      }else{
        window.mtdDesactivarLoad(buttonEl, buttonText);
      }
      
    } catch (e) {
      window.mtdDesactivarLoad(buttonEl, buttonText);
      let errorText = 'Something went wrong';
      if (e.message) {
        errorText = `Error: ${e.message}`;
      }
      mtdMostrarMensaje(errorText, "error");
    }
  }

  buttonEl.addEventListener('click', eventHandler);
}