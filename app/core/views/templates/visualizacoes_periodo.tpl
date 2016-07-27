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
        series: %%SERIES%%
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