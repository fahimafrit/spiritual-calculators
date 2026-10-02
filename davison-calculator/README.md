# Davison Relationship Chart Calculator

A standalone calculator that runs in your browser. It uses the Swiss Ephemeris (through the
`sweph` Node package) for planet positions, houses and angles.

## Run it

1. Install Node.js 18 or newer from https://nodejs.org (the LTS version is fine).
2. Open a terminal in this folder and run:

       npm install
       npm start

3. Open http://localhost:3000 in your browser.

`npm install` also downloads the three Swiss Ephemeris data files (1800-2399) into `ephe/`
if they are missing. If that download fails, get `sepl_18.se1`, `semo_18.se1` and `seas_18.se1`
from https://github.com/aloistr/swisseph/tree/master/ephe and put them in `ephe/`.
Without the files the app falls back to the built-in Moshier ephemeris, which has no Chiron.

To use another port: `PORT=4000 npm start` (macOS/Linux) or `$env:PORT=4000; npm start` (PowerShell).

## What is in the folder

    server.mjs              calculation engine + tiny web server (POST /api/davison)
    public/index.html       the whole interface: form, SVG wheel, tables, aspects
    scripts/download-ephe.mjs   fetches the ephemeris data files
    ephe/                   Swiss Ephemeris data files

## How the Davison chart is built

1. Birth local time -> UT using the IANA time zone database (historical DST included).
2. Average the two Julian Days (UT).
3. Average latitude; average longitude along the shorter arc (or use the great-circle midpoint).
4. Cast a normal chart for that moment and place.

## Before you put this on a public website

`sweph` and the Swiss Ephemeris are dual-licensed: AGPL-3.0, or a paid professional license from
Astrodienst (astro.com/swisseph). Under AGPL, a public site that uses them must offer its source.
Decide which route you want before merging.

City search uses Open-Meteo's free geocoding API, which is for non-commercial use. For a
commercial site, use a paid plan or host your own city database (GeoNames).

## Troubleshooting

- **Opening the page:** the cleanest way is http://localhost:3000. The page also finds the calculator
  server if it was opened another way (Live Server, or double-clicking index.html), but `npm start`
  must still be running in a terminal window.
- **Every request is printed in the terminal** running `npm start` (for example `POST /api/davison 200 30 ms`).
  If you click Calculate and no new line appears, the page is talking to a different program.
- **"Calculated by server xxxxxx on port 3000"** appears under the chart. If that id changes between
  clicks on the same data, two copies of the server are running. Close every terminal running
  `npm start`, then start one.
- Find what is using a port on Windows: `netstat -ano | findstr :3000`, then `taskkill /PID <number> /F`.
- If port 3000 is taken, the server picks the next free port and prints the address to open.
