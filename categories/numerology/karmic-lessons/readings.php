<?php
declare(strict_types=1);

/* Interpretation content for the Karmic Lessons Calculator.
   Keyed by the missing number (1-9) plus 'none' for the full-spectrum
   reading. Server-side only: never included from a browser request
   directly. */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

return [
    '1' => [
        'title' => 'Karmic Lesson 1: Independence and Initiative',
        'sections' => [
            ['Essence', 'You are learning to trust yourself. Somewhere along the way, you learned to defer, wait for approval, or let others decide, and this life asks you to find your own will.'],
            ['Strengths', 'As you grow into this lesson, you develop quiet, earned confidence. You learn to make decisions, hold your ground, and start things on your own. Because it isn\'t automatic for you, you know how to lead without arrogance.'],
            ['Challenges', 'You may doubt your ideas, hesitate to speak up, or lean on others to choose for you. Some people with this lesson overcorrect into stubbornness or bossiness, then retreat again.'],
            ['Love', 'You may let a stronger partner take the lead or struggle to state what you want. You need a relationship where your voice carries real weight, and you need to use it.'],
            ['Career', 'Roles that build autonomy step by step, such as project ownership, freelancing, mentoring, and small-team leadership. Any work where you gradually take responsibility for outcomes.'],
            ['Life lesson', 'No one is coming to give you permission. Make the small decision today, and let your confidence grow from there.'],
        ],
    ],
    '2' => [
        'title' => 'Karmic Lesson 2: Cooperation and Sensitivity',
        'sections' => [
            ['Essence', 'You are learning to work with others. This life asks you to slow down, listen, and see that patience and partnership often achieve more than pushing ahead alone.'],
            ['Strengths', 'As you master this lesson, you become a skilled listener, a fair negotiator, and someone who notices what others need. Your diplomacy is deliberate, so it\'s reliable.'],
            ['Challenges', 'You may miss social cues, rush past other people\'s feelings, or feel uncomfortable with compromise. You can be dismissive of details or of the quiet people in the room.'],
            ['Love', 'Intimacy may require practice in listening, giving space, and reading emotions. You need a patient partner, and you need to ask what they feel before assuming.'],
            ['Career', 'Team-based roles that train collaboration, such as mediation, HR, customer care, coordination, and partnership work.'],
            ['Life lesson', 'Winning the moment can cost you the relationship. Learn to ask, wait, and hear the answer.'],
        ],
    ],
    '3' => [
        'title' => 'Karmic Lesson 3: Self-Expression and Joy',
        'sections' => [
            ['Essence', 'You are learning to let yourself be heard and seen. This life invites you to voice your thoughts, embrace creativity, and allow more play into your days.'],
            ['Strengths', 'As you grow, you find a distinctive, sincere voice. You may never be the loudest in the room, but what you express carries weight because you\'ve earned it.'],
            ['Challenges', 'You may feel shy, hold back your feelings, or judge your creative ideas before they see daylight. Social situations can feel like performances, and lightness can feel out of reach.'],
            ['Love', 'You may keep emotions private and struggle to say what you feel. You need a warm partner who draws you out, and you need to practice saying it even when it feels awkward.'],
            ['Career', 'Fields that build expressive confidence gradually, such as writing, teaching, design, presenting, or creative hobbies that grow into work.'],
            ['Life lesson', 'Your voice doesn\'t need to be polished to be worth hearing. Speak, make, and share before you feel ready.'],
        ],
    ],
    '4' => [
        'title' => 'Karmic Lesson 4: Discipline and Order',
        'sections' => [
            ['Essence', 'You are learning to build steady foundations. This life asks you to develop routine, focus, and follow-through, and to turn good intentions into completed work.'],
            ['Strengths', 'As you master this lesson, you gain a hard-won ability to organize, plan, and finish. Because you know what disorder costs, you become thoughtful about the systems that keep life running.'],
            ['Challenges', 'You may struggle with punctuality, budgeting, paperwork, or sticking to a plan. Projects may start with energy and fade, and rules can feel like cages.'],
            ['Love', 'Practical matters like money, chores, and schedules may cause friction. You need a partner who shares the structure without policing it, and you need to keep your promises small and real.'],
            ['Career', 'Roles that teach structure in a supportive setting, such as operations, project coordination, trades, or any work with clear milestones and accountable systems.'],
            ['Life lesson', 'Motivation comes and goes, but routines carry you through. Build one small habit and protect it.'],
        ],
    ],
    '5' => [
        'title' => 'Karmic Lesson 5: Freedom and Adaptability',
        'sections' => [
            ['Essence', 'You are learning to embrace change. This life asks you to loosen your grip on the familiar, take healthy risks, and trust that flexibility is a form of safety.'],
            ['Strengths', 'As you grow, you become resilient and open-minded. You learn to move with change instead of fearing it, and you discover that new experiences expand you.'],
            ['Challenges', 'You may resist change, cling to routine, or feel anxious in unfamiliar situations. Alternatively, you may swing to reckless behavior when you feel trapped.'],
            ['Love', 'You may hold on too tightly or avoid growth in a relationship. You need a partner who invites you into new experiences gently, and you need to practice letting things evolve.'],
            ['Career', 'Roles that expose you to variety in manageable doses, such as travel-related work, cross-functional roles, consulting, or teaching new groups.'],
            ['Life lesson', 'Change is not the enemy of stability. Try something new this week, and notice that you\'re still yourself.'],
        ],
    ],
    '6' => [
        'title' => 'Karmic Lesson 6: Responsibility and Harmony',
        'sections' => [
            ['Essence', 'You are learning to care and commit. This life asks you to show up for others, build a stable home or community, and balance giving with receiving.'],
            ['Strengths', 'As you master this lesson, you develop a mature, grounded sense of responsibility. You learn to nurture without controlling and to make commitments that you keep.'],
            ['Challenges', 'You may avoid obligations, feel burdened by family or duty, or struggle to make a home feel safe. Others may see you as inconsistent, or you may take on too much to prove yourself.'],
            ['Love', 'Commitment and domestic life may feel unfamiliar or heavy. You need a partner who shares responsibility fairly, and you need to practice steady presence over grand gestures.'],
            ['Career', 'Roles that develop reliability and care, such as healthcare, teaching, community work, hospitality, or leading a small team you\'re responsible for.'],
            ['Life lesson', 'Responsibility is a way of loving, not a weight. Choose what you commit to, then keep it.'],
        ],
    ],
    '7' => [
        'title' => 'Karmic Lesson 7: Faith and Inner Wisdom',
        'sections' => [
            ['Essence', 'You are learning to trust what you can\'t fully prove. This life invites you to slow down, reflect, and develop a relationship with your intuition and your own beliefs.'],
            ['Strengths', 'As you grow, you gain a grounded, personal form of wisdom. You learn to balance logic with intuition, and to find calm in solitude instead of fear.'],
            ['Challenges', 'You may be skeptical, restless, or uncomfortable with silence. You might avoid introspection, accept ideas without examining them, or struggle to trust yourself or the process of life.'],
            ['Love', 'You may find emotional depth or vulnerability difficult, or distrust a partner\'s sincerity. You need someone patient, and you need to build trust through small, honest steps.'],
            ['Career', 'Roles that combine study and reflection with practical work, such as research, analysis, writing, coaching, or any field where you learn deeply before acting.'],
            ['Life lesson', 'Not everything can be proven, but you can learn to listen. Give yourself a few quiet minutes each day.'],
        ],
    ],
    '8' => [
        'title' => 'Karmic Lesson 8: Power and Material Balance',
        'sections' => [
            ['Essence', 'You are learning to handle money, authority, and ambition wisely. This life asks you to build a healthy relationship with success, resources, and your own influence.'],
            ['Strengths', 'As you master this lesson, you develop practical financial sense, quiet authority, and a balanced view of achievement. You learn to earn and manage without being ruled by either.'],
            ['Challenges', 'You may struggle with budgeting, undervalue your work, or feel uneasy about power and wealth. Some swing between avoiding money and overreaching for it.'],
            ['Love', 'Money or status may cause friction. You need a partner who shares your values around resources, and you need to talk about them openly.'],
            ['Career', 'Roles that build financial and managerial skills step by step, such as budgeting, business operations, finance, administration, or small business ownership.'],
            ['Life lesson', 'Money and power are tools, not verdicts on your worth. Learn to use them with clarity and fairness.'],
        ],
    ],
    '9' => [
        'title' => 'Karmic Lesson 9: Compassion and Completion',
        'sections' => [
            ['Essence', 'You are learning to look beyond yourself. This life asks you to develop empathy, forgiveness, and the ability to let things end without bitterness.'],
            ['Strengths', 'As you grow, you develop a broad, genuine compassion that is earned rather than assumed. You learn to forgive, release what is finished, and contribute to something larger than your own concerns.'],
            ['Challenges', 'You may focus on personal concerns, struggle to forgive, or hold on to grievances and unfinished business. Others\' struggles may feel distant until you face your own.'],
            ['Love', 'Letting go of old hurts may be difficult. You need a partner who models generosity, and you need to practice forgiving without waiting for an apology.'],
            ['Career', 'Roles that develop empathy through service, such as volunteering, counseling, teaching, healthcare, or advocacy work.'],
            ['Life lesson', 'Holding on costs more than letting go. Forgive one small thing today, and see how much lighter you feel.'],
        ],
    ],
    'none' => [
        'title' => 'No Karmic Lessons: The Full Spectrum',
        'sections' => [
            ['Essence', 'All nine numbers appear in your name, so you have no missing lesson. This is uncommon, and it usually means a long name.'],
            ['Strengths', 'You have access to every energy, and few situations feel entirely foreign. You can adapt to many people and roles.'],
            ['Challenges', 'With all numbers present, you may have no clear focus or lose sight of what matters most. Look at which numbers appear most often, since repeated numbers show where your energy concentrates.'],
            ['Love', 'You can relate to many types of people, but you may lack a clear sense of what you need. Take time to define it.'],
            ['Career', 'Wide open. Let your Life Path and Destiny numbers guide your choices.'],
            ['Life lesson', 'Having every tool doesn\'t mean using them all at once. Choose your emphasis.'],
        ],
    ],
];
