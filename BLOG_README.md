# Kanini Technology Blog System

A complete PHP-based blog management system with admin panel for the Kanini Technology website.

## Features

### Frontend (Public Blog)
- **Dynamic Blog Listing** (blog-grid.php) - Displays all published blog posts with pagination
- **Blog Details Page** (blog-details.php) - Shows full post content with related posts
- **Category Filtering** - Filter posts by category
- **Search Functionality** - Search through blog posts
- **SEO Optimized** - Proper meta tags and social media sharing
- **View Counter** - Tracks post views
- **Responsive Design** - Works perfectly on all devices

### Admin Panel
- **Secure Login System** - Password-protected admin access
- **Dashboard** - Overview of blog statistics
- **Post Management** - Full CRUD (Create, Read, Update, Delete) operations
- **Rich Content Editor** - HTML content support
- **Image Upload** - Featured image management
- **Category Management** - Organize posts by category
- **Draft/Publish** - Save drafts or publish immediately
- **Slug Generation** - Automatic URL-friendly slug creation

## Installation Instructions

### Step 1: Database Setup

1. Open your MySQL/PHPMyAdmin
2. Run the SQL file to create database and tables:
   ```sql
   SOURCE /path/to/Kanini/database_setup.sql
   ```
   OR manually execute the contents of `database_setup.sql`

3. This will create:
   - Database: `kanini_blog`
   - Tables: `admin_users`, `blog_posts`, `blog_categories`
   - Default admin user
   - Sample blog posts

### Step 2: Configure Database Connection

1. Open `admin/config.php`
2. Update database credentials if needed:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'kanini_blog');
   ```

3. Update SITE_URL:
   ```php
   define('SITE_URL', 'http://localhost/Kanini');
   ```

### Step 3: File Permissions

Ensure the upload directory has write permissions:
```bash
chmod 755 assets/imgs/blog/uploads/
```

### Step 4: Update Navigation Links

The blog is already integrated with your existing design. Update other pages to link to the new blog:

**Change blog links from:**
```html
<a href="blog-grid.html">Blog</a>
```

**To:**
```html
<a href="blog-grid.php">Blog</a>
```

## Default Admin Credentials

- **Username:** admin
- **Password:** admin123
- **Login URL:** http://localhost/Kanini/admin/login.php

**IMPORTANT:** Change the default password immediately after first login!

## File Structure

```
Kanini/
├── admin/
│   ├── config.php              # Database configuration
│   ├── login.php               # Admin login page
│   ├── index.php               # Admin dashboard
│   ├── posts.php               # List all posts
│   ├── post-add.php            # Add new post
│   ├── post-edit.php           # Edit post
│   ├── post-delete.php         # Delete post
│   ├── logout.php              # Logout handler
│   └── includes/
│       ├── header.php          # Admin header
│       ├── sidebar.php         # Admin sidebar
│       └── footer.php          # Admin footer
├── includes/
│   ├── header.php              # Frontend header
│   └── footer.php              # Frontend footer
├── blog-grid.php               # Blog listing page
├── blog-details.php            # Blog post details page
├── database_setup.sql          # Database schema and sample data
└── BLOG_README.md              # This file
```

## Usage Guide

### Admin Panel

1. **Login:** Go to `/admin/login.php`
2. **Dashboard:** View statistics and recent posts
3. **Add Post:**
   - Click "Add New Post"
   - Fill in title (slug auto-generates)
   - Add content (HTML supported)
   - Upload featured image
   - Select category and status
   - Click "Save Post"

4. **Edit Post:**
   - Click edit icon on any post
   - Make changes
   - Click "Update Post"

5. **Delete Post:**
   - Click delete icon
   - Confirm deletion

### Adding Blog Posts with HTML Content

The content editor supports HTML. Example formatting:

```html
<h3>Heading</h3>
<p>Paragraph text with <strong>bold</strong> and <em>italic</em>.</p>
<ul>
  <li>List item 1</li>
  <li>List item 2</li>
</ul>
<blockquote>Quote text here</blockquote>
```

### Adding Images to Posts

1. Upload featured image through admin panel
2. Images are stored in `assets/imgs/blog/uploads/`
3. For inline images in content, upload separately and use HTML:
   ```html
   <img src="assets/imgs/blog/your-image.jpg" alt="Description">
   ```

## Security Features

- **Password Hashing:** Uses PHP's password_hash()
- **SQL Injection Protection:** Uses MySQLi with proper escaping
- **Session Management:** Secure session handling
- **Login Required:** Admin pages check authentication
- **XSS Protection:** Output escaping with htmlspecialchars()

## Customization

### Adding New Categories

1. Go to PHPMyAdmin
2. Open `blog_categories` table
3. Add new category with name and slug

OR edit these files to add to dropdowns:
- `admin/post-add.php`
- `admin/post-edit.php`

### Changing Posts Per Page

Edit these values:
- Blog listing: `blog-grid.php` line 11 `$posts_per_page = 9;`
- Admin listing: `admin/posts.php` line 12 `$per_page = 20;`

### Styling

- Admin panel styles: `admin/includes/header.php` (CSS section)
- Frontend uses existing Kanini design
- Blog-specific styles can be added to `assets/css/main.css`

## Troubleshooting

### Problem: "Connection failed" error
**Solution:** Check database credentials in `admin/config.php`

### Problem: Images not uploading
**Solution:** Check folder permissions: `chmod 755 assets/imgs/blog/uploads/`

### Problem: Blog pages showing 404
**Solution:** Ensure your server supports PHP and files have `.php` extension

### Problem: Can't login
**Solution:**
1. Check database connection
2. Verify admin_users table has data
3. Use default credentials: admin / admin123

### Problem: Blank page
**Solution:** Enable PHP error reporting:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## Testing Checklist

- [ ] Database created and populated
- [ ] Can login to admin panel
- [ ] Can create new blog post
- [ ] Can edit existing post
- [ ] Can delete post
- [ ] Blog listing page displays posts
- [ ] Blog details page shows full content
- [ ] Category filter works
- [ ] Pagination works
- [ ] Image upload works
- [ ] Views counter increments
- [ ] Navigation links updated

## Support

For issues or questions:
- Email: service@kaninitechnology.com
- Phone: +91 96299 88887

## Credits

Developed for Kanini Technology, Coimbatore
Website: https://www.kaninitechnology.com

## License

Proprietary - © 2025 Kanini Technology. All rights reserved.
