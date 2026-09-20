'use strict';

/* Condensed interpretation content for the attitude-number Calculator.
   Keyed by the final number (1-9, 11, 22, 33). One short block of
   1-2 paragraphs per number -- no sub-sections/accordion. */
const ATTITUDE_NUMBER_DATA = {
  "1": {
    "title": "The Initiator",
    "paragraphs": [
      "Your Attitude Number shapes the first impression you give off and your instinctive approach to new situations — and 1 walks in ready to lead. Before you know a room, you're already scanning it for what needs starting, and your default reaction to a new challenge is to act rather than wait to be told what to do.",
      "Left unchecked, this reads as impatience or a need to control the opening move. Tempered, it's the person a group is quietly glad has taken initiative — decisive without needing to dominate the room to prove it."
    ]
  },
  "2": {
    "title": "The Diplomat",
    "paragraphs": [
      "Your Attitude Number shapes your instinctive approach to new people and situations — and 2 walks in reading the room before saying much. Your default reaction to something unfamiliar is to observe the social temperature first, adjusting yourself to fit rather than announcing your presence.",
      "Left unchecked, this reads as passivity or an inability to state a clear opinion early on. Tempered, it's a genuinely welcome calm in a new or tense situation — someone whose first move is to make everyone else comfortable."
    ]
  },
  "3": {
    "title": "The Charmer",
    "paragraphs": [
      "Your Attitude Number shapes the first impression you give off — and 3 walks in warm, expressive, and quick with a comment that lightens the mood. New situations don't intimidate you; if anything, an unfamiliar room is an invitation to be noticed.",
      "Left unchecked, this reads as not being taken seriously, using charm to skip past anything that requires depth. Tempered, it's real likability — an easy, disarming presence that makes new people and new rooms feel instantly less stiff."
    ]
  },
  "4": {
    "title": "The Steady Hand",
    "paragraphs": [
      "Your Attitude Number shapes your instinctive approach to new situations — and 4 walks in cautious and methodical, wanting to understand how something works before committing to it. Your default reaction to the unfamiliar is to look for the structure underneath it.",
      "Left unchecked, this reads as stiffness or being slow to warm up. Tempered, it's quiet dependability from the very first interaction — people sense early that you're someone who follows through on what you say."
    ]
  },
  "5": {
    "title": "The Live Wire",
    "paragraphs": [
      "Your Attitude Number shapes the first impression you give off — and 5 walks in energetic, curious, and visibly restless in a good way. New situations read as opportunities rather than threats, and your default reaction to unfamiliar territory is genuine excitement.",
      "Left unchecked, this reads as flightiness or an inability to sit still long enough to be taken seriously. Tempered, it's infectious enthusiasm — the person who makes a new environment feel more interesting just by being in it."
    ]
  },
  "6": {
    "title": "The Caretaker",
    "paragraphs": [
      "Your Attitude Number shapes your instinctive approach to new people — and 6 walks in warm and attentive, quickly noticing who in the room might need something. Your default reaction to a new situation is concern for how everyone else is doing in it.",
      "Left unchecked, this reads as over-involvement before anyone's asked for it. Tempered, it's the reassuring presence people remember from a first meeting — genuine care offered without an agenda."
    ]
  },
  "7": {
    "title": "The Observer",
    "paragraphs": [
      "Your Attitude Number shapes the first impression you give off — and 7 walks in quiet and watchful, taking in far more than you let on. New people and situations get studied before you decide how much of yourself to offer.",
      "Left unchecked, this reads as aloofness or being hard to reach. Tempered, it's a thoughtful presence people come to trust precisely because you don't perform openness you don't actually feel yet."
    ]
  },
  "8": {
    "title": "The Commander",
    "paragraphs": [
      "Your Attitude Number shapes your instinctive approach to new situations — and 8 walks in assessing scale, stakes, and who's actually in charge. Your default reaction to something unfamiliar is to figure out how to gain competent control of it quickly.",
      "Left unchecked, this reads as intimidating or overly transactional on first meeting. Tempered, it's quiet authority — the person a new room instinctively takes seriously, without needing to raise their voice to earn it."
    ]
  },
  "9": {
    "title": "The Old Soul",
    "paragraphs": [
      "Your Attitude Number shapes the first impression you give off — and 9 walks in with a kind of worldly warmth, treating new people with an ease that suggests you've been somewhere like this before. Your default reaction to an unfamiliar situation is broad-minded acceptance rather than wariness.",
      "Left unchecked, this reads as detachment or a slight distance, as if part of you is already thinking bigger picture. Tempered, it's genuine, unforced generosity — the sense that you make room for people without needing anything back."
    ]
  },
  "11": {
    "title": "The Spark",
    "paragraphs": [
      "Your Attitude Number is a master number — 11 walks into new situations carrying a heightened, almost electric sensitivity to the room's mood before a word's been exchanged. Your default first reaction is intuitive rather than analytical; you sense the undercurrent before you understand it.",
      "Left unchecked, this reads as visible nervousness or overwhelm in unfamiliar settings. Tempered, it's a quietly magnetic first impression — people sense there's real perceptiveness behind your reaction, even when you haven't said very much yet."
    ]
  },
  "22": {
    "title": "The Architect",
    "paragraphs": [
      "Your Attitude Number is a master number — 22 walks into new situations already sketching the structure of what could be built there. Your default first reaction combines big-picture vision with an instinct for what's practically achievable, rare in combination.",
      "Left unchecked, this reads as overwhelming intensity for a first meeting, jumping straight to scale before anyone's ready. Tempered, it's a first impression of quiet, credible capability — someone who makes ambitious things sound entirely doable."
    ]
  },
  "33": {
    "title": "The Healer's Presence",
    "paragraphs": [
      "Your Attitude Number is the rarest master number — 33 walks into new situations with an instinctive warmth that reads as genuine care, not performance. Your default first reaction is compassion for whoever seems to need it most in the room.",
      "Left unchecked, this reads as over-extension before you've even settled in yourself. Tempered, it's the kind of first impression people don't forget — a sense of being truly looked after from the very first interaction."
    ]
  }
};
