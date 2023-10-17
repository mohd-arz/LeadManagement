<head>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>   

    @if(session('message'))
    <p class="alert alert-success d-inline-block m-4 absolute top-5">{{session('message')}}</p>
    @endif

    <div class="top-section flex place-items-center">
        <!-- Form for Filtering -->
        <form action="" method='get' class='m-2'>
            <!-- Sort by Category -->
            <select name="category" id="category" class='text-white bg-gray-800 text-center rounded-md  hover:border-gray-500 leading-tight focus:outline-none focus:shadow-outline m-3'>
                <option value='' >--Sort by category--</option>
                @foreach($categories as $category)
                <option value="{{$category->catergory_type}}" {{Request::get('category')==$category->catergory_type ? 'selected':''}}>{{$category->catergory_type}}</option>
                @endforeach
            </select>
            <!-- Sort by Executive -->
            <select name="executive" id="executive" class='text-white bg-gray-800 text-center rounded-md  hover:border-gray-500 leading-tight focus:outline-none focus:shadow-outline m-3'>
            <option value=''>--Sort by Executive--</option>
                @foreach($executives as $executive)
                <option value="{{$executive->id}}" {{Request::get('executive')==$executive->id ? 'selected':''}}>{{$executive->name}}</option>
                @endforeach
            </select>
            <!-- Sort by Date -->
            <select name="date" id="date" class='text-white bg-gray-800 text-center rounded-md  hover:border-gray-500 leading-tight focus:outline-none focus:shadow-outline m-3'>
                <option value=''>--Sort by Created date--</option>
                <option value="lower" {{Request::get('date')=='lower' ? 'selected':''}}>Oldest</option>
                <option value="higher" {{Request::get('date')=='higher' ? 'selected':''}}>Latest</option>
            </select>
            <!-- Submittion -->
            <button type='submit' class='btn btn-primary'>Filter</button>
        </form>
        <!-- Add Lead  -->
        <a href="{{route('addLeadPageAdmin')}}" class="btn btn-primary text-white ml-auto mr-4">Add Lead</a>
    </div>

    <!-- Leads Container -->
    <div class="leads-container">
        @include('admin.leads',compact('leads'))
    </div>
    
</x-app-layout>
<script>
     const resultbtn=document.querySelector('.alert');
        setTimeout(() => {
            resultbtn.parentNode.removeChild(resultbtn);
        }, 2000);
</script>
<!-- Ajax Filtering  but multiple filtering is not working as I intended-->

<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
<script>
    jQuery('document').ready(function(){    
        jQuery('#category').change(function(){
            let filter=jQuery(this).val();
            jQuery.ajax({
                url:'/filter_category',
                type:'post',
                data:'filter='+filter+'&_token={{csrf_token()}}',
                success:function(response){
                // console.log(response);
                jQuery('.leads-container').html(response);
                },
            })
        })
        jQuery('#executive').change(function(){
            let filter=jQuery(this).val();
            jQuery.ajax({
                url:'/filter_executive',
                type:'post',
                data:'filter='+filter+'&_token={{csrf_token()}}',
                success:function(response){
                // console.log(response);
                jQuery('.leads-container').html(response);
                },
            })
        })
        jQuery('#date').change(function(){
            let value=jQuery(this).val();
            console.log(value)
            if(value=='higher'){
                jQuery.ajax({
                url:'/filter_higher',
                type:'post',
                data:'value='+value+'&_token={{csrf_token()}}',
                success:function(response){
                // console.log(response);
                jQuery('.leads-container').html(response);
                },
            })

            }
            else{
                jQuery.ajax({
                    url:'/filter_lower',
                    type:'post',
                    data:'value='+value+'&_token={{csrf_token()}}',
                    success:function(response){
                    console.log(response);
                    jQuery('.leads-container').html(response);
                    },
                })
            }
           
        })
    })
</script> -->