# Testing
Result column is filled in by you after running each case on XAMPP. **Nothing here has been run yet.**
| # | Area | Steps | Expected | Result |
|---|------|-------|----------|--------|
| 1 | Registration | Submit empty name | Error shown, no record | |
| 2 | Registration | Invalid email / mobile | Validation error | |
| 3 | Registration | Submit without privacy box | Error | |
| 4 | Registration | Valid data | Visitor created, redirect to upload | |
| 5 | Returning | Register again with same email | Welcome-back message, visits +1, no duplicate row | |
| 6 | Returning | Same mobile, different email | Matched as returning | |
| 7 | Upload | Upload JPG/PNG/WebP | Success page, status pending | |
| 8 | Upload | File > 5 MB | Rejected (client and server) | |
| 9 | Upload | Rename a .php or .txt file to .jpg | Rejected by server | |
| 10 | Upload | Remove a preview before upload | File not uploaded | |
| 11 | Upload | Open upload.php without registering | Redirect to register | |
| 12 | Slideshow | Photo pending | Not shown | |
| 13 | Slideshow | Approve photo | Appears within 30 s without restart | |
| 14 | Slideshow | Pause, next, previous, fullscreen | Work | |
| 15 | Slideshow | Settings: duration 5, random | Applied | |
| 16 | Consent | Visitor without display consent, photo approved | Not shown | |
| 17 | Consent | Withdraw consent in dashboard | Photo disappears from slideshow | |
| 18 | Security | POST to dashboard without CSRF token | Ignored | |
| 19 | Security | Open admin/dashboard.php logged out | Redirect to login | |
| 20 | Security | Open http://localhost/.../uploads/photos/x.php | Denied | |
| 21 | Security | Wrong admin password | Error message | |
| 22 | Admin | Delete photo | DB row and file removed | |
| 23 | Admin | Visitors search by name/email | Filtered list | |
| 24 | Admin | Photos filter Pending/Approved/Rejected | Filtered grid | |
| 25 | Admin | Change password (wrong current / <8 chars / valid) | Error / error / success, new login works | |
| 26 | Admin | Dashboard chart and counters | Match database | |
| 27 | API | Register with JavaScript on: wrong data / valid data | Errors shown inline / redirect to upload | |
| 28 | API | Register with JavaScript disabled | Normal form post works | |
| 29 | API | POST api/delete-photo.php without admin session | 401 JSON | |
| 30 | API | Delete photo in admin | Card disappears, file and row removed | |
| 31 | API | GET api/slideshow-settings.php | Current duration/order JSON | |
| 32 | API | POST api/update-consent.php (admin, value=0) | display_consent = 0, photo leaves slideshow | |
| 33 | Security | 5 wrong admin passwords, then the correct one | Blocked message for 15 minutes; a correct login after the wait works | |
| 34 | Consent | consent.php with correct ID + email, Withdraw | Photos leave slideshow; message shown | |
| 35 | Consent | consent.php with wrong ID or email | Generic "could not match" error | |
| 36 | Consent | "Withdraw and delete my photos" | Consent off, photos and files removed | |
| 37 | Export | Admin > Visitors/Photos > Export CSV | CSV opens in Excel with correct columns; name starting with "=" is escaped | |

| 38 | Design | Open site at phone width | Gold/black theme, hamburger menu works, no sideways scroll | |
| 39 | Gallery | Search a name; filter by category | Results match | |
| 40 | Gallery | Click a photo | Full-screen preview with name and date | |
| 41 | Home | Open home page | Hero background cycles approved photos every 5 s; statistics match the database | |
| 42 | Admin | Edit visitor (valid; duplicate email) | Saved; error message | |
| 43 | Sample data | Import sample-data.sql | 8 sample photos appear in gallery and slideshow | |
| 44 | Upload | Choose a category and upload | Category stored and filterable in gallery | |
