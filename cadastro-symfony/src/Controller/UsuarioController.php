<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Usuario;

/**
 * @Route("/", methods={"GET", "POST"}, name="web_usuario_")
 */
class UsuarioController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="index")
     */
    public function index(): Response
    {
        return $this->render("usuario/form.html.twig");
    }

    /**
     * @Route("/salvar", methods={"POST"}, name="salvar")
     */
    public function salvar(Request $request): Response
    {
        $data = $request->request->all();

        $usuario = new Usuario;
        $usuario->setNome($data['nome']);
        $usuario->setEmail($data['email']);

        $doctrineORM = $this->getDoctrine()->getManager();
        $doctrineORM->persist($usuario);
        $doctrineORM->flush();

        if($doctrineORM->contains($usuario)) {
            return $this->render("usuario/sucesso.html.twig", [
                "Fulano" => $data['nome']
            ]);
        } else {
            return $this->render("usuario/erro.html.twig", [
                "Fulano" => $data['nome']
            ]);
        }
    }
}
