<head>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Duplicates ') }}
        </h2>
    </x-slot>   
    <table class="table table-dark table-striped table-hover table-bordered w-4/5 m-auto text-center text-white">
    <tr>
        <th>#</th>
        <th>Executive Name</th>
        <th>Lead Name</th>
        <th>Lead Email</th>
        <th>Lead Contact No:</th>
        <th>Lead Category</th>
        <th>Lead Remark</th>
    </tr>
        @foreach($leads as $lead)
    <tr>
        <td>{{($leads->currentPage()-1)*$leads->perPage()+$loop->index+1}}</td>
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
    </tr>
        @endforeach
</table>
<div>
    <label class='text-white'>Do you wish to Add Duplication :</label>
    <a href="{{route('addDuplicate')}}" ><button class="btn btn-primary text-white m-3">Yes</button></a>
    <a href="{{route('rejectDuplicate')}}" ><button class="btn btn-primary text-white m-3">No</button></a>
</div>
</x-app-layout>

<div class='p-3'>
    {{$leads->links()}}
</div>