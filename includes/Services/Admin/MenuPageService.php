<?php

declare(strict_types=1);

namespace Includes\Services\Admin;

use Includes\Config;
use Includes\Interfaces\PageInterface;
use Includes\Interfaces\PluginServiceInterface;

class MenuPageService implements PluginServiceInterface
{
    private $pages = [];
    public function initialize()
    {
        $this->setPages();
        add_action('admin_menu', [$this, 'registerMenuPages']);
    }
    
    /**
     * Registers all menu items along with their associated pages
     *
     * @return void
     */
    public function registerMenuPages()
    {
       foreach($this->getPages() as $class){
           $page = new $class();
           $this->initializePage($page);
           $this->addMenuPage($page->getOptions());
       }
    }

    private function setPages(){
        $this->pages = [
            \Includes\Pages\Settings::class
        ];
    }

    private function getPages(){
        return $this->pages;
    }

    private function initializePage(PageInterface $page){
        $page->initPage();
    }

    private function addMenuPage(array $pageOptions){
        add_menu_page(
            $pageOptions['page_title'],
            $pageOptions['menu_title'],
            $pageOptions['capability'],
            $pageOptions['menu_slug'],
            $pageOptions['callback'],
            $pageOptions['icon_url'],
            $pageOptions['position']
        );
    }    
}
