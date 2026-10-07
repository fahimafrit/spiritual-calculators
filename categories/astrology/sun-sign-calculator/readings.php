<?php
declare(strict_types=1);

/* Interpretation content for the Sun Sign Calculator.
   Keyed by sign index, 0 (Aries) to 11 (Pisces), in zodiac order.
   One title and a set of short sections per sign.
   Server-side only: never included from a browser request directly. */

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

return [
    0 => [
        'title' => 'The Pioneer',
        'sections' => [
            ['Overview', 'Aries opens the zodiac, and you carry that first-in-line energy into everything. As a Fire sign ruled by Mars, you are direct, energetic and quick to act. You would rather try something and adjust than wait for a perfect plan.'],
            ['Strengths', 'Courage, initiative and honesty are your signature strengths. You start things others only talk about, you recover fast from setbacks, and people usually know exactly where they stand with you.'],
            ['Challenges', 'Impatience is the usual cost of speed. You can bulldoze past other people\'s pace, lose interest once the novelty fades, or let a short temper flare and fade before you notice the effect it had.'],
            ['In Love', 'You love with enthusiasm and a taste for the chase. You thrive with a partner who has their own spark and does not mind your intensity, and you do best when you remember that steady attention matters as much as a bold gesture.'],
            ['At Work', 'You do well where you can lead, compete or build something from scratch: entrepreneurship, sales, sport, emergency work and any role with clear goals and room to move fast.'],
            ['Best Matches', 'Leo and Sagittarius share your fire and keep pace with you. Gemini and Aquarius add curiosity and fresh air to your flame.'],
        ],
    ],
    1 => [
        'title' => 'The Builder',
        'sections' => [
            ['Overview', 'Taurus is the steady heart of the zodiac. As an Earth sign ruled by Venus, you value comfort, loyalty and things that last. You move at your own pace, and once you commit, you are very hard to shift.'],
            ['Strengths', 'Patience, reliability and a strong sense of what is worth having. You are practical, loyal and persistent, with a real gift for turning effort into something solid and lasting.'],
            ['Challenges', 'Stubbornness is the shadow of your steadiness. You can resist change long after it makes sense, hold on to possessions or old grudges, and settle into routine when growth is calling.'],
            ['In Love', 'You are devoted, sensual and dependable. You show love through presence, good food, thoughtful gifts and consistency, and you want a partner who offers the same security in return.'],
            ['At Work', 'You excel in work that rewards craft and endurance: finance, property, cooking, design, gardening, the arts and any field where quality matters more than speed.'],
            ['Best Matches', 'Virgo and Capricorn share your grounded outlook. Cancer and Pisces bring the emotional warmth you appreciate.'],
        ],
    ],
    2 => [
        'title' => 'The Communicator',
        'sections' => [
            ['Overview', 'Gemini is curious, quick and endlessly interested in the world. As an Air sign ruled by Mercury, you think fast, talk easily and pick up ideas from everywhere. Variety keeps you alive.'],
            ['Strengths', 'Adaptability, wit and a talent for connecting people and ideas. You learn quickly, explain things well and can hold more than one point of view at a time.'],
            ['Challenges', 'Restlessness can scatter your focus. You may start more than you finish, skim the surface of a subject, or talk yourself out of a decision by seeing every side of it.'],
            ['In Love', 'You need a mind to match yours. Conversation, humor and playfulness win you over, and you stay committed when a relationship keeps surprising you.'],
            ['At Work', 'You shine in communication-heavy roles: writing, teaching, media, marketing, technology, travel and anywhere that rewards quick thinking and flexibility.'],
            ['Best Matches', 'Libra and Aquarius share your love of ideas. Aries and Leo bring energy and encouragement to your curiosity.'],
        ],
    ],
    3 => [
        'title' => 'The Nurturer',
        'sections' => [
            ['Overview', 'Cancer is the sign of home, memory and care. As a Water sign ruled by the Moon, you feel deeply, notice what others need before they say it, and protect the people and places you love.'],
            ['Strengths', 'Empathy, intuition and loyalty. You create warmth wherever you go, remember what matters to people, and bring a quiet persistence to anything you care about.'],
            ['Challenges', 'Sensitivity can turn into moodiness or withdrawal. You may take things personally, cling to the past, or retreat into your shell instead of saying what you need.'],
            ['In Love', 'You love with your whole heart and want a relationship that feels like a safe home. Reassurance, shared routines and emotional honesty help you open up.'],
            ['At Work', 'You thrive in roles with a caring or protective core: healthcare, education, counseling, hospitality, family business, cooking and community work.'],
            ['Best Matches', 'Scorpio and Pisces understand your emotional depth. Taurus and Virgo offer the steady ground you value.'],
        ],
    ],
    4 => [
        'title' => 'The Performer',
        'sections' => [
            ['Overview', 'Leo is warm, generous and made to be seen. As a Fire sign ruled by the Sun, you bring confidence and a big heart to whatever you do, and you light up the people around you.'],
            ['Strengths', 'Leadership, creativity and loyalty. You inspire others, give freely, and have the courage to stand in the spotlight when something matters to you.'],
            ['Challenges', 'Pride can get in the way. You may need more recognition than you admit, find it hard to back down, or take criticism as a verdict on your worth.'],
            ['In Love', 'You love grandly and expect devotion in return. Appreciation, loyalty and shared fun keep the flame going, and your generosity is at its best when it is paired with listening.'],
            ['At Work', 'You do well where you can lead, create or perform: management, entertainment, design, teaching, events and any role that rewards confidence and vision.'],
            ['Best Matches', 'Aries and Sagittarius match your fire. Gemini and Libra bring the lively company and admiration you enjoy.'],
        ],
    ],
    5 => [
        'title' => 'The Analyst',
        'sections' => [
            ['Overview', 'Virgo is thoughtful, precise and quietly devoted. As an Earth sign ruled by Mercury, you notice details others miss and feel most at ease when you are being useful.'],
            ['Strengths', 'Discernment, diligence and a real wish to improve things. You are organized, dependable and skilled at turning a messy problem into a clear, working solution.'],
            ['Challenges', 'Your high standards can turn inward. Perfectionism, worry and over-criticism of yourself or others can keep you from enjoying what already works.'],
            ['In Love', 'You show love through acts of care: remembering the small things, solving problems, being there. You open up slowly, and you do best with a partner who is patient and kind about your self-doubt.'],
            ['At Work', 'You excel in work that rewards accuracy and service: health, research, editing, analysis, engineering, administration and skilled trades.'],
            ['Best Matches', 'Taurus and Capricorn share your practical nature. Cancer and Scorpio offer the emotional depth that balances your analysis.'],
        ],
    ],
    6 => [
        'title' => 'The Diplomat',
        'sections' => [
            ['Overview', 'Libra seeks balance, beauty and fairness. As an Air sign ruled by Venus, you read people well, dislike conflict, and work naturally toward harmony in your surroundings and relationships.'],
            ['Strengths', 'Tact, charm and a strong sense of justice. You listen well, see both sides of a situation, and have an eye for aesthetics and a gift for bringing people together.'],
            ['Challenges', 'Indecision is your familiar trap. Weighing every option can leave you stuck, and a wish to keep the peace may lead you to avoid honest disagreement.'],
            ['In Love', 'You are a romantic who values partnership. Shared beauty, thoughtful communication and a sense of fairness make you feel secure, and you grow when you say what you need plainly.'],
            ['At Work', 'You do well in roles that involve people, design or fairness: law, mediation, the arts, diplomacy, public relations, fashion and collaborative teams.'],
            ['Best Matches', 'Gemini and Aquarius share your air and your love of ideas. Leo and Sagittarius bring the warmth and enthusiasm you enjoy.'],
        ],
    ],
    7 => [
        'title' => 'The Investigator',
        'sections' => [
            ['Overview', 'Scorpio is intense, perceptive and determined. As a Water sign traditionally ruled by Mars, and by Pluto in modern astrology, you look beneath the surface and want the truth of things.'],
            ['Strengths', 'Depth, resilience and focus. You are loyal, resourceful and not afraid of difficult subjects, and once you decide on something you see it through.'],
            ['Challenges', 'Intensity can slide into secrecy or control. You may find it hard to trust, hold on to hurts, or test people instead of simply asking for what you need.'],
            ['In Love', 'You love deeply and want real intimacy, not surface charm. Trust, honesty and loyalty are everything to you, and a relationship deepens as you learn to share vulnerability.'],
            ['At Work', 'You excel in work that calls for focus and depth: research, investigation, psychology, medicine, finance, strategy and crisis management.'],
            ['Best Matches', 'Cancer and Pisces understand your emotional world. Virgo and Capricorn offer loyalty and steadiness.'],
        ],
    ],
    8 => [
        'title' => 'The Explorer',
        'sections' => [
            ['Overview', 'Sagittarius is optimistic, adventurous and always looking for the bigger picture. As a Fire sign ruled by Jupiter, you are driven by curiosity, freedom and a search for meaning.'],
            ['Strengths', 'Enthusiasm, honesty and a generous spirit. You inspire people with your optimism, learn through experience, and bring humor and perspective to hard situations.'],
            ['Challenges', 'Your bluntness can sting, and your love of freedom can read as restlessness. You may overpromise, skip the details, or leave before a commitment has had time to grow.'],
            ['In Love', 'You want a partner who is also a companion on the road: someone who shares your curiosity and respects your independence. Honesty and a good laugh go a long way.'],
            ['At Work', 'You do well in roles with variety and purpose: travel, teaching, publishing, law, international work, sport and anything that lets you keep learning.'],
            ['Best Matches', 'Aries and Leo share your fire and your zest. Libra and Aquarius match your curiosity and need for space.'],
        ],
    ],
    9 => [
        'title' => 'The Strategist',
        'sections' => [
            ['Overview', 'Capricorn is disciplined, ambitious and patient. As an Earth sign ruled by Saturn, you take responsibility seriously and are willing to work steadily toward long-term goals.'],
            ['Strengths', 'Discipline, reliability and a talent for planning. You handle pressure calmly, build things that last, and earn trust through consistent effort.'],
            ['Challenges', 'You can be hard on yourself and others. Work may crowd out rest and play, and a wary, reserved manner can hide how much you actually feel.'],
            ['In Love', 'You take love seriously and show it through loyalty and practical support. You open up gradually, and you thrive with a partner who values commitment and also draws out your lighter side.'],
            ['At Work', 'You excel in roles that reward structure and perseverance: management, finance, engineering, government, law, architecture and business building.'],
            ['Best Matches', 'Taurus and Virgo share your grounded approach. Scorpio and Pisces bring emotional depth to your steadiness.'],
        ],
    ],
    10 => [
        'title' => 'The Visionary',
        'sections' => [
            ['Overview', 'Aquarius is independent, inventive and focused on the future. As an Air sign ruled by Saturn, and by Uranus in modern astrology, you think differently and care about ideas that improve life for many people.'],
            ['Strengths', 'Originality, intellect and a humanitarian streak. You are open-minded, loyal to your principles, and able to see possibilities that others have not considered.'],
            ['Challenges', 'Detachment can make you seem distant, and a strong independent streak can turn into stubbornness. You may find it easier to care about causes than to share personal feelings.'],
            ['In Love', 'You value friendship, honesty and room to be yourself. A partner who is also a good friend and who respects your individuality has the best chance of getting close to you.'],
            ['At Work', 'You do well in innovative or socially minded fields: technology, science, design, activism, research and any work that lets you question how things are done.'],
            ['Best Matches', 'Gemini and Libra share your air and your curiosity. Aries and Sagittarius energize your ideas.'],
        ],
    ],
    11 => [
        'title' => 'The Dreamer',
        'sections' => [
            ['Overview', 'Pisces is compassionate, imaginative and deeply intuitive. As a Water sign ruled by Jupiter, and by Neptune in modern astrology, you sense the moods around you and move easily between the practical and the poetic.'],
            ['Strengths', 'Empathy, creativity and adaptability. You are kind, artistic and accepting, with a gift for understanding people and for finding meaning in the unseen.'],
            ['Challenges', 'Boundaries can be hard. You may absorb other people\'s stress, escape into daydreams, or avoid difficult conversations instead of facing them.'],
            ['In Love', 'You are a romantic with a generous heart. You flourish with a partner who is gentle and steady, and who helps you stay grounded without dimming your imagination.'],
            ['At Work', 'You excel in creative and caring work: the arts, music, healing, counseling, film, charity and any role that draws on imagination and compassion.'],
            ['Best Matches', 'Cancer and Scorpio share your emotional depth. Taurus and Capricorn offer the steady ground that helps your dreams take shape.'],
        ],
    ],
];
