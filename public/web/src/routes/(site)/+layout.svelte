<script>
	import '../../app.css';
	let { children } = $props();
	import Header from '$lib/components/site/Header.svelte';
	import Footer from '$lib/components/site/Footer.svelte';
	import Side from '$lib/components/site/Side.svelte';
	import Backtotop from '$lib/components/site/Backtotop.svelte';
	import Mouse from '$lib/components/site/Mouse.svelte';
	import { onMount } from 'svelte';

	// const scripts = [
		
	// 	{
	// 		id: 'elementor-frontend-js',
	// 		src: 'assets/wp-content/plugins/elementor/assets/js/frontend.mindb68.js?ver=3.27.1'
	// 	},
	// 	{
	// 		id: 'qi-addons-for-elementor-elementor-js',
	// 		src: 'assets/wp-content/plugins/qi-addons-for-elementor/inc/plugins/elementor/assets/js/elementor9704.js?ver=6.7.1'
	// 	},
	// 	{
	// 		id: 'globefarer-core-elementor-js-extra',
	// 		content: `/* <![CDATA[ */
    // var qodefElementorGlobal = {
    //   vars: { elementorSectionHandler: [], elementorColumnHandler: [] },
    // };
    // /* ]]> */`
	// 	},
	// 	{
	// 		id: 'globefarer-core-elementor-js',
	// 		src: 'assets/wp-content/plugins/globefarer-core/inc/plugins/elementor/assets/js/elementor.min9704.js?ver=6.7.1'
	// 	},
	// 	{
	// 		id: 'elementor-pro-webpack-runtime-js',
	// 		src: 'assets/wp-content/plugins/elementor-pro/assets/js/webpack-pro.runtime.mindb68.js?ver=3.27.1'
	// 	},
	// 	{
	// 		id: 'elementor-pro-frontend-js-before',
	// 		content: `
    // var ElementorProFrontendConfig = {
    //   ajaxurl: "http:\/\/localhost\/nwc\/wp-admin\/admin-ajax.php",
    //   nonce: "0fd65747d2",
    //   urls: {
    //     assets: "http:\/\/localhost\/nwc\/wp-content\/plugins\/elementor-pro\/assets\/",
    //     rest: "http:\/\/localhost\/nwc\/index.php?rest_route=\/",
    //   },
    //   settings: { lazy_load_background_images: true },
    //   popup: { hasPopUps: false },
    //   shareButtonsNetworks: { /* ... networks config ... */ },
    //   facebook_sdk: { lang: "en_US", app_id: "" },
    //   lottie: { defaultAnimationUrl: "http:\/\/localhost\/nwc\/wp-content\/plugins\/elementor-pro\/modules\/lottie\/assets\/animations\/default.json" },
    // };
    // /* ]]> */`
	// 	},
	// 	{
	// 		id: 'elementor-pro-frontend-js',
	// 		src: 'assets/wp-content/plugins/elementor-pro/assets/js/frontend.mindb68.js?ver=3.27.1'
	// 	},
	// 	{
	// 		id: 'pro-elements-handlers-js',
	// 		src: 'assets/wp-content/plugins/elementor-pro/assets/js/elements-handlers.mindb68.js?ver=3.27.1'
	// 	},
	// 	{
	// 		id: 'rs-initialisation-scripts',
	// 		content: `/* Add your RevSlider initialization code here */`
	// 	}
	// ];

	// onMount(() => {
	// 	// Wait for the body element to be ready
	// 	const body = document.body;

	// 	scripts.forEach((script) => {
	// 		const s = document.createElement('script');
	// 		s.id = script.id;

	// 		if (script.src) {
	// 			s.src = script.src;
	// 			s.onload = () => {
	// 				console.log(`${script.id} loaded successfully`);
	// 			};
	// 		} else if (script.content) {
	// 			s.type = 'text/javascript';
	// 			s.text = script.content;
	// 		}

	// 		body.appendChild(s); // Append each script at the bottom of the body
	// 	});
	// });
</script>

<svelte:head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />

	<title>Newworld cargo</title>
	<meta name="robots" content="max-image-preview:large" />
	<style>
		img:is([sizes='auto' i], [sizes^='auto,' i]) {
			contain-intrinsic-size: 3000px 1500px;
		}
	</style>
	<link rel="dns-prefetch" href="http://fonts.googleapis.com/" />

	<script type="text/javascript">
		/* <![CDATA[ */
		window._wpemojiSettings = {
			baseUrl: 'https:\/\/s.w.org\/images\/core\/emoji\/15.0.3\/72x72\/',
			ext: '.png',
			svgUrl: 'https:\/\/s.w.org\/images\/core\/emoji\/15.0.3\/svg\/',
			svgExt: '.svg',
			source: {
				concatemoji: '\/assets\/wp-includes\/js\/wp-emoji-release.min.js?ver=6.7.1'
			}
		};
		/*! This file is auto-generated */
		!(function (i, n) {
			var o, s, e;
			function c(e) {
				try {
					var t = { supportTests: e, timestamp: new Date().valueOf() };
					sessionStorage.setItem(o, JSON.stringify(t));
				} catch (e) {}
			}
			function p(e, t, n) {
				e.clearRect(0, 0, e.canvas.width, e.canvas.height), e.fillText(t, 0, 0);
				var t = new Uint32Array(e.getImageData(0, 0, e.canvas.width, e.canvas.height).data),
					r =
						(e.clearRect(0, 0, e.canvas.width, e.canvas.height),
						e.fillText(n, 0, 0),
						new Uint32Array(e.getImageData(0, 0, e.canvas.width, e.canvas.height).data));
				return t.every(function (e, t) {
					return e === r[t];
				});
			}
			function u(e, t, n) {
				switch (t) {
					case 'flag':
						return n(
							e,
							'\ud83c\udff3\ufe0f\u200d\u26a7\ufe0f',
							'\ud83c\udff3\ufe0f\u200b\u26a7\ufe0f'
						)
							? !1
							: !n(e, '\ud83c\uddfa\ud83c\uddf3', '\ud83c\uddfa\u200b\ud83c\uddf3') &&
									!n(
										e,
										'\ud83c\udff4\udb40\udc67\udb40\udc62\udb40\udc65\udb40\udc6e\udb40\udc67\udb40\udc7f',
										'\ud83c\udff4\u200b\udb40\udc67\u200b\udb40\udc62\u200b\udb40\udc65\u200b\udb40\udc6e\u200b\udb40\udc67\u200b\udb40\udc7f'
									);
					case 'emoji':
						return !n(e, '\ud83d\udc26\u200d\u2b1b', '\ud83d\udc26\u200b\u2b1b');
				}
				return !1;
			}
			function f(e, t, n) {
				var r =
						'undefined' != typeof WorkerGlobalScope && self instanceof WorkerGlobalScope
							? new OffscreenCanvas(300, 150)
							: i.createElement('canvas'),
					a = r.getContext('2d', { willReadFrequently: !0 }),
					o = ((a.textBaseline = 'top'), (a.font = '600 32px Arial'), {});
				return (
					e.forEach(function (e) {
						o[e] = t(a, e, n);
					}),
					o
				);
			}
			function t(e) {
				var t = i.createElement('script');
				(t.src = e), (t.defer = !0), i.head.appendChild(t);
			}
			'undefined' != typeof Promise &&
				((o = 'wpEmojiSettingsSupports'),
				(s = ['flag', 'emoji']),
				(n.supports = { everything: !0, everythingExceptFlag: !0 }),
				(e = new Promise(function (e) {
					i.addEventListener('DOMContentLoaded', e, { once: !0 });
				})),
				new Promise(function (t) {
					var n = (function () {
						try {
							var e = JSON.parse(sessionStorage.getItem(o));
							if (
								'object' == typeof e &&
								'number' == typeof e.timestamp &&
								new Date().valueOf() < e.timestamp + 604800 &&
								'object' == typeof e.supportTests
							)
								return e.supportTests;
						} catch (e) {}
						return null;
					})();
					if (!n) {
						if (
							'undefined' != typeof Worker &&
							'undefined' != typeof OffscreenCanvas &&
							'undefined' != typeof URL &&
							URL.createObjectURL &&
							'undefined' != typeof Blob
						)
							try {
								var e =
										'postMessage(' +
										f.toString() +
										'(' +
										[JSON.stringify(s), u.toString(), p.toString()].join(',') +
										'));',
									r = new Blob([e], { type: 'text/javascript' }),
									a = new Worker(URL.createObjectURL(r), {
										name: 'wpTestEmojiSupports'
									});
								return void (a.onmessage = function (e) {
									c((n = e.data)), a.terminate(), t(n);
								});
							} catch (e) {}
						c((n = f(s, u, p)));
					}
					t(n);
				})
					.then(function (e) {
						for (var t in e)
							(n.supports[t] = e[t]),
								(n.supports.everything = n.supports.everything && n.supports[t]),
								'flag' !== t &&
									(n.supports.everythingExceptFlag =
										n.supports.everythingExceptFlag && n.supports[t]);
						(n.supports.everythingExceptFlag = n.supports.everythingExceptFlag && !n.supports.flag),
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
							(e = n.source || {}).concatemoji
								? t(e.concatemoji)
								: e.wpemoji && e.twemoji && (t(e.twemoji), t(e.wpemoji)));
					}));
		})((window, document), window._wpemojiSettings);
		/* ]]> */
	</script>
	<link
		rel="stylesheet"
		id="animate-css"
		href="wp-content/plugins/qi-blocks/assets/css/plugins/animate/animate.min0235.css?ver=4.1.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="sbi_styles-css"
		href="wp-content/plugins/instagram-feed/css/sbi-styles.minb6a4.css?ver=6.6.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="dripicons-css"
		href="wp-content/plugins/globefarer-core/inc/icons/dripicons/assets/css/dripicons.min9704.css?ver=6.7.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="elegant-icons-css"
		href="wp-content/plugins/globefarer-core/inc/icons/elegant-icons/assets/css/elegant-icons.min9704.css?ver=6.7.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="font-awesome-css"
		href="wp-content/plugins/globefarer-core/inc/icons/font-awesome/assets/css/all.min9704.css?ver=6.7.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="fontkiko-css"
		href="wp-content/plugins/globefarer-core/inc/icons/fontkiko/assets/css/kiko-all.min9704.css?ver=6.7.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="ionicons-css"
		href="wp-content/plugins/globefarer-core/inc/icons/ionicons/assets/css/ionicons.min9704.css?ver=6.7.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="linea-icons-css"
		href="wp-content/plugins/globefarer-core/inc/icons/linea-icons/assets/css/linea-icons.min9704.css?ver=6.7.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="linear-icons-css"
		href="wp-content/plugins/globefarer-core/inc/icons/linear-icons/assets/css/linear-icons.min9704.css?ver=6.7.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="material-icons-css"
		href="https://fonts.googleapis.com/icon?family=Material+Icons&amp;ver=6.7.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="simple-line-icons-css"
		href="wp-content/plugins/globefarer-core/inc/icons/simple-line-icons/assets/css/simple-line-icons.min9704.css?ver=6.7.1"
		type="text/css"
		media="all"
	/>
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
	<link
		rel="stylesheet"
		id="contact-form-7-css"
		href="wp-content/plugins/contact-form-7/includes/css/styles1eb7.css?ver=6.0.3"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="cf7msm_styles-css"
		href="wp-content/plugins/contact-form-7-multi-step-module/resources/cf7msma94e.css?ver=4.4.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="ctf_styles-css"
		href="wp-content/plugins/custom-twitter-feeds/css/ctf-styles.min5bf8.css?ver=2.2.5"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="qi-blocks-grid-css"
		href="wp-content/plugins/qi-blocks/assets/dist/gridc412.css?ver=1.3.4"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="qi-blocks-main-css"
		href="wp-content/plugins/qi-blocks/assets/dist/mainc412.css?ver=1.3.4"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="qi-addons-for-elementor-grid-style-css"
		href="wp-content/plugins/qi-addons-for-elementor/assets/css/grid.min29af.css?ver=1.8.4"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="qi-addons-for-elementor-helper-parts-style-css"
		href="wp-content/plugins/qi-addons-for-elementor/assets/css/helper-parts.min29af.css?ver=1.8.4"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="qi-addons-for-elementor-style-css"
		href="wp-content/plugins/qi-addons-for-elementor/assets/css/main.min29af.css?ver=1.8.4"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="perfect-scrollbar-css"
		href="wp-content/plugins/globefarer-core/assets/plugins/perfect-scrollbar/perfect-scrollbar9704.css?ver=6.7.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="swiper-css"
		href="wp-content/plugins/qi-addons-for-elementor/assets/plugins/swiper/8.4.5/swiper.min9704.css?ver=6.7.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="globefarer-main-css"
		href="wp-content/themes/globefarer/assets/css/main.min9704.css?ver=6.7.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="globefarer-core-style-css"
		href="wp-content/plugins/globefarer-core/assets/css/globefarer-core.min9704.css?ver=6.7.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="globefarer-child-style-css"
		href="wp-content/themes/globefarer-child/style9704.css?ver=6.7.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="globefarer-google-fonts-css"
		href="https://fonts.googleapis.com/css?family=Poppins%3A200%2C400%2C500%2C700&amp;subset=latin-ext&amp;display=swap&amp;ver=1.0.0"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="globefarer-grid-css"
		href="wp-content/themes/globefarer/assets/css/grid.min9704.css?ver=6.7.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="globefarer-style-css"
		href="wp-content/themes/globefarer/style9704.css?ver=6.7.1"
		type="text/css"
		media="all"
	/>
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

      .qodef-header-sticky .qodef-header-sticky-inner {
        padding-left: 0px;
        padding-right: 0px;
      }

      #qodef-page-header .qodef-header-logo-link {
        height: 120px;
        padding: 0 0 0 150px;
      }

      #qodef-page-mobile-header .qodef-mobile-header-logo-link {
        padding: 0 0 0 40px;
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
        background-color: rgba(255, 255, 255, 0);
      }

      .qodef-header--standard #qodef-page-header-inner {
        padding-left: 0px;
        padding-right: 0px;
        border-bottom-color: #ffffff80;
        border-bottom-width: 1px;
        border-bottom-style: solid;
      }

      .qodef-header--standard
        #qodef-page-header
        .qodef-widget-holder
        .widget::before {
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
    left: 10px  !important;
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


	</style>
	<link
		rel="stylesheet"
		id="globefarer-core-elementor-css"
		href="wp-content/plugins/globefarer-core/inc/plugins/elementor/assets/css/elementor.min9704.css?ver=6.7.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="elementor-frontend-css"
		href="wp-content/plugins/elementor/assets/css/frontend.mindb68.css?ver=3.27.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="elementor-post-7-css"
		href="wp-content/uploads/elementor/css/post-7ad9c.css?ver=1738195901"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="sbistyles-css"
		href="wp-content/plugins/instagram-feed/css/sbi-styles.minb6a4.css?ver=6.6.1"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="elementor-post-50-css"
		href="wp-content/uploads/elementor/css/post-504ed0.css?ver=1738195902"
		type="text/css"
		media="all"
	/>
	<link
		rel="stylesheet"
		id="google-fonts-1-css"
		href="https://fonts.googleapis.com/css?family=Roboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto+Slab%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&amp;display=swap&amp;ver=6.7.1"
		type="text/css"
		media="all"
	/>
	<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="anonymous" />
	<script
		type="text/javascript"
		src="assets/web/wp-includes/js/jquery/jquery.minf43b.js?ver=3.7.1"
		id="jquery-core-js"
	></script>
	<script
		type="text/javascript"
		src="assets/web/wp-includes/js/jquery/jquery-migrate.min5589.js?ver=3.4.1"
		id="jquery-migrate-js"
	></script>
	<link rel="https://api.w.org/" href="index52f0.json?rest_route=/" />
	<link
		rel="alternate"
		title="JSON"
		type="application/json"
		href="index8f01.json?rest_route=/wp/v2/pages/50"
	/>
	<link rel="EditURI" type="application/rsd+xml" title="RSD" href="xmlrpc0db0.php?rsd" />
	<meta name="generator" content="WordPress 6.7.1" />
	<link rel="canonical" href="index.php" />
	<link rel="shortlink" href="index.php" />
	<link
		rel="alternate"
		title="oEmbed (JSON)"
		type="application/json+oembed"
		href="indexc25b.json?rest_route=%2Foembed%2F1.0%2Fembed&amp;url=http%3A%2F%2Flocalhost%2Fnwc%2F"
	/>
	<link
		rel="alternate"
		title="oEmbed (XML)"
		type="text/xml+oembed"
		href="indexa4ad.php?rest_route=%2Foembed%2F1.0%2Fembed&amp;url=http%3A%2F%2Flocalhost%2Fnwc%2F&amp;format=xml"
	/>

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
	</style>

	<script>
		function setREVStartSize(e) {
			//window.requestAnimationFrame(function() {
			window.RSIW = window.RSIW === undefined ? window.innerWidth : window.RSIW;
			window.RSIH = window.RSIH === undefined ? window.innerHeight : window.RSIH;
			try {
				var pw = document.getElementById(e.c).parentNode.offsetWidth,
					newh;
				pw =
					pw === 0 || isNaN(pw) || e.l == 'fullwidth' || e.layout == 'fullwidth' ? window.RSIW : pw;
				e.tabw = e.tabw === undefined ? 0 : parseInt(e.tabw);
				e.thumbw = e.thumbw === undefined ? 0 : parseInt(e.thumbw);
				e.tabh = e.tabh === undefined ? 0 : parseInt(e.tabh);
				e.thumbh = e.thumbh === undefined ? 0 : parseInt(e.thumbh);
				e.tabhide = e.tabhide === undefined ? 0 : parseInt(e.tabhide);
				e.thumbhide = e.thumbhide === undefined ? 0 : parseInt(e.thumbhide);
				e.mh = e.mh === undefined || e.mh == '' || e.mh === 'auto' ? 0 : parseInt(e.mh, 0);
				if (e.layout === 'fullscreen' || e.l === 'fullscreen') newh = Math.max(e.mh, window.RSIH);
				else {
					e.gw = Array.isArray(e.gw) ? e.gw : [e.gw];
					for (var i in e.rl) if (e.gw[i] === undefined || e.gw[i] === 0) e.gw[i] = e.gw[i - 1];
					e.gh =
						e.el === undefined || e.el === '' || (Array.isArray(e.el) && e.el.length == 0)
							? e.gh
							: e.el;
					e.gh = Array.isArray(e.gh) ? e.gh : [e.gh];
					for (var i in e.rl) if (e.gh[i] === undefined || e.gh[i] === 0) e.gh[i] = e.gh[i - 1];

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
					var m = pw > e.gw[ix] + e.tabw + e.thumbw ? 1 : (pw - (e.tabw + e.thumbw)) / e.gw[ix];
					newh = e.gh[ix] * m + (e.tabh + e.thumbh);
				}
				var el = document.getElementById(e.c);
				if (el !== null && el) el.style.height = newh + 'px';
				el = document.getElementById(e.c + '_wrapper');
				if (el !== null && el) {
					el.style.height = newh + 'px';
					el.style.display = 'block';
				}
			} catch (e) {
				console.log('Failure at Presize of Slider:' + e);
			}
			//});
		}
	</script>
</svelte:head>

<div id="qodef-page-wrapper" class="">
	<div id="qodef-menu-cover"></div>
	<Header />
	<div id="qodef-page-outer">
		{@render children()}
		<!-- close #qodef-page-inner div from header.php -->
	</div>
	<!-- close #qodef-page-outer div from header.php -->
	<Footer />
	<Backtotop />
	<Mouse />
	<!-- <Side /> -->
</div>
