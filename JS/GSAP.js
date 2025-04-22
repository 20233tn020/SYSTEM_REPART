    
/// Esperar a que el DOM cargue
document.addEventListener("DOMContentLoaded", function () {
    gsap.registerPlugin(ScrollToPlugin, ScrollTrigger); // Registrar GSAP y ScrollTrigger

    const menuLinks = document.querySelectorAll(".hero "); 

    // Función para animar cada sección al aparecer
    function animateSection(section) {
        gsap.fromTo(section, 
            { opacity: 0, y: 100 }, // Estado inicial
            { opacity: 1, y: 0, duration: 1.2, ease: "power2.out" } 
        );
    }

    // Aplicar animación cuando la sección entra en pantalla
    gsap.utils.toArray("section").forEach(section => {
        ScrollTrigger.create({
            trigger: section,
            start: "top 80%", // Inicia cuando la sección está en el 80% de la vista
            onEnter: () => animateSection(section), 
        });
    });

    // Desplazamiento suave con animación al hacer clic en un enlace del menú
    menuLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            const targetId = this.getAttribute("href"); 

            // Solo evitar el comportamiento predeterminado si es un enlace interno (#)
            if (targetId.startsWith("#")) {
                e.preventDefault(); 
                const targetSection = document.querySelector(targetId); 

                if (targetSection) {
                    gsap.to(window, {
                        duration: 1.5, // Duración del desplazamiento
                        scrollTo: targetSection, // Mover a la sección
                        ease: "power2.inOut",
                        onComplete: () => animateSection(targetSection) // Reproducir animación al llegar
                    });
                }
            }
        });
    });
});
