<?php
declare(strict_types=1);

/* Condensed interpretation content for the Lucky Number Calculator.
   Keyed by a single digit (1-9). Master numbers (11, 22, 33) and the
   day of birth resolve through their root digit before the lookup.
   One short block of 1-2 paragraphs per number -- no sub-sections/accordion.
   Server-side only: never included from a browser request directly. */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

return [
    '1' => [
        'title' => 'Lucky Number 1 — The Pioneer',
        'paragraphs' => [
            'Your lucky number is 1, the digit of beginnings, leadership, and independence. Fortune tends to smile on you when you act first and trust your own vision — new ventures, solo initiatives, and bold launches all carry your signature energy. The Sun rules this number, so visibility and originality are your secret weapons.',
            'To invite more luck, keep a few "1" rituals close at hand: start important tasks on the 1st, 10th, 19th, or 28th of the month, wear shades of gold or orange, and give yourself permission to go it alone when your instinct says yes. Your lucky colors are gold and orange, your lucky day Sunday, and the numbers 1 and 5 tend to open doors for you.',
        ],
    ],
    '2' => [
        'title' => 'Lucky Number 2 — The Diplomat',
        'paragraphs' => [
            'Your lucky number is 2, the digit of partnership, patience, and quiet intuition. Luck finds you through other people — collaborations, introductions, and one honest conversation at the right moment. Ruled by the Moon, you benefit from timing, tact, and trusting your gut about people.',
            'To strengthen your luck, say yes to teamwork, settle disputes rather than avoid them, and make decisions on the 2nd, 11th, 20th, or 29th of the month. Your lucky colors are white, cream, and soft pastels, your lucky days are Monday and Friday, and the numbers 2 and 6 vibrate most harmoniously with yours.',
        ],
    ],
    '3' => [
        'title' => 'Lucky Number 3 — The Expresser',
        'paragraphs' => [
            'Your lucky number is 3, the digit of creativity, communication, and joy. Opportunities arrive the moment you put yourself and your gifts out loud — writing, speaking, performing, or simply sharing an idea with enthusiasm. Jupiter rules this number, the planet of expansion and good fortune itself.',
            'To keep luck flowing, create something every week, surround yourself with cheerful company, and choose the 3rd, 12th, 21st, or 30th of the month for anything that needs an audience. Your lucky colors are yellow, pink, and turquoise, your lucky day is Thursday, and the numbers 3, 12, and 21 are especially fortunate for you.',
        ],
    ],
    '4' => [
        'title' => 'Lucky Number 4 — The Builder',
        'paragraphs' => [
            'Your lucky number is 4, the digit of stability, discipline, and foundations. Your luck is earned through steady effort — the more structure you build, the more chance has to work with. Ruled by Uranus, you are often rewarded exactly when you feel things are moving too slowly.',
            'To attract luck, keep your commitments, organize one corner of your life at a time, and sign, launch, or finalize on the 4th, 13th, 22nd, or 31st of the month. Your lucky colors are blue, grey, and earth tones, your lucky days are Saturday and Sunday, and the numbers 4 and 8 support your path.',
        ],
    ],
    '5' => [
        'title' => 'Lucky Number 5 — The Free Spirit',
        'paragraphs' => [
            'Your lucky number is 5, the digit of movement, variety, and quick wit. Luck follows you when you stay flexible — travels, meetings with strangers, and unplanned detours repeatedly turn into your best opportunities. Mercury rules this number, blessing you with adaptability and sharp communication.',
            'To multiply your luck, say yes to new experiences, change your routine before it stagnates, and use the 5th, 14th, or 23rd of the month for negotiations and travel plans. Your lucky colors are green and light grey, your lucky day is Wednesday, and the numbers 5 and 1 keep your energy in motion.',
        ],
    ],
    '6' => [
        'title' => 'Lucky Number 6 — The Nurturer',
        'paragraphs' => [
            'Your lucky number is 6, the digit of harmony, responsibility, and beauty. Fortune rewards you whenever you care for others or create comfort and balance around you — home, family, and community are where your blessings hide. Venus rules this number, drawing love, art, and prosperity toward you.',
            'To enhance your luck, beautify your living space, help someone without being asked, and mark the 6th, 15th, or 24th of the month for matters of the heart and home. Your lucky colors are pink, blue, and white, your lucky day is Friday, and the numbers 6 and 3 resonate most favorably with you.',
        ],
    ],
    '7' => [
        'title' => 'Lucky Number 7 — The Seeker',
        'paragraphs' => [
            'Your lucky number is 7, the digit of insight, analysis, and inner wisdom. Your luck arrives as knowing — hunches that prove right, research that pays off, and solitude that reveals what crowds conceal. Ruled by Neptune, you are protected when you honor your quieter instincts.',
            'To deepen your luck, keep time alone for reflection, study what fascinates you, and choose the 7th, 16th, or 25th of the month for decisions that need clarity rather than speed. Your lucky colors are violet, sea-green, and grey, your lucky days are Monday and Tuesday, and the numbers 7 and 2 walk beside you.',
        ],
    ],
    '8' => [
        'title' => 'Lucky Number 8 — The Achiever',
        'paragraphs' => [
            'Your lucky number is 8, the digit of ambition, authority, and material mastery. This is the number of abundance loops — what you put into the world with skill and integrity returns multiplied. Saturn rules this number, so your luck is bound to patience, but the payoff is lasting.',
            'To activate your luck, set measurable goals, negotiate from strength, and schedule money or career moves for the 8th, 17th, or 26th of the month. Your lucky colors are black, dark blue, and gold, your lucky day is Saturday, and the numbers 8 and 4 anchor your climb.',
        ],
    ],
    '9' => [
        'title' => 'Lucky Number 9 — The Humanitarian',
        'paragraphs' => [
            'Your lucky number is 9, the digit of completion, compassion, and broad perspective. Luck favors you when you finish old chapters generously and serve something larger than yourself — endings you handle with grace become beginnings you did not have to plan. Mars rules this number, giving your kindness its courage.',
            'To welcome luck, let go of what is complete, mentor or give back regularly, and use the 9th, 18th, or 27th of the month to close cycles and clear space for the new. Your lucky colors are red and rose tones, your lucky day is Tuesday, and the numbers 9 and 1 light your way forward.',
        ],
    ],
];
