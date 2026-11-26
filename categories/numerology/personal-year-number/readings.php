<?php
declare(strict_types=1);

/* Interpretation content for the Personal Year Number Calculator.
   'year'  => single digit (1-9) => reading ['title' => ..., 'paragraphs' => [...]]
   'month' => single digit (1-9) => one-line theme for that Personal Month
   Both are keyed by a single digit: a Personal Year is always 1-9.
   Server-side only: never included from a browser request directly. */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

return [
    'year' => [
        '1' => [
            'title' => 'The Fresh Start',
            'paragraphs' => [
                'A Personal Year 1 opens a new nine-year cycle. Whatever has run its course is behind you, and the year asks you to begin again on your own terms. Ideas, projects, moves and decisions you start now set the direction for the next nine years, so it is worth acting on what you truly want rather than waiting for permission.',
                'Independence and initiative are rewarded this year. Take the lead, trust your own judgment and be willing to go first. The risk is impatience or going it alone when a little help would serve you. Plant carefully and keep your focus on the few things that matter, because you will be living with these beginnings for a long time.',
            ],
        ],
        '2' => [
            'title' => 'The Patient Partner',
            'paragraphs' => [
                'A Personal Year 2 is slower and quieter after the push of a 1. The seeds you planted last year need time to take root, and this year is about nurturing them rather than forcing results. Cooperation, listening and good timing matter more than speed, and progress often comes through other people.',
                'Relationships take centre stage, whether partnerships, friendships or working teams. You are more sensitive than usual, which is a strength when it helps you read a situation and a weakness when it makes you doubt yourself. Be patient, stay flexible and let things develop. Pushing hard for quick answers tends to backfire.',
            ],
        ],
        '3' => [
            'title' => 'The Creative Awakening',
            'paragraphs' => [
                'A Personal Year 3 brings energy back into your life. Words come more easily, your social circle widens and creative ideas want to be used rather than postponed. It is a good year for writing, speaking, performing, making things and simply enjoying people. Say yes to invitations and finish the project you keep talking about.',
                'The risk of a 3 year is scattering your energy. Too many plans, too many distractions or too much spending on pleasure can leave little finished at the end. Choose a few things to express well, keep your word, and let optimism lift you without letting it replace follow-through.',
            ],
        ],
        '4' => [
            'title' => 'The Foundation Builder',
            'paragraphs' => [
                'A Personal Year 4 is a year of work. The excitement of the previous year settles into routines, and the task is to build something solid from what you have started. Organise your finances, your health, your home and your plans. The tasks are often plain, but what you put in order this year tends to stay in order.',
                'Progress feels slower than you would like, and obstacles are practical ones such as paperwork, budgets and limits. Treat them as part of the building process, not as setbacks. Steady effort, discipline and attention to detail pay off later, and a patient approach now saves you from rework in the years ahead.',
            ],
        ],
        '5' => [
            'title' => 'The Turning Point',
            'paragraphs' => [
                'A Personal Year 5 sits at the middle of the nine-year cycle, and it brings change. Plans shift, opportunities appear without warning and the routines of the past year may stop fitting. Travel, new people, a new place or a new direction are all common. The year asks you to stay flexible and meet change with a steady head.',
                'Freedom is the theme, and so is the temptation to overdo it. Restlessness can lead to rash decisions, scattered commitments or excess. Say yes to the unexpected opening, but check the details before you leap. Used well, this year frees you from what was holding you back and teaches you to adapt.',
            ],
        ],
        '6' => [
            'title' => 'The Caretaker',
            'paragraphs' => [
                'A Personal Year 6 turns your attention to home, family and the people you are responsible for. Relationships deepen, and commitments such as marriage, children, a move or a household change are common. Others lean on you more than usual, and you are asked to give care, fairness and steady support.',
                'This is also a year to create harmony and beauty around you. The risk is taking on too much for others and neglecting yourself, or trying to fix problems that are not yours. Set sensible limits, give help freely where it is wanted and let your home and your closest relationships become more balanced.',
            ],
        ],
        '7' => [
            'title' => 'The Inner Journey',
            'paragraphs' => [
                'A Personal Year 7 is a quieter, more reflective year. After the demands of the previous year, you are drawn to step back, think, study and understand what you really believe. Time alone, learning, research and rest are not wasted this year. They are the work itself.',
                'Answers tend to come through reflection rather than action, so forcing outcomes or chasing results rarely works. You may feel more distant from others or less interested in social activity, and that is natural. Trust your instincts, look after your health and use the time to clarify what you want before the next stage begins.',
            ],
        ],
        '8' => [
            'title' => 'The Harvest of Effort',
            'paragraphs' => [
                'A Personal Year 8 is about results, achievement and the material side of life. Work, money, status and authority all come into focus. What you have built over recent years is tested and often rewarded, and this is a strong year for career moves, business decisions, investments and taking on more responsibility.',
                'Power and ambition bring their own challenges. Be fair in how you use your influence, manage money with care and avoid becoming so driven that you neglect people and health. Set clear goals, act with integrity and be realistic about what you can control. The rewards of this year last when they are earned honestly.',
            ],
        ],
        '9' => [
            'title' => 'The Closing Chapter',
            'paragraphs' => [
                'A Personal Year 9 closes the nine-year cycle. It is a year of completion, clearing out and letting go. Relationships, jobs, habits and beliefs that no longer fit may come to an end, and finishing old business is more productive than starting new ventures. Make room for what comes next by releasing what is done.',
                'Endings can feel emotional, but they are not losses. Forgive where you can, give generously and look back at what the last nine years have taught you. Avoid clinging to what is over or rushing into a new beginning. A clean finish this year gives your next cycle a far better start.',
            ],
        ],
    ],

    'month' => [
        '1' => 'New beginnings and taking the lead',
        '2' => 'Patience, cooperation and listening',
        '3' => 'Self-expression and social life',
        '4' => 'Groundwork, routines and steady effort',
        '5' => 'Change, movement and the unexpected',
        '6' => 'Home, family and responsibility',
        '7' => 'Reflection, study and rest',
        '8' => 'Work, money and results',
        '9' => 'Finishing, letting go and clearing space',
    ],
];
