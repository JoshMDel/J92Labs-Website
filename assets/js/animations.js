/* ==========================================================================
   J92 Labs — visual/interaction upgrade
   Scroll parallax, mouse parallax, card tilt, scroll-reveal, and a light
   canvas particle field. Pure progressive enhancement: every element this
   file touches is decorative or an animation *state* on top of markup that
   already works without it. If this script fails to load or GSAP fails to
   load, the site remains fully readable and usable.
   ========================================================================== */

(function () {
  "use strict";

  var reduceMotionQuery = window.matchMedia("(prefers-reduced-motion: reduce)");
  var coarsePointerQuery = window.matchMedia("(pointer: coarse)");
  var smallScreenQuery = window.matchMedia("(max-width: 900px)");

  var prefersReducedMotion = reduceMotionQuery.matches;
  var isCoarsePointer = coarsePointerQuery.matches;
  var isSmallScreen = smallScreenQuery.matches;

  var gsapReady = typeof window.gsap !== "undefined";
  var scrollTriggerReady = gsapReady && typeof window.ScrollTrigger !== "undefined";

  if (prefersReducedMotion) {
    document.documentElement.classList.add("reduced-motion");
  }
  document.documentElement.classList.add(gsapReady ? "js-enhanced" : "js-basic");

  if (scrollTriggerReady) {
    gsap.registerPlugin(ScrollTrigger);
  }

  /* ------------------------------------------------------------------------
     Scroll progress (lightweight, rAF-throttled, passive)
     Exposes --scroll-progress (0..1) on <html> for any CSS that wants it.
     ------------------------------------------------------------------------ */
  function initScrollProgress() {
    var ticking = false;

    function update() {
      var scrollTop = window.scrollY || document.documentElement.scrollTop;
      var height = document.documentElement.scrollHeight - window.innerHeight;
      var progress = height > 0 ? Math.min(1, Math.max(0, scrollTop / height)) : 0;
      document.documentElement.style.setProperty("--scroll-progress", progress.toFixed(4));
      ticking = false;
    }

    window.addEventListener(
      "scroll",
      function () {
        if (!ticking) {
          requestAnimationFrame(update);
          ticking = true;
        }
      },
      { passive: true }
    );

    update();
  }

  /* ------------------------------------------------------------------------
     Scroll reveal — fades/lifts existing content into view once, on first
     intersection. Skips entirely under reduced motion or without GSAP: the
     content is already visible by default (no JS-independent hidden state).
     ------------------------------------------------------------------------ */
  function initScrollReveal() {
    var els = document.querySelectorAll("[data-reveal]");
    if (!els.length || prefersReducedMotion || !scrollTriggerReady) {
      return;
    }

    els.forEach(function (el) {
      // Hero content gets its own immediate on-load entrance (initHeroEntrance)
      // rather than a scroll-triggered one — it's above the fold, and running
      // both would fight over the same opacity/y properties on page load.
      if (el.closest(".hero")) {
        return;
      }

      var group = el.closest("[data-reveal-group]");
      var index = 0;
      if (group) {
        index = Array.prototype.indexOf.call(group.querySelectorAll("[data-reveal]"), el);
      }
      var delay = Math.min(index * 0.08, 0.4);

      el.classList.add("reveal-init");

      ScrollTrigger.create({
        trigger: el,
        start: "top 88%",
        once: true,
        onEnter: function () {
          gsap.to(el, {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: "power2.out",
            delay: delay,
            onStart: function () {
              el.classList.remove("reveal-init");
              el.classList.add("reveal-in");
            },
          });
        },
      });
    });
  }

  /* ------------------------------------------------------------------------
     Hero entrance — staggers the existing hero content in on load. Text
     itself is never touched, only opacity/position of the existing elements.
     ------------------------------------------------------------------------ */
  function initHeroEntrance() {
    if (prefersReducedMotion || !gsapReady) {
      return;
    }

    var hero = document.querySelector(".hero");
    if (!hero) {
      return;
    }

    var targets = hero.querySelectorAll(".container > *");
    if (!targets.length) {
      return;
    }

    gsap.set(targets, { opacity: 0, y: 22 });
    gsap.to(targets, {
      opacity: 1,
      y: 0,
      duration: 0.9,
      ease: "power2.out",
      stagger: 0.12,
      delay: 0.15,
    });
  }

  /* ------------------------------------------------------------------------
     Hero/section scene scroll parallax — each layer moves at a speed set by
     its own data-depth, scrubbed precisely to that section's own scroll
     range (not the whole page).
     ------------------------------------------------------------------------ */
  function initSceneScrollParallax() {
    if (prefersReducedMotion || !scrollTriggerReady) {
      return;
    }

    document.querySelectorAll("[data-parallax-scene]").forEach(function (scene) {
      var section = scene.closest("section");
      if (!section) {
        return;
      }

      var layers = scene.querySelectorAll("[data-depth]");
      layers.forEach(function (layer) {
        var depth = parseFloat(layer.getAttribute("data-depth")) || 0.2;
        var travel = depth * (isSmallScreen ? -24 : -48); // yPercent

        gsap.to(layer, {
          yPercent: travel,
          ease: "none",
          scrollTrigger: {
            trigger: section,
            start: "top bottom",
            end: "bottom top",
            scrub: 0.6,
          },
        });
      });
    });

    // Fade the scroll indicator out as the homepage hero scrolls past.
    var indicator = document.querySelector(".scroll-indicator");
    var hero = document.querySelector(".hero");
    if (indicator && hero) {
      ScrollTrigger.create({
        trigger: hero,
        start: "top top",
        end: "bottom top",
        scrub: true,
        onUpdate: function (self) {
          gsap.set(indicator, { opacity: 1 - self.progress, y: self.progress * 20 });
        },
      });
    }
  }

  /* ------------------------------------------------------------------------
     Mouse parallax — desktop/fine-pointer only. Moves each scene layer a
     small amount (scaled by its own depth) toward the cursor position within
     its section. Disabled on touch devices entirely.
     ------------------------------------------------------------------------ */
  function initMouseParallax() {
    if (prefersReducedMotion || isCoarsePointer || !gsapReady) {
      return;
    }

    document.querySelectorAll("[data-parallax-scene]").forEach(function (scene) {
      var section = scene.closest("section");
      if (!section) {
        return;
      }

      var layers = Array.prototype.map.call(scene.querySelectorAll("[data-depth]"), function (layer) {
        return {
          depth: parseFloat(layer.getAttribute("data-depth")) || 0.2,
          setX: gsap.quickTo(layer, "x", { duration: 0.9, ease: "power3" }),
        };
      });

      section.addEventListener(
        "mousemove",
        function (e) {
          var bounds = section.getBoundingClientRect();
          var relX = (e.clientX - bounds.left) / bounds.width - 0.5; // -0.5..0.5
          layers.forEach(function (layer) {
            // Max travel ~20px for the deepest layer.
            layer.setX(relX * layer.depth * 40);
          });
        },
        { passive: true }
      );

      section.addEventListener("mouseleave", function () {
        layers.forEach(function (layer) {
          layer.setX(0);
        });
      });
    });
  }

  /* ------------------------------------------------------------------------
     Interactive card tilt — restrained perspective tilt toward the pointer.
     Desktop/fine-pointer only; returns smoothly to flat on pointer leave.

     Deliberately plain rAF + CSS transitions rather than GSAP here: it's
     the lower-complexity option for a self-contained per-element effect,
     and it avoids any risk of fighting scroll-reveal/mouse-parallax over
     shared transform properties on the same elements.
     ------------------------------------------------------------------------ */
  function initCardTilt() {
    if (prefersReducedMotion || isCoarsePointer) {
      return;
    }

    var primaryCards = document.querySelectorAll(".service-card, .icon-card, .price-card");
    var secondaryCards = document.querySelectorAll(".card, .addon-item, .why-item, .work-step, .step");

    function wire(card, maxTilt) {
      card.classList.add("tilt-card");

      var targetRX = 0;
      var targetRY = 0;
      var targetScale = 1;
      var rafPending = false;

      function apply() {
        card.style.transform =
          "perspective(800px) rotateX(" + targetRX.toFixed(2) + "deg) rotateY(" + targetRY.toFixed(2) + "deg) scale(" + targetScale + ")";
        rafPending = false;
      }

      function schedule() {
        if (!rafPending) {
          rafPending = true;
          requestAnimationFrame(apply);
        }
      }

      card.addEventListener(
        "pointermove",
        function (e) {
          var r = card.getBoundingClientRect();
          var px = (e.clientX - r.left) / r.width - 0.5;
          var py = (e.clientY - r.top) / r.height - 0.5;
          card.style.transitionDuration = "0.1s";
          targetRY = px * maxTilt;
          targetRX = -py * maxTilt;
          targetScale = 1.015;
          card.classList.add("tilt-active");
          schedule();
        },
        { passive: true }
      );

      card.addEventListener("pointerleave", function () {
        card.style.transitionDuration = "0.5s";
        targetRX = 0;
        targetRY = 0;
        targetScale = 1;
        card.classList.remove("tilt-active");
        schedule();
      });
    }

    primaryCards.forEach(function (card) {
      wire(card, 6);
    });
    secondaryCards.forEach(function (card) {
      wire(card, 3);
    });
  }

  /* ------------------------------------------------------------------------
     Canvas particle fields — small, restrained "digital node" fields.
     One instance per .hero-scene / .ambient-bg canvas. Pauses when off
     screen (IntersectionObserver) and when the tab is hidden. Draws a single
     static frame (no animation loop) under reduced motion.
     ------------------------------------------------------------------------ */
  function createParticleField(canvas, count) {
    var ctx = canvas.getContext("2d");
    if (!ctx) {
      return;
    }

    var dpr = Math.min(window.devicePixelRatio || 1, 2);
    var width = 0;
    var height = 0;
    var particles = [];
    var rafId = null;
    var visible = true;

    function resize() {
      var rect = canvas.parentElement.getBoundingClientRect();
      width = rect.width;
      height = rect.height;
      canvas.width = Math.max(1, Math.round(width * dpr));
      canvas.height = Math.max(1, Math.round(height * dpr));
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }

    function seed() {
      particles = [];
      for (var i = 0; i < count; i++) {
        particles.push({
          x: Math.random() * width,
          y: Math.random() * height,
          r: Math.random() * 1.6 + 0.6,
          vx: (Math.random() - 0.5) * 0.12,
          vy: (Math.random() - 0.5) * 0.12,
          a: Math.random() * 0.5 + 0.25,
        });
      }
    }

    function draw() {
      ctx.clearRect(0, 0, width, height);
      for (var i = 0; i < particles.length; i++) {
        var p = particles[i];
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fillStyle = "rgba(232, 100, 26, " + p.a + ")";
        ctx.fill();
      }
    }

    function step() {
      for (var i = 0; i < particles.length; i++) {
        var p = particles[i];
        p.x += p.vx;
        p.y += p.vy;
        if (p.x < 0) p.x = width;
        if (p.x > width) p.x = 0;
        if (p.y < 0) p.y = height;
        if (p.y > height) p.y = 0;
      }
      draw();
      if (visible && !prefersReducedMotion) {
        rafId = requestAnimationFrame(step);
      }
    }

    resize();
    seed();
    draw();

    if (!prefersReducedMotion) {
      var io = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            visible = entry.isIntersecting && document.visibilityState === "visible";
            if (visible && rafId === null) {
              rafId = requestAnimationFrame(step);
            } else if (!visible && rafId !== null) {
              cancelAnimationFrame(rafId);
              rafId = null;
            }
          });
        },
        { threshold: 0 }
      );
      io.observe(canvas);

      document.addEventListener("visibilitychange", function () {
        visible = document.visibilityState === "visible";
        if (visible && rafId === null) {
          rafId = requestAnimationFrame(step);
        } else if (!visible && rafId !== null) {
          cancelAnimationFrame(rafId);
          rafId = null;
        }
      });

      var resizeTimer = null;
      window.addEventListener(
        "resize",
        function () {
          clearTimeout(resizeTimer);
          resizeTimer = setTimeout(function () {
            resize();
            seed();
            draw();
          }, 200);
        },
        { passive: true }
      );

      rafId = requestAnimationFrame(step);
    }
  }

  function initParticles() {
    document.querySelectorAll(".hero-scene .scene-particles").forEach(function (canvas) {
      var scene = canvas.closest(".hero-scene");
      var count = parseInt(scene.getAttribute("data-particle-count"), 10) || 20;
      if (isSmallScreen) {
        count = Math.round(count * 0.45);
      }
      createParticleField(canvas, count);
    });

    var ambientCanvas = document.querySelector(".ambient-bg canvas");
    if (ambientCanvas) {
      createParticleField(ambientCanvas, isSmallScreen ? 12 : 30);
    }
  }

  /* ------------------------------------------------------------------------
     Boot
     ------------------------------------------------------------------------ */
  document.addEventListener("DOMContentLoaded", function () {
    initScrollProgress();
    initParticles();
    initScrollReveal();
    initHeroEntrance();
    initSceneScrollParallax();
    initMouseParallax();
    initCardTilt();
  });
})();
