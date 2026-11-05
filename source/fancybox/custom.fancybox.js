// JavaScript Document
$(document).ready(function() {
				$(".fancybox").fancybox();
				$(".youtube").click(function() {
							$.fancybox({
									'padding'		: 0,
									'autoScale'		: false,
									'transitionIn'	: 'none',
									'transitionOut'	: 'none',
									'title'			: this.title,
									'width'			: 680,
									'height'		: 495,
									'href'			: this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
									'type'			: 'swf',
									'swf'			: {
									'wmode'			: 'transparent',
									'allowfullscreen'	: 'true'
									}
								});
							return false;
				});
				$("#inlineBox").fancybox({
					'titlePosition'		: 'inside',
					'transitionIn'		: 'none',
					'transitionOut'		: 'none'
				});
				
				
				
				$(".fancyboxIframe").fancybox({
					'width'				: '75%',
					'height'			: '75%',
					'autoScale'     	: false,
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'hideOnOverlayClick': false,
					'centerOnScroll'    : true,
 					'type'				: 'iframe'
				}); 
});