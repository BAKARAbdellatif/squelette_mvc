<?php
include __DIR__ . "/../core/Model.php";

class HomeController
{
    protected $request_controller = "user";
    protected $request_action = "index";
    protected $request_data;

    public function __construct()
    {
        $this->splitUrl();
        $this->executeMethod($this->request_controller, $this->request_action);
    }

    private function splitUrl()
    {
        try {
            $url = $_SERVER['REQUEST_URI'];

            if (substr_count($url, '/') > 4) {
                throw new Exception(400, "Bad Request");
            } else {
                // Split the request URL by slashes
                $url_parts = explode("?", $url)[0];
                $url_parts = array_filter(explode("/", $url_parts));
                // Supprime les valeurs vides
                $url_parts = array_filter($url_parts);
                // Réorganise les clés de manière séquentielle à partir de 0
                $url_parts = array_values($url_parts);
                // Assign the controller and action based on the URL parts
                if (isset($url_parts[0])) {
                    $this->request_controller = $url_parts[0];
                }

                if (isset($url_parts[1])) {
                    $this->request_action = $url_parts[1];
                } else {
                    $this->request_action = "index";
                }
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function executeMethod($controller, $action)
    {
        $action = (isset($action)) ? $action : "index";
        $controller = (isset($controller)) ? $controller : "user";
        $class_name = ucfirst($controller) . "Controller";

        $file_path = __DIR__ . "/../Controllers/$class_name.php";
        include_once($file_path);
        $instance = new $class_name();
        // Check if the file exists
        if (file_exists($file_path)) {
            // Include the file and call the method
            if (class_exists($class_name)) {
                try {
                    call_user_func(array($instance, $action));
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                echo "The class does not exist in the file";
            }
        } else {
            echo "The file does not exist";
        }
    }
}
