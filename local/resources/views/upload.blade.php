<form method="post" enctype="multipart/form-data">
	<input type="file" name="file">
	<button type="submit">Send</button>
	{{csrf_field()}}
</form>