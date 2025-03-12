<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

Simple Blog System with Dynamic Features
Developer: Asad Luqman
Internship: Hybrid Media Works
Technology Stack: Laravel, AJAX, Select2, TinyMCE, DOMpdf, Spatie, Queue Jobs
Project Overview
The "Blogs" project is a web-based blogging system developed using Laravel. It includes
authentication, user management, posts with tags, comments, search, filtering, and role-based
access control.
Project Features
1. Laravel Installation & Setup
• Installed Laravel framework
• Configured environment settings (database, mail, etc.)
2. Authentication System
• User login
• User registration via email
• Password recovery through email with expiration
• Login as Admin & User by Role
o Users log in based on their assigned role (Admin/User)
o Admins have full access
o Users can only view their own content and perform actions permitted to them
3. User Management (CRUD)
• Create, Read, Update, and Delete (CRUD) operations for users
• Live search input using AJAX
• Show Admin & User View Based on Role
o Admins can see all users
o Users can only view their own data
4. MVC Pattern Understanding
• Implemented Model-View-Controller (MVC) architecture
5. Tags Management (AJAX CRUD)
• Add, update, delete, and list tags using AJAX
6. Post Management (CRUD)
• Add/edit posts with:
o Title
o Image
o Description using TinyMCE editor
o Multiple tags selection using Select2
7. Comments Section (Polymorphic Relationship)
• Implemented polymorphic relationship for comments
• Users can comment on posts
• Display comments with:
o User name
o Profile picture
o Date
• Used lazy loading and AJAX for displaying comments
8. Model Relationships Understanding
• One-to-One
• One-to-Many
• Many-to-Many
• HasOne & HasMany
• Implemented:
o Many-to-Many (Posts & Tags)
o One-to-Many (Users & Posts)
o Many-to-Many Polymorphic (Comments & Posts)
9. Advanced Features
• Live Search in User Table: Implemented AJAX-based search
• Post Filtering System:
o Search by Date
o Search by Title
o Search by Tags
o Used AJAX on form submission
• Generate PDF: Created PDF documents using DOMpdf
10. Role & Permission Management
• Implemented user roles and permissions using Spatie package
• Middleware for login and permission checks
• Custom middleware for role validation
• Used Laravel’s can function for permission validation
• Restricted Views Based on Roles
o Admins can manage all users
o Users can only manage their own content
11. Email Functionality
• Sending emails using Laravel Mailable
• Implemented email queue jobs for efficient email sending
12. Upload Project to GitHub Using GitHub Desktop
1. Initialize a Git Repository:
o Open GitHub Desktop.
o Click File > New Repository.
o Enter your project name and set the local path.
o Click Create Repository.
2. Add Project Files:
o Ensure .gitignore includes vendor/, .env, and other sensitive files.
o Commit all files in GitHub Desktop.
3. Publish to GitHub:
o Click Publish Repository.
o Choose your GitHub account and repository visibility.
o Click Publish Repository.
4. Push Future Changes:
o Open GitHub Desktop, check for changes, commit, and push to origin.
Conclusion
This project provides a robust blogging system with authentication, CRUD operations, AJAXbased functionalities, advanced relationships, role-based access, and email notifications. The
implementation of various Laravel features ensures a scalable and maintainable application.
Future Enhancements
• Implement post approval system for admins
• Add user profiles and dashboards
• Optimize AJAX calls for better performance
• Improve UI/UX with better frontend design
