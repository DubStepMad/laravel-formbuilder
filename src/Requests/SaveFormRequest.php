<?php
/*--------------------
https://github.com/dubstepmad/formbuilder
Licensed under the GNU General Public License v3.0
Author: DubStepMad (dubstepmad.com)
Original: Jasmine Robinson (jazmy.com)
Last Updated: 07/08/2019
----------------------*/
namespace dubstepmad\FormBuilder\Requests;

use dubstepmad\FormBuilder\Models\Form;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'visibility' => ['required', Rule::in([Form::FORM_PUBLIC, Form::FORM_PRIVATE, Form::FORM_PRIVATE_MISC, Form::FORM_STAFF])],
            'allows_edit' => 'required|boolean',
            'form_builder_json' => 'required|json',
        ];
    }
}
