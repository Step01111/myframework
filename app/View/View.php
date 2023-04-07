<?php
namespace App\View;

class View
{
    private $templatesPath;
    private $extraVars = [];

    public function __construct ()
    {
        $this->templatesPath = $_SERVER['DOCUMENT_ROOT'] . '/app/templates/';
    }
    
    public function setVar (string $name, $value)
    {
        $this->extraVars[$name] = $value;
    }
    
    public function renderHTML (string $template_name, $vars = [])
    {
        extract($this->extraVars);
        extract ($vars);

        ob_start();
        require $this->templatesPath . $template_name;
        $buffer = ob_get_contents();
        ob_end_clean();

        echo $buffer;
     }
}
