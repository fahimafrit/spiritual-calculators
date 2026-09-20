'use strict';

/* Condensed interpretation content for the life-path-number Calculator.
   Keyed by the final number (1-9, 11, 22, 33). One short block of
   1-2 paragraphs per number -- no sub-sections/accordion. */
const LIFE_PATH_DATA = {
  "1": {
    "title": "The Leader",
    "paragraphs": [
      "Life Path 1 is the number of the pioneer. You arrived with a drive to carve your own trail rather than follow someone else's, and independence isn't a phase for you — it's how you naturally operate. You lead by starting things, deciding quickly, and turning a raw idea into a working first version before most people have finished discussing it.",
      "The growth edge is impatience: a pull to steamroll input you didn't ask for, and discomfort admitting when you need help. At your best you're a leader who still makes room for other people's ideas — confident enough in your own direction that you don't need to dominate every decision to feel secure in it."
    ]
  },
  "2": {
    "title": "The Peacemaker",
    "paragraphs": [
      "Life Path 2 is the number of partnership. You read a room before you speak in it, sensing the emotional undercurrent of a situation faster than most people notice its surface. Cooperation isn't a compromise for you — it's genuinely how you prefer to get things done, and you're a loyal, attentive collaborator.",
      "The growth edge is over-accommodation: softening your own needs so much that people never quite know where you stand, and avoiding conflict that actually needs addressing. At your best you hold both sides of a disagreement with real warmth, while still saying plainly what you actually want."
    ]
  },
  "3": {
    "title": "The Communicator",
    "paragraphs": [
      "Life Path 3 is the number of self-expression. Words, images, and performance come naturally to you, and a thought rarely feels finished until you've said it, written it, or shown it to someone. You bring lightness into rooms that badly need it, and people are drawn to how alive you make ordinary moments feel.",
      "The growth edge is follow-through: scattered focus and a habit of starting more than you finish, sometimes using humor to deflect from feelings you'd rather not sit with. At your best your expression carries real substance — a voice used to say something that matters, and finished often enough that it counts."
    ]
  },
  "4": {
    "title": "The Builder",
    "paragraphs": [
      "Life Path 4 is the number of structure. You value what's solid and repeatable over what's flashy, and you're the person a group quietly relies on to make sure the actual work gets done. Discipline, reliability, and an ability to sustain effort long after everyone else's motivation fades are your signature strengths.",
      "The growth edge is rigidity: discomfort when plans need to shift, and a tendency to equate rest with laziness rather than maintenance. At your best your structure still flexes when it needs to — discipline that leaves room for spontaneity and joy along the way, not just for the plan."
    ]
  },
  "5": {
    "title": "The Adventurer",
    "paragraphs": [
      "Life Path 5 is the number of freedom. Variety keeps you alive in a way routine simply can't, and you tend to learn about yourself through new experience rather than long stretches of introspection. You adapt to sudden change better than almost anyone, treating a disrupted plan as an opportunity rather than a crisis.",
      "The growth edge is commitment: restlessness that can undermine an otherwise good decision, and an occasional pull toward escape when freedom stops feeling like exploration. At your best your curiosity can still commit — variety chosen alongside someone, not used as a way to avoid depth."
    ]
  },
  "6": {
    "title": "The Nurturer",
    "paragraphs": [
      "Life Path 6 is the number of responsibility and care. Family, community, and the wellbeing of the people close to you tend to sit near the center of your decisions, and you feel most yourself when you're genuinely useful to someone you love. You notice what others need before they've said it aloud.",
      "The growth edge is self-sacrifice: taking on responsibility for things that were never yours to fix, and building quiet resentment from over-giving. At your best your care comes with limits — showing up for the people you love without disappearing yourself in the process."
    ]
  },
  "7": {
    "title": "The Seeker",
    "paragraphs": [
      "Life Path 7 is the number of the seeker. You're drawn to what's true rather than what's comfortable, and you need real solitude to process the world, not just downtime. Sharp analytical thinking and natural intuition make you an excellent researcher and a trustworthy confidant precisely because you don't overshare.",
      "The growth edge is isolation: pulling away further than the solitude you actually need, and letting healthy skepticism curdle into cynicism. At your best your depth is still shared — wisdom you're willing to offer rather than wisdom you only keep to yourself."
    ]
  },
  "8": {
    "title": "The Powerhouse",
    "paragraphs": [
      "Life Path 8 is the number of material mastery. You think in terms of outcomes, resources, and scale, with a natural instinct for how power, money, and influence actually move through a system. Strong executive ability and the discipline to see long-term goals through are your defining traits.",
      "The growth edge is ruthlessness: a tendency to equate self-worth with net worth, and workaholism that crowds out everything else. At your best your ambition lifts other people up on the way to the goal, and your presence at home matters as much as your success at work."
    ]
  },
  "9": {
    "title": "The Humanitarian",
    "paragraphs": [
      "Life Path 9 is the number of completion and compassion. You feel connected to humanity in a broad, almost impersonal way, and you're often the one in a room thinking about the bigger picture while everyone else focuses on the immediate. Generosity comes easily, and rarely with strings attached.",
      "The growth edge is boundaries: a pull toward martyrdom in the name of a cause, and difficulty letting go of chapters that have clearly run their course. At your best your compassion reaches the people closest to you with the same depth you so easily offer strangers."
    ]
  },
  "11": {
    "title": "The Intuitive",
    "paragraphs": [
      "Life Path 11 is a master number — an amplified version of the 2's sensitivity, carrying visionary insight and a heightened awareness of things other people miss entirely. You often sense what's coming before there's evidence for it, and people quietly look to you for insight during uncertain moments.",
      "The growth edge is self-doubt: sensitivity that can tip into anxiety, and second-guessing perceptiveness that later turns out to be right. At your best your intuition is grounded — trusted and shared, rather than destabilized by how intensely you feel everything."
    ]
  },
  "22": {
    "title": "The Master Builder",
    "paragraphs": [
      "Life Path 22 is a master number — the 4's discipline scaled up with the capacity to think in large, structural terms. You're drawn to projects with lasting impact, and you have a rare ability to turn an ambitious idea into something concrete rather than leaving it as a dream.",
      "The growth edge is self-pressure: expectations so high the scope feels overwhelming before you even start, and a tendency to take on more than any one person can carry. At your best your vision gets built sustainably — big goals broken into steps, shared with people who can help carry them."
    ]
  },
  "33": {
    "title": "The Master Teacher",
    "paragraphs": [
      "Life Path 33 is the rarest master number — the 6's nurturing instinct raised to a level focused on healing and teaching at scale. You carry an unusually deep capacity for compassion, often extending it well beyond your immediate circle, with a rare ability to hold other people's pain without being destroyed by it.",
      "The growth edge is self-erasure: giving until you're depleted, and discomfort acknowledging your own needs when so much of your identity is built around meeting everyone else's. At your best your healing includes yourself — service that comes from abundance, not depletion."
    ]
  }
};
