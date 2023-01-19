<?php

namespace App\Exports;

use App\Models\Profile;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EmployeeExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $result = Profile::whereEncrypted('profile_group', '=', 'Employee')->get();

        return view('pages.exports.employee', [
            'data' => $result
        ]);
    }
}
