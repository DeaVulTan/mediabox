<?php

 error_reporting(E_ALL);

 require("exifWriter.inc");

 /** Create an object */
 $er = new phpExifWriter($filename);

 $er->debug = true;

 /**
 * Show current Image info
 */
 echo "<pre>";
 print_r($er->getImageInfo());
 echo "</pre>";

 $time = $er->getDiffTime();
 echo "<br>Reading done in $time seconds";

 /*
 * Add comments to the file
 */
 $er->addComment("This is the commentss");

 /**
 * Write back the content to a file
 */
 $er->writeImage("test.jpg");

 /**
 * Show total time taken
 */
 $time = $er->getDiffTime();
 echo "<br>Writing done in $time seconds";

?>
