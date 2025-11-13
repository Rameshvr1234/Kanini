<?php
// Include database configuration
require_once 'admin/config.php';

// Get slug from URL
$slug = isset($_GET['slug']) ? sanitize($_GET['slug']) : '';

if (empty($slug)) {
    header('Location: blog-grid.php');
    exit();
}

// Fetch blog post
$query = "SELECT * FROM blog_posts WHERE slug='$slug' AND status='published'";
$result = $conn->query($query);

if (!$result || $result->num_rows == 0) {
    header('Location: blog-grid.php');
    exit();
}

$post = $result->fetch_assoc();

// Increment view count
$update_views = "UPDATE blog_posts SET views = views + 1 WHERE id=" . $post['id'];
$conn->query($update_views);

// Format date
$post_date = date('d M, Y', strtotime($post['published_at']));

// Get image
$image = $post['featured_image'] ?: 'assets/imgs/blog/default-blog.jpg';
if (strpos($image, 'uploads/') !== false) {
    $image = 'assets/imgs/blog/uploads/' . basename($image);
} else {
    $image = 'assets/imgs/blog/' . $image;
}

// Set page meta information
$page_title = htmlspecialchars($post['title']) . ' | Kanini Technology Blog';
$page_description = htmlspecialchars($post['excerpt'] ?: substr(strip_tags($post['content']), 0, 160));
$canonical_url = 'https://www.kaninitechnology.com/blog-details.php?slug=' . urlencode($post['slug']);
$og_image = 'https://www.kaninitechnology.com/' . $image;

// Get related posts from same category
$related_query = "SELECT * FROM blog_posts
                  WHERE category='" . $post['category'] . "'
                  AND id != " . $post['id'] . "
                  AND status='published'
                  ORDER BY published_at DESC LIMIT 3";
$related_result = $conn->query($related_query);

// Include header
include 'includes/header.php';
?>

<main>

<!-- Breadcrumb area start -->
<div class="breadcrumb__area theme-bg-1 p-relative pt-160 pb-160">
   <div class="breadcrumb__thumb" data-background="<?php echo htmlspecialchars($image); ?>" aria-label="<?php echo htmlspecialchars($post['title']); ?>"></div>
   <div class="breadcrumb__thumb_2" data-background="assets/imgs/resources/page-title-bg-2.png"></div>
   <div class="small-container">
      <div class="row justify-content-center">
         <div class="col-xxl-12">
            <div class="breadcrumb__wrapper p-relative">
               <h1 class="breadcrumb__title">Blog Details</h1>
               <div class="breadcrumb__menu">
                  <nav>
                     <ul>
                        <li><span><a href="index.html">Home</a></span></li>
                        <li><span><a href="blog-grid.php">Blog</a></span></li>
                        <li><span>Blog Details</span></li>
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Breadcrumb area end -->

<section class="blog-details-page section-space">
   <div class="small-container">
      <div class="row">
         <div class="col-xxl-8 col-xl-8 col-lg-8">
            <figure class="blog-thumb w-img">
               <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
            </figure>
            <ul class="blog-post-meta mb-20 mt-40">
               <li><a href="#"><i class="fal fa-user"></i>By <?php echo htmlspecialchars($post['author']); ?></a></li>
               <li><a href="#"><i class="fal fa-calendar-days"></i><?php echo $post_date; ?></a></li>
               <li><a href="blog-grid.php?category=<?php echo urlencode($post['category']); ?>"><i class="fal fa-tag"></i><?php echo htmlspecialchars($post['category']); ?></a></li>
               <li><a href="#"><i class="fal fa-eye"></i><?php echo $post['views']; ?> Views</a></li>
            </ul>
            <hr>
            <h3 class="blog-details-title mb-30 mt-20"><?php echo htmlspecialchars($post['title']); ?></h3>

            <div class="blog-content-area">
               <?php echo $post['content']; ?>
            </div>

            <div class="postbox__share-wrapper mb-60 mt-60">
               <div class="row g-4 align-items-center">
                  <div class="col-xl-7 col-lg-12">
                     <div class="postbox__tag tagcloud">
                        <span>Tags:</span>
                        <?php
                        if ($post['tags']) {
                            $tags = explode(',', $post['tags']);
                            foreach ($tags as $tag) {
                                echo '<a href="#">' . htmlspecialchars(trim($tag)) . '</a> ';
                            }
                        } else {
                            echo '<a href="#">' . htmlspecialchars($post['category']) . '</a>';
                        }
                        ?>
                     </div>
                  </div>
                  <div class="col-xl-5 col-lg-12">
                     <div class="postbox__share text-lg-end">
                        <span>Share:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($canonical_url); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($canonical_url); ?>&text=<?php echo urlencode($post['title']); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($canonical_url); ?>&title=<?php echo urlencode($post['title']); ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($post['title'] . ' - ' . $canonical_url); ?>" target="_blank"><i class="fab fa-whatsapp"></i></a>
                     </div>
                  </div>
               </div>
            </div>

            <div class="postbox__navigation d-none d-md-flex justify-content-between align-items-center mb-60">
               <?php
               // Get previous post
               $prev_query = "SELECT slug, title FROM blog_posts WHERE status='published' AND published_at < '" . $post['published_at'] . "' ORDER BY published_at DESC LIMIT 1";
               $prev_result = $conn->query($prev_query);
               if ($prev_result && $prev_result->num_rows > 0) {
                   $prev_post = $prev_result->fetch_assoc();
                   echo '<div class="postbox__navigation-item">
                           <a href="blog-details.php?slug=' . htmlspecialchars($prev_post['slug']) . '">
                              <span><i class="fal fa-arrow-left"></i> Previous Post</span>
                              <h5>' . htmlspecialchars($prev_post['title']) . '</h5>
                           </a>
                         </div>';
               }

               // Get next post
               $next_query = "SELECT slug, title FROM blog_posts WHERE status='published' AND published_at > '" . $post['published_at'] . "' ORDER BY published_at ASC LIMIT 1";
               $next_result = $conn->query($next_query);
               if ($next_result && $next_result->num_rows > 0) {
                   $next_post = $next_result->fetch_assoc();
                   echo '<div class="postbox__navigation-item text-end">
                           <a href="blog-details.php?slug=' . htmlspecialchars($next_post['slug']) . '">
                              <span>Next Post <i class="fal fa-arrow-right"></i></span>
                              <h5>' . htmlspecialchars($next_post['title']) . '</h5>
                           </a>
                         </div>';
               }
               ?>
            </div>
         </div>

         <div class="col-xxl-4 col-xl-4 col-lg-4">
            <div class="sidebar-widget-wrapper pl-20">

               <!-- Search Widget -->
               <div class="sidebar-widget mb-40">
                  <h4 class="sidebar-widget-title mb-25">Search</h4>
                  <div class="sidebar-search">
                     <form action="blog-grid.php" method="get">
                        <input type="text" name="search" placeholder="Search posts...">
                        <button type="submit"><i class="fal fa-search"></i></button>
                     </form>
                  </div>
               </div>

               <!-- Categories Widget -->
               <div class="sidebar-widget mb-40">
                  <h4 class="sidebar-widget-title mb-25">Categories</h4>
                  <div class="sidebar-category">
                     <ul>
                        <?php
                        $cat_query = "SELECT category, COUNT(*) as count FROM blog_posts WHERE status='published' GROUP BY category ORDER BY category";
                        $cat_result = $conn->query($cat_query);
                        if ($cat_result && $cat_result->num_rows > 0) {
                            while ($cat = $cat_result->fetch_assoc()) {
                                echo '<li><a href="blog-grid.php?category=' . urlencode($cat['category']) . '">' . htmlspecialchars($cat['category']) . ' <span>(' . $cat['count'] . ')</span></a></li>';
                            }
                        }
                        ?>
                     </ul>
                  </div>
               </div>

               <!-- Recent Posts Widget -->
               <?php if ($related_result && $related_result->num_rows > 0): ?>
               <div class="sidebar-widget mb-40">
                  <h4 class="sidebar-widget-title mb-25">Related Posts</h4>
                  <div class="sidebar-post">
                     <?php while ($related_post = $related_result->fetch_assoc()):
                        $related_date = date('d M, Y', strtotime($related_post['published_at']));
                        $related_image = $related_post['featured_image'] ?: 'default-blog.jpg';
                        if (strpos($related_image, 'uploads/') !== false) {
                            $related_image = 'assets/imgs/blog/uploads/' . basename($related_image);
                        } else {
                            $related_image = 'assets/imgs/blog/' . $related_image;
                        }
                     ?>
                     <div class="sidebar-post-item mb-20">
                        <div class="sidebar-post-thumb">
                           <a href="blog-details.php?slug=<?php echo htmlspecialchars($related_post['slug']); ?>">
                              <img src="<?php echo htmlspecialchars($related_image); ?>" alt="<?php echo htmlspecialchars($related_post['title']); ?>">
                           </a>
                        </div>
                        <div class="sidebar-post-content">
                           <span><?php echo $related_date; ?></span>
                           <h6><a href="blog-details.php?slug=<?php echo htmlspecialchars($related_post['slug']); ?>"><?php echo htmlspecialchars($related_post['title']); ?></a></h6>
                        </div>
                     </div>
                     <?php endwhile; ?>
                  </div>
               </div>
               <?php endif; ?>

               <!-- Contact Widget -->
               <div class="sidebar-widget">
                  <div class="sidebar-contact" style="background-image: url('assets/imgs/resources/sidebar-contact-bg.jpg'); background-size: cover; padding: 40px 30px; border-radius: 8px;">
                     <div class="sidebar-contact-inner text-center">
                        <h4 class="text-white mb-20">Need Help?</h4>
                        <p class="text-white mb-25">Contact Kanini Technology for chip-level repairs and IT services</p>
                        <a href="tel:+919629988887" class="primary-btn-1 btn-hover">Call Now<span></span></a>
                     </div>
                  </div>
               </div>

            </div>
         </div>
      </div>
   </div>
</section>

</main>

<?php
// Include footer
include 'includes/footer.php';

// Close database connection
$conn->close();
?>
