# Project Instructions for the AI

## 1. How to work with me

- Address me as Afrit. Reply in English only. Do not use emojis unless I ask for them or they are necessary.
- Guide me one step at a time. Do not hand me a full task list.
- I am not a professional developer and I work by vibe coding. Every file you give me must be complete and ready to use, with the filename clearly stated. Never give partial snippets.
- When modifying a file, give me the full revised file. Keep existing functionality, do not rewrite working code, and do not touch unrelated parts.
- Do not give alternative implementations unless there is a real architectural choice. Do not add unrelated features.
- Do not invent past decisions or files from other sessions (Claude, ChatGPT, Gemini). If something is missing, ask me.
- Once I confirm a decision, treat it as a project requirement. If a new request of mine conflicts with it, point out the conflict first.
- Before making changes that affect calculation results, existing features, data structures, interpretation content, architecture, WordPress integration or compatibility, explain the consequence if it is not obvious. Do not make broad architectural changes for a small request.
- Write repo change instructions (cleanups, file moves, git steps) as a prompt for OpenCode to execute. The exception is when I tell you to make the changes myself, as I did for the Davison step 3.
- Never commit to my local or remote repo. I commit and push myself.
- After I confirm a change is correct, ask: "Would you like a Git commit message for this change?" Do not write one beforehand.
- After providing any file or change, ask whether it needs a note in REPO_MAP.md.
- Do not update the README or docs/design-decisions.md for now.

## 2. Repo access rules

- At the start of a chat, read REPO_MAP.md from Project knowledge and treat it as the source of truth for repo structure. If it disagrees with my message, tell me.
- Do not scan, list, clone or browse the repo unless I ask or it is necessary.
- Open only files I name or that REPO_MAP.md points to. If you need another file, ask me for it.
- Never read the large JSON files in source/destiny-matrix/destiny-matrix-readings/ unless I instruct you to or it is necessary.
- When I give you a GitHub URL, fetch that exact file. Never use an older copy you may have, because the GitHub version may be more up to date.

## 3. Keep the three categories separate

- Spiritual Tools has three categories: Numerology, Destiny Matrix and Astrology.
- Never carry assumptions, calculation methods, monetization rules, interpretation structures or requirements from one category to another unless I say so.

## 4. Calculation standards

- New calculators must use recognized industry-standard rules, following what top-ranking websites do, unless I specify another system.
- Existing calculators keep their confirmed logic as the standard. Do not replace it just because another website differs.
- If several established methods exist and the intended one is unclear, explain the difference and ask me.

### Destiny Matrix
- The Chart and Compatibility calculators use MIT-licensed GitHub logic. It matches matrix-destiny.com, though not always thematrixofdestiny.com.
- Never silently swap this logic. If systems differ, investigate the actual rules first.

### Numerology
- These are free standalone tools with no subscription logic.
- Use the right system for each calculator. Do not use Chaldean in a Pythagorean calculator, or the reverse.
- The primary system is Pythagorean, with master numbers 11/22/33 shown as 11/2, 22/4, 33/6.
- Attitude Number always returns 1-9 only, with no master numbers at any step.
- Birthday Number is the day of the month as-is (born on the 25th gives 25), with no calculation.

### Astrology
- Calculations use the Swiss Ephemeris through swetest via PHP, which is what Davison uses.
- I will not pay for the Swiss Ephemeris professional license. The plan is to split the repo and make Astrology public later if needed.
- North Node is set to "True node" in Davison.

## 5. Monetization

- Destiny Matrix V1 is completely free. No paid tiers, premium or VIP locks, teaser lines, "unlock more" messages or shortened interpretations. The free interpretation must feel complete.
- If paid tiers come later, they will add genuinely new sections or depth. Do not make current content incomplete to prepare for that.

## 6. User-facing result rules

Results must never expose internal decisions. Do not add footnotes, sidenotes or methodology text about:

- how a method was chosen
- which external site was used for comparison
- which implementation influenced the calculator
- AI or tool choices
- why one algorithm beat another

This is why the Davison methodology blocks, server debug lines, Swiss Ephemeris and Open-Meteo credits and orb hints were removed.

## 7. Architecture and structure

### Standalone first
- Build each new calculator as a standalone HTML file (embedded CSS and JS, Google Fonts only). Then UI-test it, logic-test it, verify it and fix it. Only then integrate it into WordPress.
- I can explicitly tell you to skip this.

### Layout
- One folder per calculator at categories/<category>/<slug>/ (page.html, handler.php, readings).
- A shared core/ with the dispatcher (calculate.php?slug=...) and core/registry.json.
- Astrology shared code lives in categories/astrology/_shared/.
- Swetest programs and the .se1 files live in storage/.
- storage/ and source/ are kept out of web access.

### Hidden logic
- Calculation logic and interpretations must not be publicly visible.
- Readings are guarded PHP files, generated from source JSON with tools/wrap-json.php and regenerated whenever the source changes.
- Every non-endpoint PHP file keeps its SPIRITUAL_APP guard.
- Numerology currently stays on PHP with no real-time calculation. I may revert it to client-side JS later, with readings still fetched from guarded PHP, but only if needed.

### Reuse
- Reuse anything an existing tool already has.
- If a feature exists in only one tool and is better as a general feature, make it general and have the tools import it.
- Compatibility and derived calculators call shared engines instead of duplicating them.
- Astrology uses the repo's default UI and only global forms (FormKit), with no local forms per calculator.

### Dependencies
- Keep things simple and self-contained. No frameworks, libraries, APIs, CDNs or build systems unless genuinely necessary or requested.
- Having Node, Python, Git, VS Code or the Gemini API available is not a reason to use them.

### Placeholder content
- New numerology calculators (Soul Urge, Personality, Birthday Number) get one-line filler interpretations for each number until real readings exist.

## 8. WordPress and packaging

- Stack: Hello Elementor, Elementor, Code Snippets, Paid Member Subscriptions, Stripe and XAMPP, with Hostinger Unlimited as the host.
- Integration: use a reusable plugin-with-shortcode design. Each calculator is added mainly through its JS file plus one registration line, not its own plugin. The plugin folder is spiritual-calc-suite.
- Integrate only after the standalone version is verified, unless I tell you to skip that.

### What goes in the plugin
Runtime files only: the calculator pages, only the CSS and JS that pages actually load, the API endpoints, and the guarded PHP folders (readings and engines).

### What never goes in the plugin or on the live site
- source/, storage/, tools/ and docs/
- any .docx file
- .git, README.md and .gitignore
- any plain .json readings file or plain JS file containing formulas or interpretation text

Whenever I mention building a plugin, packaging, zipping, uploading or deploying, check the package against both lists, warn me if anything forbidden is present, and list the folders you left out.

### Host facts
- Hostinger runs PHP 8.5.6 on x86_64 Linux, with no FFI.
- exec and proc_open must be enabled in hPanel.
- Local dev uses XAMPP PHP 8.2.12 via c:\xampp\php\php.exe -S localhost:8000.

## 9. Form and UI/UX rules (form-rules.md)

1. **URL-based results**
   - Calculate opens the result on the same page under an updated dynamic URL.
   - The URL holds all data needed to reproduce the result, so a shared link recalculates in the other person's browser. Nothing is saved on the server.
   - Calculating again updates the URL, and browser back/forward recalculates results.
2. **Form architecture**
   - Calculator files contain no form markup or form logic.
   - Forms are shared by type (date-only, text-only, date+text, etc.). Every calculator needing that input type uses the same shared form, even if only one calculator uses it today.
3. **Date field (dd/mm/yyyy)**
   - Insert "/" immediately after the 2nd digit of the day and of the month. The user never types a separator or waits for it.
   - Backspace removes separators like ordinary characters, with no arrow keys, mouse or repeated presses needed.
4. **Time field (hh:mm:ss)**: same behavior, with ":" after the 2nd digit of hours and minutes, and the same seamless Backspace.
5. **Additional settings**: must include Reset settings, shown as a reset icon plus label only, with no border or background.
6. **SVG charts**: any calculator with an SVG needs a Download Chart button.
7. **Copy buttons**: on click, the text changes to "Copied" with an icon. The width must not change, and the button is not clickable again until the text reverts.
8. **Compatibility Matrix Calculator**: its dynamic date placeholders must stay exactly as they are. Do not modify them.
9. **Dates**
   - Display dates as dd/mm/yyyy site-wide.
   - Date validation (rules and wording) must be consistent with Destiny Matrix across every calculator.
   - Biorhythm: keep icons on chart buttons, make checked and unchecked cycle checkboxes clearly distinguishable, and keep Reset zoom visibly separate from them.

## 10. Calculator-specific decisions

- **Davison Chart (astrology)**
  - Verified against Astro-Seek and Augurine.
  - Lilith and Part of Fortune are included in aspects.
  - A 4-step refactor is in progress: aspects engine, birth-data parser, global form layout, then moving onto the default shell and astrology/base.css.
  - City search still uses Open-Meteo behind FormKit.setPlaceSearch, and that provider is undecided.
  - The live-site test on Hostinger has not been done.
- **Sun Sign**: date required, birth time and place optional. The exact Sun position comes from the Swiss Ephemeris in PHP.
- **Love Calculator**: takes two names (no birth data). It is server-side PHP, using the classic LOVES letter-count percentage, 6 score bands and 3 reading sections.
- **Life Path Compatibility (numerology)**: takes two birth dates and returns a score plus a pair reading.
- **Random Zodiac Sign Generator and Birth Chart**: requested, to be built to match top-ranking sites, and subject to the reuse rule.
- **Biorhythm**: integrate the standalone file into the repo using the repo's own UI rather than its own styling.
