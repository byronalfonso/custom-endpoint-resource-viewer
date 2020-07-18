<?php

declare(strict_types=1);

namespace Includes\Services\Admin;

use Includes\Config;
use Includes\Interfaces\PageInterface;
use Includes\Interfaces\PluginServiceInterface;

class MenuPageService implements PluginServiceInterface
{
    private static $addedMenuPages = [];
    private $pages = [];

    public function initialize()
    {
        $this->setPages();
        add_action('admin_menu', [$this, 'registerMenuPages']);
    }

    /**
     * Gets all the the classnames for all added pages
     * @return array self::$addedMenuPages
     */
    public static function addedMenuPages(): array
    {
        return self::$addedMenuPages;
    }
    
    /**
     * Registers all menu items along with their associated pages
     *
     * @return void
     */
    public function registerMenuPages()
    {
        foreach ($this->getPages() as $class) {
            // Add the page only if it hasn't been added yet
            if (in_array($class, self::$addedMenuPages, true)) {
                continue;
            }

            // Throw an error if the page is not an instance of PageInterface
            if (!is_subclass_of($class, 'Includes\Interfaces\PageInterface')) {
                throw new \Exception("Invalid page initialization. " . $class . " must be an instance of the PageInterface.");
            }

            $page = new $class();
            $this->initializePage($page);
            $this->addMenuPage($page->options());
            array_push(self::$addedMenuPages, $class);
        }
    }

    private function setPages()
    {

        $this->pages = [
            \Includes\Pages\Settings::class,
        ];
    }

    private function getPages(): array
    {

        return $this->pages;
    }

    private function initializePage(PageInterface $page)
    {

        $page->initPage();
    }

    private function addMenuPage(array $pageOptions)
    {

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
