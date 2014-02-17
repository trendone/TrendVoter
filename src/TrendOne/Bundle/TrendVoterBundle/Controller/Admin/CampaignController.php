<?php

namespace TrendOne\Bundle\TrendVoterBundle\Controller\Admin;

use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use TrendOne\Bundle\TrendVoterBundle\Entity\Campaign;
use TrendOne\Bundle\TrendVoterBundle\Form\Admin\CampaignType;

/**
 * Campaign controller.
 *
 * @Route("/campaign")
 */
class CampaignController extends Controller
{
    /**
     * Lists all Campaign entities.
     *
     * @param integer $page
     *
     * @Route("s/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1})
     * @Method("GET")
     * @Template()
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        $queryBuilder = $em->getRepository('TrendOneTrendVoterBundle:Campaign')
            ->createQueryBuilder('campaign')
            ->addSelect('items')
            ->leftJoin('campaign.items', 'items')
            ->addOrderBy('campaign.title', 'ASC')
            ->addOrderBy('campaign.id', 'ASC');

        $adapter = new DoctrineORMAdapter($queryBuilder);

        $pagerfanta = new Pagerfanta($adapter);
        //$pagerfanta->setMaxPerPage(5);
        $pagerfanta->setNormalizeOutOfRangePages(true);
        $pagerfanta->setCurrentPage($page);

        return array(
            'entities' => $pagerfanta->getCurrentPageResults(),
            'pager' => $pagerfanta
        );
    }

    /**
     * Creates a new Campaign entity.
     *
     * @Route("/")
     * @Method("POST")
     * @Template("TrendOneTrendVoterBundle:Admin/Campaign:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Campaign();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->getRequest()->getSession()->getFlashBag()->add('notice', 'Campaign was successfully created.');

            return $this->redirect($this->generateUrl('trendone_trendvoter_admin_campaign_edit', array('id' => $entity->getId())));
        }

        $this->getRequest()->getSession()->getFlashBag()->add('error', 'Campaign was not created.');

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Campaign entity.
    *
    * @param Campaign $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Campaign $entity)
    {
        $form = $this->createForm(new CampaignType(), $entity, array(
            'action' => $this->generateUrl('trendone_trendvoter_admin_campaign_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Campaign entity.
     *
     * @Route("/new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Campaign();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Campaign entity.
     *
     * @Route("/{id}")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Campaign $entity)
    {
        $deleteForm = $this->createDeleteForm($entity);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Campaign entity.
     *
     * @Route("/{id}/edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Campaign $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Campaign entity.
    *
    * @param Campaign $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Campaign $entity)
    {
        $form = $this->createForm(new CampaignType(), $entity, array(
            'action' => $this->generateUrl('trendone_trendvoter_admin_campaign_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Campaign entity.
     *
     * @Route("/{id}")
     * @Method("PUT")
     * @Template("TrendOneTrendVoterBundle:Admin/Campaign:edit.html.twig")
     */
    public function updateAction(Request $request, Campaign $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($entity);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->getRequest()->getSession()->getFlashBag()->add('notice', 'Campaign was successfully updated.');

            return $this->redirect($this->generateUrl('trendone_trendvoter_admin_campaign_edit', array('id' => $entity->getId())));
        }

        $this->getRequest()->getSession()->getFlashBag()->add('error', 'Campaign was not updated.');

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Campaign entity.
     *
     * @Route("/{id}")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Campaign $entity)
    {
        $form = $this->createDeleteForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('trendone_trendvoter_admin_campaign_index'));
    }

    /**
     * Creates a form to delete a Campaign entity by id.
     *
     * @param Campaign $entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Campaign $entity)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trendone_trendvoter_admin_campaign_delete', array('id' => $entity->getId())))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn-danger')))
            ->getForm()
        ;
    }
}
