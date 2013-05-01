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
 
$autoloader[ "NFDatabase" ] = "includes/core/database/NFDatabase.class.php";
$autoloader[ "NFCore" ] = "includes/core/NFCore.core.php";
$autoloader[ "NFSettings" ] = "includes/core/NFSettings.core.php";
$autoloader[ "NFDependencies" ] = "includes/core/dependencies/NFDependencies.core.php";
$autoloader[ "NFUserInterface" ] = "includes/core/ui/NFUserInterface.ui.php";
$autoloader[ "NFLogger" ] = "includes/core/util/NFLogger.util.php";
$autoloader[ "NFCrypto" ] = "includes/core/util/NFCrypto.util.php";
$autoloader[ "NFIntl" ] = "includes/core/util/NFIntl.util.php";
$autoloader[ "NFInstall" ] = "includes/core/install/NFInstall.core.php";
$autoloader[ "NFTemplateModel" ] = "includes/core/models/NFTemplate.model.php";
$autoloader[ "NFModuleModel" ] = "includes/core/models/NFModule.model.php";
$autoloader[ "NFModuleView" ] = "includes/core/models/NFModule.model.php";