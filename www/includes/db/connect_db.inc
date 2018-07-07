<?php

function set_global_connection( $company = -1 )
{
    global $db, $transaction_level, $db_connections;

    cancel_transaction(); // cancel all aborted transactions if any
    $transaction_level = 0;

    if ( $company == -1 ) $company = $_SESSION[ "wa_current_user" ]->company;

    $_SESSION[ "wa_current_user" ]->cur_con = $company;

    $connection = $db_connections[ $company ];

    $db = mysql_connect( $connection[ "host" ], $connection[ "dbuser" ], $connection[ "dbpassword" ] );
    mysql_select_db( $connection[ "dbname" ], $db );
    return $db;
}

$db_duplicate_error_code = 1062;

//DB wrapper functions to change only once for whole application

function db_query( $sql, $err_msg = null )
{
    global $db, $show_sql, $sql_trail, $select_trail, $go_debug, $sql_queries, $Ajax,
    $db_connections, $db_last_inserted_id;

    // set current db prefix
    $cur_prefix = $db_connections[ $_SESSION[ "wa_current_user" ]->cur_con ][ 'tbpref' ];
    $sql = str_replace( TB_PREF, $cur_prefix, $sql );

    if ( $show_sql )
    {
        $Ajax->activate( 'footer_debug' );
        $sql_queries .= "<pre>$sql</pre>\n<hr>";
    }

    $result = mysql_query( $sql, $db );

    if ( $sql_trail )
    {
        $db_last_inserted_id = mysql_insert_id( $db ); // preserve in case trail insert is done
        if ( $select_trail || (strstr( $sql, 'SELECT' ) === false) )
        {
            mysql_query(
                    "INSERT INTO " . $cur_prefix . "sql_trail
				(`sql`, `result`, `msg`)
				VALUES(" . db_escape( $sql ) . "," . ($result ? 1 : 0) . ",
				" . db_escape( $err_msg ) . ")", $db );
        }
    }

    if ( $err_msg != null || $go_debug )
    {
        $exit = $err_msg != null;
        if ( function_exists( 'xdebug_call_file' ) ) check_db_error( '<br>At file ' . xdebug_call_file() . ':' . xdebug_call_line() . ':<br>' . $err_msg, $sql, $exit );
        else check_db_error( $err_msg, $sql, $exit );
    }
    return $result;
}

function db_fetch_row( $result )
{

    return mysql_fetch_row( $result );
}

function db_fetch_assoc( $result )
{

    return mysql_fetch_assoc( $result );
}

function db_fetch( $result )
{

    return mysql_fetch_array( $result );
}

function db_seek( &$result, $record )
{
    return mysql_data_seek( $result, $record );
}

function db_free_result( $result )
{
    if ( $result ) mysql_free_result( $result );
}

function db_num_rows( $result )
{
    return mysql_num_rows( $result );
}

function db_num_fields( $result )
{
    return mysql_num_fields( $result );
}

function strip( $value )
{
    if ( is_numeric( $value ) )
    {
        return $value;
    }
    if ( strlen( $value ) <= 0 )
    {
        return $value;
    }
    return addslashes( trim( $value ) );
}

function db_escape( $value = "", $nullify = false )
{
    $value = @html_entity_decode( $value, ENT_QUOTES, $_SESSION[ 'language' ]->encoding );
    $value = @htmlspecialchars( $value, ENT_QUOTES, $_SESSION[ 'language' ]->encoding );

    //reset default if second parameter is skipped
    $nullify = ($nullify === null) ? (false) : ($nullify);

    //check for null/unset/empty strings
    if ( (!isset( $value )) || (is_null( $value )) || ($value === "") )
    {
        $value = ($nullify) ? ("NULL") : ("''");
    }
    else
    {
        if ( is_string( $value ) )
        {
            //value is a string and should be quoted; determine best method based on available extensions
            if ( function_exists( 'mysql_real_escape_string' ) )
            {
                $value = "'" . mysql_real_escape_string( $value ) . "'";
            }
            else
            {
                $value = "'" . mysql_escape_string( $value ) . "'";
            }
        }
        else if ( !is_numeric( $value ) )
        {
            //value is not a string nor numeric
            display_error( "ERROR: incorrect data type send to sql query" );
            echo '<br><br>';
            exit();
        }
    }
    return $value;
}

function db_error_no()
{
    global $db;
    return mysql_errno( $db );
}

function db_error_msg( $conn )
{
    return mysql_error( $conn );
}

function db_insert_id()
{
    global $db_last_inserted_id, $sql_trail, $db;

    return $sql_trail ? $db_last_inserted_id : mysql_insert_id( $db );
}

function db_num_affected_rows()
{
    global $db;
    return mysql_affected_rows( $db );
}

function db_field_name( $result, $n )
{
    return mysql_field_name( $result, $n );
}

function db_create_db( $connection )
{
    $db = mysql_connect( $connection[ "host" ], $connection[ "dbuser" ], $connection[ "dbpassword" ] );
    if ( !mysql_select_db( $connection[ "dbname" ], $db ) )
    {
        $sql = "CREATE DATABASE " . $connection[ "dbname" ] . "";
        if ( !mysql_query( $sql ) || !mysql_select_db( $connection[ "dbname" ], $db ) ) return 0;
    }
    return $db;
}

function db_drop_db( $connection )
{

    if ( $connection[ "tbpref" ] == "" )
    {
        $sql = "DROP DATABASE " . $connection[ "dbname" ] . "";
        return mysql_query( $sql );
    }
    else
    {
        $res = db_query( "show table status" );
        $all_tables = array( );
        while ( $row = db_fetch( $res ) ) $all_tables[ ] = $row;
        // get table structures
        foreach ( $all_tables as $table )
        {
            if ( strpos( $table[ 'Name' ], $connection[ "tbpref" ] ) === 0 ) db_query( "DROP TABLE `" . $table[ 'Name' ] . "`" );
        }
        //deleting the tables, how??
        return true;
    }
}

function db_close( $dbase = null )
{
    global $db;

    if ( !$dbase ) $dbase = $db;
    return mysql_close( $dbase );
}

//--------------PluSQL helper functions---------------
function insert_PluSQL( $table, $arr, $pk, $label, $dup )
{
    global $profile;
    $basic = PluSQL::from( $profile )->$table->select( "count(*) as cnt,$pk" );
    $dup = strip( $dup );
    if ( is_numeric( $dup ) )
    {
        $basic = $basic->where( "$label = $dup" );
    }
    else
    {
        $basic = $basic->where( "$label = '$dup'" );
    }
    $basic = $basic->run()->$table;
    if ( $basic->cnt <= 0 )
    {
        PluSQL::into( $profile )->$table( $arr )->replace();
        pr("************ WE HAVE INSERTED A RECORD ******************");
        return true;
    }
    return false;
}

//--------------
function insert_advanced_PluSQL( $table, $arr, $pk, $conds = array( ) )
{
    global $profile;
    $basic = PluSQL::from( $profile )->$table->select( "count(*) as cnt,$pk" );
    $where = '';
    $found = false;
    foreach ( $conds as $label => $value )
    {
        $value = strip( $value );
        if ( is_numeric( $value ) )
        {
            $where .= " {$table}.{$label} = {$value} and";
        }
        else
        {
            $where .= " {$table}.{$label} = '{$value}' and";
        }
        $found = true;
    }
    if ( $found )
    {
        $where{strlen( $where ) - 1} = " ";
        $where{strlen( $where ) - 2} = " ";
        $where{strlen( $where ) - 3} = " ";
        $basic = $basic->where( $where );
    }
    $basic = $basic->run()->$table;
    if ( $found == false )
    {
        PluSQL::into( $profile )->$table( $arr )->replace();
        pr("************ WE HAVE INSERTED A RECORD ******************");
        return true;
    }
    else if ( $basic->cnt <= 0 )
    {
        PluSQL::into( $profile )->$table( $arr )->replace();
        pr("************ WE HAVE INSERTED A RECORD ******************");
        return true;
    }
    else
    {
        return false;
    }
}

//--------------
function update_PluSQL( $table, $arr, $label, $pk )
{
    global $profile;
    PluSQL::on( $profile )->$table( $arr )->where( "$label = $pk" )->update();
    pr("************ WE HAVE UPDATED A RECORD ******************");
}

//--------------
function delete_PluSQL( $table, $label, $pk )
{
    global $profile;
    $sql = "DELETE FROM $table WHERE $label = $pk";
    PluSQL::against( $profile )->run( $sql );
    pr("************ WE HAVE DELETED A RECORD ******************");
}

//--------------
function select_PluSQL( $table, $fields, $args = array( ) )
{
    if ( empty( $args ) )
    {
        $args[ 'enable_where' ] = 0;
        $args[ 'disable_long_name' ] = 0;
        $args[ 'join_type' ] = 0; //0 = to the parent, 1 = extended
    }
    else
    {
        if ( !isset( $args[ 'enable_where' ] ) )
        {
            $args[ 'enable_where' ] = 0;
        }
        if ( !isset( $args[ 'disable_long_name' ] ) )
        {
            $args[ 'disable_long_name' ] = 0;
        }
        if ( !isset( $args[ 'join_type' ] ) )
        {
            $args[ 'join_type' ] = 0;
        }
    }
    global $profile;
    $basic = PluSQL::from( $profile )->$table->select( "*" );
    $where = '';
    $cfound = false;
    $backup = $table;
    if ( isset( $args[ 'skip_prefix' ] ) && $args[ 'skip_prefix' ] == 1 )
    {
        $table = '';
    }
    else
    {
        $table = $table . '.';
    }
    foreach ( $fields as $label => $value )
    {
        if ( is_array( $value ) ) //join
        {
            if ( isset( $args[ 'skip_prefix' ] ) && $args[ 'skip_prefix' ] == 1 )
            {
                $value[ 'table' ] = '';
            }
            else
            {
                $value[ 'table' ] = $value[ 'table' ] . '.';
            }
            if ( !is_empty( $value[ 'value' ], $value[ 'label' ], 0 ) )
            {
                if ( is_array( $value[ 'value' ] ) )
                {
                    $vfound = false;
                    $wtemp = "";
                    foreach ( $value[ 'value' ] as $conds )
                    {
                        $lab = "";
                        if ( isset( $conds[ 'label' ] ) )
                        {
                            $lab = $conds[ 'label' ];
                        }
                        else
                        {
                            $lab = $value[ 'label' ];
                        }
                        if ( is_numeric( $conds[ 'value' ] ) )
                        {
                            $wtemp .= " {$value[ 'table' ]}{$lab} {$conds[ 'operator' ]} {$conds[ 'value' ]} {$conds[ 'attachment' ]}";
                            $vfound = true;
                        }
                        else
                        {
                            $wtemp .= " {$value[ 'table' ]}{$lab} {$conds[ 'operator' ]} '{$conds[ 'value' ]}' {$conds[ 'attachment' ]}";
                            $vfound = true;
                        }
                    }
                    if ( $vfound == true )
                    {
                        $wtemp{strlen( $wtemp ) - 1} = " ";
                        $wtemp{strlen( $wtemp ) - 2} = " ";
                        $wtemp{strlen( $wtemp ) - 3} = " ";
                        $where .= "( $wtemp ) and";
                    }
                }
                else if ( $args[ 'enable_where' ] == 1 )
                {
                    if ( is_numeric( $value[ 'value' ] ) )
                    {
                        $where .= " {$value[ 'table' ]}{$value[ 'label' ]} = {$value[ 'value' ]} and";
                    }
                    else
                    {
                        $where .= " {$value[ 'table' ]}{$value[ 'label' ]} = '{$value[ 'value' ]}' and";
                    }
                }
                else
                {
                    $where .= " {$value[ 'table' ]}{$value[ 'label' ]} like '%{$value[ 'value' ]}%' and";
                }
                $cfound = true;
            }
        }
        else //single table
        {
            if ( !is_empty( $value, $label, 0 ) )
            {
                if ( $args[ 'enable_where' ] == 1 )
                {
                    if ( is_numeric( $value ) )
                    {
                        $where .= " {$table}{$label} = {$value} and";
                    }
                    else
                    {
                        $where .= " {$table}{$label} = '{$value}' and";
                    }
                }
                else
                {
                    $where .= " {$table}{$label} like '%{$value}%' and";
                }
                $cfound = true;
            }
        }
    }
    if ( $cfound == true )
    {
        $where{strlen( $where ) - 1} = " ";
        $where{strlen( $where ) - 2} = " ";
        $where{strlen( $where ) - 3} = " ";
        $basic = $basic->where( $where );
    }
    if ( isset( $args[ 'limit' ] ) )
    {
        $basic = $basic->limit( $args[ 'limit' ] );
    }
    else
    {
        $basic = $basic->limit( '0,1' );
    }
    if ( isset( $args[ 'orderBy' ] ) )
    {
        $basic = $basic->orderBy( $args[ 'orderBy' ] );
    }
    $table = $backup;
    return $basic->run()->$table;
}

//--------------
//table with no joins --- single table only
function search_PluSQL( $table, $fields, $args = array( ) )
{
    return querygen_PluSQL( $table, $fields, $args );
}

//for single and inner joins
function querygen_PluSQL( $table, $fields, $args = array( ) )
{
    if ( empty( $args ) )
    {
        $args[ 'enable_where' ] = 0;
        $args[ 'disable_long_name' ] = 0;
        $args[ 'join_type' ] = 0; //0 = to the parent, 1 = extended
    }
    else
    {
        if ( !isset( $args[ 'enable_where' ] ) )
        {
            $args[ 'enable_where' ] = 0;
        }
        if ( !isset( $args[ 'disable_long_name' ] ) )
        {
            $args[ 'disable_long_name' ] = 0;
        }
        if ( !isset( $args[ 'join_type' ] ) )
        {
            $args[ 'join_type' ] = 0;
        }
    }
    global $profile;
    $select = '';
    $joins = array( );
    $where = '';
    $cfound = false;
    foreach ( $fields as $label => $value )
    {
        if ( is_array( $value ) ) //join
        {
            $backup_table = $value[ 'table' ];
            if ( isset( $args[ 'skip_prefix' ] ) && $args[ 'skip_prefix' ] == 1 )
            {
                $value[ 'table' ] = '';
            }
            else
            {
                $value[ 'table' ] = $value[ 'table' ] . '.';
            }
            $select .= $value[ 'table' ] . $value[ 'label' ]; //$backup_table.'.'
            if ( $args[ 'disable_long_name' ] == 0 )
            {
                $select .= ' as ' . $backup_table . '$' . $label . ' ,';
            }
            else
            {
                $select .= ' ,';
            }
            if ( strcmp( $backup_table, $table ) != 0 )
            {
                if ( isset( $value[ 'joinType' ] ) )
                {
                    //$joins['joinType'] = $value['joinType'];
                    $joins[ ] = array( 'table' => $backup_table, 'joinType' => $value[ 'joinType' ] );
                }
                else
                {
                    $joins[ ] = array( 'table' => $backup_table );
                }
            }
            if ( !is_empty( $value[ 'value' ], $value[ 'label' ], 0 ) )
            {
                if ( is_array( $value[ 'value' ] ) )
                {
                    $vfound = false;
                    $wtemp = "";
                    foreach ( $value[ 'value' ] as $conds )
                    {
                        if ( !is_empty( $conds[ 'value' ], @$conds[ 'label' ], 0 ) )
                        {
                            $lab = "";
                            if ( isset( $conds[ 'label' ] ) )
                            {
                                $lab = $conds[ 'label' ];
                            }
                            else
                            {
                                $lab = $value[ 'label' ];
                            }
                            if ( is_numeric( $conds[ 'value' ] ) )
                            {
                                $wtemp .= " {$value[ 'table' ]}{$lab} {$conds[ 'operator' ]} {$conds[ 'value' ]} {$conds[ 'attachment' ]}";
                            }
                            else
                            {
                                if ( isset( $conds[ 'force_numeric' ] ) ) $wtemp .= " {$value[ 'table' ]}{$lab} {$conds[ 'operator' ]} {$conds[ 'value' ]} {$conds[ 'attachment' ]}";
                                else $wtemp .= " {$value[ 'table' ]}{$lab} {$conds[ 'operator' ]} '{$conds[ 'value' ]}' {$conds[ 'attachment' ]}";
                            }
                            $cfound = true;
                            $vfound = true;
                        }
                    }
                    if ( $vfound == true )
                    {
                        $wtemp{strlen( $wtemp ) - 1} = " ";
                        $wtemp{strlen( $wtemp ) - 2} = " ";
                        $wtemp{strlen( $wtemp ) - 3} = " ";
                        $where .= "( $wtemp ) and";
                    }
                }
                else if ( $args[ 'enable_where' ] == 1 )
                {
                    if ( is_numeric( $value[ 'value' ] ) )
                    {
                        $where .= " {$value[ 'table' ]}{$value[ 'label' ]} = {$value[ 'value' ]} and";
                    }
                    else
                    {
                        $where .= " {$value[ 'table' ]}{$value[ 'label' ]} = '{$value[ 'value' ]}' and";
                    }
                    $cfound = true;
                }
                else
                {
                    $value[ 'value' ] = trim( $value[ 'value' ] );
                    $where .= " {$value[ 'table' ]}{$value[ 'label' ]} like '%{$value[ 'value' ]}%' and";
                    $cfound = true;
                }
            }
            $value[ 'table' ] = $backup_table;
        }
        else //single table
        {
            $backup_table = $table;
            if ( isset( $args[ 'skip_prefix' ] ) && $args[ 'skip_prefix' ] == 1 )
            {
                $table = '';
            }
            else
            {
                $table = $table . '.';
            }
            $select .= $table . $label;
            if ( $args[ 'disable_long_name' ] == 0 )
            {
                $select .= ' as ' . $backup_table . '$' . $label . ' ,';
            }
            else
            {
                $select .= ' ,';
            }
            if ( !is_empty( $value, $label, 0 ) )
            {
                if ( $args[ 'enable_where' ] == 1 )
                {
                    if ( is_numeric( $value ) )
                    {
                        $where .= " {$table}{$label} = {$value} and";
                    }
                    else
                    {
                        $where .= " {$table}{$label} = '{$value}' and";
                    }
                }
                else
                {
                    $value = trim( $value );
                    $where .= " {$table}{$label} like '%{$value}%' and";
                }
                $cfound = true;
            }
            $table = $backup_table;
        }
    }
    if ( $cfound == true )
    {
        $where{strlen( $where ) - 1} = " ";
        $where{strlen( $where ) - 2} = " ";
        $where{strlen( $where ) - 3} = " ";
        $where = "where $where";
    }
    $select{strlen( $select ) - 1} = " ";
    $basic = PluSQL::from( $profile )->$table;
    foreach ( $joins as $Join )
    {
        $join = $Join[ 'table' ];
        if ( $args[ 'join_type' ] == 0 )
        {
            $basic = $basic->$join( $table );
        }
        else
        {
            $basic = $basic->$join;
        }
        if ( isset( $Join[ 'joinType' ] ) )
        {
            switch ( $Join[ 'joinType' ] )
            {
                case PLUSQL_LEFT_JOIN:
                    $basic = $basic->joinType( PluSQL\Table::LEFT_JOIN );
                    break;
                case PLUSQL_RIGHT_JOIN:
                    $basic = $basic->joinType( PluSQL\Table::RIGHT_JOIN );
                    break;
            }
        }
    }
    $basic = $basic->select( $select );

    ob_start();
    echo $basic;
    $sql = ob_get_contents();
    ob_end_clean();

    $sql = "$sql $where";

    if ( isset( $args[ 'orderBy' ] ) )
    {
        $sql = "$sql ORDER BY {$args[ 'orderBy' ]}";
    }

    pr( "querygen_PluSQL = " . $sql );
    return $sql;
}

define( "PLUSQL_LEFT_JOIN", 1 );
define( "PLUSQL_RIGHT_JOIN", 2 );
define( "PLUSQL_INNER_JOIN", 3 );
?>