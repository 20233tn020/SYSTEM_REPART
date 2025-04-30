document.addEventListener("DOMContentLoaded", () => {
  // Fragmentamos el número de teléfono real de forma más segura
  const p1 = "+52";
  const p2 = [7, 7, 7];
  const p3 = [1, 6, 3, 2];
  const p4 = [0, 8, 9];

  // Juntamos todo en un solo número como texto
  const numero = `${p1}${p2.join("")}${p3.join("")}${p4.join("")}`;

  // El mensaje para pre-poblar el chat de WhatsApp
  const mensaje = encodeURIComponent("¡Hola! Estoy interesado en sus servicios.");

  // Generar el enlace dinámicamente
  const link = `https://wa.me/${numero}?text=${mensaje}`;

  // Buscamos los elementos donde se insertará el enlace
  const whatsappLink = document.getElementById("whatsapp-link");
  const whatsappFloat = document.getElementById("whatsapp-float");

  // Asignamos el enlace a los elementos
  if (whatsappLink) {
    whatsappLink.href = link;
  }
  if (whatsappFloat) {
    whatsappFloat.href = link;
  }
});
