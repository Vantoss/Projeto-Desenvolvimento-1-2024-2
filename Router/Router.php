<?php class Router{
    protected $routes = [];
    
    protected function abort($code = 404){
        require ROOT_DIR. "pages/{$code}.php";
        die();
    }

public function add( $method, $uri, $controller){
    $this->routes[] = [
        'uri' => $uri,
        'controller' => $controller,
        'method' => $method
    ];
}
public function get($uri, $controller)
{
    $this->add('GET',$uri, $controller);
    
    
}
public function post($uri, $controller)
{
    $this->add('POST',$uri, $controller);
    
}
public function delete($uri, $controller)
{
    
    $this->add('DELETE',$uri, $controller);


}
public function put($uri, $controller)
{

    $this->add('PUT',$uri, $controller);

}
public function patch($uri, $controller)
{

    $this->add('PATCH',$uri, $controller);
}


public function route($uri, $method)
{
    foreach ($this->routes as $route) {
        if($route["uri"] == $uri && $route["method"] == $method){
            
            require ROOT_DIR. $route["controller"];

        } 
    }
}

}