<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init();</script>

<!-- Countdown Timer -->
<script>
  const countdownDate = new Date("May 31, 2025 23:59:59").getTime();
  const countdownEl = document.getElementById("countdown");

  const x = setInterval(() => {
    const now = new Date().getTime();
    const distance = countdownDate - now;

    if (distance <= 0) {
      countdownEl.innerHTML = "¡Finalizado!";
      clearInterval(x);
      return;
    }

    const d = Math.floor(distance / (1000 * 60 * 60 * 24));
    const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const s = Math.floor((distance % (1000 * 60)) / 1000);

    countdownEl.innerHTML = `${d}d ${h}h ${m}m ${s}s`;
  }, 1000);
