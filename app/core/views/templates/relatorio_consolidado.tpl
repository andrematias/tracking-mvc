<header class="cabecalho_content">
	<form method="post" action="">
		<label><img src="/public/_imagens/calendar_icon.gif" width="20"></label>
		<input type="date" name="date">
		<label>até</label>
		<input type="date" name="date_end">
		<input type="submit" name="date_go" value="Selecionar">
	</form>
	<span><strong>Cliente: </strong>%%CLIENTE%%</span>
</header>

<h3>Relatório Consolidado</h3>
	<section class="scroll_x tr_dados">
		<table>
			<thead>
				<th>Date</th>
				<th>Visitor</th>
				<th>Subject</th>
				<th>Description</th>
				<th>Request</th>
				<th>E-mail</th>
				<th>Function</th>
				<th>Phone</th>
				<th>Company</th>
				<th>SBU</th>
				<th>Address</th>
				<th>Zip Code</th>
				<th>City</th>
				<th>State</th>
				<th>Country</th>
				<th>CNPJ</th>
				<th>Source</th>
				<th>Content</th>
				<th>Time of Navigation</th>
				<th>Lead</th>
				<th>Score</th>
			</thead>
			<tbody>
				%%USER_CONTENT_DATA%%
			</tbody>
		</table>
	</section>
</article>
