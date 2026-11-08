<?php require '../includes/functions.php';require '../includes/admin_ui.php';admin_only();require '../includes/admin_actions.php';
admin_head('Profile');?>
<form method="post" class="glass p-4 rounded-4" style="max-width:520px"><?=csrf_field()?><input type="hidden" name="do" value="password"><h4>Admin: <?=e($_SESSION['admin'])?></h4>
<input class="form-control mb-3" type="password" name="old" placeholder="Current password" required><input class="form-control mb-3" type="password" name="new" placeholder="New password (min 8)" required minlength="8"><button class="btn btn-primary rounded-pill">Change password</button></form>
<?php foot('../');
