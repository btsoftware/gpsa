/** Wonderplugin Carousel - WordPress Image Video Carousel Plugin
 * Copyright 2014 Magic Hills Pty Ltd All Rights Reserved
 * Website: http://www.wonderplugin.com
 * Version 1.1 
 */
(function($){$(document).ready(function(){$("#wonderplugin-carousel-toolbar").find("li").each(function(index){$(this).click(function(){if($(this).hasClass("wonderplugin-tab-buttons-selected"))return;$(this).parent().find("li").removeClass("wonderplugin-tab-buttons-selected");if(!$(this).hasClass("laststep"))$(this).addClass("wonderplugin-tab-buttons-selected");$("#wonderplugin-carousel-tabs").children("li").removeClass("wonderplugin-tab-selected");$("#wonderplugin-carousel-tabs").children("li").eq(index).addClass("wonderplugin-tab-selected");
$("#wonderplugin-carousel-tabs").removeClass("wonderplugin-tabs-grey");if(index==3){previewCarousel();$("#wonderplugin-carousel-tabs").addClass("wonderplugin-tabs-grey")}else if(index==4)publishCarousel()})});var getURLParams=function(href){var result={};if(href.indexOf("?")<0)return result;var params=href.substring(href.indexOf("?")+1).split("&");for(var i=0;i<params.length;i++){var value=params[i].split("=");if(value&&value.length==2&&value[0].toLowerCase()!="v")result[value[0].toLowerCase()]=value[1]}return result};
var slideDialog=function(dialogType,onSuccess,data,dataIndex){var dialogTitle=["image","video","Youtube Video","Vimeo Video"];var dialogCode="<div class='wonderplugin-dialog-container'>"+"<div class='wonderplugin-dialog-bg'></div>"+"<div class='wonderplugin-dialog'>"+"<h3 id='wonderplugin-dialog-title'></h3>"+"<div class='error' id='wonderplugin-dialog-error' style='display:none;'></div>"+"<table id='wonderplugin-dialog-form' class='form-table'>";if(dialogType==2||dialogType==3)dialogCode+="<tr>"+
"<th>Enter video URL</th>"+"<td><input name='wonderplugin-dialog-video' type='text' id='wonderplugin-dialog-video' value='' class='regular-text' /> <input type='button' class='button' id='wonderplugin-dialog-select-video' value='Enter' /></td>"+"</tr>"+"<tr>";dialogCode+="<tr>"+"<th>Enter"+(dialogType>0?" poster":"")+" image URL</th>"+"<td><input name='wonderplugin-dialog-image' type='text' id='wonderplugin-dialog-image' value='' class='regular-text' /> or <input type='button' class='button' data-textid='wonderplugin-dialog-image' id='wonderplugin-dialog-select-image' value='Upload' /></td>"+
"</tr>"+"<tr id='wonderplugin-dialog-image-display-tr' style='display:none;'>"+"<th></th>"+"<td><img id='wonderplugin-dialog-image-display' style='width:80px;height:80px;' /></td>"+"</tr>"+"<tr>"+"<th>Thumbnail URL</th>"+"<td><input name='wonderplugin-dialog-thumbnail' type='text' id='wonderplugin-dialog-thumbnail' value='' class='regular-text' /></td>"+"</tr>";if(dialogType==1)dialogCode+="<tr>"+"<th>MP4 video URL</th>"+"<td><input name='wonderplugin-dialog-mp4' type='text' id='wonderplugin-dialog-mp4' value='' class='regular-text' /> or <input type='button' class='button' data-textid='wonderplugin-dialog-mp4' id='wonderplugin-dialog-select-mp4' value='Upload' /></td>"+
"</tr>"+"<tr>"+"<tr>"+"<th>WebM video URL (Optional)</th>"+"<td><input name='wonderplugin-dialog-webm' type='text' id='wonderplugin-dialog-webm' value='' class='regular-text' /> or <input type='button' class='button' data-textid='wonderplugin-dialog-webm' id='wonderplugin-dialog-select-webm' value='Upload' /></td>"+"</tr>"+"<tr>";dialogCode+="<tr>"+"<th>Title</th>"+"<td><input name='wonderplugin-dialog-image-title' type='text' id='wonderplugin-dialog-image-title' value='' class='large-text' /></td>"+
"</tr>"+"<tr>"+"<th>Description</th>"+"<td><textarea name='wonderplugin-dialog-image-description' type='' id='wonderplugin-dialog-image-description' value='' class='large-text' /></td>"+"</tr>";dialogCode+="<tr>"+"<th>Click to open Lightbox popup</th>"+"<td><label><input name='wonderplugin-dialog-lightbox' type='checkbox' id='wonderplugin-dialog-lightbox' value='' checked /> Open current "+dialogTitle[dialogType]+" in Lightbox</label></td>"+"</tr>";if(dialogType==0)dialogCode+="<tr><th>Click to open web link</th>"+
"<td>"+"<input name='wonderplugin-dialog-weblink' type='text' id='wonderplugin-dialog-weblink' value='' class='regular-text' disabled />"+"</td>"+"</tr>"+"<tr><th>Set web link target</th>"+"<td>"+"<input name='wonderplugin-dialog-linktarget' type='text' id='wonderplugin-dialog-linktarget' value='' class='regular-text' disabled />"+"</td>"+"</tr>";dialogCode+="</table>"+"<br /><br />"+"<div class='wonderplugin-dialog-buttons'>"+"<input type='button' class='button button-primary' id='wonderplugin-dialog-ok' value='OK' />"+
"<input type='button' class='button' id='wonderplugin-dialog-cancel' value='Cancel' />"+"</div>"+"</div>"+"</div>";var $slideDialog=$(dialogCode);$("body").append($slideDialog);$("#wonderplugin-dialog-lightbox").click(function(){var is_checked=$(this).is(":checked");if($("#wonderplugin-dialog-weblink").length){$("#wonderplugin-dialog-weblink").attr("disabled",is_checked);if(is_checked)$("#wonderplugin-dialog-weblink").val("")}if($("#wonderplugin-dialog-linktarget").length){$("#wonderplugin-dialog-linktarget").attr("disabled",
is_checked);if(is_checked)$("#wonderplugin-dialog-linktarget").val("")}});$(".wonderplugin-dialog").css({"margin-top":String($(document).scrollTop()+60)+"px"});$(".wonderplugin-dialog-bg").css({height:$(document).height()+"px"});$("#wonderplugin-dialog-title").html("Add "+dialogTitle[dialogType]);if(data){if(dialogType==2||dialogType==3)$("#wonderplugin-dialog-video").val(data.video);$("#wonderplugin-dialog-image").val(data.image);if(data.image){$("#wonderplugin-dialog-image-display-tr").css({display:"table-row"});
$("#wonderplugin-dialog-image-display").attr("src",data.image)}$("#wonderplugin-dialog-thumbnail").val(data.thumbnail);$("#wonderplugin-dialog-image-title").val(data.title);$("#wonderplugin-dialog-image-description").val(data.description);if(dialogType==1){$("#wonderplugin-dialog-mp4").val(data.mp4);$("#wonderplugin-dialog-webm").val(data.webm)}if(dialogType==0)if(data.lightbox){$("#wonderplugin-dialog-weblink").attr("disabled",true);$("#wonderplugin-dialog-linktarget").attr("disabled",true);$("#wonderplugin-dialog-weblink").val("");
$("#wonderplugin-dialog-linktarget").val("")}else{$("#wonderplugin-dialog-weblink").attr("disabled",false);$("#wonderplugin-dialog-linktarget").attr("disabled",false);$("#wonderplugin-dialog-weblink").val(data.weblink);$("#wonderplugin-dialog-linktarget").val(data.linktarget)}$("#wonderplugin-dialog-lightbox").attr("checked",data.lightbox)}if(dialogType==2||dialogType==3)$("#wonderplugin-dialog-select-video").click(function(){var videoData={type:dialogType,video:$.trim($("#wonderplugin-dialog-video").val()),
image:$.trim($("#wonderplugin-dialog-image").val()),thumbnail:$.trim($("#wonderplugin-dialog-thumbnail").val()),title:$.trim($("#wonderplugin-dialog-image-title").val()),description:$.trim($("#wonderplugin-dialog-image-description").val())};$slideDialog.remove();onlineVideoDialog(dialogType,function(items){items.map(function(data){wonderplugin_carousel_config.slides.push({type:dialogType,image:data.image,thumbnail:data.thumbnail?data.thumbnail:data.image,video:data.video,mp4:data.mp4,webm:data.webm,
title:data.title,description:data.description,weblink:data.weblink,linktarget:data.linktarget,lightbox:data.lightbox})});updateMediaTable()},videoData,true,dataIndex)});var media_upload_onclick=function(event){event.preventDefault();var buttonId=$(this).attr("id");var textId=$(this).data("textid");var media_uploader=wp.media.frames.file_frame=wp.media({title:"Choose Image",button:{text:"Choose Image"},multiple:dialogType==0&&buttonId=="wonderplugin-dialog-select-image"});media_uploader.on("select",
function(event){var selection=media_uploader.state().get("selection");if(dialogType==0&&buttonId=="wonderplugin-dialog-select-image"&&selection.length>1){var items=[];selection.map(function(attachment){attachment=attachment.toJSON();if(attachment.type!="image")return;var thumbnail;if(attachment.sizes&&attachment.sizes.thumbnail&&attachment.sizes.thumbnail.url)thumbnail=attachment.sizes.thumbnail.url;else if(attachment.sizes&&attachment.sizes.medium&&attachment.sizes.medium.url)thumbnail=attachment.sizes.medium.url;
else thumbnail=attachment.url;items.push({image:attachment.url,thumbnail:thumbnail,title:attachment.title,description:attachment.description,weblink:"",linktarget:"",lightbox:true})});$slideDialog.remove();onSuccess(items)}else{attachment=selection.first().toJSON();if(buttonId=="wonderplugin-dialog-select-image"){if(attachment.type!="image"){$("#wonderplugin-dialog-error").css({display:"block"}).html("<p>Please select an image file</p>");return}var thumbnail;if(attachment.sizes&&attachment.sizes.thumbnail&&
attachment.sizes.thumbnail.url)thumbnail=attachment.sizes.thumbnail.url;else if(attachment.sizes&&attachment.sizes.medium&&attachment.sizes.medium.url)thumbnail=attachment.sizes.medium.url;else thumbnail=attachment.url;$("#wonderplugin-dialog-image-display-tr").css({display:"table-row"});$("#wonderplugin-dialog-image-display").attr("src",attachment.url);$("#wonderplugin-dialog-image").val(attachment.url);$("#wonderplugin-dialog-thumbnail").val(thumbnail);$("#wonderplugin-dialog-image-title").val(attachment.title);
$("#wonderplugin-dialog-image-description").val(attachment.description)}else{if(attachment.type!="video"){$("#wonderplugin-dialog-error").css({display:"block"}).html("<p>Please select a video file</p>");return}$("#"+textId).val(attachment.url)}}$("#wonderplugin-dialog-error").css({display:"none"}).empty()});media_uploader.open()};if(parseInt($("#wonderplugin-carousel-wp-history-media-uploader").text())==1){var buttonId="";var textId="";var history_media_upload_onclick=function(event){buttonId=$(this).attr("id");
textId=$(this).data("textid");var mediaType=buttonId=="wonderplugin-dialog-select-image"?"image":"video";tb_show("Upload "+mediaType,"media-upload.php?referer=wonderplugin-carousel&type="+mediaType+"&TB_iframe=true",false);return false};window.send_to_editor=function(html){tb_remove();if(buttonId=="wonderplugin-dialog-select-image"){var $img=$("img",html);if(!$img.length){$("#wonderplugin-dialog-error").css({display:"block"}).html("<p>Please select an image file</p>");return}var thumbnail=$img.attr("src");
var src=$(html).is("a")?$(html).attr("href"):thumbnail;$("#wonderplugin-dialog-image-display-tr").css({display:"table-row"});$("#wonderplugin-dialog-image-display").attr("src",thumbnail);$("#wonderplugin-dialog-image").val(src);$("#wonderplugin-dialog-thumbnail").val(thumbnail);$("#wonderplugin-dialog-image-title").val($("img",html).attr("title"))}else{if($("img",html).length){$("#wonderplugin-dialog-error").css({display:"block"}).html("<p>Please select a video file</p>");return}$("#"+textId).val($(html).attr("href"))}$("#wonderplugin-dialog-error").css({display:"none"}).empty()};
$("#wonderplugin-dialog-select-image").click(history_media_upload_onclick);if(dialogType==1){$("#wonderplugin-dialog-select-mp4").click(history_media_upload_onclick);$("#wonderplugin-dialog-select-webm").click(history_media_upload_onclick)}}else{$("#wonderplugin-dialog-select-image").click(media_upload_onclick);if(dialogType==1){$("#wonderplugin-dialog-select-mp4").click(media_upload_onclick);$("#wonderplugin-dialog-select-webm").click(media_upload_onclick)}}$("#wonderplugin-dialog-ok").click(function(){if($.trim($("#wonderplugin-dialog-image").val()).length<=
0){$("#wonderplugin-dialog-error").css({display:"block"}).html("<p>Please select an image file</p>");return}if(dialogType==1&&$.trim($("#wonderplugin-dialog-mp4").val()).length<=0){$("#wonderplugin-dialog-error").css({display:"block"}).html("<p>Please select a video file</p>");return}var item={image:$.trim($("#wonderplugin-dialog-image").val()),thumbnail:$.trim($("#wonderplugin-dialog-thumbnail").val()),video:$.trim($("#wonderplugin-dialog-video").val()),mp4:$.trim($("#wonderplugin-dialog-mp4").val()),
webm:$.trim($("#wonderplugin-dialog-webm").val()),title:$.trim($("#wonderplugin-dialog-image-title").val()),description:$.trim($("#wonderplugin-dialog-image-description").val()),weblink:$.trim($("#wonderplugin-dialog-weblink").val()),linktarget:$.trim($("#wonderplugin-dialog-linktarget").val()),lightbox:$("#wonderplugin-dialog-lightbox").is(":checked")};$slideDialog.remove();onSuccess([item])});$("#wonderplugin-dialog-cancel").click(function(){$slideDialog.remove()})};var onlineVideoDialog=function(dialogType,
onSuccess,videoData,invokeFromSlideDialog,dataIndex){var dialogTitle=["Image","Video","Youtube Video","Vimeo Video"];var dialogCode="<div class='wonderplugin-dialog-container'>"+"<div class='wonderplugin-dialog-bg'></div>"+"<div class='wonderplugin-dialog'>"+"<h3 id='wonderplugin-dialog-title'></h3>"+"<div class='error' id='wonderplugin-dialog-error' style='display:none;'></div>"+"<table id='wonderplugin-dialog-form' class='form-table'>"+"<tr>"+"<th>Enter "+dialogTitle[dialogType]+" URL</th>"+"<td><input name='wonderplugin-dialog-video' type='text' id='wonderplugin-dialog-video' value='' class='regular-text' /></td>"+
"</tr>";dialogCode+="</table>"+"<div id='wonderplugin-carousel-video-dialog-loading'></div>"+"<div class='wonderplugin-dialog-buttons'>"+"<input type='button' class='button button-primary' id='wonderplugin-dialog-ok' value='OK' />"+"<input type='button' class='button' id='wonderplugin-dialog-cancel' value='Cancel' />"+"</div>"+"</div>"+"</div>";var $videoDialog=$(dialogCode);$("body").append($videoDialog);if(!videoData)videoData={type:dialogType};$("#wonderplugin-dialog-title").html("Add "+dialogTitle[dialogType]);
var videoDataReturn=function(){$videoDialog.remove();slideDialog(dialogType,function(items){if(items&&items.length>0){if(typeof dataIndex!=="undefined"&&dataIndex>=0)wonderplugin_carousel_config.slides.splice(dataIndex,1);items.map(function(data){var result={type:dialogType,image:data.image,thumbnail:data.thumbnail?data.thumbnail:data.image,video:data.video,mp4:data.mp4,webm:data.webm,title:data.title,description:data.description,weblink:data.weblink,linktarget:data.linktarget,lightbox:data.lightbox};
if(typeof dataIndex!=="undefined"&&dataIndex>=0)wonderplugin_carousel_config.slides.splice(dataIndex,0,result);else wonderplugin_carousel_config.slides.push(result)});updateMediaTable()}},videoData,dataIndex)};$("#wonderplugin-dialog-ok").click(function(){var href=$.trim($("#wonderplugin-dialog-video").val());if(href.length<=0){$("#wonderplugin-dialog-error").css({display:"block"}).html("<p>Please enter a "+dialogTitle[dialogType]+" URL</p>");return}if(dialogType==2){var youtubeId="";var regExp=/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
var match=href.match(regExp);if(match&&match[7]&&match[7].length==11)youtubeId=match[7];else{$("#wonderplugin-dialog-error").css({display:"block"}).html("<p>Please enter a valid Youtube URL</p>");return}var result="http://www.youtube.com/embed/"+youtubeId;var params=getURLParams(href);var first=true;for(var key in params){if(first){result+="?";first=false}else result+="&";result+=key+"="+params[key]}videoData.video=result;videoData.image="http://img.youtube.com/vi/"+youtubeId+"/0.jpg";videoData.thumbnail=
"http://img.youtube.com/vi/"+youtubeId+"/1.jpg";videoDataReturn()}else if(dialogType==3){var vimeoId="";var regExp=/^.*(vimeo\.com\/)((video\/)|(channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/;var match=href.match(regExp);if(match&&match[6])vimeoId=match[6];else{$("#wonderplugin-dialog-error").css({display:"block"}).html("<p>Please enter a valid Vimeo URL</p>");return}var result="http://player.vimeo.com/video/"+vimeoId;var params=getURLParams(href);var first=true;for(var key in params){if(first){result+=
"?";first=false}else result+="&";result+=key+"="+params[key]}videoData.video=result;$("#wonderplugin-carousel-video-dialog-loading").css({display:"block"});$.ajax({url:"http://www.vimeo.com/api/v2/video/"+vimeoId+".json?callback=?",dataType:"json",timeout:3E3,data:{format:"json"},success:function(data){videoData.image=data[0].thumbnail_large;videoData.thumbnail=data[0].thumbnail_medium;videoDataReturn()},error:function(){videoDataReturn()}})}});$("#wonderplugin-dialog-cancel").click(function(){$videoDialog.remove();
if(invokeFromSlideDialog)videoDataReturn()})};var updateMediaTable=function(){var mediaType=["Image","Video","YouTube","Vimeo"];$("#wonderplugin-carousel-media-table tbody").empty();for(var i=0;i<wonderplugin_carousel_config.slides.length;i++)$("#wonderplugin-carousel-media-table tbody").append("<tr>"+"<td>"+(i+1)+"</td>"+"<td><img src='"+wonderplugin_carousel_config.slides[i].thumbnail+"' style='width:60px;height:60px;' /></td>"+"<td>"+mediaType[wonderplugin_carousel_config.slides[i].type]+"</td>"+
"<td>"+"<input type='button' class='button wonderplugin-carousel-media-table-edit' value='Edit' />"+"<input type='button' class='button wonderplugin-carousel-media-table-moveup' value='Move Up' />"+"<input type='button' class='button wonderplugin-carousel-media-table-movedown' value='Move Down' />"+"<input type='button' class='button wonderplugin-carousel-media-table-delete' value='Delete' />"+"</td>"+"</tr>")};$("#wonderplugin-add-image").click(function(){slideDialog(0,function(items){items.map(function(data){wonderplugin_carousel_config.slides.push({type:0,
image:data.image,thumbnail:data.thumbnail?data.thumbnail:data.image,video:data.video,mp4:data.mp4,webm:data.webm,title:data.title,description:data.description,weblink:data.weblink,linktarget:data.linktarget,lightbox:data.lightbox})});updateMediaTable()})});$("#wonderplugin-add-video").click(function(){slideDialog(1,function(items){items.map(function(data){wonderplugin_carousel_config.slides.push({type:1,image:data.image,thumbnail:data.thumbnail?data.thumbnail:data.image,video:data.video,mp4:data.mp4,
webm:data.webm,title:data.title,description:data.description,weblink:data.weblink,linktarget:data.linktarget,lightbox:data.lightbox})});updateMediaTable()})});$("#wonderplugin-add-youtube").click(function(){onlineVideoDialog(2,function(items){items.map(function(data){wonderplugin_carousel_config.slides.push({type:2,image:data.image,thumbnail:data.thumbnail?data.thumbnail:data.image,video:data.video,mp4:data.mp4,webm:data.webm,title:data.title,description:data.description,weblink:data.weblink,linktarget:data.linktarget,
lightbox:data.lightbox})});updateMediaTable()})});$("#wonderplugin-add-vimeo").click(function(){onlineVideoDialog(3,function(items){items.map(function(data){wonderplugin_carousel_config.slides.push({type:2,image:data.image,thumbnail:data.thumbnail?data.thumbnail:data.image,video:data.video,mp4:data.mp4,webm:data.webm,title:data.title,description:data.description,weblink:data.weblink,linktarget:data.linktarget,lightbox:data.lightbox})});updateMediaTable()})});$(document).on("click",".wonderplugin-carousel-media-table-edit",
function(){var index=$(this).parent().parent().index();var mediaType=wonderplugin_carousel_config.slides[index].type;slideDialog(mediaType,function(items){if(items&&items.length>0){wonderplugin_carousel_config.slides.splice(index,1);items.map(function(data){wonderplugin_carousel_config.slides.splice(index,0,{type:mediaType,image:data.image,thumbnail:data.thumbnail?data.thumbnail:data.image,video:data.video,mp4:data.mp4,webm:data.webm,title:data.title,description:data.description,weblink:data.weblink,
linktarget:data.linktarget,lightbox:data.lightbox})});updateMediaTable()}},wonderplugin_carousel_config.slides[index],index)});$(document).on("click",".wonderplugin-carousel-media-table-delete",function(){var $tr=$(this).parent().parent();var index=$tr.index();wonderplugin_carousel_config.slides.splice(index,1);$tr.remove();$("#wonderplugin-carousel-media-table tbody").find("tr").each(function(index){$(this).find("td").eq(0).text(index+1)})});$(document).on("click",".wonderplugin-carousel-media-table-moveup",
function(){var $tr=$(this).parent().parent();var index=$tr.index();if(index==0)return;var data=wonderplugin_carousel_config.slides[index];wonderplugin_carousel_config.slides.splice(index,1);wonderplugin_carousel_config.slides.splice(index-1,0,data);var $prev=$tr.prev();$tr.remove();$prev.before($tr);$("#wonderplugin-carousel-media-table tbody").find("tr").each(function(index){$(this).find("td").eq(0).text(index+1)})});$(document).on("click",".wonderplugin-carousel-media-table-movedown",function(){var $tr=
$(this).parent().parent();var index=$tr.index();if(index==wonderplugin_carousel_config.slides.length-1)return;var data=wonderplugin_carousel_config.slides[index];wonderplugin_carousel_config.slides.splice(index,1);wonderplugin_carousel_config.slides.splice(index+1,0,data);var $next=$tr.next();$tr.remove();$next.after($tr);$("#wonderplugin-carousel-media-table tbody").find("tr").each(function(index){$(this).find("td").eq(0).text(index+1)})});var configSkinOptions=["width","height","autoplay","random",
"circular","direction","responsive","visibleitems"];var defaultSkinOptions={};for(var key in WONDERPLUGIN_CAROUSEL_SKIN_OPTIONS){defaultSkinOptions[key]={};for(var i=0;i<configSkinOptions.length;i++)defaultSkinOptions[key][configSkinOptions[i]]=WONDERPLUGIN_CAROUSEL_SKIN_OPTIONS[key][configSkinOptions[i]];defaultSkinOptions[key]["skintemplate"]=WONDERPLUGIN_CAROUSEL_SKIN_TEMPLATE[key]["skintemplate"];defaultSkinOptions[key]["skincss"]=WONDERPLUGIN_CAROUSEL_SKIN_TEMPLATE[key]["skincss"]}var printSkinOptions=
function(options){$("#wonderplugin-carousel-width").val(options.width);$("#wonderplugin-carousel-height").val(options.height);$("#wonderplugin-carousel-autoplay").attr("checked",options.autoplay);$("#wonderplugin-carousel-random").attr("checked",options.random);$("#wonderplugin-carousel-circular").attr("checked",options.circular);$("#wonderplugin-carousel-responsive").attr("checked",options.responsive);$("#wonderplugin-carousel-visibleitems").val(options.visibleitems);$("#wonderplugin-carousel-skintemplate").val(options.skintemplate);
$("#wonderplugin-carousel-skincss").val(options.skincss)};$("input:radio[name=wonderplugin-carousel-skin]").click(function(){if($(this).val()==wonderplugin_carousel_config.skin)return;$(".wonderplugin-tab-skin").find("img").removeClass("selected");$("input:radio[name=wonderplugin-carousel-skin]:checked").parent().find("img").addClass("selected");wonderplugin_carousel_config.skin=$(this).val();printSkinOptions(defaultSkinOptions[$(this).val()])});$(".wonderplugin-carousel-options-menu-item").each(function(index){$(this).click(function(){if($(this).hasClass("wonderplugin-carousel-options-menu-item-selected"))return;
$(".wonderplugin-carousel-options-menu-item").removeClass("wonderplugin-carousel-options-menu-item-selected");$(this).addClass("wonderplugin-carousel-options-menu-item-selected");$(".wonderplugin-carousel-options-tab").removeClass("wonderplugin-carousel-options-tab-selected");$(".wonderplugin-carousel-options-tab").eq(index).addClass("wonderplugin-carousel-options-tab-selected")})});var updateCarouselOptions=function(){wonderplugin_carousel_config.name=$.trim($("#wonderplugin-carousel-name").val());
wonderplugin_carousel_config.skin=$("input:radio[name=wonderplugin-carousel-skin]:checked").val();wonderplugin_carousel_config.width=parseInt($.trim($("#wonderplugin-carousel-width").val()));wonderplugin_carousel_config.height=parseInt($.trim($("#wonderplugin-carousel-height").val()));wonderplugin_carousel_config.autoplay=$("#wonderplugin-carousel-autoplay").is(":checked");wonderplugin_carousel_config.random=$("#wonderplugin-carousel-random").is(":checked");wonderplugin_carousel_config.circular=$("#wonderplugin-carousel-circular").is(":checked");
wonderplugin_carousel_config.responsive=$("#wonderplugin-carousel-responsive").is(":checked");wonderplugin_carousel_config.visibleitems=parseInt($.trim($("#wonderplugin-carousel-visibleitems").val()));if(isNaN(wonderplugin_carousel_config.visibleitems)||wonderplugin_carousel_config.visibleitems<1)wonderplugin_carousel_config.visibleitems=3;wonderplugin_carousel_config.direction=defaultSkinOptions[wonderplugin_carousel_config.skin]["direction"];wonderplugin_carousel_config.skintemplate=$.trim($("#wonderplugin-carousel-skintemplate").val()).replace(/&/g,
"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;");wonderplugin_carousel_config.skincss=$.trim($("#wonderplugin-carousel-skincss").val());wonderplugin_carousel_config.customcss=$.trim($("#wonderplugin-carousel-custom-css").val());wonderplugin_carousel_config.dataoptions=$.trim($("#wonderplugin-carousel-data-options").val())};var previewCarousel=function(){updateCarouselOptions();$("#wonderplugin-carousel-preview-container").empty();var previewCode="<div id='wonderplugin-carousel-preview'";if(wonderplugin_carousel_config.dataoptions&&
wonderplugin_carousel_config.dataoptions.length>0)previewCode+=" "+wonderplugin_carousel_config.dataoptions;previewCode+="></div>";$("#wonderplugin-carousel-preview-container").html(previewCode);if(wonderplugin_carousel_config.slides.length>0){$("head").find("style").each(function(){if($(this).data("creator")=="wonderplugincarouselcreator")$(this).remove()});var carouselid=wonderplugin_carousel_config.id>0?wonderplugin_carousel_config.id:0;if(wonderplugin_carousel_config.customcss&&wonderplugin_carousel_config.customcss.length>
0)$("head").append("<style type='text/css' data-creator='wonderplugincarouselcreator'>"+wonderplugin_carousel_config.customcss+"</style>");if(wonderplugin_carousel_config.skincss&&wonderplugin_carousel_config.skincss.length>0)$("head").append("<style type='text/css' data-creator='wonderplugincarouselcreator'>"+wonderplugin_carousel_config.skincss.replace(/#amazingcarousel-CAROUSELID/g,"#wonderplugin-carousel-preview")+"</style>");var i;var code='<div class="amazingcarousel-list-container" style="overflow:hidden;">';
code+='<ul class="amazingcarousel-list">';for(i=0;i<wonderplugin_carousel_config.slides.length;i++){code+='<li class="amazingcarousel-item">';code+='<div class="amazingcarousel-item-container">';var image_code="";if(wonderplugin_carousel_config.slides[i].lightbox){image_code+='<a href="';if(wonderplugin_carousel_config.slides[i].type==0)image_code+=wonderplugin_carousel_config.slides[i].image;else if(wonderplugin_carousel_config.slides[i].type==1){image_code+=wonderplugin_carousel_config.slides[i].mp4;
if(wonderplugin_carousel_config.slides[i].webm)image_code+='" data-webm="'+wonderplugin_carousel_config.slides[i].webm}else if(wonderplugin_carousel_config.slides[i].type==2||wonderplugin_carousel_config.slides[i].type==3)image_code+=wonderplugin_carousel_config.slides[i].video;if(wonderplugin_carousel_config.slides[i].title&&wonderplugin_carousel_config.slides[i].title.length>0)image_code+='" title="'+wonderplugin_carousel_config.slides[i].title;if(wonderplugin_carousel_config.slides[i].description&&
wonderplugin_carousel_config.slides[i].description.length>0)image_code+='" data-description="'+wonderplugin_carousel_config.slides[i].description;image_code+='" class="wondercarousellightbox" data-group="wondercarousellightbox-'+carouselid+'">'}else if(wonderplugin_carousel_config.slides[i].weblink&&wonderplugin_carousel_config.slides[i].weblink.length>0){image_code+='<a href="'+wonderplugin_carousel_config.slides[i].weblink+'"';if(wonderplugin_carousel_config.slides[i].linktarget&&wonderplugin_carousel_config.slides[i].linktarget.length>
0)image_code+=' target="'+wonderplugin_carousel_config.slides[i].linktarget+'"';image_code+=">"}image_code+='<img src="'+wonderplugin_carousel_config.slides[i].image+'"';image_code+=' alt="'+wonderplugin_carousel_config.slides[i].title+'"';image_code+=' data-description="'+wonderplugin_carousel_config.slides[i].description+'"';if(!wonderplugin_carousel_config.slides[i].lightbox)if(wonderplugin_carousel_config.slides[i].type==1){image_code+=' data-video="'+wonderplugin_carousel_config.slides[i].mp4+
'"';if(wonderplugin_carousel_config.slides[i].webm)image_code+=' data-videowebm="'+wonderplugin_carousel_config.slides[i].webm+'"'}else if(wonderplugin_carousel_config.slides[i].type==2||wonderplugin_carousel_config.slides[i].type==3)image_code+=' data-video="'+wonderplugin_carousel_config.slides[i].video+'"';image_code+=" />";if(wonderplugin_carousel_config.slides[i].lightbox||!wonderplugin_carousel_config.slides[i].lightbox&&wonderplugin_carousel_config.slides[i].weblink&&wonderplugin_carousel_config.slides[i].weblink.length>
0)image_code+="</a>";var title_code="";if(wonderplugin_carousel_config.slides[i].title&&wonderplugin_carousel_config.slides[i].title.length>0)title_code=wonderplugin_carousel_config.slides[i].title;var description_code="";if(wonderplugin_carousel_config.slides[i].description&&wonderplugin_carousel_config.slides[i].description.length>0)description_code=wonderplugin_carousel_config.slides[i].description;code+=wonderplugin_carousel_config.skintemplate.replace(/&amp;/g,"&").replace(/&lt;/g,"<").replace(/&gt;/g,
">").replace(/__IMAGE__/g,image_code).replace(/__TITLE__/g,title_code).replace(/__DESCRIPTION__/g,description_code);code+="</div>";code+="</li>"}code+="</ul>";code+="</div>";code+='<div class="amazingcarousel-prev"></div><div class="amazingcarousel-next"></div> <div class="amazingcarousel-nav"></div>';var jsfolder=$("#wonderplugin-carousel-jsfolder").text();var carouselOptions=$.extend({},WONDERPLUGIN_CAROUSEL_SKIN_OPTIONS[wonderplugin_carousel_config["skin"]],{carouselid:carouselid,jsfolder:jsfolder},
wonderplugin_carousel_config);if(carouselOptions.direction=="vertical")$("#wonderplugin-carousel-preview").css({position:"relative",width:carouselOptions.width+"px"});else if(carouselOptions.responsive)$("#wonderplugin-carousel-preview").css({position:"relative",width:"100%","max-width":carouselOptions.width*carouselOptions.visibleitems+"px"});else $("#wonderplugin-carousel-preview").css({position:"relative",width:carouselOptions.width*carouselOptions.visibleitems+"px"});$("#wonderplugin-carousel-preview").html(code);
$(".wondercarousellightbox").wondercarousellightbox();$("#wonderplugin-carousel-preview").wonderplugincarousel(carouselOptions)}};var publishCarousel=function(){$("#wonderplugin-carousel-publish-loading").show();updateCarouselOptions();jQuery.ajax({url:ajaxurl,type:"POST",data:{action:"wonderplugin_carousel_save_item",item:wonderplugin_carousel_config},success:function(data){$("#wonderplugin-carousel-publish-loading").hide();if(data.success&&data.id>=0){wonderplugin_carousel_config.id=data.id;$("#wonderplugin-carousel-publish-information").html("<div class='updated'><p>The carousel has been saved and published.</p></div>"+
"<div class='updated'><p>To embed the carousel into your page or post, use shortcode <b>[wonderplugin_carousel id=\""+data.id+'"]</b></p></div>'+"<div class='updated'><p>To embed the carousel into your template, use php code <b>&lt;?php echo do_shortcode('[wonderplugin_carousel id=\""+data.id+"\"]'); ?&gt;</b></p></div>")}else $("#wonderplugin-carousel-publish-information").html("<div class='error'><p>The carousel can not be saved, please try again later.</p></div>")}})};var default_options={id:-1,
name:"My Carousel",slides:[],skin:"classic",customcss:"",dataoptions:""};var wonderplugin_carousel_config=$.extend({},default_options,defaultSkinOptions[default_options["skin"]]);var carouselId=parseInt($("#wonderplugin-carousel-id").text());if(carouselId>=0){$.extend(wonderplugin_carousel_config,$.parseJSON($("#wonderplugin-carousel-id-config").text()));wonderplugin_carousel_config.id=carouselId}var boolOptions=["autoplay","random","circular","responsive"];for(var i=0;i<boolOptions.length;i++)if(wonderplugin_carousel_config[boolOptions[i]]!==
true&&wonderplugin_carousel_config[boolOptions[i]]!==false)wonderplugin_carousel_config[boolOptions[i]]=wonderplugin_carousel_config[boolOptions[i]]&&wonderplugin_carousel_config[boolOptions[i]].toLowerCase()==="true";if(wonderplugin_carousel_config.dataoptions&&wonderplugin_carousel_config.dataoptions.length>0)wonderplugin_carousel_config.dataoptions=wonderplugin_carousel_config.dataoptions.replace(/\\"/g,'"').replace(/\\'/g,"'");var printConfig=function(){$("#wonderplugin-carousel-name").val(wonderplugin_carousel_config.name);
updateMediaTable();$(".wonderplugin-tab-skin").find("img").removeClass("selected");$("input:radio[name=wonderplugin-carousel-skin][value="+wonderplugin_carousel_config.skin+"]").attr("checked",true);$("input:radio[name=wonderplugin-carousel-skin][value="+wonderplugin_carousel_config.skin+"]").parent().find("img").addClass("selected");printSkinOptions(wonderplugin_carousel_config);$("#wonderplugin-carousel-custom-css").val(wonderplugin_carousel_config.customcss);$("#wonderplugin-carousel-data-options").val(wonderplugin_carousel_config.dataoptions)};
printConfig()})})(jQuery);