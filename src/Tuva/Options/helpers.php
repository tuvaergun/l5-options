<?php
use Tuva\Options\Facades\Options;
if (!function_exists('options'))
{
    /**
     * @param $key
     * @param null $default
     * @return mixed|\Efriandika\LaravelSettings\Facades\Settings
     */
    function options($key, $default = null)
    {
        return Options::get($key, $default);
    }
}