<table>
    <thead>
        <tr>
           <th>Reference #</th>
           <th>Profile #</th>
           <th>Name</th>
           <th>Company</th>
           <th>Expose?</th>
           <th>Answer</th>
           <th>Date</th>
           <th>Point of Entry</th>
           <th>Last Visit</th>
           <th>Group</th>
        </tr>
    </thead>
    <tbody>
    @php 
    foreach ($data as $item): 
    $details = \App\Models\Profile::find($item->profile_id);
    $row = \App\Models\EntryPoint::find($item->entry_point_id);
	$entry_point = (empty($row)) ? '' : $row->entry_point;
    @endphp
        <tr>
            <td>{{ $item->reference_no }}</td>
            <td>{{ $details->profile_no }}</td>
            <td>{{ $details->last_name.', '.$details->first_name.' '. $details->middle_name }}</td>
            <td>{{ $details->company_name }}</td>
            <td>{{ $item->is_expose }}</td>
            <td>{{ $item->answer }}</td>
            <td>{{ \Carbon\Carbon::parse($item->confirmation_date)->format('m/d/Y g:i A') }}</td>
            <td>{{ $entry_point }}</td>
            <td>{{ $item->last_visit }}</td>
            <td>{{ $details->profile_group }}</td>
        </tr>
    @php
    endforeach;
    @endphp
    </tbody>
</table>