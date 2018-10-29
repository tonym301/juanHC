<?php

include_once '../global.php';

// get the identifier for the page we want to load
$action = $_GET['action'];

// instantiate a SiteController and route it
$sc = new SiteController();
$sc->route($action);

class SiteController
{
    // route us to the appropriate class method for this action
    public function route($action)
    {
        switch ($action) {
            case 'home':
                $this->home();
                break;
            case 'about':
                $this->about();
                break;
            case 'support':
                $this->support();
                break;
        }
    }

    public function platform() {
        $pageTitle = 'Platform';
        include_once SYSTEM_PATH . '/view/header.tpl';
        include_once SYSTEM_PATH . '/view/platform.tpl';
        include_once SYSTEM_PATH . '/view/footer.tpl';
    }

    public function about()
    {
        $pageTitle = 'About Me';
        include_once SYSTEM_PATH . '/view/header.tpl';
        include_once SYSTEM_PATH . '/view/about.tpl';
        include_once SYSTEM_PATH . '/view/footer.tpl';
    }

    public function support()
    {
        $pageTitle = 'Support';
        include_once SYSTEM_PATH . '/view/header.tpl';
        include_once SYSTEM_PATH . '/view/support.tpl';
        include_once SYSTEM_PATH . '/view/footer.tpl';
    }


    public function home()
    {
        $pageTitle = 'Home';
        include_once SYSTEM_PATH . '/view/header.tpl';
        include_once SYSTEM_PATH . '/view/index.tpl';
        include_once SYSTEM_PATH . '/view/footer.tpl';
    }
}
