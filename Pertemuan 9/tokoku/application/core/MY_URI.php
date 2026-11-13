<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Perbaikan CodeIgniter 3 untuk folder aplikasi yang namanya mengandung spasi
 * (mis. htdocs/PBKK/Pertemuan 9/siakad). URL browser memakai %20, sedangkan
 * SCRIPT_NAME memakai spasi, sehingga parser bawaan gagal (404).
 */
class MY_URI extends CI_URI {

    protected function _parse_request_uri()
    {
        if ( ! isset($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']))
        {
            return '';
        }

        $uri = parse_url('http://dummy'.$_SERVER['REQUEST_URI']);
        $query = isset($uri['query']) ? $uri['query'] : '';
        $uri = isset($uri['path']) ? $uri['path'] : '';

        if (isset($_SERVER['SCRIPT_NAME'][0]))
        {
            $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
            $dir    = str_replace('\\', '/', dirname($script));
            $candidates = array($script, $this->_encode_path($script), $dir, $this->_encode_path($dir));

            foreach ($candidates as $c)
            {
                if ($c !== '' && $c !== '/' && strpos($uri, $c) === 0)
                {
                    $uri = (string) substr($uri, strlen($c));
                    break;
                }
            }
        }

        if (trim($uri, '/') === '' && strncmp($query, '/', 1) === 0)
        {
            $query = explode('?', $query, 2);
            $uri = $query[0];
            $_SERVER['QUERY_STRING'] = isset($query[1]) ? $query[1] : '';
        }
        else
        {
            $_SERVER['QUERY_STRING'] = $query;
        }

        parse_str($_SERVER['QUERY_STRING'], $_GET);

        if ($uri === '/' OR $uri === '')
        {
            return '/';
        }

        return $this->_remove_relative_directory($uri);
    }

    // "/PBKK/Pertemuan 9/x" -> "/PBKK/Pertemuan%209/x"
    protected function _encode_path($path)
    {
        return implode('/', array_map('rawurlencode', explode('/', $path)));
    }
}
