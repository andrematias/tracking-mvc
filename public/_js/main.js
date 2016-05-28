$(document).ready(function(){
	//Remove a mensagem ao clicar
	$('[id=type_message]').click(function(){
		$(this).remove();
	});

	//Remove as mensagens apos 10 segundos
	setInterval(function(){
		$('[id=type_message]').remove();
	}, 10000);
});