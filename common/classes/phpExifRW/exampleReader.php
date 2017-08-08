<?php
/**
 * Example script showing usage of phpReader class
 *
 * Vinay Yadav < vinay@vinayras.com >

 * http://www.vinayras.com/project/phpexifrw.php
 * http://www.sanisoft.com/phpexifrw/

 *
 * For more details on constants and methods look at the
 * documentation provided in doc/ folder
 *
 */

 $filename = "02280003.jpg";

 require("exifReader.inc");

 /**
 * Create an object
 */
 $er = new phpExifReader($filename);

 $er->Debugging = 1;
 
 /**
  * Generate a Link to view thumbnail.
  * showThumbnail.php files need to be in the same directory.
  */
 if($er->ThumbnailSize > 0) {
        echo "<br><img src='".$er->showThumbnail()."'>";
 }
 /**
  * Show the image details along with Exif information.
  */
 echo "<pre>";
    print_r($er->getImageInfo());
 echo "</pre>";

 $time = $er->getDiffTime();

 echo "<br>Read EXIF in $time seconds";

?>
