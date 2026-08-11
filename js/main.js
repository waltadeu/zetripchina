/* ZeTrip China — interactions */
(function () {
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (location.search.indexOf('nomotion') > -1) reduce = true;

  /* Lenis smooth scroll */
  var lenis;
  if (window.Lenis && !reduce) {
    lenis = new Lenis({ duration: 1.15, easing: function (t) { return Math.min(1, 1.001 - Math.pow(2, -10 * t)); }, smoothWheel: true });
    function raf(time) { lenis.raf(time); requestAnimationFrame(raf); }
    requestAnimationFrame(raf);
    window.__lenis = lenis;
  }

  /* anchor smooth links */
  document.querySelectorAll('a[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var id = a.getAttribute('href');
      if (id.length < 2) return;
      var el = document.querySelector(id);
      if (!el) return;
      e.preventDefault();
      closeMenu();
      if (lenis) lenis.scrollTo(el, { offset: -70 });
      else el.scrollIntoView({ behavior: 'smooth' });
    });
  });

  /* header scrolled state */
  var header = document.getElementById('header');
  function onScroll() { if (window.scrollY > 40) header.classList.add('scrolled'); else header.classList.remove('scrolled'); }
  window.addEventListener('scroll', onScroll); onScroll();

  /* mobile menu */
  var burger = document.getElementById('burger');
  var menu = document.getElementById('mobileMenu');
  function closeMenu() { if (menu) menu.classList.remove('open'); }
  if (burger) burger.addEventListener('click', function () { menu.classList.toggle('open'); });

  /* year */
  var y = document.getElementById('year'); if (y) y.textContent = new Date().getFullYear();

  /* GSAP */
  if (window.gsap) {
    gsap.registerPlugin(ScrollTrigger);

    /* hero masked reveal */
    if (!reduce) {
      gsap.to('.hero .line-mask > span', { y: '0%', duration: 1.1, ease: 'expo.out', stagger: 0.12, delay: 0.25 });
      gsap.to('.hero .reveal', { opacity: 1, y: 0, duration: 0.9, ease: 'power3.out', stagger: 0.12, delay: 0.7 });
      /* hero parallax */
      gsap.to('#heroBg', { yPercent: 18, ease: 'none', scrollTrigger: { trigger: '#hero', start: 'top top', end: 'bottom top', scrub: true } });
    } else {
      gsap.set('.hero .line-mask > span', { y: '0%' });
      gsap.set('.hero .reveal', { opacity: 1, y: 0 });
    }

    /* generic reveals (exclude hero, already handled) */
    gsap.utils.toArray('.reveal').forEach(function (el) {
      if (el.closest('.hero')) return;
      if (reduce) { gsap.set(el, { opacity: 1, y: 0 }); return; }
      gsap.to(el, { opacity: 1, y: 0, duration: 0.9, ease: 'power3.out', scrollTrigger: { trigger: el, start: 'top 90%' } });
    });

    /* stat counters */
    gsap.utils.toArray('.stat .num').forEach(function (el) {
      var target = parseInt(el.getAttribute('data-count'), 10);
      var suffix = el.getAttribute('data-suffix') || '';
      var numEl = el.querySelector('em');
      ScrollTrigger.create({
        trigger: el, start: 'top 90%', once: true,
        onEnter: function () {
          var obj = { v: 0 };
          gsap.to(obj, { v: target, duration: 1.6, ease: 'power2.out', onUpdate: function () { numEl.textContent = Math.round(obj.v); } });
        }
      });
    });
  } else {
    document.querySelectorAll('.reveal').forEach(function (e) { e.style.opacity = 1; e.style.transform = 'none'; });
    document.querySelectorAll('.line-mask > span').forEach(function (e) { e.style.transform = 'none'; });
  }
})();
