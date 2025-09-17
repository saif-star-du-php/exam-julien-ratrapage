<?php
namespace App\Controller;

use App\Entity\Figurine;
use App\Form\FigurineType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request,Response};
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class FigurineController extends AbstractController
{
    #[Route('/figurine', name:'app_figurine_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(Figurine::class);
        $figurines = $repo->findBy([], ['createdAt'=>'DESC']);
        return $this->render('figurine/index.html.twig', ['figurines'=>$figurines]);
    }

    #[Route('/figurine/create', name:'app_figurine_create')]
    #[IsGranted('ROLE_USER')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $fig = new Figurine();
        $form = $this->createForm(FigurineType::class, $fig);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fig->setAuthor($this->getUser());
            $fig->initializeTimestamps();
            $em->persist($fig);
            $em->flush();
            $this->addFlash('success', 'Figurine créée avec succès.');
            return $this->redirectToRoute('app_figurine_index');
        }
        return $this->render('figurine/create.html.twig', ['form'=>$form->createView()]);
    }

    #[Route('/figurine/{id}', name:'app_figurine_show')]
    public function show(Figurine $fig): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('figurine/show.html.twig', ['figurine'=>$fig]);
    }

    #[Route('/figurine/{id}/edit', name:'app_figurine_edit')]
    public function edit(Request $request, Figurine $fig, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($fig->getAuthor()->getId() !== $this->getUser()->getId()) {
            $this->addFlash('danger','Accès interdit.');
            return $this->redirectToRoute('app_figurine_index');
        }
        $form = $this->createForm(FigurineType::class, $fig);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fig->setUpdatedAt(new \DateTimeImmutable());
            $em->flush();
            $this->addFlash('success','Figurine modifiée avec succès.');
            return $this->redirectToRoute('app_figurine_show', ['id'=>$fig->getId()]);
        }
        return $this->render('figurine/edit.html.twig', ['form'=>$form->createView(), 'figurine'=>$fig]);
    }

    #[Route('/figurine/{id}/delete', name:'app_figurine_delete')]
    public function delete(Figurine $fig, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($fig->getAuthor()->getId() !== $this->getUser()->getId()) {
            $this->addFlash('danger','Accès interdit.');
            return $this->redirectToRoute('app_figurine_index');
        }
        $em->remove($fig);
        $em->flush();
        $this->addFlash('danger','Figurine supprimée.');
        return $this->redirectToRoute('app_figurine_index');
    }
}
