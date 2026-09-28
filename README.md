# Spiritual Tools

A collection of free spiritual calculators, built as standalone tools first and then integrated into WordPress. The repository is organised into three separate categories. They never share calculation methods, interpretation structures or rules unless that is explicitly decided.

```text
Spiritual Tools
│
├── Numerology Tools        (built, free)
├── Destiny Matrix Tools    (built, V1 free)
└── Astrology Tools         (future phase, not started)
```

---

## Contents

1. [Current status](#current-status)
2. [Repository structure](#repository-structure)
3. [Running locally](#running-locally)
4. [Project standards](#project-standards)
5. [Numerology standards](#numerology-standards)
6. [Destiny Matrix standards](#destiny-matrix-standards)
7. [The 22 Arcana](#the-22-arcana)
8. [The 7 Chakras](#the-7-chakras)
9. [The 26 Karmic Tails](#the-26-karmic-tails)
10. [Destiny Matrix reading sections](#destiny-matrix-reading-sections)
11. [Architecture: how a calculator works](#architecture-how-a-calculator-works)
12. [Adding a new calculator](#adding-a-new-calculator)
13. [WordPress integration](#wordpress-integration)

---

## Current status

| Category | Calculator | Page | Status |
| --- | --- | --- | --- |
| Numerology | Life Path Number | `numerology/life-path-number-calculator.html` | Built, PHP |
| Numerology | Destiny Number | `numerology/destiny-number-calculator.html` | Built, PHP |
| Numerology | Attitude Number | `numerology/attitude-number-calculator.html` | Built, PHP |
| Destiny Matrix | Destiny Matrix Chart | `destiny-matrix/destiny-matrix-calculator.html` | Built, PHP, full reading |
| Destiny Matrix | Compatibility Matrix | `destiny-matrix/compatibility-matrix-calculator.html` | Built, PHP, no reading written yet |
| Destiny Matrix | Karmic Tail | `destiny-matrix/karmic-tail-calculator.html` | Built, PHP, 26 readings |
| Astrology | Sun, Moon and Rising | `astrology/sun-moon-rising-calculator.html` | Empty placeholder |
| Astrology | Zodiac Sign | `astrology/zodiac-sign-calculator.html` | Empty placeholder |

All calculation logic, validation and interpretation lookup for the built calculators runs on the server in PHP. The browser only sends the user's input and displays the finished result.

---

## Repository structure

```text
spiritual-tools
├── README.md
├── .gitignore
├── assets
│   ├── css
│   │   ├── core/forms.css
│   │   ├── destiny-matrix/base.css
│   │   ├── numerology/base.css
│   │   └── astrology/
│   └── js
│       ├── core/forms.js                 shared form component (all categories)
│       ├── destiny-matrix/
│       │   ├── svg-geometry.js
│       │   └── ui-effects.js
│       └── astrology/
├── numerology
│   ├── life-path-number-calculator.html
│   ├── destiny-number-calculator.html
│   ├── attitude-number-calculator.html
│   ├── api/
│   │   ├── life-path-calculate.php
│   │   ├── destiny-number-calculate.php
│   │   └── attitude-number-calculate.php
│   └── php/
│       ├── engine.php                    shared numerology math
│       ├── life-path-data.php            interpretations
│       ├── destiny-number-data.php       interpretations
│       └── attitude-number-data.php      interpretations
├── destiny-matrix
│   ├── destiny-matrix-calculator.html
│   ├── compatibility-matrix-calculator.html
│   ├── karmic-tail-calculator.html
│   ├── api/
│   │   ├── destiny-matrix-calculate.php
│   │   ├── destiny-matrix-reading.php
│   │   ├── compatibility-matrix-calculate.php
│   │   └── karmic-tail-calculate.php
│   ├── php/
│   │   ├── engine.php                    shared Destiny Matrix engine (dm_)
│   │   ├── reading-builder.php           Destiny Matrix reading (dm_)
│   │   ├── compatibility-engine.php      Compatibility Matrix (cm_)
│   │   ├── karmic-engine.php             Karmic Tail (kt_)
│   │   ├── readings/                     guarded Destiny Matrix readings
│   │   └── karmic-readings/              guarded Karmic Tail readings
│   └── data/                             source JSON (authoring copies)
│       ├── destiny-matrix-readings/
│       ├── karmic-tail-readings/
│       └── compatibility-readings/
├── astrology                             future phase, placeholders only
├── tools
│   └── wrap-json.php                     converts source JSON into guarded PHP
├── docs
├── spiritual-calc-suite                  WordPress plugin folder (planned)
```

Notes:

- The `data/` folders hold the source JSON used for writing and editing interpretations. The live site reads the guarded PHP copies in the `php/` folders instead.
- The only browser-side scripts are `assets/js/core/forms.js` and `assets/js/destiny-matrix/ui-effects.js`. All calculation and interpretation logic lives in PHP. `svg-geometry.js` is an empty placeholder.

---

## Running locally

The calculators need PHP, so opening an HTML file by double-click, or with a static server such as Live Server, will not work.

Requirements:

- PHP 8 or newer
- The `mbstring` extension enabled (it is on by default in XAMPP)

From the repository root:

```text
php -S localhost:8000
```

Then open:

- `http://localhost:8000/numerology/life-path-number-calculator.html`
- `http://localhost:8000/destiny-matrix/destiny-matrix-calculator.html`

Any other calculator page works the same way, using its path from the structure above.

---

## Project standards

### 1. Three separate categories

Numerology, Destiny Matrix and Astrology stay separate. Do not carry calculation methods, monetization rules, interpretation structures or requirements from one category into another unless explicitly decided.

### 2. Standalone first

Every new calculator is first built as a standalone HTML file (HTML, embedded CSS and embedded JavaScript, with Google Fonts as the only external dependency). Before it goes into WordPress it must be:

1. UI tested
2. Calculation tested
3. Results verified
4. Fixed where needed
5. Confirmed working as a standalone tool

### 3. Calculation rules

- **New calculators** use recognised industry-standard rules unless another system is specified.
- **Existing calculators**: the confirmed calculation logic is the standard. It is not replaced because another website calculates differently.
- If several established methods exist and the intended one is unclear, the difference is explained and confirmed before choosing.

### 4. Confirmed decisions are requirements

Once a design, calculation rule, architecture or UI behaviour is confirmed, it is an established project requirement. A new requirement that conflicts with one is raised before anything changes.

### 5. Significant changes are explained first

Changes that could affect calculation results, existing functionality, data structures, interpretation content, architecture, WordPress integration or compatibility with other calculators are explained before they are implemented.

### 6. Results show the result only

Calculator output contains only the intended result and interpretation. It never carries footnotes or disclosures about how a method was chosen, which other site or implementation was used for comparison, internal development decisions, or which tools were used.

### 7. Dependencies

Prefer simple, self-contained code. No frameworks, libraries, external APIs, CDNs or build systems unless they are genuinely necessary or explicitly requested.

### 8. Deliverables

Work is delivered as complete, ready-to-use files with the filename identified, not as fragments to assemble. Existing functionality is preserved unless a change is explicitly requested. Unrelated parts are not changed.

### 9. Commits

After a change is confirmed correct, a Git commit message is offered. It is not created before confirmation.

---

## Numerology standards

Numerology tools are free standalone utilities. No subscription logic applies to them.

**Primary system: Pythagorean.**

- Letter values run in a repeating 1 to 9 cycle:

  | Value | Letters |
  | --- | --- |
  | 1 | A, J, S |
  | 2 | B, K, T |
  | 3 | C, L, U |
  | 4 | D, M, V |
  | 5 | E, N, W |
  | 6 | F, O, X |
  | 7 | G, P, Y |
  | 8 | H, Q, Z |
  | 9 | I, R |

- Chaldean values are never substituted into a Pythagorean calculator, or the other way round. Each calculator uses its own appropriate system.
- **Master numbers are 11, 22 and 33.** They are never reduced further at any stage of a calculation.
- Master numbers are displayed in the dual format **11/2, 22/4, 33/6**. The single-digit form is used only as a fallback for looking up an interpretation that has not been written for the master number yet. It never changes the displayed result.
- Every reading library covers the numbers **1 to 9, 11, 22 and 33**.

| Calculator | Input | What it uses |
| --- | --- | --- |
| Life Path Number | Date of birth (dd/mm/yyyy) | Day, month and year |
| Destiny Number | Full birth name | Every letter of the name |
| Attitude Number | Date of birth (dd/mm/yyyy) | Day and month only, never the year |

Input rules shared by the numerology calculators:

- Dates are entered as dd/mm/yyyy, must be real calendar dates, and cannot be in the future.
- Names may contain Latin or Cyrillic letters, spaces and dashes.
- The result shows the working (each reduction step) and the interpretation.

For existing numerology calculators, the confirmed calculation logic is preserved unless a change is explicitly requested.

---

## Destiny Matrix standards

**Every point on the chart is an arcana number from 1 to 22.** Numbers above 22 are always reduced until they fall within 1 to 22. The chart holds 32 points, 8 purpose values and 8 rings of yearly points around the octagram.

The current Destiny Matrix Chart Calculator and Compatibility Matrix Calculator use established logic that has been verified. It is not silently replaced by another Destiny Matrix implementation. When results differ between systems, the actual calculation rules are investigated before anything is judged wrong.

**Version 1 is completely free.** There are no paid tiers, subscription restrictions, premium or VIP locks, teaser lines, "unlock more" messages or shortened interpretations. The free interpretation is complete as it stands. If paid tiers are introduced later, they add genuinely new sections, subsections or interpretation depth. The free content is not reduced to make room for them.

### The three Destiny Matrix calculators

| Calculator | Input | Output |
| --- | --- | --- |
| Destiny Matrix Chart | Name and date of birth | Full chart, chakra table and the full reading |
| Compatibility Matrix | Two dates of birth | Compatibility chart plus each partner's personal chart, on three tabs |
| Karmic Tail | Name and date of birth | The three bottom points of the chart and the matching Karmic Tail reading |

---

## The 22 Arcana

Every reading in the Destiny Matrix is keyed by arcana number. Names follow the project's reading library.

| No. | Numeral | Arcana |
| --- | --- | --- |
| 1 | I | The Magician |
| 2 | II | The High Priestess |
| 3 | III | The Empress |
| 4 | IV | The Emperor |
| 5 | V | The Hierophant |
| 6 | VI | The Lovers |
| 7 | VII | The Chariot |
| 8 | VIII | Strength |
| 9 | IX | The Hermit |
| 10 | X | Wheel of Fortune |
| 11 | XI | Justice |
| 12 | XII | The Hanged Man |
| 13 | XIII | Death |
| 14 | XIV | Temperance |
| 15 | XV | The Devil |
| 16 | XVI | The Tower |
| 17 | XVII | The Star |
| 18 | XVIII | The Moon |
| 19 | XIX | The Sun |
| 20 | XX | Judgement |
| 21 | XXI | The World |
| 22 | XXII | The Fool |

Project naming conventions:

- **8 is Strength and 11 is Justice.**
- **22 is The Fool.** It is the 22nd arcana; there is no arcana 0 in this system.
- In the Karmic Tail readings, arcana 22 is labelled "The Fool (higher octave)".

---

## The 7 Chakras

The chakra table runs from the crown down to the base, in this order:

| No. | Chakra |
| --- | --- |
| 1 | Sahasrara |
| 2 | Ajna |
| 3 | Vishuddha |
| 4 | Anahata |
| 5 | Manipura |
| 6 | Svadhisthana |
| 7 | Muladhara |

Each chakra is read across three dimensions: **Physics** (body), **Energy** and **Emotions**. The chakra library holds one written entry per chakra per arcana, which is 7 chakras across 22 arcana, or 154 entries.

---

## The 26 Karmic Tails

A Karmic Tail is defined by the three points stacked at the bottom of the chart, written as a cluster of three arcana numbers. Only these 26 clusters have a written reading.

Each reading contains:

- A badge with the tail name and its theme
- Three positions, each tied to one arcana: **Past-Life Origin**, **Present Tension** and **Resolution Direction**
- A **Shadow** block, an **Integrated** block and a **Where It Shows Up** block

| No. | Cluster | Karmic Tail | Theme |
| --- | --- | --- | --- |
| 1 | 18-6-6 | Love Magic | Love and Free Will |
| 2 | 21-10-7 | Warrior of Faith | Conviction and Choice |
| 3 | 18-6-15 | Dark Mage | Influence and Consent |
| 4 | 9-15-6 | World of Passions, Fairy Tales | Passion and Commitment |
| 5 | 9-9-18 | Wizard | Responsible Knowledge |
| 6 | 18-9-9 | Wizard (variant) | Knowledge and Solitude |
| 7 | 9-18-9 | Magical Sacrifice | Trust and Discernment |
| 8 | 12-16-4 | Emperor | Authority and Flexibility |
| 9 | 6-5-17 | Pride | Humility and Craft |
| 10 | 6-14-8 | Dictator | Power and Moderation |
| 11 | 21-4-10 | Oppressed Soul | Self-Worth and Initiative |
| 12 | 6-8-20 | Disappointment of One's Lineage | Family Expectations |
| 13 | 9-12-3 | Lonely Woman | Love and Self-Sufficiency |
| 14 | 21-10-16 | Spiritual Priest | Spiritual Integrity |
| 15 | 15-8-11 | Physical Aggression | Anger and Ethical Strength |
| 16 | 21-7-13 | Destruction, Death of Many Souls | Protection and Renewal |
| 17 | 12-19-7 | Warrior | Strength and Perspective |
| 18 | 3-7-22 | Prisoner, Unfree Soul | Inner Freedom |
| 19 | 18-3-12 | Physical Suffering | Body and Acceptance |
| 20 | 15-5-8 | Betrayal, Family Passions | Loyalty and Desire |
| 21 | 6-17-11 | Lost Talent | Talent and Discipline |
| 22 | 3-22-19 | Unborn Child | Belonging and New Beginnings |
| 23 | 3-13-10 | Self Destruction | Choosing Life and Renewal |
| 24 | 6-20-14 | Soul Sacrificed | Sacrifice and Balance |
| 25 | 15-20-5 | Rebel | Family and Belonging |
| 26 | 9-3-21 | Overseer | Power and Service |

If a chart produces a cluster that is not in this list, the page shows that the reading is still being written.

---

## Destiny Matrix reading sections

The Destiny Matrix Chart reading is built from these sections, in this order:

1. Your Core Self
2. Your Outer Presence
3. Your Soul's Journey
4. Your Hidden Talents
5. Your Love Energy
6. Your Relationship Pattern
7. Your Money Energy
8. Your Abundance Blocks
9. Your Life Path
10. Your Social Mission
11. Your General Purpose
12. Your Family Blueprint
13. Your Current Year Energy
14. Your Body and Energy Map
15. Your Legacy

The Karmic Programs section was removed from the reading and is not part of the current structure.

The source files are the JSON files in `destiny-matrix/data/destiny-matrix-readings/`. The interpretation guideline for writing them is kept there as `destiny-matrix-interpretation-guideline.docx`.

---

## Architecture: how a calculator works

Each calculator follows the same pattern:

```text
Browser page (HTML + form)  ──POST──▶  api/<calculator>-calculate.php
                                            │
                                            ├── requires php/<engine>.php   (math and validation)
                                            └── reads guarded readings      (interpretation text)
                            ◀──JSON──  header, numbers, finished reading HTML
```

- The **page** collects input, sends it to the endpoint, and renders what comes back.
- The **endpoint** validates input, calls the engine, and returns JSON. It accepts POST only.
- The **engine** owns the calculation. Each category has its own, with its own function prefix so they can never clash:
  - Numerology: `numerology/php/engine.php`
  - Destiny Matrix: `dm_` in `engine.php`, `cm_` in `compatibility-engine.php`, `kt_` in `karmic-engine.php`
- **Guarded files.** Every PHP file that is not an endpoint refuses to run unless an endpoint has defined the `SPIRITUAL_APP` constant, so opening one by URL returns "Forbidden".
- **Readings** are stored as guarded PHP files rather than plain JSON, so nobody can download them by guessing the address.

### Converting source JSON into guarded PHP

Whenever a source JSON reading file changes, regenerate the guarded copies from the repository root:

```text
php tools/wrap-json.php destiny-matrix/data/destiny-matrix-readings destiny-matrix/php/readings
php tools/wrap-json.php destiny-matrix/data/karmic-tail-readings destiny-matrix/php/karmic-readings
```

### Deployment rules: read before packaging or uploading

The repository is the working folder. It is never uploaded to the live site as it is. Only the WordPress plugin (`spiritual-calc-suite/`) is uploaded, and it must contain runtime files only.

**Include in the plugin:**

- The calculator pages
- `assets/` (only the CSS and JS files that pages actually load)
- The `api/` endpoints
- The `php/` folders, including the guarded readings (`readings/`, `karmic-readings/`) and the engines

**Never include in the plugin or upload to the live site:**

- Any `data/` folder (`destiny-matrix/data/`, `numerology/data/`, `astrology/data/`). These hold the readable source JSON of the readings.
- `tools/`
- `docs/`
- Any `.docx` file, including the interpretation guideline
- `.git/`, `README.md` and `.gitignore`
- Any plain `.json` reading file or plain JavaScript file that contains calculation formulas or interpretation text

**Rules for AI assistants:**

- Before building, converting or describing any plugin, upload or deployment package, check the package contents against the two lists above and warn the owner if anything from the "never include" list is present.
- List the folders that were left out of the package.
- Every PHP file that is not an endpoint must keep its `SPIRITUAL_APP` guard.
- Readings must reach the live site only as guarded PHP files, generated with `tools/wrap-json.php`. When a source JSON changes, regenerate its guarded copy.

---

## Adding a new calculator

1. Decide which category it belongs to. Check that no rule from another category is being carried over by accident.
2. Build it as a standalone HTML file with embedded CSS and JavaScript, using industry-standard rules for a new calculator.
3. Test the interface, test the calculation logic, and verify the results.
4. Confirm the standalone version works.
5. Move the logic to the server: add an engine function, an endpoint under the category's `api/` folder, and, if it has interpretations, a guarded readings file.
6. Reduce the HTML page to form input plus rendering of the endpoint's response.
7. Register it for WordPress (see below).
8. Only after it is confirmed correct, commit it.

---

## WordPress integration

Planned stack:

- Hello Elementor
- Elementor
- Code Snippets
- Paid Member Subscriptions
- Stripe
- XAMPP (local development)

The plan is one reusable plugin with a shortcode architecture, kept in `spiritual-calc-suite/`. A calculator is integrated through its calculator script plus a single registration line, so no separate WordPress plugin is created for each calculator.

A calculator is only integrated into WordPress after its standalone version has been verified.
