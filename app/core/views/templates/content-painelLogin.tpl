<article class="painelLogin">
	<img src="%%IMAGE_LOGO%%" width="200">
	<div class="%%CLASS_MSG%%">
		<span>%%MSG_ERROR%%</span>
	</div>
	<form method="POST" action="">
		<input name="user" type="text" placeholder="Nome de Usuário"><br>
		<input name="pass" type="password" placeholder="Senha"><br>
		<select name="clientes">
			%%CLIENT_OPTIONS%%
		</select><br><br>
		<input class="btn-blue" type="submit" name="op" value="Entrar">
	</form>
</article>