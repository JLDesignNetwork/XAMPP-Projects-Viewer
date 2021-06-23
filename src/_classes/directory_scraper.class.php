<?php

/**
 * Class for scraping the projects directory
 *
 * This class is used to read the contents of the projects 
 * directory, including file and folder stats, into an array. This 
 * class may also be used to scrape other directories if so desired,
 * by creating a new instance and passing the path to the directory.
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
 * @filename  directory_scraper.class.php
 * @datetime  2020-12-23 19:02:41
 */

/* 
 * Security check 
 */
if (!defined('THIS_PAGE') || defined('THIS_PAGE') && THIS_PAGE != 'index') :
    exit("Direct access not permitted.");    
endif;

/**
 * DirectoryScraper Class
 *
 * @category CategoryName
 * @package  XAMPP-Project_Viewer
 * @author   Jeff Langdon <admin@jldn.org>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     http://url.com
 */
class DirectoryScraper
{
    /**
     * The path to the location of the desired directory
     * to scrape.
     *
     * @var string
     */
    protected $path;
    /**
     * The contents of the scraped directory; includes
     * files, folders, and stats of each.
     *
     * @var array
     */
    protected $contents;

    /**
     * Constructor method takes a path and sends it
     * for validation and preparation for use.
     *
     * @param string $path The path used for directory scraping
     */
    public function __construct(string $path)
    {        
        /* 
         * Prepare the parameter $path for use 
         */
        if(!$this->_preparePath($path)) :
            return false;
        endif;

        /*
         * return true if path preparation succeeded.
         */
        return true;
    }
    
    /**
     * Method for validation and preparation of
     * a viable path.
     *
     * @param string $path The path used for directory scraping
     *
     * @return bool Returns false if the path is empty, else
     * it returns true after assigning the path value to the 
     * private property $path.
     */
    private function _preparePath(string $path):bool
    {
        /*
        * If the path is empty return false
        */
        if(empty($path)) : 
            return false; 
        endif;
        
        /* 
         * Define path length 
         */
        $l = strlen($path) - 1;
        
        /*
        * Replace * with .
        */
        $path = str_replace('*', '.', $path);
        
        /*
        * If $path is greater than OR equal to 2 AND
        * first character of path does NOT equal directory separator
        * constant include the directory separator constant
        */
        if($l >= 2 && $path[0] == '.' && $path[1] != DIRECTORY_SEPARATOR) :
            $path = str_replace('.', '.' . DIRECTORY_SEPARATOR, $path);
        endif;
        
        /*
        * If last character of path is equal to directory separator constant
        * remove it from the path
        */
        if(substr($path, -1) == DIRECTORY_SEPARATOR) :
            $path = substr($path, 0, -1);
        endif;
        
        /*
        * If path length is greater than 2 AND
        * the first two characters of path are NOT ./ OR .\
        * prepend the path to include  ./ OR .\
        */
        if($l > 2 && substr($path, 0, 2) != '.' . DIRECTORY_SEPARATOR) :
            $path = '.' . DIRECTORY_SEPARATOR . $path;
        endif;
        
        /*
         * Save the path as a property of the class
         */
        $this->path = $path;

        /*
         * Path verified and stored; return true
         */
        return true;
    }
    
    /**
     * Method returns an array contianing all folders,
     * files, and the stats of each.
     * 
     * @param array $exclude An array of files and folders
     *                       to exclude from the return
     *
     * @return bool|array Returns false if the path is no
     * a directory, else it returns an array.
     */
    public function scrape(array $exclude = ['.', '..']):bool|array
    {
        /*
        *  If the path does NOT lead to a directory/folder
        *  return false
        */
        if(!is_dir($this->path)) :
            return false;
        endif;
        
        /*
         * create empty arrays for files and folders
         */
        $folders = [];
        $files = [];

        /*
         * scan directory and remove any files and 
         * folders that have been excluded.
         */
        $dc = array_values(
            array_diff(
                scandir($this->path), 
                $exclude
            )
        );

        /*
         * Sort the array and assign stats to each 
         * remaining element.
         */
        natcasesort($dc);
        foreach($dc as $value):
            $stat = stat($this->path . DIRECTORY_SEPARATOR . $value);
            if(is_dir($value)) :
                $folders[$value] = $stat;
            else:
                $files[$value] = $stat;
            endif;
        endforeach;
        
        /*
         * Return the array
         */
        return [$this->path, $folders, $files];
    }
}

$scraper = new DirectoryScraper(PROJECTS_PATH);

?>