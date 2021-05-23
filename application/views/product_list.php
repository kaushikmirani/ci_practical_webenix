<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Product List</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/style.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('js/data-tables/DT_bootstrap.css'); ?>">
    </head>
    <div class="text-right">
    	<a href="<?php echo base_url();?>" >  <button type="button" class="btn-primary">Product Category List</button></a>
    </div>
<body>
	<div class="container">
		<h1 class="text-center"><span>Product List</span></h1>

		<?php
		$success_msg= $this->session->flashdata('success_msg');
		$error_msg= $this->session->flashdata('error_msg');

		if($success_msg){
		?>
		<div class="alert alert-success">
			<?php echo $success_msg; ?>
		</div>
		<?php
			}
			if($error_msg){
			?>
			<div class="alert alert-danger">
				<?php echo $error_msg; ?>
			</div>
			<?php
			}
		?>

		<div class="text-right">
			<a href="<?php echo base_url('product/product_form'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add</a>
		</div>

		<table id="dt_product_list" class="table table-striped table-bordered table-hover"></table>


	 </div>
	<script type="text/javascript" src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('js/data-tables/jquery.dataTables.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('js/data-tables/DT_bootstrap.js'); ?>"></script>

	<script type="text/javascript">
		$(function () {
			OTable = $('#dt_product_list').dataTable({
				bProcessing: true,
				bServerSide: true,
				sAjaxSource: "product_list",
				fnServerData: function (sSource, aoData, fnCallback) {
					$.ajax({
						dataType: 'json',
						type: "POST",
						url: sSource,
						data: aoData,
						success: fnCallback
					});
				},
				fnServerParams: function (aoData) {
                    //setTitle(aoData, this)
                },
				aaSorting : [],
				aoColumns: [
					{ sName: "p.id", sTitle : 'Id', bVisible: false},
					{ sName: "p.name", sTitle : "Product Name"},
					{ sName: "p.image", sTitle : "Image", bSortable: false, bSearchable: false},
					{ sName: "p.description", sTitle : "Description"},
					{ sName: "p.price", sTitle : "Price"},
					{ sName: "pc.name", sTitle : "Category Name"},
					{ sName: "p.added_on", sTitle : "Added On"},
					{ sName: "operation", sTitle: 'Operation', bSortable: false, bSearchable: false}
				]
			});
			$('.dataTables_filter').css({float: 'right'});
			$('.dataTables_filter input').addClass("form-control input-inline");
		});
	</script>
</body>
</html>
