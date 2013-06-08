<?php
ob_start();
session_start();

define( "NF_INSTANCE", "application" );

require_once( "autoloader.register.php" );
NFBootstrap::Init();


ob_end_flush( );