### Folder Structure for: D:\\Learning SEO\\Website Files\\Tools Code\\Destiny Matrix Calculator\\destiny-matrix-calculator

Generated on: 09/16/2026 19:30:47

\--------------------------------------------------

.

|-- compatibility-matrix

|   |-- interpretations

|   |   +-- compatibility-manifest.json

|   +-- compatibility-matrix.html

|-- destiny-matrix

|   |-- interpretations

|   |   |-- chakras.json

|   |   |-- destiny-manifest.json

|   |   |-- destiny-matrix-interpretation-guideline.docx

|   |   |-- karmic-tail.json

|   |   |-- point-a.json

|   |   |-- point-b.json

|   |   |-- point-e.json

|   |   |-- point-f.json

|   |   |-- point-g.json

|   |   |-- point-h.json

|   |   |-- point-i.json

|   |   |-- point-o-p.json

|   |   |-- purpose-general.json

|   |   |-- purpose-personal.json

|   |   |-- purpose-planetary.json

|   |   |-- purpose-social.json

|   |   +-- year.json

|   +-- destiny-matrix.html

|-- docs

|   +-- design-decisions.md

|-- karmic-tail

|   |-- interpretations

|   |   +-- karmic-manifest.json

|   +-- karmic-tail.html

|-- shared

|   |-- engine

|   |   |-- calculations.js

|   |   +-- svg-geometry.js

|   +-- styles

|       +-- base.css

|-- exxtract.ps1

|-- folder\_structure.txt

+-- README.md







### Plan for Karmic Tail

\# Karmic Tail Calculator — Build Guide (Handoff)



This is a build spec for a standalone karmic tail calculator, part of Afrit's

"Spiritual Tools" project. Read this fully before writing any code — it

captures decisions already made so you don't need to re-derive them.



\---



\## 1. Project context



\- Repo: `fahimafrit/destiny-matrix-calculator` (public, GitHub, `main` branch)

\- Fetch fresh before editing anything:

&#x20; `curl -sL https://codeload.github.com/fahimafrit/destiny-matrix-calculator/tar.gz/refs/heads/main | tar -xzf - --strip-components=1 -C <workdir>/`

&#x20; Never reconstruct files from memory or assume a cached version is current.

\- This is one of three tool categories on the site (Numerology, Destiny

&#x20; Matrix, Astrology). This build belongs to \*\*Destiny Matrix\*\* — a commercial,

&#x20; tiered product (Free/Premium/VIP). The karmic tail calculator itself is a

&#x20; \*\*standalone, free, lightweight\*\* tool within that family — not gated,

&#x20; not the 10,000-word deep-content standard used for the full Destiny Matrix

&#x20; reading.

\- Afrit is a vibe-coder (non-developer). Every file must be complete and

&#x20; ready to use — no partial snippets requiring manual assembly.

\- Wait for explicit confirmation before committing. Hold commit-message

&#x20; suggestions until Afrit confirms a change is correct.



\---



\## 2. Files to deliver



Two deliverables, matching the repo's existing structure:



1\. \*\*`karmic-tail/karmic-tail.html`\*\* — currently a 0-byte placeholder in the

&#x20;  repo. This is the calculator shell: input form, calculation logic, SVG

&#x20;  chart, result rendering.

2\. \*\*`karmic-tail/interpretations/karmic-tail-standalone.json`\*\* — currently

&#x20;  a 0-byte placeholder. Holds all 26 adapted interpretation entries in a

&#x20;  single file (matches the pattern already used for

&#x20;  `destiny-matrix/interpretations/\*.json`).



Do \*\*not\*\* create a single giant portable file. Afrit explicitly does not

want a forced single-file build — reference the shared repo resources below

the same way the other two calculators do, to keep one source of truth for

math and styling.



\---



\## 3. Reuse existing repo resources — do not reinvent



\- \*\*`shared/engine/calculations.js`\*\* — contains `reduceNumber()`,

&#x20; `calculateYear()`, `calculatePoints(aPoint, bPoint, cPoint)`. This is the

&#x20; verified math engine shared by `destiny-matrix.html` and

&#x20; `compatibility-matrix.html`. Reference it the same way; do not duplicate

&#x20; the logic inline.

\- \*\*`shared/styles/base.css`\*\* — shared styling foundation.

\- \*\*Date → point derivation\*\* (confirmed present in `destiny-matrix.html`,

&#x20; not currently in the shared engine file — check current repo state and

&#x20; extract/reference consistently):

&#x20; ```

&#x20; apoint = reduceNumber(day)

&#x20; bpoint = month

&#x20; cpoint = calculateYear(year)

&#x20; ```

\- \*\*Karmic tail lookup key\*\*: `jpoint-rpoint-dpoint` (e.g. `18-9-9`).

&#x20; Produces exactly 26 distinct triplets. This key must match the 26 triplets

&#x20; listed in Section 6 below — verify against all valid birth dates before

&#x20; shipping.



\---



\## 4. Visual theme — confirmed, do not use Violet \& Gold here



\- The \*\*current design standard for Destiny Matrix Tools\*\* is the

&#x20; light-mode theme already live in `destiny-matrix.html` and

&#x20; `compatibility-matrix.html`: white background, deep navy (`#1a1040`)

&#x20; primary text/stroke, CSS custom properties `--color-navy`,

&#x20; `--color-lavender`, `--color-lavender-light`, Google Font Nunito.

\- "Celestial Violet \& Gold" (deep violet/gold, Cormorant Garamond +

&#x20; Nunito) is the \*\*Numerology Tools\*\* theme only. Do not use it here — this

&#x20; was explicitly corrected after an earlier wrong assumption in the source

&#x20; conversation.

\- Pull actual theme values from `shared/styles/base.css` and the live CSS

&#x20; in `destiny-matrix.html` — do not guess hex values from this guide.



\---



\## 5. SVG chart requirements — confirmed changes from the main chart



Base this on the existing octagram SVG in `destiny-matrix.html`

(`viewBox="-20 -45 690 685"`, id `matrix`), with these specific changes:



\- \*\*Show the full octagram\*\* — not a partial/tail-only render. Afrit

&#x20; confirmed the full chart is fine to show for free; only interpretation

&#x20; \*depth\* is tiered, not the chart itself.

\- \*\*Remove\*\* the group `<g id="age-tick-dots">` — these are the small dot

&#x20; markers (solid discs + hollow circles) on the octagon's edges. Confirmed:

&#x20; no dots on the octagon-forming line for this tool.

\- \*\*Remove\*\* year-range labels (the text elements inside the octagram

&#x20; showing age/year spans per ray, with directional `text-anchor` values).

\- \*\*Keep\*\*: the frame octagon path, the point structure, connecting lines.

\- \*\*Add\*\*: visual emphasis on the three karmic tail points specifically

&#x20; (the j/r/d points at the bottom of the chart) — e.g. distinct fill color,

&#x20; glow, or highlight ring — so it's visually clear what the tool is about

&#x20; even though the full chart is shown.



\---



\## 6. Content: the 26 karmic tails (canonical triplets)



Source of truth — from Afrit's canonical content system, immutable unless

Afrit explicitly changes it. The triplet is the only authoritative

identifier; names vary across sources but these are Afrit's chosen names.



| Triplet | Name |

|---|---|

| 18-6-6 | Love Magic / Love and Free Will |

| 21-10-7 | Warrior of Faith / Conviction and Choice |

| 18-6-15 | Dark Mage / Influence and Consent |

| 9-15-6 | World of Passions, Fairy Tales / Passion and Commitment |

| 9-9-18 | Wizard / Responsible Knowledge |

| 18-9-9 | Wizard (variant) / Knowledge and Solitude |

| 9-18-9 | Magical Sacrifice / Trust and Discernment |

| 12-16-4 | Emperor / Authority and Flexibility |

| 6-5-17 | Pride / Humility and Craft |

| 6-14-8 | Dictator / Power and Moderation |

| 21-4-10 | Oppressed Soul / Self-Worth and Initiative |

| 6-8-20 | Disappointment of One's Lineage / Family Expectations |

| 9-12-3 | Lonely Woman / Love and Self-Sufficiency |

| 21-10-16 | Spiritual Priest / Spiritual Integrity |

| 15-8-11 | Physical Aggression / Anger and Ethical Strength |

| 21-7-13 | Destruction, Death of Many Souls / Protection and Renewal |

| 12-19-7 | Warrior / Strength and Perspective |

| 3-7-22 | Prisoner, Unfree Soul / Inner Freedom |

| 18-3-12 | Physical Suffering / Body and Acceptance |

| 15-5-8 | Betrayal, Family Passions / Loyalty and Desire |

| 6-17-11 | Lost Talent / Talent and Discipline |

| 3-22-19 | Unborn Child / Belonging and New Beginnings |

| 3-13-10 | Self Destruction / Choosing Life and Renewal |

| 6-20-14 | Soul Sacrificed / Sacrifice and Balance |

| 15-20-5 | Rebel / Family and Belonging |

| 9-3-21 | Overseer / Power and Service |



\### Existing deep content — use as source material, not verbatim



`destiny-matrix/interpretations/karmic-tail.json` already has full content

for all 26 triplets (3 subsections each: "What You Carried In From Before",

"How It Shows Up in This Life", "The Lesson You Are Here to Complete",

\~300–330 words per entry). This is the \*\*deep version used in the full

Destiny Matrix reading\*\* — do not copy it verbatim into the standalone

tool. Reasons (confirmed with Afrit):



\- \*\*SEO\*\*: duplicate content across two URLs causes keyword cannibalization;

&#x20; Google will suppress one page's ranking for "karmic tail" search terms.

\- \*\*Brand credibility\*\*: identical text on both pages reads as templated,

&#x20; undermines the sense of a deep, distinct system.

\- \*\*Monetization incentive\*\*: if the free standalone content says the same

&#x20; thing as the full reading, there's no reason for users to go deeper.



Use the deep-version entries as reference material to adapt from (they are

self-contained — no cross-references to other chart points, so they're

safe as a starting point), but rewrite each into new wording.



\### Arcana reference (Rider-Waite-Smith numbering — confirmed to use this ordering)



Afrit confirmed using Rider-Waite-Smith numbering, where Strength = VIII and

Justice = XI (note: this differs from Tarot de Marseille, where Strength = XI

and Justice = VIII — Waite swapped them in 1909 for Golden Dawn zodiac

correspondence reasons; use Rider-Waite-Smith per Afrit's explicit choice).



| # | Roman | Arcana name |

|---|---|---|

| 0 | — | The Fool |

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



\---



\## 7. Content structure per triplet — confirmed shape, one entry fully drafted



Each of the 26 entries needs:



1\. \*\*Position 1 — \[Roman numeral], \[Arcana name] (Past-Life Origin)\*\*: a

&#x20;  paragraph (3–5 sentences) on what this arcana represents as the

&#x20;  originating past-life energy for this specific triplet.

2\. \*\*Position 2 — \[Roman numeral], \[Arcana name] (Present Tension)\*\*: a

&#x20;  paragraph on how this arcana's energy is active/in tension in the

&#x20;  present life.

3\. \*\*Position 3 — \[Roman numeral], \[Arcana name] (Resolution Direction)\*\*:

&#x20;  a paragraph on what this arcana points toward as the growth/resolution

&#x20;  direction.

4\. \*\*Shadow\*\*: 1–2 sentences — the unconscious, unresolved expression of

&#x20;  the \*combined\* triplet.

5\. \*\*Integrated\*\*: 1–2 sentences — the resolved, integrated expression.

6\. \*\*Practical\*\*: 1 sentence — where this tends to show up in real life

&#x20;  (relationships, career, family, self-worth, etc.) — pick the 1–2

&#x20;  domains that are actually dominant for that specific triplet, not a

&#x20;  generic list.



\*\*Word count — resolved\*\*: target standard-to-slightly-above-industry-standard

length per triplet. The fully-drafted `12-16-4` example (below, \~350 words)

sits at roughly this target and should be treated as the reference length

for all 26 entries — not trimmed down. "Industry standard" here means the

typical length of a three-position karmic-tail reading on top-ranking

competitor sites (verified earlier in the source conversation); aim at or

slightly above that, not at the \~300-word deep-version length used for the

full Destiny Matrix reading, and not a short teaser either.



\### Approved/drafted examples



\*\*18-6-6 — Love Magic / Love and Free Will\*\* (approved in shorter 4-part

form, written \*before\* the three-position structure was added — needs the

three positions added to match the final structure above):



> \*\*Pattern\*\*: Your soul's past incarnation blurred the line between

> wanting someone and controlling them — love that bent another person's

> will, or love that bent yours. That history left an instinct to treat

> desire itself as dangerous, something to be managed rather than simply

> felt.

>

> \*\*Shadow\*\*: Left unexamined, this shows up as either withholding what

> you want out of fear of overstepping, or slipping into fixation, where a

> relationship starts to feel less like connection and more like a pull

> neither of you fully chose.

>

> \*\*Integrated\*\*: Resolved, it becomes the rare gift of wanting someone

> completely while leaving their choice untouched — love offered, not

> engineered, with nothing to secure because nothing was ever at risk of

> leaving.

>

> \*\*Practical\*\*: Shows up most in romantic pursuit and consent — notice

> the difference between persuading and pressuring.



\*\*12-16-4 — Emperor / Authority and Flexibility\*\* (fully drafted with the

three-position structure — treat this as the template to match for all

26, pending the word-count decision above):



> \*\*Position 1 — XII, The Hanged Man (Past-Life Origin)\*\*: In a past

> incarnation you occupied a role of enforced stillness before power was

> fully yours — held back, made to wait, forced into suspended authority

> while responsibility for outcomes already rested on you. That waiting

> taught your soul patience under pressure, but it also planted the belief

> that authority has to be earned through endurance, and once won, must

> never again be surrendered.

>

> \*\*Position 2 — XVI, The Tower (Present Tension)\*\*: That belief now

> collides with moments when a structure you've built — a plan, a

> position, a way things are "supposed" to run — needs to break so

> something truer can replace it. You likely experience necessary change

> as closer to collapse than progress, bracing against disruption even

> when it's exactly what a situation calls for.

>

> \*\*Position 3 — IV, The Emperor (Resolution Direction)\*\*: Your task is

> becoming an authority that doesn't need permanence to feel secure —

> command that can rebuild after a fall instead of only defending against

> one. When you stop treating necessary change as a threat, you arrive at

> real Emperor energy: stable leadership flexible enough to reorganize and

> still hold.

>

> \*\*Shadow\*\*: Rigidity at exactly the wrong moments — holding a decision

> past its usefulness, or reading a reasonable change of plan as a threat

> to your authority.

>

> \*\*Integrated\*\*: Authority people actually trust — firm enough to hold a

> position, open enough to adjust it when circumstances call for it.

>

> \*\*Practical\*\*: Shows up most in leadership roles — notice when

> adaptability starts to feel like weakness.



\---



\## 8. Non-negotiable output rules



\- \*\*Never\*\* include any footnote, sidenote, or visible explanation of the

&#x20; calculation method, tooling, or AI/model choices in the calculator

&#x20; result — for any tool in this project.

\- Master numbers (11, 22, 33): reduction stops at master numbers; dual

&#x20; format display (e.g. `22/4`); meaning lookups fall back to the fully

&#x20; reduced digit. (Confirm whether this applies within the karmic tail

&#x20; triplet math specifically, since the existing 26 triplets above are

&#x20; already-reduced values.)

\- \*\*Result URL rule\*\*: results must open under a new URL via query

&#x20; parameters or a hash, without a new server-side page. Opening that URL

&#x20; directly in any browser must auto-read the parameters, calculate, and

&#x20; display the result — no server-side storage.

\- Content voice: strict second-person singular, specificity over

&#x20; vagueness, no vague filler, no meta-references to "this system" or "this

&#x20; calculator" inside the interpretation text itself.

\- Do not propose any new interpretation section/structure without

&#x20; verifying it's standard practice on top-ranking Matrix of Destiny

&#x20; reference sites first (this guide's structure was already verified

&#x20; against competitor sites during the source conversation).

\- On LocalWP (nginx), standalone PHP does not execute — use WordPress REST

&#x20; API routes if any server logic is needed. Standalone HTML build-and-verify

&#x20; always happens before WordPress wiring.



\---



\## 9. Outstanding decisions before this is complete



1\. \*\*`18-6-6` needs its three positions written\*\* — it was drafted before

&#x20;  the position structure was finalized; only has Pattern/Shadow/

&#x20;  Integrated/Practical. Rewrite it to match the `12-16-4` template and

&#x20;  target length (\~350 words, standard-to-slightly-above-industry-standard,

&#x20;  per Section 7).

2\. Write the remaining 24 entries at the same target length and structure,

&#x20;  then verify programmatically (word count consistency, arcana-name

&#x20;  accuracy against Section 6's table, no forbidden meta-language) before

&#x20;  presenting to Afrit.

3\. Build `karmic-tail/karmic-tail.html`: input form → date parsing →

&#x20;  `calculatePoints()` via shared engine → derive `jpoint-rpoint-dpoint` →

&#x20;  look up matching entry in `karmic-tail-standalone.json` → render SVG

&#x20;  (Section 5) → render result text → apply URL query/hash rule (Section

&#x20;  8) → apply theme (Section 4).

4\. Confirm with Afrit before any git commit — do not suggest commit

&#x20;  messages until Afrit has reviewed and confirmed the output.

