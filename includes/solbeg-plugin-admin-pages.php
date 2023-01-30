<?php
/**
 * @package SolbegPlugin
 */

class SolbegPluginAdminPages
{

    public static function add_admin_pages()
    {
        add_menu_page(
            'Solbeg Plugin',
            'Solbeg',
            'manage_options',
            'solbeg',
            ['SolbegPluginAdminPages', 'general_section'],
            'dashicons-filter',
            '66'

        );
    }

    public static function general_section(){
        require plugin_dir_path(__DIR__) . 'views/general-section.php';
    }
}
