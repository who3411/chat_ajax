$(function(){
	$('.chatRoom').css('top', function(index){
		if(index == 0){
			return $('body').css('padding-top');
		}else{
			var prevTop = parseFloat($(this).prev().css('top'));
			var prevHeight = parseFloat($(this).prev().css('height'));
			return prevTop + prevHeight;
		}
	});
	$('body').on('click', '.chatRoom', function(){
		$('form').append($('<input>').attr({
				type: 'hidden',
				name: 'roomID',
				value: $(this).children('input').val()
			})
		);
		$('form').append($('<input>').attr({
				type: 'hidden',
				name: 'roomName',
				value: $(this).children('h2').text()
			})
		);
		document.chat.submit();
	});
});
