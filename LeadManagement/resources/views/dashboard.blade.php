<head>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Executive Dashboard') }}
        </h2>
    </x-slot>
    <!-- Session Message -->
    @if(session('message'))
        <p class="alert alert-success d-inline-block m-4 absolute top-5 ">{{session('message')}}</p>
    @endif
    <a href="{{route('addLeadPage')}}" class="btn btn-primary text-white m-3">Add Lead</a>
    <!-- Executive LeadContainer -->
    <div class="leads-container">
        @include('lead',compact('leads'))
    </div>
</x-app-layout>
<!-- Session Message TimeOut -->
<script>
     const resultbtn=document.querySelector('.alert');
        setTimeout(() => {
            resultbtn.parentNode.removeChild(resultbtn);
        }, 2000);
</script>