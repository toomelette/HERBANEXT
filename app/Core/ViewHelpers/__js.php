<?php

namespace App\Core\ViewHelpers;


class __js{



    public static function show_password($textbox_id, $checkbox_id){

       return '$(document).ready(function(){
					$("#'. $checkbox_id .'").on("change",function(){
						var is_checked = $(this).prop("checked");
						if (is_checked) {
							$("#'. $textbox_id .'").attr("type","text");
						} else {
							$("#'. $textbox_id .'").attr("type","Password");
						}
					});
				});';

    }




    public static function toast($message){

       return '$.toast({
	            text: "'. $message .'",
	            showHideTransition: "slide",
	            allowToastClose: true,
	            hideAfter: 3000,
	            loader: false,
	            position: "top-right",
	            bgColor: "#444",
	            textColor: "white",
	            textAlign: "left",
	          });';

    }
    



    public static function form_submitter_via_action($data_action, $form){

       return '$(document).on("change", "#action", function () {
       				var element = $(this).children("option:selected");
       				if(element.data("action") == "'. $data_action .'"){
		            	$("#'. $form .'").attr("action", element.data("url"));
		            	$("#'. $form .'").submit();
		        	}
		        });';

    }




    public static function select_modal_confirm_delete_caller($modal){

       return '$(document).on("change", "#action", function () {
			      var element = $(this).children("option:selected");
			      if(element.data("action") == "delete"){
			        $("#'. $modal .'").modal("show");
			        $("#delete_body #form").attr("action", element.data("url"));
			        $(this).val("");
			      }
			    });';

    }




    public static function button_modal_confirm_delete_caller($modal){

       return '$(document).on("click", "#delete_button", function () {
			      if($(this).data("action") == "delete"){
			        $("#'. $modal .'").modal("show");
			        $("#delete_body #form").attr("action", $(this).data("url"));
			      }
			    });';

    }




    public static function ajax_select_to_select($id_from, $id_to, $route, $key, $value){

      $string = "'";

      return '$(document).ready(function() {
		        $("#'. $id_from .'").on("change", function() {
		            var key = $(this).val();
		            if(key) {
		                $.ajax({
		                	headers: {"X-CSRF-TOKEN": $('. $string .'meta[name="csrf-token"]'. $string .').attr("content")},
		                    url: "'. $route .'"+key,
		                    type: "GET",
		                    dataType: "json",
		                    success:function(data) {       
		                      
		                        $("#'. $id_to .'").empty();

	                        	$.each(data, function(key, value) {
                        			$("#'. $id_to .'").append("<option value='. $string .'"+ value.'. $key .' +"'. $string .'>"+ value.'.$value.' +"</option>");
                        		});

	                        	$("#'. $id_to .'").append("<option value>Select</option>");  
		            
		                    }
		                });
		            }else{
		            	$("#'. $id_to .'").empty();
		            }
		        });
			    });';

    }




    public static function ajax_select_to_input($id_from, $id_to, $route, $value){

      $string = "'";

      return '$(document).ready(function() {
	                $("#'.$id_from.'").on("change", function() {
	                    var id = $(this).val();
	                    if(id) {
	                        $.ajax({
	                        	headers: {"X-CSRF-TOKEN": $('. $string .'meta[name="csrf-token"]'. $string .').attr("content")},
	                            url: "'.$route.'"+id,
	                            type: "GET",
	                            dataType: "json",
	                            success:function(data) {
	                                $("#'.$id_to.'").empty();
	                                $.each(data, function(key, value) {
	                                		$("#'.$id_to.'").val(value.'.$value.');
	                                }); 
	                            }
	                        });
	                    }else{
	                        $("#'.$id_to.'").val("");
	                    }
	                });
	            });';

    }







    public static function pdf_upload($id, $theme, $url){

      return '$("#'. $id .'").fileinput({
		        theme: "'. $theme .'",
		        allowedFileExtensions: ["pdf"],
    			maxFileCount: 1,
		        showUpload: false,
		        showCaption: false,
		        overwriteInitial: true,
		        fileType: "pdf",
		        browseClass: "btn btn-primary btn-md",
		        initialPreview: [
		            "'. $url .'",
		        ],
		        initialPreviewAsData: true,
		        initialPreviewConfig: [
		            {type: "pdf", size: "100%", width: "100%", key: 1},
		        ],
		      }); 
			  $(".kv-file-remove").hide();
	  ';

    }







    public static function img_upload($id, $theme, $type, $value){

      if ($type == 'URL') {
      	$initialPreviewAsData = 'true';
      	$value = $value;
      }elseif ('BLOB') {
      	$initialPreviewAsData = 'false';
      	$value =  "<img style='width:auto; height:160px;' src='data:image/png;base64,". $value ."'>";
      }

      return '$("#'. $id .'").fileinput({
		        theme: "'. $theme .'",
		        allowedFileExtensions: ["jpg", "jpeg", "png"],
    			maxFileCount: 1,
		        showUpload: false,
		        showCaption: false,
		        overwriteInitial: true,
		        fileType: "jpg",
		        browseClass: "btn btn-primary btn-md",
		        initialPreview: [
		            "'. $value .'",
		        ],
		        initialPreviewAsData: '. $initialPreviewAsData .',
		        initialPreviewFileType: "image",
		        initialPreviewConfig: [
		            {caption: "avatar.jpg", width: "100%", key: 1},
		        ],
		      }); 
			  $(".kv-file-remove").hide();
	  ';

    }







}