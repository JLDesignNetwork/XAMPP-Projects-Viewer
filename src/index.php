<?php

/**
 * XAMPP Project Viewer
 *
 * This script will display a list of all the projects that reside 
 * on your XAMPP localhost server. It is required that all your
 * projects exist in one "projects" folder on your server.
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
 * @filename  index.php
 * @datetime  2020-12-23 20:46:34
 */

// define this page for security purposes
$page = substr(basename(__FILE__), 0, strpos(basename(__FILE__), '.'));
define("THIS_PAGE", $page);

/*
 * Require essential files to this script
 * 
 * @filesource engine.php
 */
require_once 'engine.php';

/*
 * Scrape the projects directory
 */
$contents = $scraper->scrape(SCRAPER_EXCLUDES);

/*
 * Instantiate the navigation class
 */
$navigation = new Navigation($contents);

/*
 * Build projects HTML
 */
$projectHTML = "";
foreach($contents[1] as $projectName => $stats) :
    $size = $stats['size'];
    $factor = floor((strlen($size) - 1) / 3);
    
    if ($factor > 0) :
        $sz = 'KMGT';
    endif;

    $projectHTML .= $output->prepare(
        [
            $navigation->linkIt($projectName),
            date("Y-m-d", $stats['ctime']),
            date("Y-m-d", $stats['mtime']),
            date("Y-m-d", $stats['atime']),
            sprintf(
                "%.0f", 
                $size / pow(1024, $factor)
            ) . @$sz[$factor - 1] . ' bytes'
        ],
        "<div>%s</div>
        <div>%s</div>
        <div>%s</div>
        <div>%s</div>
        <div>%s</div>",
        false
    );
endforeach;

/*
 * HTML template
 */
$htmlTmpl = file_get_contents(TEMPLATE_PATH . 'html.tmpl');

/*
 * Render page
 */
echo str_replace("{% PROJECTS %}", $projectHTML, $htmlTmpl);

?>