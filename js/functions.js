var tmp_id = 0;
var tmp_comment = null;

$(document).ready(function() {
	var w = $(window).width();
	if (w <= 768) {
		$("#left").html($("#left").html() + $("#right").html());
		$("#right").remove();
	}
	if (w <= 600) {
		var h2 = $("#course h2");
		$("#course h2").remove();
		$(h2).prependTo("#course");
	}
	if (w <= 468) {
		$("#top_sep").replaceWith("<br /><br />");
	}
	$("a[rel='external']").attr("target", "_blank");
	/* prettyPrint();*/
	
	$(".captcha img:first-child").bind("click", function(event) {
		var captcha = $(".captcha img:last-child");
		var src = $(captcha).attr("src");
		if ((i = src.indexOf("?")) == -1) src += "?" + Math.random();
		else src = src.substring(0, i) + "?" + Math.random();
		$(captcha).attr("src", src);
	});
	
	$(document).on("click", "#comment_cancel span", function(event) {
		commentCancel();
	});
	
	$(document).on("click", "#add_comment", function(event) {
		commentCancel();
		showFormComment();
	});
	
	$(document).on("click", "#comments .reply_comment", function(event) {
		commentCancel();
		var parent_id = $(event.target).parents("div").get(0).id;
		$("#form_add_comment").appendTo("#" + parent_id);
		$("#form_add_comment #parent_id").val(parent_id.substr("comment_".length));
		showFormComment();
	});
	
	$(document).on("click", "#form_add_comment .button", function(event) {
		if ($("#form_add_comment textarea").val()) {
			var query;
			var comment_id = $("#comment_id").val();
			var text_comment = $("#text_comment").val();
			if (comment_id != 0) {
				query = "func=edit&obj=comment&name=text_" + comment_id + "&value=" + encodeURIComponent(text_comment);
				ajax(query, error, successEditComment);
			}
			else {
				var parent_id = $("#parent_id").val();
				var article_id = $("#article_id").val();
				query = "func=add_comment&parent_id=" + parent_id + "&article_id=" + article_id + "&text=" + encodeURIComponent(text_comment);
				ajax(query, error, successAddComment);
			}
		}
		else alert("You did not enter comment text!");
	});
	
	$(document).on("click", "#comments .edit_comment", function(event) {
		commentCancel();
		var parent_id = $(event.target).parents("div").get(0).id;
		tmp_comment = $("#" + parent_id).clone();
		$("#form_add_comment #comment_id").val(parent_id.substr("comment_".length));
		var temp = $("#" + parent_id + " .text").html();
		temp = temp.replace(/&lt;/g, "<");
		temp = temp.replace(/&gt;/g, ">");
		temp = temp.replace(/&amp;/g, "&");
		$("#form_add_comment #text_comment").val(temp);
		$($("#" + parent_id)).replaceWith($("#form_add_comment"));
		showFormComment();
	});
	
	$(document).on("click", "#comments .delete_comment", function(event) {
		commentCancel();
		if (confirm("Are you sure you want to delete the comment?")) {
			var comment_id = $(event.target).parents("div").get(0).id.substring("comment_".length);
			tmp_id = comment_id;
			var query = "func=delete&obj=comment&id=" + comment_id;
			ajax(query, error, successDeleteComment);
		}
	});
	
});

function error() {
	alert("An error has occurred! Try the operation later.");
}

function successAddComment(data) {
	data = data["r"];
	data = JSON.parse(data);
	var comment = getTemplateComment(data.id, data.user_id, data.name, data.avatar, data.text, data.date);
	if (data.parent_id != 0) {
		$("#form_add_comment").appendTo("#comments");
		$("#comment_" + data.parent_id).append(comment);
	}
	else $("#form_add_comment").before(comment);
	
	closeFormComment();
}

function successEditComment(data) {
	if (data["r"]) $(tmp_comment).find(".text").html(data["r"]);
	if (data) {
		var form = $("#form_add_comment").clone();
		$("#form_add_comment").replaceWith($(tmp_comment));
		tmp_comment = null;
		$(form).appendTo("#comments");
	}
	else error();
	closeFormComment();
}

function successDeleteComment(data) {
	if (data["r"]) {
		$("#comment_" + tmp_id).fadeOut(500, function() {
			$("#comment_" + tmp_id).remove();
			$("#count_comments").text($(".comment").length);
			tmp_id = 0;
		});
	}
	else error();
}

function getTemplateComment(id, user_id, name, avatar, text, date) {
	var str = "<div class='comment' id='comment_" + id + "'>";
	str += "<img src='" + avatar + "' alt='" + name + "' />";
	str += "<span class='name'>" + name + "</span>";
	str += "<span class='date'>" + date + "</span>";
	str += "<p class='text'>" + text + "</p>";
	str += "<div class='clear'></div>";
	str += "<p class='functions'><span class='reply_comment'>Reply</span> <span class='edit_comment'>Reply</span> <span class='delete_comment'>Remove</span>"; 
	str += "</div>";
	return str;
}

function showFormComment() {
	$("#form_add_comment").css("display", "inline-block");
	$("#form_add_comment textarea").focus();
}

function commentCancel() {
	if (tmp_comment) {
		successEditComment(true);
	}
	closeFormComment();
}

function closeFormComment() {
	$("#form_add_comment #parent_id").val(0);
	$("#form_add_comment #text_comment").val("");
	$("#form_add_comment #comment_id").val(0);
	$("#form_add_comment").css("display", "none");
	$("#count_comments").text($(".comment").length);
}


function getSocialNetwork(f, t, u) {
	if (!t) t=document.title;
	if (!u) u=location.href;
	t = encodeURIComponent(t);
	u = encodeURIComponent(u);
	var s = new Array(
		'http://www.facebook.com/sharer.php?u='+u+'&t='+t+'" title="???????????????????? ?? Facebook"',
		'http://vkontakte.ru/share.php?url='+u+'" title="???????????????????? ?? ????????????????"',
		'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl='+u+'&title='+t+'" title="???????????????? ?? ??????????????????????????"',
		'http://twitter.com/share?text='+t+'&url='+u+'" title="???????????????? ?? Twitter"',
		'http://connect.mail.ru/share?url='+u+'&title='+t+'" title="???????????????????? ?? ???????? ????????@Mail.Ru"',
		'http://www.google.com/buzz/post?message='+t+'&url='+u+'" title="???????????????? ?? Google Buzz"',
		'http://www.livejournal.com/update.bml?event='+u+'&subject='+t+'" title="???????????????????????? ?? LiveJournal"',
		'http://www.friendfeed.com/share?title='+t+' - '+u+'" title="???????????????? ?? FriendFeed"'
	);
	for(i = 0; i < s.length; i++)
		document.write('<a rel="nofollow" style="display:inline-block;width:32px;height:32px;margin:0 7px 0 0;background:url('+f+'icons.png) -'+32*i+'px 0" href="'+s[i]+'" target="_blank"></a>');
}

function ajax(data, func_error, func_success) {
	$.ajax({
		url: "/api.php",
		type: "POST",
		data: (data),
		dataType: "text",
		error: func_error,
		success: function(result) {
			result = $.parseJSON(result);
			func_success(result);
		}
	});
}

 /* Slick.js http://kenwheeler.github.io/slick/
    ========================*/

    $('#js-testimonials-slider').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        dots: true,
        autoplay: true,
        autoplaySpeed: 4000,
        fade: false
    });


    $(".js-slider-prev").on("click", function() {
        $('#js-testimonials-slider').slick("slickPrev");
    });

    $(".js-slider-next").on("click", function() {
        $('#js-testimonials-slider').slick("slickNext");
    });


	$(document).ready(function(){
	$('#newsletter-signup').submit(function(){
		
		//??????????????????, ???? ???????????????????????? ???? ?????? ?????????? ?? ?????????????? ???????????? ??????????????
		if($(this).data('formstatus') !== 'submitting'){
		
			//?????????????????????????? ????????????????????
			var form = $(this),
				formData = form.serialize(),
				formUrl = form.attr('action'),
				formMethod = form.attr('method'), 
				responseMsg = $('#signup-response');
			
			//?????????????????? ???????? ?? ??????????
			form.data('formstatus','submitting');
			
			//???????????????????? ???????????????????? ?? ???????????????? ??????????????????
			responseMsg.hide()
					   .addClass('response-waiting')
					   .text('????????????????????, ??????????????????...')
					   .fadeIn(200);
			
			//???????????????????? ???????????? ???? ???????????? ?????? ????????????????
			$.ajax({
				url: formUrl,
				type: formMethod,
				data: formData,
				success:function(data){
					
					//?????????????????????????? ????????????????????
					var responseData = jQuery.parseJSON(data), 
						klass = '';
					
					//?????????????????? ????????????
					switch(responseData.status){
						case 'error':
							klass = 'response-error';
						break;
						case 'success':
							klass = 'response-success';
						break;	
					}
					
					//???????????????????? ?????????????????? ????????????
					responseMsg.fadeOut(200,function(){
						$(this).removeClass('response-waiting')
							   .addClass(klass)
							   .text(responseData.message)
							   .fadeIn(200,function(){
								   //?????????????????????????? ?????????????? ?????? ?????????????? ?????????????????? ????????????
								   setTimeout(function(){
									   responseMsg.fadeOut(200,function(){
									       $(this).removeClass(klass);
										   form.data('formstatus','idle');
									   });
								   },3000)
								});
					});
				}
			});
		}
		
		//?????????????????????????? ???????????????? ??????????
		return false;
	});
});


	