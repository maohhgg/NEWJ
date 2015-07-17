function userclick(obj){
	var iso = $("#datenum > div:first").offset().left;
	var ios = $("#datenum > div:first").offset().top;
	var left = obj.offset().left;
	var top = obj.offset().top;
	if(left - iso > 500){
		if(top - ios > 300){
			left = left - 403;
			top = top - 230;
			$("#mark").addClass("back4");
		}else{
			left = left - 403;
			$("#mark").addClass("back2");
		}
	}else{
		if(top - ios > 300){
			top = top - 230;
			$("#mark").addClass("back3");
		}else{
			$("#mark").addClass("back1");
		}
		
	}


	var tag = $("#showdata").find("h3");
	var str = tag.attr("year")+"-"+tag.attr("mouth")+"-"+obj.find("p").html();
	$("#rantime").html(str);
	$("#rangebox").fadeIn("fast");
	$('#rangebox').css({top:top+10,left:left+150});
	$("#creatsan").click(function(){senddata(obj)});
	$('#creatsan').show();
}
function closewindow(){
	$("#rangebox").fadeOut("fast");
	$("#sub").val("");
	$(".ranline > textarea").val("");
	$("#mess").html("");
	$('#creatsan').unbind("click");
	$("#mark").removeClass();
}

function dateclick(obj){
	var tag = $("#showdata").find("h3");
	var time = tag.attr("year")+"-"+tag.attr("mouth")+"-"+obj.parent().find("p").html();
	var str = "type=date_info";
	str = str + "&time=" + time;
	str = str + "&parent=" + $("#user > a").attr("title");
	str = str + "&title=" + obj.html();
	$.ajax({
		url:"post.php",
		type:"post",
		data:str,
		dataType:"json",
		success: function(data){
			var iso = $("#datenum > div:first").offset().left;
			var ios = $("#datenum > div:first").offset().top;
			var left = obj.parent().offset().left;
			var top = obj.parent().offset().top;
			if(left - iso > 500){
				if(top - ios > 300){
					left = left - 403;
					top = top - 230;
					$("#mark").addClass("back4");
				}else{
					left = left - 403;
					$("#mark").addClass("back2");
				}
			}else{
				if(top - ios > 300){
					top = top - 230;
					$("#mark").addClass("back3");
				}else{
					$("#mark").addClass("back1");
				}
				
			}
			$("#sub").val(data['title']);
			$("#rantime").html(time);
			$('#rangebox').css({top:top+10,left:left+150});
			$(".ranline > textarea").val(data['content']);
			$('#creatsan').hide();
			$("#rangebox").fadeIn("fast");
		}
	});
}

function senddata(obj){
	if($("#rantime").html()&&$("#sub").val()&&$(".ranline > textarea").val()){
		var name= $("#sub").val();
		var str = "type=date_new";
		str = str + "&time=" + $("#rantime").html();
		str = str + "&title=" + $("#sub").val();
		str = str + "&content=" + $(".ranline > textarea").val();
		str = str + "&parent=" + $("#user > a").attr("title");
		$.ajax({
			url:"post.php",
			type:"post",
			data:str,
			success: function (data){
				if(data=='true'){
					obj.append("<a class='red'>"+name+"</a>");
					closewindow();
				}
			}
		});
	}else{
		$("#mess").html("请填写完毕！");
	}
}

$(window).ready(function(){
	$("#datenum > div:not('.other')").click(function(){userclick($(this))});
	$(".red").click(function(){event.stopPropagation;event.cancelBubble=true;dateclick($(this));});
})