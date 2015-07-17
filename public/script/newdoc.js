
function chknum(obj){
    obj.val('');
}
function showval(obj){
    if(!obj.val()){
        var str=obj.attr('title');
        obj.val(str);
        return 0;
    }
}
function sendword(){
	editor.sync();
	var str = 'type=obj_word';
	var par = window.location.search.substr(1,15);
	if($("#doctitle").val()!=$("#doctitle").attr("title")&&$("#editor").val()){
		str = str+"&parent="+par;
		str = str+"&name="+$("#doctitle").val();
		str = str+"&content="+$("#editor").val();
		$.ajax({
			url: "post.php",
			type: "POST",
			data: str,
			success: function(data){
				if(data == 'true'){
					window.location.href="projects.php?"+par;
				}else{
					$("#mess").html("因为各种原因导致你的项目创建失败！请谅解。你可以重新建立");
				}
			}
		});

	}else{
		$("#mess").html("完整的文章包括标题和内容哦").show();
	}
}
function closewindow(){
	window.history.back();
}
$(window).load(function(){
    $("#doctitle").focus(function(){chknum($(this))});
    $("#doctitle").blur(function(){showval($(this))});
});