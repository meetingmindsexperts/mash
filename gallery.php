<?php
$page_title             = 'Gallery · MASH in Focus';
$page_description       = 'MASH in Focus — promo and speaker videos.';
$page_robots            = 'noindex,follow';
$page_body_class        = 'gallery-page resource-page';
$page_brand_href        = 'index.php';
$page_nav_prefix        = 'index.php';
$page_show_register_cta = true;

include __DIR__ . '/partials/header.php';
?>

    <section class="section resource-section" aria-labelledby="gallery-title">
      <div class="container resource-layout">
        <div class="resource-intro">
          <p class="kicker">Gallery</p>
          <h1 id="gallery-title">MASH in Focus</h1>
          <p class="lede" style="margin: 0 auto">Program Promo and a message from the faculty.</p>
        </div>

        <div class="resource-videos">
          <figure class="resource-video-item">
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
            <figcaption>Program Promo</figcaption>
          </figure>

          <figure class="resource-video-item">
            <div class="resource-video">
              <video
                controls
                playsinline
                preload="metadata"
                poster="assets/img/speaker-thumb.png"
                aria-label="MASH in Focus faculty message">
                <source src="https://mashinfocus.com/speakerpromo.mp4" type="video/mp4">
                Your browser does not support the video tag.
                <a href="https://mashinfocus.com/speakerpromo.mp4">Download the speaker video</a>.
              </video>
            </div>
            <figcaption>A Message from the Faculty</figcaption>
          </figure>
        </div>

        <div class="cta-row">
          <a class="btn btn-primary" href="register.php">Register to attend</a>
        </div>
      </div>
    </section>

<?php include __DIR__ . '/partials/footer.php'; ?>
