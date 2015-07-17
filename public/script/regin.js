function clear(obj){
	if(obj.val()==obj.attr('title')){
		obj.val('')
	}
}
function showval(obj){
	if(!obj.val()){
		var str=obj.attr('title');
		obj.val(str);
	}
}
function srue(){
	str = window.location.search;
	str = str.substr((str.length)-19,str.length);
	var obj1=$('.one:first'),obj2=$(".one:last");
	if(obj1.val()!=obj1.attr('title') && obj2.val()!=obj2.attr('title')){
		$.ajax({
			type:'POST',
			url:"post.php",
			datatype:'html',
			data: "type=user_srue&"+obj1.attr('name')+'='+obj1.val()+"&"+obj2.attr('name')+'='+obj2.val()+str,
			success: function(data){
				if(data == 'true'){
					window.location.href='index.php';
				}else{
					$("#mess").html(data).show();
				}
			}
		})
	}else{
		$("#mess").html("输入框的信息不完整哦").show();
	}

}
$(document).ready(function(){
	$(".one").focus(function(){clear($(this))});
	$(".one").blur(function(){showval($(this))});
	$(".two").click(function(){srue()});
});