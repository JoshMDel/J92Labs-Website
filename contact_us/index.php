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
          <a class="whatsapp-link" href="https://wa.me/27847466010" target="_blank" rel="noopener">
            <svg class="icon-whatsapp" aria-hidden="true" viewBox="0 0 24 24" fill="currentColor"><path d="M17.5 14.4c-.3-.1-1.7-.8-2-.9-.3-.1-.5-.1-.6.1-.2.3-.7.9-.9 1-.2.2-.3.2-.6.1-.3-.1-1.2-.4-2.3-1.4-.9-.8-1.4-1.7-1.6-2-.2-.3 0-.5.1-.6.1-.1.3-.3.4-.5.1-.1.2-.3.3-.4.1-.2 0-.4 0-.5C10.2 9 9.8 8 9.6 7.6c-.2-.4-.3-.4-.5-.4h-.5c-.2 0-.5.1-.7.3-.2.3-.9.9-.9 2.1s.9 2.5 1 2.6c.1.2 1.8 2.8 4.4 3.9.6.3 1.1.4 1.5.5.6.2 1.2.2 1.6.1.5-.1 1.7-.7 1.9-1.3.2-.6.2-1.2.2-1.3-.1-.2-.3-.2-.6-.3zM12 2a10 10 0 00-8.6 15L2 22l5.2-1.4A10 10 0 1012 2z"/></svg>
            WhatsApp Us
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/partials/footer.php'; ?>
