<?php
/*--------------------
https://github.com/dubstepmad/formbuilder
Licensed under the GNU General Public License v3.0
Author: DubStepMad (dubstepmad.com)
Original: Jasmine Robinson (jazmy.com)
Last Updated: 07/08/2019
----------------------*/
namespace dubstepmad\FormBuilder\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use dubstepmad\FormBuilder\Helper;
use dubstepmad\FormBuilder\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use dubstepmad\FormBuilder\Models\Submission;
use Throwable;
use Auth;

class RenderFormController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('public-form-access');
    }

    /**
     * Render the form so a user can fill it
     *
     * @param string $identifier
     * @return Response
     */
    public function render($identifier)
    {
        // Error message bag variable
        $errors = new MessageBag();

		// Error message bag variable
        $errors = new MessageBag();

        // Checks if the user is blacklisted
        if(Auth::user()->recruitment_blacklist == true){
            // Blacklist check custom Error
            $errors->add('blacklist_check', 'You are blacklisted from using our Recruitment system, please use the Feedback system to appeal.');

            return redirect('recruitment')->withErrors($errors);
        }

        $submissions = Submission::getForUser(Auth::user());

        $form = Form::where('identifier', $identifier)->firstOrFail();

        foreach($submissions as $app){
            if($app->form_id == $form->id){
                if($app->status === "Accepted" || $app->status === "Rejected"){
                    $pageTitle = "{$form->name}";

                    return view('formbuilder::render.index', compact('form', 'pageTitle'));
                }else{
                    $errors->add('app_check', 'You already have a '.$form->name.' submitted!');

                    return redirect('recruitment')->withErrors($errors);
                }
            }
        }
        
        $pageTitle = "{$form->name}";

        return view('formbuilder::render.index', compact('form', 'pageTitle'));
    }

    /**
     * Process the form submission
     *
     * @param Request $request
     * @param string $identifier
     * @return Response
     */
    public function submit(Request $request, $identifier)
    {
        // Error message bag variable
        $errors = new MessageBag();

        $form = Form::where('identifier', $identifier)->firstOrFail();

        DB::beginTransaction();

        try {
            $input = $request->except('_token');

            $emptyCheck = false;

            foreach ($input as $key => $field) {
                if(empty($field) && $field == null){
                    $emptyCheck = true;
                }
            }

            if($emptyCheck == false) {
                // check if files were uploaded and process them
                $uploadedFiles = $request->allFiles();
                foreach ($uploadedFiles as $key => $file) {
                    // store the file and set it's path to the value of the key holding it
                    if ($file->isValid()) {
                        $input[$key] = $file->store('fb_uploads', 'public');
                    }
                }

                $user_id = auth()->user()->id ?? null;

                $form->submissions()->create([
                    'user_id' => $user_id,
                    'content' => $input,
                ]);

                DB::commit();

                return redirect()
                    ->route('formbuilder::form.feedback', $identifier)
                    ->with('success', 'Form successfully submitted.');
            }else{
                $errors->add('field_check', 'You have submmited an blank application!');

                return redirect('recruitment')->withErrors($errors);
            }
        } catch (Throwable $e) {
            info($e);

            DB::rollback();

            return back()->withInput()->with('error', Helper::wtf());
        }
    }

    /**
     * Display a feedback page
     *
     * @param string $identifier
     * @return Response
     */
    public function feedback($identifier)
    {
        $form = Form::where('identifier', $identifier)->firstOrFail();

        $pageTitle = "Form Submitted!";

        return view('formbuilder::render.feedback', compact('form', 'pageTitle'));
    }
}
