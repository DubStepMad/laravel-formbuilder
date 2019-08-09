<?php
/*--------------------
https://github.com/dubstepmad/formbuilder
Licensed under the GNU General Public License v3.0
Author: DubStepMad (dubstepmad.com)
Original: Jasmine Robinson (jazmy.com)
Last Updated: 07/08/2019
----------------------*/
namespace dubstepmad\FormBuilder\Events\Form;

use dubstepmad\FormBuilder\Models\Form;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class FormCreated
{
    use Queueable, SerializesModels;

    /**
     * The deleted form
     *
     * @var dubstepmad\FormBuilder\Models\Form
     */
    public $form;

    /**
     * Create a new event instance.
     *
     * @param dubstepmad\FormBuilder\Models\Form $form
     * @return void
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }
}
