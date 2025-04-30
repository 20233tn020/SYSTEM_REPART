document.addEventListener("DOMContentLoaded", () => {
  // Partes del número fragmentadas y disfrazadas
  const p1 = 52; // código país
  const p2 = [77, 77, 71];   // parte oculta: 777
  const p3 = [49, 54, 51, 50]; // 1632
  const p4 = [48, 56, 57];   // 089

  // Convertimos y armamos el número completo
  const numero = `${p1}${String.fromCharCode(...p2)}${String.fromCharCode(...p3)}${String.fromCharCode(...p4)}`;

  const mensaje = encodeURIComponent("¡Hola! Estoy interesado en sus servicios.");
  const link = `https://wa.me/${numero}?text=${mensaje}`;

  const whatsappLink = document.getElementById("whatsapp-link");
  const whatsappFloat = document.getElementById("whatsapp-float");

  if (whatsappLink) whatsappLink.href = link;
  if (whatsappFloat) whatsappFloat.href = link;
});
