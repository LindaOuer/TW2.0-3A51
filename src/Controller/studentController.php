<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentSearchFormType;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class studentController extends AbstractController
{

    #[Route('/index', name: "indexStudent")]
    public function index(): Response
    {
        return new Response('Hello');
    }

    #[Route('/listStudents', name: 'Student_list')]
    public function list(Request $req, StudentRepository $repo): Response
    {
        $st = new Student();
        $form = $this->createForm(StudentSearchFormType::class, $st);
        $form->handleRequest($req);
        $students = $repo->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $students = $repo->ordredList($st->getFirstName());
        }

        return $this->render('student/list.html.twig', [
            'students' => $students,
            'form' => $form->createView()
        ]);
    }

    #[Route('/addStudent', name: 'Student_Add')]
    public function add(Request $request, StudentRepository $repo): Response
    {
        $st = new Student();

        $form = $this->createForm(StudentType::class, $st);

        $form->handleRequest($request);
        if ($form->isSubmitted()  &&  $form->isValid()) {
            $repo->add($st, true);

            return $this->redirectToRoute('Student_list');
        }

        return $this->renderForm('student/form.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/deleteStudent/{id}', name: 'Student_Delete')]
    public function delete(StudentRepository $repo, Student $student): Response
    {
        $repo->remove($student, true);

        return $this->redirectToRoute('Student_list');
    }
}
