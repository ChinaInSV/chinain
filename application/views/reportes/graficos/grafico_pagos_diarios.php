<div id="grafico-pagos-container"></div>
<script>
$(function () {
	<?php
		$this->load->library("App_utilities");
		$PadillaApp = new App_utilities();
		if(isset($transacciones)):
	?>
    $('#grafico-pagos-container').highcharts({
        title: {
            text: 'Grafico de Pagos Diarios',
            x: -20 //center
        },
        subtitle: {
            text: 'Fuente: Base de Datos China In v1.0.0',
            x: -20
        },
        xAxis: {
            categories: [
				<?php
					foreach($transacciones as $transaccion):
						$fecha = explode("-",$transaccion->Fecha);
						echo '"'.$fecha[2].' de '.$PadillaApp->TraducirMes($fecha[1]).'",';
					endforeach;
				?>
			]
        },
        yAxis: {
            title: {
                text: 'Dolares ($)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
		plotOptions: {
            series: {
                dataLabels: {
                    enabled: <?php echo $valores;?>,
					format: '{point.y:.1f} dolares'
                }
            }
        },
        tooltip: {
            valueSuffix: ' dolares'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series:[
			{
				name: 'Ventas',
				data: [
					<?php
						foreach($transacciones as $transaccion):
							echo $transaccion->Total.",";
						endforeach;
					?>
				]
			}
		]
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