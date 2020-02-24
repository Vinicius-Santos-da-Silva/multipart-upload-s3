<h3>Editar</h3>

<form method="POST">
	Nome:<br/>
	<input type="text" name="nome" value="<?php echo $info['nome']; ?>" /><br/><br/>

	E-mail:<br/>
	<?php echo $info['email']; ?><br/><br/>

	<input type="submit" value="Salvar" />

</form>