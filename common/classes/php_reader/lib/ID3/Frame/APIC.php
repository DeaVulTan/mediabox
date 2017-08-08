<?php
/**
 * PHP Reader Library
 *
 * Copyright (c) 2008-2009 The PHP Reader Project Workgroup. All rights
 * reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *  - Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *  - Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 *  - Neither the name of the project workgroup nor the names of its
 *    contributors may be used to endorse or promote products derived from this
 *    software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    php-reader
 * @subpackage ID3
 * @copyright  Copyright (c) 2008-2009 The PHP Reader Project Workgroup
 * @license    http://code.google.com/p/php-reader/wiki/License New BSD License
 * @version    $Id: APIC.php 145 2009-03-25 22:18:50Z svollbehr $
 */

/**#@+ @ignore */
require_once(PHP_READER_DIR."/lib/ID3/Frame.php");
require_once(PHP_READER_DIR."/lib/ID3/Encoding.php");
/**#@-*/

/**
 * The <i>Attached picture</i> frame contains a picture directly related to the
 * audio file. Image format is the MIME type and subtype for the image.
 *
 * There may be several pictures attached to one file, each in their individual
 * APIC frame, but only one with the same content descriptor. There may only
 * be one picture with the same picture type. There is the possibility to put
 * only a link to the image file by using the MIME type "-->" and having a
 * complete URL instead of picture data.
 *
 * The use of linked files should however be used sparingly since there is the
 * risk of separation of files.
 *
 * @package    php-reader
 * @subpackage ID3
 * @author     Sven Vollbehr <svollbehr@gmail.com>
 * @author     Ryan Butterfield <buttza@gmail.com>
 * @copyright  Copyright (c) 2008-2009 The PHP Reader Project Workgroup
 * @license    http://code.google.com/p/php-reader/wiki/License New BSD License
 * @version    $Rev: 145 $
 */
final class ID3_Frame_APIC extends ID3_Frame
  implements ID3_Encoding
{
  /**
   * The list of image types.
   *
   * @var Array
   */
  public static $types = array
    ("Other", "32x32 pixels file icon (PNG only)", "Other file icon",
     "Cover (front)", "Cover (back)", "Leaflet page",
     "Media (e.g. label side of CD)", "Lead artist/lead performer/soloist",
     "Artist/performer", "Conductor", "Band/Orchestra", "Composer",
     "Lyricist/text writer", "Recording Location", "During recording",
     "During performance", "Movie/video screen capture",
     "A bright coloured fish", "Illustration", "Band/artist logotype",
     "Publisher/Studio logotype");

  /** @var integer */
  private $_encoding;

  /** @var string */
  private $_mimeType = "image/unknown";

  /** @var integer */
  private $_imageType = 0;

  /** @var string */
  private $_description;

  /** @var string */
  private $_imageData;

  /** @var integer */
  private $_imageSize = 0;

  /**
   * Constructs the class with given parameters and parses object related data.
   *
   * @param Reader $reader The reader object.
   * @param Array $options The options array.
   */
  public function __construct($reader = null, &$options = array())
  {
    parent::__construct($reader, $options);

    $this->_encoding = $this->getOption("encoding", ID3_Encoding::UTF8);

    if ($reader === null)
      return;

    $encoding = Transform::fromUInt8($this->_data[0]);
    $this->_mimeType = substr
      ($this->_data, 1, ($pos = strpos($this->_data, "\0", 1)) - 1);
    $this->_imageType = Transform::fromUInt8($this->_data[++$pos]);
    $this->_data = substr($this->_data, $pos + 1);

    switch ($encoding) {
    case self::UTF16:
      list ($this->_description, $this->_imageData) =
        $this->_explodeString16($this->_data, 2);
      $this->_description = $this->_convertString
        (Transform::fromString16($this->_description), "utf-16");
      break;
    case self::UTF16BE:
      list ($this->_description, $this->_imageData) =
        $this->_explodeString16($this->_data, 2);
      $this->_description = $this->_convertString
        (Transform::fromString16($this->_description), "utf-16be");
      break;
    case self::UTF8:
      list ($this->_description, $this->_imageData) =
        $this->_explodeString8($this->_data, 2);
      $this->_description = $this->_convertString
        ($this->_description, "utf-8");
      break;
    default:
      list ($this->_description, $this->_imageData) =
        $this->_explodeString8($this->_data, 2);
      $this->_description = $this->_convertString
        ($this->_description, "iso-8859-1");
    }

    $this->_imageSize = strlen($this->_imageData);
  }

  /**
   * Returns the text encoding.
   *
   * All the strings read from a file are automatically converted to the
   * character encoding specified with the <var>encoding</var> option. See
   * {@link ID3v2} for details. This method returns the original text encoding
   * used to write the frame.
   *
   * @return integer
   */
  public function getEncoding() { return $this->_encoding; }

  /**
   * Sets the text encoding.
   *
   * All the string written to the frame are done so using given character
   * encoding. No conversions of existing data take place upon the call to this
   * method thus all texts must be given in given character encoding.
   *
   * The default character encoding used to write the frame is UTF-8.
   *
   * @see ID3_Encoding
   * @param integer $encoding The text encoding.
   */
  public function setEncoding($encoding) { $this->_encoding = $encoding; }

  /**
   * Returns the MIME type. The MIME type is always ISO-8859-1 encoded.
   *
   * @return string
   */
  public function getMimeType() { return $this->_mimeType; }

  /**
   * Sets the MIME type. The MIME type is always ISO-8859-1 encoded.
   *
   * @param string $mimeType The MIME type.
   */
  public function setMimeType($mimeType) { $this->_mimeType = $mimeType; }

  /**
   * Returns the image type.
   *
   * @return integer
   */
  public function getImageType() { return $this->_imageType; }

  /**
   * Sets the image type code.
   *
   * @param integer $imageType The image type code.
   */
  public function setImageType($imageType) { $this->_imageType = $imageType; }

  /**
   * Returns the file description.
   *
   * @return string
   */
  public function getDescription() { return $this->_description; }

  /**
   * Sets the content description text using given encoding.
   *
   * @param string $description The content description text.
   * @param integer $encoding The text encoding.
   */
  public function setDescription($description, $encoding = false)
  {
    $this->_description = $description;
    if ($encoding !== false)
      $this->_encoding = $encoding;
  }

  /**
   * Returns the embedded image data.
   *
   * @return string
   */
  public function getImageData() { return $this->_imageData; }

  /**
   * Sets the embedded image data. Also updates the image size field to
   * correspond the new data.
   *
   * @param string $imageData The image data.
   */
  public function setImageData($imageData)
  {
    $this->_imageData = $imageData;
    $this->_imageSize = strlen($imageData);
  }

  /**
   * Returns the size of the embedded image data.
   *
   * @return integer
   */
  public function getImageSize() { return $this->_imageSize; }

  /**
   * Returns the frame raw data without the header.
   *
   * @return string
   */
  protected function _getData()
  {
    $data = Transform::toUInt8($this->_encoding) . $this->_mimeType . "\0" .
      Transform::toUInt8($this->_imageType);
    switch ($this->_encoding) {
    case self::UTF16LE:
      $data .= Transform::toString16
        ($this->_description, Transform::LITTLE_ENDIAN_ORDER, 1);
      break;
    case self::UTF16:
    case self::UTF16BE:
      $data .= Transform::toString16($this->_description, false, 1);
      break;
    default:
      $data .= $this->_description . "\0";
    }
    return $data . $this->_imageData;
  }
}
