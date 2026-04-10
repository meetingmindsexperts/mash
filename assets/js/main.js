/* =========================================================
   Wegovy® in MASH — landing page script
   Mobile-friendly, vanilla JS, no dependencies.
   ========================================================= */

(function () {
  'use strict';

  // ----- Single source of truth: edit here to retarget -----
  var EVENT = {
    title:       'Wegovy\u00AE in MASH \u2014 MASH in Focus: Integrating Metabolic and Hepatic Care in the UAE',
    description: 'A multidisciplinary scientific program on early identification and integrated management of MASH (metabolic dysfunction-associated steatohepatitis). Chaired by Dr. Ahmad Al-Rifai with leading hepatology and endocrinology faculty from the UAE and Germany. For healthcare professionals only.',
    location:    'Virtual',
    url:         'https://meetingmindsexperts.github.io/mash/',
    // 25 April 2026, 18:00 \u2013 20:15 (Gulf Standard Time, UTC+04:00)
    start:       '2026-04-25T18:00:00+04:00',
    end:         '2026-04-25T20:15:00+04:00',
    uid:         'mash-uae-2026-04-25@meetingmindsexperts.github.io'
  };
  var REGISTRATION_URL = 'register.html';

  // ---------- helpers ----------
  function $ (sel, ctx) { return (ctx || document).querySelector(sel); }
  function $$ (sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); }

  function pad (n) { return (n < 10 ? '0' : '') + n; }

  // ---------- footer year ----------
  var yearEl = $('[data-year]');
  if (yearEl) yearEl.textContent = String(new Date().getFullYear());

  // ---------- mobile nav toggle ----------
  var navToggle = $('.nav-toggle');
  var primaryNav = $('#primary-nav');
  if (navToggle && primaryNav) {
    navToggle.addEventListener('click', function () {
      var open = navToggle.getAttribute('aria-expanded') === 'true';
      navToggle.setAttribute('aria-expanded', String(!open));
      navToggle.setAttribute('aria-label', open ? 'Open menu' : 'Close menu');
      primaryNav.classList.toggle('is-open', !open);
    });
    // Close menu when a link is clicked
    $$('#primary-nav a').forEach(function (a) {
      a.addEventListener('click', function () {
        navToggle.setAttribute('aria-expanded', 'false');
        navToggle.setAttribute('aria-label', 'Open menu');
        primaryNav.classList.remove('is-open');
      });
    });
    // Close on resize to desktop
    var mq = window.matchMedia('(min-width: 880px)');
    var onMq = function () {
      if (mq.matches) {
        navToggle.setAttribute('aria-expanded', 'false');
        primaryNav.classList.remove('is-open');
      }
    };
    if (mq.addEventListener) mq.addEventListener('change', onMq); else mq.addListener(onMq);
  }

  // ---------- countdown ----------
  var cd        = $('[data-countdown]');
  var cdDays    = $('[data-cd-days]');
  var cdHours   = $('[data-cd-hours]');
  var cdMins    = $('[data-cd-mins]');
  var cdSecs    = $('[data-cd-secs]');
  var startTs   = new Date(EVENT.start).getTime();
  var endTs     = new Date(EVENT.end).getTime();

  function tick () {
    if (!cd) return;
    var now = Date.now();
    if (now >= endTs) {
      cd.classList.remove('is-live');
      cd.classList.add('is-ended');
      return;
    }
    if (now >= startTs) {
      cd.classList.remove('is-ended');
      cd.classList.add('is-live');
      return;
    }
    cd.classList.remove('is-live', 'is-ended');
    var diff = Math.max(0, startTs - now);
    var d = Math.floor(diff / 86400000);
    var h = Math.floor((diff % 86400000) / 3600000);
    var m = Math.floor((diff % 3600000) / 60000);
    var s = Math.floor((diff % 60000) / 1000);
    if (cdDays)  cdDays.textContent  = pad(d);
    if (cdHours) cdHours.textContent = pad(h);
    if (cdMins)  cdMins.textContent  = pad(m);
    if (cdSecs)  cdSecs.textContent  = pad(s);
  }
  if (cd) {
    tick();
    setInterval(tick, 1000);
  }

  // ---------- register links ----------
  $$('[data-register]').forEach(function (a) {
    if (REGISTRATION_URL && REGISTRATION_URL !== '#register') {
      a.setAttribute('href', REGISTRATION_URL);
      a.setAttribute('target', '_blank');
      a.setAttribute('rel', 'noopener');
    }
  });

  // ---------- add to calendar (.ics) ----------
  function toIcsDate (iso) {
    var d = new Date(iso);
    return d.getUTCFullYear()
         + pad(d.getUTCMonth() + 1)
         + pad(d.getUTCDate())
         + 'T'
         + pad(d.getUTCHours())
         + pad(d.getUTCMinutes())
         + pad(d.getUTCSeconds())
         + 'Z';
  }
  function escIcs (s) {
    return String(s).replace(/\\/g, '\\\\').replace(/;/g, '\\;').replace(/,/g, '\\,').replace(/\r?\n/g, '\\n');
  }
  function buildIcs () {
    var dtStamp = toIcsDate(new Date().toISOString());
    return [
      'BEGIN:VCALENDAR',
      'VERSION:2.0',
      'PRODID:-//Meeting Minds Experts//Wegovy in MASH//EN',
      'CALSCALE:GREGORIAN',
      'METHOD:PUBLISH',
      'BEGIN:VEVENT',
      'UID:' + EVENT.uid,
      'DTSTAMP:' + dtStamp,
      'DTSTART:' + toIcsDate(EVENT.start),
      'DTEND:'   + toIcsDate(EVENT.end),
      'SUMMARY:' + escIcs(EVENT.title),
      'DESCRIPTION:' + escIcs(EVENT.description + '\n\n' + EVENT.url),
      'LOCATION:' + escIcs(EVENT.location),
      'URL:' + EVENT.url,
      'STATUS:CONFIRMED',
      'TRANSP:OPAQUE',
      'BEGIN:VALARM',
      'ACTION:DISPLAY',
      'DESCRIPTION:Wegovy in MASH starts soon',
      'TRIGGER:-PT30M',
      'END:VALARM',
      'END:VEVENT',
      'END:VCALENDAR',
      ''
    ].join('\r\n');
  }
  function downloadIcs () {
    var blob = new Blob([buildIcs()], { type: 'text/calendar;charset=utf-8' });
    var url  = URL.createObjectURL(blob);
    var a    = document.createElement('a');
    a.href     = url;
    a.download = 'wegovy-in-mash-2026.ics';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    setTimeout(function () { URL.revokeObjectURL(url); }, 2500);
  }
  $$('[data-add-to-calendar]').forEach(function (b) {
    b.addEventListener('click', function (e) {
      e.preventDefault();
      try { downloadIcs(); }
      catch (err) {
        // Fallback to the static file
        window.location.href = 'assets/ics/mash-2026.ics';
      }
    });
  });

})();
