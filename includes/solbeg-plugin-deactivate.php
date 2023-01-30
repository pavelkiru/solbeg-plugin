<?php
/**
 * @package SolbegPlugin
 */


class SolbegPluginDeactivate
{
    public static function deactivate()
    {
        flush_rewrite_rules();
    }
}