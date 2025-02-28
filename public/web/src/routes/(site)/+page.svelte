<!-- <svelte:head>
  <title>Home - My Website</title>
</svelte:head> -->
  <script>
    let settings = JSON.stringify({ background_background: "classic" });
    let dataOptions = JSON.stringify({
        slidesPerView: "1",
        spaceBetween: 30,
        loop: false,
        autoplay: false,
        speed: "",
        speedAnimation: "",
        slideAnimation: "",
        outsideNavigation: "yes",
        unique: 886
    });
    let shortcode = "blog-list";
    let teamOptions = JSON.stringify({
        plugin: "globefarer_core",
        module: "post-types/team/shortcodes",
        shortcode: "team-list",
        post_type: "team",
        next_page: "2",
        max_pages_num: 1,
        behavior: "columns",
        images_proportion: "full",
        columns: "4",
        columns_responsive: "custom",
        columns_1440: "4",
        columns_1366: "4",
        columns_1024: "2",
        columns_768: "2",
        columns_680: "1",
        columns_480: "1",
        space: "medium",
        posts_per_page: "4",
        orderby: "date",
        order: "ASC",
        additional_params: "tax",
        tax: "team-category",
        tax_slug: "main home",
        layout: "info-on-side",
        title_tag: "h4",
        pagination_type: "no-pagination",
        object_class_name: "GlobeFarerCore_Team_List_Shortcode",
        taxonomy_filter: "team-category",
        additional_query_args: {
            tax_query: [
                {
                    taxonomy: "team-category",
                    field: "slug",
                    terms: "main home"
                }
            ]
        },
        item_classes: "qodef-e qodef-grid-item ",
        has_single: true,
        space_value: 20
    });
    let blogOptions = JSON.stringify({
        plugin: "globefarer_core",
        module: "blog/shortcodes",
        shortcode: "blog-list",
        post_type: "post",
        next_page: "2",
        max_pages_num: 1,
        behavior: "columns",
        images_proportion: "full",
        columns: "3",
        columns_responsive: "custom",
        columns_1440: "3",
        columns_1366: "3",
        columns_1024: "1",
        columns_768: "1",
        columns_680: "1",
        columns_480: "1",
        space: "medium",
        posts_per_page: "3",
        orderby: "date",
        order: "ASC",
        additional_params: "tax",
        tax: "category",
        tax_slug: "Agriculture",
        layout: "divided-compact",
        title_tag: "h4",
        excerpt_length: "72",
        button_text: "Read more",
        hover_animation: "yes",
        pagination_type: "no-pagination",
        object_class_name: "GlobeFarerCore_Blog_List_Shortcode",
        taxonomy_filter: "category",
        additional_query_args: {
            tax_query: [
                {
                    taxonomy: "category",
                    field: "slug",
                    terms: "Agriculture"
                }
            ]
        },
        space_value: 20
    });
</script>

<div id="qodef-page-inner" class="qodef-content-full-width">
    <main
      id="qodef-page-content"
      class="qodef-grid qodef-layout--template"
      role="main"
    >
      <div class="qodef-grid-inner clear">
        <div
          class="qodef-grid-item qodef-page-content-section qodef-col--12"
        >
          <div
            data-elementor-type="wp-page"
            data-elementor-id="50"
            class="elementor elementor-50"
            data-elementor-post-type="page"
          >
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-308763f elementor-section-full_width elementor-section-height-default elementor-section-height-default qodef-elementor-content-no"
              data-id="308763f"
              data-element_type="section"
              data-settings={settings}
            >
              <div class="elementor-container elementor-column-gap-no">
                <div
                  class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-dd8860a"
                  data-id="dd8860a"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-94b398f elementor-widget elementor-widget-slider_revolution"
                      data-id="94b398f"
                      data-element_type="widget"
                      data-widget_type="slider_revolution.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="wp-block-themepunch-revslider">
                          <!-- START Main Home REVOLUTION SLIDER 6.6.13 -->
                          <p class="rs-p-wp-fix"></p>
                          <rs-module-wrap
                            id="rev_slider_1_1_wrapper"
                            data-source="gallery"
                            style="
                              visibility: hidden;
                              background: transparent;
                              padding: 0;
                            "
                          >
                            <rs-module
                              id="rev_slider_1_1"
                              style=""
                              data-version="6.6.13"
                            >
                              <rs-slides
                                style="
                                  overflow: hidden;
                                  position: absolute;
                                "
                              >
                                <rs-slide
                                  style="position: absolute"
                                  data-key="rs-1"
                                  data-title="Slide"
                                  data-thumb="wp-content/uploads/revslider/main-home/main-home-rev-slide-1-1.jpg"
                                  data-in="o:0;"
                                  data-out="a:false;"
                                  data-p1="Ocean Freight"
                                >
                                  <img
                                    fetchpriority="high"                                  
                                    decoding="async"
                                    src="web/wp-content/plugins/revslider/public/assets/assets/dummy.png"
                                    alt=""
                                    title="main-home-rev-slide-1-1.jpg"
                                    width="1920"
                                    height="1100"
                                    class="rev-slidebg tp-rs-img rs-lazyload"
                                    data-lazyload="wp-content/uploads/revslider/main-home/main-home-rev-slide-1-1.jpg"
                                    data-bg="p:center bottom;"
                                    data-no-retina
                                  />
                                  <!--
                      --><rs-layer
                                    id="slider-1-slide-1-layer-1"
                                    data-type="text"
                                    data-xy="x:c;xo:342px,288px,0,0;y:m;yo:-20px,-32px,75px,53px;"
                                    data-text="w:normal;s:65,60,60,44;l:72,67,67,51;ls:-1px;fw:700;a:left,left,center,center;"
                                    data-dim="w:585px,540px,540px,290px;h:225px,210px,210px,210px;"
                                    data-basealign="slide"
                                    data-rsp_o="off"
                                    data-rsp_bd="off"
                                    data-frame_0="x:50;"
                                    data-frame_1="e:power4.inOut;st:250;sp:1000;"
                                    data-frame_999="o:0;st:w;"
                                    style="
                                      z-index: 6;
                                      font-family: 'Poppins';
                                    "
                                    >Worldwide shipping and professional
                                    solutions </rs-layer
                                  ><rs-layer
                                    id="slider-1-slide-1-layer-2"
                                    data-type="text"
                                    data-xy="x:c;xo:350px,293px,0,0;y:m;yo:128px,108px,215px,205px;"
                                    data-text="w:normal;s:18;l:26;a:left,left,center,center;"
                                    data-dim="w:600px,550px,550px,290px;"
                                    data-basealign="slide"
                                    data-rsp_o="off"
                                    data-rsp_bd="off"
                                    data-frame_0="x:50;"
                                    data-frame_1="e:power4.inOut;st:320;sp:1000;"
                                    data-frame_999="o:0;st:w;"
                                    style="
                                      z-index: 7;
                                      font-family: 'Poppins';
                                    "
                                    >No matter the location we got you
                                    covered with our global shipping! </rs-layer
                                  >
-->
                                </rs-slide>
                                <rs-slide
                                  style="position: absolute"
                                  data-key="rs-2"
                                  data-title="Slide"
                                  data-thumb="wp-content/uploads/revslider/main-home/main-home-rev-slide-2.jpg"
                                  data-in="o:0;"
                                  data-out="a:false;"
                                  data-p1="Land Transport"
                                >
                                  <img
                                    decoding="async"
                                    src="web/wp-content/plugins/revslider/public/assets/assets/dummy.png"
                                    alt=""
                                    title="main-home-rev-slide-2.jpg"
                                    width="1920"
                                    height="1100"
                                    class="rev-slidebg tp-rs-img rs-lazyload"
                                    data-lazyload="wp-content/uploads/revslider/main-home/main-home-rev-slide-2.jpg"
                                    data-bg="p:center bottom;"
                                    data-no-retina
                                  />
                                  <!--
                      --><rs-layer
                                    id="slider-1-slide-2-layer-1"
                                    data-type="text"
                                    data-xy="x:c;xo:342px,288px,0,0;y:m;yo:-20px,-32px,75px,54px;"
                                    data-text="w:normal;s:65,60,60,44;l:72,67,67,51;ls:-1px;fw:700;a:left,left,center,center;"
                                    data-dim="w:585px,540px,540px,290px;h:225px,210px,210px,210px;"
                                    data-basealign="slide"
                                    data-rsp_o="off"
                                    data-rsp_bd="off"
                                    data-frame_0="x:50;"
                                    data-frame_1="e:power4.inOut;st:250;sp:1000;"
                                    data-frame_999="o:0;st:w;"
                                    style="
                                      z-index: 6;
                                      font-family: 'Poppins';
                                    "
                                    >Fast and secure courier for all your
                                    packages </rs-layer
                                  ><!--

                      --><rs-layer
                                    id="slider-1-slide-2-layer-2"
                                    data-type="text"
                                    data-xy="x:c;xo:350px,293px,0,0;y:m;yo:128px,108px,215px,205px;"
                                    data-text="w:normal;s:18;l:26;a:left,left,center,center;"
                                    data-dim="w:600px,550px,550px,290px;"
                                    data-basealign="slide"
                                    data-rsp_o="off"
                                    data-rsp_bd="off"
                                    data-frame_0="x:50;"
                                    data-frame_1="e:power4.inOut;st:320;sp:1000;"
                                    data-frame_999="o:0;st:w;"
                                    style="
                                      z-index: 7;
                                      font-family: 'Poppins';
                                    "
                                    >Your packages will not be damaged
                                    with our expert courier services. 
                                    
                                    </rs-layer><!--
-->                                                         <button class="" type="submit">
                                      <span class="qodef-m-button-icon"><svg class="qodef-svg--plus" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14" height="14" viewBox="0 0 14 14">
                                        <path class="qodef-m-horizontal" d="M0,0H14V2H0Z" transform="translate(0 6)"></path>
                                        <path class="qodef-m-vertical" d="M0,0H2V14H0Z" transform="translate(6)"></path></svg></span><span class="qodef-m-button-text">Track &amp; Trace</span>
                                  </button>

                                </rs-slide>
                                <rs-slide
                                  style="position: absolute"
                                  data-key="rs-3"
                                  data-title="Slide"
                                  data-thumb="wp-content/uploads/revslider/main-home/main-home-rev-slide-3.jpg"
                                  data-in="o:0;"
                                  data-out="a:false;"
                                  data-p1="Air Freight"
                                >
                                  <img
                                    decoding="async"
                                    src="web/wp-content/plugins/revslider/public/assets/assets/dummy.png"
                                    alt=""
                                    title="main-home-rev-slide-3.jpg"
                                    width="1920"
                                    height="1100"
                                    class="rev-slidebg tp-rs-img rs-lazyload"
                                    data-lazyload="wp-content/uploads/revslider/main-home/main-home-rev-slide-3.jpg"
                                    data-bg="p:center bottom;"
                                    data-no-retina
                                  />
                                  <!--
                      --><rs-layer
                                    id="slider-1-slide-3-layer-1"
                                    data-type="text"
                                    data-xy="x:c;xo:342px,288px,0,0;y:m;yo:-20px,-32px,75px,53px;"
                                    data-text="w:normal;s:65,60,60,44;l:72,67,67,51;ls:-1px;fw:700;a:left,left,center,center;"
                                    data-dim="w:585px,540px,540px,300px;h:225px,210px,210px,210px;"
                                    data-basealign="slide"
                                    data-rsp_o="off"
                                    data-rsp_bd="off"
                                    data-frame_0="x:50;"
                                    data-frame_1="e:power4.inOut;st:250;sp:1000;"
                                    data-frame_999="o:0;st:w;"
                                    style="
                                      z-index: 6;
                                      font-family: 'Poppins';
                                    "
                                    >We provide super-fast and fuss-free
                                    delivery service </rs-layer
                                  ><!--

                      --><rs-layer
                                    id="slider-1-slide-3-layer-2"
                                    data-type="text"
                                    data-xy="x:c;xo:350px,293px,0,0;y:m;yo:128px,108px,215px,205px;"
                                    data-text="w:normal;s:18;l:26;a:left,left,center,center;"
                                    data-dim="w:600px,550px,550px,290px;"
                                    data-basealign="slide"
                                    data-rsp_o="off"
                                    data-rsp_bd="off"
                                    data-frame_0="x:50;"
                                    data-frame_1="e:power4.inOut;st:320;sp:1000;"
                                    data-frame_999="o:0;st:w;"
                                    style="
                                      z-index: 7;
                                      font-family: 'Poppins';
                                    "
                                    >We guarantee no complications and
                                    full refunds in case of damages. </rs-layer
                                  ><!--
-->
                                </rs-slide>
                                <rs-slide
                                  style="position: absolute"
                                  data-key="rs-4"
                                  data-title="Slide"
                                  data-thumb="wp-content/uploads/revslider/main-home/main-home-rev-slide-4.jpg"
                                  data-in="o:0;"
                                  data-out="a:false;"
                                  data-p1="Warehousing"
                                >
                                  <img
                                    
                                    loading="lazy"
                                    decoding="async"
                                    src="web/wp-content/plugins/revslider/public/assets/assets/dummy.png"
                                    alt=""
                                    title="main-home-rev-slide-4.jpg"
                                    width="1920"
                                    height="1100"
                                    class="rev-slidebg tp-rs-img rs-lazyload"
                                    data-lazyload="wp-content/uploads/revslider/main-home/main-home-rev-slide-4.jpg"
                                    data-bg="p:center bottom;"
                                    data-no-retina
                                  />
                                  <!--
                      --><rs-layer
                                    id="slider-1-slide-4-layer-1"
                                    data-type="text"
                                    data-xy="x:c;xo:342px,288px,0,0;y:m;yo:-20px,-32px,75px,53px;"
                                    data-text="w:normal;s:65,60,60,44;l:72,67,67,51;ls:-1px;fw:700;a:left,left,center,center;"
                                    data-dim="w:585px,540px,540px,290px;h:225px,210px,210px,210px;"
                                    data-basealign="slide"
                                    data-rsp_o="off"
                                    data-rsp_bd="off"
                                    data-frame_0="x:50;"
                                    data-frame_1="e:power4.inOut;st:250;sp:1000;"
                                    data-frame_999="o:0;st:w;"
                                    style="
                                      z-index: 6;
                                      font-family: 'Poppins';
                                    "
                                    >Always stay ahead of schedule with
                                    Newworld Cargo </rs-layer
                                  ><!--

                      --><rs-layer
                                    id="slider-1-slide-4-layer-2"
                                    data-type="text"
                                    data-xy="x:c;xo:350px,293px,0,0;y:m;yo:128px,108px,215px,205px;"
                                    data-text="w:normal;s:18;l:26;a:left,left,center,center;"
                                    data-dim="w:600px,550px,550px,290px;"
                                    data-basealign="slide"
                                    data-rsp_o="off"
                                    data-rsp_bd="off"
                                    data-frame_0="x:50;"
                                    data-frame_1="e:power4.inOut;st:320;sp:1000;"
                                    data-frame_999="o:0;st:w;"
                                    style="
                                      z-index: 7;
                                      font-family: 'Poppins';
                                    "
                                    >Cost efficient & always on time,
                                    that’s our transport company moto! </rs-layer
                                  ><!--
-->
                                </rs-slide>
                              </rs-slides>
                              <rs-static-layers
                                ><!--

                      --><!--
              --></rs-static-layers
                              >
                            </rs-module>
                            <script>
                              setREVStartSize({
                                c: "rev_slider_1_1",
                                rl: [1240, 1024, 778, 480],
                                el: [900, 768, 960, 720],
                                gw: [1400, 1100, 600, 300],
                                gh: [900, 768, 960, 720],
                                type: "standard",
                                justify: "",
                                layout: "fullscreen",
                                offsetContainer: "",
                                offset: "",
                                mh: "0",
                              });
                              if (
                                window.RS_MODULES !== undefined &&
                                window.RS_MODULES.modules !== undefined &&
                                window.RS_MODULES.modules[
                                  "revslider11"
                                ] !== undefined
                              ) {
                                window.RS_MODULES.modules[
                                  "revslider11"
                                ].once = false;
                                window.revapi1 = undefined;
                                if (
                                  window.RS_MODULES.checkMinimal !==
                                  undefined
                                )
                                  window.RS_MODULES.checkMinimal();
                              }
                            </script>
                          </rs-module-wrap>
                          <!-- END REVOLUTION SLIDER -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
                              class="elementor-section elementor-top-section elementor-element elementor-element-1e0c9ff elementor-section-full_width elementor-section-height-default elementor-section-height-default qodef-elementor-content-no"
                              data-id="1e0c9ff" data-element_type="section"
                              data-settings={settings}>
                              <div class="elementor-container elementor-column-gap-no">
                                  <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-3c100a0"
                                      data-id="3c100a0" data-element_type="column">
                                      <div class="elementor-widget-wrap elementor-element-populated">
                                          <div class="elementor-element elementor-element-0fa4b25 elementor-widget elementor-widget-slider_revolution"
                                              data-id="0fa4b25" data-element_type="widget"
                                              data-widget_type="slider_revolution.default">
                                              <div class="elementor-widget-container">

                      tracking sections
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </section> 
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-e405538 elementor-section-full_width qodef-elementor-content-grid elementor-section-height-default elementor-section-height-default"
              data-id="e405538"
              data-element_type="section"
              data-settings={settings}
            >
              <div class="elementor-container elementor-column-gap-no">
                <div
                  class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-4041d44"
                  data-id="4041d44"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-4a768dd elementor-widget elementor-widget-globefarer_core_divided_image_info"
                      data-id="4a768dd"
                      data-element_type="widget"
                      data-widget_type="globefarer_core_divided_image_info.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="qodef-shortcode qodef-m qodef-divided-image-info qodef-layout--image-right qodef-separator--on qodef-breakpoint--1024 qodef-appear-animation--yes qodef-appear-animation-type--roll-out"
                        >
                          <div
                            class="qodef-m-content"
                            style="
                              margin-top: 10px;
                              padding-left: 0px;
                              padding-right: 4%;
                            "
                          >
                            <h2
                              itemprop="name"
                              class="qodef-m-title"
                              style="margin-bottom: 29px"
                            >
                              Fast and reliable shipping services
                            </h2>
                            <p class="qodef-m-text">
                              Lorem ipsum dolor sit amet, et sale ad mutat
                              nusqua ius ea has autem aeterno divine sum.
                            </p>
                            <a
                              class="qodef-shortcode qodef-m qodef-m-button qodef-button qodef-layout--textual qodef-html--link"
                              href="https://globefarer.qodeinteractive.com/our-services/"
                              target="_self"
                            >
                              <span class="qodef-m-button-icon"
                                ><svg
                                  class="qodef-svg--plus"
                                  xmlns="http://www.w3.org/2000/svg"
                                  xmlns:xlink="http://www.w3.org/1999/xlink"
                                  width="14"
                                  height="14"
                                  viewBox="0 0 14 14"
                                >
                                  <path
                                    class="qodef-m-horizontal"
                                    d="M0,0H14V2H0Z"
                                    transform="translate(0 6)"
                                  />
                                  <path
                                    class="qodef-m-vertical"
                                    d="M0,0H2V14H0Z"
                                    transform="translate(6)"
                                  /></svg
                              ></span>
                              <span class="qodef-m-button-text"
                                >View more<br />
                                about our services
                              </span>
                            </a>
                          </div>
                          <div
                            class="qodef-m-image"
                            style="
                              width: 63%;
                              padding-left: 5.8%;
                              padding-right: 0px;
                            "
                          >
                            <img
                              loading="lazy"
                              decoding="async"
                              width="800"
                              height="407"
                              src="web/wp-content/uploads/2021/08/main-home-img-1-1.jpg"
                              class="attachment-full size-full"
                              alt="d"
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-b4bccbe elementor-section-full_width qodef-elementor-content-grid elementor-section-height-default elementor-section-height-default"
              data-id="b4bccbe"
              data-element_type="section"
            >
              <div class="elementor-container elementor-column-gap-no">
                <div
                  class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-bd4adc0"
                  data-id="bd4adc0"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-db3b23a elementor-widget elementor-widget-globefarer_core_tabbed_info"
                      data-id="db3b23a"
                      data-element_type="widget"
                      data-widget_type="globefarer_core_tabbed_info.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="qodef-shortcode qodef-m qodef-tabbed-info qodef-layout--standard"
                        >
                          <ul class="qodef-m-navigation">
                            <li>
                              <a href="qodef-tab--93b2e5e.html">
                                Air Freight
                              </a>
                            </li>
                            <li>
                              <a href="qodef-tab--88e6bad.html">
                                Rail Freight
                              </a>
                            </li>
                            <li>
                              <a href="qodef-tab--08887a2.html">
                                LTL Freight
                              </a>
                            </li>
                            <li>
                              <a href="qodef-tab--89ebe54.html">
                                Sea Freight
                              </a>
                            </li>
                            <li>
                              <a href="qodef-tab--ecdb426.html">
                                Land Freight
                              </a>
                            </li>
                            <li>
                              <a href="qodef-tab--0567851.html">
                                Warehousing
                              </a>
                            </li>
                          </ul>
                          <div
                            class="qodef-m-content"
                            id="qodef-tab--93b2e5e"
                          >
                            <div class="qodef-m-content-left">
                              <div class="qodef-m-image">
                                <img
                                  loading="lazy"
                                  decoding="async"
                                  width="800"
                                  height="425"
                                  src="web/wp-content/uploads/2021/08/main-home-tabbed-info-1-1.png"
                                  class="attachment-full size-full"
                                  alt="m"
                                />
                              </div>
                            </div>
                            <div class="qodef-m-content-right">
                              <h2 class="qodef-m-title">
                                Secure courier for small &amp; big
                                packages
                              </h2>
                              <p class="qodef-m-text">
                                Lorem ipsum dolor sit amet, id has nihil
                                discere vocibus. No novum cu labor
                                probatus cum, te utamur scripta ei legat
                                cum qui ei sapere quo noster sum periculis
                                ad.
                              </p>
                              <a
                                class="qodef-shortcode qodef-m qodef-m-button qodef-button qodef-layout--textual qodef-html--link"
                                href="https://globefarer.qodeinteractive.com/our-services/"
                                target="_self"
                              >
                                <span class="qodef-m-button-icon"
                                  ><svg
                                    class="qodef-svg--plus"
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="14"
                                    height="14"
                                    viewBox="0 0 14 14"
                                  >
                                    <path
                                      class="qodef-m-horizontal"
                                      d="M0,0H14V2H0Z"
                                      transform="translate(0 6)"
                                    />
                                    <path
                                      class="qodef-m-vertical"
                                      d="M0,0H2V14H0Z"
                                      transform="translate(6)"
                                    /></svg
                                ></span>
                                <span class="qodef-m-button-text"
                                  >View more<br />
                                  about our services
                                </span>
                              </a>
                            </div>
                          </div>
                          <div
                            class="qodef-m-content"
                            id="qodef-tab--88e6bad"
                          >
                            <div class="qodef-m-content-left">
                              <div class="qodef-m-image">
                                <img
                                  loading="lazy"
                                  decoding="async"
                                  width="800"
                                  height="425"
                                  src="web/wp-content/uploads/2021/08/main-home-tabbed-info-2-1.jpg"
                                  class="attachment-full size-full"
                                  alt="m"
                                />
                              </div>
                            </div>
                            <div class="qodef-m-content-right">
                              <h2 class="qodef-m-title">
                                Great &amp; affordable courier transport
                              </h2>
                              <p class="qodef-m-text">
                                Lorem ipsum dolor sit amet, id has nihil
                                discere vocibus. No novum cu labor
                                probatus cum, te utamur scripta ei legat
                                cum qui ei sapere quo noster sum periculis
                                ad.
                              </p>
                              <a
                                class="qodef-shortcode qodef-m qodef-m-button qodef-button qodef-layout--textual qodef-html--link"
                                href="https://globefarer.qodeinteractive.com/what-we-do/"
                                target="_self"
                              >
                                <span class="qodef-m-button-icon"
                                  ><svg
                                    class="qodef-svg--plus"
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="14"
                                    height="14"
                                    viewBox="0 0 14 14"
                                  >
                                    <path
                                      class="qodef-m-horizontal"
                                      d="M0,0H14V2H0Z"
                                      transform="translate(0 6)"
                                    />
                                    <path
                                      class="qodef-m-vertical"
                                      d="M0,0H2V14H0Z"
                                      transform="translate(6)"
                                    /></svg
                                ></span>
                                <span class="qodef-m-button-text"
                                  >View more<br />
                                  about our services
                                </span>
                              </a>
                            </div>
                          </div>
                          <div
                            class="qodef-m-content"
                            id="qodef-tab--08887a2"
                          >
                            <div class="qodef-m-content-left">
                              <div class="qodef-m-image">
                                <img
                                  loading="lazy"
                                  decoding="async"
                                  width="800"
                                  height="425"
                                  src="web/wp-content/uploads/2021/08/main-home-tabbed-info-3-1.jpg"
                                  class="attachment-full size-full"
                                  alt="m"
                                />
                              </div>
                            </div>
                            <div class="qodef-m-content-right">
                              <h2 class="qodef-m-title">
                                Any location and any time we’ll be there
                              </h2>
                              <p class="qodef-m-text">
                                Lorem ipsum dolor sit amet, id has nihil
                                discere vocibus. No novum cu labor
                                probatus cum, te utamur scripta ei legat
                                cum qui ei sapere quo noster sum periculis
                                ad.
                              </p>
                              <a
                                class="qodef-shortcode qodef-m qodef-m-button qodef-button qodef-layout--textual qodef-html--link"
                                href="https://globefarer.qodeinteractive.com/step-1-3/"
                                target="_self"
                              >
                                <span class="qodef-m-button-icon"
                                  ><svg
                                    class="qodef-svg--plus"
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="14"
                                    height="14"
                                    viewBox="0 0 14 14"
                                  >
                                    <path
                                      class="qodef-m-horizontal"
                                      d="M0,0H14V2H0Z"
                                      transform="translate(0 6)"
                                    />
                                    <path
                                      class="qodef-m-vertical"
                                      d="M0,0H2V14H0Z"
                                      transform="translate(6)"
                                    /></svg
                                ></span>
                                <span class="qodef-m-button-text"
                                  >View more<br />
                                  about our services
                                </span>
                              </a>
                            </div>
                          </div>
                          <div
                            class="qodef-m-content"
                            id="qodef-tab--89ebe54"
                          >
                            <div class="qodef-m-content-left">
                              <div class="qodef-m-image">
                                <img
                                  loading="lazy"
                                  decoding="async"
                                  width="800"
                                  height="425"
                                  src="web/wp-content/uploads/2021/08/main-home-tabbed-info-4-1.jpg"
                                  class="attachment-full size-full"
                                  alt="m"
                                />
                              </div>
                            </div>
                            <div class="qodef-m-content-right">
                              <h2 class="qodef-m-title">
                                Quality packing material for items
                              </h2>
                              <p class="qodef-m-text">
                                Lorem ipsum dolor sit amet, id has nihil
                                discere vocibus. No novum cu labor
                                probatus cum, te utamur scripta ei legat
                                cum qui ei sapere quo noster sum periculis
                                ad.
                              </p>
                              <a
                                class="qodef-shortcode qodef-m qodef-m-button qodef-button qodef-layout--textual qodef-html--link"
                                href="https://globefarer.qodeinteractive.com/get-in-touch/"
                                target="_self"
                              >
                                <span class="qodef-m-button-icon"
                                  ><svg
                                    class="qodef-svg--plus"
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="14"
                                    height="14"
                                    viewBox="0 0 14 14"
                                  >
                                    <path
                                      class="qodef-m-horizontal"
                                      d="M0,0H14V2H0Z"
                                      transform="translate(0 6)"
                                    />
                                    <path
                                      class="qodef-m-vertical"
                                      d="M0,0H2V14H0Z"
                                      transform="translate(6)"
                                    /></svg
                                ></span>
                                <span class="qodef-m-button-text"
                                  >View more<br />
                                  about our services
                                </span>
                              </a>
                            </div>
                          </div>
                          <div
                            class="qodef-m-content"
                            id="qodef-tab--ecdb426"
                          >
                            <div class="qodef-m-content-left">
                              <div class="qodef-m-image">
                                <img
                                  loading="lazy"
                                  decoding="async"
                                  width="800"
                                  height="425"
                                  src="web/wp-content/uploads/2021/08/main-home-tabbed-info-5-1.jpg"
                                  class="attachment-full size-full"
                                  alt="m"
                                />
                              </div>
                            </div>
                            <div class="qodef-m-content-right">
                              <h2 class="qodef-m-title">
                                Easy &amp; fast on-spot payment methods
                              </h2>
                              <p class="qodef-m-text">
                                Lorem ipsum dolor sit amet, id has nihil
                                discere vocibus. No novum cu labor
                                probatus cum, te utamur scripta ei legat
                                cum qui ei sapere quo noster sum periculis
                                ad.
                              </p>
                              <a
                                class="qodef-shortcode qodef-m qodef-m-button qodef-button qodef-layout--textual qodef-html--link"
                                href="https://globefarer.qodeinteractive.com/global-network/"
                                target="_self"
                              >
                                <span class="qodef-m-button-icon"
                                  ><svg
                                    class="qodef-svg--plus"
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="14"
                                    height="14"
                                    viewBox="0 0 14 14"
                                  >
                                    <path
                                      class="qodef-m-horizontal"
                                      d="M0,0H14V2H0Z"
                                      transform="translate(0 6)"
                                    />
                                    <path
                                      class="qodef-m-vertical"
                                      d="M0,0H2V14H0Z"
                                      transform="translate(6)"
                                    /></svg
                                ></span>
                                <span class="qodef-m-button-text"
                                  >View more<br />
                                  about our services
                                </span>
                              </a>
                            </div>
                          </div>
                          <div
                            class="qodef-m-content"
                            id="qodef-tab--0567851"
                          >
                            <div class="qodef-m-content-left">
                              <div class="qodef-m-image">
                                <img
                                  loading="lazy"
                                  decoding="async"
                                  width="800"
                                  height="425"
                                  src="web/wp-content/uploads/2021/08/main-home-tabbed-info-6-1.jpg"
                                  class="attachment-full size-full"
                                  alt="m"
                                />
                              </div>
                            </div>
                            <div class="qodef-m-content-right">
                              <h2 class="qodef-m-title">
                                Our fleet covers your needs &amp; pricing
                                range
                              </h2>
                              <p class="qodef-m-text">
                                Lorem ipsum dolor sit amet, id has nihil
                                discere vocibus. No novum cu labor
                                probatus cum, te utamur scripta ei legat
                                cum qui ei sapere quo noster sum periculis
                                ad.
                              </p>
                              <a
                                class="qodef-shortcode qodef-m qodef-m-button qodef-button qodef-layout--textual qodef-html--link"
                                href="https://globefarer.qodeinteractive.com/about-us/"
                                target="_self"
                              >
                                <span class="qodef-m-button-icon"
                                  ><svg
                                    class="qodef-svg--plus"
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="14"
                                    height="14"
                                    viewBox="0 0 14 14"
                                  >
                                    <path
                                      class="qodef-m-horizontal"
                                      d="M0,0H14V2H0Z"
                                      transform="translate(0 6)"
                                    />
                                    <path
                                      class="qodef-m-vertical"
                                      d="M0,0H2V14H0Z"
                                      transform="translate(6)"
                                    /></svg
                                ></span>
                                <span class="qodef-m-button-text"
                                  >View more<br />
                                  about our services
                                </span>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-7b053dc elementor-section-full_width elementor-section-height-min-height elementor-section-content-middle qodef-elementor-content-grid elementor-section-height-default elementor-section-items-middle"
              data-id="7b053dc"
              data-element_type="section"
              data-settings={settings}
            >
              <div class="elementor-container elementor-column-gap-no">
                <div
                  class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-af2520a"
                  data-id="af2520a"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-71c861c elementor-widget__width-initial elementor-widget-tablet__width-initial elementor-widget-mobile__width-inherit elementor-widget elementor-widget-globefarer_core_testimonials_list"
                      data-id="71c861c"
                      data-element_type="widget"
                      data-widget_type="globefarer_core_testimonials_list.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="qodef-shortcode qodef-m qodef-testimonials-list qodef-skin--light qodef-grid qodef-swiper-container qodef-gutter--normal qodef-col-num--1 qodef-item-layout--info-below qodef-responsive--predefined"
                          data-options={dataOptions}
                        >
                          <div
                            class="qodef-m-icon"
                            style="color: #ffffff"
                          >
                            <svg
                              class="qodef-svg--quote"
                              xmlns="http://www.w3.org/2000/svg"
                              width="75.172"
                              height="62.462"
                              viewBox="0 0 75.172 62.462"
                            >
                              <g
                                transform="translate(-762.938 -1079.129)"
                              >
                                <g
                                  transform="translate(763.438 1079.634)"
                                >
                                  <g>
                                    <path
                                      d="M808.7,1141.091H837.61v-27.657H824.424a1.159,1.159,0,0,1-1.149-1.17v-2.83c0-10.565,3.98-16.034,11.832-16.261v-13.538c-10.007.106-17.7,3.274-22.865,9.421-5.278,6.275-7.954,14.69-7.954,25.01A89.185,89.185,0,0,0,808.7,1141.091Zm-40.631,0h28.921v-27.657H783.574a1.159,1.159,0,0,1-1.15-1.17v-2.83c0-10.57,4.056-16.039,12.06-16.262v-13.537c-10.01.105-17.739,3.275-22.984,9.424-5.351,6.277-8.063,14.691-8.063,25.008A84.046,84.046,0,0,0,768.065,1141.091Z"
                                      transform="translate(-763.438 -1079.634)"
                                    />
                                  </g>
                                </g>
                              </g>
                            </svg>
                          </div>

                          <div class="swiper-wrapper">
                            <div class="qodef-e swiper-slide">
                              <div class="qodef-e-inner">
                                <h2
                                  itemprop="description"
                                  class="qodef-e-text"
                                >
                                  Eos no dico graeci sea, debet nihil
                                  omnium quodsi quot dolores percipit.
                                </h2>
                                <div class="qodef-e-content">
                                  <div class="qodef-e-media-image">
                                    <img
                                      loading="lazy"
                                      decoding="async"
                                      width="150"
                                      height="150"
                                      src="web/wp-content/uploads/2021/08/main-home-testimonial-1.png"
                                      class="attachment-thumbnail size-thumbnail wp-post-image"
                                      alt="d"
                                    />
                                  </div>
                                  <div class="qodef-e-author">
                                    <h6
                                      class="qodef-e-author-job"
                                      style="color: #ffffff"
                                    >
                                      Satisfied Client
                                    </h6>
                                    <h3 class="qodef-e-author-name">
                                      George Moreno
                                    </h3>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-e737fae elementor-section-full_width qodef-elementor-content-grid elementor-section-height-default elementor-section-height-default"
              data-id="e737fae"
              data-element_type="section"
              data-settings={settings}
            >
              <div class="elementor-container elementor-column-gap-no">
                <div
                  class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-678738e"
                  data-id="678738e"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-a9cd0d7 elementor-widget elementor-widget-globefarer_core_icon_with_text"
                      data-id="a9cd0d7"
                      data-element_type="widget"
                      data-widget_type="globefarer_core_icon_with_text.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="qodef-shortcode qodef-m qodef-icon-with-text qodef-layout--top qodef--custom-icon qodef-alignment--left"
                        >
                          <div class="qodef-m-icon-wrapper">
                            <img
                              loading="lazy"
                              decoding="async"
                              width="45"
                              height="34"
                              src="web/wp-content/uploads/2021/08/landing-icon-3-1.png"
                              class="attachment-full size-full"
                              alt="d"
                            />
                          </div>
                          <div class="qodef-m-content">
                            <h4 class="qodef-m-title">
                              <span class="qodef-m-title-text"
                                >Ocean Freight</span
                              >
                            </h4>
                            <p
                              class="qodef-m-text"
                              style="margin-top: 18px"
                            >
                              Vix ut ignota deserunt partien ad, pros tale
                              falli periculis ad, idque deseruisse
                              constituam.
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-aaeea25"
                  data-id="aaeea25"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-6d0c936 elementor-widget elementor-widget-globefarer_core_icon_with_text"
                      data-id="6d0c936"
                      data-element_type="widget"
                      data-widget_type="globefarer_core_icon_with_text.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="qodef-shortcode qodef-m qodef-icon-with-text qodef-layout--top qodef--custom-icon qodef-alignment--left"
                        >
                          <div class="qodef-m-icon-wrapper">
                            <img
                              loading="lazy"
                              decoding="async"
                              width="45"
                              height="34"
                              src="web/wp-content/uploads/2021/08/landing-icon-4-1.png"
                              class="attachment-full size-full"
                              alt="d"
                            />
                          </div>
                          <div class="qodef-m-content">
                            <h4 class="qodef-m-title">
                              <span class="qodef-m-title-text"
                                >Rail Freight</span
                              >
                            </h4>
                            <p
                              class="qodef-m-text"
                              style="margin-top: 18px"
                            >
                              Vix ut ignota deserunt partien ad, pros tale
                              falli periculis ad, idque deseruisse
                              constituam.
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-68ec894"
                  data-id="68ec894"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-fcc6e12 elementor-widget elementor-widget-globefarer_core_icon_with_text"
                      data-id="fcc6e12"
                      data-element_type="widget"
                      data-widget_type="globefarer_core_icon_with_text.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="qodef-shortcode qodef-m qodef-icon-with-text qodef-layout--top qodef--custom-icon qodef-alignment--left"
                        >
                          <div class="qodef-m-icon-wrapper">
                            <img
                              loading="lazy"
                              decoding="async"
                              width="45"
                              height="34"
                              src="web/wp-content/uploads/2021/08/landing-icon-1-1.png"
                              class="attachment-full size-full"
                              alt="d"
                            />
                          </div>
                          <div class="qodef-m-content">
                            <h4 class="qodef-m-title">
                              <span class="qodef-m-title-text"
                                >Land Freight</span
                              >
                            </h4>
                            <p
                              class="qodef-m-text"
                              style="margin-top: 18px"
                            >
                              Vix ut ignota deserunt partien ad, pros tale
                              falli periculis ad, idque deseruisse
                              constituam.
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-7dfacf7"
                  data-id="7dfacf7"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-69f5656 elementor-widget elementor-widget-globefarer_core_icon_with_text"
                      data-id="69f5656"
                      data-element_type="widget"
                      data-widget_type="globefarer_core_icon_with_text.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="qodef-shortcode qodef-m qodef-icon-with-text qodef-layout--top qodef--custom-icon qodef-alignment--left"
                        >
                          <div class="qodef-m-icon-wrapper">
                            <img
                              loading="lazy"
                              decoding="async"
                              width="45"
                              height="34"
                              src="web/wp-content/uploads/2021/08/landing-icon-2-1.png"
                              class="attachment-full size-full"
                              alt="d"
                            />
                          </div>
                          <div class="qodef-m-content">
                            <h4 class="qodef-m-title">
                              <span class="qodef-m-title-text"
                                >Air Freight</span
                              >
                            </h4>
                            <p
                              class="qodef-m-text"
                              style="margin-top: 18px"
                            >
                              Vix ut ignota deserunt partien ad, pros tale
                              falli periculis ad, idque deseruisse
                              constituam.
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-2c89377 elementor-section-full_width qodef-elementor-content-grid elementor-section-height-default elementor-section-height-default"
              data-id="2c89377"
              data-element_type="section"
              data-settings={settings}
            >
              <div class="elementor-container elementor-column-gap-no">
                <div
                  class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-26fc046"
                  data-id="26fc046"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-bf43c56 elementor-widget elementor-widget-globefarer_core_divided_image_info"
                      data-id="bf43c56"
                      data-element_type="widget"
                      data-widget_type="globefarer_core_divided_image_info.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="qodef-shortcode qodef-m qodef-divided-image-info qodef-layout--image-right qodef-separator--on qodef-breakpoint--1024 qodef-appear-animation--yes qodef-appear-animation-type--roll-out"
                        >
                          <div
                            class="qodef-m-content"
                            style="
                              margin-top: 10px;
                              padding-left: 0px;
                              padding-right: 4%;
                            "
                          >
                            <h2
                              itemprop="name"
                              class="qodef-m-title"
                              style="margin-bottom: 29px"
                            >
                              Secure courier for all your packages
                            </h2>
                            <p class="qodef-m-text">
                              Lorem ipsum dolor sit amet, et sale ad mutat
                              nusqua ius ea has autem aeterno divine sum.
                            </p>
                            <a
                              class="qodef-shortcode qodef-m qodef-m-button qodef-button qodef-layout--textual qodef-html--link"
                              href="https://globefarer.qodeinteractive.com/about-us/"
                              target="_self"
                            >
                              <span class="qodef-m-button-icon"
                                ><svg
                                  class="qodef-svg--plus"
                                  xmlns="http://www.w3.org/2000/svg"
                                  xmlns:xlink="http://www.w3.org/1999/xlink"
                                  width="14"
                                  height="14"
                                  viewBox="0 0 14 14"
                                >
                                  <path
                                    class="qodef-m-horizontal"
                                    d="M0,0H14V2H0Z"
                                    transform="translate(0 6)"
                                  />
                                  <path
                                    class="qodef-m-vertical"
                                    d="M0,0H2V14H0Z"
                                    transform="translate(6)"
                                  /></svg
                              ></span>
                              <span class="qodef-m-button-text"
                                >View more<br />
                                about our services</span
                              >
                            </a>
                          </div>
                          <div
                            class="qodef-m-image"
                            style="
                              width: 63%;
                              padding-left: 5.8%;
                              padding-right: 0px;
                            "
                          >
                            <img
                              loading="lazy"
                              decoding="async"
                              width="800"
                              height="408"
                              src="web/wp-content/uploads/2021/08/main-home-img-2-1.jpg"
                              class="attachment-full size-full"
                              alt="d"
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-6d6b37e elementor-section-full_width qodef-elementor-content-grid elementor-section-height-default elementor-section-height-default"
              data-id="6d6b37e"
              data-element_type="section"
            >
              <div class="elementor-container elementor-column-gap-no">
                <div
                  class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-57613ee"
                  data-id="57613ee"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-6643e8b elementor-widget elementor-widget-globefarer_core_section_title"
                      data-id="6643e8b"
                      data-element_type="widget"
                      data-widget_type="globefarer_core_section_title.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="qodef-shortcode qodef-m qodef-section-title qodef-alignment--left qodef-appear-animation--no"
                        >
                          <h2 class="qodef-m-title">Meet the team</h2>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-dc31848 elementor-section-full_width qodef-elementor-content-grid elementor-section-height-default elementor-section-height-default"
              data-id="dc31848"
              data-element_type="section"
            >
              <div class="elementor-container elementor-column-gap-no">
                <div
                  class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-8a5aeaf"
                  data-id="8a5aeaf"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-803d79a elementor-widget elementor-widget-globefarer_core_team_list"
                      data-id="803d79a"
                      data-element_type="widget"
                      data-widget_type="globefarer_core_team_list.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="qodef-shortcode qodef-m qodef-team-list qodef-item-layout--info-on-side qodef-grid qodef-layout--columns qodef-gutter--medium qodef-col-num--4 qodef-item-layout--info-on-side qodef--no-bottom-space qodef-pagination--off qodef-responsive--custom qodef-col-num--1440--4 qodef-col-num--1366--4 qodef-col-num--1024--2 qodef-col-num--768--2 qodef-col-num--680--1 qodef-col-num--480--1"
                          data-options={teamOptions}
                        >
                          <div class="qodef-grid-inner clear">
                            <div
                              class="qodef-e qodef-grid-item post-469 team type-team status-publish has-post-thumbnail hentry team-category-main-home"
                            >
                              <div class="qodef-e-inner">
                                <div class="qodef-e-image">
                                  <div class="qodef-e-media-image">
                                    <a
                                      itemprop="url"
                                      href="index7c54.html?team=lionel-todd"
                                    >
                                      <img
                                        loading="lazy"
                                        decoding="async"
                                        width="140"
                                        height="140"
                                        src="web/wp-content/uploads/2021/08/main-home-team-1-1-1.png"
                                        class="attachment-full size-full wp-post-image"
                                        alt="d"
                                      />
                                    </a>
                                  </div>
                                </div>
                                <div class="qodef-e-content">
                                  <span class="qodef-e-role"
                                    >Developer</span
                                  >
                                  <h4
                                    itemprop="name"
                                    class="qodef-e-title entry-title"
                                  >
                                    <a
                                      itemprop="url"
                                      class="qodef-e-title-link"
                                      href="index7c54.html?team=lionel-todd"
                                    >
                                      Lionel Todd
                                    </a>
                                  </h4>
                                </div>
                              </div>
                            </div>
                            <div
                              class="qodef-e qodef-grid-item post-471 team type-team status-publish has-post-thumbnail hentry team-category-main-home"
                            >
                              <div class="qodef-e-inner">
                                <div class="qodef-e-image">
                                  <div class="qodef-e-media-image">
                                    <a
                                      itemprop="url"
                                      href="index4543.html?team=nina-west"
                                    >
                                      <img
                                        loading="lazy"
                                        decoding="async"
                                        width="140"
                                        height="140"
                                        src="web/wp-content/uploads/2021/08/team-single-img1-1.png"
                                        class="attachment-full size-full wp-post-image"
                                        alt="r"
                                      />
                                    </a>
                                  </div>
                                </div>
                                <div class="qodef-e-content">
                                  <span class="qodef-e-role"
                                    >Copywriter</span
                                  >
                                  <h4
                                    itemprop="name"
                                    class="qodef-e-title entry-title"
                                  >
                                    <a
                                      itemprop="url"
                                      class="qodef-e-title-link"
                                      href="index4543.html?team=nina-west"
                                    >
                                      Nina West
                                    </a>
                                  </h4>
                                </div>
                              </div>
                            </div>
                            <div
                              class="qodef-e qodef-grid-item post-473 team type-team status-publish has-post-thumbnail hentry team-category-main-home"
                            >
                              <div class="qodef-e-inner">
                                <div class="qodef-e-image">
                                  <div class="qodef-e-media-image">
                                    <a
                                      itemprop="url"
                                      href="indexd11e.html?team=scott-moran"
                                    >
                                      <img
                                        loading="lazy"
                                        decoding="async"
                                        width="140"
                                        height="140"
                                        src="web/wp-content/uploads/2021/08/main-home-team-3-1-1.png"
                                        class="attachment-full size-full wp-post-image"
                                        alt="d"
                                      />
                                    </a>
                                  </div>
                                </div>
                                <div class="qodef-e-content">
                                  <span class="qodef-e-role"
                                    >Co Founder</span
                                  >
                                  <h4
                                    itemprop="name"
                                    class="qodef-e-title entry-title"
                                  >
                                    <a
                                      itemprop="url"
                                      class="qodef-e-title-link"
                                      href="indexd11e.html?team=scott-moran"
                                    >
                                      Scott Moran
                                    </a>
                                  </h4>
                                </div>
                              </div>
                            </div>
                            <div
                              class="qodef-e qodef-grid-item post-475 team type-team status-publish has-post-thumbnail hentry team-category-main-home"
                            >
                              <div class="qodef-e-inner">
                                <div class="qodef-e-image">
                                  <div class="qodef-e-media-image">
                                    <a
                                      itemprop="url"
                                      href="index4bdf.html?team=susie-marsh"
                                    >
                                      <img
                                    loading="lazy"
                                        decoding="async"
                                        width="140"
                                        height="140"
                                        src="web/wp-content/uploads/2021/08/main-home-team-4-1-1.png"
                                        class="attachment-full size-full wp-post-image"
                                        alt="d"
                                      />
                                    </a>
                                  </div>
                                </div>
                                <div class="qodef-e-content">
                                  <span class="qodef-e-role"
                                    >Web Designer</span
                                  >
                                  <h4
                                    itemprop="name"
                                    class="qodef-e-title entry-title"
                                  >
                                    <a
                                      itemprop="url"
                                      class="qodef-e-title-link"
                                      href="index4bdf.html?team=susie-marsh"
                                    >
                                      Susie Marsh
                                    </a>
                                  </h4>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-ee4caa5 elementor-section-full_width elementor-section-height-min-height qodef-elementor-content-grid elementor-section-height-default elementor-section-items-middle"
              data-id="ee4caa5"
              data-element_type="section"
              data-settings={settings}
            >
              <div class="elementor-container elementor-column-gap-no">
                <div
                  class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-7d7f4c3"
                  data-id="7d7f4c3"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-fa61764 elementor-widget__width-initial elementor-widget-mobile__width-inherit elementor-widget elementor-widget-globefarer_core_section_title"
                      data-id="fa61764"
                      data-element_type="widget"
                      data-widget_type="globefarer_core_section_title.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="qodef-shortcode qodef-m qodef-section-title qodef-alignment--left qodef-appear-animation--no"
                        >
                          <h1
                            class="qodef-m-title"
                            style="color: #ffffff"
                          >
                            We provide the best and fastest courier
                            services nowadays
                          </h1>
                          <p
                            class="qodef-m-text"
                            style="margin-top: 30px; color: #ffffff"
                          >
                            Id veniam malorum mel. At tempor euismod
                            postulant commodo.
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-e9169f3 elementor-section-full_width elementor-section-height-min-height qodef-elementor-content-grid elementor-section-content-middle elementor-section-height-default elementor-section-items-middle"
              data-id="e9169f3"
              data-element_type="section"
              data-settings={settings}
            >
              <div class="elementor-container elementor-column-gap-no">
                <div
                  class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-3c703cb"
                  data-id="3c703cb"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-c987fa3 elementor-widget__width-initial elementor-widget-tablet__width-initial elementor-widget-mobile__width-inherit elementor-widget elementor-widget-globefarer_core_section_title"
                      data-id="c987fa3"
                      data-element_type="widget"
                      data-widget_type="globefarer_core_section_title.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="qodef-shortcode qodef-m qodef-section-title qodef-alignment--center qodef-custom-cursor--enabled qodef-appear-animation--no"
                        >
                          <h2 class="qodef-m-title">
                            <a
                              itemprop="url"
                              href="https://globefarer.qodeinteractive.com/what-we-do/"
                              target="_self"
                            >
                              An innovative service for easy &amp; fast
                              shipments, transportation coordinated by
                              qualified staff
                            </a>
                          </h2>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-d0a8899 qodef-elementor-content-grid elementor-section-boxed elementor-section-height-default elementor-section-height-default"
              data-id="d0a8899"
              data-element_type="section"
            >
              <div
                class="elementor-container elementor-column-gap-default"
              >
                <div
                  class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-4220659"
                  data-id="4220659"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-7a6f37d elementor-widget elementor-widget-globefarer_core_section_title"
                      data-id="7a6f37d"
                      data-element_type="widget"
                      data-widget_type="globefarer_core_section_title.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="qodef-shortcode qodef-m qodef-section-title qodef-alignment--left qodef-appear-animation--no"
                        >
                          <h2 class="qodef-m-title">Latest blog posts</h2>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-597554c qodef-elementor-content-grid elementor-section-boxed elementor-section-height-default elementor-section-height-default"
              data-id="597554c"
              data-element_type="section"
            >
              <div
                class="elementor-container elementor-column-gap-default"
              >
                <div
                  class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-29a4321"
                  data-id="29a4321"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-a4a9efa elementor-widget elementor-widget-globefarer_core_blog_list"
                      data-id="a4a9efa"
                      data-element_type="widget"
                      data-widget_type="globefarer_core_blog_list.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                        class={"qodef-" + shortcode + " qodef-m qodef-blog qodef-item-layout--divided-compact qodef-hover-animation--yes qodef-grid qodef-layout--columns qodef-gutter--medium qodef-col-num--3 qodef-item-layout--divided-compact qodef--no-bottom-space qodef-pagination--off qodef-responsive--custom qodef-col-num--1440--3 qodef-col-num--1366--3 qodef-col-num--1024--1 qodef-col-num--768--1 qodef-col-num--680--1 qodef-col-num--480--1"}
                        data-options={blogOptions}
                        >
                          <div class="qodef-grid-inner clear">
                            <article
                              class="qodef-e qodef-blog-item qodef-grid-item qodef-item--full post-3050 post type-post status-publish format-standard has-post-thumbnail hentry category-agriculture tag-supplychain tag-travel tag-warehouse"
                            >
                              <div class="qodef-e-inner">
                                <div class="qodef-e-media">
                                  <div class="qodef-e-media-image">
                                    <a
                                      itemprop="url"
                                      href="index275d.html?p=3050"
                                    >
                                      <img
                                    loading="lazy"
                                        decoding="async"
                                        width="1400"
                                        height="935"
                                        src="web/wp-content/uploads/2021/08/maih-home-blog-img1-1.jpg"
                                        class="attachment-full size-full wp-post-image"
                                        alt="f"
                                      />
                                    </a>
                                  </div>
                                </div>
                                <div class="qodef-e-content">
                                  <div class="qodef-e-left-holder">
                                    <a
                                      itemprop="dateCreated"
                                      href="indexa7d1.html?m=202108"
                                      class="qodef-e-date entry-date published updated"
                                    >
                                      <span class="qodef-e-date-day"
                                        >09</span
                                      >
                                      <span class="qodef-e-date-month"
                                        >Aug</span
                                      >
                                    </a>
                                    <div
                                      class="qodef-info-separator-end"
                                    ></div>
                                  </div>
                                  <div class="qodef-e-right-holder">
                                    <div class="qodef-e-top-holder">
                                      <div class="qodef-e-info">
                                        <a
                                          href="index81ea.html?cat=3"
                                          rel="tag"
                                          >Agriculture</a
                                        >
                                        <div
                                          class="qodef-info-separator-end"
                                        ></div>
                                      </div>
                                    </div>
                                    <div class="qodef-e-text">
                                      <h4
                                        itemprop="name"
                                        class="qodef-e-title entry-title"
                                      >
                                        <a
                                          itemprop="url"
                                          class="qodef-e-title-link"
                                          href="index275d.html?p=3050"
                                        >
                                          The Great Innovators
                                        </a>
                                      </h4>
                                      <p
                                        itemprop="description"
                                        class="qodef-e-excerpt"
                                      >
                                        Lorem ipsum dolor sit amet,
                                        consectetur adipiscing elit. In
                                        augue ligula
                                      </p>
                                    </div>
                                    <div class="qodef-e-bottom-holder">
                                      <div class="qodef-e-read-more">
                                        <a
                                          class="qodef-shortcode qodef-m qodef-button qodef-layout--textual qodef-html--link"
                                          href="index275d.html?p=3050"
                                          target="_self"
                                        >
                                          <span
                                            class="qodef-m-button-icon"
                                            ><svg
                                              class="qodef-svg--plus"
                                              xmlns="http://www.w3.org/2000/svg"
                                              xmlns:xlink="http://www.w3.org/1999/xlink"
                                              width="14"
                                              height="14"
                                              viewBox="0 0 14 14"
                                            >
                                              <path
                                                class="qodef-m-horizontal"
                                                d="M0,0H14V2H0Z"
                                                transform="translate(0 6)"
                                              />
                                              <path
                                                class="qodef-m-vertical"
                                                d="M0,0H2V14H0Z"
                                                transform="translate(6)"
                                              /></svg
                                          ></span>
                                          <span
                                            class="qodef-m-button-text"
                                            >Read more</span
                                          >
                                        </a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </article>
                            <article
                              class="qodef-e qodef-blog-item qodef-grid-item qodef-item--full post-3059 post type-post status-publish format-standard has-post-thumbnail hentry category-agriculture tag-shipping tag-supplychain tag-warehouse"
                            >
                              <div class="qodef-e-inner">
                                <div class="qodef-e-media">
                                  <div class="qodef-e-media-image">
                                    <a
                                      itemprop="url"
                                      href="index271a.html?p=3059"
                                    >
                                      <img
                                        loading="lazy"
                                        decoding="async"
                                        width="1400"
                                        height="935"
                                        src="web/wp-content/uploads/2021/08/maih-home-blog-img2-1.jpg"
                                        class="attachment-full size-full wp-post-image"
                                        alt="d"
                                      />
                                    </a>
                                  </div>
                                </div>
                                <div class="qodef-e-content">
                                  <div class="qodef-e-left-holder">
                                    <a
                                      itemprop="dateCreated"
                                      href="indexa7d1.html?m=202108"
                                      class="qodef-e-date entry-date published updated"
                                    >
                                      <span class="qodef-e-date-day"
                                        >09</span
                                      >
                                      <span class="qodef-e-date-month"
                                        >Aug</span
                                      >
                                    </a>
                                    <div
                                      class="qodef-info-separator-end"
                                    ></div>
                                  </div>
                                  <div class="qodef-e-right-holder">
                                    <div class="qodef-e-top-holder">
                                      <div class="qodef-e-info">
                                        <a
                                          href="index81ea.html?cat=3"
                                          rel="tag"
                                          >Agriculture</a
                                        >
                                        <div
                                          class="qodef-info-separator-end"
                                        ></div>
                                      </div>
                                    </div>
                                    <div class="qodef-e-text">
                                      <h4
                                        itemprop="name"
                                        class="qodef-e-title entry-title"
                                      >
                                        <a
                                          itemprop="url"
                                          class="qodef-e-title-link"
                                          href="index271a.html?p=3059"
                                        >
                                          The Story of Civilization
                                        </a>
                                      </h4>
                                      <p
                                        itemprop="description"
                                        class="qodef-e-excerpt"
                                      >
                                        Lorem ipsum dolor sit amet,
                                        consectetur adipiscing elit. In
                                        augue ligula
                                      </p>
                                    </div>
                                    <div class="qodef-e-bottom-holder">
                                      <div class="qodef-e-read-more">
                                        <a
                                          class="qodef-shortcode qodef-m qodef-button qodef-layout--textual qodef-html--link"
                                          href="index271a.html?p=3059"
                                          target="_self"
                                        >
                                          <span
                                            class="qodef-m-button-icon"
                                            ><svg
                                              class="qodef-svg--plus"
                                              xmlns="http://www.w3.org/2000/svg"
                                              xmlns:xlink="http://www.w3.org/1999/xlink"
                                              width="14"
                                              height="14"
                                              viewBox="0 0 14 14"
                                            >
                                              <path
                                                class="qodef-m-horizontal"
                                                d="M0,0H14V2H0Z"
                                                transform="translate(0 6)"
                                              />
                                              <path
                                                class="qodef-m-vertical"
                                                d="M0,0H2V14H0Z"
                                                transform="translate(6)"
                                              /></svg
                                          ></span>
                                          <span
                                            class="qodef-m-button-text"
                                            >Read more</span
                                          >
                                        </a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </article>
                            <article
                              class="qodef-e qodef-blog-item qodef-grid-item qodef-item--full post-3065 post type-post status-publish format-standard has-post-thumbnail hentry category-agriculture tag-shipping tag-transport tag-warehouse"
                            >
                              <div class="qodef-e-inner">
                                <div class="qodef-e-media">
                                  <div class="qodef-e-media-image">
                                    <a
                                      itemprop="url"
                                      href="indexd39d.html?p=3065"
                                    >
                                      <img
                                        loading="lazy"
                                        decoding="async"
                                        width="1400"
                                        height="935"
                                        src="web/wp-content/uploads/2021/08/maih-home-blog-img3-1.jpg"
                                        class="attachment-full size-full wp-post-image"
                                        alt="d"
                                      />
                                    </a>
                                  </div>
                                </div>
                                <div class="qodef-e-content">
                                  <div class="qodef-e-left-holder">
                                    <a
                                      itemprop="dateCreated"
                                      href="indexa7d1.html?m=202108"
                                      class="qodef-e-date entry-date published updated"
                                    >
                                      <span class="qodef-e-date-day"
                                        >09</span
                                      >
                                      <span class="qodef-e-date-month"
                                        >Aug</span
                                      >
                                    </a>
                                    <div
                                      class="qodef-info-separator-end"
                                    ></div>
                                  </div>
                                  <div class="qodef-e-right-holder">
                                    <div class="qodef-e-top-holder">
                                      <div class="qodef-e-info">
                                        <a
                                          href="index81ea.html?cat=3"
                                          rel="tag"
                                          >Agriculture</a
                                        >
                                        <div
                                          class="qodef-info-separator-end"
                                        ></div>
                                      </div>
                                    </div>
                                    <div class="qodef-e-text">
                                      <h4
                                        itemprop="name"
                                        class="qodef-e-title entry-title"
                                      >
                                        <a
                                          itemprop="url"
                                          class="qodef-e-title-link"
                                          href="indexd39d.html?p=3065"
                                        >
                                          Building For Society
                                        </a>
                                      </h4>
                                      <p
                                        itemprop="description"
                                        class="qodef-e-excerpt"
                                      >
                                        Lorem ipsum dolor sit amet,
                                        consectetur adipiscing elit. In
                                        augue ligula
                                      </p>
                                    </div>
                                    <div class="qodef-e-bottom-holder">
                                      <div class="qodef-e-read-more">
                                        <a
                                          class="qodef-shortcode qodef-m qodef-button qodef-layout--textual qodef-html--link"
                                          href="indexd39d.html?p=3065"
                                          target="_self"
                                        >
                                          <span
                                            class="qodef-m-button-icon"
                                            ><svg
                                              class="qodef-svg--plus"
                                              xmlns="http://www.w3.org/2000/svg"
                                              xmlns:xlink="http://www.w3.org/1999/xlink"
                                              width="14"
                                              height="14"
                                              viewBox="0 0 14 14"
                                            >
                                              <path
                                                class="qodef-m-horizontal"
                                                d="M0,0H14V2H0Z"
                                                transform="translate(0 6)"
                                              />
                                              <path
                                                class="qodef-m-vertical"
                                                d="M0,0H2V14H0Z"
                                                transform="translate(6)"
                                              /></svg
                                          ></span>
                                          <span
                                            class="qodef-m-button-text"
                                            >Read more</span
                                          >
                                        </a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </article>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </main>
  </div>