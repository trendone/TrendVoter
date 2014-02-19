<?php

namespace TrendOne\Bundle\TrendVoterBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use TrendOne\Bundle\TrendVoterBundle\Entity\Campaign;
use TrendOne\Bundle\TrendVoterBundle\Entity\CampaignItemAnswer;
use TrendOne\Bundle\TrendVoterBundle\Form\Frontend\CampaignItemAnswerType;

/**
 * Campaign controller.
 *
 * @Route("/{campaign}")
 * @ParamConverter("campaign", class="TrendOneTrendVoterBundle:Campaign", options={"repository_method" = "findOneBySlug"})
 */
class CampaignController extends Controller
{
    /**
     * Creates a new CampaignItemAnswer entity.
     *
     * @param Request  $request
     * @param Campaign $campaign
     * @param integer  $step
     *
     * @Route("/{step}", requirements={"step" = "\d+"})
     * @Method("POST")
     * @Template("TrendOneTrendVoterBundle:Frontend/Campaign:ask.html.twig")
     */
    public function answerAction(Request $request, Campaign $campaign, $step)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getRequest()->getSession()->get('identifier');

        $campaignItem = $campaign->getItems()->get($step);

        if (!$campaignItem) {
            throw $this->createNotFoundException('Unable to find CampaignItem entity.');
        }

        $entity = $em->getRepository('TrendOneTrendVoterBundle:CampaignItemAnswer')
            ->findOneBy(
                array(
                    'campaignItem' => $campaignItem,
                    'user' => $user
                )
            );

        if (!$entity) {
            $entity = new CampaignItemAnswer();
            $entity
                ->setCampaignItem($campaignItem)
                ->setUser($user);
        }

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            if ($campaign->getItems()->last() === $campaignItem) {
                return $this->redirect($this->generateUrl('trendone_trendvoter_frontend_campaign_finish', array('campaign' => $campaign->getSlug())));
            } else {
                return $this->redirect($this->generateUrl('trendone_trendvoter_frontend_campaign_ask', array('campaign' => $campaign->getSlug(), 'step' => $step+1)));
            }
        }

        return array(
            'campaign'      => $campaign,
            'campaignItem'  => $campaignItem,
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a CampaignItemAnswer entity.
    *
    * @param CampaignItemAnswer $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(CampaignItemAnswer $entity)
    {
        $campaignItem = $entity->getCampaignItem();
        $campaign = $campaignItem->getCampaign();

        $form = $this->createForm(new CampaignItemAnswerType(), $entity, array(
            'action' => $this->generateUrl('trendone_trendvoter_frontend_campaign_answer', array('campaign' => $campaign->getSlug(), 'step' => $campaign->getItems()->indexOf($entity->getCampaignItem()))),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => $campaign->getItems()->last() === $campaignItem ? 'Finish' : 'Next'));

        return $form;
    }

    /**
     * Displays a form to create a new CampaignItemAnswer entity.
     *
     * @param Campaign $campaign
     * @param integer  $step
     *
     * @Route("/{step}", requirements={"step" = "\d+"})
     * @Method("GET")
     * @Template()
     */
    public function askAction(Campaign $campaign, $step)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getRequest()->getSession()->get('identifier');

        $campaignItem = $campaign->getItems()->get($step);

        if (!$campaignItem) {
            throw $this->createNotFoundException('Unable to find CampaignItem entity.');
        }

        $entity = $em->getRepository('TrendOneTrendVoterBundle:CampaignItemAnswer')
            ->findOneBy(
                array(
                    'campaignItem' => $campaignItem,
                    'user' => $user
                )
            );

        if (!$entity) {
            $entity = new CampaignItemAnswer();
            $entity
                ->setCampaignItem($campaignItem)
                ->setUser($user);
        }

        $form   = $this->createCreateForm($entity);

        return array(
            'campaign'      => $campaign,
            'campaignItem'  => $campaignItem,
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Campaign entity.
     *
     * @param Campaign $campaign
     *
     * @Route("/")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Campaign $campaign)
    {
        return array(
            'campaign'      => $campaign,
        );
    }

    /**
     * Finds and displays a Campaign entity.
     *
     * @param Campaign $campaign
     *
     * @Route("/finish")
     * @Method("GET")
     * @Template()
     */
    public function finishAction(Campaign $campaign)
    {
        return array(
            'campaign'      => $campaign,
        );
    }

    /**
     * Finds and displays a Campaign entity.
     *
     * @param Request  $request
     * @param Campaign $campaign
     *
     * @Route("/restart")
     * @Method("GET")
     * @Template()
     */
    public function restartAction(Request $request, Campaign $campaign)
    {
        $this->container->get('trend_one_trend_voter.session_identifier_listener')->resetIdentifier($request->getSession());

        return $this->redirect($this->generateUrl('trendone_trendvoter_frontend_campaign_show', array('campaign' => $campaign->getSlug())));
    }
}
