'use strict';

/* ════════════════════════════════════════════════════════════════════
   assets/js/astrology/zodiac.js
   ════════════════════════════════════════════════════════════════════
   The twelve zodiac signs, shared by every astrology page that needs
   them (Davison chart, Random Zodiac Sign Generator, and whatever
   follows). Facts only: no calculation formulas, no interpretation
   text. Link it before the page's own script:

     <script src="../../../assets/js/astrology/zodiac.js"></script>

   Zodiac.SIGNS   twelve entries in zodiac order, Aries first. Index 0-11
                  is also floor(ecliptic longitude / 30).
                  { name, glyph, symbol, dates, element, mode, ruler }
   Zodiac.VS      variation selector that forces text (not emoji)
                  presentation after a glyph.
   Zodiac.glyph(i)  the glyph of sign i, text presentation.
   ════════════════════════════════════════════════════════════════════ */

const Zodiac = (function () {

  const VS = '︎';

  const SIGNS = [
    { name: 'Aries',       glyph: '♈', symbol: 'The Ram',        dates: 'March 21 – April 19',        element: 'Fire',  mode: 'Cardinal', ruler: 'Mars' },
    { name: 'Taurus',      glyph: '♉', symbol: 'The Bull',       dates: 'April 20 – May 20',          element: 'Earth', mode: 'Fixed',    ruler: 'Venus' },
    { name: 'Gemini',      glyph: '♊', symbol: 'The Twins',      dates: 'May 21 – June 20',           element: 'Air',   mode: 'Mutable',  ruler: 'Mercury' },
    { name: 'Cancer',      glyph: '♋', symbol: 'The Crab',       dates: 'June 21 – July 22',          element: 'Water', mode: 'Cardinal', ruler: 'Moon' },
    { name: 'Leo',         glyph: '♌', symbol: 'The Lion',       dates: 'July 23 – August 22',        element: 'Fire',  mode: 'Fixed',    ruler: 'Sun' },
    { name: 'Virgo',       glyph: '♍', symbol: 'The Maiden',     dates: 'August 23 – September 22',   element: 'Earth', mode: 'Mutable',  ruler: 'Mercury' },
    { name: 'Libra',       glyph: '♎', symbol: 'The Scales',     dates: 'September 23 – October 22',  element: 'Air',   mode: 'Cardinal', ruler: 'Venus' },
    { name: 'Scorpio',     glyph: '♏', symbol: 'The Scorpion',   dates: 'October 23 – November 21',   element: 'Water', mode: 'Fixed',    ruler: 'Pluto' },
    { name: 'Sagittarius', glyph: '♐', symbol: 'The Archer',     dates: 'November 22 – December 21',  element: 'Fire',  mode: 'Mutable',  ruler: 'Jupiter' },
    { name: 'Capricorn',   glyph: '♑', symbol: 'The Sea-Goat',   dates: 'December 22 – January 19',   element: 'Earth', mode: 'Cardinal', ruler: 'Saturn' },
    { name: 'Aquarius',    glyph: '♒', symbol: 'The Water Bearer', dates: 'January 20 – February 18', element: 'Air',   mode: 'Fixed',    ruler: 'Uranus' },
    { name: 'Pisces',      glyph: '♓', symbol: 'The Fish',       dates: 'February 19 – March 20',     element: 'Water', mode: 'Mutable',  ruler: 'Neptune' },
  ];

  function glyph(i) {
    return SIGNS[i].glyph + VS;
  }

  return { SIGNS, VS, glyph };
})();
