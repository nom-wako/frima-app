// Stripe
document.addEventListener('DOMContentLoaded', function () {
  // 公開キーをmetaタグから取得
  const stripeKeyMeta = document.querySelector('meta[name="stripe-key"]');
    if (!stripeKeyMeta) {
        console.error('Stripe key meta tag not found.');
        return;
    }
    const stripeKey = stripeKeyMeta.getAttribute('content');
    const stripe = Stripe(stripeKey);
    const elements = stripe.elements();

  // カード入力欄の作成とマウント
  const style = {
    base: {
      fontSize: '16px',
      color: '#32325d',
      '::placeholder': { color: '#aab7c4' },
    },
    invalid: {
      color: '#fa755a',
      iconColor: '#fa755a'
    }
  };

  const card = elements.create('card', { style: style, hidePostalCode: true });
  card.mount('#card-element');

  // 支払い方法によってカード入力欄の表示を切り替え
  const paymentMethodSelect = document.getElementById('payment-method');
  const cardInfoArea = document.getElementById('card-info-area');
  const displayPayment = document.getElementById('display-payment-method');

  paymentMethodSelect.addEventListener('change', function () {
    const selectedText = this.options[this.selectedIndex].text;
    displayPayment.textContent = selectedText;

    if (this.value === '2') {
      cardInfoArea.style.display = 'block';
    } else {
      cardInfoArea.style.display = 'none';
    }
  });

  // 送信処理
  const form = document.getElementById('purchase-form');

  form.addEventListener('submit', async (event) => {
    if (paymentMethodSelect.value === '2') {
      event.preventDefault();

      const submitButton = form.querySelector('button[type="submit"]');
      submitButton.disabled = true;

      const { token, error } = await stripe.createToken(card);

      if (error) {
        const errorElement = document.getElementById('card-errors');
        errorElement.textContent = error.message;
        submitButton.disabled = false;
      } else {
        stripeTokenHandler(token);
      }
    }
  });

  function stripeTokenHandler(token) {
    const hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    form.submit();
  }

  document.getElementById('purchase-form').addEventListener('submit', function () {
    document.getElementById('buy-button').disabled = true;
  })
});

// document.addEventListener('DOMContentLoaded', function () {
//   const select = document.getElementById('payment-method');
//   const display = document.getElementById('display-payment-method');

//   select.addEventListener('change', function () {
//     const selectedText = select.options[select.selectedIndex].text;
//     display.textContent = selectedText;
//   });
// });
