<?php
require_once 'config.php';
requireLogin();

$page_title = 'Add New Post';
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $slug = sanitize($_POST['slug']);
    $excerpt = sanitize($_POST['excerpt']);
    $content = $_POST['content']; // Don't sanitize HTML content
    $author = sanitize($_POST['author']);
    $category = sanitize($_POST['category']);
    $tags = sanitize($_POST['tags']);
    $status = sanitize($_POST['status']);

    // Handle image upload
    $featured_image = '';
    if (!empty($_FILES['featured_image']['name'])) {
        $target_file = UPLOAD_DIR . basename($_FILES['featured_image']['name']);
        if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $target_file)) {
            $featured_image = 'uploads/' . basename($_FILES['featured_image']['name']);
        }
    }

    $published_at = $status == 'published' ? 'NOW()' : 'NULL';

    $query = "INSERT INTO blog_posts (title, slug, excerpt, content, featured_image, author, category, tags, status, published_at)
              VALUES ('$title', '$slug', '$excerpt', '$content', '$featured_image', '$author', '$category', '$tags', '$status', $published_at)";

    if ($conn->query($query)) {
        header('Location: posts.php?msg=added');
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
                <h1 class="h2">Add New Post</h1>
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
                                    <input type="text" name="title" class="form-control" required onkeyup="generateSlug(this.value)">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Slug *</label>
                                    <input type="text" name="slug" id="slug" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Excerpt</label>
                                    <textarea name="excerpt" class="form-control" rows="3" placeholder="Short description..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Content *</label>
                                    <textarea name="content" class="form-control" rows="15" required></textarea>
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
                                        <option value="draft">Draft</option>
                                        <option value="published">Published</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save"></i> Save Post</button>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">Post Meta</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Author</label>
                                    <input type="text" name="author" class="form-control" value="Admin">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="form-control">
                                        <option value="Technology">Technology</option>
                                        <option value="Repair Tips">Repair Tips</option>
                                        <option value="Industry News">Industry News</option>
                                        <option value="Case Studies">Case Studies</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tags</label>
                                    <input type="text" name="tags" class="form-control" placeholder="Comma separated">
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">Featured Image</div>
                            <div class="card-body">
                                <input type="file" name="featured_image" class="form-control" accept="image/*">
                                <small class="text-muted">Upload blog image</small>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>

<script>
function generateSlug(title) {
    const slug = title.toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('slug').value = slug;
}
</script>

<?php include 'includes/footer.php'; ?>
