<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CmsService;

class CmsController extends Controller
{
    public function checklist()
    {
        return view('pages.admin.tpl.cms.checklist.index');
    }

    public function showChecklist()
    {
        echo CmsService::getChecklist();
    }

    public function addChecklistForm()
    {
        return view('pages.admin.tpl.cms.checklist.modals.add_checklist');
    }

    public function saveChecklist(Request $request)
    {
        echo CmsService::doSaveChecklist($request->input());
    }

    public function editChecklistForm(Request $request)
    {
        return view('pages.admin.tpl.cms.checklist.modals.edit_checklist', [
            'details' => CmsService::checklistDetails($request->segment(4))
        ]);
    }

    public function updateChecklist(Request $request)
    {
        echo CmsService::doModifyChecklist($request->input());
    }

    public function checklistStatus(Request $request)
    {
        echo CmsService::checklistStatus($request->input());
    }

    public function company()
    {
        return view('pages.admin.tpl.cms.company.index');
    }

    public function showCompany()
    {
        echo CmsService::getCompany();
    }

    public function addCompanyForm()
    {
        return view('pages.admin.tpl.cms.company.modals.add_company');
    }

    public function saveCompany(Request $request)
    {
        echo CmsService::doSaveCompany($request->input());
    }

    public function editCompanyForm(Request $request)
    {
        return view('pages.admin.tpl.cms.company.modals.edit_company', [
            'details' => CmsService::companyDetails($request->segment(4))
        ]);
    }

    public function updateCompany(Request $request)
    {
        echo CmsService::doModifyCompany($request->input());
    }

    public function companyStatus(Request $request)
    {
        echo CmsService::companyStatus($request->input());
    }

    public function entry()
    {
        return view('pages.admin.tpl.cms.entry.index');
    }

    public function showEntryPoint()
    {
        echo CmsService::getEntryPoint();
    }

    public function addEntryPointForm()
    {
        return view('pages.admin.tpl.cms.entry.modals.add_entry');
    }

    public function saveEntryPoint(Request $request)
    {
        echo CmsService::doSaveEntryPoint($request->input());
    }

    public function editEntryPointForm(Request $request)
    {
        return view('pages.admin.tpl.cms.entry.modals.edit_entry', [
            'details' => CmsService::entryPointDetails($request->segment(4))
        ]);
    }

    public function updateEntryPoint(Request $request)
    {
        echo CmsService::doModifyEntryPoint($request->input());
    }

    public function entryPointStatus(Request $request)
    {
        echo CmsService::entryPointStatus($request->input());
    }

    public function employeeType()
    {
        return view('pages.admin.tpl.cms.e_type.index');
    }

    public function showEmployeeType()
    {
        echo CmsService::getEmployeeType();
    }

    public function addEmployeeTypeForm()
    {
        return view('pages.admin.tpl.cms.e_type.modals.add');
    }

    public function saveEmployeeType(Request $request)
    {
        echo CmsService::doSaveEmployeeType($request->input());
    }

    public function editEmployeeTypeForm(Request $request)
    {
        return view('pages.admin.tpl.cms.e_type.modals.edit', [
            'details' => CmsService::employeeTypeDetails($request->segment(4))
        ]);
    }

    public function updateEmployeeType(Request $request)
    {
        echo CmsService::doModifyEmployeeType($request->input());
    }

    public function employeeTypeStatus(Request $request)
    {
        echo CmsService::employeeTypeStatus($request->input());
    }
}
