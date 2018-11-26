<?php
namespace FGC\MenuBundle\Util;


use Symfony\Component\Cache\Adapter\AdapterInterface;

class MenuRender
{
    /**
     * @var \Twig_Environment $twigEngine
     */
    private $twigEngine;

    /**
     * @var MenuManager $menuManager
     */
    private $menuManager;

	/**
	 * MenuRender constructor.
	 *
	 * @param MenuManager       $menuManager
	 * @param \Twig_Environment $twigEngine
	 */
    public function __construct(MenuManager $menuManager, \Twig_Environment $twigEngine) //, AdapterInterface $cache
    {
        $this->twigEngine = $twigEngine;
        $this->menuManager = $menuManager;
//        $this->cache = $cache;
    }

	/**
	 * @param string|array $name
	 * @param string       $template
	 * @param int          $depth
	 *
	 * @return string
	 * @throws \Exception
	 * @throws \Twig_Error_Loader
	 * @throws \Twig_Error_Runtime
	 * @throws \Twig_Error_Syntax
	 */
    public function FGCMenuRender($name = 'default', $template = 'default', $depth = 2)
    {
    	$items = is_array($name) ? $name : $this->menuManager->getMenu($name);
	    return ($this->twigEngine->render('@FGCMenu/'.$template.'.html.twig', array(
			    'menu' => $items,
			    'template' => $template,
			    'depth' => --$depth
		    )));
    }
}