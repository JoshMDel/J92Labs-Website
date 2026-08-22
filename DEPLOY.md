# Going Live On Truehost (replacing the current WordPress site)

This deploys **j92labs.co.za itself** — not a second site alongside it. Right now
`public_html` on your Truehost account holds the live WordPress installation; this guide
replaces what's in there with this rebuilt site.

> If it turns out `j92labs.co.za` is actually set up as an **addon domain** on this hosting
> account rather than the primary `public_html` site (e.g. if some other site occupies
> `public_html` root), just swap every `public_html` reference below for that addon domain's
> own folder — everything else in this guide still applies the same way.

## Step 0 — Back up the current WordPress site first

Non-negotiable before touching anything live:

1. cPanel → **Backup Wizard** (or **Backup**) → download a **Full Backup**. Or, at minimum:
   - **Files**: File Manager → select everything in `public_html` → **Compress** → download
     the resulting zip.
   - **Database**: phpMyAdmin → select the WordPress database → **Export** → download the `.sql` file.
2. Save both somewhere off the server (your PC, cloud storage). You won't need WordPress again
   once this is live, but "don't need" and "definitely never" are different bars for a live
   business site — keep the backup for a few months regardless.

## Step 1 — Clear out `public_html`

1. In cPanel **File Manager**, navigate to `public_html`.
2. Select everything currently inside (`wp-admin`, `wp-content`, `wp-includes`, `wp-config.php`,
   `.htaccess`, `index.php`, all of it) and delete it — you already have the backup from Step 0.
   - Softer alternative: rename the whole `public_html` folder to something like
     `public_html-wp-backup` and create a fresh empty `public_html` in its place. Same safety
     net, easier one-click undo if something looks wrong later.
3. `public_html` should now be empty.

## Step 2 — Upload the new site

You're uploading everything in this project folder:

```
J92Labs/
├── index.php
├── about-us/index.php
├── services/index.php
├── gpt-agents/index.php
├── blogs/index.php
├── contact_us/index.php
├── partials/
├── assets/
├── robots.txt
├── sitemap.xml
└── (README.md, DEPLOY.md, .gitignore are just notes for you — no need to upload them)
```

**Option A — cPanel File Manager (easiest, no extra software)**
1. Zip the `J92Labs` folder on your PC (right-click → "Compress to ZIP").
2. In File Manager, make sure you're inside `public_html`, then **Upload** that zip.
3. Back in File Manager, right-click the uploaded zip → **Extract**.
4. Confirm `index.php` etc. end up directly inside `public_html/` — not nested one level
   deeper inside a folder called `J92Labs`. If it extracted into a subfolder, select everything
   inside that subfolder, cut, paste it up one level into `public_html`, then delete the
   now-empty subfolder and the zip file.

**Option B — FTP/SFTP**
1. cPanel → **FTP Accounts** (create a dedicated user, or use your main account over SFTP).
2. Connect with FileZilla, navigate to `public_html` on the server side, and drag in the
   *contents* of the `J92Labs` folder (not the folder itself).

End result: `public_html/index.php`, `public_html/assets/`, `public_html/about-us/index.php`,
`public_html/services/index.php`, and so on — directly inside `public_html`, no extra nesting.

## Step 3 — Confirm PHP is enabled

Standard on Truehost shared hosting, but worth a quick check: cPanel → **MultiPHP Manager**,
confirm `j92labs.co.za` is set to a supported PHP version. Anything PHP 7.4 or newer (including
8.x) works fine — nothing in this codebase depends on a specific version.

## Step 4 — Test everything

Visit `https://j92labs.co.za` fresh (hard-refresh or incognito — your browser, and any
caching layer in front of the site, may still be holding old WordPress pages) and check:

- [ ] Homepage loads: hero, services, "How We Work", portfolio, about, client logos, footer
- [ ] Nav works on all 6 pages, including the mobile hamburger menu, with the current page underlined
- [ ] `/about-us/` shows the full About page (story, stats, values)
- [ ] `/services/` shows the pricing page (packages, add-ons, and the FAQ accordion expands/collapses)
- [ ] `/gpt-agents/` and `/blogs/` load correctly
- [ ] `/contact_us/` shows the phone / email / WhatsApp info card next to the image, and each
      link works (`tel:`, `mailto:`, `wa.me`)
- [ ] `https://j92labs.co.za/robots.txt` loads
- [ ] `https://j92labs.co.za/sitemap.xml` loads and lists all 6 pages
- [ ] The browser tab icon shows the J92 Labs logo
- [ ] `/wp-admin/` and `/wp-login.php` no longer resolve — confirms WordPress is fully gone (expected and fine)
- [ ] The padlock/HTTPS still shows secure — should carry over automatically since SSL was
      already active on this domain (no new certificate step needed, unlike adding a brand
      new addon domain)

## Step 5 — Re-submit to Google Search Console

The domain isn't changing, so your existing Search Console property stays exactly as-is — no
new ownership verification needed. Just:

1. Go to [Google Search Console](https://search.google.com/search-console) and select the
   `j92labs.co.za` property.
2. **Sitemaps** → resubmit `sitemap.xml`. Even though the URL is unchanged, prompting a
   re-crawl helps Google notice the page content changed.
3. Optionally, **URL Inspection** → "Request Indexing" on the homepage to speed things up.
4. Check back in a few days. Since every URL (`/about-us/`, `/services/`, `/contact_us/`, etc.)
   is identical to the old WordPress permalinks, you're updating content at the same addresses
   rather than moving anything — existing rankings should carry over rather than reset.

## After launch

- Old WordPress media URLs (`wp-content/uploads/...`) will start 404ing — nothing on the new
  site links to them (all images were re-hosted under `/assets/images/`), but if any of those
  exact image URLs were shared externally (social posts, etc.), those specific links will break.
  Not fixable without keeping WordPress running, and not worth doing just for that.
- The contact **form** was intentionally removed (phone/email/WhatsApp are shown instead) — if
  you ever want it back, the previous implementation is documented as recoverable from git
  history in the project [README](README.md).
- Nothing here needs a database. If, a few months in, you're confident you'll never touch
  WordPress again, the old database from Step 0 can be dropped from MySQL — no rush on that.
