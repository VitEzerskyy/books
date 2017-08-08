<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Entity\Repository\Book\BookReadRepository;
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
//    public function createAction(Request $request)
//    {
//
//        $survey = new Survey();
//
//        $form = $this->createForm(SurveyType::class, $survey);
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->get('app.survey_write')->save($survey);
//            $this->addFlash('success','The survey has added!');
//            return $this->redirectToRoute('books_all');
//        }
//
//        return ['form' => $form->createView()];
//
//    }

    /**
     *
     *
     *
     * @Route("/apply-transition/{id}", name="book_apply_transition")
     * @Method("POST")
     */
    public function applyTransitionAction(Request $request, Book $book)
    {
        try {
            $this->container->get('workflow.book')
                ->apply($book, $request->request->get('transition'));

            $this->get('doctrine')->getManager()->flush();
        } catch (ExceptionInterface $e) {
            $this->get('session')->getFlashBag()->add('danger', $e->getMessage());
        }

        return $this->redirectToRoute('books_all');
    }

    /**
     * @Route("/reset-status/{id}", name="book_reset_status")
     * @Method("POST")
     */
    public function resetMarkingAction(Book $book)
    {
        $book->setMarking(null);
        $this->get('doctrine')->getManager()->flush();

        return $this->redirect($this->generateUrl('books_all'));
    }


}
