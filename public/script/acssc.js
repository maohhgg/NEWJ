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
$(document).ready(function(){
	$("#sea").focus(function(){stretch();});
	$("#sea").focusout(function(){stretch2();});
	if($("#end")){
		$("#end").find("a").click(function(){
			$("body").animate({scrollTop:0}, 500);
		});
	}
});