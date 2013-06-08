<?php

use Netziro\Core;

// ------------------------------------- | START Include the Autoloader class
require_once( "includes/framework/autoloader/Autoloader.core.php" );
// ------------------------------------- | END

// ------------------------------------- | START Init and register the autoloader 
Core\Autoloader\Autoloader::Init();
// ------------------------------------- | END

// ------------------------------------- | START Init the application
Core\Bootstrap::Init();
// ------------------------------------- | END