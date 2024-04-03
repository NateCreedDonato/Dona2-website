<?php
/**
 * Enables gzip for servers that allows it or do not do it by default (Xneelo compresses by default I believe)
 */
namespace HISQ\Theme\Build;


class gzCompression
{

    public function __construct()
    {
        require_once(ABSPATH.'wp-admin/includes/misc.php');

        $insertion = array('<IfModule mod_deflate.c>',
        '# Compress HTML, CSS, JavaScript, Text, XML and fonts',
        'AddOutputFilterByType DEFLATE application/javascript',
        'AddOutputFilterByType DEFLATE application/rss+xml',
        'AddOutputFilterByType DEFLATE application/vnd.ms-fontobject',
        'AddOutputFilterByType DEFLATE application/x-font',
        'AddOutputFilterByType DEFLATE application/x-font-opentype',
        'AddOutputFilterByType DEFLATE application/x-font-otf',
        'AddOutputFilterByType DEFLATE application/x-font-truetype',
        'AddOutputFilterByType DEFLATE application/x-font-ttf',
        'AddOutputFilterByType DEFLATE application/x-javascript',
        'AddOutputFilterByType DEFLATE application/xhtml+xml',
        'AddOutputFilterByType DEFLATE application/xml',
        'AddOutputFilterByType DEFLATE font/opentype',
        'AddOutputFilterByType DEFLATE font/otf',
        'AddOutputFilterByType DEFLATE font/ttf',
        'AddOutputFilterByType DEFLATE image/svg+xml',
        'AddOutputFilterByType DEFLATE image/x-icon',
        'AddOutputFilterByType DEFLATE text/css',
        'AddOutputFilterByType DEFLATE text/html',
        'AddOutputFilterByType DEFLATE text/javascript',
        'AddOutputFilterByType DEFLATE text/plain',
        'AddOutputFilterByType DEFLATE text/xml',
        '# Remove browser bugs (only needed for really old browsers)',
        'BrowserMatch ^Mozilla/4 gzip-only-text/html',
        'BrowserMatch ^Mozilla/4\.0[678] no-gzip',
        'BrowserMatch \bMSIE !no-gzip !gzip-only-text/html',
        'Header append Vary User-Agent',
        '</IfModule>');

        $htaccess_file = ABSPATH.'.htaccess';
        return insert_with_markers($htaccess_file, 'Compression', (array) $insertion);

    }

}


