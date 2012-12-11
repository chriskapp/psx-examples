<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>

<h1>Welcome,</h1>

<p>you have reached the development playground of Christoph "k42b3" Kappestein.
This website serves two purposes first it is my playground where I implement
and test classes of the psx library and second it is a great learning resource 
if you want start working with the <a href="http://phpsx.org">psx</a> framework.</p>

<p>All demos are available under the <a href="http://www.gnu.org/licenses/gpl-3.0.html">GPLv3</a> 
license. You can <a href="https://github.com/k42b3/psx-examples/downloads">download</a> 
or checkout the page from the git <a href="https://github.com/k42b3/psx-examples">repositiory</a>. 
In some examples we use dummy data from a database. If you want test the examples 
locally you have to create the following  <a href="<?php echo $base; ?>/data.sql">table</a>. 
If an example does not work correctly or you are missing an specific use case 
do not hesitate to contact me.</p>

<h2>Milestones</h2>

<ul>
	<li>11.12.2012 Update PSX to version 0.4.7</li>
	<li>09.10.2012 Added html filter and lexer demo</li>
	<li>07.10.2012 Import to git <a href="https://github.com/k42b3/psx-examples">repository</a></li>
	<li>07.10.2012 Improved application structure and added oauth2 client test</li>
	<li>24.10.2011 First release of example.phpsx.org</li>
</ul>

</body>
</html>
