var ok_timer=true;
$(document).ready(function()
{
	console.log("I am here");
	$('#digital-clock').html('<span class="hour"></span><span class="min"></span><span class="sec"></span><span class="meridiem"></span>');
        $('#digital-clock').clock({offset: '0', type: 'digital'});
        $("input[name=attendance]").css('text-transform','uppercase');
	setInterval(function()
	{
		if(ok_timer)
		{
			var value = $("input[name=attendance]").val();
			if( (value.length == 5) && (ok_timer))
			{
				add_attendance(value);
			}
		}
		$("input[name=attendance]").focus();
	},1000);
});
function add_attendance(v)
{
	ok_timer=false;
	$.ajax(
	{
		url:"",
		type:"post",
		async:false,
		data:{"value":v,"action":"update_attendance"},
		dataType:"json",
		success:function(r)
		{
			console.log(r);
			$('#first_name').html(r.first_name);
			$('#last_name').html(r.last_name);
			$('.path_to_picture').attr('src',r.picture);
			$('#code').html(r.code);
			$("input[name=attendance]").val('');
			if(r.success == 1)
			{
				if(r.code == 'GATE-IN')
				{
					$('#code').css('color','green');
				}
				else
				{
					$('#code').css('color','red');
				}
			}
			else
			{
				$('#code').css('color','red');
				$('#code').css('text-decoration','underline');
			}
			ok_timer=true;
		}
	});
}
