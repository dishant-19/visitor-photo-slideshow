<?php
// App-wide settings: secure session cookie options, then the database connection.
session_set_cookie_params(['httponly'=>true,'samesite'=>'Lax']);
session_start();
require __DIR__.'/database.php';
