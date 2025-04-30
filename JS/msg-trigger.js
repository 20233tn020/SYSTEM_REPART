document.addEventListener("DOMContentLoaded", () => {
  const numero = atob("KzUyNzc3MTYzMjA4OQ==").replace(/\D/g, ""); // Elimina el "+"
  const mensaje = encodeURIComponent("¡Hola! Estoy interesado en sus servicios.");
  const link = `https://wa.me/${numero}?text=${mensaje}`;

  const whatsappLink = document.getElementById("whatsapp-link");
  const whatsappFloat = document.getElementById("whatsapp-float");

  if (whatsappLink) whatsappLink.href = link;
  if (whatsappFloat) whatsappFloat.href = link;
});
