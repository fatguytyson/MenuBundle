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
use FGC\MenuBundle\Event\DiscoverMenuEvent;
use ReflectionException;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class MenuDiscovery
{
    private $menus = [];

    private $fetched;

    private $dispatcher;

    /**
     * MenuDiscovery constructor.
     * @param array                    $options
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct($options, EventDispatcherInterface $dispatcher)
    {
        $this->fetched = false;
        $this->dispatcher = $dispatcher;

        foreach ($options as $group => $items) {
            foreach ($items as $name => $values) {
                $values['name']  = $name;
                $values['group'] = $group;
                $item = new Menu($values);
                if (!isset($this->menus[$group])) {
                    $this->menus[$group] = [];
                }
	            $this->menus[$group][] = $item;
            }
        }
    }

    /**
     * Returns all menus
     *
     * @return array
     * @throws ReflectionException
     */
    public function getMenus(): array
    {
        if (!$this->fetched) {
            $this->discoverMenus();
        }

        return $this->menus;
    }

	/**
	 * Gathers Annotation information for menus

	 * @throws ReflectionException
	 */
    private function discoverMenus(): void
    {
        // Event Dispatch (Add dynamic Menu Items)
        $new_items = $this->dispatcher->dispatch(new DiscoverMenuEvent())->getItems();
        if ($new_items) {
        	foreach($new_items as $item) {
        		if ($item instanceof Menu) {
			        if (!isset($this->menus[$item->getGroup()])) {
				        $this->menus[$item->getGroup()] = [];
			        }
			        $this->menus[$item->getGroup()][] = $item;
		        }
	        }
        }

        foreach ($this->menus as &$group) {
        	/** $a, $b Menu  */
            usort($group, function (Menu $a, Menu $b) {return $a->getOrder()<=$b->getOrder()?-1:1;});
        }

        $this->fetched = true;
    }
}
