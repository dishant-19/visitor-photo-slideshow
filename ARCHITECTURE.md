# Architecture
```
Browser (Bootstrap 5, vanilla JS, Fetch/XHR)
   |-- pages: index, register, upload, success, slideshow, privacy
   |-- AJAX : api/upload-photo.php (POST), api/get-photos.php (GET, polled every 30 s)
   v
includes/functions.php (CSRF, flash, layout, settings, admin guard)
   v
config/config.php (session) -> config/database.php (.env -> PDO)
   v
MySQL: visitors | photos | admins | settings        uploads/photos/ (script execution disabled)
Admin: login, dashboard (stats + 7-day chart), visitors, visitor-details, photos, settings, profile, logout; shared POST handler in includes/admin_actions.php
```
## Tables
- **visitors**: code, name, email/mobile (unique, nullable), privacy_consent, display_consent, visits
- **photos**: visitor_id (FK, cascade), random filename, status pending/approved/rejected
- **admins**: username, password_hash
- **login_attempts**: ip, attempted_at (login throttling)
- **settings**: duration, order, auto_approve
## Workflow
Register (consent) -> session -> upload (client + server validation, GD re-encode, random name) -> admin approves -> `get-photos` returns approved photos whose visitor has display consent -> slideshow crossfades them and merges changes on refresh.
## Security
PDO prepared statements; CSRF token on all POSTs; `password_hash`/`password_verify`; `session_regenerate_id` on login/registration; output escaped with `htmlspecialchars`; MIME via `finfo` + `getimagesize`; file deletion uses `basename()` inside the uploads folder.
## Includes
`header.php`, `navbar.php`, `footer.php` (layout); `csrf.php`; `auth.php` (admin guard, login, API guard); `functions.php` (helpers and shared logic: register_visitor, delete_photo, set_consent, save_settings); `admin_ui.php`, `admin_actions.php` (admin pages).
## Additional modules
`consent.php` (visitor consent self-service), `admin/export.php` (CSV export with formula-injection guard).

## Pages added in the redesign
`gallery.php` (search, category filter, modal preview), `about.php`, home hero (JS cross-fade from `api/get-photos.php`), visitor edit form in `admin/visitor-details.php`, `photos.category` column.
