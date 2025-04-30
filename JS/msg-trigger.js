// Número de WhatsApp en formato internacional
const whatsappNumber = "+527771632089";

// Inserta dinámicamente los enlaces de WhatsApp
document.addEventListener("DOMContentLoaded", () => {
  const mensaje = encodeURIComponent("¡Hola! Estoy interesado en sus servicios.");
  const link = `https://wa.me/${whatsappNumber}?text=${mensaje}`;

  const whatsappLink = document.getElementById("whatsapp-link");
  const whatsappFloat = document.getElementById("whatsapp-float");

  if (whatsappLink) whatsappLink.href = link;
  if (whatsappFloat) whatsappFloat.href = link;
});
