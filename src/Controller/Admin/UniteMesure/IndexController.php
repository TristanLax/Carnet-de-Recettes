<?php
namespace App\Controller\Admin\UniteMesure;

use App\Entity\UniteMesure;
use App\Form\UniteMesureType;
use App\Repository\UniteMesureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/uniteMesure')]
class IndexController extends AbstractController
{



    public function __construct(private readonly UniteMesureRepository $umRepository, private readonly EntityManagerInterface $em){
    }

    #[Route('', name: 'app_uniteMesure_index')]
    public function index(): Response
    {
        $unitesMesure = $this->umRepository->findAll();

        return $this->render('admin/UniteMesure/index.html.twig', [
            'unitesMesure' => $unitesMesure,
        ]);
    }

    #[Route('/new', name: 'app_uniteMesure_new')]
    public function new(Request $request): Response
    {
        $uniteMesure = new UniteMesure();
        $form = $this->createForm(UniteMesureType::class, $uniteMesure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($uniteMesure);
            $this->em->flush();

            return $this->redirectToRoute('app_uniteMesure_index');
        }

        return $this->render('admin/UniteMesure/new.html.twig', [
            'form' => $form
        ]);

    }

    #[Route('/edit/{id}', name: 'app_uniteMesure_edit')]
    public function edit(Request $request, UniteMesure $uniteMesure): Response
    {
        $form = $this->createForm(UniteMesureType::class, $uniteMesure);
        $form->handleRequest($request);

        return $this->render('admin/UniteMesure/edit.html.twig', [
            'form' => $form,
            'uniteMesure' => $uniteMesure
        ]);

    }

    #[Route('/delete/{id}', name: 'app_uniteMesure_delete')]
    public function delete(UniteMesure $uniteMesure): Response
    {

        $this->em->remove($uniteMesure);
        $this->em->flush();

        return $this->redirectToRoute('app_uniteMesure_index');

    }


}