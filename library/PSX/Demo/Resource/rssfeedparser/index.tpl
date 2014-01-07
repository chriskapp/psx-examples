<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>


<h1>Feed parser</h1>

<p>This example demonstrates howto parse an simple RSS feed</p>

<?php if(!isset($error)): ?>

	<form method="post" action="<?php echo $self; ?>">
	<p>
		<label for="url">URL:</label>
		<input type="url" name="url" id="url" value="<?php echo !empty($feedUrl) ? htmlspecialchars($feedUrl) : 'http://news.google.com/news?pz=1&cf=all&topic=t&output=rss'; ?>" style="width:312px;" />
	</p>
	<p>
		<input class="btn btn-primary" type="submit" />
	</p>
	</form>

	<?php if(isset($response)): ?>
		<hr />
		<h1><?php echo $response->getTitle(); ?></h1>

		<p><small>Feed parsed from: <a href="<?php echo htmlspecialchars($feedUrl); ?>"><?php echo htmlspecialchars($feedUrl); ?></a></small></p>

		<ul>
			<?php foreach($response as $entry): ?>
			<li><?php echo $entry->getTitle(); ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

<?php else: ?>

	<div class="alert alert-error"><?php echo implode('<br />', $error); ?></div>

<?php endif; ?>


</body>
</html>
