<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Book
 *
 * @ORM\Table(name="book")
 * @ORM\Entity()
 */
class Book
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 1,
     *      max = 255,
     *      minMessage = "Title must be at least {{ limit }} characters long",
     *      maxMessage = "Title cannot be longer than {{ limit }} characters"
     * )
     */
    private $title;

    /**
     * @var bool
     *
     * @ORM\Column(name="published_year", type="integer", nullable=false)
     *
     * @Assert\Range(
     *      min = 1550,
     *      max = 2017,
     *      minMessage = "The minimum year is {{ limit }}",
     *      maxMessage = "The maximum year is {{ limit }}"
     *)
     */
    private $published_year;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetimetz")
     * @Assert\DateTime()
     */
    private $created;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Author", inversedBy="books")
     * @ORM\JoinTable(name="books_authors",
     *      joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="author_id", referencedColumnName="id")}
     *      )
     */
    private $authors;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $marking;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
        $this->created = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Book
     */
    public function setTitle(string $title): Book
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set publishedYear
     *
     * @param integer $publishedYear
     *
     * @return Book
     */
    public function setPublishedYear(int $publishedYear): Book
    {
        $this->published_year = $publishedYear;

        return $this;
    }

    /**
     * Get publishedYear
     *
     * @return integer
     */
    public function getPublishedYear()
    {
        return $this->published_year;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Book
     */
    public function setCreated(\DateTime $created): Book
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * Set marking
     *
     * @param string
     *
     */
    public function setMarking(string $marking)
    {
        $this->marking = $marking;

    }

    /**
     * Get marking
     *
     * @return string|null
     */
    public function getMarking()
    {
        return $this->marking;
    }

    /**
     * Add author
     *
     * @param \AppBundle\Entity\Author $author
     *
     * @return Book
     */
    public function addAuthor(\AppBundle\Entity\Author $author): Book
    {
        $this->authors[] = $author;

        return $this;
    }

    /**
     * Remove author
     *
     * @param \AppBundle\Entity\Author $author
     */
    public function removeAuthor(\AppBundle\Entity\Author $author): void
    {
        $this->authors->removeElement($author);
    }

    /**
     * Get authors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }
}
