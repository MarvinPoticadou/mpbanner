{if $banners}
  <div class="home-top-slider carousel-desktop carousel-top-desktop visible--desktop">
    <div id="carousel" class="carousel slick__arrow-large" {if $banners|count > 1}data-slick='{strip}
            {ldelim}
            "autoplay": false,
            "dots": false,
            "slidesToShow": 1,
            "slidesToScroll": 1,
            "autoplaySpeed": 5000
            {rdelim}
            {/strip}'{/if}>

        {foreach $banners as $banner}
          {assign var=bannerLang value=$banner->getBannerLangByLangId($lang) }
          <div class="rc" style="padding-top:{$banner->getPaddingBottom()}%;">
            <img src="{$banner->getImagePath()}" class="w-100 img-carousel lazyload" alt="{$banner->getFilename()|escape}">
            <noscript>
              <img src="{$banner->getImagePath()}" alt="{$banner->getFilename()|escape}" class="w-100 img-carousel">
            </noscript>
            {if $banner->getCoverImagePath() || $bannerLang->getTitle()}
              <div class="slider-caption {if $banner->getCoverPosition()}right{else}left{/if}">
                {if $banner->getCoverImagePath()}
                  <img src="{$banner->getCoverImagePath()}" class="w-100 img-carousel lazyload" alt="{$banner->getCoverFilename()|escape}">
                  <noscript>
                    <img src="{$banner->getCoverImagePath()}" alt="{$banner->getCoverFilename()|escape}" class="w-100 img-carousel">
                  </noscript>
                {/if}
                {if $bannerLang->getTitle() || $bannerLang->getSubTitle() || $bannerLang->getDescription()}
                  <div class="slider-text-container">
                    {if $bannerLang->getFlag()}
                      <div class="slider-flag px-3">
                        {$bannerLang->getFlag()|nl2br nofilter}
                      </div>
                    {/if}
                    {if $bannerLang->getTitle()}
                      <div class="slider-title px-3">
                        {$bannerLang->getTitle()|nl2br nofilter}
                      </div>
                    {/if}
                    {if $bannerLang->getSubTitle()}
                      <p class="slider-subtitle px-3">
                        {$bannerLang->getSubtitle()}
                          <br>
                        <span>{$bannerLang->getDescription()|htmlspecialchars_decode|strip_tags}</span>
                      </p>
                    {/if}
                    {if $banner->getUrl()}
                      <div class="slider-btn">
                        <a class="btn btn-copper" href="{$banner->getUrl()}">{$bannerLang->getCta()|escape}</a>
                      </div>
                    {/if}
                  </div>
                {/if}
              </div>
            {/if}
          </div>
        {/foreach}
    </div>
  </div>
  <div class="home-top-slider carousel-mobile carousel-top-mobile visible--mobile">
    <div class="carousel slick__arrow-large" {if $banners|count > 1}data-slick='{strip}
            {ldelim}
                "autoplay": true,
                "slidesToShow": 1,
                "dots": false,
                "arrows": false,
                "slidesToScroll": 1,
                "autoplaySpeed": 5000
            {rdelim}{/strip}'{/if}>

        {foreach $banners as $banner}
          {assign var=bannerLang value=$banner->getBannerLangByLangId($lang) }
          <div style="position: relative;background-color: {$banner->getMobileBackgroundColor()}; min-height: 1px; height: 100%;">
            <img class="img-carousel" src="{$banner->getMobileImagePath()}" alt="{$bannerLang->getTitle()|escape}" width="100%" />
            <div class="slider-caption slider-content-mobile">
                {if $banner->getCoverImagePath()}
                    <img src="{$banner->getCoverImagePath()}" class="img-carousel lazyload ml-2 {if $bannerLang->getDescription()}has-description{/if}" alt="{$banner->getCoverFilename()|escape}" width="40%">
                    <noscript>
                        <img src="{$banner->getCoverImagePath()}" alt="{$banner->getCoverFilename()|escape}" class="w-100 img-carousel {if $bannerLang->getDescription()}has-description{/if}">
                    </noscript>
                {/if}
                {if $bannerLang->getTitle() || $bannerLang->getSubTitle() || $bannerLang->getDescription()}
                    <div class="slider-text-container">
                        {if $bannerLang->getFlag()}
                            <div class="slider-flag px-3 text-right">
                                {$bannerLang->getFlag()|nl2br nofilter}
                            </div>
                        {/if}
                        {if $bannerLang->getTitle()}
                            <div class="slider-title px-3 text-right">
                                {$bannerLang->getTitle()|nl2br nofilter}
                            </div>
                        {/if}
                        {if $bannerLang->getSubTitle()}
                            <p class="slider-subtitle px-3 py-2 m-0 text-right">
                                {$bannerLang->getSubTitle()|nl2br nofilter}
                                <br>
                                <span>{$bannerLang->getDescription()|htmlspecialchars_decode|strip_tags}</span>
                            </p>
                        {/if}
                        {if $banner->getUrl() && $bannerLang->getCta()}
                            <div class="slider-btn">
                                <a class="btn btn-copper" href="{$banner->getUrl()}">{$bannerLang->getCta()|escape}</a>
                            </div>
                        {/if}
                    </div>
                {/if}
            </div>
          </div>
        {/foreach}
    </div>
  </div>
{/if}
