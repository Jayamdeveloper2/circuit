(function () {
  "use strict";

  /* Preloader */
  window.addEventListener("load", function () {
    setTimeout(function () {
      const preloader = document.getElementById("preloader");
      if (preloader) preloader.classList.add("done");
      if (typeof AOS !== "undefined") {
        AOS.init({
          duration: 1000,
          easing: "ease-in-out",
          once: true,
          mirror: false,
        });
      }
    }, 700);
  });

  /* Sticky header + scroll top visibility */
  const hdr = document.getElementById("hdr");
  const st = document.getElementById("scrl-top");
  window.addEventListener(
    "scroll",
    function () {
      if (hdr) hdr.classList.toggle("scrolled", window.scrollY > 50);
      if (st) st.classList.toggle("on", window.scrollY > 400);
    },
    { passive: true },
  );

  /* Mobile nav */
  const burger = document.getElementById("burger");
  const mnav = document.getElementById("mnav");
  const mnx = document.getElementById("mnav-x");

  function openNav() {
    if (burger && mnav) {
      burger.classList.add("open");
      mnav.classList.add("open");
      document.body.style.overflow = "hidden";
      burger.setAttribute("aria-expanded", "true");
    }
  }

  function closeNav() {
    if (burger && mnav) {
      burger.classList.remove("open");
      mnav.classList.remove("open");
      document.body.style.overflow = "";
      burger.setAttribute("aria-expanded", "false");
    }
  }

  if (burger) burger.addEventListener("click", openNav);
  if (mnx) mnx.addEventListener("click", closeNav);
  if (mnav) {
    mnav.addEventListener("click", function (e) {
      if (e.target === mnav) closeNav();
    });
  }

  document.querySelectorAll(".mnav-links a").forEach(function (a) {
    a.addEventListener("click", closeNav);
  });

  if (mnx) {
    mnx.addEventListener("keydown", function (e) {
      if (e.key === "Enter") closeNav();
    });
  }

  /* ── CLEAN TEXT FADE ANIMATION (No Underline, No Cursor) ── */
  const heroTyped = document.getElementById("heroTyped");
  if (heroTyped) {
    const textLines = [
      "End-to-End Power Electronics Design",
      "EV and Renewable Energy Engineering",
      "SiC | GaN | High Voltage Systems",
      "Not a Layout Service. A Thinking Partner.",
      "Your Specialist Engineering Partner",
    ];

    let currentLine = 0;

    // Style the main element
    heroTyped.style.display = "inline-block";
    heroTyped.style.fontWeight = "700";
    heroTyped.style.letterSpacing = "-0.02em";
    heroTyped.style.color = "#ffffff";
    heroTyped.style.textShadow =
      "0 2px 12px rgba(0,0,0,0.3), 0 0 20px rgba(255,255,255,0.4)";
    heroTyped.style.transition = "opacity 0.4s ease";

    // Create text span
    const textSpan = document.createElement("span");
    textSpan.textContent = textLines[0];
    textSpan.style.display = "inline-block";
    textSpan.style.transition = "opacity 0.4s ease, transform 0.4s ease";

    // Clear and append
    heroTyped.innerHTML = "";
    heroTyped.appendChild(textSpan);

    // Main animation function - smooth text transition
    async function animateText() {
      while (true) {
        // Wait with current text
        await new Promise((resolve) => setTimeout(resolve, 3500));

        // Fade out current text
        textSpan.style.opacity = "0";
        textSpan.style.transform = "translateY(-5px)";

        // Wait for fade out
        await new Promise((resolve) => setTimeout(resolve, 600));

        // Change to next text
        currentLine = (currentLine + 1) % textLines.length;
        textSpan.textContent = textLines[currentLine];

        // Fade in new text
        textSpan.style.opacity = "1";
        textSpan.style.transform = "translateY(0)";

        // Wait before next cycle
        await new Promise((resolve) => setTimeout(resolve, 600));
      }
    }

    // Start the animation
    animateText();
  }

  /* Smooth scroll */
  document.querySelectorAll('a[href^="#"]').forEach(function (a) {
    a.addEventListener("click", function (e) {
      const id = a.getAttribute("href");
      if (id === "#") return;
      const tgt = document.querySelector(id);
      if (tgt) {
        e.preventDefault();
        const hdrEl = document.getElementById("hdr");
        const navhp = document.querySelector(".anchor-nav-hp, .anchor-nav-w");
        const off =
          (hdrEl ? hdrEl.offsetHeight : 80) +
          (navhp ? navhp.offsetHeight : 0) +
          10;
        window.scrollTo({
          top: tgt.getBoundingClientRect().top + window.pageYOffset - off,
          behavior: "smooth",
        });
      }
    });
  });

  /* ScrollSpy for Anchor Nav */
  const navLinks = document.querySelectorAll(
    ".anchor-nav-hp .btn-hs, .anchor-nav-w .btn-hs",
  );
  if (navLinks.length > 0) {
    const sections = Array.from(navLinks).map((link) =>
      document.querySelector(link.getAttribute("href")),
    );
    window.addEventListener(
      "scroll",
      () => {
        let current = "";
        const hdrEl = document.getElementById("hdr");
        const navhp = document.querySelector(".anchor-nav-hp, .anchor-nav-w");
        const off =
          (hdrEl ? hdrEl.offsetHeight : 80) +
          (navhp ? navhp.offsetHeight : 0) +
          100;

        sections.forEach((section) => {
          if (section) {
            const sectionTop = section.offsetTop;
            if (window.pageYOffset >= sectionTop - off) {
              current = "#" + section.getAttribute("id");
            }
          }
        });

        navLinks.forEach((link) => {
          link.classList.remove("active");
          if (link.getAttribute("href") === current) {
            link.classList.add("active");
          }
        });
      },
      { passive: true },
    );
  }

  /* Scroll reveal & Count-up */
  const wows = document.querySelectorAll(".wow");
  if ("IntersectionObserver" in window) {
    const ro = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add("in");

            if (entry.target.classList.contains("cnt-card")) {
              const valEl = entry.target.querySelector(".cnt-num");
              if (valEl) {
                const target = parseInt(valEl.getAttribute("data-target"));
                let current = 0;
                const duration = 2000;
                const stepTime = Math.max(duration / target, 16);
                const timer = setInterval(() => {
                  current += Math.ceil(target / (duration / stepTime));
                  if (current >= target) {
                    valEl.textContent = target;
                    clearInterval(timer);
                  } else {
                    valEl.textContent = current;
                  }
                }, stepTime);
              }
            }
            ro.unobserve(entry.target);
          }
        });
      },
      {
        threshold: 0.1,
        rootMargin: "0px 0px -40px 0px",
      },
    );
    wows.forEach(function (w) {
      ro.observe(w);
    });
  } else {
    wows.forEach((w) => {
      w.classList.add("in");
      const valEl = w.querySelector(".cnt-num");
      if (valEl) valEl.textContent = valEl.getAttribute("data-target");
    });
  }

  /* Interactive Tech Tabs */
  const tabBtns = document.querySelectorAll(".tab-btn");
  const tabPanes = document.querySelectorAll(".tab-pane");

  if (tabBtns.length > 0) {
    tabBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        const targetTab = btn.getAttribute("data-tab");
        tabBtns.forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");
        tabPanes.forEach((pane) => {
          pane.classList.remove("active");
          if (pane.id === targetTab) {
            pane.classList.add("active");
          }
        });
      });
    });
  }

  /* Why Choose Count-Up */
  const countEls = document.querySelectorAll(".wc-count");
  if (countEls.length) {
    const observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            const el = entry.target;
            const target = parseInt(el.getAttribute("data-count"), 10);
            const duration = 1500;
            const step = Math.ceil(duration / target);
            let current = 0;
            el.textContent = "0";
            const timer = setInterval(function () {
              current++;
              el.textContent = current;
              if (current >= target) {
                el.textContent = target;
                clearInterval(timer);
              }
            }, step);
            observer.unobserve(el);
          }
        });
      },
      { threshold: 0.5 },
    );
    countEls.forEach(function (el) {
      observer.observe(el);
    });
  }

  /* Blog Carousel */
  const blogTrackWrap = document.getElementById("blogTrackWrap");
  const btnPrev = document.getElementById("blogPrev");
  const btnNext = document.getElementById("blogNext");

  if (blogTrackWrap && btnPrev && btnNext) {
    let autoSlideTimer;
    const moveSlide = (direction) => {
      const card = blogTrackWrap.querySelector(".blog-card");
      const scrollAmount = card
        ? card.offsetWidth + 24
        : blogTrackWrap.clientWidth / 2;
      if (direction === "next") {
        if (
          blogTrackWrap.scrollLeft + blogTrackWrap.clientWidth >=
          blogTrackWrap.scrollWidth - 10
        ) {
          blogTrackWrap.scrollTo({ left: 0, behavior: "smooth" });
        } else {
          blogTrackWrap.scrollBy({ left: scrollAmount, behavior: "smooth" });
        }
      } else {
        blogTrackWrap.scrollBy({ left: -scrollAmount, behavior: "smooth" });
      }
    };
    const startAutoSlide = () => {
      clearInterval(autoSlideTimer);
      autoSlideTimer = setInterval(() => moveSlide("next"), 4000);
    };
    btnPrev.addEventListener("click", function () {
      moveSlide("prev");
      startAutoSlide();
    });
    btnNext.addEventListener("click", function () {
      moveSlide("next");
      startAutoSlide();
    });
    blogTrackWrap.addEventListener("mouseenter", () =>
      clearInterval(autoSlideTimer),
    );
    blogTrackWrap.addEventListener("mouseleave", startAutoSlide);
    startAutoSlide();
  }

  /* Assurance Cards Counter */
  const counterObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const card = entry.target;
          const numElement = card.querySelector(".assurance-num");
          if (numElement && !numElement.classList.contains("counted")) {
            const target = parseInt(numElement.getAttribute("data-target"));
            animateNumber(numElement, target);
            numElement.classList.add("counted");
          }
        }
      });
    },
    { threshold: 0.3 },
  );

  function animateNumber(element, target) {
    let current = 0;
    const increment = target / 50;
    const timer = setInterval(() => {
      current += increment;
      if (current >= target) {
        element.textContent = target;
        clearInterval(timer);
      } else {
        element.textContent = Math.floor(current);
      }
    }, 20);
  }

  document.querySelectorAll(".assurance-card").forEach((card) => {
    counterObserver.observe(card);
  });

  /* Scroll reveal for wow elements */
  const wowObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("in");
        }
      });
    },
    { threshold: 0.1 },
  );

  document.querySelectorAll(".wow").forEach((el) => wowObserver.observe(el));
})();
