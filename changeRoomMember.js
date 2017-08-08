$(function(){
	var num = 0;
	$('#createText').css('display', 'none');
	$('#createText').click(function(){
		$pp = $('<p>').attr({
			class: 'inputField'
		}).append(num + 1 + '人目のアカウントを入力(半角英数字20字以内):');
		$pp.append($('<input>').attr({
				required: true,
				pattern: "[A-Za-z0-9]+",
				maxlength: 20,
				type: 'text',
				class: 'input',
				name: 'friend' + num
			})
		);
		$pp.append('&#009;');
		$pp.append($('<input>').attr({
				type: 'button',
				class: 'del',
				value: '削除'
			})
		);
		if(num++ > 0)	$('.del:last').css('display', 'none');
		$('#createField').append($pp);
	});
	$('body').on('click', '.del', function(){
		$('.inputField:last').remove();
		$('.del:last').css('display', 'inline');
		num--;
	});
	$('[name=change]').click(function(){
		$('#createField').children().remove();
		$('#createText').css('display', 'none');
		num = 0;
		if($(this).val() === 'ins'){
			$('#createText').css('display', 'block');
		}else{
			$.post('removeRoomMember.php', {

			}, function(data){
				$('#createField').html(data);
			});
		}
	});
});
