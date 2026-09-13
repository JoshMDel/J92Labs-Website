<?php
/**
 * Site header + primary navigation.
 * Included via: require $_SERVER['DOCUMENT_ROOT'] . '/partials/header.php';
 * Expects an optional $page_title / $meta_description set by the calling page.
 */

$current_path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') . '/';
if ($current_path === '') {
    $current_path = '/';
}

$nav_items = [
    '/'            => 'Home',
    '/about-us/'   => 'About Us',
    '/services/'   => 'Services',
    '/gpt-agents/' => 'GPT Agents',
    '/blogs/'      => 'Blogs',
    '/contact_us/' => 'Contact Us',
];

$site_title = isset($page_title) ? $page_title . ' | J92 Labs' : 'J92 Labs | SEO & Website Development Oudtshoorn';
$site_description = isset($meta_description)
    ? $meta_description
    : 'J92 Labs builds fast, reliable websites and SEO services for small businesses in Oudtshoorn and the Eden Karoo region.';
?>
<!DOCTYPE html>
<html lang="en-ZA">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($site_title); ?></title>
<meta name="description" content="<?php echo htmlspecialchars($site_description); ?>">
<link rel="icon" type="image/png" href="/assets/images/logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/style.css">
<link rel="stylesheet" href="/assets/css/animations.css">
<!-- Microsoft Clarity -->
<script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "y6zpvk39u5");
</script>
</head>
<body>
<!-- Persistent decorative background, shared across every page/section.
     Purely visual: aria-hidden, no content, sits behind everything via a
     fixed position + negative z-index (see animations.css). -->
<div class="ambient-bg" aria-hidden="true">
  <canvas></canvas>
  <div class="ambient-glow ambient-glow--orange"></div>
  <div class="ambient-glow ambient-glow--purple"></div>
  <div class="ambient-grid"></div>
</div>
<header class="site-header">
  <div class="container">
    <a class="logo" href="/" aria-label="J92 Labs home">
      <img src="/assets/images/logo.png" alt="J92 Labs logo">
    </a>
    <nav class="main-nav" aria-label="Primary">
      <ul>
        <?php foreach ($nav_items as $href => $label): ?>
        <li>
          <a href="<?php echo $href; ?>"<?php echo $current_path === $href ? ' aria-current="page"' : ''; ?>><?php echo $label; ?></a>
        </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <div class="header-actions">
      <a class="btn btn-primary" href="mailto:info@j92labs.co.za">Get In Touch</a>
      <button class="nav-toggle" aria-label="Toggle menu" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>
<main>
