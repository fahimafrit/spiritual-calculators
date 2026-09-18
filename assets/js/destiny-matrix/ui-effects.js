/* ============================================================
   shared/engine/ui-effects.js
   Small, dependency-free helpers shared by every calculator:

   - revealOnScroll(): fades/rises any [data-reveal] element into
     place the first time it scrolls near the viewport. Purely
     visual — respects prefers-reduced-motion by skipping straight
     to the visible state.

   - staggerReveal(elements, opts): marks a list of elements as
     [data-reveal] with an increasing --reveal-delay so they appear
     one after another instead of all at once. opts.from sets the
     entry direction (e.g. 'translate(-24px, 16px)' for a
     bottom-left "row" entrance); left unset, elements use the
     default straight bottom-to-top rise.

   - lazyMount(el, mountFn): defers running mountFn (e.g. fetching
     and rendering the interpretation reading) until el is about to
     scroll into view, instead of doing that work the moment a
     chart is calculated. This is independent of motion preference
     — it's a loading strategy, not an animation.

   - retrigger(el, className): removes then re-adds a class so its
     CSS animation restarts, used for content that updates in place
     (e.g. switching tabs) rather than being freshly inserted.

   - setupAnimatedDetails(container, opts): delegated click handler
     that animates a <details> element's open/close height with the
     Web Animations API (so it restarts correctly on every toggle,
     not just the first) and cross-fades its body content.

   The .form-card input section is never touched by this file.
   ============================================================ */
'use strict';

const UIEffects = (function () {
  const prefersReducedMotion = !!(window.matchMedia &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches);

  // Flip on the CSS gate. If this script never runs (blocked, error,
  // etc.) the gate stays off and [data-reveal] elements render fully
  // visible with no animation — never stuck hidden.
  document.documentElement.classList.add('js-reveal-ready');

  function revealOnScroll(root) {
    const scope = root || document;
    const targets = scope.querySelectorAll('[data-reveal]:not(.is-visible)');
    if (!targets.length) return;

    if (prefersReducedMotion || !('IntersectionObserver' in window)) {
      targets.forEach((el) => el.classList.add('is-visible'));
      return;
    }

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    targets.forEach((el) => observer.observe(el));
  }

  function staggerReveal(elements, options) {
    const opts = options || {};
    const from = opts.from || null; // null => CSS default (straight rise)
    const step = typeof opts.step === 'number' ? opts.step : 0.07;
    const start = typeof opts.start === 'number' ? opts.start : 0;
    const list = elements ? Array.prototype.slice.call(elements) : [];

    list.forEach((el, i) => {
      if (!el) return;
      el.setAttribute('data-reveal', '');
      if (from) el.style.setProperty('--reveal-from', from);
      el.style.setProperty('--reveal-delay', (start + i * step).toFixed(2) + 's');
    });

    revealOnScroll();
  }

  function lazyMount(el, mountFn, options) {
    if (!el || typeof mountFn !== 'function') return;
    const rootMargin = (options && options.rootMargin) || '200px 0px';

    if (!('IntersectionObserver' in window)) {
      mountFn();
      return;
    }

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        observer.unobserve(entry.target);
        mountFn();
      });
    }, { rootMargin });

    observer.observe(el);
  }

  function retrigger(el, className) {
    if (!el) return;
    el.classList.remove(className);
    void el.offsetWidth; // force reflow so the animation restarts
    el.classList.add(className);
  }

  /* Animates a <details> element's open/close height via WAAPI, and
     cross-fades its body's opacity alongside it. Attaches a single
     delegated listener to `container`, so it keeps working after the
     container's innerHTML is replaced (fresh calculation) without
     needing to be re-run. */
  function setupAnimatedDetails(container, options) {
    if (!container) return;
    const opts = options || {};
    const detailsSelector = opts.detailsSelector || 'details';
    const summarySelector = opts.summarySelector || 'summary';
    const bodySelector = opts.bodySelector || null;
    const duration = opts.duration || 300;
    const easing = opts.easing || 'ease-out';

    const state = new WeakMap(); // details el -> { animation, isClosing, isExpanding }

    function getState(details) {
      return state.get(details) || {};
    }
    function setState(details, patch) {
      state.set(details, Object.assign(getState(details), patch));
    }
    function getBody(details) {
      return bodySelector ? details.querySelector(bodySelector) : null;
    }

    function animateHeight(details, from, to, onFinish) {
      const st = getState(details);
      if (st.animation) st.animation.cancel();

      if (prefersReducedMotion) {
        onFinish();
        return;
      }

      const animation = details.animate(
        { height: [from + 'px', to + 'px'] },
        { duration, easing }
      );
      setState(details, { animation });
      animation.onfinish = () => { setState(details, { animation: null }); onFinish(); };
      animation.oncancel = () => { setState(details, { animation: null }); };
    }

    function shrink(details) {
      setState(details, { isClosing: true, isExpanding: false });
      const summary = details.querySelector(summarySelector);
      const startHeight = details.offsetHeight;
      const endHeight = summary ? summary.offsetHeight : 0;
      const body = getBody(details);
      if (body) body.style.opacity = '0';

      animateHeight(details, startHeight, endHeight, () => {
        details.open = false;
        details.style.height = '';
        setState(details, { isClosing: false });
      });
    }

    function expand(details) {
      setState(details, { isExpanding: true, isClosing: false });
      const startHeight = details.offsetHeight;
      details.open = true;
      const endHeight = details.scrollHeight;
      details.style.height = startHeight + 'px';

      const body = getBody(details);
      requestAnimationFrame(() => {
        if (body && !prefersReducedMotion) {
          body.style.opacity = '0';
          requestAnimationFrame(() => { body.style.opacity = '1'; });
        } else if (body) {
          body.style.opacity = '1';
        }
        animateHeight(details, startHeight, endHeight, () => {
          details.style.height = '';
          setState(details, { isExpanding: false });
        });
      });
    }

    container.addEventListener('click', (evt) => {
      const summary = evt.target.closest(summarySelector);
      if (!summary) return;
      const details = summary.closest(detailsSelector);
      if (!details || !container.contains(details)) return;

      evt.preventDefault();
      const st = getState(details);
      if (st.isClosing || !details.open) {
        expand(details);
      } else if (st.isExpanding || details.open) {
        shrink(details);
      }
    });
  }

  return { revealOnScroll, staggerReveal, lazyMount, retrigger, setupAnimatedDetails };
})();
