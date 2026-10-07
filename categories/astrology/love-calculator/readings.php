<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* Love calculator readings, one per score band (keyed by band number, 0 = lowest). */
return [
    0 => [
        'title' => 'A Quiet Beginning',
        'sections' => [
            ['Overview', 'The spark between you is faint for now, and that is a perfectly honest place to start. Some of the strongest bonds begin quietly, with two people who simply have not yet found their common ground.'],
            ['Strengths', 'With no pressure and no assumptions, you both have room to be yourselves. Curiosity and patience can do more here than any grand gesture.'],
            ['What to Work On', 'Spend unhurried time together and ask questions you do not already know the answers to. Look for the small things you enjoy in common and build on those.'],
        ],
    ],
    1 => [
        'title' => 'Friendly Sparks',
        'sections' => [
            ['Overview', 'There is a gentle warmth here, closer to friendship than fireworks. You can be at ease with one another, which is a better foundation than many couples ever have.'],
            ['Strengths', 'Comfort, honesty and easy conversation come naturally. Neither of you has to perform, and that makes trust possible.'],
            ['What to Work On', 'Do not let comfort turn into routine. Plan something new together now and then, and say out loud the affection you tend to leave unspoken.'],
        ],
    ],
    2 => [
        'title' => 'Growing Connection',
        'sections' => [
            ['Overview', 'Something real is taking shape. You complement each other in some ways and challenge each other in others, and both are signs of a bond that can grow.'],
            ['Strengths', 'You each bring something the other lacks. Shared effort and a willingness to learn about each other keep the connection moving forward.'],
            ['What to Work On', 'Differences will surface, so talk about them early and kindly. Agree on what matters most to each of you before small misunderstandings pile up.'],
        ],
    ],
    3 => [
        'title' => 'Strong Chemistry',
        'sections' => [
            ['Overview', 'There is a clear pull between you, a mix of attraction and understanding that does not need much explaining. Time together tends to feel natural and energising.'],
            ['Strengths', 'Warmth, shared humour and mutual support are your best qualities. You lift each other up and notice what the other needs.'],
            ['What to Work On', 'Strong feelings can make disagreements feel bigger than they are. Pause before reacting, and protect time that is just for the two of you.'],
        ],
    ],
    4 => [
        'title' => 'Deep Bond',
        'sections' => [
            ['Overview', 'This is a rare level of harmony. You understand each other quickly, often without words, and the trust between you runs deep.'],
            ['Strengths', 'Loyalty, emotional openness and a shared sense of direction set you apart. You face challenges as a team rather than as opponents.'],
            ['What to Work On', 'Even a close match benefits from independence. Keep your own friendships and goals alive so the bond stays fresh rather than dependent.'],
        ],
    ],
    5 => [
        'title' => 'Soulmate Energy',
        'sections' => [
            ['Overview', 'Few matches feel this complete. The connection between you is vivid, warm and steady, the kind people hope to find once in a lifetime.'],
            ['Strengths', 'You share deep affection, strong respect and a natural ease in each other\'s company. Your love brings out the best in both of you.'],
            ['What to Work On', 'Treat what you have as something to tend, not something that runs itself. Keep showing appreciation, keep listening, and keep choosing each other.'],
        ],
    ],
];
