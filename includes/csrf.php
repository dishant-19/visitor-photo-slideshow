<?php
function csrf(){return $_SESSION['t']??=bin2hex(random_bytes(16));}
function csrf_field(){return '<input type="hidden" name="csrf" value="'.csrf().'">';}
function csrf_ok(){return hash_equals(csrf(),$_POST['csrf']??'');}
