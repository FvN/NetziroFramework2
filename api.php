<?php

ob_start();
session_start();

define( "NF_INSTANCE", "api" );

require_once( "autoloader.register.php" );

ob_end_flush( );