<?php
/**
 * URL Helper - Generate path-based URLs
 */

if (!function_exists('base_url')) {
    function base_url($path = '') {
        if (defined('BASE_URL')) {
            return BASE_URL . $path;
        }
        return '/' . ltrim($path, '/');
    }
}
