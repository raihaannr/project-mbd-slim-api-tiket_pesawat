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

    // get tabel pemesanan
    $app->get('/pemesanan', function(Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL GetPemesanan()');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

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

    // get tabel pesawat
    $app->get('/pesawat', function(Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL GetPesawat()');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });
};
