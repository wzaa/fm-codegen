<?php
namespace App\Controller;

use App\CodeGenerator;
use App\Form\CodeGeneratorForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class GeneratorController extends Controller
{
    /**
     * @Route("/")
     */
    public function form(Request $request)
    {
        $form = $this->createForm(CodeGeneratorForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            return $this->generate($data);
        }

        return $this->render('generator/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function generate(array $data)
    {
        $numberOfCodes = $data['numberOfCodes'];
        $lengthOfCode = $data['lengthOfCode'];

        $generator = new CodeGenerator($lengthOfCode);

        $codes = $generator->generate($numberOfCodes);

        $joined = join("\r\n", $codes);

        $response = new Response($joined);

        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'codes.csv');
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }


}