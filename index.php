<?php
ob_start();
session_start();

define( "NF_INSTANCE", "application" );

require_once( "includes/framework/core/NFBootstrap.core.php" );


ob_end_flush( );