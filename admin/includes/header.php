<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Kanini Blog Admin</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome-pro.css">
    <style>
        :root {
            --sidebar-bg: #1a1d29;
            --sidebar-hover: #252836;
            --primary-color: #667eea;
            --primary-hover: #5568d3;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.95rem;
        }
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            background-color: var(--sidebar-bg);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            font-weight: 500;
            color: #adb5bd;
            padding: 0.75rem 1rem;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            color: #ffffff;
            background-color: var(--sidebar-hover);
            border-left-color: var(--primary-color);
        }
        .sidebar .nav-link.active {
            color: #ffffff;
            background-color: var(--sidebar-hover);
            border-left-color: var(--primary-color);
        }
        .sidebar .nav-link i {
            margin-right: 8px;
            width: 20px;
            text-align: center;
        }
        .navbar-brand {
            padding-top: .75rem;
            padding-bottom: .75rem;
            background-color: var(--sidebar-bg);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
        }
        .navbar .form-control {
            padding: .75rem 1rem;
            border-width: 0;
            border-radius: 0;
        }
        main {
            padding-top: 48px;
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1.5rem;
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 600;
        }
        .border-left-primary {
            border-left: .25rem solid var(--primary-color) !important;
        }
        .border-left-success {
            border-left: .25rem solid #1cc88a !important;
        }
        .border-left-warning {
            border-left: .25rem solid #f6c23e !important;
        }
        .border-left-info {
            border-left: .25rem solid #36b9cc !important;
        }
        .text-xs {
            font-size: .7rem;
        }
        .text-gray-800 {
            color: #5a5c69 !important;
        }
        .text-gray-300 {
            color: #dddfeb !important;
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }
        .navbar-dark .navbar-brand {
            color: #fff;
            font-weight: 600;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="index.php">
            <i class="fas fa-blog"></i> Kanini Blog Admin
        </a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i> Sign out
                </a>
            </div>
        </div>
    </nav>
