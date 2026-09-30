<?php
declare(strict_types=1);

/* Interpretation content for the Karmic Debt Calculator.
   Keyed by karmic debt number (13, 14, 16, 19) plus 'none' for the
   clean-slate reading. Server-side only: never included from a
   browser request directly. */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

return [
    '13' => [
        'title' => 'Karmic Debt 13: The Debt of Effort',
        'sections' => [
            ['Essence', 'The old pattern here is avoidance: taking shortcuts, leaving work unfinished, or letting others carry what was yours. In this life, results come only through steady, honest effort, and progress often feels slower than you\'d like.'],
            ['Strengths', 'Once you commit, you develop rare endurance, discipline, and integrity. You become the person who can be counted on, and what you build through patient work lasts.'],
            ['Challenges', 'You may feel blocked, overburdened, or as if you have to work twice as hard as everyone else. The old pattern shows up as procrastination, resentment of routine, or looking for the easy way out. Frustration can turn into self-criticism or the urge to quit right before a breakthrough.'],
            ['Love', 'You take commitment seriously but may struggle to relax into it. You need a partner who shares the load fairly and reminds you that rest is not laziness.'],
            ['Career', 'Skilled trades, engineering, construction, accounting, operations, research, and any field where craftsmanship and consistency are rewarded over speed.'],
            ['Life lesson', 'There are no shortcuts, but there is meaning in the work. Do the next honest task, then the one after it.'],
        ],
    ],
    '14' => [
        'title' => 'Karmic Debt 14: The Debt of Freedom',
        'sections' => [
            ['Essence', 'The old pattern here is misused freedom: indulgence, excess, restlessness, or breaking commitments for the next thrill. In this life, you are learning that real freedom requires self-mastery.'],
            ['Strengths', 'When you learn moderation, you gain remarkable adaptability, courage, and range. You can change with life without losing yourself, and you understand temptation well enough to guide others through it.'],
            ['Challenges', 'Your struggles tend to involve overindulgence, impulsiveness, or dependence on food, spending, substances, or excitement. Sudden disruptions may force you to slow down. You may also find it hard to commit, or swing between reckless and overly rigid.'],
            ['Love', 'You are passionate and magnetic, but restlessness can undermine trust. You need a partner who values honesty and gives you room without letting you drift away.'],
            ['Career', 'Travel, consulting, journalism, sales, counseling, coaching, recovery work, and any role that combines variety with responsibility.'],
            ['Life lesson', 'Freedom is not doing everything. It is choosing what deserves your energy, and staying with it when the novelty fades.'],
        ],
    ],
    '16' => [
        'title' => 'Karmic Debt 16: The Debt of Ego',
        'sections' => [
            ['Essence', 'The old pattern here is misplaced pride: the ego, vanity, or misuse of love and trust. In this life, what you build on image or status tends to be shaken so something more authentic can replace it.'],
            ['Strengths', 'After the falls, you develop humility, insight, and real spiritual depth. Having rebuilt yourself, you can see through pretense, and your wisdom is earned rather than borrowed.'],
            ['Challenges', 'The pattern shows up as sudden endings: a job, a relationship, a belief, or a reputation that collapses. You may struggle with pride, hidden insecurity, or the belief that you must handle everything alone. The old habit is protecting an image when you should be looking inward.'],
            ['Love', 'You may face heartbreak or betrayal, or have to rebuild trust after ego gets in the way. You need a partner who values you for who you are, and you need to let them see it.'],
            ['Career', 'Research, psychology, writing, philosophy, healing work, spiritual counseling, and roles that reward depth and authenticity over prestige.'],
            ['Life lesson', 'What breaks was never you. Let the false structures fall, and build again on honesty.'],
        ],
    ],
    '19' => [
        'title' => 'Karmic Debt 19: The Debt of Independence',
        'sections' => [
            ['Essence', 'The old pattern here is misused power: selfishness, domination, or refusing to rely on anyone. In this life, you are learning to lead without dominating and to be strong without going it alone.'],
            ['Strengths', 'As you grow, you develop confident, generous leadership and true self-reliance. You know how to stand on your own, and you use that strength to lift others rather than hold them back.'],
            ['Challenges', 'You may feel isolated, misunderstood, or as though everything depends on you. The old habit is turning down help, taking control, or putting your own needs first. Pride can make asking for support feel like defeat.'],
            ['Love', 'You may struggle to depend on a partner or to compromise. You need someone who is secure enough to stand as an equal and patient enough to help you accept care.'],
            ['Career', 'Entrepreneurship, leadership, management, coaching, public service, and any role where independence and responsibility to others go together.'],
            ['Life lesson', 'Strength is not needing no one. It is letting others in, and using your power for something bigger than yourself.'],
        ],
    ],
    'none' => [
        'title' => 'No Karmic Debt: The Clean Slate',
        'sections' => [
            ['Essence', 'None of your core numbers pass through 13, 14, 16, or 19. In numerology, this suggests you aren\'t carrying one of these specific inherited lessons, and you\'re free to write your path from where you stand.'],
            ['Strengths', 'You may feel a lighter starting point, with fewer recurring patterns pulling you back. Your other numbers show your gifts more clearly, and you\'re free to grow without a single defining struggle.'],
            ['Challenges', 'A clean slate does not mean an easy life. You may lack a built-in sense of urgency about your growth, or drift because nothing dramatic forces a lesson. Challenges still come through your other numbers, and you have to choose your own growth deliberately.'],
            ['Love', 'You can enter relationships without a specific karmic pattern to repeat, so your lessons will come from the connection itself. Give it real attention and don\'t assume it will work itself out.'],
            ['Career', 'No path is closed to you. Your Life Path and Destiny numbers point to where your talents lie, so follow those.'],
            ['Life lesson', 'Without a set lesson, growth is a choice. Use the freedom to decide what you\'ll work on.'],
        ],
    ],
];
