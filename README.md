# MASH in Focus — Landing Page

Static landing page for **MASH in Focus: Integrating Metabolic and Hepatic Care in the UAE**, a virtual scientific program on **25 April 2026, 6:00 – 8:15 PM (GST)**, sponsored by Novo Nordisk.

- **Live (staging):** https://meetingmindsexperts.github.io/mash/
- **Production:** HostGator dedicated server (FTP — credentials TBD)
- **Stack:** Plain HTML / CSS / JS — no build step.

## Local preview

```sh
cd mash
python3 -m http.server 8000
# open http://localhost:8000
```

## File layout

```
.
├── index.html                       # Single-page landing page
├── assets/
│   ├── css/styles.css               # All styles, mobile-first
│   ├── js/main.js                   # Countdown, .ics generator, mobile nav
│   ├── img/                         # Hero, speakers, logos, OG cover
│   └── ics/mash-2026.ics            # Static calendar invite (fallback)
├── favicon.png / favicon-32.png
├── robots.txt
├── sitemap.xml
├── .nojekyll                        # Tells GitHub Pages to serve files as-is
└── .github/workflows/deploy-pages.yml
```

## Editing content

All event metadata lives in two places:

- `index.html` — visible content + JSON-LD `Event` schema in `<head>`.
- `assets/js/main.js` — `EVENT` constant (used for the countdown and `.ics` generator) and the `REGISTRATION_URL` constant.

To wire the **real registration link** when ready: edit the `REGISTRATION_URL` constant at the top of `assets/js/main.js`. The script will rewrite every `[data-register]` link automatically (and add `target="_blank"`).

## Deployment

### Staging — GitHub Pages (automatic)

`.github/workflows/deploy-pages.yml` deploys on every push to `main`.

One-time setup in the repo:
1. Push to `main` (creates the workflow run).
2. **Repo settings → Pages → Build and deployment → Source: GitHub Actions.**
3. The next push (or re-run) will publish at `https://meetingmindsexperts.github.io/mash/`.

### Production — HostGator (FTP)

To be added once FTP credentials are available. The recommended approach:

1. Add repository secrets: `FTP_SERVER`, `FTP_USERNAME`, `FTP_PASSWORD`, `FTP_SERVER_DIR`.
2. Add `.github/workflows/deploy-ftp.yml` using `SamKirkland/FTP-Deploy-Action@v4`, triggered on release tag (or `workflow_dispatch`).
3. Tagging a release deploys to production; pushes to `main` only update staging.

## Compliance

The page surfaces the verbatim Novo Nordisk / UAE HCP-only disclaimer in the footer along with the promo code `AE26SEMO00056`. The `og:locale` is `en_AE`. Audience is healthcare professionals only.

## Verification checklist

- [ ] Lighthouse ≥ 95 on Performance / Accessibility / Best Practices / SEO.
- [ ] JSON-LD validates at <https://validator.schema.org/>.
- [ ] `Add to calendar` downloads a valid `.ics`.
- [ ] Countdown shows the correct time-to-event.
- [ ] Page renders cleanly at 360px wide with no horizontal scroll.
- [ ] Footer disclaimer matches the Save the Date PDF verbatim.
