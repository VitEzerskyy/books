<?php

namespace AppBundle\Entity\Repository\Book;

use AppBundle\Entity\MySqlReadRepository;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Book;
use AppBundle\Entity\ReadRepository;

/**
 * Class BookReadRepository
 * @package AppBundle\Entity\Repository
 */
class BookReadRepository implements MySqlReadRepository
{
    private $objectManager;

    /**
     * BookReadRepository constructor.
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }


    /**
     * find all books, sort by created
     *
     * @return array|null
     * @throws \Exception
     */
    public function findByCreated() {

        try {
            $books = $this->objectManager->getRepository('AppBundle:Book')->findBy(array(),array('created' => 'DESC'));
        }catch (\Exception $e) {
            throw new \Exception("Oops! Something went wrong. Can't fetch data from Book");
        }
        return $books;
    }
}