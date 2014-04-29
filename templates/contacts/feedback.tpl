<p>Форма обратной связи</p>
<form name="sendmessage" method="POST">
	<p>
		<label>Имя:</label>
		<br/>
		<input name="username" type="text" required/>
	</p>
	<p>
		<label>E-mail:</label>
		<br/>
		<input name="email" type="text" pattern="[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})" required/>
	</p>
	<p>
		<label>Телефон:</label>
		<br/>
		<input name="telephone" type="text" pattern="[0-9]*" required/>
	</p>
	<p>
		<textarea name="text" rows="10" cols="50" required></textarea>
	</p>
	<p>
		<input type="submit" name="sendmessage" value="Отправить сообщение" />
	</p>
</form>