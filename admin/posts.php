<?php
require_once 'config.php';
requireLogin();

$page_title = 'All Posts';

// Handle search
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';
$where = $search ? "WHERE title LIKE '%$search%' OR content LIKE '%$search%'" : '';

// Pagination
$per_page = 20;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $per_page;

$count = $conn->query("SELECT COUNT(*) as total FROM blog_posts $where")->fetch_assoc()['total'];
$total_pages = ceil($count / $per_page);

$query = "SELECT * FROM blog_posts $where ORDER BY created_at DESC LIMIT $offset, $per_page";
$posts = $conn->query($query);

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">All Posts</h1>
                <a href="post-add.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Post</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="m-0">Manage Blog Posts</h6>
                        </div>
                        <div class="col-md-6">
                            <form method="get" class="d-flex">
                                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search posts..." value="<?php echo htmlspecialchars($search); ?>">
                                <button type="submit" class="btn btn-sm btn-primary ms-2">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
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
                                <?php if ($posts && $posts->num_rows > 0): ?>
                                    <?php while ($post = $posts->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($post['title']); ?></td>
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
                                                <a href="../blog-details.php?slug=<?php echo htmlspecialchars($post['slug']); ?>" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                                <a href="post-edit.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                                <a href="post-delete.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this post?')"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="6" class="text-center">No posts found</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($total_pages > 1): ?>
                        <nav>
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
