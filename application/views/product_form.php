<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Product Form</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/style.css'); ?>">
    </head>
    <div class="text-right">
    	<a href="<?php echo base_url('product/product_list_view');?>" >  <button type="button" class="btn-primary">Product List</button></a>
    </div>
<body>
	<div class="container">
		<h1 class="text-center"><span>Product Form</span></h1>
	 	<?php
			$success_msg= $this->session->flashdata('success_msg');
			$error_msg= $this->session->flashdata('error_msg');

			if($success_msg){ ?>
				<div class="alert alert-success">
					<?php echo $success_msg; ?>
				</div>
			<?php } if($error_msg){ ?>
				<div class="alert alert-danger">
					<?php echo $error_msg; ?>
				</div>
			<?php } ?>
	 <form method="POST" enctype="multipart/form-data" class="form-horizontal" id="product_form" action="<?php echo base_url('product/submit_product_form'); ?>">
	 	<input type="hidden" name="product_id" id="product_id" value="<?php echo $id; ?>">
	 	<div class="col-sm-6 col-sm-offset-3">

	 		<div class="form-group">
	 			<label class="control-label col-sm-3">Product Name:</label>
	 			<div class="col-sm-9">
	 				<input type="text" class="form-control required" placeholder="Enter Product Name" name="name" value="<?php echo $name;?>">
	 			</div>
	 		</div>

	 		<div class="form-group">
	 			<label class="control-label col-sm-3">Product Image:</label>
	 			<div class="col-sm-9">
	 				<input type="file" accept="image/*" class="form-control required" name="image" id="image" value="<?php echo $image;?>">
	 				<img id="image_preview" src="<?php echo base_url('upload/').$image ?>" alt="<?php echo $image;?>" width="150px" id="150px" />
	 			</div>
	 		</div>

	 		<div class="form-group">
	 			<label class="control-label col-sm-3">Product Description:</label>
	 			<div class="col-sm-9">
	 				<textarea name="description" rows="4" class="form-control required"><?php echo $description ?></textarea>
	 			</div>
	 		</div>

	 		<div class="form-group">
	 			<label class="control-label col-sm-3">Product Price:</label>
	 			<div class="col-sm-9">
	 				<input type="number" class="form-control required" placeholder="Enter Product price" name="price" value="<?php echo $price;?>">
	 			</div>
	 		</div>

	 		<div class="form-group">
		      <label class="control-label col-sm-3">Product category:</label>
		      <div class="col-sm-9">
		        <select class="form-control required" name="category_id">
		        	<option value="">-- Select --</option>
		        	<?php if(count($category_dd)>0){
						foreach($category_dd as $key => $val){
							if($category_id==$val['id']){ ?>
								<option value="<?php echo $val['id'];?>" selected><?php echo $val['name'];?></option>
							<?php } else{ ?>
								<option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
							<?php } ?>
						<?php } ?>
					 <?php } ?>
		        </select>
		      </div>
		    </div>

		    <div class="text-center">
		    	<input class="btn btn-lg btn-success btn-block submit_product_form" type="submit" value="Submit" name="Submit" >
		    </div>

	 	</div>
	 </form>
	 </div>


	<script type="text/javascript" src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('js/jquery.validate.min.js'); ?>"></script>
	 <script type="text/javascript">

	 	function readFile(file, callback) {
	 		var reader = new FileReader();
	 		reader.onload = callback
	 		reader.readAsDataURL(file);
	 	}

	 	$(document).ready(function() {
	 		$(document).on("change", "#image", function (e) {
	 			var file = this.files[0];
	 			readFile(file, function (e) {
	 				var image = new Image();
	 				image.src = e.target.result;
	 				image.onload = function () {
	 					$('#image_preview').attr('src', this.src);
	 				};
	 			});
	 		});

	 		$("#product_form").validate({
	 			ignore: '.ignore',
	 			rules: {
	 				name: {
	 					required: true
	 				},
	 				description: {
	 					required: true,
	 					minlength: 20
	 				},
	 				price: {
	 					required: true
	 				},
	 				category_id: {
	 					required: true
	 				},
	 				image: {
	 					required: function () {
	 						if ($('#product_id').val() > 0) {
	 							return false;
	 						} else {
	 							return true;
	 						}
	 					}
	 				}
	 			},
	 			messages: {
	 				name: {
	 					required: "Please enter product name"
	 				},
	 				description: {
	 					required: "Please enter your product description",
	 					minlength: "Product Description must be of at least 20 characters"
	 				},
	 				price: {
	 					required: "Please enter your product price"
	 				},
	 				category_id: {
	 					required: "Please select product category"
	 				},
	 				image: {
	 					required: "Please select product image."
	 				}
	 			},
	 			errorPlacement: function (error, element) {
                	$(element).closest(".form-group div").append(error);
                }
    		});

	 		$(document).on("click", ".submit_product_form", function (e) {
	 			var action = $(this).data("action");
	 			if ($("#product_form").valid()) {
	 				$("#product_form").ajaxForm({
	 					beforeSend: function () {
	 						$(".submit_product_form").prop("disabled", true);
	 					},
	 					success: function (html, statusText, xhr, $form) {
	 						obj = $.parseJSON(html);
	 						if (obj.status) {
	 							$("#product_form")[0].reset();
	 							setTimeout(function () {
	 								window.location.href = "'<?php echo base_url('product/product_list_view') ?>'";
	 							}, 1000);
	 						} else {
	 							if(obj.redirect_url){
	 								setTimeout(function () {
	 									window.location.href = "'<?php echo base_url('product/product_list_view') ?>'";
	 								}, 1000);
	 							}
	 						}
	 					},
	 					complete: function (xhr) {
	 						$(".submit_product_form").prop("disabled", false);
	 						return false;
	 					}
	 				}).submit();
	 			}
	 		});
	 	});
	 </script>
</body>
</html>
