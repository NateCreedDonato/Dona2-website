<?php

namespace HISQ\Theme\Backend;

class compress_images{

  public function __construct(){

    //compress original image
    add_filter( 'wp_handle_upload', array($this,'compress_image'), 10, 2 );
    //compress resized images
    add_filter( 'wp_editor_set_quality', function( $quality ) { return 30; } );

  }

  function compress_image( $data){

    $image_quality = 85; // Change this according to your needs
    $file_path = $data['file'];
    $image = false;

    if (extension_loaded('imagick') && function_exists('acf_add_options_page')){

        //only compress images if option is enabled
        if(get_field('compress_images', 'option') == "true"){

            if ( $data['type'] == 'image/jpeg' || $data['type'] == 'image/png' || $data['type'] == 'image/gif') {



                $imagick = new \Imagick();

                $rawImage = file_get_contents($file_path);

                $imagick->readImageBlob($rawImage);

                $original_size = $imagick->getImageLength();

                $imagick->stripImage();

                // Define image
                $width      = $imagick->getImageWidth();
                $height     = $imagick->getImageHeight();

                // Compress image
                $imagick->setImageCompressionQuality($image_quality);

                $image_types = getimagesize($file_path);

                // Get thumbnail image
                $imagick->thumbnailImage($width, $height);

                // Set image as based its own type
                if ($image_types[2] === IMAGETYPE_JPEG)
                {
                    $imagick->setImageFormat('jpeg');

                    $imagick->setSamplingFactors(array('2x2', '1x1', '1x1'));

                    $profiles = $imagick->getImageProfiles("icc", true);

                    $imagick->stripImage();

                    if(!empty($profiles)) {
                        $imagick->profileImage('icc', $profiles['icc']);
                    }

                    $imagick->setInterlaceScheme(\Imagick::INTERLACE_JPEG);
                    $imagick->setColorspace(\Imagick::COLORSPACE_SRGB);
                }
                else if ($image_types[2] === IMAGETYPE_PNG) 
                {
                    $imagick->setImageFormat('png');
                }
                else if ($image_types[2] === IMAGETYPE_GIF) 
                {
                    $imagick->setImageFormat('gif');
                }

                //needed so a new $imagick->getImageLength() will return the correct value
                $imagick->getImageBlob();

                //do not repolace image if it is smaller (I.E. compressed using a better method)
                if($original_size > $imagick->getImageLength()){
                    $imagick->writeImage($file_path);
                }

                // Destroy image from memory
                $imagick->destroy();


            }
        }
    }

    return $data;

  }



}

?>