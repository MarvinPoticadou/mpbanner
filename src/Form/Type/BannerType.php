<?php

namespace Mp\Module\MpBanner\Form\Type;

use Mp\Module\MpBanner\Form\Model\BannerData;
use PrestaShop\PrestaShop\Core\ConstraintValidator\Constraints\CleanHtml;
use PrestaShopBundle\Form\Admin\Type\FormattedTextareaType;
use PrestaShopBundle\Form\Admin\Type\SwitchType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use PrestaShopBundle\Form\Admin\Type\TranslateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BannerType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TranslateType::class, [
                'type' => FormattedTextareaType::class,
                'locales' => $this->locales,
                'hideTabs' => false,
                'required' => false,
                'label' => $this->trans('Title', 'Modules.Mpbanner.Admin'),
                'options' => [
                    'constraints' => [
                        new CleanHtml([
                            'message' => $this->trans('This field is invalid', 'Admin.Notifications.Error'),
                        ]),
                    ],
                ], ])
            ->add('subTitle', TranslateType::class, [
                'type' => TextType::class,
                'locales' => $this->locales,
                'hideTabs' => false,
                'required' => false,
                'label' => $this->trans('Sub title', 'Modules.Mpbanner.Admin'),
                'options' => [
                    'constraints' => [
                        new CleanHtml([
                            'message' => $this->trans('This field is invalid', 'Admin.Notifications.Error'),
                        ]),
                    ],
                ], ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => $this->trans('Image', 'Modules.Mpbanner.Admin'),
            ])
            ->add('coverImageFile', FileType::class, [
                'required' => false,
                'label' => $this->trans('Cover image', 'Modules.Mpbanner.Admin'),
            ])
            ->add('coverPosition', ChoiceType::class, [
                'choices' => [
                    'Gauche' => 0,
                    'Droite' => 1,
                ],
                'expanded' => true
            ])
            ->add('mobileImageFile', FileType::class, [
                'required' => false,
                'label' => $this->trans('Mobile image', 'Modules.Mpbanner.Admin'),
            ])
            ->add('mobileBackgroundColor', ColorType::class, [
                'required' => false,
                'label' => $this->trans('Mobile background color', 'Modules.Mpbanner.Admin')
            ])
            ->add('url', UrlType::class, [
                'required' => false,
                'label' => $this->trans('URL', 'Modules.Mpbanner.Admin'),
            ])
            ->add('cta', TranslateType::class, [
                'type' => TextType::class,
                'locales' => $this->locales,
                'hideTabs' => false,
                'required' => false,
                'label' => $this->trans('CTA', 'Modules.Mpbanner.Admin'),
                'options' => [
                    'constraints' => [
                        new CleanHtml([
                            'message' => $this->trans('This field is invalid', 'Admin.Notifications.Error'),
                        ]),
                    ],
                ], ])
            ->add('flag', TranslateType::class, [
                'type' => TextType::class,
                'locales' => $this->locales,
                'hideTabs' => false,
                'required' => false,
                'label' => $this->trans('Flag', 'Modules.Mpbanner.Admin'),
                'options' => [
                    'constraints' => [
                        new CleanHtml([
                            'message' => $this->trans('This field is invalid', 'Admin.Notifications.Error'),
                        ]),
                    ],
                ], ])
            ->add('description', TranslateType::class, [
                'type' => FormattedTextareaType::class,
                'locales' => $this->locales,
                'hideTabs' => false,
                'required' => false,
                'label' => $this->trans('Description', 'Modules.Mpbanner.Admin'),
                'options' => [
                    'constraints' => [
                        new CleanHtml([
                            'message' => $this->trans('This field is invalid', 'Admin.Notifications.Error'),
                        ]),
                    ],
                ], ])
            ->add('status', SwitchType::class, [
                'choices' => [
                    'Disabled' => 0,
                    'Enabled' => 1,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BannerData::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'module_mpbanner';
    }
}
