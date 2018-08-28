$(function() {
	$('#doc-dropdown-js').dropdown({
		justify: '#doc-dropdown-justify-js'
	});
});
$(function() {
	$(".office_text").panel({
		iWheelStep: 32
	});
});
$(document).ready(function() {
	$(".sidestrip_icon a").click(function() {
		$(".sidestrip_icon a").eq($(this).index()).addClass("cur").siblings().removeClass('cur');
		$(".middle").hide().eq($(this).index()).show();
	});
});
$(document).ready(function() {
	$("#input_box").focus(function() {
		$('.windows_input').css('background', '#fff');
		$('#input_box').css('background', '#fff');
	});
	$("#input_box").blur(function() {
		$('.windows_input').css('background', '');
		$('#input_box').css('background', '');
	});
});