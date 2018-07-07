<?php

function display_heading_with_breaks( $heading, $before, $after )
{
    br( $before );
    display_heading( $heading );
    br( $after );
}

function page_start( $context, $multi = false )
{
    page( _( $help_context = $context ), false, false, "", '' );
    start_form( $multi );
}

function page_end()
{
    end_form();
    end_page( false );
}

function new_headers_start( $context, $heading = 1, $title = '' )
{
    if ( $heading )
    {
        if ( empty( $title ) )
        {
            display_heading( "Add new $context" );
        }
        else
        {
            display_heading( $title );
        }

        br( 1 );
    }
    start_table( TABLESTYLE2 );
}

function new_headers_end( $selected_id, $submit = 1 )
{
    end_table( 1 );
    if ( $submit ) submit_add_or_update_center( $selected_id == -1, '', 'both' );
    br( 1 );
}

function new_tabs_start( $controller, $tabs, $selected_id, $args = array( ) )
{
    $controller = strtolower( $controller );
    $count = 0;
    $first = '';
    $ltabs = array( );
    $func = 'temp';
    if ( !isset( $_POST[ "_" . $controller . "_sel" ] ) )
    {
        $_POST[ "_" . $controller . "_sel" ] = '';
    }
    foreach ( $tabs as $key => $tab )
    {
        $ltabs[ $key ] = array( );
        $ltabs[ $key ][ 0 ] = $tab[ 0 ];
        if ( ($selected_id == -1) && ($count == 0) )
        {
            $ltabs[ $key ][ 1 ] = 1;
            $count++;
        }
        else if ( $selected_id != -1 )
        {
            $ltabs[ $key ][ 1 ] = 1;
        }
        else
        {
            $ltabs[ $key ][ 1 ] = 0;
        }
    }
    tabbed_content_start( $controller, $ltabs );
    $count = 0;
    foreach ( $tabs as $key => $tab )
    {
        if ( ($selected_id != -1) && (strcmp( $_POST[ "_" . $controller . "_sel" ], $key ) == 0) )
        {
            $func = $tab[ 1 ];
        }
        else if ( ($selected_id == -1) && ($count == 0) )
        {
            $func = $tab[ 1 ];
            $count++;
        }
        else
        {
            
        }
    }
    $func( $args );
}

function new_tabs_end()
{
    tabbed_content_end();
}

function search_headers_start( $context, $search = 1, $print = 1 )
{
    display_heading( "Filter & Print $context" );
    br( 1 );
    start_table( TABLESTYLE2 );
    row_start();
    labelheader_cell( 'Fields' );
    if ( $search ) labelheader_cell( 'Search' );
    if ( $print ) labelheader_cell( 'Print' );
    row_end();
}

function search_headers_end( $search = 1, $print = 1, $card = 0 )
{
    end_table( 1 );
    br( 1 );
    if ( $search == 1 && $print == 1 )
    {
        submit_center_first( 'SearchOrders', _( "Search" ), _( 'Select documents' ), 'default' );
        submit_center_last( 'PrintOrders', _( "Print" ), _( 'Print documents' ), 'default' );
    }
    else if ( $search == 1 && $print == 0 )
    {
        submit_center( 'SearchOrders', _( "Search" ), _( 'Select documents' ), 'default' );
    }
    else if ( $search == 0 && $print == 1 )
    {
        submit_center( 'PrintOrders', _( "Print" ), _( 'Print documents' ), 'default' );
    }
    else
    {
        //do nothing - stupid call
    }
    br( 1 );
    if ( $card )
    {
        submit_center( 'CardOrders', _( "Print All Cards" ), _( 'Print All Cards' ), 'default' );
        br( 1 );
    }
}

function pager_display( $name, $th, $sql, $table_width, $hidden_marker, $edit_mode = 'edit_link', $delete_mode = 'delete_link', $print_mode = null, $card_mode = null, $allow_print = false, $path = "", $heading = null, $table_records = null )
{
    if ( !is_null( $edit_mode ) && !empty( $edit_mode ) )
    {
        array_append( $th, array( 'Edit' => array( 'insert' => true, 'fun' => $edit_mode ) ) );
    }
    if ( !is_null( $print_mode ) && !empty( $print_mode ) )
    {
        array_append( $th, array( 'Print' => array( 'insert' => true, 'fun' => $print_mode ) ) );
    }
    if ( !is_null( $card_mode ) && !empty( $card_mode ) )
    {
        array_append( $th, array( 'Card' => array( 'insert' => true, 'fun' => $card_mode ) ) );
    }
    if ( !is_null( $delete_mode ) && !empty( $delete_mode ) )
    {
        array_append( $th, array( 'Delete' => array( 'insert' => true, 'fun' => $delete_mode ) ) );
    }
    if ( !empty( $heading ) )
    {
        display_heading( $heading );
        br( 1 );
    }
    $table = &new_db_pager( $name, $sql, $th );
    $table->width = $table_width;
    if ( !empty( $table_records ) )
    {
        $table->page_len = $table_records;
    }
    display_db_pager( $table );
    hidden( 'REP_ID', $hidden_marker );
    if ( $allow_print )
    {
        //--------------------------
        br( 1 );
        submit_center( $name, _( "Print" ), 'Print', 'default' );
        br( 1 );
        //---print item---------------
        if ( isset( $_POST[ $name ] ) )
        {
            $rep_file = find_custom_file( $path . "rep_" . strtolower( $name ) . ".php" );
            if ( $rep_file )
            {
                require($rep_file);
            }
            die();
        }
    }
}

function custom_pager_display( $name, $th, $sql, $table_width, $table_count, $hidden_marker, $edit_mode = 'edit_link', $delete_mode = 'delete_link', $print_mode = null, $card_mode = null, $allow_print = false, $path = "", $heading = null, $table_records = null )
{
    if ( !is_null( $edit_mode ) && !empty( $edit_mode ) )
    {
        array_append( $th, array( 'Edit' => array( 'insert' => true, 'fun' => $edit_mode ) ) );
    }
    if ( !is_null( $print_mode ) && !empty( $print_mode ) )
    {
        array_append( $th, array( 'Print' => array( 'insert' => true, 'fun' => $print_mode ) ) );
    }
    if ( !is_null( $card_mode ) && !empty( $card_mode ) )
    {
        array_append( $th, array( 'Card' => array( 'insert' => true, 'fun' => $card_mode ) ) );
    }
    if ( !is_null( $delete_mode ) && !empty( $delete_mode ) )
    {
        array_append( $th, array( 'Delete' => array( 'insert' => true, 'fun' => $delete_mode ) ) );
    }
    if ( !empty( $heading ) )
    {
        display_heading( $heading );
        br( 1 );
    }
    $table = &new_db_pager( $name, $sql, $th );
    $table->width = $table_width;
    $table->rawsql = $sql;
    if ( $table->curr_page == null )
    {
        $table->curr_page = 1;
    }
    $table->custom_rec_count = $table_count;
    if ( !empty( $table_records ) )
    {
        $table->page_len = $table_records;
    }
    display_db_pager( $table );
    hidden( 'REP_ID', $hidden_marker );
    if ( $allow_print )
    {
        //--------------------------
        br( 1 );
        submit_center( $name, _( "Print" ), 'Print', 'default' );
        br( 1 );
        //---print item---------------
        if ( isset( $_POST[ $name ] ) )
        {
            $rep_file = find_custom_file( $path . "rep_" . strtolower( $name ) . ".php" );
            if ( $rep_file )
            {
                require($rep_file);
            }
            die();
        }
    }
}

function pdf_simple_header( $rep, $fields )
{
    $letter_multiplier = 8;
    $cols = array( 0, 5 * $letter_multiplier );
    $headers = array( _( '#' ) );
    $aligns = array( 'left' );
    $cstart = 0;
    foreach ( $fields as $field => $arr )
    {
        if ( 1 )
        {
            $headers[ ] = $arr[ 0 ]; //headers
            $aligns[ ] = $arr[ 1 ]; //alignment
            $cols[ ] = $cstart + ($arr[ 2 ] * $letter_multiplier); //column width
            $cstart = $cstart + ($arr[ 2 ] * $letter_multiplier);
        }
    }
    $rep->Info( array( 0 => '' ), $cols, $headers, $aligns );
    //$rep->NewPage();
}

function pdf_header_start( $name, $fields, $size = 'A4', $orientation = 'P', $fontsize = 9, $skip_print_constraints = false )
{
    $letter_multiplier = 8;
    $cols = array( 0, 5 * $letter_multiplier );
    $headers = array( _( '#' ) );
    $aligns = array( 'left' );
    $cstart = 0;
    foreach ( $fields as $field => $arr )
    {
        if ( $skip_print_constraints )
        {
            $headers[ ] = $arr[ 0 ]; //headers
            $aligns[ ] = $arr[ 1 ]; //alignment
            $cols[ ] = $cstart + ($arr[ 2 ] * $letter_multiplier); //column width
            $cstart = $cstart + ($arr[ 2 ] * $letter_multiplier);
        }
        else
        {
            if ( isset( $_POST[ "print_" . $field ] ) && strcmp( $_POST[ "print_" . $field ], '1' ) == 0 )
            {
                $headers[ ] = $arr[ 0 ]; //headers
                $aligns[ ] = $arr[ 1 ]; //alignment
                $cols[ ] = $cstart + ($arr[ 2 ] * $letter_multiplier); //column width
                $cstart = $cstart + ($arr[ 2 ] * $letter_multiplier);
            }
        }
    }
    $rep = new FrontReport( _( $name ), $name, $size, $fontsize, $orientation );
    $rep->Info( array( 0 => '' ), $cols, $headers, $aligns );
    //$rep->NewPage();
    return $rep;
}

define( 'PDF_MONEY', 1 );
define( 'PDF_NUMBER', 2 );

function pdf_body_display( $rep, $sql, $fields, $skip_print_constraints = false )
{
    //return;
    global $profile;
    if ( strlen( $sql ) <= 0 ) return;
    $result = PluSQL::against( $profile )->run( $sql );
    $ftotal = 0;
    foreach ( $fields as $field => $arr )
    {
        if ( isset( $_POST[ "print_" . $field ] ) && strcmp( $_POST[ "print_" . $field ], '1' ) == 0 )
        {
            $ftotal++;
        }
    }
    $num_lines = 0;
    while ( $res = $result->nextRow() )
    {
        if ( $num_lines == 0 )
        {
            $rep->NewPage();
        }
        $num_lines++;
        $fcount = 1;
        $rep->TextCol( 0, $fcount, $num_lines );
        foreach ( $fields as $field => $arr )
        {
            if ( !isset( $arr[ 5 ] ) )
            {
                $arr[ 5 ] = "%s";
            }
            if ( (isset( $_POST[ "print_" . $field ] ) && strcmp( $_POST[ "print_" . $field ], '1' ) == 0) || ($skip_print_constraints) )
            {
                foreach ( $res as $key => $ind )
                {
                    $temp = explode( '$', $key );
                    if ( isset( $temp[ 1 ] ) )
                    {
                        if ( strcmp( $field, $temp[ 1 ] ) == 0 )
                        {
                            if ( isset( $arr[ 3 ] ) && !empty( $arr[ 3 ] ) )
                            {
                                $placed = 0;
                                foreach ( $arr[ 3 ] as $kk => $ii )
                                {
                                    if ( strcmp( $ind, $kk ) == 0 )
                                    {
                                        if ( isset( $arr[ 4 ] ) && !empty( $arr[ 4 ] ) && $arr[ 4 ] == PDF_MONEY )
                                        {
                                            $rep->TextCol( $fcount, $fcount + 1, sprintf( $arr[ 5 ], number_format( substr( $ii, 0, $arr[ 2 ] ), 2, '.', ',' ) ) );
                                        }
                                        else if ( isset( $arr[ 4 ] ) && !empty( $arr[ 4 ] ) && $arr[ 4 ] == PDF_NUMBER )
                                        {
                                            $rep->TextCol( $fcount, $fcount + 1, sprintf( $arr[ 5 ], number_format( substr( $ii, 0, $arr[ 2 ] ), 2 ) ) );
                                        }
                                        else
                                        {
                                            $rep->TextCol( $fcount, $fcount + 1, sprintf( $arr[ 5 ], substr( $ii, 0, $arr[ 2 ] ) ) );
                                        }
                                        $placed = 1;
                                        break;
                                    }
                                }
                                if ( $placed == 0 )
                                {
                                    if ( isset( $arr[ 4 ] ) && !empty( $arr[ 4 ] ) && $arr[ 4 ] == PDF_MONEY )
                                    {
                                        $rep->TextCol( $fcount, $ftotal, sprintf( $arr[ 5 ], number_format( substr( $ind, 0, $arr[ 2 ] ), 2, '.', ',' ) ) );
                                    }
                                    else if ( isset( $arr[ 4 ] ) && !empty( $arr[ 4 ] ) && $arr[ 4 ] == PDF_NUMBER )
                                    {
                                        $rep->TextCol( $fcount, $fcount + 1, sprintf( $arr[ 5 ], number_format( substr( $ind, 0, $arr[ 2 ] ), 2 ) ) );
                                    }
                                    else
                                    {
                                        $rep->TextCol( $fcount, $fcount + 1, sprintf( $arr[ 5 ], substr( $ind, 0, $arr[ 2 ] ) ) );
                                    }
                                }
                            }
                            else
                            {
                                if ( isset( $arr[ 4 ] ) && !empty( $arr[ 4 ] ) && $arr[ 4 ] == PDF_MONEY )
                                {
                                    $rep->TextCol( $fcount, $fcount + 1, sprintf( $arr[ 5 ], number_format( substr( $ind, 0, $arr[ 2 ] ), 2, '.', ',' ) ) );
                                }
                                else if ( isset( $arr[ 4 ] ) && !empty( $arr[ 4 ] ) && $arr[ 4 ] == PDF_NUMBER )
                                {
                                    $rep->TextCol( $fcount, $fcount + 1, sprintf( $arr[ 5 ], number_format( substr( $ind, 0, $arr[ 2 ] ), 2 ) ) );
                                }
                                else
                                {
                                    $rep->TextCol( $fcount, $fcount + 1, sprintf( $arr[ 5 ], substr( $ind, 0, $arr[ 2 ] ) ) );
                                }
                            }
                            $fcount++;
                        }
                    }
                }
            }
        }
        $rep->NewLine( 1, 0 );
    }
}

function pdf_header_end( $rep )
{
    //return;
    $rep->Line( $rep->row - 4 );
    $rep->NewLine();
    $rep->End();
}

?>