<?php
require "connection.php";

if (isset($_GET['type'])) {
	if (isset($_GET['id'])) {
		
		$type = $_GET['type'];
		$id = $_GET['id'];
		
		if ($type == "province") {
			$tablename = "kht_kabupaten";
			$where = "province_id = '".$id."'";
			$order = "city_name";
			$pilih = "Pilih Kabupaten";
		} elseif ($type == "kabupaten") {
			$tablename = "kht_kecamatan";
			$where = "city_id = '".$id."'";
			$order = "subdistrict_name";
			$pilih = "Pilih Kecamatan";
		} else {
			$error = "Data Not Found";
		}
		
		if (isset($error)) {
			echo '<option>'.$error.'</option>';
		} else {
			$sql = "SELECT * FROM ".$tablename." WHERE ".$where." ORDER BY ".$order;
			$r_sql = $conn->query($sql);
			
			echo '<option>'.$pilih.'</option>';
			
			if ($r_sql->num_rows > 0) {
				while($row_sql = $r_sql->fetch_row()) {
					if ($type == "province") {
						if ($row_sql[3] == "Kabupaten") {
							$show_type = "Kab. ";
						} else {
							$show_type = "Kota ";
						}
						
						$show_name = $show_type.$row_sql[4];
					} else {
						$show_name = $row_sql[6];
					}
					
					echo '<option value="'.$row_sql[0].'">'.$show_name.'</option>';
				}
			}
		}
	} else {
		echo '<option>Data Not Found</option>';
	}
} else {
	echo '<option>Data Not Found</option>';
}