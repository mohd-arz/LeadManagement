<table class="table table-dark table-striped table-hover table-bordered w-4/5 m-auto text-center text-white">
    <tr>
        <th>#</th>
        <th>Executive Name</th>
        <th>Lead Name</th>
        <th>Lead Email</th>
        <th>Lead Contact No:</th>
        <th>Lead Category</th>
        <th>Lead Remark</th>
        <th>Action</th>
    </tr>
        @foreach($leads as $lead)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$lead->executive_name}}</td>
       <td>{{$lead->name}}</td>
       <td>
            @if($lead->email!=null)
            {{$lead->email}}
            @else
            No email Provided
            @endif
        </td>
        <td>@if($lead->phone_no != null)
            {{$lead->phone_code}} {{$lead->phone_no}}
            @else
            No Phoneno Provided
            @endif
        </td>
        <td>{{$lead->category}}</td>   
        <td>{{$lead->remark}}</td>
        <td>
        <button type="button" class="btn btn-primary bg-blue-600" onclick="window.location.href='{{ route('editLeadPageAdmin', $lead->id) }}'">Edit</button>
    <button type="button" class="btn btn-danger bg-red-700" onclick="confirmAndDelete({{ $lead->id }})">Delete</button>
        </td>
    </tr>
        @endforeach
</table>
<script>
    function confirmAndDelete(leadId) {
        if (confirm('Are you sure you want to delete this lead?')) {
            window.location.href = "{{ route('deleteLead', ':leadId') }}".replace(':leadId', leadId);
        }
    }
</script>
