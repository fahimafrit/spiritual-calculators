<?php
declare(strict_types=1);

/* Interpretation content for the Mobile Number Calculator.
   Keyed by the final single-digit number (1-9). Each entry is a title
   plus four labelled sections.
   Server-side only: never included from a browser request directly. */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

return [
    '1' => [
        'title' => 'The Leader\'s Line',
        'sections' => [
            ['Overview', 'A mobile number that reduces to 1 carries the energy of leadership, initiative, and independence. Your phone becomes a tool for taking charge, starting conversations, and making decisions quickly. This number tends to support a confident, direct style of communication.'],
            ['Communication & Relationships', 'Calls and messages on a 1 tend to be short, clear, and purposeful. You are likely to be the one who initiates contact, makes the first move, or settles matters directly. In relationships, this energy feels confident, though it may come across as blunt when you\'re rushed.'],
            ['Work & Money', 'This number suits entrepreneurs, managers, freelancers, and anyone building something of their own. It supports bold ideas, independent decisions, and fresh starts, and it can help you stand out as someone people remember and take seriously.'],
            ['Best Suited For & Cautions', 'It suits people who value independence and enjoy leading. Be mindful of impatience and ego in conversations, since a 1 can make you sound commanding. Pause to listen, and your confidence will win trust instead of resistance.'],
        ],
    ],
    '2' => [
        'title' => 'The Connector\'s Line',
        'sections' => [
            ['Overview', 'A mobile number that reduces to 2 carries the energy of cooperation, sensitivity, and partnership. Your phone becomes a tool for connection, listening, and keeping relationships warm. This number tends to support gentle, thoughtful communication and patient, steady exchanges.'],
            ['Communication & Relationships', 'Conversations on a 2 often feel caring and considerate. You are likely to be the one friends call for comfort or advice, and messages tend to be kind and diplomatic. In relationships, this energy builds trust, though it may avoid difficult conversations. Kindness travels well on this line.'],
            ['Work & Money', 'This number suits counselors, teachers, assistants, mediators, and team-based professionals. It supports collaboration, partnerships, and customer relationships, and it can help you build loyal clients and long-term working connections rather than quick wins.'],
            ['Best Suited For & Cautions', 'It suits people who value harmony and cooperation. Be mindful of indecision and oversensitivity, since a 2 can make you hesitant to speak up. State your needs clearly, and your gentleness becomes a strength.'],
        ],
    ],
    '3' => [
        'title' => 'The Communicator\'s Line',
        'sections' => [
            ['Overview', 'A mobile number that reduces to 3 carries the energy of communication, creativity, and social joy. Your phone becomes a tool for expression, humor, and staying in touch. This number tends to support lively, friendly, and imaginative conversations. Staying connected feels natural and fun.'],
            ['Communication & Relationships', 'Calls and messages on a 3 tend to be cheerful and frequent. You are likely to be the one sharing news, jokes, and ideas, and people enjoy hearing from you. In relationships, this energy keeps things light, though it may skim past serious topics.'],
            ['Work & Money', 'This number suits writers, speakers, marketers, designers, performers, and anyone whose work depends on connecting with an audience. It supports networking, promotion, and creative collaboration, and it can help your ideas travel further.'],
            ['Best Suited For & Cautions', 'It suits sociable, expressive people. Be mindful of scattered attention and gossip, since a 3 can encourage chatter without focus. Follow up on what you start, and your charm turns into lasting results.'],
        ],
    ],
    '4' => [
        'title' => 'The Builder\'s Line',
        'sections' => [
            ['Overview', 'A mobile number that reduces to 4 carries the energy of structure, reliability, and hard work. Your phone becomes a tool for planning, organizing, and handling responsibilities. This number tends to support formal, practical, and dependable communication. Reliability is the signature of this line.'],
            ['Communication & Relationships', 'Conversations on a 4 often revolve around tasks, schedules, and practical matters. You are likely to be known as the person who responds reliably and keeps promises. In relationships, this energy builds trust, though it may feel serious or reserved.'],
            ['Work & Money', 'This number suits engineers, accountants, administrators, project managers, and professionals in structured fields. It supports steady progress, careful planning, and long-term stability, and it can help you earn a reputation for dependability. Credibility grows with every kept promise.'],
            ['Best Suited For & Cautions', 'It suits disciplined, methodical people. Be mindful of rigidity and delayed responses, since a 4 can make communication feel heavy or slow. Add warmth and flexibility, and your reliability becomes truly comforting.'],
        ],
    ],
    '5' => [
        'title' => 'The Networker\'s Line',
        'sections' => [
            ['Overview', 'A mobile number that reduces to 5 carries the energy of change, movement, and versatility. Your phone becomes a tool for networking, travel, and staying open to new opportunities. This number tends to support quick, adaptable, and lively communication. Variety and curiosity are the signature of this line.'],
            ['Communication & Relationships', 'Calls and messages on a 5 tend to be spontaneous and varied. You are likely to hear from many different people, and plans may change quickly. In relationships, this energy keeps things exciting, though it may feel unpredictable.'],
            ['Work & Money', 'This number suits sales professionals, marketers, travelers, journalists, consultants, and anyone in fast-moving fields. It supports networking, negotiation, and quick decisions, and it can help you spot opportunities that others miss. Quick thinking turns small contacts into big chances.'],
            ['Best Suited For & Cautions', 'It suits adventurous, adaptable people. Be mindful of restlessness and inconsistency, since a 5 can encourage jumping between plans. Keep a few reliable routines, and your flexibility becomes a real advantage.'],
        ],
    ],
    '6' => [
        'title' => 'The Caregiver\'s Line',
        'sections' => [
            ['Overview', 'A mobile number that reduces to 6 carries the energy of care, harmony, and responsibility. Your phone becomes a tool for supporting loved ones, strengthening bonds, and keeping family and community close. This number tends to support warm, trustworthy communication.'],
            ['Communication & Relationships', 'Conversations on a 6 often feel personal and caring. You are likely to be the one people call when they need support, and you tend to check in regularly. In relationships, this energy builds closeness, though it may lead to worry or over-involvement. Small check-ins matter to you and to them.'],
            ['Work & Money', 'This number suits healthcare workers, teachers, counselors, hospitality professionals, designers, and anyone in service-focused roles. It supports customer loyalty, teamwork, and trust, and it can help you build a respected reputation.'],
            ['Best Suited For & Cautions', 'It suits nurturing, family-oriented people. Be mindful of overgiving and taking on others\' problems, since a 6 can make you feel always on call. Set healthy boundaries, and your care stays sustainable.'],
        ],
    ],
    '7' => [
        'title' => 'The Thinker\'s Line',
        'sections' => [
            ['Overview', 'A mobile number that reduces to 7 carries the energy of reflection, analysis, and inner wisdom. Your phone becomes a tool for research, learning, and quiet, meaningful conversation. This number tends to support thoughtful, selective, and private communication. Quiet depth is the signature of this line.'],
            ['Communication & Relationships', 'Calls and messages on a 7 tend to be fewer but deeper. You are likely to prefer meaningful exchanges over small talk, and you may take time to reply. In relationships, this energy invites honesty, though it can feel distant.'],
            ['Work & Money', 'This number suits researchers, analysts, writers, technologists, therapists, and specialists. It supports focus, expertise, and independent work, and it can help you build a reputation as someone knowledgeable and discreet. Trusted advice is your most valuable currency.'],
            ['Best Suited For & Cautions', 'It suits introspective, curious people. Be mindful of isolation and slow responses, since a 7 can make you seem unreachable. Reach out intentionally, and your depth becomes something others value. Solitude is a strength, not a flaw.'],
        ],
    ],
    '8' => [
        'title' => 'The Achiever\'s Line',
        'sections' => [
            ['Overview', 'A mobile number that reduces to 8 carries the energy of ambition, authority, and material success. Your phone becomes a tool for business, negotiation, and leadership. This number tends to support confident, results-focused communication. Influence is the signature of this line.'],
            ['Communication & Relationships', 'Conversations on an 8 often center on goals, deals, and responsibilities. You are likely to be taken seriously and treated as someone with influence. In relationships, this energy shows strength and reliability, though work may crowd out personal time. Promptness and clarity earn you respect.'],
            ['Work & Money', 'This number suits executives, entrepreneurs, financial professionals, lawyers, and managers. It supports business growth, strong negotiation, and wealth-building, and it can help you project authority and competence. Opportunities tend to arrive through the right introductions.'],
            ['Best Suited For & Cautions', 'It suits driven, goal-oriented people. Be mindful of workaholism and control, since an 8 can keep you permanently on duty. Schedule time away from the phone, and your power stays balanced and sustainable.'],
        ],
    ],
    '9' => [
        'title' => 'The Humanitarian\'s Line',
        'sections' => [
            ['Overview', 'A mobile number that reduces to 9 carries the energy of compassion, completion, and broad perspective. Your phone becomes a tool for helping others, sharing wisdom, and staying connected to causes you care about. This number tends to support generous, open-hearted communication. Wisdom and warmth are the signature of this line.'],
            ['Communication & Relationships', 'Calls and messages on a 9 often involve listening, advising, and encouraging. You are likely to hear from people in need of understanding, and friendships may span many backgrounds. In relationships, this energy is forgiving, though it can feel draining.'],
            ['Work & Money', 'This number suits teachers, healers, nonprofit workers, artists, and international professionals. It supports humanitarian projects, mentoring, and work with a purpose, and it can help you connect with people from many walks of life. Generosity tends to come back to you.'],
            ['Best Suited For & Cautions', 'It suits idealistic, compassionate people. Be mindful of overextending yourself and letting go slowly, since a 9 can make you everyone\'s confidant. Protect your energy, and your generosity stays strong.'],
        ],
    ],
];