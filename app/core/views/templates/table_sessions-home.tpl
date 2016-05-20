<section class="body">
	<section class="export">
		<form id="form_export" action="" name="results" method="POST">
			<select name="export_results" id="types">
				%%OPTIONS_RESULTS%%
			</select>
			<input type="text" id="date" name="month_year">
			<input type="submit" value="Exportar">
		</form>
	</section>

	<!-- Tabela com dados -->
	<section class="tr_dados">
	<h4 style="float: left; margin-right: 10px">Total de sessões: %%TOTAL_SESSOES%%</h4>
	<h4 style="float: left; margin-right: 10px">Total de usuários: %%TOTAL_USUARIOS%%</h4>

	<form style="float: right;" method="post">
		<label for="inicio"> Página: </label>
		<input style="width: 60px" type="number" min="0" max="%%MAX_NUM%%" name="inicio" value="%%VALUE_ATUAL%%">
		<label>De %%TOTAL_PAGES%%</label>
		<input type="submit" name="exibir" value="Exibir">
	</form>
		<table>
			<thead id="titulos">
				<tr>
					<th>#</th>
					<th>Usuário</th>
					<th>Data</th>
					<th>Hora</th>
					<th>Tempo da Sessão</th>
					<th>Mais</th>
				</tr>
			</thead>					
			<tbody id="dados">
				%%LINES_INFO_TABLE%%
			</tbody>
		</table>
	</section>
</section> <!-- Fim da section body -->