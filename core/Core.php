<?php

namespace Core;

use Core\Exceptions\MethodNotExists;
use Core\Exceptions\RouteNotFound;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Tools\Setup;

class Core
{

    protected $orm;


    public function bootstrap()
    {
        $paths = array('./src/Models');
        $isDevMode = true;

        // the connection configuration
        $dbParams = array(
            'driver'   => 'pdo_pgsql',
            'user'     => 'postgres',
            'password' => 'postgres',
            'dbname'   => 'sansaraci',
        );

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $entityManager = EntityManager::create($dbParams, $config);

        $this->setOrm($entityManager);
    }


    public function setOrm(EntityManager $entityManager)
    {
        $this->orm = $entityManager;
    }


    public function getOrm(): EntityManager
    {
        return $this->orm;
    }


    public function run()
    {
        $request = Request::createFromGlobals();
        try {
            $response = Router::factory()->dispatch($request);
        } catch (MethodNotExists $ex) {
            $data = json_encode([
                'ok' => false,
                'error' => 'Method not exists'
            ]);
            Response::create($data, 404)->send();
            return;
        } catch (RouteNotFound $ex) {
            $data = json_encode([
                'ok' => false,
                'error' => 'Method not exists'
            ]);
            Response::create($data, 404)->send();
            return;
        }

        $response->send();
    }
}
