$(document).ready(function(){
	$(".input-clear").click(function(){
		$(this).parent(".clear-control").children("input").val(null);
	});
	parseCharCounts();
});

function parseCharCounts(){
	$(".char-count").each(function(){
		if($(this).find(".input-group").length != 0){
			$(this).children('.input-group').after("<span class='help-block char-count-text'><span class='chars-remaining'>"+$(this).data('limit')+"</span> characters remaining</span>");
		}else{
			$(this).children('input').after("<span class='help-block char-count-text'><span class='chars-remaining'>"+$(this).data('limit')+"</span> characters remaining</span>");
		}
	});
	$(".char-count").on('input',function(){
		if($(this).find(".input-group").length != 0){
		var input = $(this).children('.input-group').children('input');
	}else{
		var input = $(this).children('input');
	}
		$(input).attr('maxlength', $(this).data('limit'));
		$(this).find('.chars-remaining').html($(this).data('limit') - $(input).val().length);
	});
}
