<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace FGC\MenuBundle\Util;

use FGC\MenuBundle\Entity\Menu;

class MenuManager
{
    /**
     * @var MenuDiscovery
     */
    private $menuDiscovery;
    /**
     * @var array
     */
    private $menus;

    /**
     * MenuManager constructor.
     * @param MenuDiscovery $menuDiscovery
     */
    public function __construct(MenuDiscovery $menuDiscovery)
    {
        $this->menuDiscovery = $menuDiscovery;
    }

    /**
     * Return all menus
     *
     * @return Menu[][]
     */
    public function getMenus(): array
    {
        $this->loadMenus();
        return $this->menus;
    }

    /**
     * Get specific menu
     *
     * @param string $name
     * @return Menu[]
     */
    public function getMenu(string $name): array
    {
        if ($this->isMenu($name)) {
            return $this->menus[$name];
        }
        return [];
    }

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
    public function isMenu(string $name): bool
    {
        $this->loadMenus();
	    return isset($this->menus[$name]);
    }

    /**
     * Makes sure menus are loaded
     */
    private function loadMenus(): void
    {
        if (!$this->menus) {
            $this->menus = $this->menuDiscovery->getMenus();
        }
    }
}
