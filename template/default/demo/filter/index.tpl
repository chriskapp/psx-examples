<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>

<h1>Filter</h1>

<p>This module demonstrates filters from the PSX_Input package. If you submit 
the form below all input fields are validated against a specific filter. This 
way you can easily test what a filter returns.</p>

<?php if(isset($error)): ?>
	<div class="alert alert-error">
		<?php echo implode('<br />', $error); ?>
	</div>
<?php endif; ?>


<form method="post" action="">

<table class="table">
<colgroup>
	<col width="200" />
	<col width="256" />
	<col width="*" />
</colgroup>
<thead>
<tr>
	<th>Type</th>
	<th>Value</th>
	<th>Result</th>
</tr>
</thead>
<tfoot>
<tr>
	<td colspan="3">
	<p>
		<input class="btn btn-primary" type="submit" />
		<input class="btn" type="reset" />
	</p>
	</td>
</tr>
</tfoot>
<tbody>
<?php foreach($result as $key => $value): ?>
<tr>
	<td><label for="<?php echo $key; ?>"><?php echo $key; ?></label></td>
	<td><input type="text" name="value_<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $value; ?>" /></td>
	<td><?php echo var_export($value, true); ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

</form>


</body>
</html>
