<html>
	<head>
		<title>Graph Portal USU</title>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
		
		<style>
			body {
				font-family: 'Open Sans', sans-serif;
			}
		</style>
		<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
		
	</head>
	<body>
		<h1>Graph Portal USU</h1>
		<p><b>By: Charlie</b> (charzone95@gmail.com) </p> 
		
		<?php 
			if (@$_POST) {
				require_once 'process.php';
			}
		?>
		
		<hr/>
		<form action="" method="POST">
			<p>
				<label>Masukkan Login Portal:</label>
				<input type="text" name="user" placeholder="Username" value=""/>
				<input type="password" name="pass" placeholder="Password" value=""/>
				
				<button type=submit">Go</button>
			</p>
		</form>
		
		<p>Aplikasi ini <b>TIDAK</b> menyimpan informasi apapun yang Anda ketikkan di form ini</p>
		
		<hr style="margin-top:20px"/>
		
		<p>Source code available at <a href="https://github.com/charzone95/graph-portal-usu" target="_BLANK">github.com/charzone95/graph-portal-usu</a></p>
	</body>
</html>