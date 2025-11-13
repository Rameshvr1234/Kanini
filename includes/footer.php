  <!-- Footer area start -->
<footer>
<div class="footer-main bg-color-1">
<div class="footer-top section-space-medium">
<div class="small-container">
<div class="row g-4">
<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
<div class="footer-widget-1">
<figure class="image">
<img alt="Kanini Technology White Logo" src="assets/imgs/logo/logo-white.svg"/>
</figure>
<p class="mt-40 mb-20">Kanini Technology<br/>No 33, Sarojini Street, V.K.K Menon Road, New Siddhapur, Coimbatore 641044<br/>Phone: <a href="tel:+919629988887">+91 96299 88887</a><br/>Email: <a href="mailto:service@kaninitechnology.com">service@kaninitechnology.com</a><br/>Hours: Mon - Sat: 9.30 AM - 7.00 PM</p>
<div class="footer-socials">
<span><a href="#"><i class="fab fa-facebook-f"></i></a></span>
<span><a href="#"><i class="fab fa-twitter"></i></a></span>
<span><a href="#"><i class="fab fa-linkedin-in"></i></a></span>
<span><a href="#"><i class="fab fa-youtube"></i></a></span>
</div>
</div>
</div>
<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
<div class="footer-widget-2 pl-50">
<h4 class="mb-20 footer-title">Our Services</h4>
<ul class="service-list"><li><a href="service-laptop-desktop.html">Laptop &amp; Desktop Repair</a></li><li><a href="service-data-recovery.html">Data Recovery Services</a></li><li><a href="service-tv-projector.html">TV &amp; Projector Repair</a></li><li><a href="service-industrial.html">Industrial Electronics Repair</a></li><li><a href="service-ev.html">EV Chargers &amp; Controllers</a></li></ul>
</div>
</div>
<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
<div class="footer-widget-3">
<h4 class="mb-20 footer-title">Latest Post</h4>
<ul class="blog-list">
<?php
// Get latest 2 posts for footer
if (isset($conn)) {
    $footer_query = "SELECT title, slug, published_at FROM blog_posts WHERE status='published' ORDER BY published_at DESC LIMIT 2";
    $footer_result = $conn->query($footer_query);

    if ($footer_result && $footer_result->num_rows > 0) {
        while ($footer_post = $footer_result->fetch_assoc()) {
            $footer_date = date('d M, Y', strtotime($footer_post['published_at']));
            echo '<li>
                <div class="footer-blog-post-box mb-15">
                    <figure class="thumb">
                        <img alt="" src="assets/imgs/blog/blog-s-1.jpg"/>
                    </figure>
                    <div class="content">
                        <span class="date"><a href="blog-details.php?slug=' . htmlspecialchars($footer_post['slug']) . '">' . $footer_date . '</a></span>
                        <h6><a href="blog-details.php?slug=' . htmlspecialchars($footer_post['slug']) . '">' . htmlspecialchars($footer_post['title']) . '</a></h6>
                    </div>
                </div>
            </li>';
        }
    } else {
        // Fallback if no posts
        echo '<li><div class="footer-blog-post-box mb-15"><figure class="thumb"><img alt="" src="assets/imgs/blog/blog-s-1.jpg"/></figure><div class="content"><span class="date"><a href="#">Recent</a></span><h6><a href="blog-grid.php">Check our latest posts</a></h6></div></div></li>';
    }
}
?>
</ul>
</div>
</div>
<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
<div class="footer-widget-4 pr-30">
<h4 class="mb-20 footer-title">Newsletter</h4>
<p>Sign up for updates, repair tips &amp; seasonal offers.</p>
<div class="footer-subscribe">
<form action="#">
<input name="email" placeholder="Your email address" required="" type="email"/>
<button class="primary-btn-1 btn-hover" type="submit">
                                 SUBSCRIBE NOW
                                 <span style="top: 147.172px; left: 108.5px;"></span>
</button>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="small-container">
<div class="footer-bottom pt-30 pb-30">
<div class="left-area">
<span>&copy; Kanini Technology, Coimbatore - All Rights Reserved.</span>
</div>
<div class="right-area">
<span><a href="#">Terms &amp; Conditions</a></span>
<span><a href="#">Privacy Policy</a></span>
</div>
</div>
</div>
</div>
</footer>
<!-- Footer area end -->
  <script src="assets/js/jquery-3.7.1.min.js"></script>
  <script src="assets/js/waypoints.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/meanmenu.min.js"></script>
  <script src="assets/js/swiper.min.js"></script>
  <script src="assets/js/slick.min.js"></script>
  <script src="assets/js/magnific-popup.min.js"></script>
  <script src="assets/js/counterup.js"></script>
  <script src="assets/js/wow.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
