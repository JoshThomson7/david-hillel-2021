# Advanced Property Framework

Advanced Property Framework (a.k.a APF), is an estate agency website framework for WordPress.

## Getting started

These instructions will get APF up and running. See pre-requisits section for dependencies needed to run this framework.

### Pre-requisites

1. [WordPress] (https://wordpress.org/download/)
2. [Advanced Custom Fields PRO] (https://www.advancedcustomfields.com/pro/).
3. [WP All Import] (http://www.wpallimport.com/)
4. [CodeKit] (https://codekitapp.com/) or similar compiler

## Installation

### Sessions, includes, variables & templates

1. Copy the **advanced-property-framework** folder into the theme's folder.

2. On the main theme's ```functions.php``` file include the main APF functions file:  ```require_once(get_stylesheet_directory().'/advanced-property-framework/functions/apf-functions.php```.

3. In your main source SASS file, include the main APF style sheet:  ```@import url('advanced-property-framework/scss/apf');``` – this is supposing the SASS source file is in the theme's root directory.  

4. In your main source JS file, include the main APF JS file:  ```// @codekit-prepend "../modules/advanced-property-framework/js/_apf.js";``` – this is supposing the JS source file is in the theme's js directory. Also, this example uses CodeKit: https://codekitapp.com/.

5. This framework heavily relies on ACF Pro, so you'd need the source JSON file located on the ```acf-json``` folder.

6. That's it. All the necessary pages and enqueued scripts should automatically be included.

## Built with

* [ATOM] (https://atom.io/)
* [CodeKit] (https://codekitapp.com/)
* [WordPress] (https://wordpress.org/download/)
