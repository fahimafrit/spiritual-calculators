<?php
declare(strict_types=1);

if (!defined('SPIRITUAL_APP')) {
    http_response_code(403);
    exit('Forbidden');
}

/* ════════════════════════════════════════════════════════════════════
   LO SHU GRID — READINGS
   Interpretation text only. The handler decides which entries to show.

   numbers[n]   : title, then one text per situation —
                  present (appears once), double (twice),
                  excess (three or more times), missing (absent)
   driver[n]    : reading for the Driver Number (1-9)
   conductor[n] : reading for the Conductor Number (1-9)
   lines[key]   : name, numbers, theme, complete, missing
   ════════════════════════════════════════════════════════════════════ */

return [
    'numbers' => [
        1 => [
            'title' => 'Self-Expression and Leadership (Sun)',
            'present' => 'You have a clear sense of self and the confidence to put your ideas into words. You can take the lead when a situation needs someone to step forward.',
            'double' => 'Your voice is strong and your independence is firmly established. People tend to listen when you speak, and you rarely wait for permission to act.',
            'excess' => 'Willpower and self-belief run very high. Used well, this makes you a natural leader; left unchecked, it can harden into stubbornness or a need to have the last word.',
            'missing' => 'Speaking up and standing your ground may not come easily. Practising clear, direct communication and making your own decisions will steadily strengthen this area.',
        ],
        2 => [
            'title' => 'Sensitivity and Cooperation (Moon)',
            'present' => 'You are intuitive and attentive to the feelings of others. Cooperation and partnership come naturally to you.',
            'double' => 'Your sensitivity runs deep. You pick up on moods and unspoken needs quickly, which makes you a caring and perceptive friend or partner.',
            'excess' => 'Emotions run very strongly. Your empathy is a gift, but it can tip into over-sensitivity, mood swings or taking on other people’s feelings as your own.',
            'missing' => 'Trusting your instincts and tending to close relationships may need conscious effort. Learning to listen, to cooperate and to ask for support is the lesson here.',
        ],
        3 => [
            'title' => 'Creativity and Imagination (Jupiter)',
            'present' => 'You have a lively mind, a good imagination and a taste for learning. Creative ideas come to you readily.',
            'double' => 'Your creativity and intellect are well developed. You enjoy ideas, enjoy sharing what you know, and often have a gift for words or design.',
            'excess' => 'Your mind is extremely active. This fuels invention, but it can also scatter your energy, lead to overthinking or leave you daydreaming more than doing.',
            'missing' => 'Trusting your own ideas and giving your imagination room to play may be a challenge. Creative hobbies, reading and open-ended learning will help build this quality.',
        ],
        4 => [
            'title' => 'Practicality and Order (Rahu)',
            'present' => 'You are practical, patient and good at turning plans into steady progress. You value method and reliability.',
            'double' => 'Discipline and organisation are real strengths. You can be counted on to finish what you start and to keep things running smoothly.',
            'excess' => 'Your drive for order and hard work is intense. It builds results, but it can slide into rigidity, over-work or difficulty accepting change.',
            'missing' => 'Structure and follow-through may feel difficult. Simple routines, checklists and breaking big goals into small steps will help you build steadiness.',
        ],
        5 => [
            'title' => 'Balance and Freedom (Mercury)',
            'present' => 'You have a steady centre and adapt well to change. Communication and quick thinking help you move between different situations with ease.',
            'double' => 'You are versatile, curious and good with people. Balance comes naturally, and you usually find a way to keep several things moving at once.',
            'excess' => 'Restless energy and a strong need for freedom stand out. You may take risks, change direction often, or find it hard to commit to one path for long.',
            'missing' => 'Finding balance and a firm sense of direction may take effort. Grounding habits, clear priorities and honest communication will help you build a stable centre.',
        ],
        6 => [
            'title' => 'Home, Love and Responsibility (Venus)',
            'present' => 'You are warm, caring and loyal. Home, family and harmony matter to you, and you take your responsibilities seriously.',
            'double' => 'Love and devotion are central to your life. You create comfort and beauty for the people around you and are often the one others lean on.',
            'excess' => 'Your sense of care is very strong. It makes you generous and dependable, but it can turn into worry, over-giving or a wish to control how others live.',
            'missing' => 'Opening your heart and accepting care as well as giving it may be the lesson. Nurturing relationships and your home environment will help develop this quality.',
        ],
        7 => [
            'title' => 'Reflection and Spirituality (Ketu)',
            'present' => 'You have an inner life that matters to you. Reflection, patience and a search for meaning shape how you see the world.',
            'double' => 'You are thoughtful and spiritually inclined. You tend to learn through experience, and difficult periods often deepen your understanding.',
            'excess' => 'The inner world is very rich. You may need a lot of solitude, and at times you can become withdrawn, secretive or detached from everyday life.',
            'missing' => 'Making time for stillness and for questions of meaning may not come naturally. Quiet reflection, meditation or time in nature can help this area grow.',
        ],
        8 => [
            'title' => 'Discipline and Duty (Saturn)',
            'present' => 'You have a good sense of responsibility and the patience to build things over time. Organisation and effort come to you without too much struggle.',
            'double' => 'Discipline and persistence are strengths. You tend to be careful with resources and willing to work steadily towards long-term goals.',
            'excess' => 'Your sense of duty and structure is intense. It can bring real achievement, but it may also make you exacting, overly serious or heavily burdened by responsibility.',
            'missing' => 'Discipline and long-term organisation may be harder to maintain. Setting realistic routines and being consistent with money and commitments will build this strength.',
        ],
        9 => [
            'title' => 'Ambition and Humanity (Mars)',
            'present' => 'You have energy, ambition and a wider view of the world. A humane, idealistic streak often sits alongside your drive.',
            'double' => 'Courage and vision are well developed. You can pursue big goals and often feel a pull to contribute to something larger than yourself.',
            'excess' => 'Ambition and intensity burn very bright. This brings energy and courage, but it can also show up as impatience, a short temper or taking on too much at once.',
            'missing' => 'Widening your view and acting for more than your own concerns may be the lesson. Setting meaningful goals and serving a cause you care about will help build this quality.',
        ],
    ],

    'driver' => [
        1 => 'Your Driver Number is 1. At your core you are independent, self-reliant and drawn to leading rather than following. You prefer to make your own decisions and tend to be at your best when you have room to act on your own initiative.',
        2 => 'Your Driver Number is 2. At your core you are sensitive, gentle and cooperative. You read people well, value harmony and tend to do your best work in partnership, though you may need to guard against absorbing other people’s moods.',
        3 => 'Your Driver Number is 3. At your core you are creative, expressive and optimistic. You enjoy learning and sharing ideas, and you tend to bring a sense of lightness and encouragement to the people around you.',
        4 => 'Your Driver Number is 4. At your core you are practical, methodical and determined. You prefer to build things step by step, value stability and are often unconventional in how you think, even while you work in an orderly way.',
        5 => 'Your Driver Number is 5. At your core you are curious, adaptable and quick-minded. You enjoy variety, movement and conversation, and you tend to learn fastest when you are free to explore.',
        6 => 'Your Driver Number is 6. At your core you are caring, responsible and drawn to beauty and comfort. Family, loyalty and harmony matter deeply to you, and you often take on the role of looking after others.',
        7 => 'Your Driver Number is 7. At your core you are reflective, analytical and spiritually inclined. You value privacy and depth over small talk, and you tend to seek understanding through study, solitude and experience.',
        8 => 'Your Driver Number is 8. At your core you are disciplined, ambitious and serious about your responsibilities. You work steadily towards long-term goals and often gain strength and authority through perseverance.',
        9 => 'Your Driver Number is 9. At your core you are energetic, courageous and idealistic. You have a strong drive to act, to protect what you believe in and to contribute to something beyond yourself.',
    ],

    'conductor' => [
        1 => 'Your Conductor Number is 1. Life tends to steer you towards independence and leadership. Over the years you are likely to be asked to take initiative, trust your own judgement and build something that carries your own stamp.',
        2 => 'Your Conductor Number is 2. Life tends to steer you towards cooperation and relationships. Partnerships, diplomacy and emotional understanding are likely to play a central part in your path.',
        3 => 'Your Conductor Number is 3. Life tends to steer you towards creativity, learning and self-expression. Teaching, writing, communicating or any work that shares ideas can be a natural direction.',
        4 => 'Your Conductor Number is 4. Life tends to steer you towards building and organising. Your path often rewards patience, hard work and careful planning, and may involve laying foundations that others can rely on.',
        5 => 'Your Conductor Number is 5. Life tends to steer you towards change, travel and communication. Your path is rarely static, and you tend to grow through variety, new experiences and meeting many kinds of people.',
        6 => 'Your Conductor Number is 6. Life tends to steer you towards family, service and responsibility. Your path often involves caring for others, creating a stable home and bringing harmony to the groups you belong to.',
        7 => 'Your Conductor Number is 7. Life tends to steer you towards inner growth and understanding. Your path often involves study, reflection and learning through experience, with a growing interest in deeper questions.',
        8 => 'Your Conductor Number is 8. Life tends to steer you towards achievement, responsibility and the handling of resources. Your path often rewards discipline and persistence, and may place you in positions of authority.',
        9 => 'Your Conductor Number is 9. Life tends to steer you towards service, vision and completion. Your path often involves working for a wider cause, letting go of what has run its course and contributing to the wider community.',
    ],

    'lines' => [
        'mind' => [
            'name' => 'Mind Plane',
            'numbers' => [4, 9, 2],
            'theme' => 'Intellect, memory and planning',
            'complete' => 'The Mind Plane is complete. You think ahead, remember well and are good at planning. Strategy and clear reasoning are real strengths for you.',
            'missing' => 'The Mind Plane is empty. Planning, memory and concentration may take extra effort. Writing things down, making lists and building a routine for important tasks will help.',
        ],
        'emotional' => [
            'name' => 'Emotional Plane',
            'numbers' => [3, 5, 7],
            'theme' => 'Feeling, intuition and inner life',
            'complete' => 'The Emotional Plane is complete. You are in touch with your feelings, intuitive and sensitive to the emotional atmosphere around you. You tend to be steady in relationships.',
            'missing' => 'The Emotional Plane is empty. You may find it hard to name or express what you feel, or tend to analyse feelings rather than experience them. Creative outlets and honest conversations can help.',
        ],
        'practical' => [
            'name' => 'Practical Plane',
            'numbers' => [8, 1, 6],
            'theme' => 'Money, action and material life',
            'complete' => 'The Practical Plane is complete. You are grounded and good at turning ideas into results. Handling money, work and everyday responsibilities tends to come comfortably to you.',
            'missing' => 'The Practical Plane is empty. Turning ideas into steady action may be a challenge. Small, consistent habits and clear goals for money and work will help you build this side.',
        ],
        'thought' => [
            'name' => 'Thought Plane',
            'numbers' => [4, 3, 8],
            'theme' => 'Generating and processing ideas',
            'complete' => 'The Thought Plane is complete. You turn ideas into organised thought easily. You tend to be a careful, imaginative thinker who can follow a line of reasoning from beginning to end.',
            'missing' => 'The Thought Plane is empty. Ideas may come faster than you can organise them, or you may doubt your own thinking. Slowing down and working through problems step by step will help.',
        ],
        'will' => [
            'name' => 'Will Plane',
            'numbers' => [9, 5, 1],
            'theme' => 'Willpower, direction and inner drive',
            'complete' => 'The Will Plane is complete. You have strong determination and a clear sense of direction. Once you decide on a goal, you tend to keep going even when progress is slow.',
            'missing' => 'The Will Plane is empty. Staying motivated and following through may be difficult, especially when others do not support you. Setting small goals and finishing them builds this strength over time.',
        ],
        'action' => [
            'name' => 'Action Plane',
            'numbers' => [2, 7, 6],
            'theme' => 'Execution, completion and results',
            'complete' => 'The Action Plane is complete. You finish what you start. Where others plan many things, you tend to deliver results and keep your commitments.',
            'missing' => 'The Action Plane is empty. You may be full of plans yet find it hard to begin or complete them. Setting deadlines and working in short focused bursts can help you move ideas into action.',
        ],
        'golden' => [
            'name' => 'Golden Yog',
            'numbers' => [4, 5, 6],
            'theme' => 'Prosperity, stability and recognition',
            'complete' => 'The Golden Yog is formed. Traditionally this is a favourable pattern linked with stability, steady prosperity and the ability to build a comfortable, respected life through your own efforts.',
            'missing' => 'The Golden Yog is empty. Prosperity and stability may need to be built with extra patience and planning. Steady saving, careful decisions and consistent effort work in your favour.',
        ],
        'silver' => [
            'name' => 'Silver Yog',
            'numbers' => [2, 5, 8],
            'theme' => 'Intuition, balance and good judgement',
            'complete' => 'The Silver Yog is formed. Traditionally this is a favourable pattern linked with sound judgement, intuition and the ability to keep emotion and practicality in balance.',
            'missing' => 'The Silver Yog is empty. Balancing feeling and practicality may take more effort, and you may second-guess your instincts. Reflecting before big decisions will help you trust your judgement.',
        ],
    ],
];