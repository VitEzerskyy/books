<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Entity\Repository\Book\BookReadRepository;
use AppBundle\Entity\Repository\Book\BookWriteRepository;
use AppBundle\Form\BookType;
use Doctrine\ORM\Mapping\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Workflow\Exception\ExceptionInterface;

/**
 * Class BookController
 * @package AppBundle\Controller
 */
class BookController extends Controller
{
    /**
     * Returns all books
     *
     * @param Request $request
     *
     * @return array
     *
     * @Template()
     * @Route("/", name="books_all")
     */
    public function indexAction(Request $request): array
    {
        $books = $this->get(BookReadRepository::class)->findByCreated();
        return ['books' => $books];
    }

    /**
     * Return form for creating book, transfer data to WriteRepository
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     *
     * @Template()
     * @Route("/create", name="create_book")
     */
    public function createAction(Request $request)
    {

        $book = new Book();

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get(BookWriteRepository::class)->save($book);
            $this->addFlash('success','The book has added!');
            return $this->redirectToRoute('books_all');
        }

        return ['form' => $form->createView()];

    }

    /**
     * applies transition for Book
     *
     * @param Request $request
     * @param Book $book
     *
     * @return RedirectResponse
     *
     * @Route("/apply-transition/{id}", name="book_apply_transition")
     * @Method("POST")
     */
    public function applyTransitionAction(Request $request, Book $book)
    {
        try {
            $this->container->get('workflow.book')
                ->apply($book, $request->get('transition'));

            $this->get(BookWriteRepository::class)->save($book);
        } catch (ExceptionInterface $e) {
            $this->get('session')->getFlashBag()->add('danger', $e->getMessage());
        }

        return $this->redirectToRoute('books_all');
    }

}
