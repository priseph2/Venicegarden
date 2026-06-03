/* ═══════════════════════════════════════════════════════════════
   Venice Gardens Distribution — Theme JavaScript
   ═══════════════════════════════════════════════════════════════ */

(function () {
  'use strict';

  /* ── Page Transition ───────────────────────────────────────── */
  const curtain = document.querySelector('.page-transition');

  function navigate(url) {
    if (!curtain) { window.location.href = url; return; }
    curtain.classList.remove('exit');
    curtain.classList.add('enter');
    curtain.addEventListener('animationend', () => { window.location.href = url; }, { once: true });
  }

  document.querySelectorAll('a[href]').forEach(link => {
    const href = link.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('mailto') ||
        href.startsWith('tel') || href.startsWith('http') ||
        link.target === '_blank' || link.hasAttribute('data-no-transition')) return;
    link.addEventListener('click', e => { e.preventDefault(); navigate(href); });
  });

  window.addEventListener('pageshow', () => {
    if (!curtain) return;
    curtain.classList.remove('enter');
    curtain.classList.add('exit');
  });

  /* ── Sticky Nav ────────────────────────────────────────────── */
  const nav = document.querySelector('.site-nav');
  if (nav) {
    const onScroll = () => nav.classList.toggle('scrolled', window.scrollY > 50);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ── Mobile Menu ───────────────────────────────────────────── */
  const toggle     = document.querySelector('.nav-toggle');
  const mobileMenu = document.querySelector('.mobile-menu');
  if (toggle && mobileMenu) {
    let open = false;
    toggle.addEventListener('click', () => {
      open = !open;
      toggle.classList.toggle('open', open);
      mobileMenu.classList.toggle('visible', open);
      document.body.style.overflow = open ? 'hidden' : '';
      toggle.setAttribute('aria-expanded', String(open));
    });
    mobileMenu.querySelectorAll('a').forEach(a => {
      a.addEventListener('click', () => {
        open = false;
        toggle.classList.remove('open');
        mobileMenu.classList.remove('visible');
        document.body.style.overflow = '';
        toggle.setAttribute('aria-expanded', 'false');
      });
    });
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape' && open) toggle.click();
    });
  }

  /* ── Scroll Reveal ─────────────────────────────────────────── */
  function initReveal() {
    const reveals = document.querySelectorAll('.reveal:not(.in)');
    if (!reveals.length) return;
    if ('IntersectionObserver' in window) {
      const obs = new IntersectionObserver((entries) => {
        entries.forEach(e => {
          if (e.isIntersecting) { e.target.classList.add('in'); obs.unobserve(e.target); }
        });
      }, { threshold: 0.1, rootMargin: '0px 0px -48px 0px' });
      reveals.forEach(r => obs.observe(r));
    } else {
      reveals.forEach(r => r.classList.add('in'));
    }
  }
  initReveal();

  /* ── Animated Counters ─────────────────────────────────────── */
  function initCounters() {
    const counters = document.querySelectorAll('[data-count]:not([data-counted])');
    if (!counters.length || !('IntersectionObserver' in window)) return;
    const cObs = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el  = entry.target;
        el.dataset.counted = '1';
        const end = parseFloat(el.dataset.count);
        const suf = el.dataset.suffix || '';
        const dur = 1800;
        const fps = 1000 / 60;
        const inc = end / (dur / fps);
        let cur = 0;
        const tick = () => {
          cur = Math.min(cur + inc, end);
          el.textContent = (Number.isInteger(end) ? Math.floor(cur) : cur.toFixed(1)) + suf;
          if (cur < end) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
        cObs.unobserve(el);
      });
    }, { threshold: 0.6 });
    counters.forEach(c => cObs.observe(c));
  }
  initCounters();

  /* ── Tabs (stores / country filter) ───────────────────────── */
  function initTabs() {
    document.querySelectorAll('[data-tabs]').forEach(container => {
      const btns   = container.querySelectorAll('.tab-btn');
      const panels = container.querySelectorAll('.tab-panel');
      btns.forEach(btn => {
        btn.addEventListener('click', () => {
          btns.forEach(b => b.classList.remove('active'));
          panels.forEach(p => p.classList.remove('active'));
          btn.classList.add('active');
          const target = container.querySelector('#' + btn.dataset.target);
          if (target) target.classList.add('active');
        });
      });
    });
  }
  initTabs();

  /* ── Stores Country Tabs ───────────────────────────────────── */
  function initStoresTabs() {
    document.querySelectorAll('.stores-tabs').forEach(nav => {
      const panelsContainer = document.getElementById(nav.dataset.tabs);
      if (!panelsContainer) return;
      const tabs   = nav.querySelectorAll('.stores-tab');
      const panels = panelsContainer.querySelectorAll('.stores-panel');
      tabs.forEach(tab => {
        tab.addEventListener('click', () => {
          tabs.forEach(t => t.classList.remove('active'));
          panels.forEach(p => p.classList.remove('active'));
          tab.classList.add('active');
          const target = panelsContainer.querySelector('[data-panel="' + tab.dataset.target + '"]');
          if (target) target.classList.add('active');
        });
      });
    });
  }
  initStoresTabs();

  /* ── Brand Filter ──────────────────────────────────────────── */
  function initBrandFilter() {
    document.querySelectorAll('[data-brand-filter]').forEach(filterWrap => {
      const filterBtns = filterWrap.querySelectorAll('[data-filter]');
      const grid = filterWrap.closest('[data-brand-grid]') || filterWrap.parentElement;
      const brandCards = grid ? grid.querySelectorAll('[data-category]') : [];
      filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
          filterBtns.forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          const f = btn.dataset.filter;
          brandCards.forEach(card => {
            const show = f === 'all' || card.dataset.category === f;
            card.style.display = show ? '' : 'none';
          });
        });
      });
    });
  }
  initBrandFilter();

  /* ── Parallax Hero ─────────────────────────────────────────── */
  const heroBg = document.querySelector('.hero-bg');
  if (heroBg) {
    window.addEventListener('scroll', () => {
      const y = window.scrollY;
      if (y < window.innerHeight) {
        heroBg.style.transform = `translateY(${y * 0.3}px)`;
      }
    }, { passive: true });
  }

  /* ── Contact Form (AJAX) ───────────────────────────────────── */
  function initContactForm() {
    const form = document.querySelector('.vg-contact-form');
    if (!form) return;
    form.addEventListener('submit', e => {
      e.preventDefault();
      const btn  = form.querySelector('[type=submit]');
      const orig = btn.innerHTML;
      btn.innerHTML = '<span style="opacity:.6">Sending…</span>';
      btn.disabled  = true;

      const data = new FormData(form);
      data.append('action', 'vg_contact_form');
      data.append('nonce', (window.vgAjax || {}).nonce || '');

      fetch((window.vgAjax || {}).url || '/wp-admin/admin-ajax.php', {
        method: 'POST',
        body:   data,
        credentials: 'same-origin',
      })
        .then(r => r.json())
        .then(res => {
          if (res.success) {
            form.style.display = 'none';
            const success = form.closest('.contact-card')?.querySelector('.form-success');
            if (success) success.style.display = 'block';
          } else {
            alert(res.data?.message || 'Error sending message. Please try again.');
            btn.innerHTML = orig;
            btn.disabled  = false;
          }
        })
        .catch(() => {
          btn.innerHTML = orig;
          btn.disabled  = false;
        });
    });
  }
  initContactForm();

  /* ── Cursor Glow (desktop only) ────────────────────────────── */
  if (window.matchMedia('(pointer: fine)').matches) {
    const glow = document.createElement('div');
    glow.style.cssText = 'position:fixed;width:320px;height:320px;border-radius:50%;background:radial-gradient(circle,rgba(201,151,42,0.05) 0%,transparent 70%);pointer-events:none;z-index:9998;transform:translate(-50%,-50%);top:-200px;left:-200px;';
    document.body.appendChild(glow);
    document.addEventListener('mousemove', e => {
      glow.style.left = e.clientX + 'px';
      glow.style.top  = e.clientY + 'px';
    });
  }

  /* ── Re-init after Elementor frontend renders (SPA/ajax) ───── */
  if (window.elementorFrontend) {
    window.elementorFrontend.hooks.addAction('frontend/element_ready/global', function () {
      initReveal();
      initCounters();
      initTabs();
      initStoresTabs();
      initBrandFilter();
      initContactForm();
    });
  }

})();
