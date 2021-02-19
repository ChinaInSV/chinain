<div id="grafico-grupos-container"></div>
<script>
$(function () {
	<?php
		if(isset($grupos)):
	?>	
    $('#grafico-grupos-container').highcharts({
		chart: {
            type: 'column'
        },
       title: {
            text: 'Grafico de Ventas por Categoria de Platos',
            x: -20
        },
        subtitle: {
            text: 'Fuente: Base de Datos China In v1.0.0',
            x: -20
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Dolares ($)'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: <?php echo $valores;?>,
                    format: '{point.y:.1f} dolares'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> dolares<br/>'
        },
		series: [{
            name: "Ventas",
            colorByPoint: true,
            data: [
					<?php
						foreach($grupos as $grupo):if($grupo->total>0):
							echo '{name: "'.$grupo->nombre_categoria_menu.'",';
							echo 'y:'.$grupo->total.',drilldown: "'.$grupo->nombre_categoria_menu.'"},';
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