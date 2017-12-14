<div id="container<?=$jenis?>" style="height: 300px; margin: 0 auto"></div>
					
<script type="text/javascript">
	$('#container<?=$jenis?>').highcharts({
	        chart: {
	            type: 'column'
	        },
	        title: {
	            text: '<?=$judul?>'
	        },
	        xAxis: {
	            type: 'category',
	            labels: {
	                rotation: -45,
	                style: {
	                    fontSize: '11px',
	                    fontFamily: 'Verdana, sans-serif'
	                }
	            }
	        },
	        yAxis: {
	            min: 0,
	            title: {
	                text: 'Rupiah'
	            }
	        },
	        legend: {
	            enabled: false
	        },
	        tooltip: {
	            pointFormat: 'Jumlah : <b>{point.y}</b>'
	        },
	        series: [{
	            name: 'Penerimaan',
	            data: [<?=$g?>],
	            dataLabels: {
	                enabled: true,
	                rotation: 0,
	                color: '#000',
	                align: 'right',
	                x: 4,
	                y: 10,
	                style: {
	                    fontSize: '11px',
	                    fontFamily: 'Verdana, sans-serif',
	                    textShadow: '0 0 3px black'
	                }
	            }
	        }]
	    });
</script>