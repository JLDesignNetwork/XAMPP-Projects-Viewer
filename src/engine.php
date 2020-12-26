<?php

/**
 * Behind-the-scenes script of XPV.
 *
 * This page is for file inclusion of needed classes for functionality.
 * Global defines, based on configuration settings, are done in this file.
 * Time zone settings are declared for the purpose of error logging. Also,
 * php ini settings are declared for the purpose of error reporting and 
 * logging.
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
 * @filename  engine.php
 * @datetime  2020-12-25 11:28:36
 */

/* 
 * Security check 
 */
if (!defined('THIS_PAGE') || defined('THIS_PAGE') && THIS_PAGE != 'index') :
    exit("Direct access not permitted.");    
endif;

/*
 * Load the json config file into an array variable for use 
 * in defining global constants used by this script.
 */
$configurations = file_exists('configurations.json')
    ? json_decode(file_get_contents('configurations.json'), true)
    : throw new Exception(
        "Configurations file cannot be found.<br>
        Please make sure the 'configurations.json' file in located in the same 
        directory as 'index.php'."
    );

/*
 * Define all our configurations as constants for ease of use.
 * There are two primary rules used for defining our constants:
 **
 * 1) if the json key contains '_path', we need to add a 
 * directory separator using the phg global DIRECTORY_SEPARATOR.
 **
 * 2) if the json key is 'error_report_level', we need to use
 * the php eval function to return the actual value. This is 
 * because we are storing a php global constant for the json
 * value. If we do not use eval, the actual value of the constant
 * will not be passed.
 */
foreach ($configurations as $key => $value) :
    if ($key == 'error_report_level') :
        eval("\$value = $value;");
    endif;

    if (preg_match("/_path/", $key)) :
        $value .= DIRECTORY_SEPARATOR;
    endif;

    define(strtoupper($key), $value);
endforeach;

/*
 * Set the default timezone for the purpose of error 
 * logging.
 */
if (date_default_timezone_get() != DEFAULT_TIMEZONE) :
    date_default_timezone_set(DEFAULT_TIMEZONE);
endif;

/*
 * Error and logging maintainance
 */
ini_set('error_log', ERROR_LOG_FILE_PATH . ERROR_LOG_FILE);
ini_set('log_errors', true);
ini_set('display_errors', GLOBAL_DEBUGGING);
ini_set('display_startup_errors', GLOBAL_DEBUGGING);
error_reporting(ERROR_REPORT_LEVEL);

/*
 * Require all needed classes
 */
require_once CLASS_PATH . 'output.class.php';
require_once CLASS_PATH . 'directory_scraper.class.php';
require_once CLASS_PATH . 'navigation.class.php';

?>