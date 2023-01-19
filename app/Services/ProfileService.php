<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\Company;
use App\Models\EmployeeType;
use Carbon\Carbon;
use Shuchkin\SimpleXLSX;

class ProfileService
{
    public static function showEmployee()
    {
        return Profile::whereEncrypted('profile_group', '=', 'Employee')->get();
    }

    public static function saveEmployee($request)
    {
        $checkEmpNo = Profile::where('profile_no', '=', $request['empNo'])->exists();

        if($checkEmpNo) : 
            $response = [
                'status'  => 400,
                'message' => 'Employee number already exists. Try another one!'
            ];
        else : 
            $save = Profile::create([
                'profile_no'    => $request['empNo'],	
                'first_name'    => $request['firstName'],
                'middle_name'   => $request['midName'],
                'last_name'     => $request['lastName'],
                'birth_date'    => $request['birthDate'],
                'gender'        => $request['gender'],
                'address'       => $request['address'],
                'mobile_no'     => $request['mobileNo'],
                'company_name'  => $request['company'],
                'employee_type' => $request['type'],
                'profile_group' => 'Employee',
                'is_active'     => 1,
                'created_at'    => Carbon::now()
            ]);

            if($save) :

                $response = [
                    'status'  => 200,
                    'message' => 'Employee successfully save!'
                ];
            else :
                $response = [
                    'status'  => 400,
                    'message' => 'Server error. Failed to save employee!'
                ];
            endif;
        endif;

        return json_encode($response);
    }

    public static function employeeDetails($id)
    {
        return Profile::where('id', '=', $id)->get();
    }

    public static function modifyEmployeeDetails($request)
    {
        $checkEmpNo = Profile::where('profile_no', '=', $request['empNo'])
            ->where('id', '!=', $request['profileID'])->exists();

        if($checkEmpNo) :
            $response = [
                'status'  => 400,
                'message' => 'Employee number already exists. Try another one!'
            ];
        else : 
        
            $profile = Profile::find($request['profileID']);
            $profile->update([
                'profile_no'    => $request['empNo'],	
                'first_name'    => $request['firstName'],
                'middle_name'   => $request['midName'],
                'last_name'     => $request['lastName'],
                'birth_date'    => $request['birthDate'],
                'gender'        => $request['gender'],
                'address'       => $request['address'],
                'mobile_no'     => $request['mobileNo'],
                'company_name'  => $request['company'],
                'employee_type' => $request['type'],
                'updated_at'    => Carbon::now()
            ]);

            $response = [
                'status'  => 200,
                'message' => 'Employee successfully modified!'
            ];
        endif;

        return json_encode($response);
    }

    public static function employeeStatus($data)
    {
        $status = ($data['status'] == 'deactivate') ? 0 : 1;
        $update = Profile::where('id', '=', $data['id'])->update(['is_active' => $status]);

        if($update) :
            $response = [
                'status'  => 200,
                'message' => str_replace('%action%', $data['status'], 'Successfully %action% employee account!',)
            ];
        else :
            $response = [
                'status'  => 400,
                'message' => str_replace('%action%', $data['status'], 'Failed to %action% employee account!')
            ];
        endif;

        return json_encode($response);
    }

    public static function importEmployeeData($file)
    {
        $path = storage_path('app/uploads/'); 
        $fileName = static::uploadFile($path, $file);
        $srcFile = $path.$fileName;
        $data = static::parseExcelFile($srcFile);
        $errCount = 0;
        foreach($data as $row) :
            $check = static::checkEmpNo($row['EmpNo']);

            if($check) :
                $item = static::empStatus($row['EmpNo']);
                $profile = Profile::find($item[0]->id);
                $profile->update([
                    'first_name'    => $row['First Name'],
                    'middle_name'   => $row['Middle Name'],
                    'last_name'     => $row['Last Name'],
                    'birth_date'    => $row['Birthdate'],
                    'gender'        => $row['Gender'],
                    'address'       => $row['Address'],
                    'mobile_no'     => '0'.$row['Mobile'],
                    'company_name'  => $row['Company'],
                    'employee_type' => $row['Employee Type'],
                    'is_active'     => $row['Status'],
                    'updated_at'    => Carbon::now()
                ]);

                $errCount += 1;
            else :
                Profile::create([
                    'profile_no'    => $row['EmpNo'],	
                    'first_name'    => $row['First Name'],
                    'middle_name'   => $row['Middle Name'],
                    'last_name'     => $row['Last Name'],
                    'birth_date'    => $row['Birthdate'],
                    'gender'        => $row['Gender'],
                    'address'       => $row['Address'],
                    'mobile_no'     => '0'.$row['Mobile'],
                    'company_name'  => $row['Company'],
                    'employee_type' => $row['Employee Type'],
                    'profile_group' => 'Employee',
                    'is_active'     => 1,
                    'created_at'    => Carbon::now()
                ]);
            endif;
        endforeach;

        if($errCount > 0) :
            $response = [
                'status'  => 400,
                'message' => 'Successfully imported data but with errors. Please check your file.'
            ];
        else :
            $response = [
                'status'  => 200,
                'message' => 'Successfully imported data!'
            ];
        endif;

        return json_encode($response);
    }

    private function checkEmpNo($empNo)
    {
        $result = Profile::where('profile_no', '=', $empNo)->exists();

        return ($result) ? true : false;
    }

    private function empStatus($empNo)
    {
        return Profile::select('is_active', 'id')
			->where('profile_no', '=', $empNo)
			->get();
    }

    private function uploadFile($path, $file)
    {
        $fileName = time().rand(1,100).'.'.$file->extension();
        $file->move($path, $fileName);

        return $fileName;
    }

    private function parseExcelFile($file)
    {
        $xlsx = SimpleXLSX::parse($file);
        $header_values = $rows = [];
        foreach ( $xlsx->rows() as $k => $r ) :
            if ( $k === 0 ) :
                $header_values = $r;
                continue;
            endif;

            $rows[] = array_combine( $header_values, $r );
        endforeach;
        
        return $rows;
    }

    public static function optCompany()
    {
        return Company::where('is_active', '=', 1)->get();
    }

    public static function optEmployeeType()
    {
        return EmployeeType::where('is_active', '=', 1)->get();
    }
	
	public static function checkProfile($pn)
    {
        $result = Profile::where('profile_no', '=', $pn)->get();
		
		$profile = Profile::find($result[0]->id);
        $profile->update([
            'profile_group' => 'Employee'
        ]);

        dd($result);
    } 
}