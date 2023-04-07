<?php
namespace App\Controllers;

use App\View\View;
use App\Models\Category\Category;

abstract class PageController extends AbstractController
{
    protected $view;
    protected $categories;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->view = new View();
        $this->view->setVar('user', $this->user);
    }
}
