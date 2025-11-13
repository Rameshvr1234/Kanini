<?php
require_once 'config.php';
requireLogin();

$page_title = 'Edit Post';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id == 0) {
    header('Location: posts.php');
    exit();
}

// Get post
$query = "SELECT * FROM blog_posts WHERE id=$id";
$result = $conn->query($query);

if (!$result || $result->num_rows == 0) {
    header('Location: posts.php?error=not_found');
    exit();
}

$post = $result->fetch_assoc();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $slug = sanitize($_POST['slug']);
    $excerpt = sanitize($_POST['excerpt']);
    $content = $_POST['content'];
    $author = sanitize($_POST['author']);
    $category = sanitize($_POST['category']);
    $tags = sanitize($_POST['tags']);
    $status = sanitize($_POST['status']);
    $featured_image = $post['featured_image'];

    // Handle image upload
    if (!empty($_FILES['featured_image']['name'])) {
        $target_file = UPLOAD_DIR . basename($_FILES['featured_image']['name']);
        if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $target_file)) {
            $featured_image = 'uploads/' . basename($_FILES['featured_image']['name']);
            // Delete old image if it was an upload
            if ($post['featured_image'] && strpos($post['featured_image'], 'uploads/') !== false) {
                @unlink(UPLOAD_DIR . basename($post['featured_image']));
            }
        }
    }

    $published_at = ($status == 'published' && $post['status'] != 'published') ? ', published_at=NOW()' : '';

    $update_query = "UPDATE blog_posts SET
                     title='$title', slug='$slug', excerpt='$excerpt', content='$content',
                     featured_image='$featured_image', author='$author', category='$category',
                     tags='$tags', status='$status' $published_at
                     WHERE id=$id";

    if ($conn->query($update_query)) {
        header('Location: posts.php?msg=updated');
        exit();
    } else {
        $error = 'Error: ' . $conn->error;
    }
}

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Post</h1>
                <a href="posts.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Posts</a>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">Post Details</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Title *</label>
                                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Slug *</label>
                                    <input type="text" name="slug" class="form-control" value="<?php echo htmlspecialchars($post['slug']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Excerpt</label>
                                    <textarea name="excerpt" class="form-control" rows="3"><?php echo htmlspecialchars($post['excerpt']); ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Content *</label>
                                    <textarea name="content" class="form-control" rows="15" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                                    <small class="text-muted">You can use HTML tags</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">Publish</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="draft" <?php echo $post['status'] == 'draft' ? 'selected' : ''; ?>>Draft</option>
                                        <option value="published" <?php echo $post['status'] == 'published' ? 'selected' : ''; ?>>Published</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save"></i> Update Post</button>
                                <a href="post-delete.php?id=<?php echo $post['id']; ?>" class="btn btn-danger w-100 mt-2" onclick="return confirm('Delete this post?')"><i class="fas fa-trash"></i> Delete Post</a>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">Post Meta</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Author</label>
                                    <input type="text" name="author" class="form-control" value="<?php echo htmlspecialchars($post['author']); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="form-control">
                                        <option value="Technology" <?php echo $post['category'] == 'Technology' ? 'selected' : ''; ?>>Technology</option>
                                        <option value="Repair Tips" <?php echo $post['category'] == 'Repair Tips' ? 'selected' : ''; ?>>Repair Tips</option>
                                        <option value="Industry News" <?php echo $post['category'] == 'Industry News' ? 'selected' : ''; ?>>Industry News</option>
                                        <option value="Case Studies" <?php echo $post['category'] == 'Case Studies' ? 'selected' : ''; ?>>Case Studies</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tags</label>
                                    <input type="text" name="tags" class="form-control" value="<?php echo htmlspecialchars($post['tags']); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">Featured Image</div>
                            <div class="card-body">
                                <?php if ($post['featured_image']): ?>
                                    <img src="../assets/imgs/blog/<?php echo htmlspecialchars($post['featured_image']); ?>" class="img-fluid mb-2" alt="Current image">
                                <?php endif; ?>
                                <input type="file" name="featured_image" class="form-control" accept="image/*">
                                <small class="text-muted">Upload new image to replace</small>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
