<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>


<h1>Open Graph discovery</h1>

<p>This example demonstrates how you can fetch values from a website wich has
Open Graph tags. More informations about Open Graph at
<a href="http://opengraphprotocol.org">opengraphprotocol.org</a></p>

<?php if(!isset($error)): ?>

	<form method="post" action="<?php echo $self; ?>">

	<p>
		<label for="url">URL:</label><br />
		<input type="text" name="url" id="url" value="http://ogp.me/" style="width:312px;" />
	</p>

	<p>
		<input class="btn btn-primary" type="submit" />
	</p>

	</form>


	<?php if(isset($response)): ?>

		<hr />

		<h2>Result</h2>

		<?php if($response !== false): ?>

			<table class="table">
			<thead>
			<tr>
				<th>Key</th>
				<th>Value</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach($response as $k => $v): ?>
			<tr>
				<td><?php echo $k; ?></td>
				<td><?php echo $v; ?></td>
			</tr>
			<?php endforeach; ?>
			</tbody>
			</table>

		<?php else: ?>

			<p>No Open Graph tags discovered</p>

		<?php endif; ?>

	<?php endif; ?>

<?php else: ?>

	<div class="alert alert-error"><?php echo implode('<br />', $error); ?></div>

<?php endif; ?>


</body>
</html>
