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
        <form action="" method='get' class='form m-2 flex items-center'>
            <!-- Filter by Category -->
            <div class="form-group m-2 flex flex-col">
                <label for="category" class=' text-white pl-2'>Filter by Category:</label>
                <select name="category" id="category" class='text-white bg-gray-800 text-center rounded-md  hover:border-gray-500 leading-tight focus:outline-none focus:shadow-outline'>
                    <option value='' >--Select a Category--</option>
                    @foreach($categories as $category)
                    <option value="{{$category->catergory_type}}" {{Request::get('category')==$category->catergory_type ? 'selected':''}}>{{$category->catergory_type}}</option>
                    @endforeach
                </select>
            </div>

            
            <!-- Filter by Executive -->
            <div class="form-group m-2 flex flex-col">
                <label for="executive" class='text-white pl-2'>Filter by Executive:</label>
                <select name="executive" id="executive" class='text-white bg-gray-800 text-center rounded-md  hover:border-gray-500 leading-tight focus:outline-none focus:shadow-outline'>
                <option value=''>--Select a Executive--</option>
                    @foreach($executives as $executive)
                    <option value="{{$executive->id}}" {{Request::get('executive')==$executive->id ? 'selected':''}}>{{$executive->name}}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Filter by Date -->
            <div class="form-group m-2 flex flex-col" id='date_filter'>
                <label for="date_filter" class='text-white pl-2'>Filter by Date:</label>
                <input type="date" name='date_filter' value="{{Request::get('date_range')=='custom' ? Request::get('date_filter') : ''}}" class=' text-white bg-gray-800 text-center rounded-md  hover:border-gray-500 leading-tight focus:outline-none focus:shadow-outline'>
            </div>
            <!-- Filter by Range -->
            <div class="form-group m-2 flex flex-col">
                <label for="date_range" class='text-white pl-2'>Filter by Range</label>
                <select name="date_range" id="date_range" class='text-white bg-gray-800 text-center rounded-md  hover:border-gray-500 leading-tight focus:outline-none focus:shadow-outline'>
                    <option value="">--Select Range--</option>
                    <option value="today" {{Request::get('date_range')=='today' ? 'selected':''}}>Today</option>
                    <option value="last_three_days" {{Request::get('date_range')=='last_three_days' ? 'selected':''}}>Last Three Days</option>
                    <option value="last_week" {{Request::get('date_range')=='last_week' ? 'selected':''}}>Last Week </option>
                    <option value="last_month" {{Request::get('date_range')=='last_month' ? 'selected':''}}>Last Month </option>
                    <option value="custom" {{Request::get('date_range')=='custom' ? 'selected':''}}>Custom</option>
                </select>
            </div>

            <!-- Submittion -->
            <div class="form-group m-2 self-end">
                <button type='submit' class='btn btn-primary px-4'>Filter</button>
            </div>
        </form>
        <!-- Add Lead  -->
        <a href="{{route('addLeadPageAdmin')}}" class="btn btn-primary text-white ml-auto mr-4">Add Lead</a>
    </div>

    <!-- Leads Container -->
    <div class="leads-container">
        @include('admin.leads',compact('leads'))
    </div>
    
</x-app-layout>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
<script>
    jQuery('document').ready(function(){ 
        $('#date_filter').hide();
        if($('#date_range').val()=='custom'){
            $('#date_filter').show();
        }
        $('#date_range').change(function(){
            if(jQuery(this).val()=='custom'){
                $('#date_filter').show();
            }else{
                $('#date_filter').hide();
            }
        })
     }) 
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