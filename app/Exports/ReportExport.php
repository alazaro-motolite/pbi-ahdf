<?php

namespace App\Exports;

use App\Models\Answer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
use Carbon\Carbon;

class ReportExport implements FromView, ShouldAutoSize
{
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function view(): View
    {
        $startDate = Carbon::parse($this->data['startDate'])->format('Y-m-d');
        $endDate   = Carbon::parse($this->data['endDate'])->format('Y-m-d');

        $result =  Answer::whereDate('answers.confirmation_date', '>=', $startDate)
            ->whereDate('answers.confirmation_date', '<=', $endDate)
            ->get();

        return view('pages.exports.xlsx', [
            'data' => $result
        ]);
    }
}
