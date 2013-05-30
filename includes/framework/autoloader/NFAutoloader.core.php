<?php
/*
* ----------------------------------------------------------------------
*                 NETZIRO FRAMEWORK - NFAutoloader
* ----------------------------------------------------------------------
* FILE RELATIVE LOCATION:	core/autoloader/NFAutoloader.core.php
* CREATOR:					Alessio Nobile
* CREATING DATA:			02/01/12
* ----------------------------------------------------------------------
* FILE DESCRIPTION:			Array containing all classes requirements
* ----------------------------------------------------------------------
*/
 
$autoloader[ "NFDatabase" ] = "includes/framework/database/NFDatabase.class.php";
$autoloader[ "NFCore" ] = "includes/framework/core/NFCore.core.php";
$autoloader[ "NFSettings" ] = "includes/framework/core/NFSettings.core.php";
$autoloader[ "NFDependencies" ] = "includes/framework/dependencies/NFDependencies.core.php";
$autoloader[ "NFUserInterface" ] = "includes/framework/ui/NFUserInterface.ui.php";
$autoloader[ "NFLogger" ] = "includes/framework/core/NFLogger.core.php";
$autoloader[ "NFCrypto" ] = "includes/framework/util/NFCrypto.util.php";
$autoloader[ "NFCache" ] = "includes/framework/util/NFCache.util.php";
$autoloader[ "NFIntl" ] = "includes/framework/util/NFIntl.util.php";
$autoloader[ "NFInstall" ] = "includes/framework/install/NFInstall.core.php";
$autoloader[ "NFTemplateModel" ] = "includes/framework/interfaces/NFTemplate.interface.php";
$autoloader[ "NFModule" ] = "includes/framework/core/NFModule.core.php";
$autoloader[ "NFModuleModel" ] = "includes/framework/interfaces/NFModule.interface.php";
$autoloader[ "NFModuleView" ] = "includes/framework/interfaces/NFModule.interface.php";