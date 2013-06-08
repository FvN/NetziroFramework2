<?php

use Netziro;

// ------------------------------------- | START Include the Autoloader class
require_once( "includes/framework/autoloader/Autoloader.core.php" );
// ------------------------------------- | END

// ------------------------------------- | START Init and register the autoloader 
Netziro\Core\Autoloader\Autoloader::Init();
// ------------------------------------- | END

Netziro\Core\Bootstrap::Init();