<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>

<?php if($ui_status == 0x0): ?>

	<h1>Temporary Credential Request</h1>

	<p>This is an example how the OAuth client library of psx works. To get
	more informations about OAuth goto <a href="http://tools.ietf.org/html/rfc5849">OAuth RFC</a>.
	For better understanding I use in this example the vocabulary of the RFC</a>.
	I assume that you are already familar with the basic concept of OAuth. The OAuth
	client guides you step by step to access a protected API. First you make
	an "Temporary Credential Request" then you obtain "Resource Owner Authorization".
	After that you try to exchange the "Temporary Credential" with an "Token"
	by making an "Token Request". Now you can request the protected API with
	the "Token". Because twitter.com is one of the famous OAuth provider
	I have entered the URL endpoints already in the form so you only have to
	provide the consumer key and secret but you can use any OAuth provider you
	like.

	<p>First we have to request "Temporary Credential" from the OAuth
	provider. The url, consumer key and consumer secret will be stored in
	your current session. Enter as URL the OAuth "Temporary Credential Request"
	endpoint and as consumer key and secret the key/secret pair that you have
	received from the provider.</p>

	<form method="post" action="<?php echo $url; ?>demo/oauth_consumer/request_token">

	<table class="table">
	<colgroup>
		<col width="160" />
		<col width="*" />
	</colgroup>
	<tr>
		<td><label for="url">URL:</label></td>
		<td><input class="text" type="url" id="url" name="url" value="https://twitter.com/oauth/request_token" /></td>
	</tr>
	<tr>
		<td><label for="consumer_key">Consumer key:</label></td>
		<td><input class="text" type="text" id="consumer_key" name="consumer_key" value="<?php echo htmlspecialchars($oc_consumer_key); ?>" /></td>
	</tr>
	<tr>
		<td><label for="consumer_secret">Consumer secret:</label></td>
		<td><input class="text" type="text" id="consumer_secret" name="consumer_secret" value="<?php echo htmlspecialchars($oc_consumer_secret); ?>" /></td>
	</tr>
	<tr>
		<td><label for="method">Method:</label></td>
		<td><select class="list" name="method" id="method">

			<option selected="selected" value="HMAC-SHA1">HMAC-SHA1</option>
			<option value="PLAINTEXT">PLAINTEXT</option>
		</select></td>
	</tr>
	<tr>
		<td><label for="callback">Callback:</label></td>
		<td><input class="text" type="url" id="callback" name="callback" value="<?php echo $url; ?>demo/oauth_consumer/callback" /></td>
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

	<h1>Temporary Credential Request</h1>

	<?php if(!isset($error)): ?>

		<p>The psx OAuth client has make an "Temporary Credential Request" to the
		given URL. If we have received a token and token secret you should see
		them both in the fields below. For debugging purpose you can see the complete
		request and response.</p>

		<form method="get" action="<?php echo $url; ?>demo/oauth_consumer/user_authentication">
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

		<div class="alert alert-error"><?php echo implode('<br />', $error); ?></div>

	<?php endif; ?>

<?php endif; ?>


</body>
</html>
