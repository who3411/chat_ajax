$(function(){
	var num = 0;
	$("div#createText").click(function(){
		num++;
		$pp = $('<p>').append(num + "人目のアカウントを入力(半角英数字20字以内):");
		$pp.append($('<input>').attr({
				type: 'button',
				class: 'del',
				value: '削除'
			})
		);
		$pp.append($('<input>').attr({
				required: true,
				pattern: "[A-Za-z0-9]+",
				maxlength: 20,
				type: 'text',
				class: 'input',
				name: 'friend'+num
			})
		)
		$("#createField p:last-child").children('input.del').css({
			display: 'none'
		});
		$("#createField").append($pp);
		 
	});
	$("body").on("click", "input.del", function(){
		$("#createField p:last-child").remove();
		$("#createField p:last-child").children('input.del').css({
			display: 'inline'
		});
	});
});
