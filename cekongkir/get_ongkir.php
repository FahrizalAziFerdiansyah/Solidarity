<?php
require "connection.php";
require "functions.php";

if (isset($_GET['src']) && !empty($_GET['src'])) {
	if (isset($_GET['dst']) && !empty($_GET['dst'])) {
		if (isset($_GET['berat']) && !empty($_GET['berat'])) {
			if (isset($_GET['kurir']) && !empty($_GET['kurir'])) {
				$src = $_GET['src'];
				$dst = $_GET['dst'];
				$berat = $_GET['berat'];
				$kurir = $_GET['kurir'];
				
				$api = 'api-raja-ongkir'; //Isi dengan api dari rajaongkir
				
				echo '<ul class="list-group mb-3">';
				
				if ($kurir == 'semua') {
					$sql_kurir = "SELECT * FROM kht_kurir ORDER BY id";
					$r_kurir = $conn->query($sql_kurir);
					while($row_kurir = $r_kurir->fetch_assoc()) {
						$kurir = $row_kurir['kode_kurir'];
						
						if ($kurir == 'pos') {
							$show_etd = '';
						} else {
							$show_etd = ' Hari';
						}
						
						$ongkir = getOngkir($src,$dst,$kurir,$berat,$api);
						$data = json_decode($ongkir, TRUE);
						
						if (isset($data['rajaongkir']['results'])) {
							for($i=0; $i < count($data['rajaongkir']['results']); $i++) {
								for($j=0; $j < count($data['rajaongkir']['results'][$i]['costs']); $j++) {
									$kurir_code = $data['rajaongkir']['results'][$i]['code'];
									$kurir_name = $data['rajaongkir']['results'][$i]['name'];
									$kurir_service = $data['rajaongkir']['results'][$i]['costs'][$j]['service'];
									$kurir_desk = $data['rajaongkir']['results'][$i]['costs'][$j]['description'];
									$kurir_etd = $data['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['etd'].$show_etd;
									$kurir_tarif = $data['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['value'];
									
									if ($kurir_tarif != 0) {
										echo '<li class="list-group-item d-flex justify-content-between lh-condensed">
												<div>
													<h6 class="my-0">'.$kurir_name.'</h6>
													<small class="text-muted">'.$kurir_service.' - '.$kurir_desk.'</small><br />
													<small class="text-muted">'.$kurir_etd.'</small>
												</div>
												<span class="text-muted">'.str_replace(",",".",number_format($kurir_tarif)).'</span>
											</li>';
									}
								}
							}
						}
					}
				} else {
					$ongkir = getOngkir($src,$dst,$kurir,$berat,$api);
					$data = json_decode($ongkir, TRUE);
					
					if ($kurir == 'pos') {
						$show_etd = '';
					} else {
						$show_etd = ' Hari';
					}
					
					if (isset($data['rajaongkir']['results']) && !empty($data['rajaongkir']['results'])) {
						for($i=0; $i < count($data['rajaongkir']['results']); $i++) {
							for($j=0; $j < count($data['rajaongkir']['results'][$i]['costs']); $j++) {
								$kurir_code = $data['rajaongkir']['results'][$i]['code'];
								$kurir_name = $data['rajaongkir']['results'][$i]['name'];
								$kurir_service = $data['rajaongkir']['results'][$i]['costs'][$j]['service'];
								$kurir_desk = $data['rajaongkir']['results'][$i]['costs'][$j]['description'];
								$kurir_etd = $data['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['etd'].$show_etd;
								$kurir_tarif = $data['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['value'];
								
								if ($kurir_tarif != 0 ) {
									echo '<li class="list-group-item d-flex justify-content-between lh-condensed">
										<div>
											<h6 class="my-0">'.$kurir_name.'</h6>
											<small class="text-muted">'.$kurir_service.' - '.$kurir_desk.'</small><br />
											<small class="text-muted">'.$kurir_etd.'</small>
										</div>
										<span class="text-muted">'.str_replace(",",".",number_format($kurir_tarif)).'</span>
									</li>';
								} else {
									echo '<li class="list-group-item d-flex justify-content-between lh-condensed">
											<div>Data tidak ditemukan</div>
											</li>';
								}
							}
						}
					} else {
						echo '<li class="list-group-item d-flex justify-content-between lh-condensed">
								<div>Data ongkir tidak ditemukan</div>
								</li>';
					}
				}
				
				echo '</ul>';
			} else {
				echo 'Kurir tidak ditemukan';
			}
		} else {
			echo 'Berat harus diisi';
		}
	} else {
		echo 'Kota tujuan tidak ditemukan';
	}
} else {
	echo 'Kota asal tidak ditemukan';
}