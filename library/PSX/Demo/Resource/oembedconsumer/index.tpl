<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>


<h1>Oembed</h1>

<p>This example demonstrates how the PSX oembed library works. Enter as URL an
location to an video. For security reasons you can only enter urls with
www.youtube.com as host.</p>

<?php if(!isset($error)): ?>

	<form method="post" action="<?php echo $self; ?>">

	<p>
		<label for="url">URL:</label>
		<input type="url" name="url" id="url" value="<?php echo !empty($oembedUrl) ? $oembedUrl : 'http://www.youtube.com/watch?v=poyYqVmhQ9w'; ?>" style="width:312px;" />
	</p>

	<p>
		<input class="btn btn-primary" type="submit" />
	</p>

	</form>


	<?php if(isset($type)): ?>

		<hr />

		<?php if($type instanceof \PSX\Oembed\Type\Video): ?>

			<h2><?php echo $type->getTitle(); ?></h2>

			<?php echo $type->getHtml(); ?>

			<dl>
				<dt>Type</dt>
				<dd><?php echo $type->getType(); ?></dd>
				<dt>Version</dt>
				<dd><?php echo $type->getVersion(); ?></dd>
				<dt>Title</dt>
				<dd><?php echo $type->getTitle(); ?></dd>
				<dt>Author name</dt>
				<dd><?php echo $type->getAuthorName(); ?></dd>
				<dt>Author url</dt>
				<dd><?php echo $type->getAuthorUrl(); ?></dd>
				<dt>Provider name</dt>
				<dd><?php echo $type->getProviderName(); ?></dd>
				<dt>Provider url</dt>
				<dd><?php echo $type->getProviderUrl(); ?></dd>
				<dt>Cache age</dt>
				<dd><?php echo $type->getCacheAge(); ?></dd>
				<dt>Thumbnail url</dt>
				<dd><?php echo $type->getThumbnailUrl(); ?></dd>
				<dt>Thumbnail width</dt>
				<dd><?php echo $type->getThumbnailWidth(); ?></dd>
				<dt>Thumbnail height</dt>
				<dd><?php echo $type->getThumbnailHeight(); ?></dd>
			</dl>

		<?php else: ?>

			<p>No oembed type discovered</p>

		<?php endif; ?>

	<?php endif; ?>

<?php else: ?>

	<div class="error"><?php echo implode('<br />', $error); ?></div>

<?php endif; ?>


</body>
</html>
