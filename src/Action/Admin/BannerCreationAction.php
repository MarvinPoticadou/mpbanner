<?php


namespace Mp\Module\MpBanner\Action\Admin;


use Mp\Module\MpBanner\Entity\Banner;
use Mp\Module\MpBanner\Entity\BannerLang;
use Mp\Module\MpBanner\Form\Model\BannerData;
use Mp\Module\MpBanner\Form\Type\BannerType;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BannerCreationAction extends FrameworkBundleAdminController
{
    public function __invoke(Request $request): Response
    {
        $bannerData = new BannerData();
        $form = $this->createForm(BannerType::class, $bannerData);
        $form->handleRequest($request);
        $langRepository = $this->container->get('prestashop.core.admin.lang.repository');

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $banner = (new Banner())
                ->setPosition($this->computePosition())
                ->setStatus($bannerData->status)
                ->setUrl($bannerData->url)
                ->setMobileBackgroundColor($bannerData->mobileBackgroundColor)
                ->setCoverPosition($bannerData->coverPosition);

            foreach ($bannerData->title as $key => $title) {
                $lang = $langRepository->find($key);
                $bannerLang = (new BannerLang())
                    ->setLang($lang)
                    ->setTitle($bannerData->title[$key])
                    ->setSubTitle($bannerData->subTitle[$key])
                    ->setCta($bannerData->cta[$key])
                    ->setFlag($bannerData->flag[$key])
                    ->setDescription($bannerData->description[$key])
                    ->setBanner($banner);
                $banner->addBannerLangs($bannerLang);
            }

            if ($bannerData->imageFile instanceof UploadedFile) {
                $uploader = $this->get('mp.module.mpbanner.uploader.banner_image');

                $filename = $uploader->upload(null, $bannerData->imageFile);
                $banner->setFilename($filename);
            }

            if ($bannerData->coverImageFile instanceof UploadedFile) {
                $uploader = $this->get('mp.module.mpbanner.uploader.banner_image');

                $coverFilename = $uploader->upload(null, $bannerData->coverImageFile);
                $banner->setCoverFilename($coverFilename);
            }

            if ($bannerData->mobileImageFile instanceof UploadedFile) {
                $uploader = $this->get('mp.module.mpbanner.uploader.banner_image');

                $mobileFilename = $uploader->upload(null, $bannerData->mobileImageFile);
                $banner->setMobileFilename($mobileFilename);
            }

            $em->persist($banner);
            $em->flush();

            $this->addFlash('success', $this->trans('Successful creation.', 'Admin.Notifications.Success'));

            return $this->redirectToRoute('admin_mpbanner_list');
        }

        return $this->render('@Modules/mpbanner/templates/admin/banner_form.html.twig', [
            'form' => $form->createView(),
            'layoutTitle' => $this->trans('Advanced Banners', 'Modules.Mpbanner.Admin'),
        ]);
    }

    private function computePosition(): int
    {
        $banners = $this->getDoctrine()->getManager()->getRepository(Banner::class)->findAll();

        $position = 0;
        foreach ($banners as $banner) {
            if ($banner->getPosition() >= $position) {
                $position = $banner->getPosition() + 1;
            }
        }

        return $position;
    }
}
