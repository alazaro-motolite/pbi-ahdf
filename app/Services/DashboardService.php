<?php

namespace App\Services;
use App\Models\Answer;
use App\Models\AnswerDetails;
use App\Models\Profile;
use App\Models\Checklist;
use App\Models\EntryPoint;
use Carbon\Carbon;

class DashboardService
{
    public static function showDashboardData()
    {
        $result = Answer::whereDate('answers.confirmation_date', '=', Carbon::now()->format('Y-m-d'))
            ->orderBy('answers.is_expose', 'desc')
            ->orderBy('answers.answer', 'desc')
            ->orderBy('answers.confirmation_date', 'desc')
            ->get();
        $output = '';
        $output .= '<table class="table table-sm dashboard_data_table">
                        <thead>
                            <tr>
                                <th>Ref. #</th>
                                <th class="col-md-1">Profile #</th>
                                <th>Name</th>
                                <th>Company</th>
                                <th class="text-center">Expose?</th>
                                <th class="text-center">Answer</th>
                                <th>Date</th>
                                <th>Point of Entry</th>
                                <th class="col-md-1">Group</th>
                                <th class="col-md-1 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach($result as $row) :
                $item = Profile::find($row->profile_id);
                $entry = EntryPoint::find($row->entry_point_id);
				$entry_point = (empty($entry)) ? '' : $entry->entry_point;
                $answer  = ($row->answer == 'No') ? 'label label-success' : 'label label-danger';
                $expose = ($row->is_expose == 'No') ? 'label label-success' : 'label label-danger';
        
                $output .= '<tr>
                                <td>'.$row->reference_no.'</td>
                                <td>'.$item->profile_no.'</td>
                                <td>'.$item->last_name .', '. $item->first_name .' '.$item->middle_name.'</td>
                                <td>'.$item->company_name.'</td>
                                <td class="text-center"><span class="'. $expose .'">'. strtoupper($row->is_expose) .'</span></td>
                                <td class="text-center"><span class="'. $answer .'">'. strtoupper($row->answer) .'</span></td>
                                <td>'.Carbon::parse($row->confirmation_date)->format('m/d/Y g:i A').'</td>
                                <td>'.$entry_point.'</td>
                                <td>'.$item->profile_group.'</td>
                                <td class="col-md-1 text-center">
                                    <ul class="icons-list">
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li><a data-toggle="modal" data-target="#modal_view_answer" data-refno="'.$row->reference_no.'" data-url="'. config('app.url').'/dashboard/view/answer/"><i class="icon-eye8"></i> View Answer</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                            </tr>';
                endforeach;
            $output .= '</tbody></table>';

        return $output;
    }

    public static function viewAnswer($refNo)
    {
        return AnswerDetails::where('reference_no', '=', $refNo)->get();
    }

    public static function getChecklistName($id)
    {
        $item = Checklist::find($id);

        return $item->checklist;
    }
}