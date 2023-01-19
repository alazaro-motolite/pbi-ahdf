<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardService;
use App\Exports\ReportExport;
use Excel;
use Mail;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.admin.tpl.dashboard.index');
    }

    public function show()
    {
        echo DashboardService::showDashboardData();
    }

    public function view(Request $request)
    {
        return view('pages.admin.tpl.dashboard.modals.answer', [
            'answers' => DashboardService::viewAnswer($request->segment(4))
        ]);
    }

    public function exportReport(Request $request)
    {
        $data = [
            'startDate' => $request->input('startDate'),
            'endDate'   => $request->input('endDate')
        ];

        $filename = 'ReportExtraction_'.Carbon::parse($request->input('startDate'))->format('Ymd').'_to_'.Carbon::parse($request->input('endDate'))->format('Ymd').'.xlsx';

        return Excel::download(new ReportExport($data), $filename);
    }

    public function sendReport()
    {
        $filterDate = Carbon::now()->subDay();
        $data = [
            'startDate' => $filterDate,
            'endDate'   => $filterDate
        ];
        
        $filename = 'ReportExtraction_'.Carbon::parse($filterDate)->format('Ymd').'_to_'.Carbon::parse($filterDate)->format('Ymd').'.xlsx';
        Excel::store(new ReportExport($data), '/excel/exports/'.$filename, 'local');

        $attachment = storage_path('app/excel/exports/'.$filename);

        $details = [
            'email'   => 'hdf@multilifecare.ph',
            'subject' => 'Automated Health Declaration Report'
        ];

        Mail::send('pages.mail.mail_report', $details, function($message)use($details, $attachment) {
            $message->to($details["email"])
                    ->subject($details["subject"])
                    ->attach($attachment);
        });
		
		echo 'Mail sent successfully';
    }
}
