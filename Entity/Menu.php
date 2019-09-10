<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace FGC\MenuBundle\Entity;

use InvalidArgumentException;

/**
 * Class Menu
 *
 * @package FGC\MenuBundle\Entity
 */
class Menu
{
    /**
     * @var string
     *
     * @Annotation\Required()
     */
    private $name;

    /**
     * @var string
     *
     * @Annotation\Required()
     */
    private $route;

    /**
     * @var array
     */
    private $routeOptions;

    /**
     * @var string
     */
    private $icon;

    /**
     * @var integer
     */
    private $order;

    /**
     * @var string
     */
    private $group;

    /**
     * @var string
     */
    private $granted;

    /**
     * @var mixed
     */
    private $grantedObject;

    /**
     * @var string
     */
    private $children;

    /**
     * Menu constructor.
     *
     * @param $options
     */
    public function __construct($options = null)
    {
        if ($options) {
            foreach ($options as $key => $value) {
                if (!property_exists($this, $key)) {
                    throw new InvalidArgumentException(sprintf('Property "%s" does not exist', $key));
                }

                $this->$key = $value;
            }
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Menu
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @param string $route
     *
     * @return Menu
     */
    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @return array
     */
    public function getRouteOptions(): array
    {
        return $this->routeOptions ? $this->routeOptions : [];
    }

    /**
     * @param array $routeOptions
     *
     * @return Menu
     */
    public function setRouteOptions(array $routeOptions): self
    {
        $this->routeOptions = $routeOptions;

        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     *
     * @return Menu
     */
    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return integer
     */
    public function getOrder(): int
    {
        return $this->order ? $this->order : 1000;
    }

    /**
     * @param int $order
     *
     * @return Menu
     */
    public function setOrder(int $order): self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group ? $this->group : 'default';
    }

    /**
     * @param string $group
     *
     * @return Menu
     */
    public function setGroup(string $group): self
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return string
     */
    public function getGranted(): string
    {
        return $this->granted;
    }

    /**
     * @param string $granted
     *
     * @return Menu
     */
    public function setGranted(string $granted): self
    {
        $this->granted = $granted;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrantedObject()
    {
        return $this->grantedObject;
    }

    /**
     * @param $grantedObject
     *
     * @return Menu
     */
    public function setGrantedObject($grantedObject): self
    {
        $this->grantedObject = $grantedObject;

        return $this;
    }

    /**
     * @return string
     */
    public function getChildren(): string
    {
        return $this->children;
    }

    /**
     * @param string $children
     *
     * @return Menu
     */
    public function setChildren(string $children): self
    {
        $this->children = $children;

        return $this;
    }
}