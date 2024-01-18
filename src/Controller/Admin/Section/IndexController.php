<?php
namespace App\Controller\Admin\Section;

use App\Entity\Section;
use App\Form\SectionType;
use App\Repository\SectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/section')]
class IndexController extends AbstractController
{



    public function __construct(private readonly SectionRepository $sr, private readonly EntityManagerInterface $em){
    }

    #[Route('', name: 'app_section_index')]
    public function index(): Response
    {
        $sections = $this->sr->findAll();

        return $this->render('admin/Section/index.html.twig', [
            'sections' => $sections,
        ]);
    }

    #[Route('/new', name: 'app_section_new')]
    public function new(Request $request): Response
    {
        $section = new Section();
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($section);
            $this->em->flush();

            return $this->redirectToRoute('app_section_index');
        }

        return $this->render('admin/Section/new.html.twig', [
            'form' => $form
        ]);

    }

    #[Route('/edit/{id}', name: 'app_section_edit')]
    public function edit(Request $request, Section $section): Response
    {
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('app_section_index');
        }

        return $this->render('admin/Section/edit.html.twig', [
            'form' => $form,
            'section' => $section
        ]);

    }

    #[Route('/delete/{id}', name: 'app_section_delete')]
    public function delete(Section $section): Response
    {

        $this->em->remove($section);
        $this->em->flush();

        return $this->redirectToRoute('app_section_index');

    }


}