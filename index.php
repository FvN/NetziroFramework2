<?php

ob_start();
session_start();

define( "NF_INSTANCE", "application" );

require_once( "autoloader.register.php" );


ob_end_flush( );