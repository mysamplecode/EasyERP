<?php

class towel_app extends application
{

    function towel_app()
    {

        $this->application( "towel", _( $this->help_context = "Towel" ), true );

        $this->add_module( _( "Transactions" ) );

        $this->add_module( _( "Inquiries and Reports" ) );

        $this->add_module( _( "Maintenance " ) );

        // submenus for transaction module

        $this->add_lapp_function( 0, _( "Enter new inventory" ), "towel/manage/add_manage_inventory.php", 'SA_TOWEL_FORMS', MENU_ENTRY );

        $this->add_lapp_function( 0, _( "Create lot" ), "towel/manage/add_manage_lots.php", 'SA_TOWEL_FORMS', MENU_ENTRY );

        $this->add_lapp_function( 0, _( "Issue lot" ), "towel/manage/add_manage_ilot.php", 'SA_TOWEL_FORMS', MENU_ENTRY );

        $this->add_rapp_function( 0, _( "Process lot" ), "towel/manage/add_manage_plot.php", 'SA_TOWEL_FORMS', MENU_ENTRY );

        $this->add_rapp_function( 0, _( "Dispatch Lot" ), "towel/manage/add_manage_dlot.php", 'SA_TOWEL_FORMS', MENU_ENTRY );


        // submenus for Inquiries and Reports module

        $this->add_lapp_function( 1, _( "Inventory Reports" ), "towel/reports/inventory_reports.php", 'SA_TOWEL_FORMS', MENU_ENTRY );
        $this->add_lapp_function( 1, _( "Efficiency Report" ), "towel/reports/lots_reports.php", 'SA_TOWEL_FORMS', MENU_ENTRY );


        $this->add_lapp_function( 2, _( "Add and Manage Supplier" ), "towel/manage/add_manage_supplier.php", 'SA_TOWEL_FORMS', MENU_MAINTENANCE );
        $this->add_lapp_function( 2, _( "Add and Manage Towel Sizes" ), "towel/manage/add_manage_tsize.php", 'SA_TOWEL_FORMS', MENU_MAINTENANCE );
        $this->add_lapp_function( 2, _( "Add and Manage Efficiency parameters" ), "towel/manage/add_manage_eparam.php", 'SA_TOWEL_FORMS', MENU_MAINTENANCE );
        $this->add_lapp_function( 2, _( "Add and Manage Customers" ), "towel/manage/add_manage_customer.php", 'SA_TOWEL_FORMS', MENU_MAINTENANCE );


        // submenus for Maintenance module




        $this->add_extensions();
    }

}

?>