<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   CHALLENGE NUMBERS — READINGS
   stages[1..4]        name and short introduction for each challenge position
   numbers[0..8]       keyword (used in the journey line and "Right now"),
                       main (used for the Main Challenge in the closing section)
   readings[n][1..4]   headline, story and the lists shows / work / gift
   ════════════════════════════════════════════════════════════════════ */

return [
    'stages' => [
        1 => ['name' => 'The Formative Years', 'about' => 'The opening chapter of life, when this challenge first takes shape in family, school and early independence.'],
        2 => ['name' => 'The Building Years', 'about' => 'The chapter of work, partnership and independence, when this challenge is tested in everyday choices.'],
        3 => ['name' => 'The Main Challenge', 'about' => 'The central thread of your life. It runs beneath every chapter and often asks for attention again and again.'],
        4 => ['name' => 'The Later Years', 'about' => 'The closing chapter, when this challenge softens into wisdom if you have been working with it.'],
    ],

    'numbers' => [
        0 => ['keyword' => 'open choice and self-direction', 'main' => 'choosing which lessons to meet, and meeting them on your own terms'],
        1 => ['keyword' => 'independence and self-belief', 'main' => 'trusting your own judgement without shutting other people out'],
        2 => ['keyword' => 'sensitivity and balance', 'main' => 'keeping hold of your own voice while staying open and caring'],
        3 => ['keyword' => 'self-expression and confidence', 'main' => 'speaking and creating as yourself, whatever the response'],
        4 => ['keyword' => 'discipline and patience', 'main' => 'building steady habits that still leave room to adapt'],
        5 => ['keyword' => 'freedom and commitment', 'main' => 'keeping your freedom while staying committed to what matters'],
        6 => ['keyword' => 'responsibility and care', 'main' => 'giving generously without carrying everyone else’s load'],
        7 => ['keyword' => 'trust and openness', 'main' => 'trusting people and life enough to let others in'],
        8 => ['keyword' => 'power, money and self-worth', 'main' => 'handling power and money fairly, and without fear'],
    ],

    'readings' => [
        /* ───────────── 0 ───────────── */
        0 => [
            1 => [
                'headline' => 'A Path With No Map',
                'story' => 'Most challenges hand you something to wrestle with; a 0 hands you a blank page. In your early years that can feel like freedom without instructions: plenty of options, few signposts, and a quiet suspicion that everyone else was told something you missed. You may have waited to be steered, or borrowed other people’s plans because they came ready-made. The real work is learning to choose, and to trust that your choices count even when nobody confirms them. The sooner you treat small decisions as practice for large ones, the less empty the page feels.',
                'shows' => ['Hesitating because every option seems equally possible', 'Taking on the plans and opinions of stronger personalities', 'Feeling behind peers who appear to know exactly what they want'],
                'work' => ['Try things in small, reversible ways and notice what you keep returning to', 'Ask yourself what you want before asking what is expected', 'Commit to one direction for a season, even if it is not forever'],
                'gift' => ['An open mind that sees possibilities others miss', 'The freedom to shape your own course'],
            ],
            2 => [
                'headline' => 'Choosing Without a Script',
                'story' => 'Careers, partners and places to live can all seem possible in the building years, which is thrilling right up to the moment a decision is due. Some people with a 0 drift into whatever arrives first; others keep waiting for a sign that never quite comes. Neither is a failure, only a pause that has gone on a little long. Deciding is a skill, and like any skill it improves with repetition. Each choice you make, even an imperfect one, teaches you something that no amount of weighing up in advance could have shown you.',
                'shows' => ['Drifting into jobs or relationships because they were available', 'Postponing decisions until circumstances make them for you', 'Envying people whose paths seem fixed'],
                'work' => ['Write down what matters most to you and use it as a filter', 'Give each decision a deadline', 'Review your choices after a year and adjust without self-blame'],
                'gift' => ['Flexibility when plans change', 'A fresh view of what is worth doing'],
            ],
            3 => [
                'headline' => 'The Challenge of Choice',
                'story' => 'Your Main Challenge is a 0, and it is the odd one out: no single obstacle to name, just a persistent question about who you are and what you will stand for. Traditionally it is read as holding the potential for every other challenge, along with the tools to meet each one, so lessons can arrive in turn rather than all at once. The question tends to sharpen over time, because drifting has a visible cost the longer it goes on. The reward for answering it is a life that is unmistakably your own.',
                'shows' => ['Feeling pulled in several directions at once', 'Doubting that you are using your potential', 'A sense that no single theme explains you, because every lesson takes a turn'],
                'work' => ['Name your core values and let them guide your choices', 'Seek mentors for perspective, not for permission', 'Build a few steady habits that hold you up while you decide'],
                'gift' => ['Wide-ranging adaptability', 'A self-authored life'],
            ],
            4 => [
                'headline' => 'Free to Begin Again',
                'story' => 'Obligations often loosen in later life, and the old question returns in a gentler form: what do you want to do with time that is truly yours? Without a purpose of your own choosing, these years can feel shapeless, with one day sliding into the next. With one, they become some of the most liberating of all. The 0 has been training you for this moment, since it has always asked you to decide for yourself. Now there is more room to do it, and far less to prove.',
                'shows' => ['Days that feel undefined once old routines fall away', 'Wondering whether it is too late to start something', 'Leaning on others to set the agenda'],
                'work' => ['Choose one project, group or practice and give it regular time', 'Treat curiosity as a reason to start, whatever your age', 'Create a loose weekly rhythm that gives your freedom some shape'],
                'gift' => ['Time and room to follow what interests you', 'The confidence of a person who has chosen many times'],
            ],
        ],

        /* ───────────── 1 ───────────── */
        1 => [
            1 => [
                'headline' => 'Finding Your Own Voice',
                'story' => 'Growing up with a 1 often means a tug-of-war over independence. You may have lived beside a strong personality, such as a parent, sibling or teacher, who made it hard to form opinions of your own. Or you may have pushed against authority simply to prove you could think for yourself. Both are ways of searching for the same thing: a voice that is unmistakably yours. What these years teach is that your ideas are worth saying aloud and your own pace is worth trusting, even when it is not the pace of everyone around you.',
                'shows' => ['Doubting your opinions until someone else agrees', 'Bristling when told what to do', 'Hesitating to start things on your own'],
                'work' => ['Make small decisions for yourself and notice that you can live with them', 'Disagree politely, and out loud, now and then', 'Find activities where you stand or fall on your own effort'],
                'gift' => ['Growing self-reliance', 'The courage to be different'],
            ],
            2 => [
                'headline' => 'Standing on Your Own',
                'story' => 'Independence gets tested properly in the building years, in work and in love. Some people with a 1 hold back, waiting for approval before they act. Others overcorrect, taking charge of everything and brushing off help as interference. Both leave you more alone than you need to be. The sweet spot is quiet confidence: willing to lead, willing to listen, and secure enough that neither role feels like a threat. It tends to arrive the first time you carry something through from start to finish on your own judgement.',
                'shows' => ['Waiting for permission that nobody is withholding', 'Taking over tasks because it feels quicker to do them yourself', 'Seeing collaboration as a threat to your authority'],
                'work' => ['Lead one small project from start to finish', 'Ask for input before deciding, then decide', 'Share credit generously'],
                'gift' => ['Initiative that others are glad to follow', 'Resilience when you have to go first'],
            ],
            3 => [
                'headline' => 'Self-Belief Without Isolation',
                'story' => 'A 1 as your Main Challenge keeps returning to one balance: self-belief without arrogance, independence without isolation. You may swing between doubting yourself and insisting on your own way, and those swings can cost you something real, such as a partnership, a promotion or a friendship. That moment is useful, because it shows exactly where the balance has slipped. Holding your ground gently, and letting other people hold theirs, is the work of a lifetime, and it can make you a leader people follow because they want to.',
                'shows' => ['Swinging between self-doubt and stubbornness', 'Finding it hard to accept help or advice', 'Feeling alone at the top of your own decisions'],
                'work' => ['Treat confidence as a practice built from promises you keep to yourself', 'Welcome challenge from people you respect', 'Delegate something that matters to you'],
                'gift' => ['A strong, original sense of direction', 'The ability to start what others only talk about'],
            ],
            4 => [
                'headline' => 'Strength Without Control',
                'story' => 'Later life asks you to stay independent without gripping. After decades of deciding for yourself, it can be hard to share a decision, accept a lift, or let a younger person take the lead. Strength in these years looks different from before: you know your own mind, you say it clearly, and you accept support without feeling smaller for it. People will go on treating you as a source of steadiness if you let them in occasionally. Independence that has room for others is often the most durable kind.',
                'shows' => ['Insisting on doing things your way after it stops being practical', 'Resisting help from family or professionals', 'Feeling sidelined when others take the lead'],
                'work' => ['Pass on responsibilities gradually, on your own terms', 'Take up something new that is entirely yours', 'Let someone younger lead and notice what you learn'],
                'gift' => ['Hard-won self-knowledge', 'A steady example of independence'],
            ],
        ],

        /* ───────────── 2 ───────────── */
        2 => [
            1 => [
                'headline' => 'The Sensitive Heart',
                'story' => 'A child with a 2 tends to be a sensitive observer. You pick up moods before anyone speaks, notice slights others miss, and may take criticism harder than anyone intended. Shyness and a wish to keep everyone happy are common, and so is the habit of staying quiet to avoid a scene. Growth here means seeing that sensitivity is a strength, though it needs a thicker skin to go with it. Not every comment is a verdict on you, and the people who matter are likely to still value you when you say what you think.',
                'shows' => ['Withdrawing or tearing up over remarks others forget', 'Going along with the group to avoid conflict', 'Feeling responsible for the mood in the room'],
                'work' => ['Separate what was said from what you fear it means', 'Practise saying no on small things', 'Spend time with friends who are gentle and honest'],
                'gift' => ['Deep empathy', 'An early ear for what people need'],
            ],
            2 => [
                'headline' => 'Between Pleasing and Standing Firm',
                'story' => 'Harmony comes naturally to you, which is exactly why relationships become the testing ground in the building years. Indecision, putting others first by default and swallowing small resentments can quietly pile up, then surface at an awkward moment. Partners and colleagues may not realise you wanted something different, because you never said so. Stating your needs early is kinder to everyone than hoping they will guess. The 2 is asking you to be a full participant in your own relationships, not their most accommodating guest.',
                'shows' => ['Saying yes while meaning no', 'Struggling to choose when two options both seem fair', 'Staying in uneven partnerships to keep the peace'],
                'work' => ['Say what you need in one clear sentence', 'Decide small things quickly to build the habit', 'Notice when helping becomes self-erasing'],
                'gift' => ['A natural gift for cooperation', 'Patience that calms tense situations'],
            ],
            3 => [
                'headline' => 'The Peacemaker’s Test',
                'story' => 'As your Main Challenge, the 2 turns sensitivity into a lifelong study. You feel deeply, read people well and crave connection, and the same qualities can leave you easily hurt or reluctant to act. Again and again, life asks you to find your own voice inside relationships instead of dissolving into them. Boundaries are the answer, and they are an act of care, not a withdrawal of it. Learn to say a gentle no and a clear yes, and your natural talent for bringing people together stops costing you so much.',
                'shows' => ['Taking criticism to heart for days', 'Putting off decisions that might upset someone', 'Feeling drained after time with demanding people'],
                'work' => ['Treat boundaries as part of caring, not the opposite of it', 'Keep a few relationships that are honest in both directions', 'Give yourself time alone to recover your own opinions'],
                'gift' => ['Tact and emotional intelligence', 'The ability to bring people together'],
            ],
            4 => [
                'headline' => 'Gentleness With Boundaries',
                'story' => 'Warmth marks later life with a 2, though old habits of over-accommodating can follow you into it. You may become the family’s gentle mediator, the friend people phone with their troubles, the one who always makes it work. It is a good role as long as it feeds you too. The task is to keep your kindness and also your say in how you spend your days. Speaking up about small preferences is good practice, and the people who love you will almost always welcome it.',
                'shows' => ['Becoming overly dependent on one person’s approval', 'Avoiding hard conversations that need to happen', 'Absorbing other people’s worries as your own'],
                'work' => ['Keep friendships beyond the family circle', 'Speak up about your preferences, even small ones', 'Choose gentle routines that look after your own wellbeing'],
                'gift' => ['Warmth people feel at once', 'A calming presence in difficult times'],
            ],
        ],

        /* ───────────── 3 ───────────── */
        3 => [
            1 => [
                'headline' => 'The Quiet Voice',
                'story' => 'A First Challenge of 3 often appears as a gap between what you feel and what you say. Perhaps you were laughed at, corrected or simply overlooked when you tried to express yourself, and learned to hold back. Humour, drawing, writing or storytelling may have become a private outlet, shown to few and doubted by you. The turning point comes when you see that your voice has a place even before it is polished. Most confident speakers began with clumsy attempts that someone was kind enough to listen to.',
                'shows' => ['Staying silent in class or at home for fear of ridicule', 'Hiding your creativity or sharing it only in private', 'Using jokes to avoid saying anything serious'],
                'work' => ['Share one creative thing a week with someone kind', 'Say what you think in low-stakes settings first', 'Treat your first attempts as drafts, not verdicts'],
                'gift' => ['A vivid imagination', 'A natural sense of humour and style'],
            ],
            2 => [
                'headline' => 'Saying What You Mean',
                'story' => 'Words and creativity are meant to go out into the world, and the building years ask you to let them, without scattering your energy. Enthusiasm for many things can leave projects half-finished, while a fear of judgement can make you play small or talk around the point. Chatter and gossip are the easy shortcuts; focused, honest expression is the real path. The 3 rewards you when you pick something, stay with it long enough to improve, and share it before it feels ready.',
                'shows' => ['Starting more projects than you finish', 'Talking about plans instead of acting on them', 'Worrying how your work will be received before you share it'],
                'work' => ['Pick one creative outlet and keep at it long enough to improve', 'Say the direct version of what you mean', 'Share work before it feels ready'],
                'gift' => ['Charm and ease with people', 'Ideas that make others smile'],
            ],
            3 => [
                'headline' => 'The Creative Voice',
                'story' => 'The 3 as your Main Challenge keeps asking you to express yourself and to trust that it is worth doing. Moods can swing, and joy can slide into self-doubt whenever the audience goes quiet. Life keeps presenting moments that ask you to use your talents, or to stop dimming them. The task is to create because creating is part of who you are, not because it will be applauded. That shift turns the challenge into the very thing people value most about you: your warmth, wit and originality.',
                'shows' => ['Energy that rises and falls with other people’s reactions', 'Dismissing your own talents as ordinary', 'Putting your talent away when it is not being noticed'],
                'work' => ['Protect regular time for the thing that lights you up', 'Treat feedback as information, not a verdict', 'Build a small circle that celebrates your work'],
                'gift' => ['Joy that lifts a room', 'Originality in how you see and say things'],
            ],
            4 => [
                'headline' => 'Late Bloom',
                'story' => 'Stories, writing, music, humour and conversation come easily in later life with a 3, and the audience may be family, friends or a much wider circle. The risk is retreating because you feel your moment has passed, which is rarely true. Many people with this challenge find their liveliest voice here, freed from worrying what others think. Write the memoir, sing in the choir, tell the long version of the story. A family’s memory often lives in the person who is willing to tell it well.',
                'shows' => ['Assuming nobody wants to hear what you have to say', 'Letting small criticisms silence you', 'Using chatter to avoid quieter feelings'],
                'work' => ['Record your stories for the people who will treasure them', 'Join a group where creativity is welcome', 'Make time for laughter on purpose'],
                'gift' => ['A lively, warm presence', 'Stories and humour that carry a family’s memory'],
            ],
        ],

        /* ───────────── 4 ───────────── */
        4 => [
            1 => [
                'headline' => 'Learning the Rules of the Game',
                'story' => 'Structure arrives early for a child with a 4: strict rules, limited resources, a heavy routine or a sense that there is more work than play. Or the reverse may be true, and discipline felt hard while others seemed to manage it effortlessly. Either way, these years carry the same message. Steady effort and patience build things that shortcuts cannot, and the habits formed now tend to last. It rarely feels fair at the time, but the person who learns to keep going when it is dull is quietly building an advantage.',
                'shows' => ['Feeling restricted by routines or expectations', 'Struggling to stick with tasks that are dull but necessary', 'Seeing others get ahead with less effort'],
                'work' => ['Break big tasks into small daily steps', 'Build one dependable routine and keep it', 'Celebrate finished work, not just ideas'],
                'gift' => ['An early taste of reliability', 'The ability to keep going when others quit'],
            ],
            2 => [
                'headline' => 'Building Brick by Brick',
                'story' => 'Progress comes slowly and mostly through consistent work in the building years, which can test your patience. You may grow frustrated by how long things take, or lean the other way and bury yourself in effort until nothing else fits in your life. Rigidity and stubbornness are the shadow here, along with a belief that there is only one correct way to do things. Good foundations need both patience and a willingness to adjust the plan. Build in rest and milestones, and the work becomes steadier and far more enjoyable.',
                'shows' => ['Impatience when results come slowly', 'Working relentlessly and calling it dedication', 'Resisting change because the old method is familiar'],
                'work' => ['Set milestones so progress becomes visible', 'Schedule rest as firmly as work', 'Ask whether the plan still serves the goal'],
                'gift' => ['Dependability people trust', 'Skills that deepen year after year'],
            ],
            3 => [
                'headline' => 'The Discipline Test',
                'story' => 'A 4 as your Main Challenge is a lifelong lesson in discipline and limits. You may swing between laziness and overwork, or between rigid habits and chaos, and neither extreme feels like home. Life tends to highlight whatever you have been avoiding building, whether that is a skill, a routine or a long-term goal. The reward comes quietly, in the solid things that last because you kept at them. A few well-protected habits, held loosely enough to adapt, will do more for you than any burst of heroic effort.',
                'shows' => ['Alternating between bursts of effort and long stalls', 'Clinging to routines after they stop helping', 'Feeling that everything depends on you and takes too long'],
                'work' => ['Choose a few core habits and protect them', 'Practise flexibility inside your structure', 'Accept help instead of doing it all alone'],
                'gift' => ['Endurance and practical wisdom', 'The satisfaction of building something that lasts'],
            ],
            4 => [
                'headline' => 'Order Without Rigidity',
                'story' => 'Routine brings comfort in later life with a 4, along with a love of things done properly. It can also harden into stubbornness, or leave you cautious about anything new, from technology to a change of scene. A steady structure to your days helps, as long as it leaves room for surprises and for other people’s ways of doing things. Think of your routines as a trellis rather than a cage: something that supports you while leaving space to grow in a new direction.',
                'shows' => ['Resisting new methods or technology out of habit', 'Becoming inflexible about how things are done at home', 'Feeling restless when routines are disrupted'],
                'work' => ['Keep your routines but add one new thing each season', 'Let others do things differently without correcting them', 'Look after your body in ways that suit you'],
                'gift' => ['Reassuring consistency', 'A practical eye for what matters'],
            ],
        ],

        /* ───────────── 5 ───────────── */
        5 => [
            1 => [
                'headline' => 'Wild Horses and Fences',
                'story' => 'Early life with a 5 can feel like pulling against a fence. Rules and routines seem confining, curiosity runs ahead of caution, and you may have been drawn to risk or excitement before you knew how to handle it. Changes of school or home may have added to the restlessness. What helps is knowing that freedom is something you grow into by showing you can use it well. Every time you pause before a big impulse, you prove you can be trusted with more of it.',
                'shows' => ['Chafing at rules and schedules', 'Acting on impulse and regretting it later', 'Getting bored quickly and moving on to the next thing'],
                'work' => ['Channel restlessness into sport, travel or learning something new', 'Pause before big impulses and sleep on them', 'Choose one stable commitment to keep while you explore'],
                'gift' => ['Curiosity and quick learning', 'The courage to try the unfamiliar'],
            ],
            2 => [
                'headline' => 'Freedom and Its Price',
                'story' => 'Commitment is the test in the building years. Variety is exciting, yet jobs, relationships and plans can end up half-lived because the next option beckons. Excess, whether in spending, pleasure or pace, is a common temptation, often a way of escaping routine rather than enjoying anything. The 5 is not asking you to give up your appetite for life. It is asking you to finish things, so that your freedom rests on a record of follow-through instead of a trail of beginnings.',
                'shows' => ['Leaving things just as they begin to deepen', 'Overindulging as a way to escape routine', 'Feeling trapped when responsibilities pile up'],
                'work' => ['Make commitments that leave some room to breathe', 'Set a limit on the habits that tempt you most', 'Finish one thing properly before starting the next'],
                'gift' => ['Adaptability under change', 'A knack for making life feel alive'],
            ],
            3 => [
                'headline' => 'Freedom With Roots',
                'story' => 'The 5 as your Main Challenge keeps asking how to be free and responsible at the same time. It can show up as restlessness, a pull towards excess or a habit of leaving just before things get hard. Over time the cost of that pattern becomes clearer, and so does the alternative: roots deep enough that you can roam without losing yourself. Staying a little longer in one difficult situation can teach you more than a dozen fresh starts, and the thing you wanted to escape is often the thing most worth building.',
                'shows' => ['Running when a situation becomes uncomfortable', 'Chasing stimulation more than satisfaction', 'Taking on a great deal and following through on little'],
                'work' => ['When a situation is difficult but workable, stay a little longer than feels natural before deciding to leave', 'Keep an anchor routine for sleep, food and movement', 'Let travel and change refresh your life instead of replacing it'],
                'gift' => ['Resourcefulness in any setting', 'The ability to reinvent yourself'],
            ],
            4 => [
                'headline' => 'Staying Curious, Staying Grounded',
                'story' => 'Later life with a 5 can be lively and adventurous, and it can also be restless. The old pull towards change may lead to impulsive moves, or to missing the people who would happily share a quieter chapter. Curiosity remains a gift, as long as it comes with enough stability to enjoy it. Keep a home base you love, plan a few journeys that mean something, and stay close to people who know the whole of you. Freedom feels richer when there is someone to tell the stories to.',
                'shows' => ['Restlessness that unsettles close relationships', 'Living at the pace of earlier years without adjusting', 'Chasing novelty to avoid reflection'],
                'work' => ['Plan a few meaningful trips or projects rather than constant motion', 'Keep a home base you love', 'Stay close to people who know you well'],
                'gift' => ['A youthful spirit', 'Enthusiasm that draws people in'],
            ],
        ],

        /* ───────────── 6 ───────────── */
        6 => [
            1 => [
                'headline' => 'The Little Caretaker',
                'story' => 'Responsibility tends to arrive early with a 6, and it can make childhood feel shorter than it should. You may have been the responsible one, the peacemaker or the family’s fixer, sensitive to everyone’s needs and held to high standards by yourself and by others. Duty and love can blur together, and perfectionism may start young, along with a sense that rest has to be earned. Growth here means learning that you can care deeply without being responsible for every outcome. Allowing other people to carry their own load is not neglect; it is respect.',
                'shows' => ['Taking on adult worries as a child or teenager', 'Feeling guilty when you rest or put yourself first', 'Judging yourself harshly for small mistakes'],
                'work' => ['Let others handle what is theirs, even if they do it imperfectly', 'Give yourself permission to play', 'Notice when you are acting from duty instead of choice'],
                'gift' => ['Early maturity and reliability', 'A big, loyal heart'],
            ],
            2 => [
                'headline' => 'Love With Limits',
                'story' => 'Partnership, family and home often take centre stage in the building years. You want to give a great deal and may quietly expect a great deal in return: tidy standards, shared values, gratitude. Control can creep in disguised as care, and disappointment as criticism. Growth here means loving people as they are rather than as you would arrange them, and to keep a little room for yourself. A relationship in which you are allowed to be imperfect, and so are they, is far more likely to last.',
                'shows' => ['Trying to fix problems nobody asked you to fix', 'Feeling unappreciated after giving generously', 'Holding partners, children or colleagues to impossible standards'],
                'work' => ['Ask what someone needs before offering help', 'Lower the bar on small things to protect the big ones', 'Keep one pursuit that is only for you'],
                'gift' => ['A gift for making a home or team feel safe', 'Devotion that builds lasting trust'],
            ],
            3 => [
                'headline' => 'The Heart of the Matter',
                'story' => 'Responsibility, giving and perfectionism make up the lifelong study of a 6 as your Main Challenge. You notice what needs doing and then do it, often at your own expense, and you can see every flaw in a room within seconds. At some point comes the realisation that being needed and being loved are not the same thing. The work is to give freely without keeping score, to accept help, and to let good enough count as a real standard. Harmony and beauty then become gifts you offer, not debts you pay.',
                'shows' => ['Giving until you are exhausted before asking for anything', 'Seeing flaws first, in yourself and in others', 'Struggling to accept help or admit you are tired'],
                'work' => ['Practise receiving with grace', 'Share responsibility openly instead of carrying it silently', 'Treat good enough as a real standard'],
                'gift' => ['Exceptional loyalty', 'The ability to create harmony and beauty around you'],
            ],
            4 => [
                'headline' => 'Caring Without Carrying',
                'story' => 'Family, friends and community can fill later life with a 6, and worry can follow if you let it. It is hard to watch people you love make choices you would not, particularly when you have spent decades looking after them. Love at this stage means being available without managing, and trusting that you have already given a great deal. Offer your advice once, clearly, and then let go. Spend time on pleasures that ask nothing of you; you have earned them.',
                'shows' => ['Worrying constantly about the people you have cared for', 'Offering advice that no one requested', 'Feeling that your worth depends on being useful'],
                'work' => ['Offer help once, clearly, then step back', 'Let people care for you in return', 'Spend time on things that are simply pleasurable'],
                'gift' => ['Warmth that anchors a family', 'Wisdom about what truly matters'],
            ],
        ],

        /* ───────────── 7 ───────────── */
        7 => [
            1 => [
                'headline' => 'The Outsider Within',
                'story' => 'Feeling slightly apart is the early signature of a 7. You may have been the thoughtful, private one who preferred your own company, questioned things early, or felt that others did not quite see you. Trust can be slow to develop, and confiding in people may have felt risky. What these years teach is that depth does not have to mean distance, and that people can be let in a little at a time. One or two good friends, chosen carefully, can make all the difference to how understood you feel.',
                'shows' => ['Feeling misunderstood or different from your peers', 'Keeping your thoughts to yourself even when you want to share them', 'Doubting that people mean what they say'],
                'work' => ['Choose one or two people to open up to gradually', 'Spend time in nature or quiet spaces that restore you', 'Follow a subject deeply, since that is where you thrive'],
                'gift' => ['A thoughtful, searching mind', 'Comfort with your own company'],
            ],
            2 => [
                'headline' => 'Learning to Trust',
                'story' => 'In the building years, the 7 asks whether you can trust other people, and yourself, enough to move forward. Doubt, analysis and a wish for certainty can hold you back: you may weigh every option and still not commit, or keep your feelings out of reach even in close relationships. Trust is not built from proof but from small acts, repeated. Try sharing something real with someone reliable and see what happens. The mind that questions everything also notices what others miss, which is worth keeping once it works alongside your instincts.',
                'shows' => ['Overthinking decisions that need to be felt as well as reasoned', 'Staying guarded in relationships', 'Withdrawing when things feel uncertain'],
                'work' => ['Take small leaps and see that you land safely', 'Tell someone you trust what is actually on your mind', 'Combine analysis with intuition'],
                'gift' => ['Insight that goes beneath the surface', 'Independence of mind'],
            ],
            3 => [
                'headline' => 'Faith in the Unseen',
                'story' => 'Trust sits at the heart of a 7 as your Main Challenge: trust in life, in other people and in your own inner knowing. You think deeply and need meaning, which can tip into scepticism, isolation or endless analysis. Questions that logic alone cannot settle keep arriving, such as what your life is for and what you believe. The work is to stay open without needing every answer first. Reflection, whether through meditation, journalling or long walks, helps, as does telling one wise person what you are really wondering.',
                'shows' => ['Withdrawing precisely when connection would help', 'Doubting good things while waiting for the catch', 'Searching for answers that keep moving out of reach'],
                'work' => ['Build a regular practice of reflection, such as meditation, journalling or walking', 'Share a doubt with someone wise instead of solving it alone', 'Let some questions stay open'],
                'gift' => ['Depth and wisdom', 'A spiritual or philosophical outlook that sustains you'],
            ],
            4 => [
                'headline' => 'Opening the Door',
                'story' => 'Contemplation comes easily to a 7 in later life, and so does isolation. You may enjoy solitude so much that connection thins out, or keep your insights to yourself because nobody asks. The invitation of these years is to open the door: share what you have learned, and let people closer than you usually do. A few warm, regular connections will not cost you your peace; they are more likely to deepen it. The wisdom you have gathered is worth passing on, and someone may be glad to hear it.',
                'shows' => ['Spending long stretches alone without noticing', 'Withholding your views because you assume they will not land', 'Letting scepticism become a reflex'],
                'work' => ['Keep a few regular, warm connections in your calendar', 'Write or talk about what you have worked out', 'Notice moments of ordinary wonder'],
                'gift' => ['A calm, discerning presence', 'Wisdom that others will seek out'],
            ],
        ],

        /* ───────────── 8 ───────────── */
        8 => [
            1 => [
                'headline' => 'Early Lessons in Worth',
                'story' => 'An 8 in the first position often brings an early encounter with money, power or authority. Perhaps resources were tight, or a driven parent set demanding standards, or you simply felt keenly who held the control in your family. It is common to link your worth to achievement from a very young age. The turning point comes when you see that value is not the same as status or income, and that you do not have to earn your place with results. People who care for you do so whatever your achievements.',
                'shows' => ['Measuring yourself by results or possessions', 'Feeling powerless, or wanting control at any cost', 'Becoming serious about money earlier than your friends'],
                'work' => ['Learn practical money skills without making them your identity', 'Notice when you are chasing approval', 'Keep people close who appreciate you beyond your achievements'],
                'gift' => ['Early awareness of effort and reward', 'A drive to achieve'],
            ],
            2 => [
                'headline' => 'Power and Its Price',
                'story' => 'Career, money and influence move to centre stage in the building years, and you may rise quickly. You may also be tested on how you use that power. Overwork, a hunger for status or an anxious grip on money are the usual traps, along with dealings that treat people as tools. The 8 rewards integrity over time: success built fairly tends to last, and success built otherwise tends to be expensive to maintain. Decide early what enough looks like, and keep room in your life for people as well as plans.',
                'shows' => ['Working so much that relationships suffer', 'Equating money with security, or with worth', 'Struggling to ask for fair pay or to share authority'],
                'work' => ['Define what enough looks like and revisit it each year', 'Make ethical decisions early, before pressure builds', 'Spend time and money on people, not only on goals'],
                'gift' => ['Strategic thinking and endurance', 'The ability to turn effort into real results'],
            ],
            3 => [
                'headline' => 'Mastering Power and Money',
                'story' => 'Power, money and self-worth are the lifelong curriculum of an 8 as your Main Challenge. You may overreach or hold back, and both are ways of avoiding a balanced relationship with them. Authority and finance may test you again and again, and how you respond shapes what comes next. Mastery here is not about getting more but about using what you have wisely and generously. When you stop needing power to feel safe, you can wield it with a lighter touch, and that is when people begin to trust it.',
                'shows' => ['Swinging between over-controlling and giving away your power', 'Letting financial worries or ambitions run your mood', 'Needing to be in charge to feel safe'],
                'work' => ['Treat money as a tool with a purpose, not a scoreboard', 'Delegate and trust others with real responsibility', 'Use your influence to lift others'],
                'gift' => ['Leadership that others trust', 'A grounded understanding of value'],
            ],
            4 => [
                'headline' => 'What Money Cannot Buy',
                'story' => 'Questions of legacy, control and security surface in later life with an 8. You may want to keep running things long after you need to, or worry about finances well beyond what is warranted. The challenge is to hold your position lightly: to use your experience and resources generously and to find a sense of worth that no title can supply. Some people with this number find that the most satisfying use of their authority is handing it on well. What you have built can outlast your role in it.',
                'shows' => ['Keeping hold of decisions that others could share', 'Worrying about money more than your situation calls for', 'Feeling diminished when a role or title ends'],
                'work' => ['Plan succession and legacy with care', 'Give time and knowledge, not only money', 'Find a purpose that does not depend on status'],
                'gift' => ['Practical authority that comes from experience', 'The chance to turn success into service'],
            ],
        ],
    ],
];