<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>

<?php if($ui_status == 0x0): ?>

	<h1>Resource Owner Authorization</h1>

	<p>If we have successful obtained an request token and token secret we must
	gain authorizaition by the user.</p>

	<table class="table">
	<colgroup>
		<col width="160" />
		<col width="*" />
	</colgroup>
	<tr>
		<td><label for="url">URL:</label></td>
		<td><input class="text" type="text" id="url" name="url" value="https://twitter.com/oauth/authorize" /></td>
	</tr>
	<tr>
		<td><label for="token">Token:</label></td>
		<td><input disabled="disabled" class="text" type="text" id="token" name="token" value="<?php echo htmlspecialchars($oc_token); ?>" /></td>
	</tr>
	<tr>
		<td colspan="2">
		<p>
			<input class="btn btn-primary" type="button" value="Authorize" onclick="redirect()" />
		</p>
		</td>
	</tr>
	</table>

	<script type="text/javascript">
	function redirect()
	{
		top.location.href = document.getElementById('url').value + '?oauth_token=' + document.getElementById('token').value;
	}
	</script>

<?php elseif($ui_status == 0x1): ?>

<?php endif; ?>


</body>
</html>
