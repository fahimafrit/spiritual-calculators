<?php
declare(strict_types=1);

/* Data for the Wedding Date Numerology calculator.
   Server-side only: never included from a browser request. */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* fit: how well a date number suits a person's Life Path Number, 0-100.
   Keyed by the two single-digit root numbers, lowest first ("3-5").
   Master numbers (11, 22, 33) use their root digit (2, 4, 6).

   readings:  date number (1-9, 11, 22, 33) => headline, story, strengths, watch, guidance
   fits:      pair key ("3-5") => ['text' => ...]       (one note per partner)
   marriage:  Marriage Number (1-9, 11, 22, 33) => same shape as readings
   */

return [
    'fit' => [
        '1-1' => 65, '1-2' => 60, '1-3' => 85, '1-4' => 60, '1-5' => 90, '1-6' => 60, '1-7' => 80, '1-8' => 65, '1-9' => 70,
        '2-2' => 70, '2-3' => 65, '2-4' => 80, '2-5' => 55, '2-6' => 90, '2-7' => 55, '2-8' => 85, '2-9' => 80,
        '3-3' => 70, '3-4' => 50, '3-5' => 90, '3-6' => 80, '3-7' => 65, '3-8' => 50, '3-9' => 90,
        '4-4' => 70, '4-5' => 55, '4-6' => 85, '4-7' => 60, '4-8' => 90, '4-9' => 65,
        '5-5' => 70, '5-6' => 55, '5-7' => 85, '5-8' => 55, '5-9' => 75,
        '6-6' => 75, '6-7' => 60, '6-8' => 75, '6-9' => 90,
        '7-7' => 65, '7-8' => 60, '7-9' => 80,
        '8-8' => 70, '8-9' => 60,
        '9-9' => 70,
    ],
    'readings' => [
        1 => [
            'headline' => 'A New Chapter, Boldly Begun',
            'story' => 'A wedding date that reduces to 1 carries the energy of beginnings. It suits couples who see marriage as a fresh start, a shared venture they are launching on their own terms. Independence and initiative run strongly here, so this date favours decisiveness, courage and a clear sense of direction. It also asks the two of you to remember that leading together is different from leading alone. When each person’s ambitions are welcomed, the marriage gains momentum; when they compete, it can feel more like a contest than a partnership. Choose a direction you both believe in, and the 1 will help you act on it.',
            'strengths' => ['Strong momentum and a clear sense of purpose', 'The courage to build a life on your own terms', 'Room for each partner to stay independent'],
            'watch' => ['Competing to lead instead of leading together', 'Pushing ahead before the other is ready'],
            'guidance' => ['Decide early how you will share decisions', 'Celebrate each other’s goals as shared wins', 'Keep a few rituals that belong only to the two of you'],
        ],
        2 => [
            'headline' => 'The Number of Partnership',
            'story' => 'The 2 is the number of partnership itself, which is why it is so often linked with weddings. A date that reduces to 2 favours cooperation, tenderness and the quiet skills that hold a marriage together: listening, patience and compromise. Intuition between you tends to run high, and small gestures carry real weight. The 2’s gentleness has a shadow, though. Sensitivity can tip into hurt feelings, and the wish for harmony into avoiding hard conversations. This date rewards couples who treat honesty as a form of tenderness. Say the small things before they grow, and the partnership the 2 promises has every chance to flourish.',
            'strengths' => ['Deep cooperation and emotional attunement', 'A natural lean towards compromise and kindness', 'Patience that helps you weather disagreements'],
            'watch' => ['Swallowing concerns to keep the peace', 'Taking small slights more personally than they were meant'],
            'guidance' => ['Talk through small worries before they build', 'Make decisions together and share the effort fairly', 'Protect time for gentle, unhurried connection'],
        ],
        3 => [
            'headline' => 'A Wedding Full of Joy',
            'story' => 'A 3 date is the number of celebration, so this is a wedding day with a sense of festivity. Laughter, music, friends and creativity come easily, and the marriage that follows can be lively, affectionate and full of conversation. The 3 loves to share, which suits couples who want a wide circle around them. Its challenge is focus: enthusiasm can scatter, and lightness can steer around the harder discussions about money, plans and responsibilities. Let the joy set the tone, and agree to meet the practical matters together. A marriage that can laugh and plan in the same week is a resilient one.',
            'strengths' => ['A warm, social, celebratory atmosphere', 'Creativity and humour that keep things fresh', 'Open, expressive communication'],
            'watch' => ['Avoiding serious conversations by keeping things light', 'Spreading energy and money across too many things'],
            'guidance' => ['Schedule regular time for practical planning', 'Keep the humour, but make space for real feelings', 'Create something together, even something small'],
        ],
        4 => [
            'headline' => 'Built on Solid Ground',
            'story' => 'The 4 is the number of foundations, and a wedding date that reduces to it is often considered one of the most reassuring. It points to loyalty, patience and a marriage built stone by stone: a home, a routine, shared responsibilities and a reputation for reliability. Couples under a 4 tend to value commitment over spectacle, and what they build tends to last. The risk is that dependability hardens into routine, with romance moved down the list behind work and chores. Build the practical foundation, certainly, and then schedule the unplanned moments that remind you why you chose each other.',
            'strengths' => ['Stability, loyalty and long-term commitment', 'A shared talent for planning and follow-through', 'Trust that deepens with the years'],
            'watch' => ['Letting routine crowd out romance', 'Stubbornness when plans need to change'],
            'guidance' => ['Plan something spontaneous on a regular basis', 'Divide responsibilities clearly and revisit them each year', 'Say the affectionate things out loud, not only the practical ones'],
        ],
        5 => [
            'headline' => 'An Adventure Begins',
            'story' => 'A 5 date brings movement, variety and a taste for adventure. It suits couples who see marriage as a shared exploration: travel, new places, a life that does not follow a script. Communication is lively and curiosity runs high. The same energy that makes a 5 exciting can make it restless, however, and traditional numerology often notes that this date asks for extra attention to stability. The remedy is not to dampen the adventure but to anchor it: a home base you love, commitments you keep, and a shared rhythm that gives your freedom something to return to.',
            'strengths' => ['Shared curiosity and a love of new experience', 'Flexibility when life changes course', 'Lively conversation and a sense of fun'],
            'watch' => ['Restlessness, or a wandering eye for novelty', 'Impulsive decisions about money or moving house'],
            'guidance' => ['Build a stable base before chasing the next adventure', 'Plan journeys together, and keep the promises you make', 'Talk openly when either of you starts to feel hemmed in'],
        ],
        6 => [
            'headline' => 'Home, Heart and Harmony',
            'story' => 'The 6 is the number most closely tied to love, home and family, and it is often named the classic wedding number. A date that reduces to 6 favours devotion, care and a marriage centred on warmth: a welcoming home, close family ties, a shared sense of duty to the people you love. Beauty and comfort matter here. The 6’s shadow is over-responsibility: taking on too much, aiming for a perfect household, or trying to fix everything for everyone. A 6 marriage thrives when the two of you care for each other first and allow the household to be gloriously imperfect.',
            'strengths' => ['Devotion and a deep sense of care', 'A warm home and strong family bonds', 'Fairness and generosity between partners'],
            'watch' => ['Perfectionism about home, family or each other', 'Carrying everyone else’s burdens at your own expense'],
            'guidance' => ['Share household and family responsibilities evenly', 'Let some things be good enough', 'Make time for the two of you before family and friends'],
        ],
        7 => [
            'headline' => 'A Deeper, Quieter Bond',
            'story' => 'A date that reduces to 7 points to a marriage that is more thoughtful than showy. It favours depth: shared values, a spiritual or philosophical connection, and an understanding that does not need many words. Couples with this energy often value privacy and may prefer an intimate celebration. The 7’s challenge is distance. Introspection can turn into withdrawal, and quiet can be mistaken for coolness. Make a habit of sharing what is going on inside, and keep some regular, unhurried time together. When connection is put into words, the 7 offers a rare kind of intimacy.',
            'strengths' => ['Deep understanding and shared values', 'Respect for each other’s inner life', 'A calm, thoughtful approach to problems'],
            'watch' => ['Withdrawing instead of talking things through', 'Over-analysing feelings that simply need to be felt'],
            'guidance' => ['Share your thoughts regularly, even when they are unfinished', 'Keep a ritual of quiet time together', 'Balance private time with time spent among others'],
        ],
        8 => [
            'headline' => 'Building a Life of Substance',
            'story' => 'The 8 is the number of achievement, and a wedding date that reduces to it often signals a marriage with ambition: careers that flourish, financial security, a life built with purpose. Practical strength and a talent for managing resources are likely to serve the two of you well. The 8 also raises questions of power and priorities. Work can take centre stage, money can become the main topic of conversation, and two strong wills may need a way to share authority. Treat the marriage as the most important project you have, and give it the same time and attention you give to your goals.',
            'strengths' => ['Shared drive and a talent for building security', 'Practical strength and sound judgement with resources', 'Ambition that supports each other’s achievements'],
            'watch' => ['Work and status taking priority over closeness', 'Power struggles over money or decisions'],
            'guidance' => ['Agree how you will manage money together', 'Put time for the relationship in the diary', 'Treat success as something to share, not to score'],
        ],
        9 => [
            'headline' => 'Love With a Big Heart',
            'story' => 'The 9 is the number of completion and compassion, and a date that reduces to it has a generous, humanitarian colour. It suits couples who want their marriage to mean something beyond themselves: serving a community, welcoming others, giving back. The 9 often marks the closing of an earlier chapter, so old attachments and unfinished business may surface and ask to be settled. That is a gift if you meet it honestly. Let go of what belongs to the past, and keep the generosity. A marriage that is loving towards the world still needs to be loving towards itself.',
            'strengths' => ['Compassion and generosity of spirit', 'Shared ideals and a sense of purpose', 'The capacity to forgive and move forward'],
            'watch' => ['Carrying unresolved past issues into the new marriage', 'Giving so much to others that the two of you come second'],
            'guidance' => ['Close old chapters properly before the wedding if you can', 'Choose a cause or community to support together', 'Make sure your generosity includes each other'],
        ],
        11 => [
            'headline' => 'A Union Guided by Intuition',
            'story' => 'A date that reduces to 11 is a master number date, with the sensitivity of a 2 and an added charge of intuition and inspiration. It suggests a marriage with a strong sense of destiny: you may feel an almost uncanny understanding, shared dreams, or a sense that your meeting was meant to be. That intensity is both a gift and a demand. Nerves can run high, idealism can set the bar very high, and everyday life can feel ordinary by comparison. Lean on the 2 beneath the 11, with its patience, cooperation and tenderness, to turn the inspiration into a steady, practical partnership.',
            'strengths' => ['A strong intuitive bond and shared vision', 'Inspiration that lifts both of you', 'Sensitivity to each other’s unspoken needs'],
            'watch' => ['Expecting the relationship to be flawless', 'Nervous tension and emotional intensity'],
            'guidance' => ['Ground big dreams in small, doable steps', 'Build calming routines you share', 'Remember that ordinary days are part of the story'],
        ],
        22 => [
            'headline' => 'The Master Builder’s Wedding',
            'story' => 'A 22 date is the master builder, the number of large visions made real. Beneath it sits the 4 of foundations, so this is a wedding date that favours couples who intend to build something substantial together: a home, a business, a family, a legacy. Practical wisdom and long-term thinking are strengths. So is the pressure that comes with them. Expectations of yourselves can be high, and the sheer scale of your plans may feel heavy. Build step by step, share the load, and let the 4’s patience carry the 22’s ambition.',
            'strengths' => ['The ability to turn big shared dreams into reality', 'Practical wisdom and long-term vision', 'Loyalty and commitment to something that lasts'],
            'watch' => ['Taking on more than two people can carry', 'Putting the project above the partnership'],
            'guidance' => ['Break large plans into stages you both agree to', 'Keep the relationship itself on the list of things you are building', 'Celebrate small milestones along the way'],
        ],
        33 => [
            'headline' => 'Devotion at Its Highest',
            'story' => 'The 33 is the rarest of the master numbers, and it carries a theme of selfless love. A date that reduces to 33 holds the warmth of the 6 beneath it, so care, family and service sit at the centre of this marriage. You may feel called to nurture each other and others, with a depth of compassion that is uncommon. The risk is self-sacrifice: giving until you are empty, or expecting the relationship to heal everything. Let the care flow both ways, and keep your own wellbeing on the list. A love that includes you both is the one that lasts.',
            'strengths' => ['Exceptional compassion and warmth', 'A shared wish to nurture family and community', 'A gentle, uplifting influence on those around you'],
            'watch' => ['Giving so much that you neglect your own needs', 'Carrying emotional responsibility for each other'],
            'guidance' => ['Let care flow in both directions', 'Share responsibilities rather than shouldering them alone', 'Rest and restore together without guilt'],
        ],
    ],
    'fits' => [
        '1-1' => ['text' => 'Two 1s share the same drive to lead and to start things, which can feel exhilarating or competitive. Decide early who takes the lead on what, and enjoy being two people who each bring their own spark.'],
        '1-2' => ['text' => 'The 1 brings initiative and the 2 brings tact, a pairing that works well when the 1 listens and the 2 speaks up. Together they balance forward motion with care. Make a habit of asking each other’s view before decisions are made.'],
        '1-3' => ['text' => 'Spark and sparkle. The 1 supplies drive, the 3 supplies joy and imagination, and each tends to cheer the other on. Energy is high, so plan for the quieter moments and the practical details as well.'],
        '1-4' => ['text' => 'The 1 wants to move and the 4 wants to build. Their strengths complement each other when the 1’s ideas meet the 4’s steady follow-through, though impatience on one side and caution on the other can cause friction. Agree a pace that suits you both.'],
        '1-5' => ['text' => 'Two restless, forward-looking energies that give each other room. The 1 starts things and the 5 keeps life varied, so neither feels held back. Take care that excitement does not crowd out the everyday commitments that keep a marriage steady.'],
        '1-6' => ['text' => 'The 1 values independence and the 6 values closeness, so the tension lies between going and nesting. It softens when the 6’s warmth is welcomed and the 1’s need for freedom is respected. Talk early about how much togetherness feels right.'],
        '1-7' => ['text' => 'A quiet strength: the 1 acts and the 7 reflects, and each respects the other’s way of thinking. Both value some independence, which can make this a calm, respectful pairing. Make sure privacy never turns into distance.'],
        '1-8' => ['text' => 'Two ambitious energies. Together they can build a great deal, but both like to be in charge, so power struggles are the risk. Agree who leads in which areas, and celebrate each other’s achievements instead of competing.'],
        '1-9' => ['text' => 'The 1 starts and the 9 completes, a natural rhythm when each plays their part. The 9’s wider compassion can soften the 1’s drive. Watch for the 1 feeling unheard while the 9 is occupied with other people’s needs.'],
        '2-2' => ['text' => 'Two 2s make a gentle, devoted pairing built on cooperation and tenderness. The risk is that both defer too much or avoid conflict, so decisions drift. Practise saying what you want plainly; kindness grows stronger with honesty.'],
        '2-3' => ['text' => 'The 2 is tender and sensitive and the 3 is expressive and playful. They can delight each other, provided the 3’s lightness never brushes past the 2’s feelings. Share the fun, and share the quiet conversations too.'],
        '2-4' => ['text' => 'Steady and sweet. The 2 offers warmth and cooperation and the 4 offers reliability and structure, a combination that tends to feel safe. Remember to keep romance alive amid the routine.'],
        '2-5' => ['text' => 'The 2 seeks closeness and security while the 5 seeks variety and freedom. The difference is real but workable: the 2 can find reassurance in honest talk, and the 5 can plan regular time together. Agree what freedom and closeness each look like for you.'],
        '2-6' => ['text' => 'One of the most harmonious pairings. The 2 and the 6 both value love, family and care, so home is likely to be warm and welcoming. Take care that you do not both put everyone else first, and leave time for each other.'],
        '2-7' => ['text' => 'The 2 wants closeness and the 7 wants room to think, so the gap lies in how each of you recharges. When the 7 shares even a little of their inner life and the 2 allows quiet, the pairing becomes deeply tender.'],
        '2-8' => ['text' => 'The 2 offers support and diplomacy and the 8 offers drive and security, a classic complement. It works best when the 8’s ambition is balanced by attention at home and the 2’s needs are voiced instead of assumed.'],
        '2-9' => ['text' => 'Two big-hearted numbers. The 2 gives devotion and the 9 gives compassion, so together they tend to be generous and understanding. Be careful that giving to others does not leave too little for each other.'],
        '3-3' => ['text' => 'Two 3s bring laughter, creativity and plenty of company, and the wedding itself is likely to be a joyful, social affair. Watch for scattered energy and serious talk that never quite happens, and set aside time for practical matters.'],
        '3-4' => ['text' => 'Playful meets practical. The 3 is spontaneous and the 4 prefers order, which can lead to friction over money, plans and mood. It becomes a strength when the 3 brings lightness to the 4’s structure and the 4 gives the 3’s ideas a base. Compromise on routines early.'],
        '3-5' => ['text' => 'A lively, adventurous pairing. Both love fun, conversation and new experiences, so life is rarely dull. Anchor it with a few shared commitments, such as a budget or a home you both love, so that freedom does not become drift.'],
        '3-6' => ['text' => 'The 3’s joy and the 6’s warmth make an affectionate, sociable pairing with a lovely home life. The 6’s sense of duty and the 3’s lightness balance each other, as long as neither judges the other’s way of coping.'],
        '3-7' => ['text' => 'The 3 is outgoing and the 7 is reflective, so the two sit at opposite ends of the social scale. They can learn a great deal from each other: the 3 draws the 7 out and the 7 gives the 3 depth. Respect each other’s need for company or quiet.'],
        '3-8' => ['text' => 'The 3 wants joy and self-expression and the 8 wants results and security, so priorities can differ over time, money and fun. It works when the 8 allows play and the 3 respects the 8’s goals. Agree a shared budget early.'],
        '3-9' => ['text' => 'Creative, generous and warm. The 3 and the 9 share a love of people and imagination, and they tend to inspire each other. Remember to finish what you start together, including the less glamorous plans.'],
        '4-4' => ['text' => 'Two 4s build a sturdy, dependable marriage: practical, loyal and organised. The risk is rigidity and routine, with romance pushed down the list. Schedule surprises, and let some plans stay loose.'],
        '4-5' => ['text' => 'The 4 values stability and the 5 values freedom, so they pull in different directions. Each has something the other lacks: the 4 gives grounding and the 5 gives fresh air. Agree a few fixed commitments and a few shared adventures.'],
        '4-6' => ['text' => 'A grounded, loving combination. The 4 provides structure and the 6 provides care, and together they tend to create a secure home. Make space for fun, because both of you lean towards the serious.'],
        '4-7' => ['text' => 'Both are thoughtful and private, which can make this a calm, respectful pairing. The 4 is practical and the 7 is reflective, so the risk is too much quiet. Make time for open, regular conversation.'],
        '4-8' => ['text' => 'A powerhouse for building. The 4 brings discipline and the 8 brings ambition, so goals such as a home, a business or financial security can come together. Guard against work crowding out affection.'],
        '4-9' => ['text' => 'The 4 is practical and close to home while the 9 is idealistic and wide-ranging, so they see the world from different distances. The 4 can ground the 9’s dreams and the 9 can broaden the 4’s horizon. Respect each other’s priorities.'],
        '5-5' => ['text' => 'Two 5s share a love of freedom, travel and change, so life together is likely to be eventful. Because neither naturally anchors, decide together what you are committed to: a home base, shared goals and a few routines.'],
        '5-6' => ['text' => 'The 5 craves freedom and the 6 craves home, so the tension is between roaming and nesting. Both can be true: the 6 offers a base and the 5 keeps life fresh. Talk early about time away and time together.'],
        '5-7' => ['text' => 'Two independent minds. The 5 is curious and the 7 is searching, and each gives the other space to explore. It is an unconventional, interesting pairing; set shared rituals so that you stay connected.'],
        '5-8' => ['text' => 'The 5 wants freedom and the 8 wants structure and control, a combination that can clash over money, time and decisions. It works when the 8 allows flexibility and the 5 respects commitments. Be open about financial habits from the start.'],
        '5-9' => ['text' => 'Both are open-minded and enjoy experience, so this pairing tends to be broad-minded and adventurous. The 5’s restlessness and the 9’s idealism both look outward, so plan time for each other.'],
        '6-6' => ['text' => 'Two 6s create a loving, family-centred home. Care comes naturally, and so can perfectionism and over-responsibility. Allow each other to be imperfect, and rest together without guilt.'],
        '6-7' => ['text' => 'The 6 is devoted and domestic and the 7 is private and inward. The 6 may crave more closeness than the 7 can easily give, and the 7 may feel crowded. Honest talk about needs, and a little space for each, helps.'],
        '6-8' => ['text' => 'The 6 provides care and the 8 provides drive, so together they can build a secure, comfortable home. The challenge is control: the 8 should not run the family like a business, and the 6 should voice needs.'],
        '6-9' => ['text' => 'A deeply caring pairing. The 6 and the 9 both give generously, and they tend to share values about family and community. Watch for martyrdom, and make sure you are as kind to each other as you are to everyone else.'],
        '7-7' => ['text' => 'Two 7s share a love of depth, thought and quiet. Understanding comes easily, though emotional expression may not. Make a habit of saying out loud what you feel, and keep a few regular rituals together.'],
        '7-8' => ['text' => 'The 7 is reflective and the 8 is driven, so one looks inward while the other looks outward. They complement each other when the 8’s practicality meets the 7’s wisdom. Keep communication open, and respect different paces.'],
        '7-9' => ['text' => 'A thoughtful, compassionate pairing. The 7 and the 9 share a sense of meaning and often a spiritual outlook, and they tolerate each other’s differences well. Take care that idealism is anchored in everyday life.'],
        '8-8' => ['text' => 'Two 8s are driven, capable and ambitious, which can build a lot together. Competition and control are the risks, as is making work the centre of life. Share power, and keep time for tenderness.'],
        '8-9' => ['text' => 'The 8 focuses on results and the 9 on people and ideals, so values can differ over money and giving. They balance each other when the 8 respects the 9’s generosity and the 9 respects the 8’s practicality.'],
        '9-9' => ['text' => 'Two 9s are generous, idealistic and compassionate, with shared values about helping others. The risk is giving so much outward that the two of you come second, or carrying old hurts into the new chapter. Put each other first, too.'],
    ],
    'marriage' => [
        1 => [
            'headline' => 'Two People, One Bold Beginning',
            'story' => 'A Marriage Number of 1 describes a couple whose shared energy is independent and forward-looking. You tend to build something of your own, whether that is a business, a home or a way of living, and you each keep a strong sense of self. The marriage does best when initiative is shared rather than contested.',
            'guidance' => ['Take turns leading, depending on who knows the ground', 'Keep your own goals, and cheer on each other’s', 'Make joint decisions deliberately, not by default'],
        ],
        2 => [
            'headline' => 'A Partnership at Heart',
            'story' => 'With a Marriage Number of 2, the pairing itself is the theme. Cooperation, tenderness and diplomacy colour your life together, and you are likely to be attentive to each other’s moods. The shadow side is avoiding conflict, or leaning too heavily on each other’s approval.',
            'guidance' => ['Say what you need plainly and early', 'Share decisions and the work equally', 'Keep friendships and interests of your own'],
        ],
        3 => [
            'headline' => 'A Marriage Full of Life',
            'story' => 'A Marriage Number of 3 gives your life together a social, creative and expressive tone. Conversation, humour and shared enjoyment tend to be central, and other people may find you a delightful couple. The shadow side is scatter and surface: lightness that avoids serious talk, or energy spread too thin.',
            'guidance' => ['Make time for practical conversations as well as fun ones', 'Create something together, such as a garden, a project or a tradition', 'Share your good news, and your worries, with each other first'],
        ],
        4 => [
            'headline' => 'A Foundation for Life',
            'story' => 'A Marriage Number of 4 points to stability, loyalty and shared effort. You are likely to build slowly and well: a home, a routine, financial security. The shadow side is rigidity, with routine taking over from tenderness.',
            'guidance' => ['Plan regular, deliberate time for romance', 'Review your plans each year and adjust together', 'Appreciate the everyday work each of you does'],
        ],
        5 => [
            'headline' => 'A Marriage in Motion',
            'story' => 'A Marriage Number of 5 brings variety, curiosity and change. Travel, new experiences and a life that avoids stagnation suit you, and you are likely to keep each other interested. The shadow side is restlessness, a pull towards the next thing before this one has settled.',
            'guidance' => ['Choose a stable base and a few firm commitments', 'Plan adventures together', 'Talk openly whenever either of you feels hemmed in'],
        ],
        6 => [
            'headline' => 'A Home Full of Love',
            'story' => 'A Marriage Number of 6 is the classic number of love, home and family. Care for each other and for the people around you sits at the heart of your life, and a warm, welcoming home is likely to matter. The shadow side is over-responsibility and perfectionism.',
            'guidance' => ['Care for each other before caring for everyone else', 'Share family and household duties evenly', 'Let some things be good enough'],
        ],
        7 => [
            'headline' => 'A Bond That Runs Deep',
            'story' => 'A Marriage Number of 7 describes a couple with a thoughtful, private and spiritually curious bond. Understanding may come without many words, and shared values matter more than shared activities. The shadow side is distance, quiet that slides into silence.',
            'guidance' => ['Share what is on your mind, even when it is unfinished', 'Keep a ritual of quiet time together', 'Make room for friends and family, too'],
        ],
        8 => [
            'headline' => 'A Couple Built to Achieve',
            'story' => 'A Marriage Number of 8 points to ambition, resourcefulness and a talent for creating security. You may achieve a good deal together, in business, in finances or in your standing in the community. The shadow side is power and priorities: work coming first, or two strong wills competing.',
            'guidance' => ['Agree how you manage money as a team', 'Put the relationship in the calendar next to work', 'Share authority, and share credit'],
        ],
        9 => [
            'headline' => 'Love That Reaches Outward',
            'story' => 'A Marriage Number of 9 gives your marriage a generous, compassionate tone. You are likely to share ideals and to want your life together to do some good in the world. The shadow side is giving so much outward that the two of you come second.',
            'guidance' => ['Choose a cause or community to give to together', 'Put each other first, sometimes', 'Let go of old hurts so they do not travel with you'],
        ],
        11 => [
            'headline' => 'An Intuitive Bond',
            'story' => 'A Marriage Number of 11 is a master number for a couple with a sense of shared destiny: heightened intuition, inspiration and sensitivity, with the 2 beneath it keeping partnership central. Life together can feel uncommonly close and uncommonly intense.',
            'guidance' => ['Ground your shared dreams in small, practical steps', 'Build calming routines for the two of you', 'Allow ordinary days to be enough'],
        ],
        22 => [
            'headline' => 'Dreams Built to Last',
            'story' => 'A Marriage Number of 22 is the master builder, the number of large visions made practical, with the 4 beneath it for stability. You may feel called to build something significant together, whether a family, an enterprise or a legacy. The pressure of that ambition is the thing to manage.',
            'guidance' => ['Break big plans into stages you both agree on', 'Keep the relationship on your list of things to build', 'Celebrate milestones, however small'],
        ],
        33 => [
            'headline' => 'A Marriage of Devotion',
            'story' => 'A Marriage Number of 33 is the master number of compassionate service, with the 6 beneath it for home and family. Care, generosity and a wish to uplift others may shape your life together. The risk is self-sacrifice, giving until there is little left.',
            'guidance' => ['Let care flow in both directions', 'Share the emotional load', 'Rest and restore together without guilt'],
        ],
    ],
];