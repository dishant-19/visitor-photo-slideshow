# AI log
Entries record what actually happened while building this with Claude. Add your own entries as you test.
1. **Architecture (Step 1).** Asked for the architecture. Result: diagram, table design, consent and upload approach. Accepted.
2. **Database + backend.** Asked for the full build. Result: SQL, config, PDO helpers, API endpoints, pages. Accepted pending testing.
3. **Frontend + slideshow.** Result: glass UI, dark mode, crossfade slideshow with polling. Accepted pending testing.
4. **Admin.** Result: dashboard with stats, approvals, consent withdrawal, settings; first-run admin creation instead of a hard-coded password. Accepted.
5. **Docs and review.** Asked for the next step; AI re-read its own output against its Step 1 plan (see mistakes).

## Mistakes and corrections
- **Mistake 1: promised feature not built.** Step 1 said uploads would be re-encoded through GD, but the first code only used `move_uploaded_file`. Found by comparing the code with the Step 1 plan. Fixed in `api/upload-photo.php` (re-encode with GD, which strips metadata and embedded payloads).
- **Mistake 2: claimed verification that wasn't possible.** Step 1 said PHP linting would be run. PHP was not installed in the build sandbox, so no lint or run happened; the first delivery said so. The code remains unverified until run on XAMPP (see TESTING.md).
- **Mistake 3 (cosmetic):** `upload.js` has a clumsy `alertMsg` helper left from a first draft; harmless, can be simplified.
- **Mistake 4: re-encoding broke photo orientation.** Found by re-reading the GD fix, not by running it: GD drops EXIF data, so phone photos would show sideways. Fixed by reading the EXIF orientation and rotating before saving.
- **Mistake 5: fragile `.htaccess`.** `php_flag` raises a 500 error if Apache is not running PHP as a module. Fixed by wrapping it in `IfModule` checks.
- **Omission fixed:** the visitor ID was generated but never shown to the visitor; it is now displayed on the upload page.
- **Mistake 6: garbage in a refactor.** While splitting files, the first `save_settings()` was written with a malformed `execute()` call, and `api/delete-photo.php` called `delete_photo()` twice (the second time with id 0). Found by re-reading the generated files, not by running them; both rewritten.
- **Mistake 7: failed scripted edit.** A patch script for `admin/login.php` crashed because it searched for the wrong text, leaving later edits unapplied. Found from the traceback; the remaining edits were re-run.
Add here any bug you find while testing and how you fixed it.
