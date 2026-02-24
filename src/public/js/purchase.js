document.addEventListener('DOMContentLoaded', function () {
  const select = document.getElementById('payment-method');
  const display = document.getElementById('display-payment-method');

  select.addEventListener('change', function () {
    const selectedText = select.options[select.selectedIndex].text;
    display.textContent = selectedText;
  });
});
