'use strict';

/* Condensed interpretation content for the destiny-number Calculator.
   Keyed by the final number (1-9, 11, 22, 33). One short block of
   1-2 paragraphs per number -- no sub-sections/accordion. */
const DESTINY_NUMBER_DATA = {
  "1": {
    "title": "The Original",
    "paragraphs": [
      "Destiny Number 1 means your name carries the vibration of independence and originality. Whatever you make tends to bear your own stamp rather than borrow someone else's template, and your life's work is best expressed through initiative — starting things, deciding quickly, and being comfortable owning the outcome.",
      "The growth edge is learning that originality doesn't require going it alone. At its most integrated, this destiny becomes a strong point of view that still makes room to hear it might be wrong."
    ]
  },
  "2": {
    "title": "The Diplomat",
    "paragraphs": [
      "Destiny Number 2 means your name carries the vibration of partnership. You communicate in a way that puts people at ease, and your life's work tends to flow through relationship and collaboration rather than solo achievement — being the connective tissue that holds something together.",
      "The growth edge is voicing your own position instead of only smoothing everyone else's. At its most integrated, this destiny becomes diplomacy with a spine — warmth that can still state a clear, held opinion."
    ]
  },
  "3": {
    "title": "The Performer",
    "paragraphs": [
      "Destiny Number 3 means your name carries the vibration of creative self-expression. You communicate vividly, and your life's work is best expressed through words, imagery, or performance — putting something you feel into a form other people can actually receive.",
      "The growth edge is finishing what you start rather than letting charm substitute for depth. At its most integrated, this destiny becomes expression with real weight behind it — a voice used for something that matters, and carried through."
    ]
  },
  "4": {
    "title": "The Organizer",
    "paragraphs": [
      "Destiny Number 4 means your name carries the vibration of structure. You communicate through what you do more than what you say, and your life's work is best expressed through reliability — building systems, institutions, or bodies of work that other people can depend on.",
      "The growth edge is letting a plan flex without treating change as a threat. At its most integrated, this destiny becomes structure with room to breathe — dependability that doesn't require perfect conditions."
    ]
  },
  "5": {
    "title": "The Free Spirit",
    "paragraphs": [
      "Destiny Number 5 means your name carries the vibration of freedom. You communicate with energy and adaptability, and your life's work is best expressed through variety — work with genuine autonomy, where no two days look quite the same.",
      "The growth edge is following through once the novelty wears off. At its most integrated, this destiny becomes freedom that can still commit — variety held within promises kept, not instead of them."
    ]
  },
  "6": {
    "title": "The Caretaker",
    "paragraphs": [
      "Destiny Number 6 means your name carries the vibration of care. You communicate through concern for others' wellbeing, and your life's work is best expressed through service — creating a sense of home, safety, or support for the people around you.",
      "The growth edge is receiving care as readily as you give it. At its most integrated, this destiny becomes care with real boundaries — showing up for others without disappearing yourself."
    ]
  },
  "7": {
    "title": "The Analyst",
    "paragraphs": [
      "Destiny Number 7 means your name carries the vibration of inquiry. You communicate carefully, and your life's work is best expressed through depth — research, analysis, or any pursuit that rewards sustained, quiet attention over quick answers.",
      "The growth edge is letting people see the thinking, not just the conclusion. At its most integrated, this destiny becomes wisdom that's shared rather than only privately held."
    ]
  },
  "8": {
    "title": "The Executive",
    "paragraphs": [
      "Destiny Number 8 means your name carries the vibration of achievement. You communicate with authority, and your life's work is best expressed through building something with real scale — organizing resources and people toward a concrete, measurable result.",
      "The growth edge is using that competence generously rather than as leverage over others. At its most integrated, this destiny becomes ambition that lifts other people up on the way to the goal."
    ]
  },
  "9": {
    "title": "The Humanitarian Voice",
    "paragraphs": [
      "Destiny Number 9 means your name carries the vibration of universal compassion. You communicate with warmth toward people well beyond your immediate circle, and your life's work is best expressed through contribution — service to something larger than personal gain.",
      "The growth edge is offering that same depth of care to the people closest to you. At its most integrated, this destiny becomes generosity with boundaries — compassion that doesn't leave your own circle running on empty."
    ]
  },
  "11": {
    "title": "The Illuminator",
    "paragraphs": [
      "Destiny Number 11 is a master number — the 2's sensitivity amplified into inspiration. You communicate ideas that feel ahead of the room, and your life's work is best expressed through insight — teaching, guiding, or articulating what others feel but can't quite put into words.",
      "The growth edge is trusting the vision without needing certainty first. At its most integrated, this destiny becomes grounded inspiration — insight shared steadily, not held back by self-doubt."
    ]
  },
  "22": {
    "title": "The Master Communicator",
    "paragraphs": [
      "Destiny Number 22 is a master number — the 4's discipline scaled up with the ability to think and speak in large, structural terms. Your life's work is best expressed through translating vision into something workable — projects with real, lasting impact.",
      "The growth edge is breaking the scope down rather than letting it overwhelm you. At its most integrated, this destiny becomes vision expressed at a sustainable pace — big ideas made achievable, one step at a time."
    ]
  },
  "33": {
    "title": "The Master Healer's Voice",
    "paragraphs": [
      "Destiny Number 33 is the rarest master number — the 6's nurturing instinct raised to a scale focused on healing and teaching. Your life's work is best expressed directly in service of others, often extending well past your closest circle.",
      "The growth edge is receiving support as openly as you offer it. At its most integrated, this destiny becomes healing expression that includes yourself — compassion offered from a full cup rather than an empty one."
    ]
  }
};
