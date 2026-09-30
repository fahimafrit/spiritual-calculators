<?php
declare(strict_types=1);

/* Interpretation content for the Maturity Number Calculator.
   Keyed by the final number (1-9, 11, 22, 33). Server-side only:
   never included from a browser request directly. */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

return [
    '1' => [
        'title' => 'The Leader',
        'sections' => [
            ['Essence', 'You are growing into self-direction. Later in life, you stop asking for permission and start living by your own convictions, with a clear sense of what you want and why.'],
            ['Strengths', 'With age you develop steady confidence, decisiveness, and independence. Experience gives you the authority to lead without needing to prove anything, and you become the person others look to for direction.'],
            ['Challenges', 'Independence can harden into stubbornness or isolation as you get older. You may resist advice, cling to your own way, or let pride keep you from asking for help.'],
            ['Love', 'You want a partner who is your equal, not one who follows or competes. Your growth is learning that leaning on someone is not a loss of strength.'],
            ['Career', 'Later-life ventures such as starting a business, consulting, mentoring, leading an organization, or launching a project that is entirely your own.'],
            ['Life lesson', 'In the second half of life, independence is best used to make room for others.'],
        ],
    ],
    '2' => [
        'title' => 'The Diplomat',
        'sections' => [
            ['Essence', 'You are growing into partnership. Later in life, cooperation, patience, and emotional attunement move to the center, and relationships become your greatest source of meaning.'],
            ['Strengths', 'With age you become wise, tactful, and calm. You can resolve tension, sense what others need, and support people without taking over.'],
            ['Challenges', 'You may drift into indecision, avoid conflict, or lose your voice in order to keep the peace. Sensitivity can turn into self-doubt or dependence on others\' approval.'],
            ['Love', 'Partnership deepens with time. You need a relationship built on mutual care and honesty, and you must learn to say what you need even when it is uncomfortable.'],
            ['Career', 'Later-life roles in counseling, mediation, teaching, healthcare, partnership work, or behind-the-scenes advisory work where your judgment is trusted.'],
            ['Life lesson', 'Be the peacemaker without becoming the one who always gives way.'],
        ],
    ],
    '3' => [
        'title' => 'The Creative',
        'sections' => [
            ['Essence', 'You are growing into expression. Later in life, creativity, joy, and communication come forward, and you feel freer to say and make what you always held back.'],
            ['Strengths', 'Age brings a more confident voice and a more genuine optimism. You become a natural storyteller, a source of warmth, and someone who makes others feel lighter.'],
            ['Challenges', 'You may scatter your energy across too many interests, avoid serious feelings behind humor, or wait for a perfect moment that never comes. Self-doubt can quiet a voice that deserves to be heard.'],
            ['Love', 'You bring warmth, playfulness, and affection to a relationship. You need a partner who enjoys your company and also invites the deeper conversations.'],
            ['Career', 'Later-life pursuits such as writing, art, teaching, public speaking, performance, design, or any work where your creativity reaches an audience.'],
            ['Life lesson', 'Don\'t save your gifts for later. Use them now, and let joy be part of the work.'],
        ],
    ],
    '4' => [
        'title' => 'The Builder',
        'sections' => [
            ['Essence', 'You are growing into stability. Later in life, security, discipline, and lasting foundations become priorities, and you find satisfaction in things that are solid and dependable.'],
            ['Strengths', 'With age you gain patience, practical wisdom, and integrity. You become the anchor of your family, workplace, or community, and what you build endures.'],
            ['Challenges', 'You may become rigid, overly cautious, or resistant to change. Work or worry about security can crowd out rest, spontaneity, and connection.'],
            ['Love', 'You show love through loyalty and reliability. You need a partner who appreciates your steadiness and helps you relax into enjoying what you have built.'],
            ['Career', 'Later-life work in construction, engineering, finance, property, operations, or organizing systems and institutions that outlast you.'],
            ['Life lesson', 'Build a life you can enjoy as well as protect.'],
        ],
    ],
    '5' => [
        'title' => 'The Adventurer',
        'sections' => [
            ['Essence', 'You are growing into freedom. Later in life, restlessness turns into a real desire for variety, travel, and new experiences, and you refuse to settle into a life that feels too small.'],
            ['Strengths', 'With age you become adaptable, curious, and youthful in spirit. You handle change with more grace than most people and stay open to learning long after others stop.'],
            ['Challenges', 'You may run from commitment, chase novelty over depth, or act on impulse when a situation demands patience. Freedom can slide into avoidance or scattered energy.'],
            ['Love', 'You need a relationship with room to breathe and grow. You need a partner who shares your curiosity, and you must learn to stay present when the excitement fades.'],
            ['Career', 'Later-life work in travel, consulting, teaching, writing, sales, entrepreneurship, or any role that offers variety and movement.'],
            ['Life lesson', 'Freedom matures into the ability to choose, and sometimes to stay.'],
        ],
    ],
    '6' => [
        'title' => 'The Nurturer',
        'sections' => [
            ['Essence', 'You are growing into responsibility and care. Later in life, home, family, and community become central, and you feel called to look after the people and places you love.'],
            ['Strengths', 'With age you become deeply compassionate, dependable, and wise about what people need. You build warmth and stability around you, and others turn to you for support.'],
            ['Challenges', 'You may overgive, take on burdens that are not yours, or try to control through caretaking. Perfectionism and unspoken resentment can build when your own needs are ignored.'],
            ['Love', 'You are devoted and family-centered. You need a partner who cares for you as much as you care for them, and you must let yourself receive.'],
            ['Career', 'Later-life roles in healthcare, teaching, counseling, community leadership, hospitality, or service work.'],
            ['Life lesson', 'You can care for others without giving up yourself.'],
        ],
    ],
    '7' => [
        'title' => 'The Seeker',
        'sections' => [
            ['Essence', 'You are growing into wisdom. Later in life, reflection, study, and a search for meaning become more important than status or activity, and you turn inward with purpose.'],
            ['Strengths', 'With age you become insightful, discerning, and self-possessed. You develop a rare depth of understanding and a peace that comes from knowing your own mind.'],
            ['Challenges', 'You may withdraw, become skeptical or aloof, or stay in your head when a situation needs your heart. Solitude can turn into isolation if left unchecked.'],
            ['Love', 'You open slowly but love deeply. You need a partner who respects your quiet time and earns your trust patiently.'],
            ['Career', 'Later-life work in research, writing, philosophy, psychology, spiritual study, analysis, or any field where depth counts most.'],
            ['Life lesson', 'Share what you learn. Wisdom that stays private helps no one.'],
        ],
    ],
    '8' => [
        'title' => 'The Achiever',
        'sections' => [
            ['Essence', 'You are growing into authority. Later in life, ambition, influence, and the wish to make a tangible mark on the world become stronger, and you feel ready to handle real power and responsibility.'],
            ['Strengths', 'With age you become strategic, resilient, and practical. You understand money, leadership, and long-term consequences, and you can steer resources toward something lasting.'],
            ['Challenges', 'You may become controlling, overly focused on status or security, or unable to step away from work. Success can quietly replace connection and rest.'],
            ['Love', 'You show love by providing and protecting. You need a partner who values you for more than your achievements and helps you slow down.'],
            ['Career', 'Later-life roles in executive leadership, business ownership, finance, real estate, investing, law, or any position with real influence.'],
            ['Life lesson', 'Use your power to build something that lasts beyond you, and share it with the people who matter.'],
        ],
    ],
    '9' => [
        'title' => 'The Humanitarian',
        'sections' => [
            ['Essence', 'You are growing into compassion and purpose. Later in life, your focus turns outward, and you feel drawn to serve, teach, and contribute to something larger than your own concerns.'],
            ['Strengths', 'With age you become generous, forgiving, and wise. You see the bigger picture, let go of old grievances, and inspire others through kindness and perspective.'],
            ['Challenges', 'You may fall into martyrdom, hold on to disappointments, or feel let down when people fail your ideals. It can be hard to let go of the past or accept help in return.'],
            ['Love', 'You love deeply and unconditionally. You need a partner who sees you as an individual, not just a giver, and cares for you in return.'],
            ['Career', 'Later-life work in nonprofit and humanitarian causes, teaching, counseling, the arts, healthcare, advocacy, or mentoring the next generation.'],
            ['Life lesson', 'Let go of what has ended, and give freely without losing yourself.'],
        ],
    ],
    '11' => [
        'title' => 'The Illuminator',
        'sections' => [
            ['Essence', 'You are growing into inspiration. Later in life, your intuition and idealism sharpen, and you feel called to bring insight, hope, and vision to others.'],
            ['Strengths', 'With age you become perceptive, spiritually attuned, and magnetic. You sense what is true before it is spoken, and your presence uplifts people.'],
            ['Challenges', 'Sensitivity can turn into anxiety, nervous tension, or withdrawal. You may put impossible standards on yourself or retreat into the people-pleasing habits of the 2 when pressure rises.'],
            ['Love', 'You are intuitive and deeply attuned to your partner. You need someone steady who respects your need for quiet and can hold both your highs and your lows.'],
            ['Career', 'Later-life work in counseling, teaching, healing, the arts, spiritual guidance, writing, or public speaking.'],
            ['Life lesson', 'Ground your vision in daily practice, and it becomes light instead of noise.'],
        ],
    ],
    '22' => [
        'title' => 'The Master Builder',
        'sections' => [
            ['Essence', 'You are growing into legacy. Later in life, you feel called to turn a large vision into something practical that lasts and serves many people.'],
            ['Strengths', 'With age you gain the discipline, strategic sense, and follow-through to organize people and resources at scale. You see the whole structure and how each piece fits.'],
            ['Challenges', 'The size of your potential can feel overwhelming and lead to perfectionism, delay, or burnout. You may become controlling or retreat into small, safe goals.'],
            ['Love', 'You are loyal and serious about commitment. You need a partner who supports your ambitions, shares the load, and helps you rest.'],
            ['Career', 'Later-life work in large-scale entrepreneurship, architecture, urban planning, philanthropy, politics, international business, or building institutions.'],
            ['Life lesson', 'A great work is built one brick at a time. Begin where you are.'],
        ],
    ],
    '33' => [
        'title' => 'The Master Teacher',
        'sections' => [
            ['Essence', 'You are growing into service. Later in life, a deep call to guide, heal, and uplift others emerges, and your warmth becomes a source of strength for the people around you.'],
            ['Strengths', 'With age you become compassionate, generous, and creative in helping others grow. You lead by example and help people find their own strength.'],
            ['Challenges', 'You may give until you are empty, carry other people\'s burdens, or slide into martyrdom and quiet resentment. Your standards can be impossibly high, and boundaries may feel like betrayal.'],
            ['Love', 'You love with full devotion and often become the emotional anchor of the family. You need a partner who cares for you in return and doesn\'t let you vanish into caretaking.'],
            ['Career', 'Later-life work in teaching, healthcare, counseling, ministry, child development, the arts, or humanitarian service.'],
            ['Life lesson', 'Teach by example: model rest, limits, and self-compassion.'],
        ],
    ],
];
