function setask(){
	$("#setask").slideToggle();
}
function chknum(obj){
	obj.html('');
}
function showval(obj){
	if(!obj.html()){
		var str=obj.attr('title');
		obj.html(str);
		return 0;
	}
}

function createview(){
	if($("#upword > textarea").val() != '144个字符内' && $("#upword > textarea").val() != ''){
		str = "type=obj_order_view";
		str = str + "&parent=" + window.location.search.substr(17);
		str = str + "&content=" + $("#upword > textarea").val();
		$.ajax({
			url: "post.php",
			type: "POST",
			data: str,
			success: function (data){
				if(data == 'true'){
					window.location.reload() 
				}else{
					$("#mess").html("因为各种原因导致你的项目创建失败！请谅解。你可以重新建立");
				}
			}
		});
	}else{
		$("#mess").html("内容是不可少，虽然要在144个字内");
	}
}

$(window).load(function(){
	$("#upword > textarea").focus(function(){chknum($(this))});
	$("#upword > textarea").blur(function(){showval($(this))});
});