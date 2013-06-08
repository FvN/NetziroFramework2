<?php

use Netziro;

// ------------------------------------- | START Include the Autoloader class
require_once( "includes/framework/autoloader/NFAutoloader.core.php" );
// ------------------------------------- | END

// ------------------------------------- | START Init and register the autoloader 
Netziro\Core\Autoloader\NFAutoloader::Init();
// ------------------------------------- | END

Netziro\Core\Bootstrap\NFBootstrap::Init();