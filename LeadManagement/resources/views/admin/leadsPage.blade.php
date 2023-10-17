<head>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>   
    <a href="{{route('addLeadPageAdmin')}}" class="btn btn-primary text-white m-3">Add Lead</a>

    <select name="category" id="category" class='text-white bg-gray-800 text-center rounded-md  hover:border-gray-500 leading-tight focus:outline-none focus:shadow-outline m-3'>
        <option value='all'>--Sort by category--</option>
        @foreach($categories as $category)
        <option value="{{$category->catergory_type}}">{{$category->catergory_type}}</option>
        @endforeach
    </select>
    <select name="executive" id="executive" class='text-white bg-gray-800 text-center rounded-md  hover:border-gray-500 leading-tight focus:outline-none focus:shadow-outline m-3'>
    <option value='all'>--Sort by Executive--</option>
         @foreach($executives as $executive)
        <option value="{{$executive->id}}">{{$executive->name}}</option>
        @endforeach
    </select>

    <select name="date" id="date" class='text-white bg-gray-800 text-center rounded-md  hover:border-gray-500 leading-tight focus:outline-none focus:shadow-outline m-3'>
    <option value='all'>--Sort by Created date--</option>
    <option value="lower">Lower</option>
    <option value="higher">Higher</option>
    </select>
    <div class="leads-container">
        @include('admin.leads',compact('leads'))
    </div>
    
</x-app-layout>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
</script>