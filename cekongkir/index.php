<?php
require "connection.php";
require "functions.php";

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
		<style>
			h2{
				margin-top:20px;
			}
			#view-ongkir{
				max-height:500px;
				overflow-x:hidden;
				overflow-y:auto;
				border:1px;
			}
		</style>
	</head>
	<body>
		<div class="container-fluid">
			<h2 align="center">Cek Ongkir</h2>

			<div class="row">
				
				<div class="col-md-8 order-md-1">
					<form method="post" action="">
						<h4>Kota Asal</h4>
						<div class="row">
							<div class="col-md-4 mb-3">
								<label for="prov-asal">Provinsi</label>
								<select class="form-control" id="prov-asal" required>
									<option>Pilih Provinsi</option>
<?php
$sql_prov1 = "SELECT * FROM kht_province ORDER BY province_id";
$r_prov1 = $conn->query($sql_prov1);
if ($r_prov1->num_rows > 0) {
	while($row_prov1 = $r_prov1->fetch_assoc()) {
?>
									<option value="<?php echo $row_prov1['province_id']; ?>"><?php echo $row_prov1['province']; ?></option>
<?php
	}
}
?>
								</select>
							</div>
							<div class="col-md-4 mb-3">
								<label for="kab-asal">Kabupaten</label>
								<select class="form-control" id="kab-asal" required>
									<option>Pilih Kabupaten</option>
								</select>
							</div>
							<div class="col-md-4 mb-3">
								<label for="kec-asal">Kecamatan</label>
								<select class="form-control" id="kec-asal" required>
									<option>Pilih Kecamatan</option>
								</select>
							</div>
						</div>
						
						<h4>Kota Tujuan</h4>
						<div class="row">
							<div class="col-md-4 mb-3">
								<label for="prov-tujuan">Provinsi</label>
								<select class="form-control" id="prov-tujuan" required>
									<option>Pilih Provinsi</option>
<?php
$sql_prov2 = "SELECT * FROM kht_province ORDER BY province_id";
$r_prov2 = $conn->query($sql_prov1);
if ($r_prov2->num_rows > 0) {
	while($row_prov2 = $r_prov2->fetch_assoc()) {
?>
									<option value="<?php echo $row_prov2['province_id']; ?>"><?php echo $row_prov2['province']; ?></option>
<?php
	}
}
?>
								</select>
							</div>
							<div class="col-md-4 mb-3">
								<label for="kab-tujuan">Kabupaten</label>
								<select class="form-control" id="kab-tujuan" required>
									<option>Pilih Kabupaten</option>
								</select>
							</div>
							<div class="col-md-4 mb-3">
								<label for="kec-tujuan">Kecamatan</label>
								<select class="form-control" id="kec-tujuan" required>
									<option>Pilih Kecamatan</option>
								</select>
							</div>
						</div>

						<div class="mb-3">
							<label for="berat">Berat (gram)</label>
							<input type="number" class="form-control" id="berat" name="berat" placeholder="Berat Barang" value="" required />
						</div>

						<div class="mb-3">
							<label for="courier">Kurir</label>
							<select class="custom-select d-block w-100" id="courier" name="courier" required>
								<option value="semua">Semua</option>
								
<?php
$sql_kurir = "SELECT * FROM kht_kurir ORDER BY id";
$r_kurir = $conn->query($sql_kurir);
if ($r_kurir->num_rows > 0) {
	while($row_kurir = $r_kurir->fetch_assoc()) {
?>
								<option value="<?php echo $row_kurir['kode_kurir']; ?>"><?php echo $row_kurir['nama_kurir']; ?></option>
<?php
	}
}
?>
							</select>
						</div>
						
						<hr class="mb-4">
						<button class="btn btn-primary btn-lg btn-block" type="button" onClick="cekongkir();">Cek Ongkir</button>
					</form>
				</div>
				
				<div class="col-md-4 order-md-2 mb-4">
					<hr class="mb-4">
					<div id="view-ongkir"></div>
				</div>
			</div>
		</div>
	
		<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script>
			$(function() {
				$("#prov-asal").change(function() {
					var prov = $("#prov-asal").val();
					$.ajax({
						url:"get_address.php",
						data:"type=province&id="+prov,
						cache:false,
						success:function(msg) {
							$("#kab-asal").html(msg);
						}
					});
				});
				
				$("#kab-asal").change(function() {
					var kab = $("#kab-asal").val();
					$.ajax({
						url:"get_address.php",
						data:"type=kabupaten&id="+kab,
						cache:false,
						success:function(msg) {
							$("#kec-asal").html(msg);
						}
					});
				});
				
				$("#prov-tujuan").change(function() {
					var prov = $("#prov-tujuan").val();
					$.ajax({
						url:"get_address.php",
						data:"type=province&id="+prov,
						cache:false,
						success:function(msg) {
							$("#kab-tujuan").html(msg);
						}
					});
				});
				
				$("#kab-tujuan").change(function() {
					var kab = $("#kab-tujuan").val();
					$.ajax({
						url:"get_address.php",
						data:"type=kabupaten&id="+kab,
						cache:false,
						success:function(msg) {
							$("#kec-tujuan").html(msg);
						}
					});
				});
			});
			
			function cekongkir() {
				var asal = $("#kec-asal").val();
				var tujuan = $("#kec-tujuan").val();
				var berat = $("#berat").val();
				var kurir = $("#courier").val();
				
				if (asal == "Pilih Kecamatan") {
					alert("Silahkan pilih kecamatan asal");
					$("#kec-asal").focus();
				} else if (tujuan == "Pilih Kecamatan") {
					alert("Silahkan pilih kecamatan tujuan");
					$("#kec-tujuan").focus();
				} else if (berat == 0) {
					alert("Silahkan isi berat barang");
					$("#berat").focus();
				} else {
					$("#view-ongkir").html('<div align="center"><img src="progress.gif" /></div>');
					$.ajax({
						url:"get_ongkir.php",
						data:"src="+asal+"&dst="+tujuan+"&berat="+berat+"&kurir="+kurir,
						cache:false,
						success:function(msg) {
							$("#view-ongkir").html(msg);
						}
					});
				}
			}
		</script>
	</body>
</html>