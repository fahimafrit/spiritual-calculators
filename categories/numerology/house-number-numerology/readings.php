<?php
declare(strict_types=1);

/* Interpretation content for the House Number Numerology Calculator.
   Keyed by the final house number as a string: '1' to '9', plus the
   master numbers '11', '22' and '33'. Each entry is a title plus three
   labelled sections, in this order:
     The Energy of This Home, What It Supports, What to Balance
   Server-side only: never included from a browser request directly. */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

return [
    '1' => [
        'title' => 'The Pioneer\'s Home',
        'sections' => [
            ['The Energy of This Home', 'The 1 gives a home a sense of beginning. It feels bright and decisive, and it nudges everyone inside toward acting rather than waiting, and toward standing on their own feet.'],
            ['What It Supports', 'Independence, fresh starts, and solo ventures. It suits a first place of your own, a new chapter after a big change, or a home office where you are building something yourself.'],
            ['What to Balance', 'The same energy can isolate. Housemates may compete instead of cooperating, and it becomes easy to stop asking for help. Share decisions, and keep the door open to company.'],
        ],
    ],
    '2' => [
        'title' => 'The Harmony Home',
        'sections' => [
            ['The Energy of This Home', 'The 2 makes a home gentle and attentive. The mood of the people inside sets the mood of the house, and it works best when that mood is kind.'],
            ['What It Supports', 'Couples, close friendships, caring work, and patient, steady progress. It rewards cooperation over competition, and it is a good place to recover from a stressful stretch.'],
            ['What to Balance', 'Sensitivity cuts both ways. Tension tends to be absorbed rather than aired, and decisions can stall. Say what you need early, and keep one space calm and uncluttered.'],
        ],
    ],
    '3' => [
        'title' => 'The Creative Home',
        'sections' => [
            ['The Energy of This Home', 'The 3 fills a home with talk, colour, and activity. Ideas move easily here, and people tend to gather, laugh, and make things.'],
            ['What It Supports', 'Creative work, children, entertaining, and anyone who recharges around other people. A studio corner or a full dining table suits it well.'],
            ['What to Balance', 'Energy scatters here. Projects get started more often than finished, and fun can crowd out quiet. Finish what you begin, protect some stillness, and keep an eye on social spending.'],
        ],
    ],
    '4' => [
        'title' => 'The Foundation Home',
        'sections' => [
            ['The Energy of This Home', 'The 4 gives a home weight and order. It feels solid and dependable, and it asks for routine and follow-through more than improvisation.'],
            ['What It Supports', 'Saving, planning, steady careers, and practical, well-run households. It suits anyone laying down long-term roots, and things built slowly here tend to last.'],
            ['What to Balance', 'Too much structure can turn the house into a list of duties. Leave room for rest and play, and fix small repairs early, before they weigh on everyone.'],
        ],
    ],
    '5' => [
        'title' => 'The Adventurer\'s Home',
        'sections' => [
            ['The Energy of This Home', 'The 5 keeps a home in motion. It is open, with people, plans, and ideas passing through, and standing still is not in its nature.'],
            ['What It Supports', 'Travel, varied or flexible work, a busy social life, and people in a season of exploring. It handles shared households and changing circumstances well.'],
            ['What to Balance', 'Restlessness is the risk: routines slip, commitments feel loose, and settling is hard. A few fixed rituals, such as regular meals and sleep hours, give the freedom something to stand on.'],
        ],
    ],
    '6' => [
        'title' => 'The Family Home',
        'sections' => [
            ['The Energy of This Home', 'The 6 is the number most at ease with domestic life. A 6 home is warm and welcoming, with a natural pull toward cooking, hosting, and looking after one another.'],
            ['What It Supports', 'Families, lasting relationships, hospitality, and work that cares for others. Comfort and beauty matter here, and spending on them tends to feel worthwhile.'],
            ['What to Balance', 'One person usually ends up carrying everything. Share the load, ask for help, and do not mistake worrying for caring.'],
        ],
    ],
    '7' => [
        'title' => 'The Sanctuary Home',
        'sections' => [
            ['The Energy of This Home', 'The 7 makes a home quiet and private. It sits slightly apart from the world, and it suits thinking more than performing.'],
            ['What It Supports', 'Study, writing, research, remote work, spiritual practice, and recovery. It is a good fit for people who need silence to do their best work.'],
            ['What to Balance', 'The quiet can turn into withdrawal. Overthinking and isolation creep in, so keep a few regular contacts and make time to get outdoors.'],
        ],
    ],
    '8' => [
        'title' => 'The Achiever\'s Home',
        'sections' => [
            ['The Energy of This Home', 'The 8 gives a home a serious, purposeful tone. Goals are taken seriously here, and effort is expected to show a return.'],
            ['What It Supports', 'Business, leadership, property, and building wealth. It suits people with big professional ambitions, and a home office here tends to be productive.'],
            ['What to Balance', 'Work can swallow the house: long hours, money worries, and relationships that get scheduled last. Put rest and people on the calendar first.'],
        ],
    ],
    '9' => [
        'title' => 'The Humanitarian\'s Home',
        'sections' => [
            ['The Energy of This Home', 'The 9 widens a home beyond its own walls. It is open-hearted, with a sense that life here is bigger than the household, and that chapters are meant to end.'],
            ['What It Supports', 'Teaching, healing, creative and charitable work, and large, welcoming circles of people. It is a helpful place to be when you are closing one chapter and moving on to the next.'],
            ['What to Balance', 'Giving can run past what you have. Hold on to your boundaries, clear out what belongs to the past, and let things end without guilt.'],
        ],
    ],
    '11' => [
        'title' => 'The Visionary\'s Home',
        'sections' => [
            ['The Energy of This Home', 'The 11 is a master number, and beneath its charge sits the gentleness of a 2. This home feels sensitive and alive: moods register quickly and ideas arrive unannounced.'],
            ['What It Supports', 'Creative, spiritual, and teaching work, and people who are attuned to atmosphere. It is a good base for anyone following a calling.'],
            ['What to Balance', 'That sensitivity can become nerves: poor sleep, overwhelm, and anxiety. Keep the space calm and routines steady, and turn inspiration into small, practical steps.'],
        ],
    ],
    '22' => [
        'title' => 'The Master Builder\'s Home',
        'sections' => [
            ['The Energy of This Home', 'The 22 is a master number, and beneath it sits the discipline of a 4. This home feels weighty and purposeful, and it asks you to think in years rather than weeks.'],
            ['What It Supports', 'Large ventures, property, family legacy, and long-range projects built with patience and planning.'],
            ['What to Balance', 'The pressure is real, and perfectionism and overwork tend to follow it. Break goals into stages, share the load, and protect your rest.'],
        ],
    ],
    '33' => [
        'title' => 'The Healer\'s Home',
        'sections' => [
            ['The Energy of This Home', 'The 33 is a master number, and beneath it sits the warmth of a 6. This home feels open and quietly healing, and people tend to come here to be heard.'],
            ['What It Supports', 'Teaching, counselling, healing, community work, and households built around looking after others.'],
            ['What to Balance', 'Giving without limit leads to exhaustion and resentment. Set boundaries, accept help, and keep your own care on the list.'],
        ],
    ],
];