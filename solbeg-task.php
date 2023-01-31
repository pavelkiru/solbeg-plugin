<?php
/*
Plugin Name:  Solbeg Plugin
Plugin URI:   https://github.com/pavelkiru/solbeg-plugin
Description:  Solbeg Test Plugin
Version:      1.0
Author:       Pavel
Author URI:   https://github.com/pavelkiru
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wpb-tutorial
Domain Path:  /languages
*/


if (!defined('WPINC')) {
    die;
}

define('MINIMUM_PHP_VERSION', '7.4');
define('CURRENT_PHP_VERSION', phpversion());

require_once plugin_dir_path(__FILE__) . 'includes/solbeg-plugin-activate.php';
require_once plugin_dir_path(__FILE__) . 'includes/solbeg-plugin-deactivate.php';
require_once plugin_dir_path(__FILE__) . 'includes/solbeg-plugin-admin-pages.php';


if (version_compare(floatval(CURRENT_PHP_VERSION), MINIMUM_PHP_VERSION, '<')) {

    // деактивируем
    add_action('admin_init', 'deactivate_plugin');
    function deactivate_plugin()
    {
        deactivate_plugins(plugin_basename(__FILE__));
    }

    //  уведомление
    add_action('admin_notices', 'deactivate_plugin_message');
    function deactivate_plugin_message($CURRENT_PHP_VERSION)
    {
        echo "<div class='notice notice-error'>
                    <p><strong>Solbeg Plugin</strong> деактивирован, для корректной работы необходима версия PHP не ниже 7.4. Текущая версия " . CURRENT_PHP_VERSION . "</p>
                    </div>";

        if (isset($_GET['activate']))
            unset($_GET['activate']);
    }

}

class Solbeg
{

    public function __construct()
    {

        add_filter('the_title', [$this, 'add_data_published_to_post_title']);

        add_action('admin_enqueue_scripts', ['Solbeg', 'enqueue']);

        add_action('admin_menu', ['SolbegPluginAdminPages', 'add_admin_pages']);
    }


    public function add_data_published_to_post_title($the_title)
    {
        if (is_single() && in_the_loop()) {
            $get_post_data = get_the_date();
            return $the_title . ' ' . $get_post_data;
        }
        return $the_title;
    }

    static function enqueue()
    {

        wp_enqueue_style('solbegpluginstyle', plugins_url('/assets/css/solbeg-plugin.css', __FILE__));
        wp_enqueue_script('solbegpluginscript', plugins_url('/assets/js/solbeg-plugin.js', __FILE__));
    }
}

new Solbeg();


register_activation_hook(__FILE__, ['SolbegPluginActivate', 'activate']);


register_deactivation_hook(__FILE__, ['SolbegPluginDeactivate', 'deactivate']);


register_uninstall_hook(__FILE__, 'uninstall');










