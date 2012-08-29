<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SSL Helpers
 *
 * @author              Andy Russell (@AndyMRussell)
 * @credit              Inspired by Choy Peng Kong
 */

if ( ! function_exists('remove_ssl'))
{       
    function remove_ssl()
    {
        $CI =& get_instance();
        $CI->config->config['base_url'] = str_replace('https://', 'http://', $CI->config->config['base_url']);
        if ($_SERVER['SERVER_PORT'] != 80)
        {
            redirect($CI->uri->uri_string());
        }   
    }
}

if (!function_exists('force_ssl'))
{
    function force_ssl()
    {
       $CI =& get_instance();

        $CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);
        if ($_SERVER['SERVER_PORT'] != 443)
        {
            redirect($CI->uri->uri_string());
        }       
    }
}

/* End of file ssl_helper.php */
/* Location: ./system/application/helpers/ssl_helper.php */