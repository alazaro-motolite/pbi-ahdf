<?php

namespace App\Services;

use App\Models\Checklist;
use App\Models\Company;
use App\Models\EntryPoint;
use App\Models\EmployeeType;
use Carbon\Carbon;

class CmsService
{
    public static function getChecklist()
    {
        $result = Checklist::all();
        $output = '';
        $output .= '<table class="table table-sm checklist_data_table">
                    <thead>
                        <tr>
                            <th>Checklist/Symptoms</th>
                            <th class="col-md-1 text-center">Status</th>
                            <th class="col-md-1 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach($result as $row) :
            $badge  = ($row->is_active == 1) ? 'label label-success' : 'label label-danger';
            $text   = ($row->is_active == 1) ? 'ACTIVE' : 'INACTIVE';
            $status = ($row->is_active == 1) ? 'deactivate' : 'activate';
            $icon   = ($row->is_active == 1) ? 'icon-close2' : 'icon-checkmark-circle2';

            $output .= '<tr>
                            <td>'.$row->checklist.'</td>
                            <td class="col-md-1 text-center"><span class="'. $badge .'">'. $text .'</span></td>
                            <td class="col-md-1 text-center">
                                <ul class="icons-list">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a data-toggle="modal" data-target="#modal_edit_checklist" data-id="'. $row->id .'" data-url="'. config('app.url') .'/cms/checklist/edit/"><i class="icon-pencil"></i> Edit Details</a></li>
                                            <li><a id="btnChecklistStatus" data-url="'. config('app.url') .'/cms/checklist/status" data-id="'. $row->id .'" data-status="'. $status .'"><i class="'. $icon .'"></i> '. ucwords($status).'</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                        </tr>';
            endforeach;
        $output .= '</tbody></table>';

        return $output;
    }

    public static function doSaveChecklist($request)
    {
        $check = Checklist::where('checklist', '=', $request['checklist'])->exists();
        if($check) :
            $response = [
                'status'  => 400,
                'message' => 'Checklist/Symptoms already exists. Try another one!'
            ];
        else :
            $save = Checklist::create([
                    'checklist'  => $request['checklist'],
                    'is_active'  => 1,
                    'created_at' => Carbon::now()
                ]);
            
            if($save) :
                $response = [
                    'status'  => 200,
                    'message' => 'Checklist/Symptoms successfully save!'
                ];
            else :
                $response = [
                    'status'  => 400,
                    'message' => 'Failed to save checklist/symptoms!'
                ];
            endif;
        endif;

        return json_encode($response);
    }

    public static function checklistDetails($id)
    {
        return Checklist::where('id', '=', $id)->get();
    } 

    public static function doModifyChecklist($request)
    {
        $check = Checklist::whereEncrypted('checklist', '=', $request['checklist'])
            ->where('id', '!=', $request['checklistID'])->exists();

        if($check) :
            $response = [
                'status'  => 400,
                'message' => 'Checklist/Symptoms already exists. Try another one!'
            ];
        else :
            $checklist = Checklist::find($request['checklistID']);
            $checklist->update([
                'checklist'  => $request['checklist'],
                'updated_at' => Carbon::now()
            ]);
            
            $response = [
                'status'  => 200,
                'message' => 'Checklist/Symptoms successfully modified!'
            ];
        endif;

        return json_encode($response);
    }

    public static function checklistStatus($data)
    {
        $status = ($data['status'] == 'deactivate') ? 0 : 1;
        $update = Checklist::where('id', '=', $data['checklistID'])->update(['is_active' => $status]);

        if($update) :
            $response = [
                'status'  => 200,
                'message' => str_replace('%action%', $data['status'], 'Successfully %action% checklist/symptoms!')
            ];
        else :
            $response = [
                'status'  => 400,
                'message' => str_replace('%action%', $data['status'], 'Failed to %action% checklist/symptoms!')
            ];
        endif;

        return json_encode($response);
    }

    public static function getCompany()
    {
        $result = Company::all();
        $output = '';
        $output .= '<table class="table table-sm company_data_table">
                    <thead>
                        <tr>
                            <th>Company</th>
                            <th class="col-md-1 text-center">Status</th>
                            <th class="col-md-1 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach($result as $row) :
            $badge  = ($row->is_active == 1) ? 'label label-success' : 'label label-danger';
            $text   = ($row->is_active == 1) ? 'ACTIVE' : 'INACTIVE';
            $status = ($row->is_active == 1) ? 'deactivate' : 'activate';
            $icon   = ($row->is_active == 1) ? 'icon-close2' : 'icon-checkmark-circle2';

            $output .= '<tr>
                            <td>'.$row->company.'</td>
                            <td class="col-md-1 text-center"><span class="'. $badge .'">'. $text .'</span></td>
                            <td class="col-md-1 text-center">
                                <ul class="icons-list">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a data-toggle="modal" data-target="#modal_edit_company" data-id="'. $row->id .'" data-url="'. config('app.url') .'/cms/company/edit/"><i class="icon-pencil"></i> Edit Details</a></li>
                                            <li><a id="btnCompanyStatus" data-url="'. config('app.url') .'/cms/company/status" data-id="'. $row->id .'" data-status="'. $status .'"><i class="'. $icon .'"></i> '. ucwords($status).'</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                        </tr>';
            endforeach;
        $output .= '</tbody></table>';

        return $output;
    }

    public static function doSaveCompany($request)
    {
        $check = Company::where('company', '=', $request['company'])->exists();
        if($check) :
            $response = [
                'status'  => 400,
                'message' => 'Company already exists. Try another one!'
            ];
        else :
            $save = Company::create([
                    'company'    => $request['company'],
                    'is_active'  => 1,
                    'created_at' => Carbon::now()
                ]);
            
            if($save) :
                $response = [
                    'status'  => 200,
                    'message' => 'Company successfully save!'
                ];
            else :
                $response = [
                    'status'  => 400,
                    'message' => 'Failed to save company!'
                ];
            endif;
        endif;

        return json_encode($response);
    }

    public static function companyDetails($id)
    {
        return Company::where('id', '=', $id)->get();
    } 

    public static function doModifyCompany($request)
    {
        $check = Company::whereEncrypted('company', '=', $request['company'])
            ->where('id', '!=', $request['companyID'])->exists();

        if($check) :
            $response = [
                'status'  => 400,
                'message' => 'Company already exists. Try another one!'
            ];
        else :
            $company = Company::find($request['companyID']);
            $company->update([
                'company'  => $request['company'],
                'updated_at' => Carbon::now()
            ]);
            
            $response = [
                'status'  => 200,
                'message' => 'Company successfully modified!'
            ];
        endif;

        return json_encode($response);
    }

    public static function companyStatus($data)
    {
        $status = ($data['status'] == 'deactivate') ? 0 : 1;
        $update = Company::where('id', '=', $data['companyID'])->update(['is_active' => $status]);

        if($update) :
            $response = [
                'status'  => 200,
                'message' => str_replace('%action%', $data['status'], 'Successfully %action% company!')
            ];
        else :
            $response = [
                'status'  => 400,
                'message' => str_replace('%action%', $data['status'], 'Failed to %action% company!')
            ];
        endif;

        return json_encode($response);
    }

    public static function getEntryPoint()
    {
        $result = EntryPoint::all();
        $output = '';
        $output .= '<table class="table table-sm entry_data_table">
                    <thead>
                        <tr>
                            <th>Point of Entry</th>
                            <th class="col-md-1 text-center">Status</th>
                            <th class="col-md-1 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach($result as $row) :
            $badge  = ($row->is_active == 1) ? 'label label-success' : 'label label-danger';
            $text   = ($row->is_active == 1) ? 'ACTIVE' : 'INACTIVE';
            $status = ($row->is_active == 1) ? 'deactivate' : 'activate';
            $icon   = ($row->is_active == 1) ? 'icon-close2' : 'icon-checkmark-circle2';

            $output .= '<tr>
                            <td>'.$row->entry_point.'</td>
                            <td class="col-md-1 text-center"><span class="'. $badge .'">'. $text .'</span></td>
                            <td class="col-md-1 text-center">
                                <ul class="icons-list">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a data-toggle="modal" data-target="#modal_edit_entry" data-id="'. $row->id .'" data-url="'. config('app.url') .'/cms/entry/edit/"><i class="icon-pencil"></i> Edit Details</a></li>
                                            <li><a id="btnEntryStatus" data-url="'. config('app.url') .'/cms/entry/status" data-id="'. $row->id .'" data-status="'. $status .'"><i class="'. $icon .'"></i> '. ucwords($status).'</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                        </tr>';
            endforeach;
        $output .= '</tbody></table>';

        return $output;
    }

    public static function doSaveEntryPoint($request)
    {
        $check = EntryPoint::where('entry_point', '=', $request['entryPoint'])->exists();
        if($check) :
            $response = [
                'status'  => 400,
                'message' => 'Point of entry already exists. Try another one!'
            ];
        else :
            $save = EntryPoint::create([
                    'entry_point' => $request['entryPoint'],
                    'is_active'   => 1,
                    'created_at'  => Carbon::now()
                ]);
            
            if($save) :
                $response = [
                    'status'  => 200,
                    'message' => 'Point of entry successfully save!'
                ];
            else :
                $response = [
                    'status'  => 400,
                    'message' => 'Failed to save point of entry!'
                ];
            endif;
        endif;

        return json_encode($response);
    }

    public static function entryPointDetails($id)
    {
        return EntryPoint::where('id', '=', $id)->get();
    } 

    public static function doModifyEntryPoint($request)
    {
        $check = EntryPoint::whereEncrypted('entry_point', '=', $request['entryPoint'])
            ->where('id', '!=', $request['entryID'])->exists();

        if($check) :
            $response = [
                'status'  => 400,
                'message' => 'Point of entry already exists. Try another one!'
            ];
        else :
            $company = EntryPoint::find($request['entryID']);
            $company->update([
                'entry_point' => $request['entryPoint'],
                'updated_at'  => Carbon::now()
            ]);
            
            $response = [
                'status'  => 200,
                'message' => 'Point of entry successfully modified!'
            ];
        endif;

        return json_encode($response);
    }

    public static function entryPointStatus($data)
    {
        $status = ($data['status'] == 'deactivate') ? 0 : 1;
        $update = EntryPoint::where('id', '=', $data['entryID'])->update(['is_active' => $status]);

        if($update) :
            $response = [
                'status'  => 200,
                'message' => str_replace('%action%', $data['status'], 'Successfully %action% point of entry!')
            ];
        else :
            $response = [
                'status'  => 400,
                'message' => str_replace('%action%', $data['status'], 'Failed to %action% point of entry!')
            ];
        endif;

        return json_encode($response);
    }


    public static function getEmployeeType()
    {
        $result = EmployeeType::all();
        $output = '';
        $output .= '<table class="table table-sm emp_type_data_table">
                    <thead>
                        <tr>
                            <th>Employee Type</th>
                            <th class="col-md-1 text-center">Status</th>
                            <th class="col-md-1 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach($result as $row) :
            $badge  = ($row->is_active == 1) ? 'label label-success' : 'label label-danger';
            $text   = ($row->is_active == 1) ? 'ACTIVE' : 'INACTIVE';
            $status = ($row->is_active == 1) ? 'deactivate' : 'activate';
            $icon   = ($row->is_active == 1) ? 'icon-close2' : 'icon-checkmark-circle2';

            $output .= '<tr>
                            <td>'.$row->type_name.'</td>
                            <td class="col-md-1 text-center"><span class="'. $badge .'">'. $text .'</span></td>
                            <td class="col-md-1 text-center">
                                <ul class="icons-list">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a data-toggle="modal" data-target="#modal_edit_emp_type" data-id="'. $row->id .'" data-url="'. config('app.url') .'/cms/employee-type/edit/"><i class="icon-pencil"></i> Edit Details</a></li>
                                            <li><a id="btnEmpTypeStatus" data-url="'. config('app.url') .'/cms/employee-type/status" data-id="'. $row->id .'" data-status="'. $status .'"><i class="'. $icon .'"></i> '. ucwords($status).'</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                        </tr>';
            endforeach;
        $output .= '</tbody></table>';

        return $output;
    }

    public static function doSaveEmployeeType($request)
    {
        $check = EmployeeType::where('type_name', '=', $request['type'])->exists();
        if($check) :
            $response = [
                'status'  => 400,
                'message' => 'Employee type already exists. Try another one!'
            ];
        else :
            $save = EmployeeType::create([
                    'type_name'  => $request['type'],
                    'is_active'  => 1,
                    'created_at' => Carbon::now()
                ]);
            
            if($save) :
                $response = [
                    'status'  => 200,
                    'message' => 'Employee type successfully save!'
                ];
            else :
                $response = [
                    'status'  => 400,
                    'message' => 'Failed to save employee type!'
                ];
            endif;
        endif;

        return json_encode($response);
    }

    public static function employeeTypeDetails($id)
    {
        return EmployeeType::where('id', '=', $id)->get();
    } 

    public static function doModifyEmployeeType($request)
    {
        $check = EmployeeType::where('type_name', '=', $request['type'])
            ->where('id', '!=', $request['id'])->exists();

        if($check) :
            $response = [
                'status'  => 400,
                'message' => 'Employee type already exists. Try another one!'
            ];
        else :
            $company = EmployeeType::find($request['id']);
            $company->update([
                'type_name'  => $request['type'],
                'updated_at' => Carbon::now()
            ]);
            
            $response = [
                'status'  => 200,
                'message' => 'Employee type successfully modified!'
            ];
        endif;

        return json_encode($response);
    }

    public static function employeeTypeStatus($data)
    {
        $status = ($data['status'] == 'deactivate') ? 0 : 1;
        $update = EmployeeType::where('id', '=', $data['id'])->update(['is_active' => $status]);

        if($update) :
            $response = [
                'status'  => 200,
                'message' => str_replace('%action%', $data['status'], 'Successfully %action% employee type!')
            ];
        else :
            $response = [
                'status'  => 400,
                'message' => str_replace('%action%', $data['status'], 'Failed to %action% employee type!')
            ];
        endif;

        return json_encode($response);
    }
    
}