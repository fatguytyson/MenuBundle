<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace FGC\MenuBundle\Util;

use Exception;
use FGC\MenuBundle\Entity\Menu;
use Twig\Environment;
use Twig_Error_Loader;
use Twig_Error_Runtime;
use Twig_Error_Syntax;

/**
 * Class MenuRender
 *
 * @package FGC\MenuBundle\Util
 */
class MenuRender
{
    /**
     * @var Environment $twigEngine
     */
    private $twigEngine;

    /**
     * @var MenuManager $menuManager
     */
    private $menuManager;

	/**
	 * MenuRender constructor.
	 *
	 * @param MenuManager $menuManager
	 * @param Environment $twigEngine
	 */
    public function __construct(MenuManager $menuManager, Environment $twigEngine)
    {
        $this->twigEngine = $twigEngine;
        $this->menuManager = $menuManager;
    }

	/**
	 * @param string|Menu[] $name
	 * @param string        $template
	 * @param int           $depth
	 *
	 * @return string
	 * @throws Exception
	 * @throws Twig_Error_Loader
	 * @throws Twig_Error_Runtime
	 * @throws Twig_Error_Syntax
	 */
    public function FGCMenuRender($name = 'default', $template = 'default', $depth = 2)
    {
    	$items = is_array($name) ? $name : $this->menuManager->getMenu($name);
	    return $this->twigEngine->render('@FGCMenu/'.$template.'.html.twig', [
			    'menu' => $items,
			    'template' => $template,
			    'depth' => --$depth
		    ]);
    }
}