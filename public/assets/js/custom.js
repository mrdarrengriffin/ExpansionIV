$(document).ready(function(){
	$(".input-clear").click(function(){
		$(this).parent(".clear-control").children("input").val(null);
	});
	parseCharCounts();
});

function parseCharCounts(){
	$("input.char-count").each(function(){
		$(this).after("<span class='help-block char-count-text'><span class='chars-remaining' title='Characters Remaining'>"+$(this).data('limit')+"</span></span>");
		$(this).attr('maxlength', $(this).data('limit'));
		$(this).parent().find('.chars-remaining').html($(this).data('limit') - $(this).val().length);
	});
	$(".char-count").on('input',function(){
		$(this).parent().find('.chars-remaining').html($(this).data('limit') - $(this).val().length);
	});
}
