<?php
/**
 * Decorative, aria-hidden layered background "scene" for hero-type sections.
 *
 * Purely visual — contributes zero content, headings, text, or links, so it
 * is safe to share across every page without affecting copy or SEO.
 *
 * Usage (inside a .hero / .page-hero / .svc-hero section, before its
 * .container):
 *   <?php $scene_variant = 'full'; require $_SERVER['DOCUMENT_ROOT'] . '/partials/hero-scene.php'; ?>
 *
 * $scene_variant:
 *   'full'    — homepage hero: the primary cinematic experience, more
 *               particles, fuller-strength glow/terrain.
 *   'compact' — every other page's hero: same layer system, quieter/fewer
 *               particles, for visual continuity without competing with
 *               that page's own content.
 */

$scene_variant = isset($scene_variant) && $scene_variant === 'full' ? 'full' : 'compact';
$scene_particle_count = $scene_variant === 'full' ? 46 : 20;
$scene_class = $scene_variant === 'full' ? 'hero-scene' : 'hero-scene hero-scene--compact';
?>
<div class="<?php echo $scene_class; ?>" data-parallax-scene data-particle-count="<?php echo (int) $scene_particle_count; ?>" aria-hidden="true">
  <div class="scene-floor" data-depth="0.18"></div>
  <div class="scene-grid" data-depth="0.28"></div>
  <canvas class="scene-particles"></canvas>
  <div class="scene-glow scene-glow--orange" data-depth="0.5"></div>
  <div class="scene-glow scene-glow--purple" data-depth="0.36"></div>
</div>
<?php $scene_variant = null; ?>
