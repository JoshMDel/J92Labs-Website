<?php
$page_title = 'Blogs';
$meta_description = 'Insights on SEO, website development, and growing a small business online, from J92 Labs in Oudtshoorn.';
require $_SERVER['DOCUMENT_ROOT'] . '/partials/header.php';
?>

<section class="page-hero">
  <div class="container">
    <p class="breadcrumbs"><a href="/">Home</a> / Blogs</p>
    <div class="eyebrow"><span class="line"></span>Blogs</div>
    <h1>Insights On SEO, Websites &amp; Growing Your Business</h1>
    <p class="lead">Practical, no-nonsense articles for small businesses in Oudtshoorn and the Eden Karoo region.</p>
  </div>
</section>

<section>
  <div class="container">
    <!--
      New posts: add a card below (copy the .card block) once articles are ready,
      or wire this section up to a simple JSON/markdown-driven list later.
    -->
    <div class="card" style="max-width: 620px;">
      <h3>New articles coming soon</h3>
      <div class="rule"></div>
      <p>We're working on our first set of posts covering local SEO, website performance, and practical growth tips for small businesses. Check back soon &mdash; or <a href="/contact_us/" style="color: var(--orange);">get in touch</a> if you have a question you'd like us to cover.</p>
    </div>
  </div>
</section>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/partials/footer.php'; ?>
