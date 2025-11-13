<?php
require_once 'config.php';
requireLogin();

// Get statistics
$total_posts_query = "SELECT COUNT(*) as total FROM blog_posts";
$published_posts_query = "SELECT COUNT(*) as total FROM blog_posts WHERE status='published'";
$draft_posts_query = "SELECT COUNT(*) as total FROM blog_posts WHERE status='draft'";
$total_views_query = "SELECT SUM(views) as total FROM blog_posts";

$total_posts = $conn->query($total_posts_query)->fetch_assoc()['total'];
$published_posts = $conn->query($published_posts_query)->fetch_assoc()['total'];
$draft_posts = $conn->query($draft_posts_query)->fetch_assoc()['total'];
$total_views = $conn->query($total_views_query)->fetch_assoc()['total'] ?: 0;

// Get recent posts
$recent_posts_query = "SELECT * FROM blog_posts ORDER BY created_at DESC LIMIT 10";
$recent_posts = $conn->query($recent_posts_query);

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="post-add.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> New Post
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Posts</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_posts; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Published</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $published_posts; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Drafts</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $draft_posts; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-edit fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Views</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($total_views); ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-eye fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Posts Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Posts</h6>
                    <a href="posts.php" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Views</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($recent_posts && $recent_posts->num_rows > 0): ?>
                                    <?php while ($post = $recent_posts->fetch_assoc()): ?>
                                        <tr>
                                            <td>
                                                <a href="../blog-details.php?slug=<?php echo htmlspecialchars($post['slug']); ?>" target="_blank">
                                                    <?php echo htmlspecialchars($post['title']); ?>
                                                </a>
                                            </td>
                                            <td><?php echo htmlspecialchars($post['category']); ?></td>
                                            <td>
                                                <?php if ($post['status'] == 'published'): ?>
                                                    <span class="badge bg-success">Published</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Draft</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $post['views']; ?></td>
                                            <td><?php echo date('d M, Y', strtotime($post['created_at'])); ?></td>
                                            <td>
                                                <a href="post-edit.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="post-delete.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No posts found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
