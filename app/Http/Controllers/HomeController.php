<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\FormService;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.form.index', [
            'referenceNo' => 'HD-'.date('Y').'-'.time(),
            'ids'         => FormService::checklistIDs(),
            'keyword'     => $request->segment(2),
            'company'     => FormService::optCompany(),
            'checklist'   => FormService::optChecklist(),
            'entryPoint'  => FormService::optEntryPoint()
        ]); 
		
		//return view('under');
    }

    public function details(Request $request)
    {
        echo FormService::profileDetails($request->input());
    }

    public function save(Request $request)
    {
        echo FormService::saveFormData($request->input());
    }

    public function codes(Request $request)
    {
        $code = $request->input('url').'/form/guest';
        echo \QrCode::size(100)->generate($code);
    }

    public function sendNotification(Request $request)
    {
        $details = [
            'guestNo' => $request->input('guestNo')
        ];
       
        \Mail::to($request->input('email'))->send(new \App\Mail\EmailNotification($details));

        echo 'Email sent!';
    }
}
