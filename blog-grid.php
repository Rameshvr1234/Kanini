<?php
// Include database configuration
require_once 'admin/config.php';

// Set page meta information
$page_title = 'Kanini Technology Blog & Repair Tips | Kanini Technology Coimbatore';
$page_description = 'Repair insights from Kanini Technology: laptop care, data safety, industrial maintenance and EV controller tips for businesses in Coimbatore and Tamil Nadu.';
$canonical_url = 'https://www.kaninitechnology.com/blog-grid.php';

// Pagination settings
$posts_per_page = 9;
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($current_page - 1) * $posts_per_page;

// Get category filter
$category_filter = isset($_GET['category']) ? sanitize($_GET['category']) : '';

// Build query
$where_clause = "WHERE status='published'";
if ($category_filter) {
    $where_clause .= " AND category='" . $category_filter . "'";
}

// Get total posts count
$count_query = "SELECT COUNT(*) as total FROM blog_posts $where_clause";
$count_result = $conn->query($count_query);
$total_posts = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_posts / $posts_per_page);

// Get posts for current page
$query = "SELECT * FROM blog_posts $where_clause ORDER BY published_at DESC LIMIT $offset, $posts_per_page";
$result = $conn->query($query);

// Get all categories for filter
$categories_query = "SELECT DISTINCT category FROM blog_posts WHERE status='published' ORDER BY category";
$categories_result = $conn->query($categories_query);

// Include header
include 'includes/header.php';
?>

  <main>
    <div class="breadcrumb__area theme-bg-1 p-relative pt-160 pb-160">
      <div class="breadcrumb__thumb" data-background="assets/imgs/resources/page-title-bg-1.png"></div>
      <div class="breadcrumb__thumb_2" data-background="assets/imgs/resources/page-title-bg-2.png"></div>
      <div class="small-container">
        <div class="row justify-content-center">
          <div class="col-xxl-12">
            <div class="breadcrumb__wrapper p-relative text-center">
              <h1 class="breadcrumb__title">Kanini Insights</h1>
              <div class="breadcrumb__menu"><nav><ul><li><span><a href="index.html">Home</a></span></li><li><span>Blog</span></li></ul></nav></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="blog-section section-space">
      <div class="small-container">

        <!-- Category Filter -->
        <?php if ($categories_result && $categories_result->num_rows > 0): ?>
        <div class="row mb-40">
          <div class="col-12">
            <div class="blog-category-filter text-center">
              <a href="blog-grid.php" class="btn btn-sm <?php echo !$category_filter ? 'btn-primary' : 'btn-outline-primary'; ?> mx-1 mb-2">All</a>
              <?php while ($cat = $categories_result->fetch_assoc()): ?>
                <a href="blog-grid.php?category=<?php echo urlencode($cat['category']); ?>"
                   class="btn btn-sm <?php echo $category_filter == $cat['category'] ? 'btn-primary' : 'btn-outline-primary'; ?> mx-1 mb-2">
                   <?php echo htmlspecialchars($cat['category']); ?>
                </a>
              <?php endwhile; ?>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <div class="row g-4">
          <?php
          if ($result && $result->num_rows > 0) {
              while ($post = $result->fetch_assoc()) {
                  // Format date
                  $post_date = date('d M, Y', strtotime($post['published_at']));

                  // Get excerpt
                  $excerpt = $post['excerpt'] ?: substr(strip_tags($post['content']), 0, 150) . '...';

                  // Get image
                  $image = $post['featured_image'] ?: 'assets/imgs/blog/default-blog.jpg';
                  if (strpos($image, 'uploads/') !== false) {
                      $image = 'assets/imgs/blog/uploads/' . basename($image);
                  } else {
                      $image = 'assets/imgs/blog/' . $image;
                  }
          ?>
          <div class="col-xxl-4 col-xl-4 col-lg-6">
            <div class="blog-style-one">
              <a class="blog-image w-img" href="blog-details.php?slug=<?php echo htmlspecialchars($post['slug']); ?>">
                <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
              </a>
              <div class="blog-content">
                <div class="post-meta">
                  <span class="p-relative"><a href="blog-details.php?slug=<?php echo htmlspecialchars($post['slug']); ?>"><i class="fal fa-user"></i> By <?php echo htmlspecialchars($post['author']); ?></a></span>
                  <span class="p-relative"><a href="blog-details.php?slug=<?php echo htmlspecialchars($post['slug']); ?>"><i class="fal fa-calendar-alt"></i><?php echo $post_date; ?></a></span>
                </div>
                <hr>
                <h5 class="blog-title mb-15"><a href="blog-details.php?slug=<?php echo htmlspecialchars($post['slug']); ?>"><?php echo htmlspecialchars($post['title']); ?></a></h5>
                <p class="mb-25"><?php echo htmlspecialchars($excerpt); ?></p>
                <div class="blog-link"><a class="primary-btn-5 btn-hover" href="blog-details.php?slug=<?php echo htmlspecialchars($post['slug']); ?>">Read More &nbsp; | <i class="icon-right-arrow"></i><span></span></a></div>
              </div>
            </div>
          </div>
          <?php
              }
          } else {
              echo '<div class="col-12"><div class="alert alert-info text-center"><h4>No blog posts found</h4><p>Check back soon for new content!</p></div></div>';
          }
          ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="row mt-50">
          <div class="col-12">
            <nav aria-label="Blog pagination">
              <ul class="pagination justify-content-center">
                <?php if ($current_page > 1): ?>
                <li class="page-item">
                  <a class="page-link" href="blog-grid.php?page=<?php echo $current_page - 1; ?><?php echo $category_filter ? '&category=' . urlencode($category_filter) : ''; ?>">Previous</a>
                </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo $i == $current_page ? 'active' : ''; ?>">
                  <a class="page-link" href="blog-grid.php?page=<?php echo $i; ?><?php echo $category_filter ? '&category=' . urlencode($category_filter) : ''; ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                <li class="page-item">
                  <a class="page-link" href="blog-grid.php?page=<?php echo $current_page + 1; ?><?php echo $category_filter ? '&category=' . urlencode($category_filter) : ''; ?>">Next</a>
                </li>
                <?php endif; ?>
              </ul>
            </nav>
          </div>
        </div>
        <?php endif; ?>

      </div>
    </section>
  </main>

<?php
// Include footer
include 'includes/footer.php';

// Close database connection
$conn->close();
?>
