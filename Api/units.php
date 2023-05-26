<?php 
require_once '../config/db.php';
$db = new db();
$table = "units";
$id = "id";
$data_insert = ["id_kantor","name"];
$data_edit = ["id_kantor","name","updated_at"];

session_start();


//http://localhost/phpCrud/Api/units.php?all
if (isset($_GET['all'])) {
	$res = $db->manual_query("select * from {$table}");
	if ($res !== null) {
		$response = array(
			"status" => 200,
			"message" =>"sukses",
			"data" => $res
		);
		echo json_encode($response);
	}else{
		echo json_encode($response = array(
			"status" => 500,
			"message" =>"error",
		));
	}
}


//http://localhost/phpCrud/Api/units.php?id=1
if (isset($_GET['id'])) {
	$res = $db->manual_query("select * from $table where $id = ".$_GET['id']);
	if ($res !== null) {
		echo json_encode($res);
	}else{
		echo json_encode("gagal");
	}
}


//http://localhost/phpCrud/Api/units.php?insert=&id_kantor=2&name=lll
if(isset($_GET['insert'])){
	$data  = array(); 
    $err ="";
    foreach($data_insert as $col){
        if(isset($_GET[$col]) && $_GET[$col] != "") $data[$col] = $_GET[$col];
        else $err .= "Kolom $col belum terisi !!! \n";
    }
    
    if($err !="" ) {
        echo json_encode($response = array(
            "status" => 500,
            "message" =>$err,
        ));
        exit();
    }

	$res = $db->insert($table,$data);
	if ($res == "sukses") {
		echo json_encode($response = array(
			"status" => 200,
			"message" =>"sukses insert",
		));
	}else{
		echo json_encode($response = array(
			"status" => 500,
			"message" =>$res,
		));
	}
}


// http://localhost/phpCrud/Api/units.php?edit=9&id_kantor=3&name=99
if(isset($_GET['edit'])){
	$data  = array(); 
    $err ="";
    foreach($data_insert as $col){
        if(isset($_GET[$col]) && $_GET[$col] != "") $data[$col] = $_GET[$col];
    }
    
    if($err !="" ) {
        echo json_encode($response = array(
            "status" => 500,
            "message" =>$err,
        ));
        exit();
    }

	$res = $db->bulk_edit($table,$data,$id,$_GET['edit']);
	if($res > 0){
        echo json_encode($response = array(
			"status" => 200,
			"message" =>"sukses mengubah $res data.",
		));
    }else{
        echo json_encode($response = array(
			"status" => 500,
			"message" =>"data tidak di temukan.",
		));
    }
}


// http://localhost/phpCrud/Api/units.php?delete=8
if (isset($_GET['delete'])) {
	# code...
	$res = $db->delete($table,$id,$_GET['delete']);
    if($res > 0){
        echo json_encode($response = array(
			"status" => 200,
			"message" =>"sukses menghapus $res data.",
		));
    }else{
        echo json_encode($response = array(
			"status" => 500,
			"message" =>"data tidak di temukan.",
		));
    }
}

?>