<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace FGC\MenuBundle\Twig;

use Exception;
use FGC\MenuBundle\Util\MenuRender;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig_Error_Loader;
use Twig_Error_Runtime;
use Twig_Error_Syntax;

class MenuRenderExtension extends AbstractExtension
{
    /**
     * @var MenuRender
     */
    private $menuRender;

	/**
	 * MenuRenderExtension constructor.
	 *
	 * @param MenuRender $menuRender
	 */
    public function __construct(MenuRender $menuRender)
    {
        $this->menuRender = $menuRender;
    }

	/**
	 * @return array|TwigFunction[]
	 */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('fgc_menu', [$this, 'FGCMenuRender'], ['is_safe' => ['html']]),
        ];
    }

	/**
	 * @param string|array $name
	 * @param string       $template
	 * @param int          $depth
	 *
	 * @return string
	 * @throws Exception
	 * @throws Twig_Error_Loader
	 * @throws Twig_Error_Runtime
	 * @throws Twig_Error_Syntax
	 */
    public function FGCMenuRender($name = 'default', $template = 'default', $depth = 2): string
    {
        return $this->menuRender->FGCMenuRender($name, $template, $depth);
    }
}