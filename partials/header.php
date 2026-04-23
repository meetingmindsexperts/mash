<?php
// ---------------------------------------------------------------------------
// Pre-launch gate
// ---------------------------------------------------------------------------
// Flip $LAUNCHED = true when the site goes live. While false, every page that
// includes this header is replaced with partials/coming-soon.php, except for
// register.php (early sign-ups via direct link still work) and visitors who
// arrive with ?preview=<token> (stakeholder preview, persisted in a cookie).
$LAUNCHED       = true;
$PREVIEW_TOKEN  = 'mash2026';
$PREVIEW_COOKIE = 'mash_preview';

if (!$LAUNCHED) {
    if (isset($_GET['preview']) && hash_equals($PREVIEW_TOKEN, (string) $_GET['preview'])) {
        setcookie($PREVIEW_COOKIE, $PREVIEW_TOKEN, [
            'expires'  => time() + 60 * 60 * 24 * 7,
            'path'     => '/',
            'secure'   => !empty($_SERVER['HTTPS']),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        $preview_ok = true;
    } else {
        $preview_ok = isset($_COOKIE[$PREVIEW_COOKIE])
            && hash_equals($PREVIEW_TOKEN, (string) $_COOKIE[$PREVIEW_COOKIE]);
    }

    $script      = basename($_SERVER['SCRIPT_NAME'] ?? '');
    $is_register = in_array($script, ['register.php'], true);

    if (!$preview_ok && !$is_register) {
        header('X-Robots-Tag: noindex, nofollow', true);
        include __DIR__ . '/coming-soon.php';
        exit;
    }
}
// ---------------------------------------------------------------------------
// Shared page header. Set any of these before `include`-ing this file:
//   $page_title              string
//   $page_description        string
//   $page_robots             string (default: index,follow,max-image-preview:large)
//   $page_body_class         string (default: '')
//   $page_brand_href         string (default: '#top')
//   $page_nav_prefix         string — prepended to nav anchors (default: '')
//   $page_show_register_cta  bool   (default: true)
//   $page_preload_head       string — additional <link rel="preload"> tags
//   $page_extra_head         string — page-specific OG / JSON-LD / canonical tags

$page_title             = $page_title             ?? 'MASH in Focus';
$page_description       = $page_description       ?? '';
$page_robots            = $page_robots            ?? 'index,follow,max-image-preview:large';
$page_body_class        = $page_body_class        ?? '';
$page_brand_href        = $page_brand_href        ?? '#top';
$page_nav_prefix        = $page_nav_prefix        ?? '';
$page_show_register_cta = $page_show_register_cta ?? true;
$page_preload_head      = $page_preload_head      ?? '';
$page_extra_head        = $page_extra_head        ?? '';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="theme-color" content="#e6007e">
  <meta name="color-scheme" content="light">

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-HH081LKK8Q"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-HH081LKK8Q');
  </script>

  <title><?= htmlspecialchars($page_title, ENT_QUOTES) ?></title>
  <meta name="description" content="<?= htmlspecialchars($page_description, ENT_QUOTES) ?>">
  <meta name="robots" content="<?= htmlspecialchars($page_robots, ENT_QUOTES) ?>">

  <!-- Favicons -->
  <link rel="icon" href="favicon.svg" type="image/svg+xml">
  <link rel="icon" href="favicon.png" type="image/png" sizes="256x256">
  <link rel="icon" href="favicon-32.png" type="image/png" sizes="32x32">
  <link rel="apple-touch-icon" href="favicon.png">

  <!-- Preload key assets -->
  <?= $page_preload_head ?>
  <link rel="preload" as="style" href="assets/css/styles.css">
  <link rel="stylesheet" href="assets/css/styles.css">

  <?= $page_extra_head ?>
</head>
<body<?= $page_body_class ? ' class="' . htmlspecialchars($page_body_class, ENT_QUOTES) . '"' : '' ?>>

  <a class="skip-link" href="#main">Skip to content</a>

  <header class="site-header" id="top">
    <div class="container nav-bar">
      <a class="brand" href="<?= htmlspecialchars($page_brand_href, ENT_QUOTES) ?>" aria-label="MASH in Focus — home">
        <img class="brand-mark" src="assets/img/mash.png" alt="" width="200" height="auto" aria-hidden="true">
      </a>
      <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-nav" aria-label="Open menu">
        <svg class="nav-toggle-icon nav-toggle-open" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
          <line x1="4" y1="7" x2="20" y2="7"></line>
          <line x1="4" y1="12" x2="20" y2="12"></line>
          <line x1="4" y1="17" x2="20" y2="17"></line>
        </svg>
        <svg class="nav-toggle-icon nav-toggle-close" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
          <line x1="6" y1="6" x2="18" y2="18"></line>
          <line x1="18" y1="6" x2="6" y2="18"></line>
        </svg>
      </button>
      <nav class="primary-nav" id="primary-nav" aria-label="Primary">
        <ul>
          <li><a href="<?= htmlspecialchars($page_nav_prefix, ENT_QUOTES) ?>#about">About</a></li>
          <li><a href="<?= htmlspecialchars($page_nav_prefix, ENT_QUOTES) ?>#speakers">Speakers</a></li>
          <li><a href="<?= htmlspecialchars($page_nav_prefix, ENT_QUOTES) ?>#agenda">Agenda</a></li>
          <li><a href="gallery.php">Gallery</a></li>
          <?php if ($page_show_register_cta): ?>
          <li><a class="nav-cta" href="register.php" data-register>Register</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>

  <main id="main">
