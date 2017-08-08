$(function(){
	$('input[type=file]').on('change', function(){
		var file = this.files[0];
		if(file != null){
			var exp = new RegExp('(png|gif|jpg|jpeg|txt|PNG|GIF|JPG|JPEG|TXT)$', 'g');
			if(!file.name.match(exp)){
				alert('don\'t select this file');
				$('#filename').text('file selet');
				return;
			}
			$('#filename').text(file.name);
		}else{
			$('#filename').text('file select');
		}
	});
	$('#greet').click(function(){
		if(!$('#message').val() && $('#filename').text().indexOf('file select') != -1)	return;
		var str = '';
		var flg = true;
		var resultArray = [null, null];
		if($('#filename').text().indexOf('file select') == -1){
			var fileData = new FormData();
			fileData.append('file', $('input[type=file]')[0].files[0]);
			$.ajax('upload.php', {
				type: 'POST',
				data: fileData,
				dataType: 'text',
				processData: false,
				contentType: false,
				async: false,
				cache: false,
			}).done(function(data){
				console.log(data);
				resultArray = data.split(',');
				flg = (resultArray[0] === 'true' ? true : false);
			});
			/*
			obj = $('input[type=file]')[0].files[0];
			str = '{"file":{';
			for(var key in obj){
				str += ('"' + key + '":"' + obj[key] + '"');
				if(key == 'slice')	break;
				else			str += ',';
			}
			str += '}}';
			*/
		}
		if(flg){
			console.log(resultArray[1]);
			var mes = $('#message').val();
			mes = mes.replace(/\\/g, '\\\\');
			$.post('bbs2.php', {
				message: mes,
				tmp_name: resultArray[1],
				mode: 0 // 書き込み
			}, function(data){
				if(data.indexOf('<delete>') > -1){
					$('#result .left_user:first').remove();
					$('#result .left_balloon:first').remove();
					var beforeData = data.substring(0, data.indexOf('<delete>'));
					var afterData = data.substring(data.indexOf('<delete>')+8, data.length);
					data = beforeData + afterData;
				}
				$('#result').html(data + $('#result').html());
				$('#message').val("");
				$('#filename').text('file select');
				// scTarget();
			});
		}
	});
	oneLog(1);
	checker();
});

function oneLog(val){
	$.post('bbs2.php', {
		mode: val // 読み込み
	}, function(data){
		if(data.indexOf('<deleted>') > -1){
			data = data.substring(9, data.length);
			var dataArray = data.split('<span></span>');
			var len = dataArray.length;
			var i = 1;
			$('span.right').each(function(){
				for(var j = 0;j < i;j++){
					if($(this).text() == dataArray[j]){
						$(this).remove();
						i++;
						break;
					}
				}
				if(i === len)	return false;
				
			});
			console.log($('#result').html());
			data = "";
		}else if(data.indexOf('<cleard>') > -1){
			$('#result').html("");
			data = "";
		}
		$('#result').html(data + $('#result').html());
		//scTarget();
	});
}

// 一定間隔でログをリロードする
///*
function checker(){
	setTimeout(function(){
		oneLog(1);
		checker();
	}, 1000); //リロード時間はここで調整
}
//*/
