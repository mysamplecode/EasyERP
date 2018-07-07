<?php

//----------------------------
function pr( $var, $empty = 0 )
{
    
    if ( is_array( $var ) )
    {
        $var = print_r( $var, true );
    }
    $fp = @fopen( "/root/aitextile.log", 'a' );
    if ( $fp == false )
    {
        return;
    }
    $script_name = pathinfo( $_SERVER[ 'PHP_SELF' ], PATHINFO_FILENAME );
    $time = @date( '[d/M/Y:H:i:s]' );
    fwrite( $fp, "$time ($script_name) $var" . PHP_EOL );
    fclose( $fp );
}

include_once($path_to_root . "/includes/ui/ui_lists.inc");
include_once($path_to_root . "/includes/ui/ui_controls.inc");
include_once($path_to_root . "/includes/ui/ui_input.inc");
include_once($path_to_root . "/includes/ui/ui_msgs.inc");
include_once($path_to_root . "/includes/ui/ui_image.inc");
include_once($path_to_root . "/includes/ui/ui_globals.inc");
include_once($path_to_root . "/includes/ui/ui_view.inc");
include_once($path_to_root . "/includes/ui/ui_buttons.inc");
include_once($path_to_root . "/includes/ui/ui_dates.inc");
include_once($path_to_root . "/includes/ui/ui_headers.inc");
include_once($path_to_root . "/includes/data_checks.inc");
?>