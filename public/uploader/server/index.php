<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

if(!isset($_COOKIE['logged-in'])){
		exit;
	}
	if($_COOKIE['logged-in']!="logged-in"){
		exit;
	}

error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');
$uppth = $_GET['uppth'];
$upload_handler = new UploadHandler($uppth);
