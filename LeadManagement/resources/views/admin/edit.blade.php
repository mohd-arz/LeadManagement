<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lead</title>
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
        <h1 class='text-center'>Edit Lead</h1>
        <div class="container d-flex justify-content-center align-items-center">
        <form action="{{route('editLeadAdmin',$lead->id)}}" method='post' class='form'>
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">Name:
                    <input type="text" name='name' class="form-control" value='{{$lead->name}}'>
                     @error('name') <p class='alert alert-danger mt-2'>{{$message}}</p> @enderror
                </label>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email:
                    <input type="email" name='email' class="form-control" value='{{$lead->email}}'>
                     @error('email') <p class='alert alert-danger mt-2'>{{$message}}</p> @enderror
                </label>
            </div>

            <div class="form-group">
                <label for="phone_no" class="form-label">Phone No:
                    <input type="phone_no" name='phone_no' class="form-control" value='{{$lead->phone_no}}'>
                     @error('phone_no') <p class='alert alert-danger mt-2'>{{$message}}</p> @enderror
                </label>
            </div>
            
            <div class="form-group">
                <label for="phone_code" class="form-label">Phone Code:
                    <input type="phone_code" name='phone_code' class="form-control"value='{{$lead->phone_code}}'>
                     @error('phone_code') <p class='alert alert-danger mt-2'>{{$message}}</p> @enderror
                </label>
            </div>

            <div class="form-group">
            <label for="executive">Executive:</label>
                <select name="executive" id="executive" class="form-select">
                    <option>--Select a Executive--</option>
                    @foreach($executives as $executive)
                    <option value="{{$executive->id}}" {{$executive->id==$lead->user_id ? 'selected':''}}>{{$executive->name}}</option>
                    @endforeach
                </select>
                @error('executive') <p class='alert alert-danger mt-2'>{{$message}}</p> @enderror
            </div>

            <div class="form-group">
            <label for="category">Category:</label>
                <select name="category" id="category" class="form-select">
                    <option>--Select a category--</option>
                    @foreach($categories as $category)
                    <option value="{{$category->catergory_type}}" {{$category->catergory_type==$lead->category ? 'selected':''}}>{{$category->catergory_type}}</option>
                    @endforeach
                </select>
                @error('category') <p class='alert alert-danger mt-2'>{{$message}}</p> @enderror
            </div>
            <div class="form-group">
                <label for="remark" class="form-label">Remark:
                    <input type="text" name='remark' class="form-control" value='{{$lead->remark}}'>
                     @error('remark') <p class='alert alert-danger mt-2'>{{$message}}</p> @enderror
                </label>
            </div>

            
            <div class="form-group mt-4">
                <input type="submit" value='Edit Lead' class='btn btn-primary'>
            </div>
        </form> 
        </div>
</body>
</html>