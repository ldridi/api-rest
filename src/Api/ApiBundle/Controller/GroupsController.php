<?php

namespace Api\ApiBundle\Controller;

use Api\ApiBundle\Entity\Groups;
use Api\ApiBundle\Form\GroupsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class GroupsController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/groups/")
     */
    public function getGroupsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $groups = $em->getRepository('ApiBundle:Groups')->findAll();

        return $groups;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/groups/{group_id}")
     */
    public function getGroupAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('ApiBundle:Groups')->find($request->get('group_id'));

        if (!$group) {
            return new JsonResponse(['message' => 'Group not found'], Response::HTTP_NOT_FOUND);
        }

        return $group;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/groups/")
     */
    public function createGroupAction(Request $request)
    {
        $group = new Groups();
        $form = $this->createForm(GroupsType::class, $group);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($group);
            $em->flush();
            return $group;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View()
     * @Rest\Put("/groups/{id}")
     */
    public function updateGroupAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('ApiBundle:Groups')->find($request->get('id'));

        if (!$group) {
            return new JsonResponse(['message' => 'Group not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(GroupsType::class, $group);

        $form->submit($request->request->all());

        if ($form->isValid()) {

            $em->flush();
            return $group;

        } else {
            return $form;
        }
    }
}
