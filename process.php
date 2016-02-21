<?php

//error_reporting(null);

require_once 'login-portal.php';

$obj = new LoginPortal();

$login = $obj->masuk($_POST['user'], $_POST['pass']);

if ($login) {
	
	$page = $obj->getKHSPage();
	
	$temp = @reset(explode('</div>', explode('<div id="member-info">', $page)[1]));
	
	$name = @reset(explode('</h3>', explode('<h3>', $temp)[1]));
	$nim = @reset(explode('</h4>', explode('<h4>', $temp)[1]));
	$prodi = @reset(explode('</h4>', explode('<h4>', $temp)[2]));
	
	
	$options = @reset(explode("</select>", explode('<select id="semester" name="semester">', $page)[1]));
	
	$semester = [];
	$postData = [];
	
	$explode = explode('<option value="', $options) ;
	unset($explode[count($explode)-1]);
	unset($explode[0]);
	foreach ($explode as $key=>$val) {
		$semester[] = @reset(explode('</option>', explode('" >', $val)[1]));
		$postData[] = @reset(explode('" >', $val));
		
	}
	
	$sks = [];
	$ip = [];
	foreach ($postData as $val) {
		$ipPage = $obj->getIPPage($val);
		
		
		$ip[] = @reset(explode('</td>', explode('<td>: ', explode('<th>IP Semester</th>', $ipPage)[1])[1]));
		$sks[] = @reset(explode('</td>', explode('<td>: ', explode('<th>Jumlah SKS yang Diambil</th>', $ipPage)[1])[1]));
		
	}
	
	
	
	$series = [];
	$ipk = 0;
	$jlhSks = 0;
	for ($i=0;$i<count($semester);$i++) {
		if ($ip[$i] <= 0) {
			unset($ip[$i]);
			unset($semester[$i]);
			unset($sks[$i]);
		} else {
			$temp = [];
			$temp['y'] = (float)$ip[$i];
			$temp['semester'] = $semester[$i];
			$temp['sks'] = $sks[$i];
				
			
			$ipk += $ip[$i] * $sks[$i];
			$jlhSks += $sks[$i];
			
			$series[] = $temp;
		}
	}
	
	$ipk = number_format($ipk / (float) $jlhSks, 2);
	
}

?>

<?php 
	if (!$login) {
?>
	<h2 style="text-align:center">Login gagal!</h2>
<?php
	} else {
?>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	
	<h2 style="text-align:center">
		<?php echo $name?> (<?php echo $nim?>)<br/>
		<small><?php echo $prodi?></small>
	</h2>
	
	<div id="result"></div>
	
	<table border="1" cellpadding="5" cellspacing="0" style="margin:30px auto">
		<tr>
			<th>Semester</th>
			<th>Jlh SKS</th>
			<th>IP Semester</th>
		</tr>
		<?php
			foreach ($series as $val) {
		?>
			<tr>
				<td><?php echo $val['semester']?></td>
				<td><?php echo $val['sks']?></td>
				<td><?php echo number_format($val['y'], 2)?></td>
			</tr>
		<?php 	
			}
		?>
		<tr>
			<td colspan="2" align="right"><b>IP Kumulatif</b></td>
			<td><b><?php echo number_format($ipk, 2)?></b></td>
		</tr>
	</table>
	
	<script>
	$(function () {
	    $('#result').highcharts({
	    	title: {
	    	    text: 'Grafik Indeks Prestasi'
	    	},
	    	subtitle: {
	    	    text: 'Universitas Sumatera Utara'
	    	},
	        xAxis: {
	            categories: <?php echo json_encode($semester)?>
	        },
	        yAxis: {
	            title: {
	                text: 'IP Semester'
	            },
	            min: 0,
	            max: 4
	            
	        },
	       	colors: ['#2196F3'],
	        series: [
				{
		            name: 'IP Semester',
		            data: <?php echo json_encode($series)?>
	        	}
	        ],
	        tooltip: {
	            formatter: function() {
	            	return '<b>'+ this.point.semester+'</b><br/>'+
	            		'IP Semester: <b>'+ this.y +'</b><br/>'+
						'Jlh. SKS: <b>'+this.point.sks + '</b>';
	            }
	       	},
	       	legend: {
				enabled: false
	       	},
	        plotOptions: {
	            series: {
	                cursor: 'pointer',
	                marker: {
	                    lineWidth: 1
	                }
	            }
	        },
	    });
	});
	
	</script>
<?php 
	}
?>