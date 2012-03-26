// JavaScript Document
$(document).ready(function(){

	$('.blog_slide').cycle({
		fx:     'scrollHorz',
		slideExpr : 'li',
		speed	: 500,
		prev:   '#blog_prev',
		next:   '#blog_next',
		after:   BlogonAfter,
		timeout: 0
	});

	$('.video_list').cycle({
		fx:     'scrollHorz',
		slideExpr : 'li',
		speed	: 500,
		prev:   '#video_prev',
		next:   '#video_next',
		after:   VideoonAfter,
		timeout: 0
	});
	
	$('.project_list').cycle({
		fx:     'scrollHorz',
		slideExpr : 'li',
		speed	: 500,
		prev:   '#project_prev',
		next:   '#project_next',
		after:   ProjonAfter,
		timeout: 0
	});

	function BlogonAfter(curr, next, opts) {
		var index = opts.currSlide;
		$('#blog_prev')[index == 0 ? 'hide' : 'show']();
		$('#blog_next')[index == opts.slideCount - 1 ? 'hide' : 'show']();
	}

	function VideoonAfter(curr, next, opts) {
		var index = opts.currSlide;
		$('#video_prev')[index == 0 ? 'hide' : 'show']();
		$('#video_next')[index == opts.slideCount - 1 ? 'hide' : 'show']();
	}

	function ProjonAfter(curr, next, opts) {
		var index = opts.currSlide;
		$('#project_prev')[index == 0 ? 'hide' : 'show']();
		$('#project_next')[index == opts.slideCount - 1 ? 'hide' : 'show']();
	}
});

