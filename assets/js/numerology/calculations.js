'use strict';

/* ════════════════════════════════════════════════════════════════════
   NUMEROLOGY CORE — CALCULATION ENGINE
   Shared by every calculator under /numerology/ (Life Path, Expression
   Number, and whatever comes after — Soul Urge, Personality Number,
   compatibility tools, etc). This file owns ONLY the math: reduction
   rules, master-number handling, and letter-value systems. Each
   calculator's own <script> block owns its DOM/UI and reads from here.
   ════════════════════════════════════════════════════════════════════ */

const MASTER_NUMBERS = [11, 22, 33];

function isMasterNumber(number) {
  return MASTER_NUMBERS.indexOf(number) !== -1;
}

/**
 * Formats a number for display using the site's standard dual format
 * for master numbers — 11 -> "11/2", 22 -> "22/4", 33 -> "33/6" — and
 * plain digits otherwise. Used only for a final, labeled result
 * (e.g. "Life Path Number: 11/2"), not for intermediate chain steps.
 */
function formatDisplayNumber(number) {
  return isMasterNumber(number) ? `${number}/${reduceToSingleDigit(number)}` : String(number);
}

/**
 * Sums the digits of a number once (no reduction loop).
 * e.g. 1988 -> 1+9+8+8 -> 26
 */
function sumDigitsOnce(number) {
  return String(Math.abs(number))
    .split('')
    .reduce((sum, digit) => sum + Number(digit), 0);
}

/**
 * Reduces a number down to a single digit (1-9) or a master number
 * (11, 22, 33), and returns every intermediate value along the way —
 * including the starting number itself — so the calculator can render
 * the full "29 -> 11" style reduction chain, not just the end result.
 *
 * A master number is never reduced further, wherever it appears in
 * the chain: reduceKeepingMasterWithSteps(1994) -> [1994, 23, 5]
 * reduceKeepingMasterWithSteps(29)   -> [29, 11]        (stops at 11)
 * reduceKeepingMasterWithSteps(7)    -> [7]              (already done)
 */
function reduceKeepingMasterWithSteps(number) {
  const steps = [number];
  let value = number;
  while (value > 9 && !isMasterNumber(value)) {
    value = sumDigitsOnce(value);
    steps.push(value);
  }
  return steps;
}

/**
 * Reduces a master number down to its underlying single digit
 * (11 -> 2, 22 -> 4, 33 -> 6). Used only as a fallback lookup key for
 * interpretation content that hasn't been written for the master
 * number itself yet — never used to change the displayed result.
 */
function reduceToSingleDigit(number) {
  let value = number;
  while (value > 9) {
    value = sumDigitsOnce(value);
  }
  return value;
}

/* ── Letter values (Destiny Number, Soul Urge, etc) ───────────────── */

const LETTER_VALUES = buildLetterMap({
  1: 'ajs', 2: 'bkt', 3: 'clu', 4: 'dmv', 5: 'enw',
  6: 'fox', 7: 'gpy', 8: 'hqz', 9: 'ir',
});

const VOWELS = new Set(['a', 'e', 'i', 'o', 'u']);

function buildLetterMap(groups) {
  const map = {};
  Object.keys(groups).forEach((value) => {
    groups[value].split('').forEach((letter) => { map[letter] = Number(value); });
  });
  return map;
}

/**
 * Computes a name's numerology total. `filter` optionally narrows to
 * 'vowels' or 'consonants' (for Soul Urge / Personality Number
 * calculators later) — omit it to use every letter, as Destiny
 * Number does.
 *
 * Returns { total, breakdown } where breakdown is an array of
 * { letter, value } for every counted letter, in order, ready to
 * render as a letter-by-letter breakdown.
 */
function computeNameNumber(name, filter) {
  const letters = String(name).toLowerCase().split('').filter((ch) => /[a-z]/.test(ch));

  const counted = letters.filter((letter) => {
    if (filter === 'vowels') return VOWELS.has(letter);
    if (filter === 'consonants') return !VOWELS.has(letter);
    return true;
  });

  const breakdown = counted.map((letter) => ({ letter, value: LETTER_VALUES[letter] || 0 }));
  const total = breakdown.reduce((sum, entry) => sum + entry.value, 0);
  return { total, breakdown };
}

/* ── Date helpers (shared by every date-based calculator) ────────── */

function isValidCalendarDate(parsed, date) {
  if (!parsed || isNaN(date.getTime())) return false;
  return (
    date.getFullYear() === parsed.year &&
    date.getMonth() === parsed.month - 1 &&
    date.getDate() === parsed.day
  );
}

function parseDdMmYyyy(value) {
  const match = /^(\d{2})\/(\d{2})\/(\d{4})$/.exec(value);
  if (!match) return null;
  const [, dd, mm, yyyy] = match;
  return { day: +dd, month: +mm, year: +yyyy };
}

const MONTH_NAMES = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
  'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

function formatLongDate(day, month, year) {
  return `${day} ${MONTH_NAMES[month - 1]} ${year}`;
}

// Date-input auto-"/" masking now lives in assets/js/core/forms.js
// (FormKit.maskDateInput), shared by every calculator across all
// categories, so it isn't duplicated here anymore.

function titleCase(str) {
  return str.replace(/^[a-zа-яё]|[\- ][a-zа-яё]/g, (a) => a.toUpperCase());
}

function escapeHtml(str) {
  const div = document.createElement('div');
  div.textContent = str == null ? '' : String(str);
  return div.innerHTML;
}
