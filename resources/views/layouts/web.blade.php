<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$tabTitles = [""];
?>

<!DOCTYPE html>
<html lang="en-US">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />

  <title>Newworld cargo</title>
  <meta name="robots" content="max-image-preview:large" />
  <style>
    img:is([sizes="auto" i], [sizes^="auto," i]) {
      contain-intrinsic-size: 3000px 1500px;
    }
  </style>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <link rel="alternate" type="application/rss+xml" title="New world cargo &raquo; Feed"
    href="indexd784.html?feed=rss2" />
  <link rel="alternate" type="application/rss+xml" title="New world cargo &raquo; Comments Feed"
    href="indexa6da.html?feed=comments-rss2" />
    @php 
    $model = App\Models\Settings::where('group', 'general')->where('name','system_logo')->first();
@endphp
<link rel="shortcut icon" href="{{ $model->getFirstMediaUrl('system_logo') ? $model->getFirstMediaUrl('system_logo') : asset('assets/lte/media/logos/favicon.png') }}" />


  <script type="text/javascript">
    /* <![CDATA[ */
    window._wpemojiSettings = {
      baseUrl: "https:\/\/s.w.org\/images\/core\/emoji\/15.0.3\/72x72\/",
      ext: ".png",
      svgUrl: "https:\/\/s.w.org\/images\/core\/emoji\/15.0.3\/svg\/",
      svgExt: ".svg",
      source: {
        concatemoji: "http:\/\/localhost\/nwc\/wp-includes\/js\/wp-emoji-release.min.js?ver=6.7.1",
      },
    };
    /*! This file is auto-generated */
    !(function (i, n) {
      var o, s, e;

      function c(e) {
        try {
          var t = {
            supportTests: e,
            timestamp: new Date().valueOf()
          };
          sessionStorage.setItem(o, JSON.stringify(t));
        } catch (e) { }
      }

      function p(e, t, n) {
        e.clearRect(0, 0, e.canvas.width, e.canvas.height),
          e.fillText(t, 0, 0);
        var t = new Uint32Array(
          e.getImageData(0, 0, e.canvas.width, e.canvas.height).data
        ),
          r =
            (e.clearRect(0, 0, e.canvas.width, e.canvas.height),
              e.fillText(n, 0, 0),
              new Uint32Array(
                e.getImageData(0, 0, e.canvas.width, e.canvas.height).data
              ));
        return t.every(function (e, t) {
          return e === r[t];
        });
      }

      function u(e, t, n) {
        switch (t) {
          case "flag":
            return n(
              e,
              "\ud83c\udff3\ufe0f\u200d\u26a7\ufe0f",
              "\ud83c\udff3\ufe0f\u200b\u26a7\ufe0f"
            ) ?
              !1 :
              !n(
                e,
                "\ud83c\uddfa\ud83c\uddf3",
                "\ud83c\uddfa\u200b\ud83c\uddf3"
              ) &&
              !n(
                e,
                "\ud83c\udff4\udb40\udc67\udb40\udc62\udb40\udc65\udb40\udc6e\udb40\udc67\udb40\udc7f",
                "\ud83c\udff4\u200b\udb40\udc67\u200b\udb40\udc62\u200b\udb40\udc65\u200b\udb40\udc6e\u200b\udb40\udc67\u200b\udb40\udc7f"
              );
          case "emoji":
            return !n(
              e,
              "\ud83d\udc26\u200d\u2b1b",
              "\ud83d\udc26\u200b\u2b1b"
            );
        }
        return !1;
      }

      function f(e, t, n) {
        var r =
          "undefined" != typeof WorkerGlobalScope &&
            self instanceof WorkerGlobalScope ?
            new OffscreenCanvas(300, 150) :
            i.createElement("canvas"),
          a = r.getContext("2d", {
            willReadFrequently: !0
          }),
          o = ((a.textBaseline = "top"), (a.font = "600 32px Arial"), {});
        return (
          e.forEach(function (e) {
            o[e] = t(a, e, n);
          }),
          o
        );
      }

      function t(e) {
        var t = i.createElement("script");
        (t.src = e), (t.defer = !0), i.head.appendChild(t);
      }
      "undefined" != typeof Promise &&
        ((o = "wpEmojiSettingsSupports"),
          (s = ["flag", "emoji"]),
          (n.supports = {
            everything: !0,
            everythingExceptFlag: !0
          }),
          (e = new Promise(function (e) {
            i.addEventListener("DOMContentLoaded", e, {
              once: !0
            });
          })),
          new Promise(function (t) {
            var n = (function () {
              try {
                var e = JSON.parse(sessionStorage.getItem(o));
                if (
                  "object" == typeof e &&
                  "number" == typeof e.timestamp &&
                  new Date().valueOf() < e.timestamp + 604800 &&
                  "object" == typeof e.supportTests
                )
                  return e.supportTests;
              } catch (e) { }
              return null;
            })();
            if (!n) {
              if (
                "undefined" != typeof Worker &&
                "undefined" != typeof OffscreenCanvas &&
                "undefined" != typeof URL &&
                URL.createObjectURL &&
                "undefined" != typeof Blob
              )
                try {
                  var e =
                    "postMessage(" +
                    f.toString() +
                    "(" + [JSON.stringify(s), u.toString(), p.toString()].join(
                      ","
                    ) +
                    "));",
                    r = new Blob([e], {
                      type: "text/javascript"
                    }),
                    a = new Worker(URL.createObjectURL(r), {
                      name: "wpTestEmojiSupports",
                    });
                  return void (a.onmessage = function (e) {
                    c((n = e.data)), a.terminate(), t(n);
                  });
                } catch (e) { }
              c((n = f(s, u, p)));
            }
            t(n);
          })
            .then(function (e) {
              for (var t in e)
                (n.supports[t] = e[t]),
                  (n.supports.everything =
                    n.supports.everything && n.supports[t]),
                  "flag" !== t &&
                  (n.supports.everythingExceptFlag =
                    n.supports.everythingExceptFlag && n.supports[t]);
              (n.supports.everythingExceptFlag =
                n.supports.everythingExceptFlag && !n.supports.flag),
                (n.DOMReady = !1),
                (n.readyCallback = function () {
                  n.DOMReady = !0;
                });
            })
            .then(function () {
              return e;
            })
            .then(function () {
              var e;
              n.supports.everything ||
                (n.readyCallback(),
                  (e = n.source || {}).concatemoji ?
                    t(e.concatemoji) :
                    e.wpemoji && e.twemoji && (t(e.twemoji), t(e.wpemoji)));
            }));
    })((window, document), window._wpemojiSettings);
    /* ]]> */
  </script>
  <link rel="stylesheet" id="animate-css"
    href="web/wp-content/plugins/qi-blocks/assets/css/plugins/animate/animate.min0235.css?ver=4.1.1" type="text/css"
    media="all" />
  <link rel="stylesheet" id="sbi_styles-css"
    href="web/wp-content/plugins/instagram-feed/css/sbi-styles.minb6a4.css?ver=6.6.1" type="text/css" media="all" />
  <link rel="stylesheet" id="dripicons-css"
    href="web/wp-content/plugins/globefarer-core/inc/icons/dripicons/assets/css/dripicons.min9704.css?ver=6.7.1"
    type="text/css" media="all" />
  <link rel="stylesheet" id="elegant-icons-css"
    href="web/wp-content/plugins/globefarer-core/inc/icons/elegant-icons/assets/css/elegant-icons.min9704.css?ver=6.7.1"
    type="text/css" media="all" />
  <link rel="stylesheet" id="font-awesome-css"
    href="web/wp-content/plugins/globefarer-core/inc/icons/font-awesome/assets/css/all.min9704.css?ver=6.7.1"
    type="text/css" media="all" />
  <link rel="stylesheet" id="fontkiko-css"
    href="web/wp-content/plugins/globefarer-core/inc/icons/fontkiko/assets/css/kiko-all.min9704.css?ver=6.7.1"
    type="text/css" media="all" />
  <link rel="stylesheet" id="ionicons-css"
    href="web/wp-content/plugins/globefarer-core/inc/icons/ionicons/assets/css/ionicons.min9704.css?ver=6.7.1"
    type="text/css" media="all" />
  <link rel="stylesheet" id="linea-icons-css"
    href="web/wp-content/plugins/globefarer-core/inc/icons/linea-icons/assets/css/linea-icons.min9704.css?ver=6.7.1"
    type="text/css" media="all" />
  <link rel="stylesheet" id="linear-icons-css"
    href="web/wp-content/plugins/globefarer-core/inc/icons/linear-icons/assets/css/linear-icons.min9704.css?ver=6.7.1"
    type="text/css" media="all" />
  <link rel="stylesheet" id="material-icons-css"
    href="https://fonts.googleapis.com/icon?family=Material+Icons&amp;ver=6.7.1" type="text/css" media="all" />
  <link rel="stylesheet" id="simple-line-icons-css"
    href="web/wp-content/plugins/globefarer-core/inc/icons/simple-line-icons/assets/css/simple-line-icons.min9704.css?ver=6.7.1"
    type="text/css" media="all" />
  <style id="wp-emoji-styles-inline-css" type="text/css">
    img.wp-smiley,
    img.emoji {
      display: inline !important;
      border: none !important;
      box-shadow: none !important;
      height: 1em !important;
      width: 1em !important;
      margin: 0 0.07em !important;
      vertical-align: -0.1em !important;
      background: none !important;
      padding: 0 !important;
    }
  </style>
  <style id="classic-theme-styles-inline-css" type="text/css">
    /*! This file is auto-generated */
    .wp-block-button__link {
      color: #fff;
      background-color: #012642;
      border-radius: 9999px;
      box-shadow: none;
      text-decoration: none;
      padding: calc(0.667em + 2px) calc(1.333em + 2px);
      font-size: 1.125em;
    }

    .wp-block-file__button {
      background: #012642;
      color: #fff;
      text-decoration: none;
    }
  </style>


  <link href="web/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="web/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="web/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="web/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="web/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <link rel="stylesheet" id="contact-form-7-css"
    href="web/wp-content/plugins/contact-form-7/includes/css/styles1eb7.css?ver=6.0.3" type="text/css" media="all" />
  <link rel="stylesheet" id="cf7msm_styles-css"
    href="web/wp-content/plugins/contact-form-7-multi-step-module/resources/cf7msma94e.css?ver=4.4.1" type="text/css"
    media="all" />
  <link rel="stylesheet" id="ctf_styles-css"
    href="web/wp-content/plugins/custom-twitter-feeds/css/ctf-styles.min5bf8.css?ver=2.2.5" type="text/css" media="all" />
  <link rel="stylesheet" id="qi-blocks-grid-css" href="web/wp-content/plugins/qi-blocks/assets/dist/gridc412.css?ver=1.3.4"
    type="text/css" media="all" />
  <link rel="stylesheet" id="qi-blocks-main-css" href="web/wp-content/plugins/qi-blocks/assets/dist/mainc412.css?ver=1.3.4"
    type="text/css" media="all" />
  <link rel="stylesheet" id="qi-addons-for-elementor-grid-style-css"
    href="web/wp-content/plugins/qi-addons-for-elementor/assets/css/grid.min29af.css?ver=1.8.4" type="text/css"
    media="all" />
  <link rel="stylesheet" id="qi-addons-for-elementor-helper-parts-style-css"
    href="web/wp-content/plugins/qi-addons-for-elementor/assets/css/helper-parts.min29af.css?ver=1.8.4" type="text/css"
    media="all" />
  <link rel="stylesheet" id="qi-addons-for-elementor-style-css"
    href="web/wp-content/plugins/qi-addons-for-elementor/assets/css/main.min29af.css?ver=1.8.4" type="text/css"
    media="all" />
  <link rel="stylesheet" id="perfect-scrollbar-css"
    href="web/wp-content/plugins/globefarer-core/assets/plugins/perfect-scrollbar/perfect-scrollbar9704.css?ver=6.7.1"
    type="text/css" media="all" />
  <link rel="stylesheet" id="swiper-css"
    href="web/wp-content/plugins/qi-addons-for-elementor/assets/plugins/swiper/8.4.5/swiper.min9704.css?ver=6.7.1"
    type="text/css" media="all" />
  <link rel="stylesheet" id="globefarer-main-css"
    href="web/wp-content/themes/globefarer/assets/css/main.min9704.css?ver=6.7.1" type="text/css" media="all" />
  <link rel="stylesheet" id="globefarer-core-style-css"
    href="web/wp-content/plugins/globefarer-core/assets/css/globefarer-core.min9704.css?ver=6.7.1" type="text/css"
    media="all" />
  <link rel="stylesheet" id="globefarer-child-style-css"
    href="web/wp-content/themes/globefarer-child/style9704.css?ver=6.7.1" type="text/css" media="all" />
  <link rel="stylesheet" id="globefarer-google-fonts-css"
    href="https://fonts.googleapis.com/css?family=Poppins%3A200%2C400%2C500%2C700&amp;subset=latin-ext&amp;display=swap&amp;ver=1.0.0"
    type="text/css" media="all" />
  <link rel="stylesheet" id="globefarer-grid-css"
    href="web/wp-content/themes/globefarer/assets/css/grid.min9704.css?ver=6.7.1" type="text/css" media="all" />
  <link rel="stylesheet" id="globefarer-style-css" href="web/wp-content/themes/globefarer/style9704.css?ver=6.7.1"
    type="text/css" media="all" />


  <style id="globefarer-style-inline-css" type="text/css">
    #qodef-page-outer {
      margin-top: -80px;
    }

    @media only screen and (max-width: 1024px) {
      #qodef-page-outer {
        margin-top: -80px;
      }
    }

    #qodef-page-footer-top-area-inner {
      position: relative;
    }

    #qodef-page-footer-middle-area-inner {
      position: relative;
    }

    #qodef-page-footer-bottom-area-inner:before {
      background-color: #ffffff16;
    }

    #qodef-page-inner {
      padding: 0px 0px 0px 0px;
    }

    @media only screen and (max-width: 1024px) {
      #qodef-page-inner {
        padding: 0px 0px 0px 0px;
      }
    }


    .qodef-page-title .qodef-m-content {
			padding-top: 113px;
		}
    .elementor-2602 .elementor-element.elementor-element-94e4a01>.elementor-container {
        bottom: 0px;
        padding: 100px 0 0 0;
        position: absolute;
    }

    .qodef-page-title {
      height: 92px;
      background-color: transparent;
    }

    .qodef-page-title .qodef-m-content {
      padding-top: 80px;
    }

    @media only screen and (max-width: 1024px) {
      .qodef-page-title {
        height: 125px;
      }
    }

    @media only screen and (max-width: 1024px) {
      .qodef-page-title .qodef-m-content {
        padding-top: 80px;
      }
    }

    .qodef-header--standard #qodef-page-header {
      background-color: rgba(255, 205, 4, 0.9);
    }

    .qodef-header--standard #qodef-page-header-inner {
      padding-left: 0px;
      padding-right: 0px;
      border-bottom-color: #ffffff80;
      border-bottom-width: 1px;
      border-bottom-style: solid;
    }

    .qodef-header--standard #qodef-page-header .qodef-widget-holder .widget::before {
      background-color: #ffffff80;
    }

    @media only screen and (max-width: 680px) {

      h1,
      .qodef-h1 {
        font-size: 42px;
        line-height: 50px;
      }

      h2,
      .qodef-h2 {
        font-size: 37px;
        line-height: 45px;
      }
    }

    rs-layer h2 {
      color: white;
    }

    /* Default padding for large screens (Desktops, TVs) */
    .rs-layer-wrap.rs-parallax-wrap {
      left: 100px !important;
    }

    /* Adjust padding for smaller desktop/laptop screens (1440px and below) */
    @media (max-width: 1440px) {
      .rs-layer-wrap.rs-parallax-wrap {
        left: 80px !important;/
      }
    }



    /* Further decrease for standard laptops (1280px and below) */
    @media (max-width: 1280px) {
      .rs-layer-wrap.rs-parallax-wrap {
        left: 60px !important;
      }
    }

    /* Tablet screens (1024px and below) */
    @media (max-width: 1024px) {
      .rs-layer-wrap.rs-parallax-wrap {
        left: 40px !important;
      }
    }

    /* Mobile devices (768px and below) */
    @media (max-width: 768px) {
      .rs-layer-wrap.rs-parallax-wrap {
        left: 20px !important;
      }
    }

    /* Very small screens (480px and below) */
    @media (max-width: 480px) {
      .rs-layer-wrap.rs-parallax-wrap {
        left: 10px !important;
      }
    }




    /* Adjustments for different screen sizes */
    @media (min-width: 784px) and (max-width: 1024px) {
      rs-layer {
        right: 23rem !important;
      }
    }

    @media (min-width: 1025px) and (max-width: 1280px) {
      rs-layer {
        right: 33rem !important;
      }
    }

    @media (min-width: 1281px) and (max-width: 1440px) {
      rs-layer {
        right: 37rem !important;
      }
    }

    @media (min-width: 1441px) and (max-width: 1600px) {
      rs-layer {
        right: 43rem !important;
      }
    }

    @media (min-width: 1501px) {
      rs-layer {
        right: 45rem !important;
      }
    }

    @media (min-width: 1501px) {
      rs-layer {
        right: 53rem !important;
      }
    }

    @font-face {
      font-family: 'IroncladBold';
      src: url('./ironclad-bold.otf') format('opentype');
      font-weight: bold;
      font-style: normal;
    }
  </style>
  <link rel="stylesheet" id="globefarer-core-elementor-css"
    href="web/wp-content/plugins/globefarer-core/inc/plugins/elementor/assets/css/elementor.min9704.css?ver=6.7.1"
    type="text/css" media="all" />
  <link rel="stylesheet" id="elementor-frontend-css"
    href="web/wp-content/plugins/elementor/assets/css/frontend.mindb68.css?ver=3.27.1" type="text/css" media="all" />
  <link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet" />
  <link rel="stylesheet" id="elementor-post-7-css" href="web/wp-content/uploads/elementor/css/post-7ad9c.css?ver=1738195901"
    type="text/css" media="all" />
  <link rel="stylesheet" id="sbistyles-css"
    href="web/wp-content/plugins/instagram-feed/css/sbi-styles.minb6a4.css?ver=6.6.1" type="text/css" media="all" />
  <link rel="stylesheet" id="elementor-post-50-css"
    href="web/wp-content/uploads/elementor/css/post-504ed0.css?ver=1738195902" type="text/css" media="all" />
  <link rel="stylesheet" id="google-fonts-1-css"
    href="https://fonts.googleapis.com/css?family=Roboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto+Slab%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&amp;display=swap&amp;ver=6.7.1"
    type="text/css" media="all" />
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
  <script type="text/javascript" src="web/wp-includes/js/jquery/jquery.minf43b.js?ver=3.7.1" id="jquery-core-js"></script>
  <script type="text/javascript" src="web/wp-includes/js/jquery/jquery-migrate.min5589.js?ver=3.4.1"
    id="jquery-migrate-js"></script>
  <link rel="https://api.w.org/" href="index52f0.json?rest_route=/" />
  <link rel="alternate" title="JSON" type="application/json" href="index8f01.json?rest_route=/wp/v2/pages/50" />
  <link rel="EditURI" type="application/rsd+xml" title="RSD" href="xmlrpc0db0.php?rsd" />
  <meta name="generator" content="WordPress 6.7.1" />
  <link rel="canonical" href="index.php" />
  <link rel="shortlink" href="index.php" />
  <link rel="alternate" title="oEmbed (JSON)" type="application/json+oembed"
    href="indexc25b.json?rest_route=%2Foembed%2F1.0%2Fembed&amp;url=http%3A%2F%2Flocalhost%2Fnwc%2F" />
  <link rel="alternate" title="oEmbed (XML)" type="text/xml+oembed"
    href="indexa4ad.php?rest_route=%2Foembed%2F1.0%2Fembed&amp;url=http%3A%2F%2Flocalhost%2Fnwc%2F&amp;format=xml" />
  <meta name="generator"
    content="Elementor 3.27.1; features: e_font_icon_svg, additional_custom_breakpoints, e_element_cache; settings: css_print_method-external, google_font-enabled, font_display-swap" />
  <style>
    .e-con.e-parent:nth-of-type(n + 4):not(.e-lazyloaded):not(.e-no-lazyload),
    .e-con.e-parent:nth-of-type(n + 4):not(.e-lazyloaded):not(.e-no-lazyload) * {
      background-image: none !important;
    }

    @media screen and (max-height: 1024px) {

      .e-con.e-parent:nth-of-type(n + 3):not(.e-lazyloaded):not(.e-no-lazyload),
      .e-con.e-parent:nth-of-type(n + 3):not(.e-lazyloaded):not(.e-no-lazyload) * {
        background-image: none !important;
      }
    }

    @media screen and (max-height: 640px) {

      .e-con.e-parent:nth-of-type(n + 2):not(.e-lazyloaded):not(.e-no-lazyload),
      .e-con.e-parent:nth-of-type(n + 2):not(.e-lazyloaded):not(.e-no-lazyload) * {
        background-image: none !important;
      }
    }

    @media screen and (min-width: 1068px) {

      .elementor-column.elementor-col-33.elementor-top-column.elementor-element {
        --display: flex;
        --align-items: center;
        --container-widget-width: calc((1 - var(--container-widget-flex-grow))* 100%);
        border-style: solid;
        --border-style: solid;
        border-width: 0px 1px 0px 0px;
        --border-top-width: 0px;
        --border-right-width: 1px;
        --border-bottom-width: 0px;
        --border-left-width: 0px;
        border-color: #D1D1D1;
        --border-color: #D1D1D1;
        --padding-top: 40px;
        --padding-bottom: 40px;
        --padding-left: 120px;
        --padding-right: 120px;
        margin-left: 30px;
        margin: 1rem;

      }

    }

    @media screen and (max-width: 668px) {

      .elementor-column.elementor-col-33.elementor-top-column.elementor-element {
        border-style: solid;
        --border-style: solid;
        border-width: 0px 0px 1px 0px;
        border-color: #D1D1D1;
        margin-left: 30px;
        margin-right: 30px;
        margin: 1rem;
        padding-bottom: 4rem;


      }

    }
  </style>
  <meta name="generator"
    content="Powered by Slider Revolution 6.6.13 - responsive, Mobile-Friendly Slider Plugin for WordPress with comfortable drag and drop interface." />
  <script>
    function setREVStartSize(e) {
      //window.requestAnimationFrame(function() {
      window.RSIW =
        window.RSIW === undefined ? window.innerWidth : window.RSIW;
      window.RSIH =
        window.RSIH === undefined ? window.innerHeight : window.RSIH;
      try {
        var pw = document.getElementById(e.c).parentNode.offsetWidth,
          newh;
        pw =
          pw === 0 ||
            isNaN(pw) ||
            e.l == "fullwidth" ||
            e.layout == "fullwidth" ?
            window.RSIW :
            pw;
        e.tabw = e.tabw === undefined ? 0 : parseInt(e.tabw);
        e.thumbw = e.thumbw === undefined ? 0 : parseInt(e.thumbw);
        e.tabh = e.tabh === undefined ? 0 : parseInt(e.tabh);
        e.thumbh = e.thumbh === undefined ? 0 : parseInt(e.thumbh);
        e.tabhide = e.tabhide === undefined ? 0 : parseInt(e.tabhide);
        e.thumbhide = e.thumbhide === undefined ? 0 : parseInt(e.thumbhide);
        e.mh =
          e.mh === undefined || e.mh == "" || e.mh === "auto" ?
            0 :
            parseInt(e.mh, 0);
        if (e.layout === "fullscreen" || e.l === "fullscreen")
          newh = Math.max(e.mh, window.RSIH);
        else {
          e.gw = Array.isArray(e.gw) ? e.gw : [e.gw];
          for (var i in e.rl)
            if (e.gw[i] === undefined || e.gw[i] === 0) e.gw[i] = e.gw[i - 1];
          e.gh =
            e.el === undefined ||
              e.el === "" ||
              (Array.isArray(e.el) && e.el.length == 0) ?
              e.gh :
              e.el;
          e.gh = Array.isArray(e.gh) ? e.gh : [e.gh];
          for (var i in e.rl)
            if (e.gh[i] === undefined || e.gh[i] === 0) e.gh[i] = e.gh[i - 1];

          var nl = new Array(e.rl.length),
            ix = 0,
            sl;
          e.tabw = e.tabhide >= pw ? 0 : e.tabw;
          e.thumbw = e.thumbhide >= pw ? 0 : e.thumbw;
          e.tabh = e.tabhide >= pw ? 0 : e.tabh;
          e.thumbh = e.thumbhide >= pw ? 0 : e.thumbh;
          for (var i in e.rl) nl[i] = e.rl[i] < window.RSIW ? 0 : e.rl[i];
          sl = nl[0];
          for (var i in nl)
            if (sl > nl[i] && nl[i] > 0) {
              sl = nl[i];
              ix = i;
            }
          var m =
            pw > e.gw[ix] + e.tabw + e.thumbw ?
              1 :
              (pw - (e.tabw + e.thumbw)) / e.gw[ix];
          newh = e.gh[ix] * m + (e.tabh + e.thumbh);
        }
        var el = document.getElementById(e.c);
        if (el !== null && el) el.style.height = newh + "px";
        el = document.getElementById(e.c + "_wrapper");
        if (el !== null && el) {
          el.style.height = newh + "px";
          el.style.display = "block";
        }
      } catch (e) {
        console.log("Failure at Presize of Slider:" + e);
      }
      //});
    }
  </script>
</head>

<body class=" home page-template page-template-page-full-width page-template-page-full-width-php page page-id-50 qi-blocks-1.3.4 qodef-gutenberg--no-touch qode-framework-1.2.2 qodef-qi--no-touch qi-addons-for-elementor-1.8.4 qodef-back-to-top--enabled qodef-custom-cursor--enabled qodef-fullscreen-menu--hide-logo qodef-fullscreen-menu--hide-widget-area qodef-content-behind-header qodef-header--standard qodef-header-appearance--sticky qodef-header--transparent qodef-content--behind-header qodef-mobile-header--standard qodef-drop-down-second--full-width qodef-drop-down-second--default Newworld Cargo-core-1.1 Newworld Cargo-child-1.0 Newworld Cargo-1.2.1 qodef-content-grid-1400 qodef-header-standard--right elementor-default elementor-kit-7 elementor-page elementor-page-50"
  itemscope itemtype="https://schema.org/WebPage">
  <a class="skip-link screen-reader-text" href="#qodef-page-content">Skip to the content</a>
  <div id="qodef-page-wrapper" class=" containerr">
    <div id="qodef-menu-cover"></div>

    @include('components.Header')
    <div id="qodef-page-outer">
      <div id="qodef-page-inner" class="qodef-content-full-width">
        <main id="qodef-page-content" class="qodef-grid qodef-layout--template" role="main">
          <div class="qodef-grid-inner clear">
            <div class="qodef-grid-item qodef-page-content-section qodef-col--12">
              <div data-elementor-type="wp-page" data-elementor-id="50" class="elementor elementor-50" data-elementor-post-type="page">
                @yield('content')
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>

    @include('components.footer')
    @include('components.top')
    @include('components.mouse')
    @include('components.Side')
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
        const images = document.querySelectorAll("img");

        images.forEach(img => {
            const src = img.getAttribute("src");
            if (!src) return;
            const cachedImage = localStorage.getItem(`cachedImg_${src}`);
            if (cachedImage) {
                img.src = cachedImage;
            } else {
                cacheImage(img, src);
            }
        });

        function cacheImage(img, src) {
            fetch(src)
            .then(response => response.blob())
            .then(blob => {
                const reader = new FileReader();
                reader.onloadend = function () {
                    const base64data = reader.result;
                    try {
                        localStorage.setItem(`cachedImg_${src}`, base64data);
                        img.src = base64data;
                    } catch (e) {
                        console.warn("LocalStorage quota exceeded. Image not cached.");
                    }
                };
                reader.readAsDataURL(blob);
            })
            .catch(err => console.error("Image fetch error:", err));
        }
    });
  </script>
  <script>
    window.RS_MODULES = window.RS_MODULES || {};
    window.RS_MODULES.modules = window.RS_MODULES.modules || {};
    window.RS_MODULES.waiting = window.RS_MODULES.waiting || [];
    window.RS_MODULES.defered = true;
    window.RS_MODULES.moduleWaiting = window.RS_MODULES.moduleWaiting || {};
    window.RS_MODULES.type = "compiled";
  </script>
  <!-- Instagram Feed JS -->
  <script type="text/javascript">
    var sbiajaxurl = "web/wp-admin/admin-ajax.html";
  </script>
  <script>
    const lazyloadRunObserver = () => {
      const lazyloadBackgrounds = document.querySelectorAll(
        `.e-con.e-parent:not(.e-lazyloaded)`
      );
      const lazyloadBackgroundObserver = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              let lazyloadBackground = entry.target;
              if (lazyloadBackground) {
                lazyloadBackground.classList.add("e-lazyloaded");
              }
              lazyloadBackgroundObserver.unobserve(entry.target);
            }
          });
        }, {
        rootMargin: "200px 0px 200px 0px"
      }
      );
      lazyloadBackgrounds.forEach((lazyloadBackground) => {
        lazyloadBackgroundObserver.observe(lazyloadBackground);
      });
    };
    const events = ["DOMContentLoaded", "elementor/lazyload/observe"];
    events.forEach((event) => {
      document.addEventListener(event, lazyloadRunObserver);
    });
  </script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:700%2C400%7CRoboto:400&amp;display=swap" rel="stylesheet"
    property="stylesheet" media="all" type="text/css" />

  <script>
    if (typeof revslider_showDoubleJqueryError === "undefined") {
      function revslider_showDoubleJqueryError(sliderID) {
        console.log(
          "You have some jquery.js library include that comes after the Slider Revolution files js inclusion."
        );
        console.log("To fix this, you can:");
        console.log(
          "1. Set 'Module General Options' -> 'Advanced' -> 'jQuery & OutPut Filters' -> 'Put JS to Body' to on"
        );
        console.log("2. Find the double jQuery.js inclusion and remove it");
        return "Double Included jQuery Library";
      }
    }
  </script>
  <link rel="stylesheet" id="mediaelement-css"
    href="web/wp-includes/js/mediaelement/mediaelementplayer-legacy.min1f61.css?ver=4.2.17" type="text/css" media="all" />
  <link rel="stylesheet" id="wp-mediaelement-css"
    href="web/wp-includes/js/mediaelement/wp-mediaelement.min9704.css?ver=6.7.1" type="text/css" media="all" />
  <style id="wp-block-image-inline-css" type="text/css">
    .wp-block-image a {
      display: inline-block;
    }

    .wp-block-image img {
      box-sizing: border-box;
      height: auto;
      max-width: 100%;
      vertical-align: bottom;
    }

    @media (prefers-reduced-motion: no-preference) {
      .wp-block-image img.hide {
        visibility: hidden;
      }

      .wp-block-image img.show {
        animation: show-content-image 0.4s;
      }
    }

    .wp-block-image[style*="border-radius"] img,
    .wp-block-image[style*="border-radius"]>a {
      border-radius: inherit;
    }

    .wp-block-image.has-custom-border img {
      box-sizing: border-box;
    }

    .wp-block-image.aligncenter {
      text-align: center;
    }

    .wp-block-image.alignfull a,
    .wp-block-image.alignwide a {
      width: 100%;
    }

    .wp-block-image.alignfull img,
    .wp-block-image.alignwide img {
      height: auto;
      width: 100%;
    }

    .wp-block-image .aligncenter,
    .wp-block-image .alignleft,
    .wp-block-image .alignright,
    .wp-block-image.aligncenter,
    .wp-block-image.alignleft,
    .wp-block-image.alignright {
      display: table;
    }

    .wp-block-image .aligncenter>figcaption,
    .wp-block-image .alignleft>figcaption,
    .wp-block-image .alignright>figcaption,
    .wp-block-image.aligncenter>figcaption,
    .wp-block-image.alignleft>figcaption,
    .wp-block-image.alignright>figcaption {
      caption-side: bottom;
      display: table-caption;
    }

    .wp-block-image .alignleft {
      float: left;
      margin: 0.5em 1em 0.5em 0;
    }

    .wp-block-image .alignright {
      float: right;
      margin: 0.5em 0 0.5em 1em;
    }

    .wp-block-image .aligncenter {
      margin-left: auto;
      margin-right: auto;
    }

    .wp-block-image :where(figcaption) {
      margin-bottom: 1em;
      margin-top: 0.5em;
    }

    .wp-block-image.is-style-circle-mask img {
      border-radius: 9999px;
    }

    @supports ((-webkit-mask-image: none) or (mask-image: none)) or (-webkit-mask-image: none) {
      .wp-block-image.is-style-circle-mask img {
        border-radius: 0;
        -webkit-mask-image: url('data:image/svg+xml;utf8,<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="50"/></svg>');
        mask-image: url('data:image/svg+xml;utf8,<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="50"/></svg>');
        mask-mode: alpha;
        -webkit-mask-position: center;
        mask-position: center;
        -webkit-mask-repeat: no-repeat;
        mask-repeat: no-repeat;
        -webkit-mask-size: contain;
        mask-size: contain;
      }
    }

    :root :where(.wp-block-image.is-style-rounded img,
      .wp-block-image .is-style-rounded img) {
      border-radius: 9999px;
    }

    .wp-block-image figure {
      margin: 0;
    }

    .wp-lightbox-container {
      display: flex;
      flex-direction: column;
      position: relative;
    }

    .wp-lightbox-container img {
      cursor: zoom-in;
    }

    .wp-lightbox-container img:hover+button {
      opacity: 1;
    }

    .wp-lightbox-container button {
      align-items: center;
      -webkit-backdrop-filter: blur(16px) saturate(180%);
      backdrop-filter: blur(16px) saturate(180%);
      background-color: #5a5a5a40;
      border: none;
      border-radius: 4px;
      cursor: zoom-in;
      display: flex;
      height: 20px;
      justify-content: center;
      opacity: 0;
      padding: 0;
      position: absolute;
      right: 16px;
      text-align: center;
      top: 16px;
      transition: opacity 0.2s ease;
      width: 20px;
      z-index: 100;
    }

    .wp-lightbox-container button:focus-visible {
      outline: 3px auto #5a5a5a40;
      outline: 3px auto -webkit-focus-ring-color;
      outline-offset: 3px;
    }

    .wp-lightbox-container button:hover {
      cursor: pointer;
      opacity: 1;
    }

    .wp-lightbox-container button:focus {
      opacity: 1;
    }

    .wp-lightbox-container button:focus,
    .wp-lightbox-container button:hover,
    .wp-lightbox-container button:not(:hover):not(:active):not(.has-background) {
      background-color: #5a5a5a40;
      border: none;
    }

    .wp-lightbox-overlay {
      box-sizing: border-box;
      cursor: zoom-out;
      height: 100vh;
      left: 0;
      overflow: hidden;
      position: fixed;
      top: 0;
      visibility: hidden;
      width: 100%;
      z-index: 100000;
    }

    .wp-lightbox-overlay .close-button {
      align-items: center;
      cursor: pointer;
      display: flex;
      justify-content: center;
      min-height: 40px;
      min-width: 40px;
      padding: 0;
      position: absolute;
      right: calc(env(safe-area-inset-right) + 16px);
      top: calc(env(safe-area-inset-top) + 16px);
      z-index: 5000000;
    }

    .wp-lightbox-overlay .close-button:focus,
    .wp-lightbox-overlay .close-button:hover,
    .wp-lightbox-overlay .close-button:not(:hover):not(:active):not(.has-background) {
      background: none;
      border: none;
    }

    .wp-lightbox-overlay .lightbox-image-container {
      height: var(--wp--lightbox-container-height);
      left: 50%;
      overflow: hidden;
      position: absolute;
      top: 50%;
      transform: translate(-50%, -50%);
      transform-origin: top left;
      width: var(--wp--lightbox-container-width);
      z-index: 9999999999;
    }

    .wp-lightbox-overlay .wp-block-image {
      align-items: center;
      box-sizing: border-box;
      display: flex;
      height: 100%;
      justify-content: center;
      margin: 0;
      position: relative;
      transform-origin: 0 0;
      width: 100%;
      z-index: 3000000;
    }

    .wp-lightbox-overlay .wp-block-image img {
      height: var(--wp--lightbox-image-height);
      min-height: var(--wp--lightbox-image-height);
      min-width: var(--wp--lightbox-image-width);
      width: var(--wp--lightbox-image-width);
    }

    .wp-lightbox-overlay .wp-block-image figcaption {
      display: none;
    }

    .wp-lightbox-overlay button {
      background: none;
      border: none;
    }

    .wp-lightbox-overlay .scrim {
      background-color: #fff;
      height: 100%;
      opacity: 0.9;
      position: absolute;
      width: 100%;
      z-index: 2000000;
    }

    .wp-lightbox-overlay.active {
      animation: turn-on-visibility 0.25s both;
      visibility: visible;
    }

    .wp-lightbox-overlay.active img {
      animation: turn-on-visibility 0.35s both;
    }

    .wp-lightbox-overlay.show-closing-animation:not(.active) {
      animation: turn-off-visibility 0.35s both;
    }

    .wp-lightbox-overlay.show-closing-animation:not(.active) img {
      animation: turn-off-visibility 0.25s both;
    }

    @media (prefers-reduced-motion: no-preference) {
      .wp-lightbox-overlay.zoom.active {
        animation: none;
        opacity: 1;
        visibility: visible;
      }

      .wp-lightbox-overlay.zoom.active .lightbox-image-container {
        animation: lightbox-zoom-in 0.4s;
      }

      .wp-lightbox-overlay.zoom.active .lightbox-image-container img {
        animation: none;
      }

      .wp-lightbox-overlay.zoom.active .scrim {
        animation: turn-on-visibility 0.4s forwards;
      }

      .wp-lightbox-overlay.zoom.show-closing-animation:not(.active) {
        animation: none;
      }

      .wp-lightbox-overlay.zoom.show-closing-animation:not(.active) .lightbox-image-container {
        animation: lightbox-zoom-out 0.4s;
      }

      .wp-lightbox-overlay.zoom.show-closing-animation:not(.active) .lightbox-image-container img {
        animation: none;
      }

      .wp-lightbox-overlay.zoom.show-closing-animation:not(.active) .scrim {
        animation: turn-off-visibility 0.4s forwards;
      }
    }

    @keyframes show-content-image {
      0% {
        visibility: hidden;
      }

      99% {
        visibility: hidden;
      }

      to {
        visibility: visible;
      }
    }

    @keyframes turn-on-visibility {
      0% {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    @keyframes turn-off-visibility {
      0% {
        opacity: 1;
        visibility: visible;
      }

      99% {
        opacity: 0;
        visibility: visible;
      }

      to {
        opacity: 0;
        visibility: hidden;
      }
    }

    @keyframes lightbox-zoom-in {
      0% {
        transform: translate(calc((-100vw + var(--wp--lightbox-scrollbar-width)) / 2 + var(--wp--lightbox-initial-left-position)),
            calc(-50vh + var(--wp--lightbox-initial-top-position))) scale(var(--wp--lightbox-scale));
      }

      to {
        transform: translate(-50%, -50%) scale(1);
      }
    }

    @keyframes lightbox-zoom-out {
      0% {
        transform: translate(-50%, -50%) scale(1);
        visibility: visible;
      }

      99% {
        visibility: visible;
      }

      to {
        transform: translate(calc((-100vw + var(--wp--lightbox-scrollbar-width)) / 2 + var(--wp--lightbox-initial-left-position)),
            calc(-50vh + var(--wp--lightbox-initial-top-position))) scale(var(--wp--lightbox-scale));
        visibility: hidden;
      }
    }
  </style>
  <style id="wp-block-columns-inline-css" type="text/css">
    .wp-block-columns {
      align-items: normal !important;
      box-sizing: border-box;
      display: flex;
      flex-wrap: wrap !important;
    }

    @media (min-width: 782px) {
      .wp-block-columns {
        flex-wrap: nowrap !important;
      }
    }

    .wp-block-columns.are-vertically-aligned-top {
      align-items: flex-start;
    }

    .wp-block-columns.are-vertically-aligned-center {
      align-items: center;
    }

    .wp-block-columns.are-vertically-aligned-bottom {
      align-items: flex-end;
    }

    @media (max-width: 781px) {
      .wp-block-columns:not(.is-not-stacked-on-mobile)>.wp-block-column {
        flex-basis: 100% !important;
      }
    }

    @media (min-width: 782px) {
      .wp-block-columns:not(.is-not-stacked-on-mobile)>.wp-block-column {
        flex-basis: 0;
        flex-grow: 1;
      }

      .wp-block-columns:not(.is-not-stacked-on-mobile)>.wp-block-column[style*="flex-basis"] {
        flex-grow: 0;
      }
    }

    .wp-block-columns.is-not-stacked-on-mobile {
      flex-wrap: nowrap !important;
    }

    .wp-block-columns.is-not-stacked-on-mobile>.wp-block-column {
      flex-basis: 0;
      flex-grow: 1;
    }

    .wp-block-columns.is-not-stacked-on-mobile>.wp-block-column[style*="flex-basis"] {
      flex-grow: 0;
    }

    :where(.wp-block-columns) {
      margin-bottom: 1.75em;
    }

    :where(.wp-block-columns.has-background) {
      padding: 1.25em 2.375em;
    }

    .wp-block-column {
      flex-grow: 1;
      min-width: 0;
      overflow-wrap: break-word;
      word-break: break-word;
    }

    .wp-block-column.is-vertically-aligned-top {
      align-self: flex-start;
    }

    .wp-block-column.is-vertically-aligned-center {
      align-self: center;
    }

    .wp-block-column.is-vertically-aligned-bottom {
      align-self: flex-end;
    }

    .wp-block-column.is-vertically-aligned-stretch {
      align-self: stretch;
    }

    .wp-block-column.is-vertically-aligned-bottom,
    .wp-block-column.is-vertically-aligned-center,
    .wp-block-column.is-vertically-aligned-top {
      width: 100%;
    }
  </style>
  <style id="global-styles-inline-css" type="text/css">
    :root {
      --wp--preset--aspect-ratio--square: 1;
      --wp--preset--aspect-ratio--4-3: 4/3;
      --wp--preset--aspect-ratio--3-4: 3/4;
      --wp--preset--aspect-ratio--3-2: 3/2;
      --wp--preset--aspect-ratio--2-3: 2/3;
      --wp--preset--aspect-ratio--16-9: 16/9;
      --wp--preset--aspect-ratio--9-16: 9/16;
      --wp--preset--color--black: #000000;
      --wp--preset--color--cyan-bluish-gray: #abb8c3;
      --wp--preset--color--white: #ffffff;
      --wp--preset--color--pale-pink: #f78da7;
      --wp--preset--color--vivid-red: #clemee;
      --wp--preset--color--luminous-vivid-orange: #ff6900;
      --wp--preset--color--luminous-vivid-amber: #fcb900;
      --wp--preset--color--light-green-cyan: #7bdcb5;
      --wp--preset--color--vivid-green-cyan: #00d084;
      --wp--preset--color--pale-cyan-blue: #8ed1fc;
      --wp--preset--color--vivid-cyan-blue: #0693e3;
      --wp--preset--color--vivid-purple: #9b51e0;
      --wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg,
          rgba(6, 147, 227, 1) 0%,
          rgb(155, 81, 224) 100%);
      --wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg,
          rgb(122, 220, 180) 0%,
          rgb(0, 208, 130) 100%);
      --wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg,
          rgba(252, 185, 0, 1) 0%,
          rgba(255, 105, 0, 1) 100%);
      --wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg,
          rgba(255, 105, 0, 1) 0%,
          rgb(207, 46, 46) 100%);
      --wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg,
          rgb(238, 238, 238) 0%,
          rgb(169, 184, 195) 100%);
      --wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg,
          rgb(74, 234, 220) 0%,
          rgb(151, 120, 209) 20%,
          rgb(207, 42, 186) 40%,
          rgb(238, 44, 130) 60%,
          rgb(251, 105, 98) 80%,
          rgb(254, 248, 76) 100%);
      --wp--preset--gradient--blush-light-purple: linear-gradient(135deg,
          rgb(255, 206, 236) 0%,
          rgb(152, 150, 240) 100%);
      --wp--preset--gradient--blush-bordeaux: linear-gradient(135deg,
          rgb(254, 205, 165) 0%,
          rgb(254, 45, 45) 50%,
          rgb(107, 0, 62) 100%);
      --wp--preset--gradient--luminous-dusk: linear-gradient(135deg,
          rgb(255, 203, 112) 0%,
          rgb(199, 81, 192) 50%,
          rgb(65, 88, 208) 100%);
      --wp--preset--gradient--pale-ocean: linear-gradient(135deg,
          rgb(255, 245, 203) 0%,
          rgb(182, 227, 212) 50%,
          rgb(51, 167, 181) 100%);
      --wp--preset--gradient--electric-grass: linear-gradient(135deg,
          rgb(202, 248, 128) 0%,
          rgb(113, 206, 126) 100%);
      --wp--preset--gradient--midnight: linear-gradient(135deg,
          rgb(2, 3, 129) 0%,
          rgb(40, 116, 252) 100%);
      --wp--preset--font-size--small: 13px;
      --wp--preset--font-size--medium: 20px;
      --wp--preset--font-size--large: 36px;
      --wp--preset--font-size--x-large: 42px;
      --wp--preset--spacing--20: 0.44rem;
      --wp--preset--spacing--30: 0.67rem;
      --wp--preset--spacing--40: 1rem;
      --wp--preset--spacing--50: 1.5rem;
      --wp--preset--spacing--60: 2.25rem;
      --wp--preset--spacing--70: 3.38rem;
      --wp--preset--spacing--80: 5.06rem;
      --wp--preset--shadow--natural: 6px 6px 9px rgba(0, 0, 0, 0.2);
      --wp--preset--shadow--deep: 12px 12px 50px rgba(0, 0, 0, 0.4);
      --wp--preset--shadow--sharp: 6px 6px 0px rgba(0, 0, 0, 0.2);
      --wp--preset--shadow--outlined: 6px 6px 0px -3px rgba(255, 255, 255, 1),
        6px 6px rgba(0, 0, 0, 1);
      --wp--preset--shadow--crisp: 6px 6px 0px rgba(0, 0, 0, 1);
    }

    :where(.is-layout-flex) {
      gap: 0.5em;
    }

    :where(.is-layout-grid) {
      gap: 0.5em;
    }

    body .is-layout-flex {
      display: flex;
    }

    .is-layout-flex {
      flex-wrap: wrap;
      align-items: center;
    }

    .is-layout-flex> :is(*, div) {
      margin: 0;
    }

    body .is-layout-grid {
      display: grid;
    }

    .is-layout-grid> :is(*, div) {
      margin: 0;
    }

    :where(.wp-block-columns.is-layout-flex) {
      gap: 2em;
    }

    :where(.wp-block-columns.is-layout-grid) {
      gap: 2em;
    }

    :where(.wp-block-post-template.is-layout-flex) {
      gap: 1.25em;
    }

    :where(.wp-block-post-template.is-layout-grid) {
      gap: 1.25em;
    }

    .has-black-color {
      color: var(--wp--preset--color--black) !important;
    }

    .has-cyan-bluish-gray-color {
      color: var(--wp--preset--color--cyan-bluish-gray) !important;
    }

    .has-white-color {
      color: var(--wp--preset--color--white) !important;
    }

    .has-pale-pink-color {
      color: var(--wp--preset--color--pale-pink) !important;
    }

    .has-vivid-red-color {
      color: var(--wp--preset--color--vivid-red) !important;
    }

    .has-luminous-vivid-orange-color {
      color: var(--wp--preset--color--luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-amber-color {
      color: var(--wp--preset--color--luminous-vivid-amber) !important;
    }

    .has-light-green-cyan-color {
      color: var(--wp--preset--color--light-green-cyan) !important;
    }

    .has-vivid-green-cyan-color {
      color: var(--wp--preset--color--vivid-green-cyan) !important;
    }

    .has-pale-cyan-blue-color {
      color: var(--wp--preset--color--pale-cyan-blue) !important;
    }

    .has-vivid-cyan-blue-color {
      color: var(--wp--preset--color--vivid-cyan-blue) !important;
    }

    .has-vivid-purple-color {
      color: var(--wp--preset--color--vivid-purple) !important;
    }

    .has-black-background-color {
      background-color: var(--wp--preset--color--black) !important;
    }

    .has-cyan-bluish-gray-background-color {
      background-color: var(--wp--preset--color--cyan-bluish-gray) !important;
    }

    .has-white-background-color {
      background-color: var(--wp--preset--color--white) !important;
    }

    .has-pale-pink-background-color {
      background-color: var(--wp--preset--color--pale-pink) !important;
    }

    .has-vivid-red-background-color {
      background-color: var(--wp--preset--color--vivid-red) !important;
    }

    .has-luminous-vivid-orange-background-color {
      background-color: var(--wp--preset--color--luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-amber-background-color {
      background-color: var(--wp--preset--color--luminous-vivid-amber) !important;
    }

    .has-light-green-cyan-background-color {
      background-color: var(--wp--preset--color--light-green-cyan) !important;
    }

    .has-vivid-green-cyan-background-color {
      background-color: var(--wp--preset--color--vivid-green-cyan) !important;
    }

    .has-pale-cyan-blue-background-color {
      background-color: var(--wp--preset--color--pale-cyan-blue) !important;
    }

    .has-vivid-cyan-blue-background-color {
      background-color: var(--wp--preset--color--vivid-cyan-blue) !important;
    }

    .has-vivid-purple-background-color {
      background-color: var(--wp--preset--color--vivid-purple) !important;
    }

    .has-black-border-color {
      border-color: var(--wp--preset--color--black) !important;
    }

    .has-cyan-bluish-gray-border-color {
      border-color: var(--wp--preset--color--cyan-bluish-gray) !important;
    }

    .has-white-border-color {
      border-color: var(--wp--preset--color--white) !important;
    }

    .has-pale-pink-border-color {
      border-color: var(--wp--preset--color--pale-pink) !important;
    }

    .has-vivid-red-border-color {
      border-color: var(--wp--preset--color--vivid-red) !important;
    }

    .has-luminous-vivid-orange-border-color {
      border-color: var(--wp--preset--color--luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-amber-border-color {
      border-color: var(--wp--preset--color--luminous-vivid-amber) !important;
    }

    .has-light-green-cyan-border-color {
      border-color: var(--wp--preset--color--light-green-cyan) !important;
    }

    .has-vivid-green-cyan-border-color {
      border-color: var(--wp--preset--color--vivid-green-cyan) !important;
    }

    .has-pale-cyan-blue-border-color {
      border-color: var(--wp--preset--color--pale-cyan-blue) !important;
    }

    .has-vivid-cyan-blue-border-color {
      border-color: var(--wp--preset--color--vivid-cyan-blue) !important;
    }

    .has-vivid-purple-border-color {
      border-color: var(--wp--preset--color--vivid-purple) !important;
    }

    .has-vivid-cyan-blue-to-vivid-purple-gradient-background {
      background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;
    }

    .has-light-green-cyan-to-vivid-green-cyan-gradient-background {
      background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;
    }

    .has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background {
      background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-orange-to-vivid-red-gradient-background {
      background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;
    }

    .has-very-light-gray-to-cyan-bluish-gray-gradient-background {
      background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;
    }

    .has-cool-to-warm-spectrum-gradient-background {
      background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;
    }

    .has-blush-light-purple-gradient-background {
      background: var(--wp--preset--gradient--blush-light-purple) !important;
    }

    .has-blush-bordeaux-gradient-background {
      background: var(--wp--preset--gradient--blush-bordeaux) !important;
    }

    .has-luminous-dusk-gradient-background {
      background: var(--wp--preset--gradient--luminous-dusk) !important;
    }

    .has-pale-ocean-gradient-background {
      background: var(--wp--preset--gradient--pale-ocean) !important;
    }

    .has-electric-grass-gradient-background {
      background: var(--wp--preset--gradient--electric-grass) !important;
    }

    .has-midnight-gradient-background {
      background: var(--wp--preset--gradient--midnight) !important;
    }

    .has-small-font-size {
      font-size: var(--wp--preset--font-size--small) !important;
    }

    .has-medium-font-size {
      font-size: var(--wp--preset--font-size--medium) !important;
    }

    .has-large-font-size {
      font-size: var(--wp--preset--font-size--large) !important;
    }

    .has-x-large-font-size {
      font-size: var(--wp--preset--font-size--x-large) !important;
    }

    :where(.wp-block-columns.is-layout-flex) {
      gap: 2em;
    }

    :where(.wp-block-columns.is-layout-grid) {
      gap: 2em;
    }
  </style>
  <style id="core-block-supports-inline-css" type="text/css">
    .wp-container-core-columns-is-layout-1 {
      flex-wrap: nowrap;
    }
  </style>
  <link rel="stylesheet" id="rs-plugin-settings-css"
    href="web/wp-content/plugins/revslider/public/assets/css/rs6e8c6.css?ver=6.6.13" type="text/css" media="all" />
  <style id="rs-plugin-settings-inline-css" type="text/css">
    #rev_slider_1_1_wrapper .globefarer_arrows.tparrows {
      cursor: pointer;
      background: transparent;
      width: 90px;
      height: 90px;
      position: absolute;
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1000;
      border-radius: 50%;
    }

    #rev_slider_1_1_wrapper .globefarer_arrows.tparrows:after {
      content: "";
      display: block;
      width: 100%;
      height: 100%;
      background-color: #f7c600;
      border-radius: 50%;
      position: absolute;
      z-index: -1;
      opacity: 0;
      transform: translateX(-5px) scale(0);
      transition: transform 0.3s cubic-bezier(0.1, 0, 0.3, 1),
        opacity 0.3s ease;
    }

    #rev_slider_1_1_wrapper .globefarer_arrows.tparrows:hover {
      background: transparent;
    }

    #rev_slider_1_1_wrapper .globefarer_arrows.tparrows:hover:after {
      opacity: 1;
      transform: translateX(-5px) scale(1);
    }

    #rev_slider_1_1_wrapper .globefarer_arrows.tparrows:hover svg {
      transform: translateX(-9px);
    }

    #rev_slider_1_1_wrapper .globefarer_arrows.tparrows:hover svg .qodef-m-oblique {
      width: 20px;
    }

    #rev_slider_1_1_wrapper .globefarer_arrows.tparrows:hover svg .qodef-m-horizontal {
      width: 32px;
    }

    #rev_slider_1_1_wrapper .globefarer_arrows.tparrows svg {
      fill: #ffffff;
      overflow: visible;
      transform: translateX(0);
      transition: transform 0.3s ease;
    }

    #rev_slider_1_1_wrapper .globefarer_arrows.tparrows svg .qodef-m-oblique {
      width: 34px;
      height: 2px;
      transition: width 0.3s ease;
    }

    #rev_slider_1_1_wrapper .globefarer_arrows.tparrows svg .qodef-m-horizontal {
      width: 0px;
      height: 2px;
      transition: width 0.3s ease;
    }

    #rev_slider_1_1_wrapper .globefarer_arrows.tparrows.tp-rightarrow {
      transform: rotate(180deg);
    }

    #rev_slider_1_1_wrapper .globefarer_arrows.tparrows.tp-leftarrow:before {
      display: none;
    }

    #rev_slider_1_1_wrapper .globefarer_arrows.tparrows.tp-rightarrow:before {
      display: none;
    }

    #rev_slider_1_1_wrapper .globefarer_tabs .tp-tab-mask {
      padding-bottom: 32px !important;
    }

    #rev_slider_1_1_wrapper .globefarer_tabs .tp-tab {
      width: 410px;
      height: 77px !important;
      opacity: 1 !important;
      text-align: left;
    }

    #rev_slider_1_1_wrapper .globefarer_tabs .tp-tab:before {
      content: "";
      position: absolute;
      left: 0;
      bottom: 35px;
      height: 1px;
      background: rgba(255, 255, 255, 0.5);
      width: calc(100%);
      transition: 0.5s ease-in-out;
    }

    #rev_slider_1_1_wrapper .globefarer_tabs .tp-tab:after {
      content: "";
      position: absolute;
      left: 0;
      bottom: 34px;
      height: 3px;
      background: var(--qode-main-color);
      width: 0;
      transition: 0.5s ease-in-out;
      z-index: 12;
    }

    #rev_slider_1_1_wrapper .globefarer_tabs .tp-tab-title {
      font-size: 18px;
      font-weight: 400;
      color: #ffffff;
      line-height: 26px;
      font-family: "Poppins", sans-serif;
      transition: all 0.2s ease-in-out;
    }

    #rev_slider_1_1_wrapper .globefarer_tabs .tp-tab.rs-touchhover:after {
      transition: 0.5s ease-in-out;
      width: 100%;
    }

    #rev_slider_1_1_wrapper .globefarer_tabs .tp-tab.selected:after {
      transition: 3s ease-in-out;
      width: 100%;
    }
  </style>
  <script type="text/javascript" src="web/wp-includes/js/dist/hooks.min4fdd.js?ver=4d63a3d491d11ffd8ac6"
    id="wp-hooks-js"></script>
  <script type="text/javascript" src="web/wp-includes/js/dist/i18n.minc33c.js?ver=5e580eb46a90c2b997e6"
    id="wp-i18n-js"></script>
  <script type="text/javascript" id="wp-i18n-js-after">
    /* <![CDATA[ */
    wp.i18n.setLocaleData({
      "text direction\u0004ltr": ["ltr"]
    });
    /* ]]> */
  </script>
  <script type="text/javascript" src="web/wp-content/plugins/contact-form-7/includes/swv/js/index1eb7.js?ver=6.0.3"
    id="swv-js"></script>
  <script type="text/javascript" id="contact-form-7-js-before">
  </script>
  <script type="text/javascript" src="web/wp-content/plugins/contact-form-7/includes/js/index1eb7.js?ver=6.0.3"
    id="contact-form-7-js"></script>
  <script type="text/javascript" id="cf7msm-js-extra">
    /* <![CDATA[ */
    var cf7msm_posted_data = [];
    var cf7msm_redirect_urls = [];
    /* ]]> */
  </script>
  <script type="text/javascript"
    src="web/wp-content/plugins/contact-form-7-multi-step-module/resources/cf7msm.mina94e.js?ver=4.4.1"
    id="cf7msm-js"></script>
  <script type="text/javascript" id="qi-blocks-main-js-extra">
    /* <![CDATA[ */
    var qiBlocks = {
      vars: {
        arrowLeftIcon: '<svg xmlns="http:\/\/www.w3.org\/2000\/svg" xmlns:xlink="http:\/\/www.w3.org\/1999\/xlink" x="0px" y="0px" viewBox="0 0 34.2 32.3" xml:space="preserve" style="stroke-width: 2;"><line x1="0.5" y1="16" x2="33.5" y2="16"\/><line x1="0.3" y1="16.5" x2="16.2" y2="0.7"\/><line x1="0" y1="15.4" x2="16.2" y2="31.6"\/><\/svg>',
        arrowRightIcon: '<svg xmlns="http:\/\/www.w3.org\/2000\/svg" xmlns:xlink="http:\/\/www.w3.org\/1999\/xlink" x="0px" y="0px" viewBox="0 0 34.2 32.3" xml:space="preserve" style="stroke-width: 2;"><line x1="0" y1="16" x2="33" y2="16"\/><line x1="17.3" y1="0.7" x2="33.2" y2="16.5"\/><line x1="17.3" y1="31.6" x2="33.5" y2="15.4"\/><\/svg>',
        closeIcon: '<svg xmlns="http:\/\/www.w3.org\/2000\/svg" xmlns:xlink="http:\/\/www.w3.org\/1999\/xlink" x="0px" y="0px" viewBox="0 0 9.1 9.1" xml:space="preserve"><g><path d="M8.5,0L9,0.6L5.1,4.5L9,8.5L8.5,9L4.5,5.1L0.6,9L0,8.5L4,4.5L0,0.6L0.6,0L4.5,4L8.5,0z"\/><\/g><\/svg>',
        viewCartText: "View Cart",
      },
    };
    /* ]]> */
  </script>
  <script type="text/javascript" src="web/wp-content/plugins/qi-blocks/assets/dist/mainc412.js?ver=1.3.4"
    id="qi-blocks-main-js"></script>
  <script type="text/javascript" src="web/wp-content/plugins/revslider/public/assets/js/rbtools.mine8c6.js?ver=6.6.13" defer
    async id="tp-tools-js"></script>
  <script type="text/javascript" src="web/wp-content/plugins/revslider/public/assets/js/rs6.mine8c6.js?ver=6.6.13" defer
    async id="revmin-js"></script>
  <script type="text/javascript" src="web/wp-includes/js/jquery/ui/core.minb37e.js?ver=1.13.3"
    id="jquery-ui-core-js"></script>
  <script type="text/javascript" id="qi-addons-for-elementor-script-js-extra">
    /* <![CDATA[ */
    var qodefQiAddonsGlobal = {
      vars: {
        adminBarHeight: 0,
        iconArrowLeft: '<svg  xmlns="http:\/\/www.w3.org\/2000\/svg" x="0px" y="0px" viewBox="0 0 34.2 32.3" xml:space="preserve" style="stroke-width: 2;"><line x1="0.5" y1="16" x2="33.5" y2="16"\/><line x1="0.3" y1="16.5" x2="16.2" y2="0.7"\/><line x1="0" y1="15.4" x2="16.2" y2="31.6"\/><\/svg>',
        iconArrowRight: '<svg  xmlns="http:\/\/www.w3.org\/2000\/svg" x="0px" y="0px" viewBox="0 0 34.2 32.3" xml:space="preserve" style="stroke-width: 2;"><line x1="0" y1="16" x2="33" y2="16"\/><line x1="17.3" y1="0.7" x2="33.2" y2="16.5"\/><line x1="17.3" y1="31.6" x2="33.5" y2="15.4"\/><\/svg>',
        iconClose: '<svg  xmlns="http:\/\/www.w3.org\/2000\/svg" x="0px" y="0px" viewBox="0 0 9.1 9.1" xml:space="preserve"><g><path d="M8.5,0L9,0.6L5.1,4.5L9,8.5L8.5,9L4.5,5.1L0.6,9L0,8.5L4,4.5L0,0.6L0.6,0L4.5,4L8.5,0z"\/><\/g><\/svg>',
      },
    };
    /* ]]> */
  </script>
  <script type="text/javascript" src="web/wp-content/plugins/qi-addons-for-elementor/assets/js/main.min29af.js?ver=1.8.4"
    id="qi-addons-for-elementor-script-js"></script>
  <script type="text/javascript"
    src="web/wp-content/plugins/globefarer-core/assets/plugins/perfect-scrollbar/perfect-scrollbar.jquery.min9704.js?ver=6.7.1"
    id="perfect-scrollbar-js"></script>
  <script type="text/javascript" src="web/wp-includes/js/hoverIntent.min3e5a.js?ver=1.10.2" id="hoverIntent-js"></script>
  <script type="text/javascript"
    src="web/wp-content/plugins/globefarer-core/assets/plugins/modernizr/modernizr9704.js?ver=6.7.1"
    id="modernizr-js"></script>
  <script type="text/javascript"
    src="web/wp-content/plugins/qi-addons-for-elementor/inc/shortcodes/parallax-images/assets/js/plugins/jquery.parallax-scroll68b3.js?ver=1"
    id="parallax-scroll-js"></script>
  <script type="text/javascript" src="web/wp-content/plugins/globefarer-core/assets/plugins/gsap/gsap.min9704.js?ver=6.7.1"
    id="gsap-js"></script>
  <script type="text/javascript" id="globefarer-main-js-js-extra">
    /* <![CDATA[ */
    var qodefGlobal = {
      vars: {
        adminBarHeight: 0,
        iconArrowLeft: '<svg class="qodef-svg--slider-arrow-left" xmlns="http:\/\/www.w3.org\/2000\/svg" width="25.456" height="48.083" viewBox="0 0 25.456 48.083"><rect class="qodef-m-oblique" width="100%" height="100%" transform="translate(1.414 22.627) rotate(45)" \/><rect class="qodef-m-oblique" width="100%" height="100%" transform="translate(0 24.042) rotate(-45)" \/><rect class="qodef-m-horizontal" width="32" height="2" transform="translate(2.433 23.042)" \/><\/svg>',
        iconArrowRight: '<svg class="qodef-svg--slider-arrow-right" xmlns="http:\/\/www.w3.org\/2000\/svg" width="25.456" height="48.083" viewBox="0 0 25.456 48.083"><rect class="qodef-m-oblique" width="100%" height="100%" transform="translate(25.456 24.042) rotate(135)" \/><rect class="qodef-m-oblique" width="100%" height="100%" transform="translate(24.042 25.456) rotate(-135)" \/><rect class="qodef-m-horizontal" width="32" height="2" transform="translate(23.023 25.042) rotate(180)" \/><\/svg>',
        iconClose: '<svg class="qodef-svg--close" xmlns="http:\/\/www.w3.org\/2000\/svg" xmlns:xlink="http:\/\/www.w3.org\/1999\/xlink" width="19.778" height="19.778" viewBox="0 0 19.778 19.778"><g transform="translate(-30 -30)"><rect width="13" height="2" transform="translate(31.414 30) rotate(45)"\/><rect width="13" height="2" transform="translate(48.364 49.778) rotate(-135)"\/><rect width="13" height="2" transform="translate(30 48.364) rotate(-45)"\/><rect width="13" height="2" transform="translate(49.778 31.414) rotate(135)"\/><\/g><\/svg>',
        qodefStickyHeaderScrollAmount: 650,
        topAreaHeight: 0,
        
        restNonce: "c07de431ab",
        paginationRestRoute: "globefarer\/v1\/get-posts",
        headerHeight: 80,
        mobileHeaderHeight: 80,
      },
    };
    /* ]]> */
  </script>
  <script type="text/javascript" src="web/wp-content/themes/globefarer/assets/js/main.min9704.js?ver=6.7.1"
    id="globefarer-main-js-js"></script>
  <script type="text/javascript" src="web/wp-content/plugins/globefarer-core/assets/js/globefarer-core.min9704.js?ver=6.7.1"
    id="globefarer-core-script-js"></script>
  <script type="text/javascript"
    src="web/wp-content/plugins/qi-addons-for-elementor/assets/plugins/swiper/8.4.5/swiper.min9704.js?ver=6.7.1"
    id="swiper-js"></script>
  <script type="text/javascript" src="web/wp-includes/js/jquery/ui/tabs.minb37e.js?ver=1.13.3"
    id="jquery-ui-tabs-js"></script>
  <script type="text/javascript"
    src="web/wp-content/plugins/qi-blocks/inc/masonry/assets/plugins/isotope.pkgd.min7c45.js?ver=3.0.6"
    id="isotope-js"></script>
  <script type="text/javascript"
    src="web/wp-content/plugins/qi-blocks/inc/masonry/assets/plugins/packery-mode.pkgd.min7406.js?ver=2.0.1"
    id="packery-js"></script>
  <script type="text/javascript" id="mediaelement-core-js-before">
    /* <![CDATA[ */
    var mejsL10n = {
      language: "en",
      strings: {
        "mejs.download-file": "Download File",
        "mejs.install-flash": "You are using a browser that does not have Flash player enabled or installed. Please turn on your Flash player plugin or download the latest version from https:\/\/get.adobe.com\/flashplayer\/",
        "mejs.fullscreen": "Fullscreen",
        "mejs.play": "Play",
        "mejs.pause": "Pause",
        "mejs.time-slider": "Time Slider",
        "mejs.time-help-text": "Use Left\/Right Arrow keys to advance one second, Up\/Down arrows to advance ten seconds.",
        "mejs.live-broadcast": "Live Broadcast",
        "mejs.volume-help-text": "Use Up\/Down Arrow keys to increase or decrease volume.",
        "mejs.unmute": "Unmute",
        "mejs.mute": "Mute",
        "mejs.volume-slider": "Volume Slider",
        "mejs.video-player": "Video Player",
        "mejs.audio-player": "Audio Player",
        "mejs.captions-subtitles": "Captions\/Subtitles",
        "mejs.captions-chapters": "Chapters",
        "mejs.none": "None",
        "mejs.afrikaans": "Afrikaans",
        "mejs.albanian": "Albanian",
        "mejs.arabic": "Arabic",
        "mejs.belarusian": "Belarusian",
        "mejs.bulgarian": "Bulgarian",
        "mejs.catalan": "Catalan",
        "mejs.chinese": "Chinese",
        "mejs.chinese-simplified": "Chinese (Simplified)",
        "mejs.chinese-traditional": "Chinese (Traditional)",
        "mejs.croatian": "Croatian",
        "mejs.czech": "Czech",
        "mejs.danish": "Danish",
        "mejs.dutch": "Dutch",
        "mejs.english": "English",
        "mejs.estonian": "Estonian",
        "mejs.filipino": "Filipino",
        "mejs.finnish": "Finnish",
        "mejs.french": "French",
        "mejs.galician": "Galician",
        "mejs.german": "German",
        "mejs.greek": "Greek",
        "mejs.haitian-creole": "Haitian Creole",
        "mejs.hebrew": "Hebrew",
        "mejs.hindi": "Hindi",
        "mejs.hungarian": "Hungarian",
        "mejs.icelandic": "Icelandic",
        "mejs.indonesian": "Indonesian",
        "mejs.irish": "Irish",
        "mejs.italian": "Italian",
        "mejs.japanese": "Japanese",
        "mejs.korean": "Korean",
        "mejs.latvian": "Latvian",
        "mejs.lithuanian": "Lithuanian",
        "mejs.macedonian": "Macedonian",
        "mejs.malay": "Malay",
        "mejs.maltese": "Maltese",
        "mejs.norwegian": "Norwegian",
        "mejs.persian": "Persian",
        "mejs.polish": "Polish",
        "mejs.portuguese": "Portuguese",
        "mejs.romanian": "Romanian",
        "mejs.russian": "Russian",
        "mejs.serbian": "Serbian",
        "mejs.slovak": "Slovak",
        "mejs.slovenian": "Slovenian",
        "mejs.spanish": "Spanish",
        "mejs.swahili": "Swahili",
        "mejs.swedish": "Swedish",
        "mejs.tagalog": "Tagalog",
        "mejs.thai": "Thai",
        "mejs.turkish": "Turkish",
        "mejs.ukrainian": "Ukrainian",
        "mejs.vietnamese": "Vietnamese",
        "mejs.welsh": "Welsh",
        "mejs.yiddish": "Yiddish",
      },
    };
    /* ]]> */
  </script>
  <script type="text/javascript" src="web/wp-includes/js/mediaelement/mediaelement-and-player.min1f61.js?ver=4.2.17"
    id="mediaelement-core-js"></script>
  <script type="text/javascript" src="web/wp-includes/js/mediaelement/mediaelement-migrate.min9704.js?ver=6.7.1"
    id="mediaelement-migrate-js"></script>
  <script type="text/javascript" id="mediaelement-js-extra">
    /* <![CDATA[ */
    var _wpmejsSettings = {
      pluginPath: "\/nwc\/wp-includes\/js\/mediaelement\/",
      classPrefix: "mejs-",
      stretching: "responsive",
      audioShortcodeLibrary: "mediaelement",
      videoShortcodeLibrary: "mediaelement",
    };
    /* ]]> */
  </script>
  <script type="text/javascript" src="web/wp-includes/js/mediaelement/wp-mediaelement.min9704.js?ver=6.7.1"
    id="wp-mediaelement-js"></script>
  <script type="text/javascript" src="web/wp-includes/js/mediaelement/renderers/vimeo.min1f61.js?ver=4.2.17"
    id="mediaelement-vimeo-js"></script>
  <script type="text/javascript" src="web/wp-content/plugins/elementor/assets/js/webpack.runtime.mindb68.js?ver=3.27.1"
    id="elementor-webpack-runtime-js"></script>
  <script type="text/javascript" src="web/wp-content/plugins/elementor/assets/js/frontend-modules.mindb68.js?ver=3.27.1"
    id="elementor-frontend-modules-js"></script>
  <script type="text/javascript" id="elementor-frontend-js-before">
    /* <![CDATA[ */
    var elementorFrontendConfig = {
      environmentMode: {
        edit: false,
        wpPreview: false,
        isScriptDebug: false,
      },
      i18n: {
        shareOnFacebook: "Share on Facebook",
        shareOnTwitter: "Share on Twitter",
        pinIt: "Pin it",
        download: "Download",
        downloadImage: "Download image",
        fullscreen: "Fullscreen",
        zoom: "Zoom",
        share: "Share",
        playVideo: "Play Video",
        previous: "Previous",
        next: "Next",
        close: "Close",
        a11yCarouselPrevSlideMessage: "Previous slide",
        a11yCarouselNextSlideMessage: "Next slide",
        a11yCarouselFirstSlideMessage: "This is the first slide",
        a11yCarouselLastSlideMessage: "This is the last slide",
        a11yCarouselPaginationBulletMessage: "Go to slide",
      },
      is_rtl: false,
      breakpoints: {
        xs: 0,
        sm: 480,
        md: 768,
        lg: 1025,
        xl: 1440,
        xxl: 1600
      },
      responsive: {
        breakpoints: {
          mobile: {
            label: "Mobile Portrait",
            value: 767,
            default_value: 767,
            direction: "max",
            is_enabled: true,
          },
          mobile_extra: {
            label: "Mobile Landscape",
            value: 880,
            default_value: 880,
            direction: "max",
            is_enabled: false,
          },
          tablet: {
            label: "Tablet Portrait",
            value: 1024,
            default_value: 1024,
            direction: "max",
            is_enabled: true,
          },
          tablet_extra: {
            label: "Tablet Landscape",
            value: 1200,
            default_value: 1200,
            direction: "max",
            is_enabled: false,
          },
          laptop: {
            label: "Laptop",
            value: 1366,
            default_value: 1366,
            direction: "max",
            is_enabled: false,
          },
          widescreen: {
            label: "Widescreen",
            value: 2400,
            default_value: 2400,
            direction: "min",
            is_enabled: false,
          },
        },
        hasCustomBreakpoints: false,
      },
      version: "3.27.1",
      is_static: false,
      experimentalFeatures: {
        e_font_icon_svg: true,
        additional_custom_breakpoints: true,
        container: true,
        e_swiper_latest: true,
        e_onboarding: true,
        theme_builder_v2: true,
        home_screen: true,
        "nested-elements": true,
        editor_v2: true,
        e_element_cache: true,
        "link-in-bio": true,
        "floating-buttons": true,
        "launchpad-checklist": true,
      },
      urls: {
        assets: "http:\/\/localhost\/nwc\/wp-content\/plugins\/elementor\/assets\/",
        ajaxurl: "http:\/\/localhost\/nwc\/wp-admin\/admin-ajax.php",
        uploadUrl: "http:\/\/localhost\/nwc\/wp-content\/uploads",
      },
      nonces: {
        floatingButtonsClickTracking: "157bbf6f2c"
      },
      swiperClass: "swiper",
      settings: {
        page: [],
        editorPreferences: []
      },
      kit: {
        active_breakpoints: ["viewport_mobile", "viewport_tablet"],
        global_image_lightbox: "yes",
        lightbox_enable_counter: "yes",
        lightbox_enable_fullscreen: "yes",
        lightbox_enable_zoom: "yes",
        lightbox_enable_share: "yes",
        lightbox_title_src: "title",
        lightbox_description_src: "description",
      },
      post: {
        id: 50,
        title: "New%20world%20cargo",
        excerpt: "",
        featuredImage: false,
      },
    };
    /* ]]> */
  </script>
  <script type="text/javascript" src="web/wp-content/plugins/elementor/assets/js/frontend.mindb68.js?ver=3.27.1"
    id="elementor-frontend-js"></script>
  <script type="text/javascript"
    src="web/wp-content/plugins/qi-addons-for-elementor/inc/plugins/elementor/assets/js/elementor9704.js?ver=6.7.1"
    id="qi-addons-for-elementor-elementor-js"></script>
  <script type="text/javascript" id="globefarer-core-elementor-js-extra">
    /* <![CDATA[ */
    var qodefElementorGlobal = {
      vars: {
        elementorSectionHandler: [],
        elementorColumnHandler: []
      },
    };
    /* ]]> */
  </script>
  <script type="text/javascript"
    src="web/wp-content/plugins/globefarer-core/inc/plugins/elementor/assets/js/elementor.min9704.js?ver=6.7.1"
    id="globefarer-core-elementor-js"></script>
  <script type="text/javascript"
    src="web/wp-content/plugins/elementor-pro/assets/js/webpack-pro.runtime.mindb68.js?ver=3.27.1"
    id="elementor-pro-webpack-runtime-js"></script>
  <script type="text/javascript" id="elementor-pro-frontend-js-before">
    /* <![CDATA[ */
    var ElementorProFrontendConfig = {
      ajaxurl: "\/\/wp-admin\/admin-ajax.php",
      nonce: "0fd65747d2",
      urls: {
        
      },
      settings: {
        lazy_load_background_images: true
      },
      popup: {
        hasPopUps: false
      },
      shareButtonsNetworks: {
        facebook: {
          title: "Facebook",
          has_counter: true
        },
        twitter: {
          title: "Twitter"
        },
        linkedin: {
          title: "LinkedIn",
          has_counter: true
        },
        pinterest: {
          title: "Pinterest",
          has_counter: true
        },
        reddit: {
          title: "Reddit",
          has_counter: true
        },
        vk: {
          title: "VK",
          has_counter: true
        },
        odnoklassniki: {
          title: "OK",
          has_counter: true
        },
        tumblr: {
          title: "Tumblr"
        },
        digg: {
          title: "Digg"
        },
        skype: {
          title: "Skype"
        },
        stumbleupon: {
          title: "StumbleUpon",
          has_counter: true
        },
        mix: {
          title: "Mix"
        },
        telegram: {
          title: "Telegram"
        },
        pocket: {
          title: "Pocket",
          has_counter: true
        },
        xing: {
          title: "XING",
          has_counter: true
        },
        whatsapp: {
          title: "WhatsApp"
        },
        email: {
          title: "Email"
        },
        print: {
          title: "Print"
        },
        "x-twitter": {
          title: "X"
        },
        threads: {
          title: "Threads"
        },
      },
      facebook_sdk: {
        lang: "en_US",
        app_id: ""
      },
      lottie: {
        defaultAnimationUrl: "http:\/\/localhost\/nwc\/wp-content\/plugins\/elementor-pro\/modules\/lottie\/assets\/animations\/default.json",
      },
    };
    /* ]]> */
  </script>
  <script type="text/javascript" src="web/wp-content/plugins/elementor-pro/assets/js/frontend.mindb68.js?ver=3.27.1"
    id="elementor-pro-frontend-js"></script>
  <script type="text/javascript"
    src="web/wp-content/plugins/elementor-pro/assets/js/elements-handlers.mindb68.js?ver=3.27.1"
    id="pro-elements-handlers-js"></script>
 

  <script id="rs-initialisation-scripts">
    var tpj = jQuery;

    var revapi1;

    if (window.RS_MODULES === undefined) window.RS_MODULES = {};
    if (RS_MODULES.modules === undefined) RS_MODULES.modules = {};
    RS_MODULES.modules["revslider11"] = {
      once: RS_MODULES.modules["revslider11"] !== undefined ?
        RS_MODULES.modules["revslider11"].once : undefined,
      init: function () {
        window.revapi1 =
          window.revapi1 === undefined ||
            window.revapi1 === null ||
            window.revapi1.length === 0 ?
            document.getElementById("rev_slider_1_1") :
            window.revapi1;
        if (
          window.revapi1 === null ||
          window.revapi1 === undefined ||
          window.revapi1.length == 0
        ) {
          window.revapi1initTry =
            window.revapi1initTry === undefined ?
              0 :
              window.revapi1initTry + 1;
          if (window.revapi1initTry < 20)
            requestAnimationFrame(function () {
              RS_MODULES.modules["revslider11"].init();
            });
          return;
        }
        window.revapi1 = jQuery(window.revapi1);
        if (window.revapi1.revolution == undefined) {
          revslider_showDoubleJqueryError("rev_slider_1_1");
          return;
        }
        revapi1.revolutionInit({
          revapi: "revapi1",
          DPR: "dpr",
          sliderLayout: "fullscreen",
          duration: "3000ms",
          visibilityLevels: "1240,1024,778,480",
          gridwidth: "1400,1100,600,300",
          gridheight: "900,768,960,720",
          lazyType: "smart",
          perspective: 600,
          perspectiveType: "global",
          editorheight: "900,768,960,720",
          responsiveLevels: "1240,1024,778,480",
          progressBar: {
            disableProgressBar: true
          },
          navigation: {
            wheelCallDelay: 1000,
            onHoverStop: false,
            touch: {
              touchenabled: true,
            },
            arrows: {
              enable: true,
              tmp: '<svg xmlns="http://www.w3.org/2000/svg" width="25.456" height="48.083" viewBox="0 0 25.456 48.083">  <rect class="qodef-m-oblique" width="100%" height="100%" transform="translate(1.414 22.627) rotate(45)" />  <rect class="qodef-m-oblique" width="100%" height="100%" transform="translate(0 24.042) rotate(-45)" />  <rect class="qodef-m-horizontal" transform="translate(2.433 23.042)" /></svg>',
              style: "globefarer_arrows",
              hide_onmobile: true,
              hide_under: "1280px",
              left: {
                h_offset: 48,
              },
              right: {
                h_offset: 48,
              },
            },
            tabs: {
              enable: true,
              tmp: tabTitles.map(title => `<div class="tp-tab-title">${title}</div>`).join(''),
              style: "globefarer_tabs",
              hide_onmobile: true,
              hide_under: "680px",
              animSpeed: "500ms",
              animDelay: "500ms",
              space: 35,
              width: 410,
              height: 77,
              wrapper_color: "transparent",
              visibleAmount: 4,
              mhoff: "",
              mvoff: "",
            },
          },
          viewPort: {
            global: true,
            globalDist: "-200px",
            enable: false,
          },
          fallbacks: {
            allowHTML5AutoPlayOnAndroid: true,
          },
        });
      },
    }; // End of RevInitScript

    if (window.RS_MODULES.checkMinimal !== undefined) {
      window.RS_MODULES.checkMinimal();
    }
  </script>
</body>


</html>
