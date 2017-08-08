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
 * @version    $Id: TXXX.php 145 2009-03-25 22:18:50Z svollbehr $
 */

/**#@+ @ignore */
require_once(PHP_READER_DIR."/lib/ID3/Frame/AbstractText.php");
/**#@-*/

/**
 * This frame is intended for one-string text information concerning the audio
 * file in a similar way to the other T-frames. The frame body consists of a
 * description of the string, represented as a terminated string, followed by
 * the actual string. There may be more than one TXXX frame in each tag, but
 * only one with the same description.
 *
 * The description is the first value, and the its value the second in the text
 * array.
 * 
 * @package    php-reader
 * @subpackage ID3
 * @author     Sven Vollbehr <svollbehr@gmail.com>
 * @author     Ryan Butterfield <buttza@gmail.com>
 * @copyright  Copyright (c) 2008-2009 The PHP Reader Project Workgroup
 * @license    http://code.google.com/p/php-reader/wiki/License New BSD License
 * @version    $Rev: 145 $
 */
final class ID3_Frame_TXXX extends ID3_Frame_AbstractText
{
  /** @var string */
  private $_description;
  
  /**
   * Constructs the class with given parameters and parses object related data.
   *
   * @param Reader $reader The reader object.
   * @param Array $options The options array.
   */
  public function __construct($reader = null, &$options = array())
  {
    ID3_Frame::__construct($reader, $options);
    
    $this->_encoding = $this->getOption("encoding", ID3_Encoding::UTF8);
    
    if ($reader === null)
      return;
    
    $encoding = Transform::fromUInt8($this->_data[0]);
    $this->_data = substr($this->_data, 1);
    
    switch ($encoding) {
    case self::UTF16:
      list($this->_description, $this->_text) =
        $this->_explodeString16($this->_data, 2);
      $this->_description = $this->_convertString
        (Transform::fromString16($this->_description), "utf-16");
      $this->_text = $this->_convertString
        (array(Transform::fromString16($this->_text)), "utf-16");
      break;
    case self::UTF16BE:
      list($this->_description, $this->_text) =
        $this->_explodeString16($this->_data, 2);
      $this->_description = $this->_convertString
        (Transform::fromString16($this->_description), "utf-16be");
      $this->_text = $this->_convertString
        (array(Transform::fromString16($this->_text)), "utf-16be");
      break;
    case self::UTF8:
      list($this->_description, $this->_text) = $this->_convertString
        ($this->_explodeString8($this->_data, 2), "utf-8");
      $this->_text = array($this->_text);
      break;
    default:
      list($this->_description, $this->_text) = $this->_convertString
        ($this->_explodeString8($this->_data, 2), "iso-8859-1");
      $this->_text = array($this->_text);
    }
  }
  
  /**
   * Returns the description text.
   * 
   * @return string
   */
  public function getDescription() { return $this->_description; }
  
  /**
   * Sets the description text using given encoding.
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
   * Returns the frame raw data without the header.
   *
   * @return string
   */
  protected function _getData()
  {
    $data = Transform::toUInt8($this->_encoding);
    switch ($this->_encoding) {
    case self::UTF16LE:
      $data .= Transform::toString16
          ($this->_description, Transform::LITTLE_ENDIAN_ORDER, 1) .
        Transform::toString16
          ($this->_text[0], Transform::LITTLE_ENDIAN_ORDER, 1);
      break;
    case self::UTF16:
    case self::UTF16BE:
      $data .= Transform::toString16($this->_description, false, 1) .
        Transform::toString16($this->_text[0], false, 1);
      break;
    default:
      $data .= $this->_description . "\0" . $this->_text[0];
    }
    return $data;
  }
}

