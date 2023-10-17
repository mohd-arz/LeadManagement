<h1 class='text-2xl text-white text-center mb-3'>Executives</h1>
<table class="table table-dark table-striped table-hover table-bordered w-4/5 m-auto text-center text-white">
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
        @foreach($executives as $executive)
    <tr>
        <td>{{($executives->currentPage()-1)*$executives->perPage()+$loop->index+1}}</td>
        <td>{{$executive->name}}</td>
        <td>{{$executive->email}}</td> 
        <td>
            <select name="status" id="{{$executive->id}}" class='text-white bg-gray-800 text-center rounded-md  hover:border-gray-500 leading-tight focus:outline-none focus:shadow-outline'>
                <option value="active" {{$executive->status=='active' ? 'selected':''}}>Active</option>
                <option value="inactive" {{$executive->status=='inactive' ? 'selected':''}}>Inactive</option>
            </select>
        </td>
        <td>
            <a href="{{route('executiveEdit',$executive->id)}}"><button class='btn btn-primary'>Edit Executive</button></a>
        </td>
    </tr>
        @endforeach
</table>

<div class='p-3'>
    {{$executives->links()}}
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
<!-- Ajax for Changing Status of a User by Admin -->
<script>
    jQuery('document').ready(function(){
        jQuery('select').change(function(){
            var status =jQuery(this).val();
            var elementId = $(this).attr('id');
            console.log(status,elementId);
            jQuery.ajax({
                url:'/set_status',
                type:'post',
                data:'status='+status+'&id='+elementId+'&_token={{csrf_token()}}',
                success:function(response){
                    console.log(response);
                }
            })
        })
    })
</script>
