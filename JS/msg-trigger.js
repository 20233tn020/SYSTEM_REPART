// Número codificado en base64 y luego invertido manualmente
const codificado = "==Q8O2z3Y6TM7c7z25zK".split('').reverse().join('');

// Función para decodificar Base64
function decodificar(base64) {
  try {
    return atob(base64);
  } catch (e) {
    return '';
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const numero = decodificar(codificado); // Resultado:
  const mensaje = encodeURIComponent("¡Hola! Estoy interesado en sus servicios.");
  const link = `https://wa.me/${numero}?text=${mensaje}`;

  const whatsappLink = document.getElementById("whatsapp-link");
  const whatsappFloat = document.getElementById("whatsapp-float");

  if (whatsappLink) whatsappLink.href = link;
  if (whatsappFloat) whatsappFloat.href = link;
});
