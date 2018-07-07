$(document).ready(function(){
bind_doom();
$("#save_search").live("click",function(){
	var doom  = $("#doom_search").clone();
	doom.find("input[type='text']").each(function(){
		$(this).attr("value",$(this).val());
	});
	doom.find("input[type='checkbox']").each(function(){
		if($(this).is(":checked"))
			$(this).attr("checked","checked");
	});
	doom.find("select").each(function(){
		var val = $(this).val();
		$(this).find("option").each(function(){
		
			if($(this).attr("value") == val) $(this).attr("selected","selected");
		});
	});
	var name = $("#save_field").val();
	if($.trim(name)==''){
		$("#msgbox").html(' <div class="err_msg">Please add a name!<br></div> ');
		return false;
	}
	$("#msgbox").html(' ');
	$("#ajaxmark").css({"visibility":"visible"});
	$.ajax({
		url:"",
		type:"POST",
		async:false, 
		data:{"isAjax":"save_search","doom":doom.html(),"name":name},
		success:function(r){ 
		
			$("#msgbox").html(' <div class="note_msg">Search saved</div> ');
			$("#load_select").html(r);
			$("#ajaxmark").css({"visibility":"hidden"});
		}
	});
	return false;
})

$("#load_search").live("click",function(){
	 
	var val = $("#load_select").val();
	
	$("#msgbox").html(' ');
	$("#ajaxmark").css({"visibility":"visible"});
	$.ajax({
		url:"",
		type:"POST",
		async:false, 
		data:{"isAjax":"load_search","id":val},
		success:function(r){ 
			$("#doom_search").html(r);
			$("#ajaxmark").css({"visibility":"hidden"});
			
			$("#msgbox").html(' <div class="note_msg">Search loaded</div> ');
		}
	});
	bind_doom();
	return false;
})
$("#print_btn").live("click",function(){
	
$("#ajaxmark").css({"visibility":"visible"});
 var data = {}; 
 var ok = true;
 var data_include = [];
 if($("#issued_inventories").is(":checked")){
		data_include.push({"issue":"yes"});
 }
 if($("#processed_inventories").is(":checked")){
		data_include.push({"process":"yes"});
 }
 if($("#dispatch_inventories").is(":checked")){
		data_include.push({"dispatch":"yes"});
 }
$(".panels").each(function(i){
		 
		if($(this).attr("excluded") == "excluded") ok =  false; 
		if(ok && $(this).attr("active") == "active" && ($(this).attr("blocked") == "blocked"  ) ){
			var id = $(this).attr("id");	
			var values = [];
			if($(this).find("select").length>0){
 
				$(this).find(".filter_wrapper").each(function(){
					values.push($(this).find("select").val());
				});
			}
			if($(this).find("input").length>0){ 
				$(this).find(".filter_wrapper").each(function(){
					values.push({"start":$(this).find("input:first").val(),"end":$(this).find("input:last").val()});
				});
			
			
			}
			
			data[id] = values;
		}
}) ;
var data_fields = {};
$("#rightpanel_print div") .each(function(){
	var field_id = $(this).attr("id");
	var values = {};  
	$(this).find("input[type='checkbox']").each(function(){
		if($(this).is(":checked")) {
			values[$(this).attr('name')] = $(this).val();
		}
	});
	data_fields[field_id] =  values;
});  
	$.ajax({
		url:"",
		type:"POST",
		async:false, 
		data:{"isAjax":"print_raport","data":data,"include":data_include,fields:data_fields},
		success:function(r){ 
		 
			window.open($.trim(r),'pdf_fil','height='+$(window).height()+',width='+$(window).width());
				
			
			$("#ajaxmark").css({"visibility":"hidden"});
		}
	});

 
  return false;
})
});

function bind_doom(){

	$("#left_panel a").live("click",function(){
	var id = $(this).attr("id");
	$(".panels").hide();
	if($("#"+id+"_panel").is(":visible")){
		$("#"+id+"_panel").hide();
	}else{
		$("#"+id+"_panel").show();
	}
	
	return false;
	});	
	
	$("#leftpanel_print a").die("click").live("click",function(){
	var id = $(this).attr("id");
	$("#rightpanel_print div").hide();
	if($("#"+id+"_panel").is(":visible")){
		$("#"+id+"_panel").hide();
	}else{
		$("#"+id+"_panel").show();
	}
	
	return false;
	});
	$("#left_panel input").die("click").live("click",function(){
	if($(this).next().next().is(":visible")){
		$(this).next().next().find("a").each(function(){
			var panid = $(this).attr("href");
			$(panid).removeAttr("active");
			
		})
		$(this).next().next().hide();
	}else{
		$(this).next().next().find("a").each(function(){
			var panid = $(this).attr("href");
			$(panid).attr("active","active");
			
		})
		$(this).next().next().show();
	
	} 
	});
	$(".panels .add_filter").die("click").live("click",function(){
	if($(this).parent().attr("blocked") == "blocked") return false;
	if($(this).parent().attr("excluded") == "excluded") return false;
	

		var clone = $(this).parent().find(".filter_wrapper:first").clone();
		clone.find("input").die("focus").val("");
		clone.find("select").val(""); 
		
		$(this).parent().find(".filter_wrapper:last").after(clone);
 		 bind_dates( );

	return false;
	})
	$(".panels .block_filter").die("click").live("click",function(){
			
			if($(this).parent().attr("excluded") == "excluded") return false;
			$(this).find("span").text("Unblock");
			$(this).removeClass("block_filter");
			$(this).addClass("unblock_filter");
			$(this).parent().find(".filter_wrapper").find("select,input").attr("disabled","disabled");
			$(this).parent().attr("blocked","blocked");
			return false;
	});
	$(".panels .exclude_filter").die("click").live("click",function(){  
	
			if($(this).parent().attr("blocked") == "blocked") return false;
			$(this).find("span").text("Include");
			$(this).removeClass("exclude_filter");
			$(this).addClass("include_filter");
			$(this).parent().find(".filter_wrapper").find("select,input").attr("disabled","disabled");
			$(this).parent().attr("excluded","excluded");
			return false;
	});

	$(".panels .include_filter").die("click").live("click",function(){  
			$(this).find("span").text("Exclude");
			$(this).removeClass("include_filter");
			$(this).addClass("exclude_filter");
			$(this).parent().find(".filter_wrapper").find("select,input").removeAttr("disabled");
			$(this).parent().removeAttr("excluded");
			return false;
	});
	$(".panels .unblock_filter").die("click").live("click",function(){

			if($(this).parent().attr("excluded") == "excluded") return false;	
			$(this).find("span").text("Block");
			$(this).removeClass("unblock_filter");
			$(this).addClass("block_filter");
			$(this).parent().find(".filter_wrapper").find("select,input").removeAttr("disabled");
			$(this).parent().removeAttr("blocked");
			return false;
	});
	$(".panels .update_filter").die("click").live("click",function(){

			if($(this).parent().attr("blocked") == "blocked") return false;
			if($(this).parent().attr("excluded") == "excluded") return false;	
			update_filters($(this).parent().index());
			return false;
	});

	 bind_dates( );


}
function update_filters(index){
$("#ajaxmark").css({"visibility":"visible"});
 var data = {}; 
 var ok = true;
 var data_include = [];
 if($("#issued_inventories").is(":checked")){
		data_include.push({"issue":"yes"});
 }
 if($("#processed_inventories").is(":checked")){
		data_include.push({"process":"yes"});
 }
 if($("#dispatch_inventories").is(":checked")){
		data_include.push({"dispatch":"yes"});
 }
$(".panels").each(function(i){
		 
		if($(this).attr("excluded") == "excluded") ok =  false; 
		if(ok && $(this).attr("active") == "active" && ($(this).attr("blocked") == "blocked" || i == index-1) ){
			var id = $(this).attr("id");	
			var values = [];
			if($(this).find("select").length>0){
 
				$(this).find(".filter_wrapper").each(function(){
					values.push($(this).find("select").val());
				});
			}
			if($(this).find("input").length>0){ 
				$(this).find(".filter_wrapper").each(function(){
					values.push({"start":$(this).find("input:first").val(),"end":$(this).find("input:last").val()});
				});
			
			
			}
			
			data[id] = values;
		}
})  
	$.ajax({
		url:"",
		type:"POST",
		async:false,
		dataType:"json",
		data:{"isAjax":"update_fields","data":data,"include":data_include},
		success:function(r){ 
		 
			$.each(r, function(key, value) {
				if($("#"+key).attr("blocked") != 'blocked' && $("#"+key).attr("excluded") != 'excluded'){
				$("#"+key).find("select").html("<option value=''>None</option>");
						 $.each(value, function(k,v) {
								$("#"+key).find("select").append("<option value='"+k+"'>"+v+"</option>");
						 })
				} 
				})	 
				
			
			$("#ajaxmark").css({"visibility":"hidden"});
		}
	});



}
function bind_dates(obj){
 	$("#right_panel .date_field").each(function(i){
		 $(this).die("focus").live("focus",function(){
			$(this).attr("name",$(this).attr('name')+i)
			date_picker(this);
		 });
	});
}


 