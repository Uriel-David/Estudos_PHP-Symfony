<?php

namespace App\Controller\Api;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Usuario;

/**
 * @Route("/api/v1", name="api_v1_usuario_")
 */
class UsuarioController extends AbstractController
{
    /**
     * @Route("/lista", methods={"GET"}, name="lista")
     */
    public function lista(): JsonResponse
    {
        $doctrineORM = $this->getDoctrine()->getRepository(Usuario::class);

        return new JsonResponse($doctrineORM->CatchAll());
    }

    /**
     * @Route("/cadastra", methods={"POST"}, name="cadastra")
     */
    public function cadastra(Request $request): Response
    {
        $data = $request->request->all();

        $usuario = new Usuario;
        $usuario->setNome($data['nome']);
        $usuario->setEmail($data['email']);

        $doctrineORM = $this->getDoctrine()->getManager();
        $doctrineORM->persist($usuario);
        $doctrineORM->flush();

        if($doctrineORM->contains($usuario)) {
            return new Response("Ok", 200);
        } else {
            return new Response("Erro", 404);
        }
    }
}
