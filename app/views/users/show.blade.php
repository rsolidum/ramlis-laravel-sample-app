<div class="row">
  <aside class="span4">
    <section>
      <h1>
        <img src="<?= Gravatar::src($user->email) ?>" class="gravatar">
        {{ $user->firstname }} {{ $user->lastname }}
      </h1>
    </section>
    <section>
    	<div class="stats">
    		<span>
			    <strong id="following" class="stat">
			      {{  $user->followed_users()->count() }}<br>
			      following
			    </strong>
			    
			  </span>
			  <span>
			    <strong id="followers" class="stat">
			      {{  $user->following_users()->count() }}<br>
			      followers
			    </strong>

			  </span>
			  <span>
			  	@if(Auth::check() and Auth::user()->id != $user->id)
			  		<div id="follow_form">
					  @if(Auth::user()->following($user))
					    {{ Form::open(array('route' => array('relationships.destroy', Auth::user()->following($user)->id), 'method' => 'delete', 'class' => 'delete_form')) }}
								<button type="submit" href="{{ URL::route('relationships.destroy', Auth::user()->following($user)->id) }}" class="btn btn-primary">Unfollow</butfon>
							{{ Form::close() }}
					  @else
						  	{{ Form::open(array('route'=>'relationships.store','class'=>'follow_form')) }}
						  	{{ Form::hidden('followed_id',$user->id); }}
								{{ Form::submit('Follow', array('class'=>'btn btn-primary'))}}
								{{ Form::close() }}
					  @endif
					  </div>
			  	@endif
			  </span>
			</div>
    </section>
    @if(Auth::check() and Auth::user()->id == $user->id)
    <section>
			{{ Form::open(array('route'=>'microposts.store')) }}
				<ul>
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
				<div class="field">
					{{ Form::textarea('body', null, array('class'=>'input-block-level', 'placeholder'=>'Compose new micropost...')) }}
				</div>
				{{ Form::submit('Post', array('class'=>'btn btn-large btn-primary'))}}
			{{ Form::close() }}
    </section>
    @endif
    
  </aside>
  <div class="span8">
    @if ($microposts->count() > 0)
      <h3>Microposts ({{$microposts->count()}})</h3>
	      <ol class="microposts">
		      @foreach ($microposts as $micropost) 
		      	<li>
						  <span class="content"> {{ $micropost->body }}</span>
						  <span class="timestamp">
						    Posted {{ $micropost->get_created_ago() }} ago.
						  </span>
						  @if ( Auth::check() and $micropost->user->id == Auth::user()->id )
						  	{{ Form::open(array('route' => array('microposts.destroy', $micropost->id), 'method' => 'delete', 'data-confirm' => 'Are you sure?', 'class' => 'delete_form')) }}
								      <button type="submit" href="{{ URL::route('microposts.destroy', $micropost->id) }}" class="btn btn-danger btn-mini">Delete</butfon>
								{{ Form::close() }}
							@endif
						</li>
		      @endforeach
	      </ol>
      {{ $microposts->links() }}
    @endif
  </div>
</div>