<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>

<?php if($ui_status == 0x0): ?>

	<h1>Token Request</h1>

	<p>We try to exchange the "Temporary Credential" for an "Token" with
	that we can access the protected API.</p>

	<form method="post" action="<?php echo $url; ?>oauthconsumer/accesstoken">

	<table class="table">
	<colgroup>
		<col width="160" />
		<col width="*" />
	</colgroup>
	<tr>
		<td><label for="url">URL:</label></td>
		<td><input class="text" type="url" id="url" name="url" value="https://twitter.com/oauth/access_token" /></td>
	</tr>
	<tr>
		<td><label for="consumer_key">Consumer key:</label></td>
		<td><input disabled="disabled" class="text" type="text" id="consumer_key" name="consumer_key" value="<?php echo htmlspecialchars($oc_consumer_key); ?>" /></td>
	</tr>
	<tr>
		<td><label for="consumer_secret">Consumer secret:</label></td>
		<td><input disabled="disabled" class="text" type="text" id="consumer_secret" name="consumer_secret" value="<?php echo htmlspecialchars($oc_consumer_secret); ?>" /></td>
	</tr>
	<tr>
		<td><label for="method">Method:</label></td>
		<td><select class="list" name="method" id="method">

			<option selected="selected" value="HMAC-SHA1">HMAC-SHA1</option>
			<option value="PLAINTEXT">PLAINTEXT</option>
		</select></td>
	</tr>
	<tr>
		<td><label for="token">Token:</label></td>
		<td><input disabled="disabled" class="text" type="text" id="token" name="token" value="<?php echo $oc_token; ?>" /></td>
	</tr>
	<tr>
		<td><label for="token_secret">Token secret:</label></td>
		<td><input disabled="disabled" class="text" type="text" id="token_secret" name="token_secret" value="<?php echo $oc_token_secret; ?>" /></td>
	</tr>
	<tr>
		<td><label for="verifier">Verifier:</label></td>
		<td><input disabled="disabled" class="text" type="text" id="verifier" name="verifier" value="<?php echo $oc_verifier; ?>" /></td>
	</tr>
	<tr>
		<td colspan="2">
		<p>
			<input class="btn btn-primary" type="submit" />
			<input class="btn" type="reset" />
		</p>
		</td>
	</tr>
	</table>

	</form>

<?php elseif($ui_status == 0x1): ?>

	<h1>Token Request</h1>

	<?php if(!isset($error)): ?>

		<p>We have tried to exchange our "Temporary Credential" for an "Token".
		If it was successful you should see the token and token secret
		in the fields below. For debugging purpose you can see the
		complete request and response.</p>

		<form method="get" action="<?php echo $url; ?>oauthconsumer/requestapi">
		<input class="btn btn-primary" type="submit" value="Next" />
		</form>

		<hr />

		<dl>
			<dt>Token</dt>
			<dd><?php echo $token; ?></dd>
			<dt>Token secret</dt>
			<dd><?php echo $token_secret; ?></dd>
		</dl>

		<hr />

		<h2>Request</h2>
		<pre><?php echo $request; ?></pre>

		<hr />

		<h2>Response</h2>
		<pre><?php echo $response; ?></pre>

	<?php else: ?>

		<div class="error"><?php echo implode('<br />', $error); ?></div>

	<?php endif; ?>

<?php endif; ?>


</body>
</html>
