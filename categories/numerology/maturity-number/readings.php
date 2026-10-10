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
        'title' => 'The Rise of Self-Direction',
        'sections' => [
            ['Overview', 'Your Maturity Number, the reduced sum of your Life Path and Expression numbers, shows who you are becoming. Its influence builds from around age 35 to 40. With a 1, that growth points toward independence. Think of it as the person your experience is shaping.'],
            ['Growing Into', 'You are growing into independence, leadership, and self-trust. Over time you stop waiting for permission and start shaping your own direction, discovering that your ideas and instincts deserve to be acted on with confidence. Courage that once felt forced starts to feel natural.'],
            ['Later Life Emphasis', 'Later life emphasizes initiating, pioneering, and standing on your own. New ventures, bold decisions, and original projects often appear in midlife and beyond, giving you chances to lead in ways your younger years may not have allowed. Independence becomes less lonely and more purposeful.'],
            ['How You Change', 'You become more comfortable being first and taking responsibility. Hesitation fades, replaced by steady self-assurance, and you learn to lead without needing to prove anything to anyone.'],
        ],
    ],
    '2' => [
        'title' => 'The Growth of Partnership',
        'sections' => [
            ['Overview', 'Your Maturity Number, the reduced sum of your Life Path and Expression numbers, shows who you are becoming. Its influence builds from around age 35 to 40. With a 2, that growth points toward cooperation. The gentler self you grow into is a strength, not a retreat.'],
            ['Growing Into', 'You are growing into cooperation, sensitivity, and partnership. With experience, you discover that real strength includes listening, and that closeness and trust bring a richer kind of success than going it alone. Collaboration starts to feel like power, not compromise.'],
            ['Later Life Emphasis', 'Later life emphasizes relationships, diplomacy, and supporting others. Mediation, mentoring, and deep companionship often become central, and you may find that your greatest fulfillment comes from the people you help and walk beside.'],
            ['How You Change', 'You soften, become more patient, and become more attuned to people\'s needs. Small emotional details matter more, and you grow into someone others turn to for calm, understanding, and fair-minded guidance. Your quiet presence becomes a source of steadiness for others.'],
        ],
    ],
    '3' => [
        'title' => 'The Bloom of Expression',
        'sections' => [
            ['Overview', 'Your Maturity Number, the reduced sum of your Life Path and Expression numbers, shows who you are becoming. Its influence builds from around age 35 to 40. With a 3, that growth points toward creative expression. The joyful voice you grow into becomes harder to ignore.'],
            ['Growing Into', 'You are growing into creative expression, joy, and communication. As the years pass, you feel less need to hold back, and your voice, humor, and imagination become more confident and more openly shared.'],
            ['Later Life Emphasis', 'Later life emphasizes sharing ideas, art, humor, and inspiration. Writing, speaking, teaching, or creative hobbies may grow into something meaningful, and you can become a source of lightness and encouragement for the people around you. Others are often lifted simply by your presence.'],
            ['How You Change', 'You become more open, expressive, and socially engaged. Old shyness or self-criticism fades, and you discover that sharing your thoughts and talents freely is one of the best ways to feel alive. Playfulness and confidence start to travel together.'],
        ],
    ],
    '4' => [
        'title' => 'The Foundation of Legacy',
        'sections' => [
            ['Overview', 'Your Maturity Number, the reduced sum of your Life Path and Expression numbers, shows who you are becoming. Its influence builds from around age 35 to 40. With a 4, that growth points toward stability. The sturdy self you grow into becomes your quiet superpower.'],
            ['Growing Into', 'You are growing into stability, discipline, and practical contribution. Experience teaches you the value of steady effort, and you begin shaping a life with firm foundations instead of scattered attempts. Patience turns into a skill instead of a struggle.'],
            ['Later Life Emphasis', 'Later life emphasizes building, organizing, and leaving solid structures. Whether through a business, a home, a body of work, or a dependable community role, you are drawn to creating something that outlasts you. Your effort tends to be remembered long after it ends.'],
            ['How You Change', 'You become more grounded, reliable, and focused on lasting results. Restlessness gives way to patience, and you take quiet pride in work that is carefully made and honestly completed. Peace comes from knowing your work has meaning.'],
        ],
    ],
    '5' => [
        'title' => 'The Wisdom of Freedom',
        'sections' => [
            ['Overview', 'Your Maturity Number, the reduced sum of your Life Path and Expression numbers, shows who you are becoming. Its influence builds from around age 35 to 40. With a 5, that growth points toward freedom and adaptability. The adaptable self you grow into feels lighter and more alive.'],
            ['Growing Into', 'You are growing into freedom, adaptability, and experiential wisdom. Rather than fearing change, you learn to move through it with curiosity, trusting that each new experience adds something to your understanding. Every detour starts to look like part of the map.'],
            ['Later Life Emphasis', 'Later life emphasizes variety, learning through change, and mentoring through experience. Travel, new interests, and fresh chapters may fill your later years, and you can guide others by sharing what life has taught you firsthand.'],
            ['How You Change', 'You become more flexible, open-minded, and comfortable with uncertainty. The need to control outcomes loosens, and you gain a relaxed confidence that you can handle whatever comes next. Spontaneity and wisdom begin to work together.'],
        ],
    ],
    '6' => [
        'title' => 'The Heart of Service',
        'sections' => [
            ['Overview', 'Your Maturity Number, the reduced sum of your Life Path and Expression numbers, shows who you are becoming. Its influence builds from around age 35 to 40. With a 6, that growth points toward care and responsibility. The caring self you grow into brings lasting contentment.'],
            ['Growing Into', 'You are growing into care, responsibility, and service to family and community. Over time, relationships and belonging take on greater meaning, and you feel called to create warmth and stability for those around you.'],
            ['Later Life Emphasis', 'Later life emphasizes nurturing, teaching, and creating harmony. Family, friendships, and community roles often become central, and you may find deep satisfaction in being the person who holds everyone together with love and good judgment. Loved ones come to rely on your calm, steady presence.'],
            ['How You Change', 'You become more protective, supportive, and focused on home and community. Your priorities shift toward the people and places you love, and giving care becomes a source of peace instead of pressure.'],
        ],
    ],
    '7' => [
        'title' => 'The Depth of Wisdom',
        'sections' => [
            ['Overview', 'Your Maturity Number, the reduced sum of your Life Path and Expression numbers, shows who you are becoming. Its influence builds from around age 35 to 40. With a 7, that growth points toward wisdom and reflection. The reflective self you grow into becomes a trusted compass.'],
            ['Growing Into', 'You are growing into wisdom, introspection, and spiritual depth. Surface answers satisfy you less with time, and you feel a stronger pull toward understanding yourself and the deeper patterns behind life\'s events. You start to value understanding over approval.'],
            ['Later Life Emphasis', 'Later life emphasizes study, reflection, and seeking truth. Reading, research, meditation, or spiritual practice may become a central part of your days, and quiet time turns into a source of insight and renewal. Time alone becomes productive instead of lonely.'],
            ['How You Change', 'You become more contemplative, selective about relationships, and spiritually oriented. You value fewer, deeper connections, trust your inner knowing more, and feel increasingly at peace with solitude and silence. Your insights arrive with greater clarity.'],
        ],
    ],
    '8' => [
        'title' => 'The Power of Legacy',
        'sections' => [
            ['Overview', 'Your Maturity Number, the reduced sum of your Life Path and Expression numbers, shows who you are becoming. Its influence builds from around age 35 to 40. With an 8, that growth points toward authority and achievement. The empowered self you grow into carries quiet confidence.'],
            ['Growing Into', 'You are growing into authority, material mastery, and legacy-building. As experience accumulates, you gain the confidence to take on larger responsibilities and to handle money, influence, and power with greater skill. You learn that true authority begins with self-discipline.'],
            ['Later Life Emphasis', 'Later life emphasizes leadership in business and finance, managing resources, and leaving a tangible legacy. Major accomplishments, strong financial foundations, and positions of influence often develop during this stage of life. Wise financial choices become a source of security.'],
            ['How You Change', 'You become more strategic, focused in your ambition, and concerned with impact. Success matters less for its own sake and more for what it lets you build, protect, and pass on to others.'],
        ],
    ],
    '9' => [
        'title' => 'The Gift of Compassion',
        'sections' => [
            ['Overview', 'Your Maturity Number, the reduced sum of your Life Path and Expression numbers, shows who you are becoming. Its influence builds from around age 35 to 40. With a 9, that growth points toward compassion and completion. The generous self you grow into feels freer with each year.'],
            ['Growing Into', 'You are growing into compassion, completion, and universal service. As the years pass, your concerns widen beyond yourself, and you feel a growing wish to contribute something meaningful to the wider world. Your sense of purpose expands beyond personal goals.'],
            ['Later Life Emphasis', 'Later life emphasizes letting go, serving humanity, and sharing wisdom. Teaching, mentoring, humanitarian work, or creative expression with a purpose may become important, and you learn to release what has run its course. Younger people often benefit from your perspective.'],
            ['How You Change', 'You become more generous, idealistic, and focused on the bigger picture. Old grievances lose their grip, forgiveness comes more easily, and you find joy in giving without expecting anything in return.'],
        ],
    ],
    '11' => [
        'title' => 'The Awakening of Vision',
        'sections' => [
            ['Overview', 'Your Maturity Number, the reduced sum of your Life Path and Expression numbers, shows who you are becoming. Its influence builds from around age 35 to 40. With a master 11, that growth points toward spiritual insight. The luminous self you grow into becomes harder to hide.'],
            ['Growing Into', 'You are growing into spiritual insight, inspiration, and intuitive leadership. Your inner voice becomes clearer with age, and you learn to trust the flashes of understanding that once seemed too subtle to rely on.'],
            ['Later Life Emphasis', 'Later life emphasizes guiding others through vision, art, teaching, or counseling. People may seek you out for perspective and encouragement, and your role as an inspirer or quiet guide becomes more visible and more valued. Your presence alone can steady and uplift a room.'],
            ['How You Change', 'You become more sensitive, visionary, and spiritually attuned. You learn to protect your energy, ground your insights in daily life, and accept that your sensitivity is the very quality that makes your light useful.'],
        ],
    ],
    '22' => [
        'title' => 'The Building of Vision',
        'sections' => [
            ['Overview', 'Your Maturity Number, the reduced sum of your Life Path and Expression numbers, shows who you are becoming. Its influence builds from around age 35 to 40. With a master 22, that growth points toward large-scale building. The capable self you grow into feels both humbling and exciting.'],
            ['Growing Into', 'You are growing into large-scale building and practical idealism. With experience, you learn how to connect big dreams with real-world plans, and you begin to see how your abilities can serve something much larger than yourself. Discipline starts to feel like freedom.'],
            ['Later Life Emphasis', 'Later life emphasizes creating institutions, systems, or projects that benefit many. Major undertakings, organizations, or lasting contributions often take shape, and your work may reach people you will never meet personally.'],
            ['How You Change', 'You become more capable of handling significant responsibilities and long-term visions. Pressure that once felt overwhelming becomes manageable, and you develop the patience to build steadily toward something that endures. Confidence grows with every step you complete.'],
        ],
    ],
    '33' => [
        'title' => 'The Fulfillment of Love',
        'sections' => [
            ['Overview', 'Your Maturity Number, the reduced sum of your Life Path and Expression numbers, shows who you are becoming. Its influence builds from around age 35 to 40. With a master 33, that growth points toward unconditional love. The gentle self you grow into carries quiet authority.'],
            ['Growing Into', 'You are growing into unconditional love, healing, and spiritual teaching. Over the years, compassion deepens into something steady and wise, and you feel called to uplift others through presence, patience, and example. Your kindness becomes something people trust deeply.'],
            ['Later Life Emphasis', 'Later life emphasizes nurturing communities and taking on healing or selfless service roles. You may become a teacher, counselor, or quiet pillar for the people around you, offering comfort and guidance where they are needed most. Your example teaches more than words ever could.'],
            ['How You Change', 'You become more giving, patient, and spiritually mature. You also learn that caring for yourself is part of caring for others, and your love becomes steadier, wiser, and far less draining.'],
        ],
    ],
];