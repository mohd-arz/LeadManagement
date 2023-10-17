<head>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>   

    <!-- For Messaging -->
    @if(session('message'))
        <p class="alert alert-success d-inline-block m-4 absolute top-5">{{session('message')}}</p>
    @endif

    <!-- For Viewing Leads -->
    <a href="{{route('leadPage')}}" class="btn btn-primary m-3">View Leads</a>

    <!-- For partials Executive -->
    <div class="executives-container">
        @include('admin.executive',compact('executives'))
    </div>
</x-app-layout>
<!-- Timeout Message -->
<script>
     const resultbtn=document.querySelector('.alert');
        setTimeout(() => {
            resultbtn.parentNode.removeChild(resultbtn);
        }, 2000);
</script>
