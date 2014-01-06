<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>


<h1>Html lexer</h1>

<p>The html lexer class is an robust html 5 parser to parse non well-formed 
markup. Enter an url and the lexer tries to extract all links from the html 
content. Try to enter websites wich have non well formed markup to test how 
robust the html lexer is.</p>

<?php if(!isset($error)): ?>

	<form method="post" action="<?php echo $self; ?>">
	<p>
		<label for="src">URL:</label>
		<input type="url" name="src" id="src" value="<?php echo isset($src) ? htmlspecialchars($src) : 'http://www.google.com'; ?>" style="width:312px;" />
	</p>
	<p>
		<input class="btn btn-primary" type="submit" />
	</p>
	</form>

	<?php if(isset($links)): ?>
		<hr />
		<?php if(!empty($links)): ?>
		<ul>
			<?php foreach($links as $link): ?>
			<li><?php echo $link; ?></li>
			<?php endforeach; ?>
		</ul>
		<?php else: ?>
		<div class="alert alert-info">No links found</div>
		<?php endif; ?>
	<?php endif; ?>

<?php else: ?>

	<div class="alert alert-error"><?php echo implode('<br />', $error); ?></div>

<?php endif; ?>


</body>
</html>
