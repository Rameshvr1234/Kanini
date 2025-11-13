<?php
require_once 'config.php';
requireLogin();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Get post details for image deletion
    $post_query = "SELECT featured_image FROM blog_posts WHERE id=$id";
    $result = $conn->query($post_query);

    if ($result && $result->num_rows > 0) {
        $post = $result->fetch_assoc();

        // Delete image if it's an upload
        if ($post['featured_image'] && strpos($post['featured_image'], 'uploads/') !== false) {
            $image_path = UPLOAD_DIR . basename($post['featured_image']);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        // Delete post
        $delete_query = "DELETE FROM blog_posts WHERE id=$id";
        if ($conn->query($delete_query)) {
            header('Location: posts.php?msg=deleted');
        } else {
            header('Location: posts.php?error=delete_failed');
        }
    } else {
        header('Location: posts.php?error=not_found');
    }
} else {
    header('Location: posts.php');
}

exit();
?>
