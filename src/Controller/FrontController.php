<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Photo;
use Twig\Environment;
use Symfony\UX\Turbo\TurboBundle;
use App\Repository\PhotoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FrontController extends AbstractController
{

    #[Route('/', name: 'homepage')]
    public function noLocalHomepage(): Response
    {
        return $this->redirectToRoute('app_front', ['_locale' => 'fr']);
    }


    #[Route('/{_locale<%app.supported_locales%>}', name: 'app_front')]
    public function index(PhotoRepository $photoRepository): Response
    {
        $photos = $photoRepository->findAll();
        return $this->render('front/index.html.twig', [
            'photos' => $photos
        ]);
    }

   /*  #[Route('/test', name: 'app_test')]
    public function test(Request $request): Response
    {
        //dd(TurboBundle::STREAM_FORMAT, $request->getPreferredFormat());
        //if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            // If the request comes from Turbo, set the content type as text/vnd.turbo-stream.html and only send the HTML to update
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('front/_cartNav.html.twig', ['cartNumber' => 10]);
        //}
        
    } */

    #[Route('/{_locale<%app.supported_locales%>}/pages/{pageName}', name: 'app_static_page')]
    public function staticPage(string $_locale, string $pageName, Environment $twig): Response
    {
        $template = 'front/pages/' . $pageName . '.' . $_locale . '.html.twig';
        $loader = $twig->getLoader();
        if (!$loader->exists($template))
            throw new NotFoundHttpException();

        return $this->render($template, []);
    }


    #[Route('/photo/{slug}', name: 'app_display_photo')]
    public function displayPhoto(Photo $photo): Response
    {
        return $this->render('front/photo.html.twig', [
            'photo' => $photo
        ]);
    }

    #[Route('/tag/{slug}', name: 'app_display_tag')]
    public function displayTag(Tag $tag): Response
    {
        return $this->render('front/tag.html.twig', [
            'tag' => $tag
        ]);
    }


   
}
