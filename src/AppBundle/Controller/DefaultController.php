<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Proposition;
use AppBundle\Entity\Document;
use AppBundle\Form\DocumentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $proposition = new Proposition();
        $proposition->setDeadline(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($proposition)
            ->add('title', TextType::class, array('label' => 'Titre(*) : ', 'required'    => true))
            ->add('teaser', TextType::class, array('label' => 'Teaser(*) (140 caractère) : ', 'required'    => true))
            ->add('url', TextType::class, array('label' => 'Lien à partager(*) : ', 'required'    => true))
            ->add('typeProposition', ChoiceType::class, array(
                'label' => 'Type de proposition(*) : ',
                'required'    => true,
                'choice_list' => new ChoiceList(
                    array(1, 2, 3),
                    array('Agenda', 'Action', 'Article')
                )))
            ->add('lieu', TextType::class, array('label' => 'Lieu : ', 'required'    => false))
            ->add('theme', TextType::class, array('label' => 'Thèmes ou Commission : ', 'required'    => false))
            ->add('deadline', DateType::class , array("required" => false,'label' => "Date de l'évènement : ",
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker','placeholder' => 'facultatif']))
            ->add('description', 'textarea', array(
                'label' => "Description de l'évènement : ",
                'required'    => true,
                'attr' => array(
                    'class' => 'editor'
                )
            ))
            ->add('documents', 'collection', array('type' => new DocumentType(),
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->add('save', SubmitType::class, array('label' => 'Enregistrez'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $proposition = $form->getData();
            $proposition->setCreatedAt(new \DateTime());
            $proposition->setOrdre(0);
            $proposition->setActive(true);

            foreach ($proposition->getDocuments() as $doc) {
                if($doc){
                    if($doc->file !== null){
                        $doc->setProposition($proposition);
                        $doc->setDoc(sha1(uniqid(mt_rand(), true)).'.'.$doc->file->guessExtension());
                    }
                }
            }

            $em->persist($proposition);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        $arrayProposition = $this->getDoctrine()->getRepository('AppBundle:Proposition')->findBy(array("active" => true), array('ordre' => 'DESC'));

        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'form' => $form->createView(),
            'arrayProposition' => $arrayProposition,
        ));
    }

    /**
     * @Route("/monte/{id}", name="proposition_monte", requirements={"id": "\d+"})
     */
    public function monteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $prop = $this->getDoctrine()->getRepository('AppBundle:Proposition')->findOneBy(array("id"=>$id));
        $prop->setOrdre($prop->getOrdre() + 1 );
        $em->persist($prop);
        $em->flush();

        return $this->redirectToRoute("homepage");
    }

    /**
     * @Route("/descend/{id}", name="proposition_descend", requirements={"id": "\d+"})
     */
    public function descendAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $prop = $this->getDoctrine()->getRepository('AppBundle:Proposition')->findOneBy(array("id"=>$id));
        $prop->setOrdre($prop->getOrdre() - 1 );
        $em->persist($prop);
        $em->flush();

        return $this->redirectToRoute("homepage");
    }

    /**
     * @Route("/interdit/{id}", name="proposition_interdit", requirements={"id": "\d+"})
     */
    public function interditAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $prop = $this->getDoctrine()->getRepository('AppBundle:Proposition')->findOneBy(array("id"=>$id));
        $prop->setActive(false );
        $em->persist($prop);
        $em->flush();

        return $this->redirectToRoute("homepage");
    }
}
