<?php
$request = $_SERVER['REQUEST_URI'];
$request = str_replace('/school_api/index.php/', '', $request);
$request = strtok($request, '?');
$segments = explode('/', $request);

if (count($segments) === 2) {
    $folder_file = $segments[0];
    $function_name = $segments[1];

    $folder_file_parts = explode('.', $folder_file);

    if (count($folder_file_parts) === 2) {
        $folder_name = $folder_file_parts[0];
        $file_name = $folder_file_parts[1];

        $file_path = __DIR__ . "/$folder_name/$file_name.php";

        if (file_exists($file_path)) {
            include_once $file_path;

            $class_name = ucfirst($file_name);

            if (class_exists($class_name)) {
                $class_instance = new $class_name();

                if (method_exists($class_instance, $function_name)) {
                    $reflection = new ReflectionMethod($class_instance, $function_name);
                    $parameters = $reflection->getParameters();

                    if (!empty($parameters)) {
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $json = file_get_contents('php://input');
                            $postData = json_decode($json, true);

                            if (json_last_error() === JSON_ERROR_NONE) {
                                if (isset($postData['params']) && is_array($postData['params'])) {
                                    $args = $postData['params'];
                                    call_user_func_array(array($class_instance, $function_name), $args);
                                } else {
                                    http_response_code(400);
                                    echo "Invalid JSON format. Expected 'params' to be an array.";
                                }
                            } else {
                                http_response_code(400);
                                echo "Invalid JSON data.";
                            }
                        } else {
                            http_response_code(405);
                            echo "Method $function_name expects a POST request with JSON data.";
                        }
                    } else {
                        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                            $class_instance->$function_name();
                        } else {
                            http_response_code(405);
                            echo "Method $function_name expects a GET request.";
                        }
                    }
                } else {
                    http_response_code(404);
                    echo "Method '$function_name' not found in class '$class_name'";
                }
            } else {
                http_response_code(404);
                echo "Class '$class_name' not found in '$file_name.php'";
            }
        } else {
            http_response_code(404);
            echo "File '$file_name.php' not found in folder '$folder_name'";
        }
    } else {
        http_response_code(400);
        echo "Invalid format for folder_name.file_name in URL";
    }
} else {
    http_response_code(400);
    echo "Invalid URL format. Expected /folder_name.file_name/function_name";
}
?>
