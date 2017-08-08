<?php
/**
 * PHP Reader Library
 *
 * Copyright (c) 2006-2009 The PHP Reader Project Workgroup. All rights
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
 * @subpackage ASF
 * @copyright  Copyright (c) 2006-2009 The PHP Reader Project Workgroup
 * @license    http://code.google.com/p/php-reader/wiki/License New BSD License
 * @version    $Id: ASF.php 139 2009-02-19 14:10:37Z svollbehr $
 */

/**#@+ @ignore */
require_once("Reader.php");
require_once("ASF/Object/Container.php");
/**#@-*/

/**
 * This class represents a file in Advanced Systems Format (ASF) as described in
 * {@link http://go.microsoft.com/fwlink/?LinkId=31334 The Advanced Systems
 * Format (ASF) Specification}. It is a file format that can contain various
 * types of information ranging from audio and video to script commands and
 * developer defined custom streams.
 *
 * The ASF file consists of code blocks that are called content objects. Each
 * of these objects have a format of their own. They may contain other objects
 * or other specific data. Each supported object has been implemented as their
 * own classes to ease the correct use of the information.
 * 
 * @package    php-reader
 * @subpackage ASF
 * @author     Sven Vollbehr <svollbehr@gmail.com>
 * @copyright  Copyright (c) 2006-2009 The PHP Reader Project Workgroup
 * @license    http://code.google.com/p/php-reader/wiki/License New BSD License
 * @version    $Rev: 139 $
 */
class ASF extends ASF_Object_Container
{
  /** @var string */
  private $_filename;
  
  /**
   * Constructs the ASF class with given file and options.
   *
   * The following options are currently recognized:
   *   o encoding -- Indicates the encoding that all the texts are presented
   *     with. By default this is set to utf-8. See the documentation of iconv
   *     for accepted values.
   *   o readonly -- Indicates that the file is read from a temporary location
   *     or another source it cannot be written back to.
   *
   * @param string $filename The path to the file or file descriptor of an
   *                         opened file.
   * @param Array  $options  The options array.
   */
  public function __construct($filename, $options = array())
  {
    $this->_reader = new Reader($this->_filename = $filename);
    $this->setOptions($options);
    if ($this->getOption("encoding", false) === false)
      $this->setOption("encoding", "utf-8");
    $this->setOffset(0);
    $this->setSize($this->_reader->getSize());
    $this->constructObjects
      (array
       (self::HEADER => "Header",
        self::DATA => "Data",
        self::SIMPLE_INDEX => "SimpleIndex",
        self::INDEX => "Index",
        self::MEDIA_OBJECT_INDEX => "MediaObjectIndex",
        self::TIMECODE_INDEX => "TimecodeIndex"));
  }
  
  /**
   * Returns the mandatory header object contained in this file.
   * 
   * @return ASF_Object_Header
   */
  public function getHeader()
  {
    $header = $this->getObjectsByIdentifier(self::HEADER);
    return $header[0];
  }
  
  /**
   * Returns the mandatory data object contained in this file.
   * 
   * @return ASF_Object_Data
   */
  public function getData()
  {
    $data = $this->getObjectsByIdentifier(self::DATA);
    return $data[0];
  }
  
  /**
   * Returns an array of index objects contained in this file.
   * 
   * @return Array
   */
  public function getIndices()
  {
    return $this->getObjectsByIdentifier
      (self::SIMPLE_INDEX . "|" . self::INDEX . "|" .
       self::MEDIA_OBJECT_INDEX . "|" . self::TIMECODE_INDEX);
  }
  
  /**
   * Writes the changes back to the original media file.
   */
  public function write($filename = false)
  {
    if ($filename === false)
      $filename = $this->_filename;
    if ($filename !== false && $this->_filename !== false &&
        realpath($filename) != realpath($this->_filename) &&
        !copy($this->_filename, $filename)) {
      require_once("ASF/Exception.php");
      throw new ASF_Exception("Unable to copy source to destination: " .
        realpath($this->_filename) . "->" . realpath($filename));
    }
    
    if (($fd = fopen
         ($filename, file_exists($filename) ? "r+b" : "wb")) === false) {
      require_once("ASF/Exception.php");
      throw new ASF_Exception("Unable to open file for writing: " . $filename);
    }

    $header = $this->getHeader();
    $headerLengthOld = $header->getSize();
    $header->removeObjectsByIdentifier(ASF_Object::PADDING);
    $header->headerExtension->removeObjectsByIdentifier(ASF_Object::PADDING);

    $headerData = $header->__toString();
    $headerLengthNew = $header->getSize();

    // Fits right in
    if ($headerLengthOld == $headerLengthNew) {
    }
    
    // Fits with adjusted padding
    else if ($headerLengthOld >= $headerLengthNew + 24 /* for header */) {
      $header->headerExtension->padding->setSize
        ($headerLengthOld - $headerLengthNew);
      $headerData = $header->__toString();
      $headerLengthNew = $header->getSize();
    }
    
    // Must expand
    else {
      $header->headerExtension->padding->setSize(4096);
      $headerData = $header->__toString();
      $headerLengthNew = $header->getSize();
      
      fseek($fd, 0, SEEK_END);
      $oldFileSize = ftell($fd);
      ftruncate
        ($fd, $newFileSize = $headerLengthNew - $headerLengthOld +
         $oldFileSize);
      for ($i = 1, $cur = $oldFileSize; $cur > 0; $cur -= 1024, $i++) {
        fseek($fd, -(($i * 1024) + ($newFileSize - $oldFileSize)), SEEK_END);
        $buffer = fread($fd, 1024);
        fseek($fd, -($i * 1024), SEEK_END);
        fwrite($fd, $buffer, 1024);
      }
    }

    fseek($fd, 0);
    fwrite($fd, $headerData, $headerLengthNew);
    fclose($fd);

    $this->_filename = $filename;
  }
  
  /**
   * Returns the whether the object is required to be present, or whether
   * minimum cardinality is 1.
   * 
   * @return boolean
   */
  public function isMandatory() { return true; }
  
  /**
   * Returns whether multiple instances of this object can be present, or
   * whether maximum cardinality is greater than 1.
   * 
   * @return boolean
   */
  public function isMultiple() { return false; }
}
