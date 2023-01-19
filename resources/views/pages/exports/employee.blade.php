<table>
    <thead>
        <tr>
           <th>EmpNo</th>
           <th>Last Name</th>
           <th>First Name</th>
           <th>Middle Name</th>
           <th>Address</th>
           <th>Birthdate</th>
           <th>Gender</th>
           <th>Mobile</th>
           <th>Company</th>
           <th>Employee Type</th>
           <th>Status</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($data as $item)
        <tr>
            <td>{{ $item->profile_no }}</td>
            <td>{{ $item->last_name }}</td>
            <td>{{ $item->first_name }}</td>
            <td>{{ $item->middle_name }}</td>
            <td>{{ $item->address }}</td>
            <td>{{ $item->birth_date }}</td>
            <td>{{ $item->gender }}</td>
            <td>{{ substr($item->mobile_no, 1) }}</td>
            <td>{{ $item->company_name }}</td>
            <td>{{ $item->employee_type }}</td>
            <td>{{ $item->is_active }}</td>
        </tr>
    @endforeach
    </tbody>
</table>