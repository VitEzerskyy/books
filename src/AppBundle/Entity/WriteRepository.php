<?php

namespace AppBundle\Entity;


Interface WriteRepository
{
    public function save($object);
}