function newtask(){
	$("#newtasks").slideToggle();
}

function createorder(){
	if($("#ordername").val()){
		$("#mess").html("");
		var str='type=obj_order';
		str=str+"&parent="+window.location.search.substr(1,15);
		str=str+"&name="+$("#ordername").val();
		$.ajax({
			url: "post.php",
			type: "POST",
			data: str,
			success: function(data){
				if(data == 'true'){
					window.location.reload() 
				}else{
					$("#mess").html("因为各种原因导致你的项目创建失败！请谅解。你可以重新建立");
				}
			}
		});

	}else{
		$("#mess").html("名字是很重要的哦");
	}
}
function getimg(str){
	var str='type=obj_new_file';
	str=str+"&parent="+window.location.search.substr(1,15);
	$.ajax({
		url:"post.php",
		type:"post",
		data:str,
		success: function(data){
			$("#listshowimg").append("<a class='li fancybox-effects-d' href='"+data+"'><img src='"+data+"' /></a>");
		}
	});
}

function sendfile(obj){

	$.ajaxFileUpload({  
		url:'upload.php',
		secureuri:false,
		fileElementId:'uploadfile',  
		dataType: 'text',
		success: function (data,status){  
			getimg();
		},  
		error: function (data,status,e){  
			$.each(data,function(i,n){  
	   			$("#showmetherecall").html("<span>图片加载失败！</span>");   
			});  
		}
	}); 

}

$(document).ready(function() {

	$(".fancybox-effects-d").fancybox({
		padding: 0,
		openEffect : 'elastic',
		openSpeed  : 150,
		closeEffect : 'elastic',
		closeSpeed  : 150,
		closeClick : true,
		helpers : {
			overlay : null
		}
	});

	$('.fancybox-buttons').fancybox({
		openEffect  : 'none',
		closeEffect : 'none',
		prevEffect : 'none',
		nextEffect : 'none',
		closeBtn  : false,
		helpers : {
			title : {
				type : 'inside'
			},
			buttons	: {}
		},
		afterLoad : function() {
			this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
		}
	});




});