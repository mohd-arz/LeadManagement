<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Lead</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400&display=swap" rel="stylesheet">
</head>
<style>
        body{
            font-family: 'Figtree', sans-serif;
            background-color :rgb(17 24 39);
            color: rgb(175 ,175,175);
            height:100vh;
            display:flex;
            flex-direction:column;
        }
        .container{
            flex:1;
            display:flex;
            justify-content
            align-items:center;
        }
        .form-group{
            margin: 1rem;
        }
        .form-control,input{
            border:1px solid black;
            width:50vw;
        }
        .alert{
           padding: 0.1rem;
        }
    </style>
<body>
        <h1 class='text-center'>Add Lead</h1>
        <div class="container d-flex justify-content-center align-items-center">
            <form action="{{route('addLeadAdmin')}}" method='post' class='form'>
                @csrf

                <!-- Lead Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Name:
                        <input type="text" name='name' class="form-control" >
                        @error('name') <p class='alert alert-danger mt-2'>{{$message}}</p> @enderror
                    </label>
                </div>

                <!-- Contact Type -->
                <div class="form-group">
                    <label for="contact_option">Contact Type:</label>
                    <select name="contact_option" id="contact_option" class='form-select'>
                        <option value=''>--Select Contact Option--</option>
                        <option value="email">Email</option>
                        <option value="phone">Phone</option>
                    </select>
                    @error('contact_option') <p class='alert alert-danger mt-2'>{{$message}}</p> @enderror
                </div>

                <!-- Placement for contacts -->
                <div class="contact-container"></div>

                <!-- Choosing Executives -->
                <div class="form-group">
                    <label for="executive">Active Executives:</label>
                        <select name="executive" id="executive" class="form-select">
                            <option value=''>--Select a Executive--</option>
                            @foreach($executives as $executive)
                            <option value="{{$executive->id}}">{{$executive->name}}</option>
                            @endforeach
                        </select>
                        @error('executive') <p class='alert alert-danger mt-2'>{{$message}}</p> @enderror
                </div>

                <!-- Categories -->
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select name="category" id="category" class="form-select">
                        <option value=''>--Select a category--</option>
                        @foreach($categories as $category)
                        <option value="{{$category->catergory_type}}">{{$category->catergory_type}}</option>
                        @endforeach
                    </select>
                    @error('category') <p class='alert alert-danger mt-2'>{{$message}}</p> @enderror
                </div>
                
                <!-- Remarks -->
                <div class="form-group">
                    <label for="remark" class="form-label">Remark:
                        <input type="text" name='remark' class="form-control" >
                        @error('remark') <p class='alert alert-danger mt-2'>{{$message}}</p> @enderror
                    </label>
                </div>
        
                <!-- Submittion -->
                <div class="form-group mt-4">
                    <input type="submit" value='Add Lead' class='btn btn-primary'>
                </div>
            </form> 
        </div>
</body>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
<script>
    jQuery('document').ready(function(){
        jQuery('#contact_option').change(function(){
            let option =jQuery(this).val();
            jQuery.ajax({
                url:'/set_option',
                type:'post',
                data:'option='+option+'&_token={{csrf_token()}}',
                success:function(response){
                    console.log(response);
                    jQuery('.contact-container').html(response);
                }
            })
        })
    })
</script>
</html>