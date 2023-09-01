<?php

namespace Mp\Module\MpBanner\Action\Admin;

use Mp\Module\MpBanner\Entity\Banner;
use Mp\Module\MpBanner\Entity\BannerLang;
use Mp\Module\MpBanner\Form\Model\BannerData;
use Mp\Module\MpBanner\Form\Type\BannerType;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use MpBanner;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BannerEditionAction extends FrameworkBundleAdminController
{
    public function __invoke(Request $request, int $id): Response
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Banner $banner */
        $banner = $em->getRepository(Banner::class)->find($id);

        if (!$banner) {
            throw $this->createNotFoundException('Banner not found');
        }

        $bannerData = new BannerData($banner);
        $form = $this->createForm(BannerType::class, $bannerData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $banner
                ->setStatus($bannerData->status)
                ->setMobileBackgroundColor($bannerData->mobileBackgroundColor)
                ->setCoverPosition($bannerData->coverPosition);

            /** @var BannerLang $bannerLang */
            foreach ($banner->getBannerLangs() as $bannerLang) {
                $bannerLang->setTitle($bannerData->title[$bannerLang->getLang()->getId()]);
                $bannerLang->setSubTitle($bannerData->subTitle[$bannerLang->getLang()->getId()]);
                $bannerLang->setCta($bannerData->cta[$bannerLang->getLang()->getId()]);
                $bannerLang->setFlag($bannerData->flag[$bannerLang->getLang()->getId()]);
                $bannerLang->setDescription($bannerData->description[$bannerLang->getLang()->getId()]);
                $em->persist($bannerLang);
            }

            if ($bannerData->imageFile instanceof UploadedFile) {
                $uploader = $this->get('mp.module.mpbanner.uploader.banner_image');

                if ($filename = $uploader->upload($banner->getId(), $bannerData->imageFile)) {
                    if ($banner->getFilename()) {
                        unlink(MpBanner::getImagesDir() . '/' . $banner->getFilename());
                    }

                    $banner->setFilename($filename);
                }
            }

            if ($bannerData->coverImageFile instanceof UploadedFile) {
                $uploader = $this->get('mp.module.mpbanner.uploader.banner_image');

                if ($coverFilename = $uploader->upload($banner->getId(), $bannerData->coverImageFile)) {
                    if ($banner->getCoverFilename()) {
                        unlink(MpBanner::getImagesDir() . '/' . $banner->getCoverFilename());
                    }

                    $banner->setCoverFilename($coverFilename);
                }
            }

            if ($bannerData->mobileImageFile instanceof UploadedFile) {
                $uploader = $this->get('mp.module.mpbanner.uploader.banner_image');

                if ($mobileFilename = $uploader->upload($banner->getId(), $bannerData->mobileImageFile)) {
                    if ($banner->getMobileFilename()) {
                        unlink(MpBanner::getImagesDir() . '/' . $banner->getMobileFilename());
                    }

                    $banner->setMobileFilename($mobileFilename);
                }
            }

            $em->persist($banner);
            $em->flush();

            $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

            return $this->redirectToRoute('admin_mpbanner_list');
        }

        return $this->render('@Modules/mpbanner/templates/admin/banner_form.html.twig', [
            'form' => $form->createView(),
            'layoutTitle' => $this->trans('Banners', 'Modules.Mpbanner.Admin'),
            'bannerImage' => ($banner->getFilename() ? $banner->getImagePath() : ''),
            'bannerImageMobile' => ($banner->getMobileFilename() ? $banner->getMobileImagePath() : ''),
        ]);
    }
}
