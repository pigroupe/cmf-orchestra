<?php
/**
 * This file is part of the <Tool> project.
 *
 * @subpackage   Tool
 * @package    Builder
 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
 * @since 2012-02-23
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Sfynx\ToolBundle\Builder;

/**
 * RouteTranslatorFactoryInterface interface.
 *
 * @subpackage   Tool
 * @package    Builder
 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
interface RouteTranslatorFactoryInterface
{
    public function getRefererRoute($langue = '', $options = null);
    public function getLocaleRoute($langue = '', $options = null);
    public function getRoute($route_name = null, $params = null);
    public function getMatchParamOfRoute($param = null, $langue = '', $isGetReferer = false);
    public function getGenerate($name, array $locales, array $defaults = array(), array $requirements = array(), array $options = array());
}