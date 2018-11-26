<?php

namespace FGC\MenuBundle\Util;

use FGC\MenuBundle\Annotation\Menu;
use Doctrine\Common\Annotations\Reader;
use FGC\MenuBundle\Event\DiscoverMenuEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

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
     */
    public function getMenus()
    {
        if (!$this->fetched) {
            $this->discoverMenus();
        }

        return $this->menus;
    }

	/**
	 * Gathers Annotation information for menus

	 * @throws \ReflectionException
	 */
    private function discoverMenus()
    {
        // Event Dispatch (Add dynamic Menu Items)
	    $event = new DiscoverMenuEvent();
        $new_items = $this->dispatcher->dispatch(DiscoverMenuEvent::NAME, $event)->getItems();
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
            usort($group, function ($a, $b) {return $a->getOrder()<=$b->getOrder()?-1:1;});
        }

        $this->fetched = true;
    }
}
