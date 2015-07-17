function stretch(){
	$("#sea").animate({
		width:"140px"
	},500);
}
function stretch2(){
	$("#sea").animate({
		width:"50px"
	},400);
}
function select(obj){
	obj.parent().find('li').removeClass('select');
	obj.addClass("select");
}
function color(obj){
	select(obj);
	$("#mark").removeClass().addClass(obj.attr("class"));
}

function create(){
	if($(".one:first").val() == ''){
		$("#showmetherecall").html("<a>N</a>请填写项目名");
	}else{
		$("#showmetherecall").html('');
		var str = '';
		if(window.location.search){
			str = 'type=obj_update';
			str=str+"&url="+window.location.search.substr(1,15);
		}else{
			str='type=obj_new';
		}
		str=str+"&parent="+$("#user").attr('class');
		str=str+"&name="+$(".one:first").val();
		str=str+"&mark="+$("#mark > .select:first").html();
		str=str+"&color="+$("#color > .select:first").attr("class").substring(0,6);
		$.ajax({
			url: "post.php",
			type: "POST",
			data: str,
			success: function(data){
				if(data == 'true'){
					if(window.location.search){
						window.history.back()
					}else{
						window.location.href='index.php';
					}
				}else{
					$("#mess").html("<a>N</a>因为各种原因导致你的项目创建失败！请谅解。你可以重新建立").show();
				}
			},
			error:function(){
				$("#showmetherecall").html("<a>N</a>服务器通信失败");
			}
		});
	}
}

$(document).ready(function(){
	$("."+$("#mark").attr('class')).addClass("select");
	var num = $("#mark").attr('mark').charCodeAt(0)-65;
	document.getElementById('mark').getElementsByTagName('li')[num].className="select";
	$("#sea").focus(function(){stretch();});
	$("#sea").focusout(function(){stretch2();});
	if($("#end")){
		$("#end").find("a").click(function(){
			$("body").animate({scrollTop:0}, 500);
		});
	}
	$("#mark > li").click(function(){select($(this));})
	$("#color > li").click(function(){color($(this));})
});