# XAMPP Projects Viewer version 1.0.1

## Description

Software application for use with XAMPP localhost software. This software application will display an HTML formatted list of all projects that exist on your XAMPP localhost server.

![XPV](/xpv.png?raw=true "Default view.")

## Features

* Colorful display
* Alternating row colors
* Projects statistics (size, accessed data, modified date, change date)
* Project navigation (project folders are links that open in new tabs)

## Install

1. Download the package and extract it.
2. Copy the contents of the 'src' folder into the directory containing all your project directories.
3. Edit the configurations.json file as needed.
4. Point your browser to your projects directory.

## Additional

This script was built using PHP 8.0.1. There exists PHP elements that will not work, or will throw errors, on earlier versions of PHP.

## Todo

- [ ] Create a template class and additional templates for customizable display.
- [ ] Add "Create Project" feature
- [ ] Add "Delete Project" feature
- [ ] Add "php_info()" feature
- [ ] Add mysql connection test