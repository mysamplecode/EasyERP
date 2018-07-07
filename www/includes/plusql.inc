<?php

//plusql setup
include_once($path_to_root . "/includes/PluSQL/autoload.config.php");
$profile = 'frontaccounting';
if ( isset( $_SESSION ) )
{
    $connection = $db_connections[ $_SESSION[ "wa_current_user" ]->cur_con ];
    $prefix = $db_connections[ $_SESSION[ "wa_current_user" ]->cur_con ][ 'tbpref' ];
    $details = array
        (
        0 => $connection[ "host" ],
        1 => $connection[ "dbuser" ],
        2 => $connection[ "dbpassword" ],
        3 => $connection[ "dbname" ],
    );
    Plusql::credentials( $profile, $details );
}
else
{
    echo "Iniating PluSQL in the console mode \n";
    $details = array
        (
        0 => $argv[1], //"host" 
        1 => $argv[2], //"dbuser"
        2 => $argv[3], //"dbpassword"
        3 => $argv[4], //"dbname"
    );
    $prefix = $argv[5];
    Plusql::credentials( $profile, $details );
}
?>