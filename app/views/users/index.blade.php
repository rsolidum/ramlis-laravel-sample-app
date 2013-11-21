<h1>All users</h1>

{{ $users->links() }}

<ul class="users">
  @foreach ($users as $user) 
    <li>
    	<img src="<?= Gravatar::src($user->email, 52) ?>">
    	{{ HTML::link(URL::route('users.show',$user->id), "$user->firstname $user->lastname") }}
    </li>
  @endforeach
</ul>

{{ $users->links() }}