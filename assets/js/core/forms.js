'use strict';

/* ════════════════════════════════════════════════════════════════════
   assets/js/core/forms.js
   ════════════════════════════════════════════════════════════════════
   Shared input-form behavior for every calculator, across all tool
   categories (numerology, destiny-matrix, and later astrology).

   What lives here:
     - The markup for each known field type (date, name/text)
     - The canonical auto "/" date-masking behavior
     - Focus-advance from one field to the next as it's completed
     - Enter-key-submits on the last field
     - Reading/writing the shareable-link URL params (?dob=, ?name=,
       ?dob1=&dob2=, ...)

   What does NOT live here (stays in each calculator, unchanged):
     - validate() — the business rules for that specific calculator
     - calculateAndRender() / runCalculation() — the actual math and
       result rendering for that specific calculator

   Usage in a calculator's own <script>:

     const fields = FormKit.render(document.querySelector('.form-card'), 'dob-name');
     const dateInput = document.getElementById('date');
     const nameInput = document.getElementById('name');

     FormKit.wire(fields, {
       onSubmit: (values) => runCalculation(values.date, values.name),
     });

     FormKit.prefillFromUrl(fields, (values) =>
       runCalculation(values.date, values.name, { updateUrl: false })
     );

   Inside runCalculation, once a result is successfully shown:

     FormKit.updateUrlParams(fields, { date: calculationDate, name });

   Adding a new form type later (e.g. for astrology's date+time+place)
   is a matter of adding one entry to LAYOUTS below — every calculator
   that uses it gets the same markup and behavior automatically.
   ════════════════════════════════════════════════════════════════════ */

const FormKit = (function () {

  /* ---- Known form layouts -----------------------------------------
     Each field: id (also the URL param key unless urlParam is given),
     type ('date' or 'name'), label, placeholder, and optionally
     focusPlaceholder (placeholder shown only while the field has
     focus — used by two-dob's "Partner 1 / Partner 2" swap). */
  const LAYOUTS = {
    dob: {
      fields: [
        { id: 'date', type: 'date', label: 'Date of birth', placeholder: 'dd/mm/yyyy', urlParam: 'dob' },
      ],
    },
    name: {
      fields: [
        { id: 'name', type: 'name', label: 'Name', placeholder: 'Your name', urlParam: 'name' },
      ],
    },
    'dob-name': {
      fields: [
        { id: 'date', type: 'date', label: 'Date of birth', placeholder: 'dd/mm/yyyy', urlParam: 'dob' },
        { id: 'name', type: 'name', label: 'Name', placeholder: 'Your name', urlParam: 'name' },
      ],
    },
    'two-dob': {
      fields: [
        { id: 'date1', type: 'date', label: 'Date of birth', placeholder: 'Partner 1', focusPlaceholder: 'dd/mm/yyyy', urlParam: 'dob1' },
        { id: 'date2', type: 'date', label: 'Date of birth', placeholder: 'Partner 2', focusPlaceholder: 'dd/mm/yyyy', urlParam: 'dob2' },
      ],
    },
  };

  /* ---- Canonical auto "/" date-masking behavior ---------------------
     One implementation, used by every date field in every calculator.
     onComplete fires once, when the 8th digit (dd+mm+yyyy) is typed,
     so the caller can move focus to whatever comes next for that
     particular form (or do nothing, if this is the last field). */
  function maskDateInput(evt, onComplete) {
    const input = evt.target;
    const digits = input.value.replace(/\D/g, '').slice(0, 8);
    let formatted = digits;
    if (digits.length >= 4) {
      formatted = `${digits.slice(0, 2)}/${digits.slice(2, 4)}/${digits.slice(4)}`;
    } else if (digits.length >= 2) {
      formatted = `${digits.slice(0, 2)}/${digits.slice(2)}`;
    }
    input.value = formatted;
    if (digits.length === 8 && typeof onComplete === 'function') onComplete();
  }

  /* ---- Field markup -------------------------------------------------- */
  function fieldHtml(field) {
    if (field.type === 'date') {
      return `    <div class="field">
      <label for="${field.id}">${field.label}</label>
      <input id="${field.id}" type="text" placeholder="${field.placeholder}" maxlength="10" autocomplete="off" inputmode="numeric" />
    </div>`;
    }
    return `    <div class="field">
      <label for="${field.id}">${field.label}</label>
      <input id="${field.id}" type="text" placeholder="${field.placeholder}" autocomplete="off" />
    </div>`;
  }

  /* ---- render(mountEl, layoutKey, overrides) -------------------------
     Builds the field(s) + submit button and inserts them into mountEl
     (the .form-card div). overrides lets a specific calculator use
     different label/placeholder text for a field while sharing the
     same layout and behavior, e.g. destiny-number-calculator.html:

       FormKit.render(mount, 'name', {
         name: { label: 'Full birth name', placeholder: 'e.g. John Michael Smith' },
       });

     The reserved key overrides.submitLabel sets the button's own text
     (each calculator has its own call-to-action wording, e.g. "Create
     your chart", "Reveal my karmic tail") — it defaults to "Calculate".

     Returns the resolved field list (with overrides applied), which
     the calculator keeps and passes to wire() / prefillFromUrl() /
     updateUrlParams(). */
  function render(mountEl, layoutKey, overrides) {
    overrides = overrides || {};
    const layout = LAYOUTS[layoutKey];
    if (!layout) throw new Error(`FormKit: unknown layout "${layoutKey}"`);

    const fields = layout.fields.map((f) => Object.assign({}, f, overrides[f.id] || {}));
    const submitLabel = overrides.submitLabel || 'Calculate';

    mountEl.innerHTML = fields.map(fieldHtml).join('\n') + `\n    <button id="submit-btn">${submitLabel}</button>`;

    return fields;
  }

  /* ---- wire(fields, options) -----------------------------------------
     Attaches: date masking + focus-advance, the Partner-1/Partner-2
     style focus-placeholder swap where configured, Enter-key-submits
     on the last field, and the submit button's click handler.
     options.onSubmit(values) is called with the current field values
     (an object keyed by field id) whenever the form is submitted,
     whether by clicking Calculate or pressing Enter. */
  function wire(fields, options) {
    options = options || {};
    const inputs = fields.map((f) => document.getElementById(f.id));
    const submitBtn = document.getElementById('submit-btn');

    fields.forEach((field, i) => {
      const input = inputs[i];
      const isLast = i === fields.length - 1;
      // Advance to the next field when there is one. On the last field,
      // only a date field in a multi-field form advances to the submit
      // button on completion (this is how Compatibility Matrix's two
      // date fields already behaved) — a lone date field (Life Path,
      // Attitude) does not auto-focus the button, matching its existing
      // behavior, since Enter already submits from that field.
      const next = inputs[i + 1] || (isLast && fields.length > 1 ? submitBtn : null);

      if (field.type === 'date') {
        input.addEventListener('input', (evt) => {
          maskDateInput(evt, next ? () => next.focus() : undefined);
        });
      }

      if (field.focusPlaceholder) {
        const basePlaceholder = field.placeholder;
        input.addEventListener('focus', () => { input.placeholder = field.focusPlaceholder; });
        input.addEventListener('blur', () => { input.placeholder = basePlaceholder; });
      }
    });

    // Enter submits from the last field — matches how every existing
    // calculator wires it (earlier fields auto-advance on completion,
    // so only the final field needs an explicit Enter handler).
    const lastInput = inputs[inputs.length - 1];
    lastInput.addEventListener('keydown', (evt) => {
      if (evt.key === 'Enter') submitBtn.click();
    });

    if (typeof options.onSubmit === 'function') {
      submitBtn.addEventListener('click', (evt) => {
        evt.preventDefault();
        const values = {};
        fields.forEach((f, i) => { values[f.id] = inputs[i].value; });
        options.onSubmit(values);
      });
    }

    return { inputs, submitBtn };
  }

  /* ---- prefillFromUrl(fields, onFound) --------------------------------
     If every field's URL param is present (e.g. ?dob=12-03-1990 or
     ?dob1=...&dob2=...), fills the inputs and calls onFound(values) so
     the calculator can run the calculation immediately — the shared
     "open a link, see your result with no click required" behavior. */
  function prefillFromUrl(fields, onFound) {
    const params = new URLSearchParams(window.location.search);
    const values = {};

    for (const field of fields) {
      const raw = params.get(field.urlParam);
      if (raw == null) return; // require every field's param to be present, same as before
      values[field.id] = field.type === 'date' ? raw.replace(/-/g, '/') : raw;
    }

    fields.forEach((field) => {
      document.getElementById(field.id).value = values[field.id];
    });

    if (typeof onFound === 'function') onFound(values);
  }

  /* ---- updateUrlParams(fields, values) --------------------------------
     Swaps the shareable-link URL params in place after a successful
     calculation (no reload — everything is recalculated client-side
     from the URL, nothing is stored server-side). */
  function updateUrlParams(fields, values) {
    const url = new URL(window.location.href);
    fields.forEach((field) => {
      const raw = values[field.id];
      if (raw == null) return;
      url.searchParams.set(field.urlParam, field.type === 'date' ? String(raw).replace(/\//g, '-') : raw);
    });
    window.history.pushState({}, '', url);
  }

  return { LAYOUTS, render, wire, maskDateInput, prefillFromUrl, updateUrlParams };
})();
