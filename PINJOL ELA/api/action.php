<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Content-Type: application/json; charset=UTF-8');

include "db_config.php";
$postjson = json_decode(file_get_contents('php://input'), true);
$aksi = strip_tags($postjson['aksi']);
$data = array();

switch($aksi)
{
    case "add_register":
        $nama       = filter_var($postjson['nama'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
        $nohp       = filter_var($postjson['nohp'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
        $email      = filter_var($postjson['email'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
        $nik      = filter_var($postjson['nik'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
        $usia = filter_var($postjson['usia'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
        $jumlah = filter_var($postjson['jumlah'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
        try {
            $sql = "INSERT INTO pinjam (nama,nohp,email,nik,jumlah,usia) VALUES (:nama, :nohp, :email, :nik, :jumlah, :usia)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
            $stmt->bindParam(':nohp', $nohp, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':nik', $nik, PDO::PARAM_STR);
            $stmt->bindParam(':jumlah', $jumlah, PDO::PARAM_STR);
            $stmt->bindParam(':usia', $usia, PDO::PARAM_STR);
            $stmt->execute();
            if ($sql) {
                $result = json_encode(array('success' => true));
            } else {
                $result = json_encode(array('success' => false, 'msg' => 'error, please try again'));
            }
            echo $result;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    break;
 
    case "getdata":
        $limit = filter_var($postjson['limit'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
        $start = filter_var($postjson['start'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
        try {
            $sql = "SELECT * FROM pinjam ORDER BY `id` DESC LIMIT :start,:limit";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':start', $start, PDO::PARAM_STR);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $data[] = array(
                    'id' => $row['id'],
                    'nama' => $row['nama'],
                    'nohp' => $row['nohp'],
                    'email' => $row['email'],
                    'nik' => $row['nik'],
                    'jumlah' => $row['jumlah'],
                    'usia' => $row['usia']
                    );
            }
        if($stmt) $result = json_encode(array('success'=>true,
            'result'=>$data));
        else $result = json_encode(array('success'=>false));

    echo $result;
        }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
    break;
}