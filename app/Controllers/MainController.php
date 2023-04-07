<?php
namespace App\Controllers;

use App\Models\Art;

class MainController extends PageController
{
    public function main()
    {
        $this->view->renderHTML('main/show.php');
    }
}
