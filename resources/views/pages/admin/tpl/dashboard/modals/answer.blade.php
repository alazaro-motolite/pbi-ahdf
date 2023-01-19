<table class="table table-xs table-bordered">
    <thead>
        <tr class="border-double btn-default">
            <th>Symptoms Checklist</th>
            <th class="col-md-1 text-center">Answer</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($answers as $row)
        <tr>
            <td>{{ \App\Services\DashboardService::getChecklistName($row->checklist_id) }}</td>
            <td class="col-md-1 text-center"><span class="label {{ ($row->answer == 'No') ? 'label-success' : 'label-danger' }}">{{ $row->answer }}</span></td>
        </tr>
    @endforeach
    </tbody>
</table>