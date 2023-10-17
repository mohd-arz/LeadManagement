<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Executive</title>
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
            <form action="{{route('editExecutive',$executive->id)}}" method='post' class='form'>
                @csrf
                <!-- Executive Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Name:
                    <input type="text" name='name' class="form-control" value='{{$executive->name}}'>
                    @error('name') <p class='alert alert-danger mt-2'>{{$message}}</p> @enderror
                    </label>
                </div>

                <!-- Executive Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email:
                    <input type="email" name='email' class="form-control" value='{{$executive->email}}'>
                    @error('email') <p class='alert alert-danger mt-2'>{{$message}}</p> @enderror
                    </label>
                </div>

                <!-- Executive Password (Read Only) -->
                <div class="form-group">
                    <label for="email" class="form-label">Password(Read Only):
                    <input type="password" name='password' class="form-control" value='{{$executive->password}}' readonly>
                    </label>
                </div>

                <!-- Submittion -->
                <div class="form-group mt-4">
                    <input type="submit" value='Edit Executive' class='btn btn-primary'>
                </div>
            </form> 
        </div>
</body>
</html>