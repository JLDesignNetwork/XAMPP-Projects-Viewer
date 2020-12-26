<?php

/**
 * Short Description: Class for preparing output
 *
 * Long Description: Output class takes the parameters $format,
 * $message, and $linebreak to build an output string.
 * $message can be either a string or an array. The output prepare
 * method will consider the $message input and determine the 
 * appropriate algorithm for output, using the supplied format.
 *
 * PHP version 8.0.1
 *
 * LICENSE: MIT License
 *
 * Copyright (c) 2020 JL Design Network
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * @category  CATEGORY_NAME
 * @package   XAMPP-Project_Viewer
 * @author    Jeff Langdon <admin@jldn.org>
 * @copyright 1996-2020 JL Design Network
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version   GIT: $Id$
 * @link      http://pear.php.net/package/PackageName
 * @since     File available since Release 1.0.0
 * @filename  navigation.class.php
 * @datetime  2020-12-23 19:32:04
 */

/**
 * Navigation Class
 * 
 * @category Description
 * @package  Category
 * @author   Jeff Langdon <admin@jldn.org>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     http://url.com
 */
class Navigation
{
    /**
     * Undocumented variable
     *
     * @var array  $_files
     * @var array  $_folders
     * @var string $_path
     */
    private array  $_files;
    private array  $_folders;
    private string $_path;

    /**
     * Undocumented function
     *
     * @param array $args Index array containing path, files and folders
     */
    public function __construct(array $args)
    {
        list($this->_path, $this->_folders, $this->_files) = $args;
    }

    /**
     * Undocumented function
     *
     * @param string $item Comment
     *
     * @return string
     */
    public function linkIt(string $item):string
    {
        $link = $this->_path . DIRECTORY_SEPARATOR . $item;

        if (is_dir($link . DIRECTORY_SEPARATOR . 'public_html')) :
            $link = $link . DIRECTORY_SEPARATOR . 'public_html';
        endif;

        return sprintf(
            "<a href=\"%s\" target=\"_blank\">%s</a>", 
            $link, 
            ucfirst($item)
        );
    }

    /**
     * Undocumented function
     *
     * @param int $what Comment
     *
     * @return mixed
     */
    private function _include(int $what):mixed
    {
        switch($what) :
        default:
        case 0:
                $data = [
                        $this->_folders, 
                        $this->_files
                    ];
            break;
        case 1:
                $data = $this->_path;
            break;
        case 2:
                $data = $this->_folders;
            break;
        case 3:
                $data = $this->_files;
            break;
        endswitch;
        
        return $data;
    }

    /**
     * Undocumented function
     *
     * @param int $what comment
     *
     * @return void
     */
    public function output(int $what=0)
    {
        return sprintf("<pre>%s</pre>", print_r($this->_include($what), true));
    }
}