<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Product Category Form</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/style.css'); ?>">
    </head>
    <div class="text-right">
    	<a href="<?php echo base_url('');?>" >  <button type="button" class="btn-primary">Product Category List</button></a>
    </div>
<body>
	<div class="container">
		<h1 class="text-center"><span>Product Category Form</span></h1>
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
	 <form method="POST" enctype="multipart/form-data" class="form-horizontal" id="product_category_form" action="<?php echo base_url('product/submit_product_category_form'); ?>">
	 	<input type="hidden" name="product_category_id" id="product_category_id" value="<?php echo $id; ?>">
	 	<div class="col-sm-6 col-sm-offset-3">

	 		<div class="form-group">
	 			<label class="control-label col-sm-3">Category Name:</label>
	 			<div class="col-sm-9">
	 				<input type="text" class="form-control required" placeholder="Enter Product Category Name" name="name" value="<?php echo $name;?>">
	 			</div>
	 		</div>

	 		<div class="form-group">
	 			<label class="control-label col-sm-3">Category Description:</label>
	 			<div class="col-sm-9">
	 				<textarea name="description" rows="4" class="form-control required"><?php echo $description ?></textarea>
	 			</div>
	 		</div>

		    <div class="text-center">
		    	<input class="btn btn-lg btn-success btn-block submit_product_category_form" type="submit" value="Submit" name="Submit" >
		    </div>

	 	</div>
	 </form>
	 </div>


	<script type="text/javascript" src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('js/jquery.validate.min.js'); ?>"></script>
	 <script type="text/javascript">


	 	$(document).ready(function() {

	 		$("#product_category_form").validate({
	 			ignore: '.ignore',
	 			rules: {
	 				name: {
	 					required: true
	 				},
	 				description: {
	 					required: true,
	 					minlength: 20
	 				}
	 			},
	 			messages: {
	 				name: {
	 					required: "Please enter category name"
	 				},
	 				description: {
	 					required: "Please enter your category description",
	 					minlength: "Category Description must be of at least 20 characters"
	 				}
	 			},
	 			errorPlacement: function (error, element) {
                	$(element).closest(".form-group div").append(error);
                }
    		});

	 		$(document).on("click", ".submit_product_category_form", function (e) {
	 			var action = $(this).data("action");
	 			if ($("#product_category_form").valid()) {
	 				$("#product_category_form").ajaxForm({
	 					beforeSend: function () {
	 						$(".submit_product_category_form").prop("disabled", true);
	 					},
	 					success: function (html, statusText, xhr, $form) {
	 						obj = $.parseJSON(html);
	 						if (obj.status) {
	 							$("#product_category_form")[0].reset();
	 							setTimeout(function () {
	 								window.location.href = "'<?php echo base_url() ?>'";
	 							}, 1000);
	 						} else {
	 							if(obj.redirect_url){
	 								setTimeout(function () {
	 									window.location.href = "'<?php echo base_url() ?>'";
	 								}, 1000);
	 							}
	 						}
	 					},
	 					complete: function (xhr) {
	 						$(".submit_product_category_form").prop("disabled", false);
	 						return false;
	 					}
	 				}).submit();
	 			}
	 		});
	 	});
	 </script>
</body>
</html>
