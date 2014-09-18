<?php
/**
 * This file is part of the <Auth> project.
 * 
 * @category   Auth
 * @package    Repository
 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
 * @since 2012-01-04
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Sfynx\AuthBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Sfynx\AuthBundle\Builder\RepositoryBuilderInterface;

/**
 * Main Repository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 *
 * @category   Auth
 * @package    Repository
 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
class Repository implements RepositoryBuilderInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;

    /**
     * Initializes a new <tt>EntityRepository</tt>.
     *
     * @param \Doctrine\ORM\EntityManager $em
     * @return void
     */
    public function __construct(EntityManager $em)
    {
        $this->_em = $em;
    }

    /**
     * EntityManager getter
     *
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->_em;
    }
    
    /**
     *
     * @param string $nameEntity
     * @return EntityRepository
     */
    public function getRepository($nameEntity = '' )
    {
        if (!empty($nameEntity))
            return $this->getEntityManager()->getRepository('SfynxAuthBundle:' . ucfirst($nameEntity));
        else 
            throw new \Doctrine\ORM\EntityNotFoundException(); 
    }    

    /**
     * Remove object
     *
     * @param array $object
     * @return void
     */
    public function remove($object = null)
    {
        if (!$object)
            return null;

        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();
    }

    /**
     * Create object
     *
     * @param array $object
     * @return void
     */
    public function create($object = null)
    {
        if (!$object)
            return null;

        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    /**
     * Retrieve object by id
     *
     * @param string $name
     * @param string $nameEntity
     * @return Object
     */
    public function findOneById($id, $nameEntity = '')
    {
        if (!empty($id) && !empty($nameEntity))
            return $this->getRepository($nameEntity)->findOneById($id);
        else
            return null;
    }
    
    /**
     * Retrieve all objects
     *
     * @param string $nameEntity
     * @return Object
     */
    public function findAll($nameEntity = '')
    {
        if (!empty($id) && !empty($nameEntity))
            return $this->getRepository($nameEntity)->findAll();
        else
            return null;
    }
    
    /**
     * Retrieve all enable objects
     *
     * @param string $nameEntity
     * @return Object
     */
    public function findAllEnabled($nameEntity = '')
    {
        if (!empty($nameEntity))
            return $this->getRepository($nameEntity)->findByEnabled(true);
        else
            return null;
    }    

}
