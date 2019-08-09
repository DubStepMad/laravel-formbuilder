<?php
/*--------------------
https://github.com/dubstepmad/formbuilder
Licensed under the GNU General Public License v3.0
Author: DubStepMad (dubstepmad.com)
Original: Jasmine Robinson (jazmy.com)
Last Updated: 07/08/2019
----------------------*/
return [
    /**
     * Url path to use for this package routes
     */
    'url_path' => '/form-builder',

    /**
     * Template layout file. This is the path to the layout file your application uses
     */
    'layout_file' => 'layouts.app',

    /**
     * The stack section in the layout file to output js content
     * Define something like @stack('stack_name') and provide the 'stack_name here'
     */
    'layout_js_stack' => 'scripts',

    /**
     * The stack section in the layout file to output css content
     */
    'layout_css_stack' => 'styles',

    /**
     * The class that will provide the roles we will display on form create or edit pages?
     */
    'roles_provider' => dubstepmad\FormBuilder\Services\RolesProvider::class,
];
