<!DOCTYPE html>
<html lang="en">
 	<head>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    	<title>Laravel Sample App</title>

    	{{ HTML::style('packages/bootstrap/css/bootstrap.min.css') }}
    	{{ HTML::style('css/main.css')}}
    	{{ HTML::script('js/jquery-2.0.3.min.js')}}
    	{{ HTML::script('js/bootstrap.min.js')}}
    	<script>
    		$(function() {
 
				        // Confirm deleting resources
				        $("form[data-confirm]").submit(function() {
				                if ( ! confirm($(this).attr("data-confirm"))) {
				                        return false;
				                }
				        });
				 
				});
    	</script>
  	</head>

  	<body>

	  	<header class="navbar navbar-fixed-top">
		  	<div class="navbar-inner">
		    	<div class="container">
		    	{{ HTML::link('/', 'Sample App',array('id'=>'logo')) }}
					<ul class="nav pull-right">  
						
							<li>{{ HTML::link('/', 'Home') }}</li>   
							<li>{{ HTML::link('/about', 'About') }}</li>   
							<li>{{ HTML::link('/users', 'All Users') }}</li> 
						@if(!Auth::check())
							<li>{{ HTML::link('/register', 'Register') }}</li>   
							<li>{{ HTML::link('/login', 'Login') }}</li>   
						@else
							
	            <li id="fat-menu" class="dropdown">
	              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                Account <b class="caret"></b>
	              </a>
	              <ul class="dropdown-menu">
	                <li>{{ HTML::link(URL::route('users.show',Auth::user()->id), 'Profile') }}</li>
	                <li>{{ HTML::link(URL::route('users.edit',Auth::user()->id), 'Settings') }}</li>
	                <li class="divider"></li>
	                <li>{{ HTML::link('/logout', 'Logout') }}</li>
	              </ul>
	            </li>
						@endif
					</ul>  
		    	</div>
		  	</div>
		</header> 	            

	    <div class="container">
	    	@if(Session::has('message'))
				<p class="alert">{{ Session::get('message') }}</p>
			@endif

	    	{{ $content }}

	    	<footer class="footer">
				  <small>
				    Laravel Sample App
				    by <a href="http://www.ramlijohn.com/about">Ramli John</a>
				  </small>
				  <nav>
				    <ul>
				      <li>{{ HTML::link('/about', 'About') }}</li>
				    </ul>
				  </nav>
				</footer>
	    </div>
  	</body>
</html>