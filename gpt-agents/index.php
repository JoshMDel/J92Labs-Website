<?php
$page_title = 'GPT Agents';
$meta_description = 'Explore specialized GPT Agents for SEO, content creation, marketing, research and business productivity from J92 Labs.';
require $_SERVER['DOCUMENT_ROOT'] . '/partials/header.php';

$agents = [
    ['name' => 'SEO GPT', 'desc' => 'Keyword research, content planning and SEO strategy.'],
    ['name' => 'Content GPT', 'desc' => 'Blog writing, website copy and content briefs.'],
    ['name' => 'Marketing GPT', 'desc' => 'Campaign ideas, social media content and ad copy.'],
    ['name' => 'Research Agent', 'desc' => 'Market research, competitor analysis and insights.'],
    ['name' => 'Business Strategy Agent', 'desc' => 'Business planning, growth opportunities and process improvement.'],
    ['name' => 'Website Content GPT', 'desc' => 'Landing pages, FAQs and optimized website content.'],
];
?>

<section class="page-hero">
  <div class="container">
    <p class="breadcrumbs"><a href="/">Home</a> / GPT Agents</p>
    <div class="eyebrow"><span class="line"></span>About GPT Agents</div>
    <h1>GPT Agents Built To Help You Work Smarter And Faster</h1>
    <p class="lead">Explore specialized GPT Agents for SEO, content creation, marketing, research and business productivity. Find the right AI assistant for the task at hand.</p>
    <a class="btn btn-primary" href="/contact_us/">Contact Us</a>
  </div>
</section>

<section>
  <div class="container">
    <div class="eyebrow"><span class="line"></span>AI Business Tools Built For Real Work</div>
    <h2 class="section-heading">Featured GPT Agents</h2>
    <p style="max-width:620px;">Our GPT Agents are purpose-built AI assistants designed to handle specific tasks with precision. From SEO and marketing to content and strategy, each tool helps you save time, improve results, and grow your business.</p>
    <div class="content-grid" style="margin-top: 40px;">
      <?php foreach ($agents as $agent): ?>
      <div class="card">
        <h3><?php echo htmlspecialchars($agent['name']); ?></h3>
        <div class="rule"></div>
        <p><?php echo htmlspecialchars($agent['desc']); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="about-section">
  <div class="container">
    <div class="eyebrow"><span class="line"></span>Why Choose Us</div>
    <h2 class="section-heading">Built For Real Business Results</h2>
    <p style="max-width:620px;">Our GPT agents are designed to solve real business problems, save time and deliver measurable impact across your entire workflow. Practical, powerful and built for growth.</p>
  </div>
</section>

<section class="cta-strip">
  <div class="container">
    <h2>Want a GPT Agent built for your business?</h2>
    <p>Tell us the task you want to speed up and we'll help you find or build the right agent for it.</p>
    <a class="btn btn-primary" href="/contact_us/">Get a Quote</a>
  </div>
</section>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/partials/footer.php'; ?>
