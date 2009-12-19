<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Setup :: Three CMS</title>
		<link rel="stylesheet" type="text/css" media="screen,tv,projection" href="css/screen.css" />
		<script type="text/javascript" src="../system/application/views/admin/js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="js/global.js"></script>
		<?php
			if(isset($_GET['step7'])) {
		?>
			<style type="text/css">
				#step1 { display: none; }
				#step7 { display: block; }
			</style>
		<?php
			}
		?>
    </head>
    <body>
        <div id="body">
			<form method="post" action="install.php">
				<div id="step1">
					<!-- Welcome -->
					<h1>Thank you</h1>
					<p>Thank you for choosing for Three CMS!</p>
					<p>This setup will guide you to some basic steps to install Three CMS on this server.</p>
					<div class="footer">
						<input type="button" class="next step2" value="Next" />
						<p>Step 1/6</p>
					</div>
				</div>
				<div id="step2">
					<!-- Licence -->
					<h1>License Agreement</h1>
					<p>Three CMS is licensed under the GNU General Public License v3. Before you can continue you must read and agree to this license:</p>
					<div class="license">
						<?php echo str_replace("\n", '<br />', file_get_contents('../license.txt')); ?>
					</div>
					<input type="checkbox" name="license" id="license" /> <label for="license" class="licenseLabel">I have read and agree to this license</label>
					<div class="footer">						
						<input type="button" class="prev step1" value="Previous" />
						<input type="button" class="next step3" value="Next" disabled="disabled" />
						<p>Step 2/6</p>
					</div>
				</div>
				<div id="step3">
					<!-- Database -->
					<!-- Check database connection, create database -->					
					<h1>Database</h1>
					<p>Please enter your database credentials; if no database is found, this installer will attempt to create one.</p>
					<div>
						<label for="dbname">Database name:</label>
						<input type="text" name="dbname" id="dbname" />
					</div>
					<div>
						<label for="dbhost">Database host:</label>
						<input type="text" name="dbhost" id="dbhost" value="localhost" />
					</div>
					<div>
						<label for="dbuser">Database username:</label>
						<input type="text" name="dbuser" id="dbuser" />
					</div>
					<div>
						<label for="dbpass">Database password:</label>
						<input type="text" name="dbpass" id="dbpass" />
					</div>
					<div>
						<label for="dbprefix">Database prefix:</label>
						<input type="text" name="dbprefix" id="dprefix" value="three_" />
					</div>
					<div>
						<input type="button" name="dbcheck" value="check these settings" />
					</div>
					<div id="dbmessage">
						
					</div>
					<div class="footer">
						<input type="button" class="prev step2" value="Previous" />
						<input type="button" class="next step4" value="Next" disabled="disabled" />
						<p>Step 3/6</p>
					</div>
				</div>
				<div id="step4">
					<!-- Administrator user -->
					<h1>Administrator user</h1>
					<p>Please enter the credentials for the administrator user.</p>
					<div>
						<label for="adminuser">Username:</label>
						<input type="text" name="adminuser" id="adminuser" />
					</div>
					<div>
						<label for="adminpass">Password:</label>
						<input type="text" name="adminpass" id="adminpass" /><input type="button" name="generate" value="Generate" />
					</div>
					<div>
						<label for="adminemail">E-mail address:</label>
						<input type="text" name="adminemail" id="adminemail" />
					</div>
					<p><em>Please note that once installed, the password will be encrypted before it is stored in the database, so there will be no way of retreiving it when you lost it. You can however reset your password when lost.</em></p>
					<div class="footer">
						<input type="button" class="prev step3" value="Previous" />
						<input type="button" class="next step5" value="Next" />
						<p>Step 4/6</p>
					</div>
				</div>
				<div id="step5">
					<!--
						Select setup:
						- Empty, complete blank database
						- Default website template, with a default page-template (with header, summary and content) (default)
						- Sample site, multilingual with default pages and a news example
						- Sample blog, with default pages and a blog example
					-->				
					<h1>Select setup</h1>
					<p>There are different types of predefined installations available, please select the one which you would want to install:</p>
					<label><input type="radio" name="setup" value="1" /> Empty installation</label>
					<label><input type="radio" name="setup" value="2" checked="checked" /> Default website</label>
					<label><input type="radio" name="setup" value="3" disabled="disabled" /> Example site</label>
					<label><input type="radio" name="setup" value="4" disabled="disabled" /> Example blog</label>
					<div class="descriptions">
						<p class="description1">This is an empty site with no predefined content types, templates or pages.<br /><br />Use this setup if you want to create a site completely form scratch.</p>
						<p class="description2">This is an empty site with one page and one basic template. The template provides general options for default pages, such as a header, a summary and a content area.<br /><br />Use this setup if you want a quick setup for a simple site.</p>
						<p class="description3">This is an example of a multilingual site with some default pages and a news page. It shows the default functionality of Three CMS and the Smarty Template Engine.<br /><br />Use this setup if you're new to Three CMS or want to learn the way Three CMS works (or if you want to create a multilingual site with a news-page offcourse!).</p>
						<p class="description4">This is an example of a blog created with Three CMS.<br /><br />Use this setup if you're new to Three CMS or want to learn the way Three CMS works (or if you want to create a blog offcourse!).</p>
					</div>
					<div class="footer">
						<input type="button" class="prev step4" value="Previous" />
						<input type="button" class="next step6" value="Next" />
						<p>Step 5/6</p>
					</div>
				</div>
				<div id="step6">
					<!-- Last check -->					
					<h1>Last check</h1>
					<p>Please check these settings supplied by you before clicking the 'install'-button. If some settings are not correct, you can modify them by using the 'previous'-button:</p>
					<dl>
						<dt>Database name:</dt>
						<dd class="dbname">...</dd>
						<dt>Database prefix:</dt>
						<dd class="dbprefix">...</dd>
						<dt>Administrator username:</dt>
						<dd class="adminuser">...</dd>
						<dt>Administrator password:</dt>
						<dd class="adminpass">...</dd>
						<dt>Administrator e-mail address:</dt>
						<dd class="adminemail">...</dd>
						<dt>Setup type:</dt>
						<dd class="setup">...</dd>
					</dl>
					<div class="footer">
						<input type="button" class="prev step5" value="Previous" />
						<input type="submit" class="next install" value="Install" />
						<p>Step 6/6</p>
					</div>
				</div>
			</form>
			<form method="post" action="complete.php">
				<div id="step7">
					<!-- Installation complete, delete install folder -->
					<h1>Installation complete</h1>
					<p>You have succesfully installed Three CMS on this server.</p>
					<div id="installMessage"></div>
					<input type="checkbox" name="delete" id="delete" /> <label for="delete" class="licenseLabel">Delete the installation folder (recommended)</label>
					<div class="footer">
						<input type="submit" class="next" value="Complete" />
					</div>
				</div>
			</form>
		</div>
    </body>
</html>