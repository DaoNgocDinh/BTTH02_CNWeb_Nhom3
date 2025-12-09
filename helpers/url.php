<?php
/**
 * URL Helper - Generate path-based URLs
 */

if (!function_exists('base_url')) {
    function base_url($path = '') {
        return '/BTTH02_CNWeb_Nhom3' . $path;
    }
}
