<?php
/**
 * This file is part of the <Trigger> project.
 *
 * @category   Trigger
 * @package    EventListener
 * @subpackage prePersist
 * @author     Etienne de Longeaux <etienne.delongeaux@gmail.com>
 * @copyright  2015 PI-GROUPE
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    2.3
 * @link       http://opensource.org/licenses/gpl-license.php
 * @since      2015-02-16
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Sfynx\SfynxTrigger\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Sfynx\TriggerBundle\EventListener\abstractListener;
use Sfynx\TriggerBundle\SfynxTriggerEvents;
use Sftnx\TriggerBundle\Event\TriggerEvent;
use Sfynx\TriggerBundle\Event\TriggerEvent;

/**
 * Custom pre persist entities listener.
 * The prePersist event occurs for a given entity before the respective EntityManager
 * persist operation for that entity is executed.
 *
 * @category   Trigger
 * @package    EventListener
 * @subpackage prePersist
 * @author     Etienne de Longeaux <etienne.delongeaux@gmail.com>
 * @copyright  2015 PI-GROUPE
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    2.3
 * @link       http://opensource.org/licenses/gpl-license.php
 * @since      2015-02-16
 * 
 */
class PrePersistListener extends abstractListener
{
    /**
     * Constructs a new instance of SecurityListener.
     *
     * @param ContainerInterface        $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }
        
    /**
     * Methos which will be called when the event is thrown.
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $eventArgs
     *
     * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
     */    
    public function PrePersist(LifecycleEventArgs $eventArgs)
    {
        $this->container->get('event_dispatcher')->dispatch(SfynxTriggerEvents::TRIGGER_EVENT_PREPERSIST, new TriggerEvent($eventArgs));
    }    
}
