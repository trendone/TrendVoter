<?php

namespace TrendOne\Bundle\TrendVoterBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use TrendOne\Bundle\TrendVoterBundle\Entity\CampaignItem;
use TrendOne\Bundle\TrendVoterBundle\Form\Admin\CampaignItemType;
use TrendOne\Bundle\TrendVoterBundle\Entity\Campaign;

/**
 * CampaignItem controller.
 *
 * @Route("/campaign/{campaign}/item")
 * @ParamConverter("campaign", class="TrendOneTrendVoterBundle:Campaign", options={"id" = "campaign"})
 */
class CampaignItemController extends Controller
{

    /**
     * Lists all CampaignItem entities.
     *
     * @param Campaign $campaign
     *
     * @Route("s/")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Campaign $campaign)
    {
        return $this->redirect($this->generateUrl('trendone_trendvoter_admin_campaign_edit', array('id' => $campaign->getId())));

        return array(
            'entities' => $campaign->getItems(),
            'campaign' => $campaign
        );
    }
    /**
     * Creates a new CampaignItem entity.
     *
     * @param Campaign $campaign
     *
     * @Route("/")
     * @Method("POST")
     * @Template("TrendOneTrendVoterBundle:Admin/CampaignItem:new.html.twig")
     */
    public function createAction(Request $request, Campaign $campaign)
    {
        $entity = new CampaignItem();
        $entity->setCampaign($campaign);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->getRequest()->getSession()->getFlashBag()->add('notice', 'Campaign item was successfully created.');

            return $this->redirect($this->generateUrl('trendone_trendvoter_admin_campaignitem_edit', array('id' => $entity->getId(), 'campaign' => $campaign->getId())));
        }

        $this->getRequest()->getSession()->getFlashBag()->add('error', 'Campaign item was not created.');

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a CampaignItem entity.
    *
    * @param CampaignItem $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(CampaignItem $entity)
    {
        $form = $this->createForm(new CampaignItemType(), $entity, array(
            'action' => $this->generateUrl('trendone_trendvoter_admin_campaignitem_create', array('campaign' => $entity->getCampaign()->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn-primary')));

        return $form;
    }

    /**
     * Displays a form to create a new CampaignItem entity.
     *
     * @param Campaign $campaign
     *
     * @Route("/new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Campaign $campaign)
    {
        $entity = new CampaignItem();
        $entity->setCampaign($campaign);
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a CampaignItem entity.
     *
     * @param Campaign     $campaign
     * @param CampaignItem $entity
     *
     * @Route("/{id}")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Campaign $campaign, CampaignItem $entity)
    {
        $deleteForm = $this->createDeleteForm($entity);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CampaignItem entity.
     *
     * @param Campaign     $campaign
     * @param CampaignItem $entity
     *
     * @Route("/{id}/edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Campaign $campaign, CampaignItem $entity)
    {
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a CampaignItem entity.
    *
    * @param CampaignItem $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CampaignItem $entity)
    {
        $form = $this->createForm(new CampaignItemType(), $entity, array(
            'action' => $this->generateUrl('trendone_trendvoter_admin_campaignitem_update', array('id' => $entity->getId(), 'campaign' => $entity->getCampaign()->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn-primary')));

        return $form;
    }
    /**
     * Edits an existing CampaignItem entity.
     *
     * @param Request      $request
     * @param Campaign     $campaign
     * @param CampaignItem $entity
     *
     * @Route("/{id}")
     * @Method("PUT")
     * @Template("TrendOneTrendVoterBundle:Admin/CampaignItem:edit.html.twig")
     */
    public function updateAction(Request $request, Campaign $campaign, CampaignItem $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($entity);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->getRequest()->getSession()->getFlashBag()->add('notice', 'Campaign item was successfully updated.');

            return $this->redirect($this->generateUrl('trendone_trendvoter_admin_campaignitem_edit', array('id' => $entity->getId(), 'campaign' => $campaign->getId())));
        }

        $this->getRequest()->getSession()->getFlashBag()->add('error', 'Campaign item was not updated.');

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a CampaignItem entity.
     *
     * @param Request      $request
     * @param Campaign     $campaign
     * @param CampaignItem $entity
     *
     * @Route("/{id}")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Campaign $campaign, CampaignItem $entity)
    {
        $form = $this->createDeleteForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($entity);
            $em->flush();
        }

//        return $this->redirect($this->generateUrl('trendone_trendvoter_admin_campaignitem_index', array('campaign' => $campaign->getId())));
        return $this->redirect($this->generateUrl('trendone_trendvoter_admin_campaign_edit', array('id' => $campaign->getId())));
    }

    /**
     * Creates a form to delete a CampaignItem entity by id.
     *
     * @param CampaignItem $entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CampaignItem $entity)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trendone_trendvoter_admin_campaignitem_delete', array('id' => $entity->getId(), 'campaign' => $entity->getCampaign()->getId())))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn-danger')))
            ->getForm()
        ;
    }
}
