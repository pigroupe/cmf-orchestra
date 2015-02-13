<?php 
/**
 * This file is part of the <Gedmo> project.
 *
 * @category   Content_Entities
 * @package    Entity
 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
 * @since 2012-07-31
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Plugins\ContentBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use BootStrap\TranslationBundle\Model\AbstractTranslationEntity;

/**
 * @ORM\Entity(repositoryClass="Plugins\ContentBundle\Repository\BlocGeneralRepository")
 * @ORM\Table(
 *         name="cont_bloc_general_translations",
 *         uniqueConstraints={@ORM\UniqueConstraint(name="lookup_unique_idx", columns={
 *             "locale", "object_id", "field"
 *         })}
 * )
 */
class BlocGeneralTranslation extends AbstractTranslationEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="Plugins\ContentBundle\Entity\BlocGeneral", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;
    
    /**
     * Convinient constructor
     *
     * @param string $locale
     * @param string $field
     * @param string $value
     */
    public function __construct($locale = null, $field = null, $value = null)
    {
        if (!is_null($locale))
            $this->setLocale($locale);
        if (!is_null($field))
            $this->setField($field);
        if (!is_null($value))
            $this->setContent($value);
    }    
        
}