<?php
declare(strict_types=1);

/* Interpretation content for the Personal Month Number Calculator.
   Keyed by a single digit (1-9): a Personal Month is always 1-9.
   Each entry is ['title' => ..., 'paragraphs' => [...]].
   Server-side only: never included from a browser request directly. */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

return [
    '1' => [
        'title' => 'The Quick Start',
        'paragraphs' => [
            'A Personal Month 1 is a month for beginning. Energy is high, ideas arrive easily and you are more willing than usual to take the first step. It is a good time to start a project, launch a plan, make a decision you have been postponing or simply take the lead where you would normally wait. What you begin now sets the tone for the next nine months.',
            'Act on what you want, but do not rush past the details. Impatience, stubbornness or going it alone can cost you goodwill. Choose one or two things that matter, put your energy into them and trust your own judgment. A clear start is worth more this month than a long list of half-begun plans.',
        ],
    ],
    '2' => [
        'title' => 'The Quiet Collaborator',
        'paragraphs' => [
            'A Personal Month 2 slows the pace. After the push of a 1 month, this is a time for patience, listening and working with other people rather than ahead of them. Progress comes through cooperation, good timing and attention to small details, and quick results are less likely than steady ones.',
            'You may feel more sensitive than usual, which helps you read people and situations well. It can also leave you easily hurt or indecisive. Give conversations time, make peace where there is friction and let things develop at their own speed. Pushing for fast answers tends to backfire this month.',
        ],
    ],
    '3' => [
        'title' => 'The Social Spark',
        'paragraphs' => [
            'A Personal Month 3 brings lightness and expression. You feel more talkative, more creative and more drawn to people. It is a good month for writing, speaking, performing, making things and spending time with friends. Invitations, introductions and casual conversations can lead to something useful.',
            'The risk is scattering your energy. Too many plans, too much socialising or too much spending can leave little finished by month end. Pick one thing to express well, keep your commitments and let your good mood work for you. Share what you have been keeping to yourself.',
        ],
    ],
    '4' => [
        'title' => 'The Steady Worker',
        'paragraphs' => [
            'A Personal Month 4 is a month of practical work. The pace is slower and the tasks are plainer: planning, organising, paperwork, budgets, repairs and routines. Effort is rewarded here, even if it feels dull. What you put in order now tends to stay in order.',
            'Progress can feel slow, and limits or obstacles are usually practical ones. Treat them as part of the building and keep going. Look after your health, as long hours of work may wear you down. Discipline and attention to detail give you a stronger footing for the months ahead.',
        ],
    ],
    '5' => [
        'title' => 'The Shake-Up',
        'paragraphs' => [
            'A Personal Month 5 brings movement and change. Plans shift, news arrives unexpectedly and routines may stop fitting. Travel, new contacts, a change of scene or a sudden opportunity are all common. The month asks you to stay flexible and meet what comes with a steady head.',
            'The pull toward freedom is strong, and so is the temptation to act on impulse. Restlessness can lead to hasty choices or too many commitments at once. Say yes to the unexpected opening, but check the details first. Handled well, this month frees you from something that was holding you back.',
        ],
    ],
    '6' => [
        'title' => 'The Home Keeper',
        'paragraphs' => [
            'A Personal Month 6 turns your attention to home, family and the people you care for. Relationships ask for time and care, and you may find others leaning on you more than usual. It is a good month for domestic matters, shared meals, repairs at home and making your surroundings more comfortable.',
            'Fairness and responsibility are the themes. The risk is taking on too much for others or trying to fix problems that are not yours to fix. Give support where it is wanted, set sensible limits and look after yourself too. A kind, balanced approach strengthens your closest relationships this month.',
        ],
    ],
    '7' => [
        'title' => 'The Reflective Pause',
        'paragraphs' => [
            'A Personal Month 7 invites you to step back. It is a quieter month for thinking, studying, resting and understanding what you really want. Time alone is not wasted now. It is where clarity comes from, and answers tend to arrive through reflection rather than effort.',
            'You may feel less social or more distant than usual, and that is natural. Avoid forcing results or starting major ventures that need pushing through. Look after your health, spend time somewhere quiet and trust your instincts. What you work out this month makes the next one more productive.',
        ],
    ],
    '8' => [
        'title' => 'The Productive Push',
        'paragraphs' => [
            'A Personal Month 8 is about results. Work, money and responsibility come into focus, and your efforts are more visible than usual. It is a strong month for business decisions, negotiations, career moves, financial planning and taking charge of something that matters.',
            'Ambition brings pressure. Be fair in how you use your influence, handle money with care and avoid working so hard that you neglect health and relationships. Set clear goals, be realistic about what you can control and act with integrity. Results earned honestly this month tend to last.',
        ],
    ],
    '9' => [
        'title' => 'The Clean Slate',
        'paragraphs' => [
            'A Personal Month 9 is a month of finishing. It is a time to complete what is open, let go of what has run its course and clear space for what comes next. Old habits, clutter, unfinished tasks and worn-out connections are better released than carried forward.',
            'Endings can feel emotional, but they are not losses. Forgive where you can, give generously and tie up loose ends. Avoid clinging to what is over or rushing into a new start before this one is done. A clean finish now makes your next fresh start far easier to begin well.',
        ],
    ],
];
