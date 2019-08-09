<?php
/*--------------------
https://github.com/dubstepmad/formbuilder
Licensed under the GNU General Public License v3.0
Author: DubStepMad (dubstepmad.com)
Original: Jasmine Robinson (jazmy.com)
Last Updated: 07/08/2019
----------------------*/
namespace dubstepmad\FormBuilder\Services;

class RolesProvider
{
	/**
	 * Return the array of roles in the format
	 *
	 * [
	 * 	 1 => 'Role Name',
	 * ]
	 * @return array
	 */
    public function __invoke() : array
    {
    	return [
    		1 => 'Default',
    	];
    }
}
