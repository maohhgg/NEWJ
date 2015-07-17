function clear(obj){
	if(obj.val()==obj.attr('title')){
		obj.val('')
	}
}
function chkmail(obj){
	var Expression=/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/; 
	var objExp=new RegExp(Expression);
	return objExp.test(obj.val());
}
function showval(obj){
	if(!obj.val()){
		var str=obj.attr('title');
		obj.val(str);
	}else if(chkmail(obj)){
		$("#mess").hide()
		$.ajax({
			url:"post.php",
			type:"POST",
			dataType: "html",
			data: "type=user_chk&"+obj.attr('name')+'='+obj.val(),
			success:function(data){
				if(data=="true"){
					$("#mess").show().html('这个邮箱已经注册了哦');
				}
			}
		});
	}else{
		$("#mess").show().html("邮箱格式不对，请重试");
	}
}
function sendmail(){
	var obj = $(".one");
	if(obj.val()==obj.attr('title')){
		$("#mess").show().html("你还没填你的邮箱呢");
	}else{
		$.ajax({
			url:"post.php",
			type:"POST",
			dataType: "html",
			data: "type=user_reg_tmp&"+obj.attr('name')+'='+obj.val(),
			success:function(data){
				if(data){
					$("#center").hide();
					$("#secc").show().html("邮件发送成功 注意查收 <a href='index.php'>返回</a>");
				}else{
					$("#mess").html("由于我们各种的原因，没有成功请重试");
				}
			}
		});
	}
}
$(document).ready(function(){
	$(".one").focus(function(){clear($(this))});
	$(".one").blur(function(){showval($(this))});
	$(".two").click(function(){sendmail()});
});