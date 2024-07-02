<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/admin')]

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_admin_category')]
    public function index(CategoryRepository $repository): Response
    {
        if ($repository->count() == 0) {
            return $this->redirectToRoute('admin_add_category');
        }
        return $this->render('admin/category/index.html.twig', [
            'categories' => $repository->findBy([],['name'=>'ASC']),
        ]);
    }

    #[Route('/category/new', name: 'admin_add_category')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('app_admin_category');
        }
        return $this->render('admin/category/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/category/edit/{id}', name: 'admin_edit_category')]
    public function edit(Request $request, EntityManagerInterface $manager, Category $category): Response
    {

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('app_admin_category');
        }
        return $this->render('admin/category/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/category/remove/{id}', name: 'app_admin_category_remove')]
    public function remove(Category $category, EntityManagerInterface $manager): Response
    {
        foreach ($category->getFilms() as $film){
            $film->removeCategory($category);
        }
        $manager->remove($category);
        $manager->flush();
        return $this->redirectToRoute('app_admin_category');
    }
}
