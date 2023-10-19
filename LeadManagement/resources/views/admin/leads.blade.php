<h1 class='text-2xl text-white text-center mb-3'>Leads</h1>
<table class="table table-dark table-striped table-hover table-bordered w-4/7 m-auto text-center text-white">
    <tr>
        <th>#</th>
        <th>Executive Name</th>
        <th>Lead Name</th>
        <th>Lead Email</th>
        <th>Lead Contact No:</th>
        <th>Lead Category</th>
        <th>Created at</th>
        <th>Lead Remark</th>
        <th>Action</th>
    </tr>
        @foreach($leads as $lead)
    <tr>
        <td>{{($leads->currentPage()-1)*$leads->perPage()+$loop->index+1}}</td>
        <td>
            @if($lead->user_status == 'active')
                {{$lead->executive_name}}
            @else
                {{$lead->executive_name}} ({{$lead->user_status}})
            @endif
        </td>
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
        <td>{{$lead->created_at->format('d-m-Y')}}</td>
        <td>{{$lead->remark}}</td>
        <td>
            <button type="button" class="btn btn-primary bg-blue-600" onclick="window.location.href='{{ route('editLeadPageAdmin', $lead->id) }}'">Edit</button>
            <button type="button" class="btn btn-danger bg-red-700" onclick="confirmAndDelete({{ $lead->id }})">Delete</button>
        </td>
    </tr>
        @endforeach
</table>

<div class='p-3'>
    {{$leads->links()}}
</div>
<!-- Js for Confirmation of Deletion -->
<script>
    function confirmAndDelete(leadId) {
        if (confirm('Are you sure you want to delete this lead?')) {
            window.location.href = "{{ route('deleteLead', ':leadId') }}".replace(':leadId', leadId);
        }
    }
</script>
