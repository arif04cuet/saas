{{ content() }}

<div align="center" class="well">

	{{ form('class': 'form-search', "AUTOCOMPLETE":"OFF") }}

	<div align="left">
		<h2>Forgot Password?</h2>
	</div>

		{{ form.render('email') }}
		{{ form.render('Send') }}

		<hr>

		{{ form.render('csrf', ['value': security.getToken()]) }}

	</form>

</div>