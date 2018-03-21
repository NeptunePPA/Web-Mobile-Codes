@extends('layouts.app')

@section('content')

<div class="login-panel">
		<div class="login-form">
		<h2>Login</h2>
       
 <form role="form" method="POST" action="{{ url('admin/login') }}">
                        {{ csrf_field() }}
						
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                          
                            <div class="input username-icon">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                          
                            <div class="input paddword-icon">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        

                            <div class="login-btn">
								<input type="submit" value="Log in" />
                            </div>
							
							<div class="remember clearfix">
								<input type="checkbox" class="checkbox" id="rememberme" name="remember"/> <label for="rememberme"> Remember me </label>
								<a href="{{ url('/password/reset') }}" class="forgot" title="I forgot my password!">I forgot my password!</a>
							</div>
							
	

                    </form>
                </div>
            </div>
@endsection
