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
		$("#mess").hide()
	}
	if(obj.attr('type')=='text'&&obj.val()!=obj.attr('title')){
		chkfirstmail(obj);
	}
}
function chkfirstmail(obj){
	if(chkmail(obj)){
		$.ajax({
			url:"post.php",
			type:"POST",
			dataType: "html",
			data: "type=user_chk&"+obj.attr('name')+'='+obj.val(),
			success:function(data){
				if(data!='true'){
					$("#mess").show().html("邮箱不对哦，请重试");
				}
			},
			error: function(){
				$("#mess").show().html("网络存在问题，与服务器通信失败");
			}
		});
	}else{
		$("#mess").show().html("邮箱格式不对，请重试");
	}
}
function sendData(){
	var obj1=$('.one:first'),obj2=$(".one:last"),obj3=$(".there");
	if(obj1.val()!=obj1.attr('title') && obj2.val()!=obj2.attr('title')){
		$.ajax({
			type:'POST',
			url:"post.php",
			datatype:'html',
			data: "type=user_login&"+obj1.attr('name')+'='+obj1.val()+"&"+obj2.attr('name')+'='+obj2.val()+"&"+obj3.attr('name')+'='+obj3.attr('checked'),
			success: function(data){
				if(data == 'true'){
					window.location.href='index.php';
				}else{
					$("#mess").html("密码错误").show();
				}
			},
			error: function(){
				$("#mess").show().html("网络存在问题，与服务器通信失败");
			}
		})
	}else{
		$("#mess").html("输入框的信息不完整哦").show();
	}
}
$(document).ready(function(){
	$(".one").focus(function(){clear($(this))});
	$(".one").blur(function(){showval($(this))});
	$(".two").click(function(){sendData()});
});