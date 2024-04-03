<?php
/**
 * Enables gzip for servers that allows it or do not do it by default (Xneelo compresses by default I believe)
 */
namespace HISQ\Theme\Build;


class browser_cache
{

    public function __construct()
    {
        require_once(ABSPATH.'wp-admin/includes/misc.php');

        $insertion = array('<IfModule mod_expires.c>',
                            'FileETag MTime Size',
                            'AddOutputFilterByType DEFLATE text/plain text/html text/xml text/css application/xml application/xhtml+xml application/rss+xml application/javascript application/x-javascript',
                            'ExpiresActive On',
                            'ExpiresByType text/css "access 1 month"',
                            'ExpiresByType text/javascript "access 1 month"',
                            'ExpiresByType text/x-javascript "access 1 month"',
                            'ExpiresByType application/javascript "access 1 month"',
                            'ExpiresByType application/x-javascript "access 1 month"',
                            'ExpiresByType application/x-shockwave-flash "access 1 month"',
                            'ExpiresByType application/pdf "access 1 month"',
                            'ExpiresByType image/x-icon "access 1 year"',
                            'ExpiresByType image/jpg "access 1 year"',
                            'ExpiresByType image/jpeg "access 1 year"',
                            'ExpiresByType image/png "access 1 year"',
                            'ExpiresByType image/gif "access 1 year"',
                            'ExpiresDefault "access 1 month"',
                            '</IfModule>',
                            '<ifModule mod_headers.c>',
                            '<filesMatch "\.(ico|jpe?g|png|gif|swf)$">',
                            'Header set Cache-Control "max-age=31556952, public"',
                            '</filesMatch>',
                            '<filesMatch "\.(css|js)$">',
                            'Header set Cache-Control "max-age=2592000, public"',
                            '</filesMatch>',
                            '</ifModule>',
                            '<ifModule mod_headers.c>',
                            'Header unset ETag',
                            '</ifModule>',
                            'FileETag None',
                            '<ifModule mod_headers.c>',
                            'Header unset Last-Modified',
                            '</ifModule>');

        $htaccess_file = ABSPATH.'.htaccess';
        return insert_with_markers($htaccess_file, 'Cache', (array) $insertion);

    }

}


