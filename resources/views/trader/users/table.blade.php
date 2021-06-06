<table class="table table-striped">
    <thead>
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Customer Tokens</td>
            <td>CreditCard Tokens</td>
            <td>Orders</td>
            <td colspan="2">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->customerTokens()->count()}}</td>
            <td>{{$user->creditCardTokens()->count()}}</td>
            <td>{{$user->orders()->count()}}</td>
            <td>
                <a href="{{ route('root.users.show',$user->id)}}" class="btn btn-primary">Show</a>
                <!--
                <a href="{{ route('root.users.edit',$user->id)}}" class="btn btn-primary">Edit</a>
                <form action="{{ route('root.users.destroy', $user->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form>-->
            </td>
        </tr>
        @endforeach
    </tbody>
</table>