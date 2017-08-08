<?php

namespace AppBundle\Entity\Repository\Book;

use AppBundle\Entity\Book;
use AppBundle\Entity\MySqlWriteRepository;
use AppBundle\Entity\WriteRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class BookWriteRepository
 * @package AppBundle\Entity\Repository
 */
class BookWriteRepository implements MySqlWriteRepository
{
    private $objectManager;

    /**
     * BookWriteRepository constructor.
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * save book to db
     *
     * @param $object
     * @throws \Exception
     */
    public function save($object): void
    {
        try {
            if ($object instanceof Book) {
                $this->objectManager->persist($object);
                $this->objectManager->flush();
            }
        } catch (\Exception $e) {
            throw new \Exception("Something went wrong. Can't save Book");
        }
    }

}