# REPO_MAP.md

## 1. Folder tree

```
spiritual-calculators/
├── calculate.php              # Public entry point — dispatches to handlers
├── core/
│   ├── registry.json          # Slug → category/folder/file map
│   ├── .htaccess
│   └── php/
│       ├── bootstrap.php      # Defines SPIRITUAL_APP, SPIRITUAL_ROOT
│       ├── dispatcher.php     # POST handling, input validation, JSON output
│       ├── http.php           # sc_json_response(), sc_error(), sc_require_post()
│       └── registry.php       # sc_registry(), sc_find_calculator()
├── categories/
│   ├── astrology/
│   │   ├── _shared/           # swetest.php, timezone.php, birth-data.php, aspects.php, tz-data.php
│   │   ├── davison-chart/     # page.html, handler.php
│   │   ├── birth-chart/       # page.html, handler.php
│   │   ├── sun-sign-calculator/  # page.html, handler.php, readings.php
│   │   ├── love-calculator/   # page.html, handler.php, readings.php
│   │   └── random-zodiac-sign-generator/  # page.html (no handler — client-side only)
│   ├── numerology/
│   │   ├── _shared/           # engine.php, render.php, name-calculator.php
│   │   ├── life-path-number/  # page.html, handler.php, readings.php
│   │   ├── attitude-number/   # page.html, handler.php, readings.php
│   │   ├── destiny-number/    # page.html, handler.php, readings.php
│   │   ├── maturity-number/   # page.html, handler.php, readings.php
│   │   ├── karmic-debt/       # page.html, handler.php, readings.php
│   │   ├── karmic-lessons/    # page.html, handler.php, readings.php
│   │   ├── soul-urge-number/  # page.html, handler.php, readings.php
│   │   ├── personality-number/ # page.html, handler.php, readings.php
│   │   ├── birthday-number/   # page.html, handler.php, readings.php
│   │   └── life-path-compatibility/  # page.html, handler.php
│   └── destiny-matrix/
│       ├── _shared/           # engine.php, compatibility-engine.php, karmic-engine.php, reading-builder.php, readings/ (PHP-wrapped JSON)
│       ├── destiny-matrix/    # page.html, handler.php
│       ├── compatibility-matrix/  # page.html, handler.php
│       ├── karmic-tail/       # page.html, handler.php
│       └── destiny-matrix/reading-handler.php  # Shared reading handler (registered as destiny-matrix-reading)
├── assets/
│   ├── css/
│   │   ├── core/forms.css     # Shared form styles
│   │   ├── astrology/base.css # Shared astrology result styles
│   │   ├── numerology/        # Numerology-specific styles
│   │   └── destiny-matrix/    # DM-specific styles
│   └── js/
│       ├── core/forms.js      # FormKit — shared form behavior
│       ├── astrology/zodiac.js    # Zodiac sign data (Zodiac.SIGNS, Zodiac.glyph)
│       └── astrology/chart-wheel.js  # ChartView — shared chart rendering
├── source/                    # Raw JSON source files (destiny-matrix only, ~15+ files)
├── storage/                   # Swiss Ephemeris binaries + .se1 ephemeris files
├── tools/
│   ├── wrap-json.php          # CLI: wraps .json → guarded .php
│   └── check-timezones.php
├── docs/
│   └── design-decisions.md
└── spiritual-calc-suite/      # .gitkeep only — plugin staging folder
```

## 2. Architecture

**Request flow:**

1. Browser loads `categories/<category>/<slug>/page.html`
2. Page's `<script>` calls `FormKit.render()` to build the form, then `FormKit.wire()` to handle submit
3. On submit, JS POSTs flat form fields to `calculate.php?slug=<slug>`
4. `calculate.php` requires `core/php/bootstrap.php` (defines `SPIRITUAL_APP`, `SPIRITUAL_ROOT`), then calls `sc_dispatch()`
5. `sc_dispatch()` in `dispatcher.php`:
   - Calls `sc_require_post()` — rejects non-POST
   - Reads `$_GET['slug']`, calls `sc_find_calculator($slug)`
   - `sc_find_calculator()` looks up slug in `core/registry.json`, validates the entry, builds path `categories/<category>/<folder>/<file>`, checks file exists
   - Validates `$_POST` keys/values (pattern + length limits)
   - `require`s the handler file — handler returns a closure
   - Calls `sc_json_response()` with the result
6. Handler closure receives `$input` array, returns result array (or `['valid' => false, 'errorsHtml' => ...]`)
7. JS receives JSON, renders result or shows error

**Key files:**
- `core/php/bootstrap.php` — defines `SPIRITUAL_APP` and `SPIRITUAL_ROOT` constants
- `core/php/http.php` — `sc_json_response()`, `sc_error()`, `sc_require_post()`
- `core/php/registry.php` — `sc_registry()` (loads registry.json), `sc_find_calculator()` (slug → handler path)
- `core/php/dispatcher.php` — `sc_dispatch()` (orchestrates the above)

## 3. Adding a calculator

**Registry entry format** (in `core/registry.json`):
```json
"slug-name": { "category": "category-name" }
```
Optional keys: `"folder"` (when folder ≠ slug), `"file"` (when handler file ≠ `handler.php`).

**Files needed in `categories/<category>/<slug>/`:**
- `page.html` — the calculator page (form + result display + JS)
- `handler.php` — returns `function (array $input): array`
- `readings.php` — (optional) returns array of interpretation text, keyed by result

**Handler contract:**
- Must start with `declare(strict_types=1);` and the `SPIRITUAL_APP` guard
- Must `require_once` any shared engines from `_shared/`
- Returns `['valid' => true, ...]` on success
- Returns `['valid' => false, 'errorsHtml' => '<p>...</p>']` on error

## 4. Shared code

| File | Used by | Purpose |
|------|---------|---------|
| `categories/numerology/_shared/engine.php` | All numerology calculators | Pythagorean numerology math |
| `categories/numerology/_shared/render.php` | All numerology calculators | Shared HTML rendering |
| `categories/numerology/_shared/name-calculator.php` | All numerology calculators | Name → number conversion |
| `categories/destiny-matrix/_shared/engine.php` | DM, compatibility-matrix, karmic-tail | DM calculation engine |
| `categories/destiny-matrix/_shared/compatibility-engine.php` | compatibility-matrix | Compatibility math |
| `categories/destiny-matrix/_shared/karmic-engine.php` | karmic-tail | Karmic tail math |
| `categories/destiny-matrix/_shared/reading-builder.php` | DM, compatibility-matrix, karmic-tail | Builds reading HTML from wrapped JSON |
| `categories/astrology/_shared/swetest.php` | davison-chart, birth-chart, sun-sign-calculator | Swiss Ephemeris wrapper |
| `categories/astrology/_shared/timezone.php` | davison-chart, birth-chart, sun-sign-calculator | Timezone detection |
| `categories/astrology/_shared/birth-data.php` | davison-chart, birth-chart, sun-sign-calculator | Birth data parsing |
| `categories/astrology/_shared/aspects.php` | davison-chart, birth-chart | Aspect computation |
| `assets/js/core/forms.js` | All calculators | FormKit — form rendering, validation, URL params |
| `assets/js/astrology/zodiac.js` | All astrology calculators | Zodiac sign data |
| `assets/js/astrology/chart-wheel.js` | birth-chart, davison-chart | ChartView — wheel + tables rendering |

## 5. Calculator status table

| Category | Slug | Folder | Registry slug | Status | System |
|----------|------|--------|---------------|--------|--------|
| numerology | life-path-number | categories/numerology/life-path-number/ | life-path-number | built | Pythagorean |
| numerology | attitude-number | categories/numerology/attitude-number/ | attitude-number | built | Pythagorean |
| numerology | destiny-number | categories/numerology/destiny-number/ | destiny-number | built | Pythagorean |
| numerology | maturity-number | categories/numerology/maturity-number/ | maturity-number | built | Pythagorean |
| numerology | karmic-debt | categories/numerology/karmic-debt/ | karmic-debt | built | Pythagorean |
| numerology | karmic-lessons | categories/numerology/karmic-lessons/ | karmic-lessons | built | Pythagorean |
| numerology | soul-urge-number | categories/numerology/soul-urge-number/ | soul-urge-number | built | Pythagorean |
| numerology | personality-number | categories/numerology/personality-number/ | personality-number | built | Pythagorean |
| numerology | birthday-number | categories/numerology/birthday-number/ | birthday-number | built | Pythagorean |
| numerology | life-path-compatibility | categories/numerology/life-path-compatibility/ | life-path-compatibility | built | Pythagorean |
| destiny-matrix | destiny-matrix | categories/destiny-matrix/destiny-matrix/ | destiny-matrix | built | DM engine |
| destiny-matrix | compatibility-matrix | categories/destiny-matrix/compatibility-matrix/ | compatibility-matrix | built | CM engine |
| destiny-matrix | karmic-tail | categories/destiny-matrix/karmic-tail/ | karmic-tail | built | KT engine |
| destiny-matrix | destiny-matrix-reading | categories/destiny-matrix/destiny-matrix/ | destiny-matrix-reading | built | Reading builder |
| astrology | davison-chart | categories/astrology/davison-chart/ | davison-chart | built | Swiss Ephemeris |
| astrology | birth-chart | categories/astrology/birth-chart/ | birth-chart | built | Swiss Ephemeris |
| astrology | sun-sign-calculator | categories/astrology/sun-sign-calculator/ | sun-sign-calculator | built | Swiss Ephemeris |
| astrology | love-calculator | categories/astrology/love-calculator/ | love-calculator | built | LOVES letter count |
| astrology | random-zodiac-sign-generator | categories/astrology/random-zodiac-sign-generator/ | (not registered) | built | Client-side only |

## 6. Guarded vs public files

**Guarded (SPIRITUAL_APP check — web server returns 403):**
- All `core/php/*.php` files
- All `categories/*/*/handler.php` files
- All `categories/*/*/readings.php` files
- All `categories/*/_shared/*.php` files
- All `categories/*/_shared/readings/*.php` files (wrapped JSON)
- `tools/wrap-json.php` (CLI-only, checks `PHP_SAPI !== 'cli'`)

**Public endpoints (no guard):**
- `calculate.php` — entry point, calls `sc_dispatch()`
- `categories/*/*/page.html` — calculator pages

**Public assets (no guard):**
- `assets/css/**/*.css`
- `assets/js/**/*.js`

**`tools/wrap-json.php`:**
- CLI-only tool, run from repo root: `php tools/wrap-json.php <source-folder> <destination-folder>`
- Reads `.json` files from source folder, wraps each in a guarded `.php` file with `SPIRITUAL_APP` check
- Output file returns `json_decode()` of the original JSON content
- Performs round-trip check to verify integrity
- Used to generate `categories/destiny-matrix/_shared/readings/*.php` from `source/destiny-matrix/*-readings/*.json`

## 7. Packaging

**spiritual-calc-suite plugin:**
- Staging folder: `spiritual-calc-suite/` (currently empty except `.gitkeep`)
- Should include: `calculate.php`, `core/`, `categories/`, `assets/`
- Must **never** include:
  - `source/` — raw JSON with formulas/interpretation text
  - `storage/` — Swiss Ephemeris binaries and ephemeris files
  - `tools/` — dev tools (wrap-json.php, check-timezones.php)
  - `docs/` — internal documentation
  - `.docx` files
  - `.git/` folder
  - `README.md`
  - `.gitignore`
  - Any plain `.json` or `.js` files containing formulas or interpretation text (must be wrapped/guarded)

## 8. Local dev

**Command:**
```
c:\xampp\php\php.exe -S localhost:8000
```

**PHP version:** 8.1+ (uses `declare(strict_types=1)`, typed properties, `never` return type, `readonly` where applicable)
