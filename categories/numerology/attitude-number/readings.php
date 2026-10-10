<?php
declare(strict_types=1);

/* Interpretation content for the Attitude Number Calculator.
   Keyed by the final number (1-9). Server-side only:
   never included from a browser request directly. */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

return [
    '1' => [
        'title' => 'The Independent Achiever',
        'sections' => [
            ['Overview', 'Your Attitude Number, found from your birth month and day, shows how you instinctively respond to situations and challenges. With a 1, you meet life head-on: confident, self-reliant, and ready to take charge before anyone asks.'],
            ['Strengths', 'Self-confidence and courage are your greatest assets. You make decisions quickly, trust your own judgment, and keep moving when others hesitate. Your assertiveness gives you natural authority, and people often follow your lead when pressure rises. Few things intimidate you for long.'],
            ['Challenges', 'Your strong will can turn into stubbornness or arrogance when you feel challenged. You may resist advice, take on too much alone, or struggle to admit mistakes. Learning to listen turns your determination into wiser, more flexible leadership.'],
            ['Career & Relationships', 'Careers involving leadership, entrepreneurship, management, or independent work suit you best. In relationships, you value respect and freedom, and you thrive with partners who admire your strength while also encouraging you to share your softer side.'],
        ],
    ],
    '2' => [
        'title' => 'The Understanding Diplomat',
        'sections' => [
            ['Overview', 'Your Attitude Number, found from your birth month and day, shows how you instinctively respond to situations and challenges. With a 2, you respond with sensitivity and tact, reading the mood of a situation before you decide how to act. Gentle strength is your signature.'],
            ['Strengths', 'Empathy and diplomacy are your gifts. You listen well, notice what people leave unsaid, and look for solutions that leave everyone feeling respected. Your calm, cooperative nature makes you a trusted peacemaker in tense or emotional situations.'],
            ['Challenges', 'Your sensitivity can make criticism feel heavy, and your wish for harmony may lead you to avoid necessary conflict. You might hesitate over decisions or put others first until you feel overlooked. Speaking honestly protects both your peace and your relationships.'],
            ['Career & Relationships', 'Counseling, teaching, human resources, mediation, and team-based roles let your strengths shine. In love and friendship, you offer loyalty and tenderness, and you flourish with people who value your kindness and encourage you to voice your own needs.'],
        ],
    ],
    '3' => [
        'title' => 'The Cheerful Creator',
        'sections' => [
            ['Overview', 'Your Attitude Number, found from your birth month and day, shows how you instinctively respond to situations and challenges. With a 3, you meet life with humor, imagination, and a natural desire to connect and express yourself.'],
            ['Strengths', 'Optimism and creativity define your approach. You find the bright side quickly, communicate with charm, and make people feel included. Your enthusiasm is contagious, and you often turn difficult moments into something lighter and more hopeful. People remember how you made them feel.'],
            ['Challenges', 'Your energy can scatter across too many interests, and you may avoid serious issues by joking or staying on the surface. Boredom comes quickly. Choosing a few goals and facing uncomfortable feelings honestly helps your talents grow deeper and last longer.'],
            ['Career & Relationships', 'Writing, speaking, design, entertainment, marketing, and teaching suit you well. In relationships, you bring warmth, fun, and affection, and you do best with partners who appreciate your expressiveness and give you the freedom to create.'],
        ],
    ],
    '4' => [
        'title' => 'The Dependable Anchor',
        'sections' => [
            ['Overview', 'Your Attitude Number, found from your birth month and day, shows how you instinctively respond to situations and challenges. With a 4, you respond with steadiness, preferring a clear plan and practical action over drama or guesswork.'],
            ['Strengths', 'Honesty, loyalty, and reliability stand out in you. You work patiently, keep your promises, and handle responsibility without complaint. People trust you in a crisis because you stay calm, focus on what\'s practical, and follow through to the end. Stability is what you offer without trying.'],
            ['Challenges', 'Your love of order can harden into rigidity, and unexpected changes may feel threatening. You might work too hard or insist that your way is the only right one. Staying open to new methods keeps your reliability from becoming resistance.'],
            ['Career & Relationships', 'Engineering, administration, finance, construction, project management, and any structured field fit you. In relationships, you show love through loyalty and consistent support, and you thrive with partners who value commitment and respect your need for stability.'],
        ],
    ],
    '5' => [
        'title' => 'The Bold Adventurer',
        'sections' => [
            ['Overview', 'Your Attitude Number, found from your birth month and day, shows how you instinctively respond to situations and challenges. With a 5, you respond with courage and curiosity, treating change as an invitation instead of a threat. You rarely wait for permission to try something new.'],
            ['Strengths', 'Adaptability, boldness, and sociability are your strengths. You think quickly, welcome new experiences, and stay flexible when plans collapse. Your lively, outgoing nature helps you connect with almost anyone and find opportunity in unfamiliar situations.'],
            ['Challenges', 'Restlessness can pull you away from commitments, and you may take risks without thinking through the consequences. Routine may feel suffocating, which can leave projects or relationships unfinished. Pausing to plan before leaping helps your freedom work in your favor.'],
            ['Career & Relationships', 'Careers in travel, sales, media, communication, consulting, or entrepreneurship keep you energized. In relationships, you bring excitement and spontaneity, and you do best with partners who enjoy adventure and trust you to value freedom without losing loyalty.'],
        ],
    ],
    '6' => [
        'title' => 'The Devoted Protector',
        'sections' => [
            ['Overview', 'Your Attitude Number, found from your birth month and day, shows how you instinctively respond to situations and challenges. With a 6, you respond with care, asking first how people are doing and what they need to feel safe.'],
            ['Strengths', 'Responsibility, warmth, and trustworthiness shape your approach. You value close relationships, create harmony wherever you go, and show up for people when it counts. Others rely on your steady kindness and your instinct to protect and support. Your home and your circle matter deeply to you.'],
            ['Challenges', 'You may take on too much responsibility, trying to fix problems that belong to others. Care can slip into control, and worry can follow you home. Setting healthy boundaries lets your generosity stay genuine instead of exhausting.'],
            ['Career & Relationships', 'Healthcare, teaching, counseling, hospitality, design, and community work make good use of your nature. In love and family life, you are devoted and dependable, and you flourish with people who appreciate your care and return it generously.'],
        ],
    ],
    '7' => [
        'title' => 'The Thoughtful Analyst',
        'sections' => [
            ['Overview', 'Your Attitude Number, found from your birth month and day, shows how you instinctively respond to situations and challenges. With a 7, you pause and observe first, turning to thought and reflection before you decide what to do.'],
            ['Strengths', 'Analysis, intuition, and a love of learning are your strengths. You study problems carefully, notice details others miss, and arrive at well-considered conclusions. Your calm, thoughtful approach gives you wisdom that people respect and often seek. Solitude helps you recharge and think clearly.'],
            ['Challenges', 'Your reflective nature can slide into overthinking, secrecy, or emotional distance. You may withdraw when stressed or doubt what you can\'t prove. Sharing your thoughts and feelings with trusted people keeps your inner world from becoming isolating.'],
            ['Career & Relationships', 'Research, science, technology, writing, psychology, and specialized fields suit you best. In relationships, you value depth and honesty over small talk, and you thrive with partners who respect your need for quiet while patiently inviting you to open up.'],
        ],
    ],
    '8' => [
        'title' => 'The Determined Powerhouse',
        'sections' => [
            ['Overview', 'Your Attitude Number, found from your birth month and day, shows how you instinctively respond to situations and challenges. With an 8, you respond with drive and focus, treating obstacles as problems to be solved and goals to be reached.'],
            ['Strengths', 'Ambition, discipline, and dedication define you. You commit fully to what you care about, manage resources wisely, and stay composed under pressure. Your strength and organizational skill make you a natural leader in demanding environments. Setbacks rarely shake your determination for long.'],
            ['Challenges', 'Your intensity can lead to workaholism, control issues, or measuring your worth by success alone. You may struggle to relax or to trust others with responsibility. Balancing achievement with rest and connection keeps your power healthy and sustainable.'],
            ['Career & Relationships', 'Business, finance, management, law, real estate, and executive roles reward your abilities. In relationships, you show love through providing and protecting, and you do best with partners who admire your ambition while reminding you to slow down.'],
        ],
    ],
    '9' => [
        'title' => 'The Compassionate Humanitarian',
        'sections' => [
            ['Overview', 'Your Attitude Number, found from your birth month and day, shows how you instinctively respond to situations and challenges. With a 9, you respond with understanding and a wide perspective, thinking about how choices affect more than just yourself.'],
            ['Strengths', 'Compassion, wisdom, and generosity guide your attitude. You forgive easily, think of the bigger picture, and inspire people with your idealism. Your prudent, open-minded approach helps you stay balanced when situations become emotional or complicated. Your outlook helps others feel less alone.'],
            ['Challenges', 'Your idealism can lead to disappointment, and your generosity may leave you giving more than you have. Letting go of the past or of people may feel difficult. Practicing healthy detachment helps you keep serving without losing yourself.'],
            ['Career & Relationships', 'Teaching, healing, charity work, the arts, and international or humanitarian careers suit you well. In relationships, you are loving, forgiving, and supportive, and you flourish with people who share your values and care for you in return.'],
        ],
    ],
];