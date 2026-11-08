# Visitor Photo Slideshow (PHP 8 + MySQL, XAMPP)
## Setup
1. Install XAMPP; start **Apache** and **MySQL**.
2. Copy this folder to `C:\xampp\htdocs\visitor-photo-slideshow`.
3. Open http://localhost/phpmyadmin → Import → `database/database.sql`.
4. Database settings are in `config/database.php` (default XAMPP: user `root`, empty password) or an optional `.env`.
5. (Already imported an older version? Import `database.sql` again; it only adds the new `login_attempts` table.)
6. Open http://localhost/visitor-photo-slideshow/admin/login.php — first visit creates the admin account.
7. Register at `/register.php`, upload photos, approve them in the dashboard, open `/slideshow.php`.
## Features
Registration with consent and returning-visitor detection (email/mobile), drag-and-drop multi-upload with progress, server-side MIME/size validation, approval workflow, consent withdrawal, crossfade slideshow with auto-refresh, admin stats/settings, dark mode. PDO prepared statements, CSRF tokens, password_hash, session regeneration.

## Config
Optional: copy `.env.example` to `.env` to override DB settings (git-ignored).

## GitHub submission
1. Create a **public** repo on github.com (no README/license), name `visitor-photo-slideshow`.
2. In the project folder: `git init`, `git add .`, `git commit -m "Initial project structure and database schema"`.
3. `git branch -M main`, `git remote add origin https://github.com/<you>/visitor-photo-slideshow.git`, `git push -u origin main`.
4. Suggested later commits: "Add visitor registration with consent", "Add secure photo upload", "Add slideshow", "Add admin dashboard", "Add documentation and tests".
5. Check before pushing: no `.env`, no real photos (`uploads/photos/` is ignored), no passwords.

## JSON API
| Endpoint | Method | Access | Purpose |
|---|---|---|---|
| `api/register.php` | POST | public + CSRF | Register / recognise visitor (used by the registration form) |
| `api/upload-photo.php` | POST | registered visitor + CSRF | Upload photos (used by drag-and-drop) |
| `api/get-photos.php` | GET | public | Approved, consented photos + settings (used by slideshow) |
| `api/delete-photo.php` | POST | admin + CSRF | Delete a photo (used by the admin photo cards) |
| `api/update-consent.php` | POST | admin + CSRF | Set `visitor_id`, `value` 0/1 display consent |
| `api/slideshow-settings.php` | GET / POST | GET public, POST admin + CSRF | Read or save slideshow settings |
`update-consent` and `slideshow-settings` (POST) are available for AJAX use; the admin pages save those through normal form posts.

## Extra features
- **Visitor self-service consent** at `/consent.php`: withdraw, re-grant, or withdraw and delete photos.
- **CSV export** of visitors and photos from the admin pages.

## Design (dark luxury + glassmorphism)
Black (#080808/#151515) and gold (#D4AF37) palette, frosted-glass cards, golden glow borders, floating gold particles, loading screen, scroll-reveal and hover-zoom animations, responsive mobile menu. Pages: Home (hero slideshow, live statistics), Gallery (search, category filters, full-screen preview), Slideshow, About, Register, Upload, Privacy, My consent, and the admin area.

## Sample data (optional)
After `database.sql`, import `database/sample-data.sql` to get 8 approved sample photos (files are in `uploads/photos/sample-*.jpg`).

## Upgrading an older install
Run in phpMyAdmin: `ALTER TABLE photos ADD COLUMN category VARCHAR(30) NOT NULL DEFAULT 'General';` (the slideshow default of 5 seconds can be changed in Admin → Settings).

## Not included
Admins cannot upload photos on behalf of visitors (visitors upload via the public form; admins approve, edit and delete). The database keeps the name `visitor_photo_slideshow` and has more tables than the 3 in the new brief because of consent and login throttling.
