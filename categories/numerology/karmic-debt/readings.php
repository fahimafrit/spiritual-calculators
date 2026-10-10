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
        'title' => 'Karmic Debt 13/4: The Debt of Effort',
        'sections' => [
            ['Core Theme', 'Karmic Debt 13/4 is the debt of effort. Numerology tradition links it to a past pattern of avoiding hard work or taking shortcuts for easy gain. In this life, it calls you to build things honestly, through discipline, patience, and responsibility.'],
            ['Strengths to Develop', 'You are developing persistence, organization, and practical skill. Over time you learn to finish demanding work, break large goals into steps, and stay steady when progress feels slow. These qualities become a reliability others trust and depend on.'],
            ['Challenges', 'The shadow side includes shortcuts, procrastination, scattered effort, and expecting results without consistent work. You may feel life demands more from you than from others, or that obstacles appear whenever you rush. Frustration lingers until effort becomes habit.'],
            ['Life Lesson', 'Your lesson is to build success through steady, honest effort rather than quick fixes. When you commit to one path and work at it patiently, struggle turns into pride, and the debt becomes a lasting skill.'],
        ],
    ],
    '14' => [
        'title' => 'Karmic Debt 14/5: The Debt of Freedom',
        'sections' => [
            ['Core Theme', 'Karmic Debt 14/5 is the debt of freedom. Numerology tradition links it to a past misuse of liberty through excess, impulsiveness, or avoiding responsibility. In this life, it asks you to enjoy freedom with moderation, self-control, and wise choices.'],
            ['Strengths to Develop', 'You are developing adaptability, balance, and discipline. You learn to welcome change without being ruled by it, to enjoy pleasures without excess, and to use independence in ways that strengthen your life instead of destabilizing it. Moderation becomes a form of strength, not restriction.'],
            ['Challenges', 'The shadow side includes impulsiveness, excess, inconsistency, and resistance to limits or commitments. Restlessness may push you toward choices that feel exciting briefly but leave you unsettled, and you may feel trapped whenever responsibility appears.'],
            ['Life Lesson', 'Your lesson is to enjoy freedom without letting immediate desires undermine stability. Real freedom comes from self-mastery: when you can say yes and no with equal ease, you gain both adventure and peace. Freedom you choose wisely lasts longer.'],
        ],
    ],
    '16' => [
        'title' => 'Karmic Debt 16/7: The Debt of Humility',
        'sections' => [
            ['Core Theme', 'Karmic Debt 16/7 is the debt of humility. Numerology tradition links it to a past pattern of pride, ego, or attachment to appearances. In this life, it brings situations that dissolve false certainty and invite honest self-knowledge.'],
            ['Strengths to Develop', 'You are developing reflection, honesty, and emotional insight. You learn to question assumptions, listen to your inner truth, and rebuild stronger after setbacks. Over time, humility becomes a source of wisdom rather than loss. Quiet moments of honesty become your greatest teachers.'],
            ['Challenges', 'The shadow side includes pride, self-deception, attachment to image or status, and resistance to necessary change. Life may dismantle plans or identities you relied on, which can feel jarring until you recognize what the collapse is clearing away.'],
            ['Life Lesson', 'Your lesson is to build self-knowledge and humility, especially when life challenges an old self-image. When you let go of who you thought you had to be, a quieter, truer, and more resilient self emerges. Humility opens doors that pride keeps closed.'],
        ],
    ],
    '19' => [
        'title' => 'Karmic Debt 19/1: The Debt of Independence',
        'sections' => [
            ['Core Theme', 'Karmic Debt 19/1 is the debt of independence. Numerology tradition links it to a past misuse of power, selfishness, or refusal to share responsibility. In this life, it asks you to stand on your own while remembering that leadership serves people. It is a debt about strength used generously.'],
            ['Strengths to Develop', 'You are developing initiative, resilience, and fair leadership. You learn to act decisively without dominating, to take responsibility for your choices, and to stay strong when circumstances leave you without support. Your confidence becomes warm instead of defensive.'],
            ['Challenges', 'The shadow side includes self-centeredness, misuse of authority, refusing help, and expecting others to solve your problems. Isolation can follow when independence turns into stubbornness, leaving you feeling that you must carry everything alone.'],
            ['Life Lesson', 'Your lesson is to balance self-reliance with cooperation. Lead with fairness, accept help gracefully, and use your strength to lift others as well as yourself. Independence becomes powerful when it is shared. You never have to choose between strength and connection.'],
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