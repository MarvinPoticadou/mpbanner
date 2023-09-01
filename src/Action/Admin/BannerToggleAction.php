<?php


namespace Mp\Module\MpBanner\Action\Admin;


use Mp\Module\MpBanner\Entity\Banner;
use Mp\Module\MpBanner\Form\Model\BannerData;
use Mp\Module\MpBanner\Form\Type\BannerType;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BannerToggleAction extends FrameworkBundleAdminController
{
    public function __invoke(Request $request, int $bannerId): Response
    {
        try {
            $em = $this->getDoctrine()->getManager();

            /** @var Banner $banner */
            $banner = $em->getRepository(Banner::class)->find($bannerId);

            if (!$banner) {
                throw $this->createNotFoundException('Banner not found');
            }

            $bannerData = new BannerData($banner);
            $form = $this->createForm(BannerType::class, $bannerData);
            $form->handleRequest($request);

            $em = $this->getDoctrine()->getManager();

            $banner
                ->setStatus(!$bannerData->status);

            $em->persist($banner);
            $em->flush();

            $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));
        } catch (ReviewerException $e) {
            $this->addFlash('error', $this->getErrorMessageForException($e, $this->getErrorMessageMapping()));
        }

        return $this->redirectToRoute('admin_mpbanner_list');
    }
}
