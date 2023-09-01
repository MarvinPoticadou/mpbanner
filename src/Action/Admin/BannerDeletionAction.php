<?php

namespace Mp\Module\MpBanner\Action\Admin;

use Mp\Module\MpBanner\Entity\Banner;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use MpBanner;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BannerDeletionAction extends FrameworkBundleAdminController
{
    public function __invoke(Request $request, int $id): Response
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Banner $banner */
        $banner = $em->getRepository(Banner::class)->find($id);

        if (!$banner) {
            throw $this->createNotFoundException('Banner not found');
        }

        $imageFilename = $banner->getFilename();
        $mobileImageFilename = $banner->getMobileFilename();

        $em->remove($banner);
        $em->flush();

        if ($imageFilename) {
            unlink(MpBanner::getImagesDir() . '/' . $imageFilename);
        }

        if ($mobileImageFilename) {
            unlink(MpBanner::getImagesDir() . '/' . $mobileImageFilename);
        }

        $this->addFlash('success', $this->trans('Successful deletion.', 'Admin.Notifications.Success'));

        return $this->redirectToRoute('admin_mpbanner_list');
    }
}
