<?php

define('PHP_READER_DIR', dirname(__FILE__));
require_once(PHP_READER_DIR.'/lib/ID3v2.php');

class ReadID3Data
	{
		public function getData($temp_file, $image_upload_url)
			{
				if(is_file($temp_file))
					{
						$id3_data_arr = array();

						$id3 = new ID3v2($temp_file);

						//Writing image to file
						$image_type_arr = array('image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif');

						if(!strpos($id3->apic->mimeType, 'unknown'))
							{
								$image_type = $image_type_arr[$id3->apic->mimeType];
							}

						if(isset($image_type) and $image_type)
							{
								//File name and path should be dynamic
								$fh = fopen($image_upload_url.'L.'.$image_type, 'w');
								fwrite($fh, $id3->apic->imageData);
								fclose($fh);
								$id3_data_arr['music_thumb_ext'] = $image_type;
							}


						/*header("Content-Type: ".$id3->apic->mimeType);
						echo $id3->apic->imageData;

						exit;*/


						$frame = $id3->getFramesByIdentifier("TIT2"); // for song title;
						$id3_data_arr['music_title'] = (!empty($frame)?$frame[0]->getText():'');

						$frame = $id3->getFramesByIdentifier("TALB"); // for song album;
						$id3_data_arr['music_album_id'] = (!empty($frame)?$frame[0]->getText():'');

						$frame = $id3->getFramesByIdentifier("TCOM"); // for artist/composer;
						$composer = (!empty($frame)?$frame[0]->getText():'');

						$frame = $id3->getFramesByIdentifier("TYER"); // for released year;
						$id3_data_arr['music_year_released'] = (!empty($frame)?$frame[0]->getText():'');

						$frame = $id3->getFramesByIdentifier("COMM"); // for comment;
						$id3_data_arr['music_caption'] = (!empty($frame)?$frame[0]->getText():'');

						/*$frame = $id3->getFramesByIdentifier("TCON"); // for genre;
						$id3_data_arr['music_category_id'] = (!empty($frame)?$frame[0]->getText():'');*/

						/*$frame = $id3->getFramesByIdentifier("TOPE"); // for length;
						$id3_data_arr['TOPE'] = (!empty($frame)?$frame[0]->getText():'');*/

						$frame = $id3->getFramesByIdentifier("TPE1"); // for length;
						$singers = (!empty($frame)?$frame[0]->getText():'');

						$id3_data_arr['music_artist'] = (!empty($composer)?$composer.', '.$singers:$singers);

						/*$frame = $id3->getFramesByIdentifier("APIC"); // for genre;
						$artist = (!empty( $frame)?$frame[0]->getText():'');*/

						return $id3_data_arr;
					}
			}
	}
?>