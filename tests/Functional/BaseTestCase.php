<?php

namespace Tests\Functional;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;

/**
 * This is an example class that shows how you could set up a method that
 * runs the application. Note that it doesn't cover all use-cases and is
 * tuned to the specifics of this skeleton app, so if your needs are
 * different, you'll need to change it.
 */
class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    protected $db;

    public function setUp()
    {
        parent::setUp();
        if (empty($this->db)) {
            $this->db = $this->getDatabase();
        }
    }

    /**
     * Use middleware when running application?
     *
     * @var bool
     */
    protected $withMiddleware = false;

    /**
     * Process the application given a request method and URI
     *
     * @param string $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string $requestUri the request URI
     * @param array|object|null $requestData the request data
     * @return \Slim\Http\Response
     */
    public function runApp($requestMethod, $requestUri, $requestData = null)
    {
        // Create a mock environment for testing with
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
        );

        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);

        // Add request data, if it exists
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        // Set up a response object
        $response = new Response();

        // Use the application settings
        $settings = require __DIR__ . '/../../src/settings.php';

        // Instantiate the application
        $app = new App($settings);

        // Set up dependencies
        require __DIR__ . '/../../src/dependencies.php';

        // Register middleware
        if ($this->withMiddleware) {
            require __DIR__ . '/../../src/middleware.php';
        }

        // Register routes
        require __DIR__ . '/../../src/routes.php';

        // Process the application
        $response = $app->process($request, $response);

        // Return the response
        return $response;
    }

    protected function truncateTable($table)
    {
        $this->db->query("TRUNCATE TABLE `$table`")->execute();
    }

    protected function seeInDatabase($table, $pairs)
    {
        $result = $this->recordExists($table, $pairs);
        $this->assertTrue($result);
    }

    protected function notSeeInDatabase($table, $pairs)
    {
        $result = $this->recordExists($table, $pairs);
        $this->assertNotTrue($result);
    }

    private function recordExists($table, $pairs)
    {
        $stmt = $this->db->select()->from($table);
        foreach ($pairs as $key => $value) {
            $stmt->where($key, '=', $value);
        }
        $result = $stmt->execute()->fetch();
        return $result !== false;
    }

    private function getDatabase()
    {
        $dsn = 'mysql:host=' . getenv('DB_HOST');
        $dsn .= ';port=' . getenv('DB_PORT');
        $dsn .= ';dbname=' . getenv('DB_NAME') . ';charset=utf8';
        $dsn .= ';charset=utf8';

        $pdo = new \Slim\PDO\Database($dsn, getenv('DB_USER'), getenv('DB_PASS'));
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        return $pdo;
    }

}
