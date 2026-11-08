<?php require '../includes/functions.php';require '../includes/admin_ui.php';admin_only();require '../includes/admin_actions.php';
admin_head('Settings');?>
<form method="post" class="glass p-4 rounded-4" style="max-width:520px"><?=csrf_field()?><input type="hidden" name="do" value="settings"><h4>Slideshow settings</h4>
<label>Seconds per photo (2-120)</label><input class="form-control mb-3" type="number" name="duration" min="2" max="120" value="<?=e(setting('duration','10'))?>">
<label>Order</label><select class="form-select mb-3" name="order"><option value="chronological">Chronological</option><option value="random" <?=setting('order')==='random'?'selected':''?>>Random</option></select>
<div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="auto" id="au" <?=setting('auto_approve')==='1'?'checked':''?>><label for="au" class="form-check-label">Auto-approve uploads</label></div>
<button class="btn btn-primary rounded-pill">Save</button></form>
<?php foot('../');
