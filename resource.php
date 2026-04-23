<?php
$page_title             = 'Resources · MASH in Focus';
$page_description       = 'MASH in Focus promotional video and session resources.';
$page_robots            = 'noindex,follow';
$page_body_class        = 'resource-page';
$page_brand_href        = 'index.php';
$page_nav_prefix        = 'index.php';
$page_show_register_cta = true;

include __DIR__ . '/partials/header.php';
?>

    <section class="section resource-section" aria-labelledby="resource-title">
      <div class="container resource-layout">
        <div class="resource-intro">
          <p class="kicker">Resources</p>
          <h1 id="resource-title">MASH in Focus</h1>
          <p class="lede">A short introduction to the upcoming scientific program.</p>
        </div>

        <!-- Promo video — temporarily hidden, do not remove.
        <div class="resource-video">
          <video
            controls
            playsinline
            preload="metadata"
            poster="assets/img/mash-promi-thumb.jpg"
            aria-label="MASH in Focus promotional video">
            <source src="https://mashinfocus.com/promo.mp4" type="video/mp4">
            Your browser does not support the video tag.
            <a href="https://mashinfocus.com/promo.mp4">Download the promo video</a>.
          </video>
        </div>
        -->

        <div class="resource-video">
          <video
            controls
            playsinline
            preload="metadata"
            poster="assets/img/speaker-thumb.png"
            aria-label="MASH in Focus speaker video">
            <source src="https://mashinfocus.com/speakerpromo.mp4" type="video/mp4">
            Your browser does not support the video tag.
            <a href="https://mashinfocus.com/speakerpromo.mp4">Download the speaker video</a>.
          </video>
        </div>

        <div class="cta-row">
          <a class="btn btn-primary" href="register.php">Register to attend</a>
        </div>
      </div>
    </section>

<?php include __DIR__ . '/partials/footer.php'; ?>
