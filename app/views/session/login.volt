

	<div class="container">
			<div class="well">
		<div class="row">
			<div class="" style="width:25%;margin:0 auto">
					{{ form("AUTOCOMPLETE":"OFF") }}
					{{ form.render('csrf', ['value': security.getToken()]) }}
					<div class="form-group">
						{{ form.render('email') }} 
					</div>
					<div class="form-group">
							{{ form.render('password') }}
					</div>
					
					<div class="form-group checkbox">
							{{ form.render('remember') }} {{ form.label('remember') }}
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
				
				<div class="forgot">
						{{ link_to("session/forgotPassword", "Forgot password ? click here") }}
				</div>
			</div>
		</div>
	</div>
	</div>

