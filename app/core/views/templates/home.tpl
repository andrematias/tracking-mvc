<header class="cabecalho_content">
	<form method="post" action="">
		<label><img src="/public/_imagens/calendar_icon.gif" width="20"></label>
		<input type="date" name="date">
		<label>até</label>
		<input type="date" name="date_end">
		<input type="submit" name="date_go" value="Selecionar">
	</form>
	<span><strong>Cliente: </strong>http://blogadhesivoindustrial.com</span>
</header>

<h3>Média de visualizações no período</h3>

<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: '%%TITULO%%'
        },
        subtitle: {
            text: '%%SUBTITULO%%'
        },
        xAxis: {
            categories: [%%CATEGORIAS%%]
        },
        yAxis: {
            title: {
                text: '%%TITULO_Y%%'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        series: [{
            name: '%%NOME_SERIE%%',
            data: [%%DATA_VALUES%%]
        }]
    });
});
		</script>

<article id="container"  class="grafico">
	
</article>


<article class="meta_infos">
	<div class="meta">
		<p>Média de visualizações</p>
		<p>1460</p>
	</div>
	<div class="meta">
		<p>Visualizações de páginas</p>
		<p>4560</p>
	</div>
	<div class="meta">
		<p>Páginas / Sessão</p>
		<p>3,31</p>
	</div>
</article>