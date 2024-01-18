<?php
namespace App\Controller\Admin\SousSection;


use App\Entity\SousSection;
use App\Form\SousSectionType;
use App\Repository\SousSectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/sousSection')]
class IndexController extends AbstractController
{



    public function __construct(private readonly SousSectionRepository $ssr, private readonly EntityManagerInterface $em){
    }

    #[Route('', name: 'app_sousSection_index')]
    public function index(): Response
    {
        $sousSections = $this->ssr->findAll();

        return $this->render('admin/SousSection/index.html.twig', [
            'sousSections' => $sousSections,
        ]);
    }

    #[Route('/new', name: 'app_sousSection_new')]
    public function new(Request $request): Response
    {
        $sousSection = new SousSection();
        $form = $this->createForm(SousSectionType::class, $sousSection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($sousSection);
            $this->em->flush();

            return $this->redirectToRoute('app_sousSection_index');
        }

        return $this->render('admin/SousSection/new.html.twig', [
            'form' => $form
        ]);

    }

    #[Route('/edit/{id}', name: 'app_sousSection_edit')]
    public function edit(Request $request, SousSection $sousSection): Response
    {
        $form = $this->createForm(SousSectionType::class, $sousSection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('app_sousSection_index');
        }

        return $this->render('admin/SousSection/edit.html.twig', [
            'form' => $form,
            'sousSection' => $sousSection
        ]);

    }

    #[Route('/delete/{id}', name: 'app_sousSection_delete')]
    public function delete(SousSection $sousSection): Response
    {

        $this->em->remove($sousSection);
        $this->em->flush();

        return $this->redirectToRoute('app_sousSection_index');

    }


}