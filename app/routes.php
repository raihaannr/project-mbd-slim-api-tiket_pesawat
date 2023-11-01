<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    // get tabel kelas
    $app->get('/kelas', function(Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL GetKelas()');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });

    //get tabel kelas by id
    $app->get('/kelas/{idkelas}', function(Request $request, Response $response, $args){
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL GetKelasById(?)');
        $query->execute([$args['idkelas']]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results[0]));

        return $response->withHeader("Content-Type", "application/json");
    });

    // get tabel pemesanan
    $app->get('/pemesanan', function(Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL GetPemesanan()');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });

    //get tabel pemesanan by id
    $app->get('/pemesanan/{idpemesanan}', function(Request $request, Response $response, $args){
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL GetPemesananById(?)');
        $query->execute([$args['idpemesanan']]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results[0]));

        return $response->withHeader("Content-Type", "application/json");
    });

    // get tabel penumpang
    $app->get('/penumpang', function(Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL GetPenumpang()');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });

    //get tabel penumpang by id
    $app->get('/penumpang/{idpenumpang}', function(Request $request, Response $response, $args){
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL GetPenumpangById(?)');
        $query->execute([$args['idpenumpang']]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results[0]));

        return $response->withHeader("Content-Type", "application/json");
    });

    // get tabel pesawat
    $app->get('/pesawat', function(Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL GetPesawat()');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });

    //get tabel pesawat by id
    $app->get('/pesawat/{idpenerbangan}', function(Request $request, Response $response, $args){
        $db = $this->get(PDO::class);

        $query = $db->prepare('CALL GetPesawatById(?);');
        $query->execute([$args['idpenerbangan']]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results[0]));

        return $response->withHeader("Content-Type", "application/json");
    });

    //post data tabel kelas
    $app->post('/kelas', function(Request $request, Response $response) {
        $parsedBody = $request->getParsedBody();

        $jeniskelas = $parsedBody["jeniskelas"];

        $db = $this->get(PDO::class);
        $query = $db->prepare('CALL CreateKelas(?)');
        $query->execute([$jeniskelas]);

        $lastId = $db->lastInsertId();

        $response->getBody()->write(json_encode(
            [
                'message' => 'country disimpan dengan id ' .$lastId 
            ]
            ));

        return $response->withHeader("Content-Type", "application/json");
    });

    //post data tabel pemesanan
    $app->post('/create_pemesanan', function (Request $request, Response $response) {
        $parsedBody = $request->getParsedBody();
        $idpemesanan = $parsedBody["idpemesanan"];
        $notiket = $parsedBody["notiket"];
        $tglpesan = $parsedBody["tglpesan"];
        $harga = $parsedBody["harga"];
        $idpenumpang = $parsedBody["idpenumpang"];
        $idpenerbangan = $parsedBody["idpenerbangan"];
        $status = $parsedBody["status"];
    
        $db = $this->get(PDO::class);
        $query = $db->prepare('INSERT INTO pemesanan (idpemesanan, notiket, tglpesan, harga, idpenumpang, idpenerbangan, status) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $query->execute([$idpemesanan, $notiket, $tglpesan, $harga, $idpenumpang, $idpenerbangan, $status]);
    
        $lastId = $db->lastInsertId();
    
        $response->getBody()->write(json_encode(
            [
                'message' => 'Pemesanan disimpan dengan id ' . $lastId,
            ]
        ));
    
        return $response->withHeader("Content-Type", "application/json");
    });
    
    //post data tabel penumpang
    $app->post('/create_penumpang', function (Request $request, Response $response) {
        $parsedBody = $request->getParsedBody();
        $idpenumpang = $parsedBody["idpenumpang"];
        $nama_penumpang = $parsedBody["nama_penumpang"];
        $alamat = $parsedBody["alamat"];
        $no_telephone = $parsedBody["no_telephone"];
    
        $db = $this->get(PDO::class);
        $query = $db->prepare('INSERT INTO penumpang (idpenumpang, nama_penumpang, alamat, no_telephone) VALUES (?, ?, ?, ?)');
        $query->execute([$idpenumpang, $nama_penumpang, $alamat, $no_telephone]);
    
        $lastId = $db->lastInsertId();
    
        $response->getBody()->write(json_encode(
            [
                'message' => 'Penumpang disimpan dengan id ' . $lastId,
            ]
        ));
    
        return $response->withHeader("Content-Type", "application/json");
    });
    
    //post data tabel pesawat
    $app->post('/create_penumpang', function (Request $request, Response $response) {
        $parsedBody = $request->getParsedBody();
        $idpenumpang = $parsedBody["idpenumpang"];
        $nama_penumpang = $parsedBody["nama_penumpang"];
        $alamat = $parsedBody["alamat"];
        $no_telephone = $parsedBody["no_telephone"];
    
        $db = $this->get(PDO::class);
        $query = $db->prepare('INSERT INTO penumpang (idpenumpang, nama_penumpang, alamat, no_telephone) VALUES (?, ?, ?, ?)');
        $query->execute([$idpenumpang, $nama_penumpang, $alamat, $no_telephone]);
    
        $lastId = $db->lastInsertId();
    
        $response->getBody()->write(json_encode(
            [
                'message' => 'Penumpang disimpan dengan id ' . $lastId,
            ]
        ));
    
        return $response->withHeader("Content-Type", "application/json");
    });
    
    // put data tabel kelas
    $app->put('/kelas/{id}', function (Request $request, Response $response, $args) {
        $parsedBody = $request->getParsedBody();
        $currentId = $args['id'];
        $jeniskelas = $parsedBody["jeniskelas"];
    
        $db = $this->get(PDO::class);
        $query = $db->prepare('CALL UpdateKelas(?, ?)');
        $query->execute([$currentId, $jeniskelas]);
    
        $response->getBody()->write(json_encode(
            [
                'message' => 'Kelas dengan id ' . $currentId . ' telah diupdate dengan jenis kelas ' . $jeniskelas,
            ]
        ));
    
        return $response->withHeader("Content-Type", "application/json");
    });

    // put data tabel pemesanan
    $app->put('/pemesanan/{id}', function (Request $request, Response $response, $args) {
        $parsedBody = $request->getParsedBody();
        $currentId = $args['id'];
        $notiket = $parsedBody["notiket"];
        $tglpesan = $parsedBody["tglpesan"];
        $harga = $parsedBody["harga"];
        $idpenumpang = $parsedBody["idpenumpang"];
        $idpenerbangan = $parsedBody["idpenerbangan"];
        $status = $parsedBody["status"];
    
        $db = $this->get(PDO::class);
        $query = $db->prepare('CALL UpdatePemesanan(?, ?, ?, ?, ?, ?, ?)');
        $query->execute([$currentId, $notiket, $tglpesan, $harga, $idpenumpang, $idpenerbangan, $status]);
    
        $response->getBody()->write(json_encode(
            [
                'message' => 'Pemesanan dengan id ' . $currentId . ' telah diupdate dengan data yang baru',
            ]
        ));
    
        return $response->withHeader("Content-Type", "application/json");
    });
    
    // put data tabel penumpang
    $app->put('/penumpang/{id}', function (Request $request, Response $response, $args) {
        $parsedBody = $request->getParsedBody();
        $currentId = $args['id'];
        $nama_penumpang = $parsedBody["nama_penumpang"];
        $alamat = $parsedBody["alamat"];
        $no_telephone = $parsedBody["no_telephone"];
    
        $db = $this->get(PDO::class);
        $query = $db->prepare('CALL UpdatePenumpang(?, ?, ?, ?)');
        $query->execute([$currentId, $nama_penumpang, $alamat, $no_telephone]);
    
        $response->getBody()->write(json_encode(
            [
                'message' => 'Penumpang dengan id ' . $currentId . ' telah diupdate dengan data yang baru',
            ]
        ));
    
        return $response->withHeader("Content-Type", "application/json");
    });
    
    // put data tabel pesawat
    $app->put('/pesawat/{id}', function (Request $request, Response $response, $args) {
        $parsedBody = $request->getParsedBody();
        $currentId = $args['id'];
        $namapesawat = $parsedBody["namapesawat"];
        $keberangkatan = $parsedBody["keberangkatan"];
        $tujuan = $parsedBody["tujuan"];
        $tglberangkat = $parsedBody["tglberangkat"];
        $jamberangkat = $parsedBody["jamberangkat"];
        $jamtiba = $parsedBody["jamtiba"];
        $idkelas = $parsedBody["idkelas"];
        $kursi_tersedia = $parsedBody["kursi_tersedia"];
    
        $db = $this->get(PDO::class);
        $query = $db->prepare('CALL UpdatePesawat(?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $query->execute([$currentId, $namapesawat, $keberangkatan, $tujuan, $tglberangkat, $jamberangkat, $jamtiba, $idkelas, $kursi_tersedia]);
    
        $response->getBody()->write(json_encode(
            [
                'message' => 'Pesawat dengan id ' . $currentId . ' telah diupdate dengan data yang baru',
            ]
        ));
    
        return $response->withHeader("Content-Type", "application/json");
    });    

    //Delete kelas
    $app->delete('/kelas/{id}', function(Request $request, Response $response, $args) {
        $currentId = $args["id"];
        $db = $this->get(PDO::class);
    
        $query = $db->prepare('CALL DeleteKelas(?)');
        $query->execute([$currentId]);
    
        $response->getBody()->write(json_encode(
            [
                'message' => 'Kelas dengan id ' . $currentId . ' dihapus dari database'
            ]
        ));
    
        return $response->withHeader("Content-Type", "application/json");
    });
    
    //Delete kelas tabel pemesanan
    $app->delete('/pemesanan/{id}', function (Request $request, Response $response, $args) {
        $currentId = $args["id"];
        $db = $this->get(PDO::class);
        $query = $db->prepare('CALL DeletePemesanan(?)');
        $query->execute([$currentId]);
    
        $response->getBody()->write(json_encode(
            [
                'message' => 'Pemesanan dengan id ' . $currentId . ' telah dihapus dari database',
            ]
        ));
    
        return $response->withHeader("Content-Type", "application/json");
    });
    
    //Delete kelas tabel penumpang
    $app->delete('/penumpang/{id}', function (Request $request, Response $response, $args) {
        $currentId = $args["id"];
        $db = $this->get(PDO::class);
        $query = $db->prepare('CALL DeletePenumpang(?)');
        $query->execute([$currentId]);
    
        $response->getBody()->write(json_encode(
            [
                'message' => 'Penumpang dengan id ' . $currentId . ' telah dihapus dari database',
            ]
        ));
    
        return $response->withHeader("Content-Type", "application/json");
    });
    
    //Delete kelas pesawat
    $app->delete('/pesawat/{id}', function (Request $request, Response $response, $args) {
        $currentId = $args["id"];
        $db = $this->get(PDO::class);
        $query = $db->prepare('CALL DeletePesawat(?)');
        $query->execute([$currentId]);
    
        $response->getBody()->write(json_encode(
            [
                'message' => 'Pesawat dengan id ' . $currentId . ' telah dihapus dari database',
            ]
        ));
    
        return $response->withHeader("Content-Type", "application/json");
    });    
    
};
