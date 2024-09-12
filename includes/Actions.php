<?php

require_once WC_FNC_HELPER_PLUGIN_PATH . 'includes/CustomAdminPages.php';

class Actions
{
    public static function onActivate()
    {
        flush_rewrite_rules();
    }

    public static function onDeactivate()
    {
        flush_rewrite_rules();
    }

}