
document.addEventListener("DOMContentLoaded", function () {
  // Obtener todos los servicios
  const services = document.querySelectorAll('.service');

  services.forEach(service => {
    const priceOriginal = service.querySelector('.price-original');
    const priceDiscount = service.querySelector('.price-discount');

    // Obtener el precio original y el porcentaje de descuento
    const originalPrice = parseFloat(priceOriginal.getAttribute('data-original-price'));
    const discountPercentage = 20;

    // Calcular el precio con descuento
    const discountedPrice = originalPrice - (originalPrice * (discountPercentage / 100));

    // Mostrar los precios
    priceOriginal.querySelector('span').textContent = `$${originalPrice.toFixed(2)} MXN`;
    priceDiscount.querySelector('span').textContent = `$${discountedPrice.toFixed(2)} MXN`;

    // Aplicar las clases dependiendo de si hay descuento
    if (discountPercentage > 0) {
      priceOriginal.classList.add('strikethrough');
      priceDiscount.classList.add('show');
    } else {
      priceOriginal.classList.remove('strikethrough');
      priceDiscount.classList.remove('show');
    }
  });
});
