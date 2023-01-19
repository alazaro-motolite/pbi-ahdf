<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Checklist;
use App\Models\Profile;
use App\Models\Answer;
use App\Models\AnswerDetails;
use App\Models\Logs;
use App\Models\EntryPoint;
use Carbon\Carbon;

class FormService
{
    public static function optCompany()
    {
        return Company::where('is_active', '=', 1)->get();
    }

    public static function optChecklist()
    {
        return Checklist::where('is_active', '=', 1)->get();
    }

    public static function optEntryPoint()
    {
        return EntryPoint::where('is_active', '=', 1)->get();
    }

    public static function checklistIDs()
    {
        $result = Checklist::where('is_active', '=', 1)->get();
        $output = '';
        foreach($result as $row) :
            $output .= $row->id.',';
        endforeach;

        return substr($output, 0, -1);
    }

    public static function profileDetails($request)
    {
        if($request['group'] == 'employee') :
            $result = Profile::where('profile_no', '=', $request['empNo'])
                ->whereEncrypted('profile_group', '=', 'Employee')
                ->where('is_active', '=', 1)
                ->get();
        else :
            if($request['guestNo'] == NULL) :
                $result = Profile::whereEncrypted('last_name', '=', $request['lastName'])
                    ->whereEncrypted('first_name', '=', $request['firstName'])
                    ->whereEncrypted('middle_name', '=', $request['midName'])
                    ->whereEncrypted('birth_date', '=', $request['birthDate'])
                    ->whereEncrypted('profile_group', '=', 'Guest')
                    ->get();
            else :
                $result = Profile::where('profile_no', '=', $request['guestNo'])
                    ->whereEncrypted('profile_group', '=', 'Guest')
                    ->get();
            endif;
        endif;


        if($result->isEmpty()) :
            $message = ($request['group'] == 'employee') ? 'Employee does not exist. Please approach the security personnel at the gate for manual health declaration and registration.' : 'Guest is not yet registered. You may proceed to fill-up the form to register.';

            $response = [
                'status'  => 400,
                'message' => $message,
                'data'    => NULL
            ];
        else :
            $data = [
                'empNo'     => ($request['group'] == 'guest') ? NULL : $result[0]->profile_no,
                'guestNo'   => ($request['group'] == 'guest') ? $result[0]->profile_no : NULL,
                'email'     => ($request['group'] == 'guest') ? $result[0]->email : NULL,
                'lastName'  => $result[0]->last_name,
                'firstName' => $result[0]->first_name,
                'midName'   => $result[0]->middle_name,
                'birthDate' => $result[0]->birth_date,
                'address'   => $result[0]->address,
                'company'   => $result[0]->company_name,
                'mobile'    => $result[0]->mobile_no,
                'profileLog' => static::checkLogs($result[0]->profile_no)
            ];

            $response = [
                'status'  => 200,
                'message' => NULL,
                'data'    => $data
            ];
        endif;

        return json_encode($response); 
    }

    public static function saveFormData($request)
    {
        $search = ($request['group'] == 'employee') ? $request['empNo'] : $request['guestNo'];
        $checkProfile = Profile::where('profile_no', '=', $search)
            ->where('is_active', '=', 0)->exists();

        if($checkProfile) :
            $response = [
                'status' => 400,
                'title'  => 'Warning!',
                'text'   => 'Employee or guest number already in used. You cannot use it twice on different profile!',
                'icon'   => 'waning'
            ];
        else :
            $dateTime  = Carbon::now();
            $profileID = static::registerProfile($request, $dateTime);

            $count = Answer::where('profile_id', '=', $profileID)
                ->whereDate('confirmation_date', '=', Carbon::now()->format('Y-m-d'))
                ->count();

            if($count == 1) :
                $response = [
                    'status' => 400,
                    'title'  => 'Warning!',
                    'text'   => 'You have already answered the Health Declaration form for today!',
                    'icon'   => 'waning'
                ];
            else :
                $checklist = explode(',', $request['checklist']);
                $insert = Answer::create([
                    'reference_no'      => $request['refNum'],
                    'profile_id'        => $profileID,
                    'is_expose'         => $request['isExpose'],
                    'answer' 	        => $request['answer'],
                    'entry_point_id'    => $request['entryPoint'],
                    'last_visit'        => $request['lastVisit'],
                    'confirmation_date' => $dateTime
                ]);

                if($insert) :
                    foreach($checklist as $row) :
                        $value = explode('&', $row);

                        AnswerDetails::create([
                            'reference_no' => $request['refNum'],
                            'checklist_id' => $value[1],
                            'answer'       => $value[0]
                        ]);
                    endforeach;

                    if($request['answer'] == 'No' && $request['isExpose'] == 'No') :
                        $title = '<h1 class="text-center text-bold text-success-800">Thank you!</h1>
								<h5 class="text-center text-semibold">Entry Point : '.static::getEntryPoint($request['entryPoint']).'</h5>
                                <h5 class="col-md-12 text-center text-semibold">Disclaimer: If you developed any symptoms of COVID-19 within the day, please contact LifeCare hotline at 09171249500 for assistance.(KUNG MAY NARAMDAMANG KAHIT ANONG SINTOMAS NG COVID-19 ay tumawag lamang sa numero 09171249500 upang mabigyan ng payo).</h5>';
                        $text  = '<div class="col-md-12 text-center text-semibold">Reference No. : '.$request['refNum'].'</div><div class="col-md-12 text-center text-semibold">Date and Time. : '.Carbon::parse($dateTime)->format('M d, Y g:i A').'</div>';
                    else :
                        if($request['group'] == 'guest') :
                            $title = '<h1 class="text-center text-bold text-danger-800">Our apologies, but you cannot enter the SMIPC premises at this time.</h1>';
                            $text  = NULL;
                        else :
                            $title = '<h1 class="text-center text-bold text-danger-800">Thank you. Please contact Lifecare at 09171249500!</h1>';
                            $text  = '<div class="col-md-12 text-center text-semibold">Reference No. : '.$request['refNum'].'</div><div class="col-md-12 text-center text-semibold">Date and Time. : '.Carbon::parse($dateTime)->format('M d, Y g:i A').'</div>';
                        endif;
                    endif;

                    $response = [
                        'status' => 200,
                        'title'  => $title,
                        'text'   => $text,
                        'icon'   => 'success'
                    ];
                else :
                    $response = [
                        'status' => 400,
                        'title'  => 'Error!',
                        'text'   => 'Failed to save health declaration data!',
                        'icon'   => 'error'
                    ];
                endif;
            endif;
        endif;

        return json_encode($response);
    }

    public function registerProfile($input, $timestamp)
    {
        $keyword = ($input['group'] == 'employee') ? $input['empNo'] : $input['guestNo'];
        $result  = Profile::where('profile_no', '=', $keyword)->whereEncrypted('profile_group', '=', $input['group'])->get();

        if(($input['group'] == 'employee')) :
            $check = static::checkLogs($input['empNo']);

            if($check == 0) :
                static::saveLogs($input['empNo']);
            endif;
        endif;

        if($result->isEmpty()) :
            $profile = Profile::create([
                'profile_no'    => ($input['group'] == 'guest') ? $input['guestNo'] : $input['empNo'],
                'last_name'     => $input['lastName'],
                'first_name'    => $input['firstName'],
                'middle_name'   => $input['midName'],
                'birth_date'    => $input['birthDate'],
                'address'       => $input['address'],
                'mobile_no'     => $input['mobileNo'],
                'company_name'  => $input['company'],
                'profile_group' => ucfirst($input['group']),
                'is_active'     => 1,
                'created_at'    => $timestamp
            ]);

            $profileID = $profile->id;
        else :
            if($input['group'] == 'employee') :
                $address = Profile::find($result[0]->id);
                $address->update([
                    'address'    => $input['address'],
                    'updated_at' => Carbon::now()
                ]);
            endif;

            $profileID = $result[0]->id;
        endif;

        return $profileID;
    }

    private function checkLogs($profileNo)
    {
        $exist = Logs::where('profile_no', '=', $profileNo)->exists();

        return ($exist) ? 1 : 0;
    }

    private function saveLogs($profileNo)
    {
        Logs::create([
            'profile_no' => $profileNo,
            'log_date'   => Carbon::now()
        ]);
    }
	
	private function getEntryPoint($id)
    {
        $result = EntryPoint::find($id);

        return $result->entry_point;
    }

}