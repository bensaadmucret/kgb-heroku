<?php declare(strict_types=1);

namespace Core\Router;

use Symfony\Component\HttpFoundation\Request;

class Route
{
    public $callable;
    public array $matches = [];
    private array $params = [];
    public string $method;
    public string $name;

    public function __construct(string $method, string $path, $callable, string $name = null)
    {
        $this->method = $method;
        $this->path = trim($path, '/');
        $this->callable = $callable;
        $this->name = $name;
    }

     

    public function match($url)
    {
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
       
        $this->matches = $matches;
        
        return true;
    }

    public function call()
    {
        if (is_string($this->callable)) {
            $params = explode('@', $this->callable);
            $controller = router::getNameSpace() . $this->getController();           
            $action = $params[1];  
            $controller = new $controller();    
               
                
          
            call_user_func_array([ $controller, $action], $this->matches);
        } else {
            call_user_func_array($this->callable, $this->matches);
        }
    }

    private function getController()
    {
        if (is_string($this->callable)) {
            $params = explode('@', $this->callable);
            return $params[0];
        }
    }
}
