<div id="grafico-grupos-container"></div>
<script>
$(function () {
	<?php
		if(isset($grupos)):
			$totalventas = 0;
			foreach($grupos as $grupo):if($grupo->total>0):
				$totalventas+=$grupo->total;
			endif;endforeach;	
	?>	
    $('#grafico-grupos-container').highcharts({
		title: {
            text: 'Grafico de Ventas por Categoria de Platos',
            x: -20
        },
        subtitle: {
            text: 'Fuente: Base de Datos China In v1.0.0',
            x: -20
        },
         chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: <?php echo $valores;?>,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: "Ventas",
            colorByPoint: true,
            data: [
					<?php
						foreach($grupos as $grupo):if($grupo->total>0):
							echo '{name: "'.$grupo->nombre_categoria_menu.'",';
							echo 'y:'.($grupo->total * 100 / $totalventas).',drilldown: "'.$grupo->nombre_categoria_menu.'"},';
						endif;endforeach;
					?>
			]
        }],
		drilldown: {
            series: [
				<?php
					foreach($grupos as $grupo):if($grupo->total>0):
						echo '{name: "'.$grupo->nombre_categoria_menu.'",';
						echo 'id: "'.$grupo->nombre_categoria_menu.'",data:[';
						foreach($grupo->platos as $servicio):if($servicio->pagos>0):
							echo '["'.$servicio->nombre_plato.'",'.$servicio->pagos.'],';
						endif;endforeach;
						echo "]},";
					endif;endforeach;
				?>
			]
        }
    });
	<?php
		else:
	?>
	toastr.options = {
	  "closeButton": true,
	  "progressBar": true,
	  "positionClass": "toast-top-right"
	}
	toastr.error('No hay informacion para dibujar un grafico');
	<?php
		endif;
	?>
});
</script>