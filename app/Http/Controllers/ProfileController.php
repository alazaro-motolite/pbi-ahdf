<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProfileService;
use App\Exports\EmployeeExport;
use Excel;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function index()
    {
        return view('pages.admin.tpl.profile.index', [
            'employee' => ProfileService::showEmployee()
        ]);
    }

    public function show()
    {
        echo ProfileService::showEmployee();
    }

    public function add()
    {
        return view('pages.admin.tpl.profile.modals.add', [
            'company' => ProfileService::optCompany(),
            'type'    => ProfileService::optEmployeeType()
        ]);
    }

    public function save(Request $request)
    {
        echo ProfileService::saveEmployee($request->input());
    }

    public function edit(Request $request)
    {
        return view('pages.admin.tpl.profile.modals.edit', [
            'company' => ProfileService::optCompany(),
            'type'    => ProfileService::optEmployeeType(),
            'details' => ProfileService::employeeDetails($request->segment(3))
        ]);
    }

    public function update(Request $request)
    {
        echo ProfileService::modifyEmployeeDetails($request->input());
    }

    public function status(Request $request)
    {
        echo ProfileService::employeeStatus($request->input());
    }

    public function importForm()
    {
        return view('pages.admin.tpl.profile.modals.import');
    }

    public function importData(Request $request)
    {
        echo ProfileService::importEmployeeData($request->file('files'));
    }

    public function exportData()
    {
        $filename = 'EmployeeAsOf_'.Carbon::now()->format('Ymd').'.xlsx';

        return Excel::download(new EmployeeExport(), $filename);
    }
}
