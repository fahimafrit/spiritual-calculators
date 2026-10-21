<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   PINNACLE NUMBERS — READINGS
   Interpretation text only. The handler decides which entries to show.

   stages[1-4]       : name and a one-line description of each pinnacle
   numbers[n]        : keyword (used in the closing summary) and arrival
                       (completes "It brings ..." in the Right now note)
                       for every possible number: 1-9, 11, 22, 33
   readings[n][1-4]  : one reading for each number in each pinnacle position:
                       headline, story, strengths (3), watch (2), guidance (3)
   ════════════════════════════════════════════════════════════════════ */

return [
    'stages' => [
        1 => [
            'name' => 'Foundation Years',
            'about' => 'Growing up and the early years of adulthood, when character, habits and your first big choices take shape.',
        ],
        2 => [
            'name' => 'Building Years',
            'about' => 'The adult years when career, relationships and responsibilities take root.',
        ],
        3 => [
            'name' => 'Harvest Years',
            'about' => 'The middle of life, when earlier effort shows its results and you decide what to keep, change or release.',
        ],
        4 => [
            'name' => 'Wisdom Years',
            'about' => 'Later life, the final cycle, when experience turns into wisdom, meaning and legacy.',
        ],
    ],

    'numbers' => [
        1 => ['keyword' => 'independence and initiative', 'arrival' => 'a push to take the lead and start something that is truly your own'],
        2 => ['keyword' => 'partnership and patience', 'arrival' => 'a slower, more relational rhythm in which cooperation achieves more than force'],
        3 => ['keyword' => 'creativity and self-expression', 'arrival' => 'a livelier season of communication, imagination and enjoyment'],
        4 => ['keyword' => 'structure and steady effort', 'arrival' => 'a call to build, organise and put solid foundations under your life'],
        5 => ['keyword' => 'change and freedom', 'arrival' => 'a period of movement, variety and welcome disruption'],
        6 => ['keyword' => 'care and responsibility', 'arrival' => 'a turn towards home, family, community and the people who depend on you'],
        7 => ['keyword' => 'reflection and inner growth', 'arrival' => 'a quieter, more inward season of study, meaning and depth'],
        8 => ['keyword' => 'achievement and authority', 'arrival' => 'a stage where ambition, resources and leadership come to the front'],
        9 => ['keyword' => 'compassion and completion', 'arrival' => 'a wider, more generous outlook, with endings that make room for what comes next'],
        11 => ['keyword' => 'inspiration and intuition', 'arrival' => 'heightened intuition and a pull towards inspiring others'],
        22 => ['keyword' => 'building on a grand scale', 'arrival' => 'the chance to turn big ideas into something lasting'],
        33 => ['keyword' => 'compassion and service', 'arrival' => 'a deep calling to nurture, teach and serve'],
    ],

    'readings' => [

        /* ───────────── 1 ───────────── */
        1 => [
            1 => [
                'headline' => 'Learning to Stand on Your Own',
                'story' => 'Growing up with the 1, you are pushed towards independence early. Perhaps the family expects you to manage, or perhaps it is simply an inner restlessness to do things your own way. Either way you form strong opinions, try things alone and discover how much you can handle. It can feel thrilling, and it can feel lonely.',
                'strengths' => ['Early confidence in your own ideas', 'Willingness to go first when others hesitate', 'Resilience from learning things the hard way'],
                'watch' => ['Brushing off advice from people who have already walked the road you are on', 'Mistaking stubbornness for strength, which can leave you without support just when you need it'],
                'guidance' => ['Pick one skill and take it from beginner to genuinely good, on your own initiative', 'Ask for help earlier than feels natural, because independence is stronger with allies', 'Notice what you want, separate from what is expected of you'],
            ],
            2 => [
                'headline' => 'Taking the Lead',
                'story' => 'This chapter hands you the controls. Work and responsibilities arrive with an unspoken question: will you step up? The 1 rewards initiative, whether that means starting the venture, volunteering for the difficult assignment or making the call everyone else avoids. Progress comes fastest when you trust your own judgement instead of waiting for permission.',
                'strengths' => ['Decisiveness when the answer is not obvious', 'The drive to start what others only discuss', 'Credibility earned by going first'],
                'watch' => ['Carrying everything alone because delegating feels slower', 'Overruling people who needed to be brought along'],
                'guidance' => ['Set one bold goal for this chapter and plan backwards from it', 'Build a small circle you trust to challenge you honestly', 'Share credit generously, since it buys loyalty that outlasts any single win'],
            ],
            3 => [
                'headline' => 'A Second Beginning',
                'story' => 'The 1 tends to arrive in midlife as a fresh start, not a slow glide. You look at what you have built and ask whether it still carries your own signature. You have the experience and the nerve to change course if it does not, and others may look to you for leadership you did not expect to be handed.',
                'strengths' => ['Experience paired with renewed courage', 'Authority from having already proved yourself', 'The ability to reinvent without starting from zero'],
                'watch' => ['Rushing into change to prove you still can, rather than because it is right', 'Leaning on past results so hard that newer voices go unheard'],
                'guidance' => ['Audit your life honestly: what is still yours, and what is only habit?', 'Start something small and new alongside what you already do', 'Mentor someone coming up behind you, because leadership matures when you share it'],
            ],
            4 => [
                'headline' => 'Independence on Your Own Terms',
                'story' => 'There is nothing quiet about the 1 in later life. It brings a strong wish to live by your own rules, keep decisions in your own hands and stay a participant rather than a spectator. Many people with this pinnacle are at their most openly themselves in these years, free at last of the need to impress anyone.',
                'strengths' => ['Self-reliance that protects your freedom', 'A clear sense of what you will and will not tolerate', 'The courage to begin something new at any age'],
                'watch' => ['Refusing support out of pride when accepting it would make life easier', 'Letting independence slide into distance from the people who care about you'],
                'guidance' => ['Take on a project that is entirely yours, however modest', 'Keep your circle active, because self-direction thrives with company', 'Tell your story while you still hold the pen: write it, record it, pass it on'],
            ],
        ],

        /* ───────────── 2 ───────────── */
        2 => [
            1 => [
                'headline' => 'Learning to Read the Room',
                'story' => 'Early life with the 2 is shaped by the people around you. You absorb moods, notice who is tense and who is hurting, and often become the one who keeps the peace. That sensitivity is a real gift, though it can teach you to put yourself second long before you realise you are doing it.',
                'strengths' => ['Natural empathy and a gift for listening', 'Early talent for mediation and teamwork', 'A gentleness that makes others feel safe'],
                'watch' => ['Absorbing other people’s feelings until you lose track of your own', 'Avoiding conflict so thoroughly that your needs never get spoken'],
                'guidance' => ['Practise saying what you want in plain words, even about small things', 'Look for at least one friendship where you are heard as much as you listen', 'Give your sensitivity an outlet: music, writing, animals or time outdoors'],
            ],
            2 => [
                'headline' => 'The Power of Partnership',
                'story' => 'Success in this chapter comes through other people. Collaborations, close partnerships and trusted teams are where the 2 does its best work, and patient diplomacy often achieves what force cannot. Progress may feel slower than you would like, but what is built together tends to last.',
                'strengths' => ['Skill at bringing people into agreement', 'An eye for the detail others overlook', 'Loyalty that deepens trust over time'],
                'watch' => ['Waiting to be chosen when you could step forward', 'Staying in an uneven partnership too long to keep the peace'],
                'guidance' => ['Choose collaborators for shared values, not just convenience', 'Negotiate what you need early rather than resenting it later', 'Let your quiet competence be noticed by naming what you contributed'],
            ],
            3 => [
                'headline' => 'Depth Over Speed',
                'story' => 'By the third chapter the 2 asks what your relationships have given you, and what you have given back. It is a season for repairing, deepening and sometimes quietly releasing connections that no longer nourish. Intuition tends to sharpen, and you may read situations faster than you can explain how.',
                'strengths' => ['Mature emotional intelligence', 'Standing as a trusted confidant', 'A talent for healing rifts others have given up on'],
                'watch' => ['Becoming everyone’s counsellor at the cost of your own energy', 'Holding grudges quietly instead of naming what hurt'],
                'guidance' => ['Invest in the two or three bonds that matter most', 'Schedule rest before you are depleted, not after', 'Trust a gut feeling enough to act on it once, and see what happens'],
            ],
            4 => [
                'headline' => 'The Gift of Presence',
                'story' => 'In the final cycle the 2 turns patience into wisdom. You are likely to be the person others seek out for steadiness: a listener, a peacemaker, someone whose company calms a room. Closeness with family, friends and community often matters more than achievement now, and brings some of the deepest satisfaction of your life.',
                'strengths' => ['Warmth that draws people close', 'Patience refined by long experience', 'A knack for bridging generations and viewpoints'],
                'watch' => ['Drifting into dependence when you could still be giving', 'Tolerating disrespect because you dislike a fuss'],
                'guidance' => ['Reach out to the people you love without waiting for an occasion', 'Offer your listening as a deliberate gift to a grandchild, a neighbour or a group', 'Keep some interests that belong to you alone'],
            ],
        ],

        /* ───────────── 3 ───────────── */
        3 => [
            1 => [
                'headline' => 'Finding Your Spark',
                'story' => 'The 3 tends to shape an expressive, curious young person, quick to spot the funny or beautiful side of things. Words, drawing, performance or simple social ease may show up early. The risk is not a shortage of talent but scattering it, with so many interests that none gets the patience it needs to deepen.',
                'strengths' => ['Imagination that makes ordinary things vivid', 'Social charm and a talent for making people laugh', 'Quick learning, especially through stories and play'],
                'watch' => ['Starting many things and finishing few', 'Hiding worry behind humour so nobody sees you struggling'],
                'guidance' => ['Pick one creative practice and stay with it long enough to get good', 'Find a mentor who takes your talent seriously', 'Say the true thing sometimes, not only the entertaining thing'],
            ],
            2 => [
                'headline' => 'Your Voice Goes Public',
                'story' => 'This chapter wants you visible. Communication, creativity and charisma are your working tools, and fields where ideas travel, such as writing, teaching, design, sales and media, tend to suit you. Opportunities often arrive through conversation, so being generous with your time and enthusiasm pays off.',
                'strengths' => ['Engaging, persuasive communication', 'Optimism that lifts teams and customers', 'Ideas that spark fresh solutions'],
                'watch' => ['Overcommitting because everything sounds fun', 'Spreading energy so wide that your best idea never gets fully built'],
                'guidance' => ['Pair your creativity with a dependable organiser or system', 'Release the imperfect version instead of polishing forever', 'Protect time for creating, not only for connecting'],
            ],
            3 => [
                'headline' => 'Harvesting Your Creativity',
                'story' => 'Somewhere in midlife the 3 invites you to gather what imagination has planted. Skills that once felt like hobbies can mature into your voice, your craft or a platform, and joy returns as a priority rather than a luxury. It is also a good season to ask what you would make if nobody were grading it.',
                'strengths' => ['Creative confidence earned through experience', 'The ability to teach and inspire', 'A renewed appetite for play and friendship'],
                'watch' => ['Using lightness to dodge a conversation that needs weight', 'Comparing your output with younger voices instead of trusting your own'],
                'guidance' => ['Finish the project you keep postponing', 'Share what you know, since teaching sharpens your voice', 'Plan fun on purpose instead of treating it as a reward for finishing everything else'],
            ],
            4 => [
                'headline' => 'A Life Well Told',
                'story' => 'The 3 makes later life something to be enjoyed. Humour, storytelling, hobbies and lively company keep you young in spirit, and you may become the person at the centre of gatherings, the one who remembers the good stories. Creative work in these years often carries a freedom that younger ambition never allowed.',
                'strengths' => ['Playfulness that keeps relationships alive', 'Stories and perspective worth passing on', 'Enthusiasm for learning something new'],
                'watch' => ['Letting social life replace deeper conversation', 'Talking about what you used to do instead of starting something now'],
                'guidance' => ['Write, record or perform something that carries your voice forward', 'Join a group built around a shared creative interest', 'Keep making plans that give you something to look forward to'],
            ],
        ],

        /* ───────────── 4 ───────────── */
        4 => [
            1 => [
                'headline' => 'Laying the First Bricks',
                'story' => 'The 4 makes the early years practical and sometimes demanding. You may grow up around hard work, duty or limited resources, or simply feel a sober need for things to be solid. It is not always glamorous, yet the habits formed here (discipline, reliability, doing things properly) can become a lasting foundation.',
                'strengths' => ['A strong work ethic from an early age', 'Dependability that earns trust', 'Patience with slow, steady projects'],
                'watch' => ['Taking life too seriously before you have had room to play', 'Fearing mistakes so much that you avoid trying new things'],
                'guidance' => ['Build one solid skill or qualification that opens doors', 'Schedule enjoyment as deliberately as you schedule work', 'Ask whether a rule serves you or only restricts you'],
            ],
            2 => [
                'headline' => 'Building Something That Lasts',
                'story' => 'This is the chapter of construction: a career, a home, savings, systems that work. The 4 rewards patience, planning and effort, and it rarely rewards shortcuts. Progress is often gradual and then suddenly obvious. People rely on you because you do what you say you will, and that reputation becomes your strongest asset.',
                'strengths' => ['Exceptional follow-through', 'A talent for turning plans into working systems', 'Practical and financial common sense'],
                'watch' => ['Working so hard that relationships and health quietly wait their turn', 'Resisting change even when the plan clearly needs to change'],
                'guidance' => ['Set milestones so you can see progress and celebrate it', 'Automate or delegate the routine so energy goes where it counts', 'Leave real space in the week for rest and for the people you love'],
            ],
            3 => [
                'headline' => 'Checking the Foundations',
                'story' => 'In the third chapter the 4 asks whether what you built still serves you. It is a season for reinforcing what is sound, repairing what has worn and releasing structures kept only out of habit. The stability you created earlier now gives you room to take more considered risks.',
                'strengths' => ['A clear eye for what is genuinely working', 'Practical wisdom that others respect', 'The patience to renovate instead of demolish'],
                'watch' => ['Defending old routines that have stopped fitting', 'Overworking in an attempt to feel secure'],
                'guidance' => ['Review finances, health and commitments honestly, with a plan for each', 'Swap one rigid habit for a flexible one', 'Invest in something solid that also nourishes you, such as a craft, a skill or a place'],
            ],
            4 => [
                'headline' => 'The Steady Legacy',
                'story' => 'Order, security and dependable rhythm take centre stage when the 4 reaches later life. You may be the family’s anchor, the keeper of practical knowledge, someone who leaves things tidier and more secure than you found them. Routine brings comfort, as long as you do not let it harden into a cage.',
                'strengths' => ['A calm reliability that steadies others', 'Hands-on skills worth teaching', 'Wise management of resources'],
                'watch' => ['Insisting that things be done your way because that is how it has always worked', 'Avoiding new experiences because they disturb your routine'],
                'guidance' => ['Pass practical know-how to someone willing to learn it', 'Add one new experience each season to keep life fresh', 'Tidy practical matters at an unhurried pace, then enjoy the peace of having done it'],
            ],
        ],

        /* ───────────── 5 ───────────── */
        5 => [
            1 => [
                'headline' => 'The Restless Explorer',
                'story' => 'A First Pinnacle of 5 can feel like growing up in motion: moves, changes of school, shifting friendships and a hunger to see what lies beyond the familiar. You learn by doing, and curiosity pulls you in many directions at once. Freedom feels essential, long before you know what you want to do with it.',
                'strengths' => ['Adaptability to new places and people', 'Quick, curious intelligence', 'Courage to try what others avoid'],
                'watch' => ['Letting boredom drive impulsive choices you later regret', 'Resisting commitment so firmly that good opportunities pass by'],
                'guidance' => ['Travel, volunteer or study somewhere new if you can, since experience is your best teacher', 'Keep one stable anchor, such as a friend, a routine or a place, while everything else changes', 'Sleep on big decisions before you make them'],
            ],
            2 => [
                'headline' => 'Riding the Waves of Change',
                'story' => 'Expect variety in this chapter: new jobs, new places, unexpected openings and perhaps more than one career. The 5 thrives on movement, communication and adaptability, and the people who gain most here treat change as information rather than a threat. Freedom matters, but so does knowing what you are moving towards.',
                'strengths' => ['Versatility across fields and situations', 'Lively, persuasive communication', 'Comfort with uncertainty that unsettles other people'],
                'watch' => ['Chasing novelty and leaving projects half-finished', 'Using treats, spending or distraction as relief from routine'],
                'guidance' => ['Build skills that travel well, because they open doors wherever you go', 'Make commitments in a form that leaves you some room to move', 'Choose a direction as well as a pace, so that movement becomes progress'],
            ],
            3 => [
                'headline' => 'Reinvention Season',
                'story' => 'Around midlife, the 5 loosens the structure you may have spent decades building. A job change, a move, a new relationship with your own freedom: something shifts, and it is often welcome. You now have enough experience to move boldly without being reckless, and the world feels larger again.',
                'strengths' => ['Energy for reinvention', 'Experience that makes bold moves smarter', 'Ease with new people and unfamiliar settings'],
                'watch' => ['Running from a problem that would follow you anywhere', 'Confusing excitement with fulfilment'],
                'guidance' => ['Decide what you want to keep stable before changing everything else', 'Try the new direction in a small way first', 'Make time for physical movement, which often helps a restless mind settle'],
            ],
            4 => [
                'headline' => 'Freedom, Finally',
                'story' => 'The 5 in later life is a lively, curious companion. Travel, new friends, fresh interests and an openness to change keep you engaged long after others settle into routine. Freedom is the prize of these years, and you are likely to use it. The real question is what you will fill it with.',
                'strengths' => ['A youthful mind and open attitude', 'A talent for fitting into any company', 'An appetite for experience that keeps life interesting'],
                'watch' => ['Restlessness that keeps you from deepening the relationships you already have', 'Overextending your energy or health as if nothing had changed'],
                'guidance' => ['Plan a few meaningful journeys or adventures, not just distractions', 'Stay close to the people who know the whole of you', 'Look after your body so your appetite for life has the means to follow it'],
            ],
        ],

        /* ───────────── 6 ───────────── */
        6 => [
            1 => [
                'headline' => 'A Heart That Notices',
                'story' => 'Home and belonging sit at the centre of your early years with the 6. You tend to be the responsible one, the carer, the peacemaker in the family, sometimes carrying adult worries long before you should. Beauty, loyalty and a deep wish for harmony shape who you become.',
                'strengths' => ['Natural warmth and dependability', 'A sense of fairness and duty to others', 'An eye for comfort and beauty'],
                'watch' => ['Becoming the family’s emotional caretaker at the cost of your own childhood', 'Believing that love has to be earned by being useful'],
                'guidance' => ['Let yourself be looked after sometimes', 'Choose friends who give as well as take', 'Express care through making and creating, not only through fixing'],
            ],
            2 => [
                'headline' => 'Home, Love and Commitment',
                'story' => 'This chapter often revolves around the people you love: partnership, children, home, community and work that serves others. The 6 rewards devotion and fairness, and you may find yourself carrying more responsibility than most. When balanced, you create the kind of warm, stable world that others are grateful to belong to.',
                'strengths' => ['Loyalty that builds deep trust', 'A gift for creating welcoming spaces', 'Strength in caring professions and service roles'],
                'watch' => ['Taking on everyone’s burdens because saying no feels unkind', 'Trying to control outcomes for the people you want to protect'],
                'guidance' => ['Draw clear lines around what you can carry', 'Ask for help without apologising for it', 'Keep one pursuit for yourself that nobody depends on'],
            ],
            3 => [
                'headline' => 'Reaping What You Have Tended',
                'story' => 'Midlife is when the 6 shows you the fruits of everything you have tended. Family life matures, relationships deepen and communities you served may begin to support you in return. It is also a time to examine the balance between giving and receiving, and to ask whether your devotion has left room for your own happiness.',
                'strengths' => ['Respect earned through years of care', 'Emotional depth and a steadying presence', 'Skill at easing tension in families and groups'],
                'watch' => ['Resentment building quietly behind constant giving', 'Struggling to let others make their own mistakes'],
                'guidance' => ['Say a gentle no where you used to say an automatic yes', 'Invest in your own health and comfort without guilt', 'Redirect nurturing energy into mentoring or community leadership'],
            ],
            4 => [
                'headline' => 'The Heart of the Family',
                'story' => 'The 6 in later life is among the warmest of the pinnacles. You may become the one who brings people together, remembers the birthdays and offers a steady, loving presence. Contentment grows from being part of something and from the quiet satisfaction of having cared well.',
                'strengths' => ['Deep, enduring loyalty', 'A gift for making people feel at home', 'Wisdom about what truly matters in relationships'],
                'watch' => ['Worrying constantly about other people’s choices', 'Expecting your devotion to be repaid in particular ways'],
                'guidance' => ['Say “I love you” and “thank you” often, and out loud', 'Let others care for you, since that is a gift to them too', 'Share family stories and traditions before they are forgotten'],
            ],
        ],

        /* ───────────── 7 ───────────── */
        7 => [
            1 => [
                'headline' => 'The Quiet Observer',
                'story' => 'The 7 tends to shape a thoughtful, somewhat private upbringing. You watch before you join, ask why things work as they do, and may feel slightly different from those around you. Loneliness and curiosity are both common here, and a rich inner world takes shape early.',
                'strengths' => ['Deep curiosity and a questioning mind', 'Capacity for focused study', 'Comfort with solitude'],
                'watch' => ['Retreating so far that others cannot reach you', 'Mistaking being misunderstood for being unlovable'],
                'guidance' => ['Follow one subject deeply, because that is where your mind comes alive', 'Find at least one person with whom you can think aloud', 'Spend time in nature, which can settle a busy inner world'],
            ],
            2 => [
                'headline' => 'Mastery in Private',
                'story' => 'This chapter favours depth over display. Study, specialist skills, research, spiritual practice and focused craft suit the 7, and you may do your best work away from the noise. Recognition can come more slowly than it does for others, but it tends to be for real expertise rather than surface polish.',
                'strengths' => ['Analytical depth and attention to detail', 'Independent thinking that finds what others miss', 'Authority built on actual knowledge'],
                'watch' => ['Keeping yourself so apart that relationships thin out', 'Perfectionism that delays sharing your work'],
                'guidance' => ['Develop a specialism and become known for it', 'Schedule time with other people as firmly as time alone', 'Show work in progress to someone you trust before it feels finished'],
            ],
            3 => [
                'headline' => 'The Inner Reckoning',
                'story' => 'When the 7 arrives in midlife, your attention turns inward. Big questions return: what do you actually believe, what has been worth the effort, what is missing? It can feel like a retreat, but it is closer to a recalibration, and the answers that surface tend to reshape what you do next.',
                'strengths' => ['Insight that cuts through noise', 'Spiritual or philosophical depth', 'Discernment about what deserves your time'],
                'watch' => ['Cynicism that follows disappointment', 'Withdrawing precisely when connection would help most'],
                'guidance' => ['Set aside regular quiet time for reflection, such as journaling or meditation', 'Study something that has always intrigued you', 'Talk the big questions through with someone wise instead of silently'],
            ],
            4 => [
                'headline' => 'The Wise Elder',
                'story' => 'Serenity and depth arrive with the 7 in later life. Reading, nature, reflection and spiritual or philosophical inquiry give these years a contemplative richness, and others may come to you for perspective. You are comfortable with solitude, and you tend to see through what other people find confusing.',
                'strengths' => ['Calm, considered wisdom', 'A rich inner life', 'The ability to find meaning in simple things'],
                'watch' => ['Isolation that tips from restful into lonely', 'Keeping your insights entirely to yourself'],
                'guidance' => ['Choose one question you never had time for and give it proper attention', 'Keep a few warm, regular connections', 'Let yourself enjoy simple pleasures without analysing them'],
            ],
        ],

        /* ───────────── 8 ───────────── */
        8 => [
            1 => [
                'headline' => 'Early Lessons in Power',
                'story' => 'Money, authority and responsibility find you early with the 8, through a driven family, financial pressure or simply an inner drive to achieve. Ambition develops young, and so does an awareness of what things cost. You learn quickly that effort carries both a price and a payoff.',
                'strengths' => ['Early maturity and sense of purpose', 'Natural business and leadership instincts', 'Perseverance in the face of obstacles'],
                'watch' => ['Equating your worth with what you achieve', 'Becoming hard on yourself, or on others, before you have learned gentleness'],
                'guidance' => ['Build a healthy relationship with money: earning, saving and giving', 'Choose goals you actually want, not just ones that look impressive', 'Surround yourself with people who value you beyond your results'],
            ],
            2 => [
                'headline' => 'Building Authority',
                'story' => 'This is the power chapter: careers, finances, influence and leadership move to the front. The 8 rewards sustained effort, strategic thinking and integrity, and it can bring recognition and material progress. It also tests how you handle power, and fairness tends to protect both respect and relationships.',
                'strengths' => ['Executive ability and strategic vision', 'Resilience through setbacks', 'A talent for managing resources and people'],
                'watch' => ['Becoming consumed by work and status', 'Treating relationships as transactions'],
                'guidance' => ['Set your ethical lines early, because they will be tested', 'Decide what you want money to do for you, and revisit that as life changes', 'Treat rest and real intimacy as non-negotiable'],
            ],
            3 => [
                'headline' => 'The Reckoning and the Reward',
                'story' => 'In the third chapter the 8 returns with results. Effort invested earlier tends to show up now as position, influence or financial standing, and the question becomes what to do with it. It is a time to weigh success against fulfilment, and to decide what your authority is actually for.',
                'strengths' => ['Hard-won expertise that commands respect', 'The ability to make large decisions calmly', 'Capacity to build something lasting'],
                'watch' => ['Chasing more when you already have enough', 'Holding on to control after it has stopped being necessary'],
                'guidance' => ['Define “enough” for yourself, and notice when you reach it', 'Use your influence to open doors for others', 'Rebalance towards health and relationships before they demand it'],
            ],
            4 => [
                'headline' => 'Authority Used Well',
                'story' => 'Experience, resources and respect can converge when the 8 reaches later life. You may be advising, funding, leading or guiding from a position of long-earned credibility. The 8 here asks you to use that standing generously, and to value what money and status cannot buy.',
                'strengths' => ['Judgement sharpened by decades of consequences', 'Natural authority that others trust', 'An ability to guide institutions or families'],
                'watch' => ['Staying in control long after it serves anyone', 'Tying your identity to a role you no longer hold'],
                'guidance' => ['Plan your succession and legacy deliberately', 'Give generously, with time and knowledge as well as money', 'Find a purpose that does not rely on a job title'],
            ],
        ],

        /* ───────────── 9 ───────────── */
        9 => [
            1 => [
                'headline' => 'An Old Soul Grows Up',
                'story' => 'The 9 often shows up early as unusual maturity and a wide, sympathetic heart. You may feel injustice keenly, ache for people who are struggling and wonder early about your place in the larger picture. Endings, losses or upheaval in your early years can teach compassion sooner than you would have chosen.',
                'strengths' => ['Empathy and moral sensitivity', 'A broad view beyond your own circle', 'Creative, idealistic imagination'],
                'watch' => ['Taking on the world’s pain as though all of it were yours', 'Struggling to focus on your own immediate path'],
                'guidance' => ['Channel concern into one practical cause rather than every cause', 'Learn to let go of what you cannot change', 'Protect your own wellbeing so that your generosity stays sustainable'],
            ],
            2 => [
                'headline' => 'Working for Something Bigger',
                'story' => 'The 9 in your building years asks for purpose beyond personal gain. Teaching, healing, the arts and public-facing work often feel right, and even in other fields you need your work to mean something. It can also bring a sense of finishing things: relationships, jobs and ideas that have run their course.',
                'strengths' => ['Generosity and a talent for inspiring others', 'Vision that connects work to a larger purpose', 'Willingness to let go of what no longer fits'],
                'watch' => ['Giving more than you can sustain', 'Staying in a dying situation out of idealism or loyalty'],
                'guidance' => ['Align what you do with what you care about, even partly', 'Practise clean endings, with gratitude instead of bitterness', 'Set limits on your generosity before exhaustion sets them for you'],
            ],
            3 => [
                'headline' => 'Completion and Release',
                'story' => 'The 9 turns midlife into a season of clearing. You close chapters, forgive old hurts and release what served earlier versions of you. Emotional clutter, outdated roles and unfinished business ask for attention, and as they clear, space opens for work and love that feel truer.',
                'strengths' => ['Perspective gained from surviving endings', 'Compassion for yourself and others', 'The ability to forgive and move on'],
                'watch' => ['Dwelling on loss instead of learning from it', 'Cutting things off abruptly instead of finishing them well'],
                'guidance' => ['Write the letter, make the call or take the step you have put off', 'Consciously let go of one thing each season', 'Use what you have learned to help someone standing where you once stood'],
            ],
            4 => [
                'headline' => 'The Universal Heart',
                'story' => 'In later life the 9 brings the widest view of any number. Compassion, wisdom and a wish to contribute to something beyond yourself shape these years. You are likely to care about the world you leave behind and to find fulfilment in giving, teaching and quiet service.',
                'strengths' => ['A deep, tolerant humanity', 'Wisdom from watching many things end and begin', 'A natural fit for mentoring and community work'],
                'watch' => ['Disappointment when the world falls short of your ideals', 'Holding on to old griefs'],
                'guidance' => ['Choose a cause or community and give it regular time', 'Settle one old disagreement, if it feels right to you', 'Practise gratitude for what has been, and release what could have been'],
            ],
        ],

        /* ───────────── 11 (master) ───────────── */
        11 => [
            1 => [
                'headline' => 'A Sensitive Spark',
                'story' => 'An 11 in your First Pinnacle often means a highly sensitive, intuitive early life. You may sense atmospheres, notice what others miss and feel things intensely. That can be bewildering as a child and brilliant as an adult, since the same antennae that overwhelm you also give you a gift for insight and inspiration. If the intensity becomes too much, the gentler 2 beneath it, steady and cooperative, can help steady you.',
                'strengths' => ['Heightened intuition', 'Imagination and creative vision', 'An ability to inspire through presence alone'],
                'watch' => ['Nervous tension, self-doubt or feeling different from everyone', 'Withdrawing to cope instead of learning to ground yourself'],
                'guidance' => ['Build calming routines around sleep, movement and quiet time outdoors', 'Find people who respect your sensitivity', 'Give your vision a creative outlet such as art, music or writing'],
            ],
            2 => [
                'headline' => 'Inspiring Through Insight',
                'story' => 'In your building years the 11 pulls you towards work that speaks to people at a deeper level: teaching, healing, the arts, counselling, or visionary and spiritual pursuits. You often see where things could go before anyone else, which is exciting and, at times, isolating. The 2 beneath keeps cooperation central, and your ideas land best when carried by partnership.',
                'strengths' => ['Intuitive vision that anticipates what is coming', 'A magnetic, inspiring presence', 'The ability to bring ideals into everyday conversation'],
                'watch' => ['Anxiety when reality does not match the picture in your mind', 'Burnout from running on nervous energy'],
                'guidance' => ['Turn inspiration into small, concrete steps', 'Partner with a practical person who can ground the vision', 'Protect your energy with firm rest and clear boundaries'],
            ],
            3 => [
                'headline' => 'The Awakening',
                'story' => 'For the 11, midlife often feels like a deepening or an awakening. Questions of meaning and purpose become pressing, and intuition grows louder. You may feel called to share something, whether an idea, a teaching or simply a more honest way of living. The grounded, relational 2 beneath helps you bring it down to earth.',
                'strengths' => ['Intensified intuition and creative insight', 'A powerful influence on those around you', 'Courage to follow an inner call'],
                'watch' => ['Impatience with the ordinary routines that sustain life', 'Expecting too much of yourself and of other people'],
                'guidance' => ['Keep a record of your insights and notice which ones repeat', 'Test big ideas with trusted friends before committing', 'Balance inspiration with daily practicalities such as meals, sleep and finances'],
            ],
            4 => [
                'headline' => 'A Beacon in Later Life',
                'story' => 'The 11 in later life can make you a quiet source of light for others. Insight, spiritual depth and a sensitivity that has matured into wisdom give you a presence people trust. These years carry the chance to teach through who you are, not just what you say, with the 2 within it keeping warmth and connection at the heart of the teaching.',
                'strengths' => ['Intuitive wisdom softened by experience', 'A calming, inspiring presence', 'A talent for encouraging other people’s growth'],
                'watch' => ['Sensitivity to criticism or slights', 'Retreating from the world instead of engaging with it'],
                'guidance' => ['Mentor one person whose gifts remind you of your younger self', 'Stay physically active to keep nervous energy balanced', 'Spend time with people who lift you'],
            ],
        ],

        /* ───────────── 22 (master) ───────────── */
        22 => [
            1 => [
                'headline' => 'A Big Blueprint',
                'story' => 'A First Pinnacle of 22 can feel like growing up with a large, hard-to-name sense of purpose, and with the pressure that follows. You may be a practical visionary even as a child, someone who wants to build something that matters. The pressure to achieve can be heavy, and the grounded 4 beneath it, steady and methodical, is there to hold you up.',
                'strengths' => ['Combining big ideas with practical sense', 'Early discipline and focus', 'The capacity to see how large goals can be built'],
                'watch' => ['Feeling overwhelmed by expectations, your own or other people’s', 'Putting off starting because the vision feels too large'],
                'guidance' => ['Break the vision into one small, achievable first step', 'Learn the foundations of a craft or trade thoroughly', 'Remind yourself that it is fine to build slowly'],
            ],
            2 => [
                'headline' => 'The Master Builder at Work',
                'story' => 'Your building years with the 22 offer unusual potential to turn large ideas into lasting structures: organisations, businesses, communities, systems that serve many people. It demands patience, planning and sustained effort, and it is easy to feel crushed by the scale. Practical habits, the 4 side of the 22, make the scale manageable.',
                'strengths' => ['The ability to organise people and resources around big goals', 'Practicality married to vision', 'Perseverance on long projects'],
                'watch' => ['Taking on more than any one person can carry', 'Perfectionism that stalls progress'],
                'guidance' => ['Build a capable team, since this chapter is bigger than one person', 'Plan in phases with clear milestones', 'Take regular breaks so that you can sustain the pace'],
            ],
            3 => [
                'headline' => 'Building at Full Strength',
                'story' => 'Midlife is often when the 22 offers the chance to build or lead something of real significance. Years of experience can finally match the scale of your ambition. The stakes feel higher, and so does your capacity. When the pressure builds, the steady 4 beneath the 22 can help, because daily effort is often the way back to calm.',
                'strengths' => ['Large-scale thinking backed by experience', 'The capacity to lead and realise ambitious projects', 'Practical wisdom that makes ideas work'],
                'watch' => ['Becoming consumed by the project at the expense of everything else', 'Self-criticism when the result falls short of the vision'],
                'guidance' => ['Choose the one major project that deserves your best energy', 'Invite collaborators and let them own parts of it', 'Check in on your health and relationships on a regular schedule'],
            ],
            4 => [
                'headline' => 'Legacy Built to Last',
                'story' => 'In later life the 22 turns to legacy: something that will outlast you, whether an institution, a body of work, a family tradition or a community. You see how things hold together over time, and you are likely to be consulted for your sense of what is built to last. The steady 4 beneath keeps the work grounded and doable.',
                'strengths' => ['A long view that others find reassuring', 'The ability to organise legacy and succession', 'Practical wisdom with visionary depth'],
                'watch' => ['Controlling a project that needs to be handed on', 'Burdening yourself with expectations you no longer need to meet'],
                'guidance' => ['Document what you know so that it can be used after you', 'Mentor a successor and let them make it theirs', 'Stand back and enjoy what you have built'],
            ],
        ],

        /* ───────────── 33 (master) ───────────── */
        33 => [
            1 => [
                'headline' => 'A Tender Responsibility',
                'story' => 'The 33 often brings an early sense of responsibility for other people’s wellbeing, along with a strong compassionate streak. You may be the child who looks after everyone, or the one who feels the family’s moods very keenly. It is a lot to carry, and the loving, homely 6 beneath the 33 offers a simpler way to be caring without being consumed.',
                'strengths' => ['Exceptional compassion', 'Natural nurturing instincts', 'A gift for soothing and encouraging others'],
                'watch' => ['Taking responsibility for people who should be carrying their own load', 'Neglecting your own needs in the name of love'],
                'guidance' => ['Learn the difference between caring for someone and rescuing them', 'Allow yourself to play and to be looked after, even when others lean on you', 'Find outlets for compassion that are healthy and bounded'],
            ],
            2 => [
                'headline' => 'Service as a Way of Life',
                'story' => 'In your building years the 33 pulls you towards teaching, healing, caring and service on a significant scale. Work and relationships alike tend to be shaped by the wish to uplift others. It can be deeply fulfilling and also draining, and the steadying 6 beneath it, practical and home-loving, helps you give in a sustainable way.',
                'strengths' => ['An uplifting, healing presence', 'Willingness to serve with sincerity', 'The ability to inspire trust and loyalty'],
                'watch' => ['Taking on other people’s problems until you are depleted', 'Giving so freely that missing appreciation stings more than you expect'],
                'guidance' => ['Set clear working hours and keep to them', 'Surround yourself with people who give back', 'Make your own home and body a place of restoration'],
            ],
            3 => [
                'headline' => 'The Teacher Within',
                'story' => 'A calling to teach, guide or heal, formally or simply by example, often arrives with the 33 in midlife. Your experience of what hurts and what helps has become something other people can learn from. The practical 6 beneath helps you bring that wisdom to your own family and community first.',
                'strengths' => ['Compassionate authority', 'The ability to turn experience into guidance', 'A gentle, inspiring presence'],
                'watch' => ['Expecting too much of yourself as a role model', 'Overlooking your own healing while helping others'],
                'guidance' => ['Teach from your own lived experience, not just theory', 'Seek support for yourself as readily as you offer it', 'Start with the people nearest to you'],
            ],
            4 => [
                'headline' => 'A Life of Giving',
                'story' => 'Profound love is the keynote when the 33 reaches later life. You may be the grandparent, mentor or community elder whose kindness people remember for decades. Giving feels natural here, so the work is to keep it joyful rather than dutiful, and home and rest are part of giving well, not a rival to it.',
                'strengths' => ['Warmth that makes people feel valued', 'Compassionate wisdom', 'A generous spirit'],
                'watch' => ['Giving past the point of your own health', 'Feeling unappreciated when your care goes unnoticed'],
                'guidance' => ['Give in ways that also feed you, such as teaching, gardening, cooking or music', 'Accept help and appreciation graciously', 'Leave notes, stories or recipes that carry your love forward'],
            ],
        ],
    ],
];