<?php

/**
 * This file was created by the Form Tools Form Builder module.
 */
require_once('/home/gorillac/public_html/ftools/global/library.php');
use FormTools\Core;
Core::init(array("auto_logout" => false));
$root_dir = Core::getRootDir();
$published_form_id = 3;
$filename  = "employment.php";
require_once("$root_dir/modules/form_builder/form.php");