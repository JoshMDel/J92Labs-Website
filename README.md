# J92 Labs — website (code rebuild)

Rebuild of [j92labs.co.za](https://j92labs.co.za) off WordPress, in plain PHP/HTML/CSS/JS.
Layout, copy, and section order match the live WordPress site as of Aug 2026 — this
is the same site, just hand-coded instead of Elementor.

## Stack

- Plain HTML/CSS/JS, pages are `.php` only so the header/nav/footer can be shared
  via `require` — there's no framework, build step, database, or admin panel.
- PHP is only used for the shared header/footer includes (and the copyright year).
  There's no server-side form processing — see "Contact" below.
- Any standard shared host that serves PHP (Truehost, same as your other sites) works
  with zero extra setup — no Node, no Composer, no build step.

## Structure

```
index.php               Home
about-us/index.php      About Us
services/index.php      Services
gpt-agents/index.php    GPT Agents
blogs/index.php         Blogs (placeholder — no posts yet, see below)
contact_us/index.php    Contact Us (phone/email/WhatsApp — no on-page form)
partials/header.php     Shared <head>, header, nav
partials/footer.php     Shared footer, closing tags, script include
assets/css/style.css    All styling (single stylesheet, CSS variables at top)
assets/js/main.js       Mobile nav toggle only
assets/images/          Logo, portfolio shots, client logos — pulled from the live site
robots.txt, sitemap.xml Same as the WordPress site
```

## Contact

The old WordPress site had an on-page contact form (Elementor Forms plugin). At the
client's request that form has been **removed** — the Contact page now shows direct
contact info (phone, email, WhatsApp) next to a photo instead. `Get A Quote` /
`Book A Free Consultation` buttons across the site link to `/contact_us/`.

If a form is wanted again later, the previous implementation (a `mail.php` handler
using PHP's `mail()`, with honeypot spam protection and Reply-To set to the visitor's
address) is recoverable from git history — say the word rather than rebuilding from
scratch.

URLs match the old WordPress permalinks exactly (`/about-us/`, `/contact_us/`, etc.)
so nothing breaks for anyone who already has the old links bookmarked or indexed.

## Local preview

PHP's built-in server is enough — no install beyond PHP itself:

```bash
php -S localhost:8000
```

Then open `http://localhost:8000`.

## Deploying to Truehost

See [DEPLOY.md](DEPLOY.md) for the full step-by-step guide — it walks through backing up
and replacing the current live WordPress install with this site, since (unlike the Hair
By Mimmie project, which was added as a second/addon domain) this one takes over
`j92labs.co.za`'s existing primary hosting slot.

## What's intentionally left for later

Per "keep the same layout, add what's needed as we go" — these are stubbed but not
fully built out, since the live WordPress pages for them were themselves mostly empty:

- **Blogs** — no CMS. When you're ready to add posts, either hand-write more `.php`
  files under `/blogs/`, or say the word and I'll wire up a simple flat-file/markdown
  post list.
- **Portfolio items** — currently link to the contact page as placeholders (matching
  what the live site does). Happy to build real case-study pages once you have some.
- **Cookie consent banner** — the WordPress site had one (CookieAdmin plugin). Not
  rebuilt yet; add if you need it for compliance.
- **Analytics** — no GA4/Search Console tag wired in yet.
- **favicon.ico** — currently using `logo.png` as the favicon (works in all modern
  browsers). A dedicated multi-size `.ico` can be generated if you want the exact
  fallback the old site had for older crawlers.
