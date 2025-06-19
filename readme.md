# Custom WordPress Theme Task Submission Custom Portfolio

## Introduction

This project is a **custom WordPress theme** developed entirely from scratch as part of a technical assignment. The goal was to showcase both **front-end** and **back-end** skills in WordPress development without the use of page builders like Elementor or WPBakery.

## Note on Starter Theme

Although permission to use the **Underscores (\_s)** starter theme was granted later in the process, I had already started building the theme **fully from scratch** before receiving that confirmation. Therefore, this theme is handcrafted with manual setup, template structure, and WordPress best practices without relying on any starter frameworks.

## Features Implemented

### 1.Theme Setup

- Custom WordPress theme created from scratch.
- All standard theme files included: `style.css`, `index.php`, `functions.php`, etc.
- No page builders or pre-built templates used.

### 2. Custom Page Templates

Two custom page templates are provided:

- `template-home.php` — **Home Page Template**
- `template-blog.php` — **Blog Page Template**

To assign:

1. Go to **Pages > Add New**
2. Create a page (e.g., "Home" or "Blog")
3. Under "Page Attributes", select the desired template.

---

### 3. Custom Post Type – `project`

A custom post type `project` was created via code (no plugins).

### Custom Fields (created manually via PHP):

Project Name
Project Description
Project Start Date
Project End Date
Project URL

These fields are handled using `add_meta_box()` and saved/sanitized with `save_post`.

### 4. Custom Templates for Project CPT

- `archive-project.php`: A **custom archive** page for listing all projects.
- `single-project.php`: A detailed **single project** page showing all custom fields.

The archive includes:

- Grid layout
- Client name
- Start and End dates
- Project URL

The single page displays full descriptions and styled layout.

### 5. Custom REST API Endpoint

A custom REST API endpoint was developed to return a list of all `project` posts.

**Endpoint URL:**
http://yourdomain.com/wp-json/custom/v1/projects

-Replace yourdomain.com with your actual domain.

### 6. Bonus Task: Filter Projects by Start & End Date ✅

Although this was marked as optional, I have **fully implemented the bonus task**.

The **Projects Archive Page** includes a date-based filter form allowing users to filter projects by:

- **Start Date**
- **End Date**

Example URL with filter:
http://localhost/azoure/projects/?start_date=2025-06-01&end_date=2025-06-30
