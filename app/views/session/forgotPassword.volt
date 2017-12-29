
<div align="center" class="well">

	<h2>Forgot Password?</h2>
		
	{{ form('class': 'form-search', "AUTOCOMPLETE":"OFF") }}
	{{ form.render('csrf', ['value': security.getToken()]) }}


		{{ form.render('email') }}
		{{ form.render('Send') }}

		<hr>

		

	</form>

</div>