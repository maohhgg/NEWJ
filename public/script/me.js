function hideshow(){
	$("#hide").slideToggle("slow");
}

function getimg(){
	$.ajax({
		url:"post.php",
		type:"post",
		data:"type=user_headimg&email="+$("#showme > p").html(),
		success: function(data){
			$("#mtitleimg").attr("src",data);
		}
	});
}
function upchangeimg(){

	$.ajaxFileUpload({  
		url:'upload.php',
		secureuri:false,
		fileElementId:'uploadfile',  
		dataType: 'text',
		success: function (data,status){  
			getimg();
		},  
		error: function (data,status,e){ 
			$("#showmetherecall").html("<a>N</a>服务器通信失败");
		}
	}); 
}

function setsendcontent(obj,str){
	if(obj.val() != ""){
		str = str+"&"+obj.attr("name")+"="+obj.val();
	}
	return str;
}
function upselfdate(){
	var str = "type=user_update&email="+$("#showme > p").html();
	str = setsendcontent($("#password"),
		setsendcontent($("#name"),str));
	$.ajax({
		type: "POST",
		url: "post.php",
		data: str,
		success:function(data){
			if(data=='true'){
				$("#showmetherecall").html("<a class='b'>W</a>设置成功了哦");
				$("#showme > h2").html($("#name").val());
			}else{
				$("#showmetherecall").html("<a>N</a>各种原因最终还是失败了");
			}
		},
		error:function(){
			$("#showmetherecall").html("<a>N</a>服务器通信失败");
		}
	});
}
function test(obj){
	if(obj.val() != $("#password").val()){
		$("#showmetherecall").html("<a>N</a>密码不一致");
	}else{
		$("#showmetherecall").html("");
	}
}
