<?php
$page_title = 'Contact Us';
$meta_description = 'Get in touch with J92 Labs for website development and SEO services in Oudtshoorn and the Eden Karoo region.';
require $_SERVER['DOCUMENT_ROOT'] . '/partials/header.php';
?>

<section class="page-hero">
  <?php $scene_variant = 'compact'; require $_SERVER['DOCUMENT_ROOT'] . '/partials/hero-scene.php'; ?>
  <div class="container">
    <p class="breadcrumbs"><a href="/">Home</a> / Contact Us</p>
    <div class="eyebrow" data-reveal><span class="line"></span>Get In Touch</div>
    <h1 data-reveal>Contact Us</h1>
    <p class="lead" data-reveal>J92 Labs builds fast, reliable websites for businesses in Oudtshoorn and provides SEO services that help improve visibility, traffic, and leads. We work with small businesses across the Eden Karoo region to create practical, high-performing websites designed for long-term growth.</p>
  </div>
</section>

<section>
  <div class="container">
    <div class="contact-grid" data-reveal-group>
      <div class="contact-image" data-reveal>
        <img src="/assets/images/hero-quote.jpg" alt="J92 Labs — website development and SEO" loading="lazy">
      </div>

      <div class="contact-info-card" data-reveal>
        <div class="item">
          <span>Phone</span>
          <a href="tel:+27847466010">+27 84 746 6010</a>
        </div>
        <div class="item">
          <span>Email</span>
          <a href="mailto:info@j92labs.co.za">info@j92labs.co.za</a>
        </div>
        <div class="item">
          <span>Based In</span>
          <p>Oudtshoorn, Eden Karoo, South Africa</p>
        </div>
        <div class="item">
          <span>Chat</span>
          <a class="whatsapp-link" href="https://wa.me/27847466010" target="_blank" rel="noopener">💬 WhatsApp Us</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/partials/footer.php'; ?>
