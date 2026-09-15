'use strict';

/* ════════════════════════════════════════════════════════════════════
   MATRIX CALCULATION ENGINE
   Shared by destiny-matrix.html and compatibility-matrix.html.
   Logic is identical in both — extracted here verbatim so it only
   has to be maintained in one place.
   ════════════════════════════════════════════════════════════════════ */

function isValidCalendarDate(parsed, date) {
  if (!parsed || isNaN(date.getTime())) return false;
  return (
    date.getFullYear() === parsed.year &&
    date.getMonth() === parsed.month - 1 &&
    date.getDate() === parsed.day
  );
}

const reduceNumber = (number) => {
  let num = number;
  while (num > 22) {
    num = String(num).split('').reduce((sum, digit) => sum + Number(digit), 0);
  }
  return num;
};

const calculateYear = (year) => {
  let y = 0;
  while (year > 0) {
    y += year % 10;
    year = Math.floor(year / 10);
  }
  return reduceNumber(y);
};

const calculatePoints = (aPoint, bPoint, cPoint) => {
  const dpoint = reduceNumber(aPoint + bPoint + cPoint);
  const epoint = reduceNumber(aPoint + bPoint + cPoint + dpoint);
  const fpoint = reduceNumber(aPoint + bPoint);
  const gpoint = reduceNumber(bPoint + cPoint);
  const hpoint = reduceNumber(dpoint + aPoint);
  const ipoint = reduceNumber(cPoint + dpoint);
  const jpoint = reduceNumber(dpoint + epoint);

  const npoint = reduceNumber(cPoint + epoint);
  const lpoint = reduceNumber(jpoint + npoint);
  const mpoint = reduceNumber(lpoint + npoint);
  const kpoint = reduceNumber(jpoint + lpoint);

  const qpoint = reduceNumber(npoint + cPoint);
  const rpoint = reduceNumber(jpoint + dpoint);
  const spoint = reduceNumber(aPoint + epoint);
  const tpoint = reduceNumber(bPoint + epoint);

  const opoint = reduceNumber(aPoint + spoint);
  const ppoint = reduceNumber(bPoint + tpoint);

  const upoint = reduceNumber(fpoint + gpoint + hpoint + ipoint);
  const vpoint = reduceNumber(epoint + upoint);
  const wpoint = reduceNumber(spoint + epoint);
  const xpoint = reduceNumber(tpoint + epoint);

  const f2point = reduceNumber(fpoint + upoint);
  const f1point = reduceNumber(fpoint + f2point);
  const g2point = reduceNumber(gpoint + upoint);
  const g1point = reduceNumber(gpoint + g2point);
  const i2point = reduceNumber(ipoint + upoint);
  const i1point = reduceNumber(ipoint + i2point);
  const h2point = reduceNumber(hpoint + upoint);
  const h1point = reduceNumber(hpoint + h2point);

  const afpoint = reduceNumber(aPoint + fpoint);
  const af1point = reduceNumber(aPoint + afpoint);
  const af2point = reduceNumber(aPoint + af1point);
  const af3point = reduceNumber(afpoint + af1point);
  const af4point = reduceNumber(afpoint + fpoint);
  const af5point = reduceNumber(afpoint + af4point);
  const af6point = reduceNumber(af4point + fpoint);
  const fbpoint = reduceNumber(fpoint + bPoint);
  const fb1point = reduceNumber(fpoint + fbpoint);
  const fb2point = reduceNumber(fpoint + fb1point);
  const fb3point = reduceNumber(fbpoint + fb1point);
  const fb4point = reduceNumber(fbpoint + bPoint);
  const fb5point = reduceNumber(fbpoint + fb4point);
  const fb6point = reduceNumber(fb4point + bPoint);
  const bgpoint = reduceNumber(bPoint + gpoint);
  const bg1point = reduceNumber(bPoint + bgpoint);
  const bg2point = reduceNumber(bPoint + bg1point);
  const bg3point = reduceNumber(bgpoint + bg1point);
  const bg4point = reduceNumber(bgpoint + gpoint);
  const bg5point = reduceNumber(bgpoint + bg4point);
  const bg6point = reduceNumber(bg4point + gpoint);
  const gcpoint = reduceNumber(gpoint + cPoint);
  const gc1point = reduceNumber(gpoint + gcpoint);
  const gc2point = reduceNumber(gpoint + gc1point);
  const gc3point = reduceNumber(gcpoint + gc1point);
  const gc4point = reduceNumber(gcpoint + cPoint);
  const gc5point = reduceNumber(gcpoint + gc4point);
  const gc6point = reduceNumber(gc4point + cPoint);
  const cipoint = reduceNumber(cPoint + ipoint);
  const ci1point = reduceNumber(cPoint + cipoint);
  const ci2point = reduceNumber(cPoint + ci1point);
  const ci3point = reduceNumber(cipoint + ci1point);
  const ci4point = reduceNumber(cipoint + ipoint);
  const ci5point = reduceNumber(cipoint + ci4point);
  const ci6point = reduceNumber(ci4point + ipoint);
  const idpoint = reduceNumber(ipoint + dpoint);
  const id1point = reduceNumber(ipoint + idpoint);
  const id2point = reduceNumber(ipoint + id1point);
  const id3point = reduceNumber(idpoint + id1point);
  const id4point = reduceNumber(idpoint + dpoint);
  const id5point = reduceNumber(idpoint + id4point);
  const id6point = reduceNumber(id4point + dpoint);
  const dhpoint = reduceNumber(dpoint + hpoint);
  const dh1point = reduceNumber(dpoint + dhpoint);
  const dh2point = reduceNumber(dpoint + dh1point);
  const dh3point = reduceNumber(dhpoint + dh1point);
  const dh4point = reduceNumber(dhpoint + hpoint);
  const dh5point = reduceNumber(dhpoint + dh4point);
  const dh6point = reduceNumber(dh4point + hpoint);
  const hapoint = reduceNumber(hpoint + aPoint);
  const ha1point = reduceNumber(hpoint + hapoint);
  const ha2point = reduceNumber(hpoint + ha1point);
  const ha3point = reduceNumber(hapoint + ha1point);
  const ha4point = reduceNumber(hapoint + aPoint);
  const ha5point = reduceNumber(hapoint + ha4point);
  const ha6point = reduceNumber(ha4point + aPoint);

  const years = {
    afpoint, af1point, af2point, af3point, af4point, af5point, af6point,
    fbpoint, fb1point, fb2point, fb3point, fb4point, fb5point, fb6point,
    bgpoint, bg1point, bg2point, bg3point, bg4point, bg5point, bg6point,
    gcpoint, gc1point, gc2point, gc3point, gc4point, gc5point, gc6point,
    cipoint, ci1point, ci2point, ci3point, ci4point, ci5point, ci6point,
    idpoint, id1point, id2point, id3point, id4point, id5point, id6point,
    dhpoint, dh1point, dh2point, dh3point, dh4point, dh5point, dh6point,
    hapoint, ha1point, ha2point, ha3point, ha4point, ha5point, ha6point,
  };

  const skypoint = reduceNumber(bPoint + dpoint);
  const earthpoint = reduceNumber(aPoint + cPoint);
  const perspurpose = reduceNumber(skypoint + earthpoint);
  const femalepoint = reduceNumber(gpoint + hpoint);
  const malepoint = reduceNumber(fpoint + ipoint);
  const socialpurpose = reduceNumber(femalepoint + malepoint);
  const generalpurpose = reduceNumber(perspurpose + socialpurpose);
  const planetarypurpose = reduceNumber(socialpurpose + generalpurpose);

  const points = {
    apoint: aPoint, bpoint: bPoint, cpoint: cPoint,
    dpoint, epoint, fpoint, gpoint, hpoint, ipoint, jpoint,
    kpoint, lpoint, mpoint, npoint, opoint, ppoint, qpoint, rpoint,
    spoint, tpoint, upoint, vpoint, wpoint, xpoint,
    f2point, f1point, g2point, g1point, i2point, i1point, h2point, h1point,
  };

  const purposes = {
    skypoint, earthpoint, perspurpose,
    femalepoint, malepoint, socialpurpose,
    generalpurpose, planetarypurpose,
  };

  const chartHeart = {
    sahphysics: aPoint, ajphysics: opoint, vishphysics: spoint, anahphysics: wpoint,
    manphysics: epoint, svadphysics: npoint, mulphysics: cPoint,

    sahenergy: bPoint, ajenergy: ppoint, vishenergy: tpoint, anahenergy: xpoint,
    manenergy: epoint, svadenergy: jpoint, mulenergy: dpoint,

    sahemotions: reduceNumber(aPoint + bPoint),
    ajemotions: reduceNumber(opoint + ppoint),
    vishemotions: reduceNumber(spoint + tpoint),
    anahemotions: reduceNumber(wpoint + xpoint),
    manemotions: reduceNumber(epoint + epoint),
    svademotions: reduceNumber(jpoint + npoint),
    mulemotions: reduceNumber(cPoint + dpoint),
  };

  return { points, purposes, chartHeart, years };
};