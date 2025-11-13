-- Kanini Blog Database Setup
-- Run this SQL to create the database and tables

CREATE DATABASE IF NOT EXISTS kanini_blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE kanini_blog;

-- Admin users table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    full_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Blog posts table
CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    excerpt TEXT,
    content LONGTEXT NOT NULL,
    featured_image VARCHAR(255),
    author VARCHAR(100) DEFAULT 'Admin',
    category VARCHAR(50) DEFAULT 'Technology',
    tags VARCHAR(255),
    status ENUM('draft', 'published') DEFAULT 'draft',
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    published_at TIMESTAMP NULL DEFAULT NULL,
    INDEX idx_slug (slug),
    INDEX idx_status (status),
    INDEX idx_created (created_at),
    FULLTEXT KEY ft_search (title, content, excerpt)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Blog categories table
CREATE TABLE IF NOT EXISTS blog_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user (username: admin, password: admin123)
-- Password is hashed using PHP's password_hash() function
INSERT INTO admin_users (username, password, email, full_name) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@kaninitechnology.com', 'Administrator');

-- Insert default categories
INSERT INTO blog_categories (name, slug, description) VALUES
('Technology', 'technology', 'Technology and IT related posts'),
('Repair Tips', 'repair-tips', 'Tips and guides for repairs'),
('Industry News', 'industry-news', 'Latest news from the industry'),
('Case Studies', 'case-studies', 'Customer case studies and success stories');

-- Insert sample blog posts
INSERT INTO blog_posts (title, slug, excerpt, content, featured_image, author, category, status, published_at) VALUES
(
    'Laptop Data Safety Tips for Coimbatore SMEs',
    'laptop-data-safety-tips-coimbatore-smes',
    'Essential data safety practices every small and medium business in Coimbatore should follow to protect their critical information.',
    '<p>In today\'s digital age, data safety is paramount for businesses of all sizes. Small and medium enterprises (SMEs) in Coimbatore face unique challenges when it comes to protecting their valuable data. This comprehensive guide will walk you through the essential practices to keep your business data safe.</p>

<h3>1. Regular Backups are Non-Negotiable</h3>
<p>The first rule of data safety is to always maintain multiple backups. Follow the 3-2-1 backup rule: keep 3 copies of your data, on 2 different media types, with 1 copy stored offsite or in the cloud.</p>

<h3>2. Use Strong Password Policies</h3>
<p>Implement strong password requirements across your organization. Passwords should be at least 12 characters long, include a mix of uppercase, lowercase, numbers, and special characters.</p>

<h3>3. Keep Software Updated</h3>
<p>Regular software updates patch security vulnerabilities that hackers exploit. Enable automatic updates for your operating system and critical software.</p>

<h3>4. Employee Training</h3>
<p>Your employees are your first line of defense. Regular training on cybersecurity best practices can prevent many common security incidents.</p>

<h3>5. Professional Hardware Maintenance</h3>
<p>Regular hardware maintenance can prevent sudden failures that lead to data loss. Schedule periodic checkups with professional service providers like Kanini Technology.</p>

<p>At Kanini Technology, we offer comprehensive data recovery services and can help you implement robust backup solutions. Contact us at +91 96299 88887 for a free consultation.</p>',
    'laptop-data-safety-tips-kanini-blog.jpg',
    'Admin',
    'Repair Tips',
    'published',
    NOW()
),
(
    'Retail IT Maintenance Guide from Kanini Technology',
    'retail-it-maintenance-guide-kanini-technology',
    'A comprehensive guide for retail businesses on maintaining their IT infrastructure to ensure smooth operations and prevent costly downtime.',
    '<p>Running a retail business in today\'s competitive market requires reliable IT infrastructure. From POS systems to inventory management software, every component must work flawlessly. Here\'s your complete guide to retail IT maintenance.</p>

<h3>Understanding Your IT Infrastructure</h3>
<p>Your retail IT infrastructure typically includes POS terminals, back-office computers, networking equipment, security cameras, and servers. Each component requires specific maintenance schedules.</p>

<h3>Daily Maintenance Tasks</h3>
<ul>
<li>Check POS system functionality at store opening</li>
<li>Monitor network connectivity</li>
<li>Verify backup completion from previous night</li>
<li>Check printer paper and toner levels</li>
</ul>

<h3>Weekly Maintenance Tasks</h3>
<ul>
<li>Clean computer and POS terminal screens and keyboards</li>
<li>Check for software updates</li>
<li>Review system logs for errors</li>
<li>Test backup restoration procedures</li>
</ul>

<h3>Monthly Maintenance Tasks</h3>
<ul>
<li>Clean dust from computers and networking equipment</li>
<li>Check all cable connections</li>
<li>Run comprehensive antivirus scans</li>
<li>Review system performance metrics</li>
</ul>

<h3>When to Call Professionals</h3>
<p>Some issues require expert attention. Contact Kanini Technology immediately if you experience:</p>
<ul>
<li>Frequent system crashes or freezes</li>
<li>Slow performance despite optimization</li>
<li>Hardware making unusual noises</li>
<li>Suspected data breach or virus infection</li>
</ul>

<p>We offer same-day service for retail businesses in Coimbatore with free pickup within 5km. Call +91 96299 88887 today.</p>',
    'retail-it-maintenance-guide-kanini-blog.jpg',
    'Admin',
    'Technology',
    'published',
    NOW()
),
(
    'Server Platform Best Practices for Business Continuity',
    'server-platform-best-practices-business-continuity',
    'Essential server management practices that ensure your business stays operational even during hardware failures or disasters.',
    '<p>For businesses that rely on server infrastructure, downtime can mean lost revenue and damaged reputation. Implementing the right server management practices is crucial for business continuity.</p>

<h3>High Availability Architecture</h3>
<p>Design your server infrastructure with redundancy in mind. Key components should have failover mechanisms to ensure continuous operation even if primary systems fail.</p>

<h3>Monitoring and Alerting</h3>
<p>Implement comprehensive monitoring solutions that track:</p>
<ul>
<li>CPU and memory utilization</li>
<li>Disk space and I/O performance</li>
<li>Network connectivity and bandwidth</li>
<li>Application response times</li>
<li>Security events and intrusions</li>
</ul>

<h3>Regular Maintenance Windows</h3>
<p>Schedule regular maintenance windows for:</p>
<ul>
<li>Operating system and security updates</li>
<li>Hardware firmware updates</li>
<li>Database maintenance and optimization</li>
<li>Log rotation and cleanup</li>
</ul>

<h3>Disaster Recovery Planning</h3>
<p>A robust disaster recovery plan should include:</p>
<ol>
<li>Complete documentation of your infrastructure</li>
<li>Regular backup testing and verification</li>
<li>Clear recovery time objectives (RTO) and recovery point objectives (RPO)</li>
<li>Documented recovery procedures</li>
<li>Regular disaster recovery drills</li>
</ol>

<h3>Physical Infrastructure</h3>
<p>Don\'t overlook the physical aspects:</p>
<ul>
<li>Adequate cooling systems</li>
<li>Uninterruptible Power Supply (UPS)</li>
<li>Generator backup for extended outages</li>
<li>Physical security measures</li>
<li>Fire suppression systems</li>
</ul>

<h3>Expert Support</h3>
<p>Kanini Technology provides comprehensive server maintenance and repair services for businesses across Tamil Nadu. Our industrial electronics division specializes in server hardware repair at the component level, often saving you significant replacement costs.</p>

<p>Contact us at +91 96299 88887 or email service@kaninitechnology.com for a free infrastructure assessment.</p>',
    'server-platform-best-practices-kanini-blog.jpg',
    'Admin',
    'Technology',
    'published',
    NOW()
);

-- Create indexes for better performance
CREATE INDEX idx_category ON blog_posts(category);
CREATE INDEX idx_author ON blog_posts(author);
CREATE INDEX idx_published_at ON blog_posts(published_at);

-- Show success message
SELECT 'Database setup completed successfully!' AS message;
SELECT CONCAT('Default admin username: admin') AS info;
SELECT CONCAT('Default admin password: admin123') AS info;
SELECT CONCAT('Please change the default password after first login!') AS warning;
