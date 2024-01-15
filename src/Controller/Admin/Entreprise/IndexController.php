<?php
namespace App\Controller\Admin\Entreprise;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/entreprise')]
class IndexController extends AbstractController
{



    public function __construct(private readonly EntrepriseRepository $er, private readonly EntityManagerInterface $em){
    }

    #[Route('', name: 'app_entreprise_index')]
    public function index(): Response
    {
        $entreprises = $this->er->findAll();

        return $this->render('admin/Entreprise/index.html.twig', [
            'entreprises' => $entreprises,
        ]);
    }

    #[Route('/new', name: 'app_entreprise_new')]
    public function new(Request $request): Response
    {
        $entreprise = new Entreprise();
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($entreprise);
            $this->em->flush();

            return $this->redirectToRoute('app_entreprise_index');
        }

        return $this->render('admin/Entreprise/new.html.twig', [
            'form' => $form
        ]);

    }

    #[Route('/edit/{id}', name: 'app_entreprise_edit')]
    public function edit(Request $request, Entreprise $entreprise): Response
    {
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('app_entreprise_index');
        }

        return $this->render('admin/Entreprise/edit.html.twig', [
            'form' => $form,
            'entreprise' => $entreprise
        ]);

    }

    #[Route('/delete/{id}', name: 'app_entreprise_delete')]
    public function delete(Entreprise $entreprise): Response
    {

        $this->em->remove($entreprise);
        $this->em->flush();

        return $this->redirectToRoute('app_entreprise_index');

    }


}