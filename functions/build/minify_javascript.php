<?php
/**
 * Enables gzip for servers that allows it or do not do it by default (Xneelo compresses by default I believe)
 */
namespace HISQ\Theme\Build;

use MatthiasMullie\Minify;
use Patchwork\JSqueeze;

class minify_javascript
{

    public function __construct()
    {

        /*
        * combine and minify all javascript files (can do css as well)
         */

        //https://github.com/matthiasmullie/minify.git
        require_once(get_template_directory().'/functions/build/minify/vendor/autoload.php');
        $sourcePath = get_template_directory()."/library/js/main.js";
        $minifier = new Minify\JS($sourcePath);

        //$sourcePath2 = get_template_directory()."/library/js/main1.js";
        //$minifier->add($sourcePath2);

        $minifiedPath = get_template_directory()."/library/js/main-min.js";
        $minifier->minify($minifiedPath);

        /*
        *   obfuscate and compress the combined minified file
         */
        //https://github.com/tchwork/jsqueeze
        $jz = new JSqueeze();
        // Retrieve the content of a JS file
        $fatJs = file_get_contents($minifiedPath);
        $minifiedJs = $jz->squeeze(
            $fatJs,
            true,   // $singleLine
            true,   // $keepImportantComments
            false   // $specialVarRx
        );
        file_put_contents($minifiedPath, $minifiedJs);

    }

}


