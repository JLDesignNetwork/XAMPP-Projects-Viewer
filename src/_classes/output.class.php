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
 * @filename  output.class.php
 * @datetime  2020-12-23 18:51:17
 */

/**
 * Output Class
 * 
 * @category Description
 * @package  XAMPP-Project_Viewer
 * @author   Jeff Langdon <admin@jldn.org>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     http://url.com
 */
class Output
{
    /**
     * Instance of this class.
     *
     * @var object
     */
    private static $_instance;

    /**
     * Method creates a new instance of this class if
     * one does not yet exist, and returns the class 
     * instance.
     *
     * @return Output Instance of this class
     */
    public static function instance(): Output
    {
        /*
         * Check if an instance exists already
         * if instance is null, create a new 
         * instance.
         */
        if(!self::$_instance) :
            self::$_instance = new self();
        endif;

        return self::$_instance;
    }

    /**
     * Method prepares a message for output. Uses one
     * of two built-in PHP functions to prepare the message,
     * depending on the type of message. If message is a 
     * string (or int), sprintf is called. If the message is an array,
     * vsprintf is called. This may throw an error if the 
     * message is an array and the number of array values do
     * not match the number of placeholders in the format 
     * string.
     * 
     * Example 1: (correct usage)
     *  array  $message ['value_1', 'value_2']
     *  string $format  "Value 1: %s \n Value 2: %s"
     * 
     * Example 2: (correct usage)
     *  string $message "This is a string"
     *  string $format  "Contents: %s"
     * 
     * Example 3: (incorrect usage)
     *  array  $message ['value_1', 'value_2', 'value_3']
     *  string $format  "Value 1: %s \n Value 2: %s"
     * 
     * @param mixed  $message   message to output
     * @param string $format    output format
     * @param bool   $linebreak add linebreak at end of output
     * 
     * @return string
     */
    public function prepare(
        mixed $message,
        string $format,
        bool $linebreak=true
    ) :string {

        /*
         * If the message is an array, use the vsprintf 
         * function, else use the sprintf function.
         */
        $function = (is_array($message)) ? 'vsprintf' : 'sprintf';

        /*
         * Return the formatted string and append a linebreak
         * if $linebreak is true
         */
        return call_user_func_array(
            $function, 
            [
                "{$format}", 
                $message
            ]
        ) . ($linebreak ? nl2br(PHP_EOL) : "");
    }
}

$output = Output::instance();

?>