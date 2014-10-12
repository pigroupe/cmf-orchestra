<?php
/**
 * This file is part of the <Cmf> project.
 * 
 * @subpackage   Cmf
 * @package    Repository
 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
 * @since 2011-12-28
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Sfynx\CmfBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Sfynx\CmfBundle\Repository\CmfTreeRepository;

/**
 * Rubrique Repository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 * 
 * @subpackage   Cmf
 * @package    Repository
 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
class RubriqueRepository extends CmfTreeRepository
{
    /**
     * Return all Rubrique.
     *
     * @return \Sfynx\CmfBundle\Entity\Rubrique
     * @access public
     *
     * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
     * @since 2012-01-23
     */
    public function getAllPageRubrique()
    {
        $query = $this->createQueryBuilder('r')
                        ->select('r')
                        ->where('r.enabled = :enabled')
                        ->orderBy('r.lft', 'ASC')
                        ->setParameter('enabled', 1);
        //return $query->getQuery()->setMaxResults(1)->getArrayResult();
    
        return $query;
    }    
}