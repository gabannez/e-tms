	<br />
	<button class="btn btn-success" onClick="add_level()"><i class="glyphicon glyphicon-plus"></i> Add Level</button>
	<button class="btn btn-default" onClick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
	<br /><br />
	<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Description</th>
				<th style="width:140px;">Action</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
		
		<tfoot>
		</tfoot>
	</table>
</div>
	
<script type="text/javascript">

var save_method;
var table;

$(document).ready(function() {
	
	table = $('#table').DataTable({
		
		"processing": true,
		"serverSide": true,
		"order": [],
		
		"ajax": {
			"url": "<?php echo site_url('level/ajax_list')?>",
			"type": "POST"
		},
		
		"columnDefs": [
		{
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});
});

function add_level() 
{
	save_method = 'add';
	$('#form')[0].reset();
	$('.form-group').removeClass('has-error');
	$('.help-block').empty();
	$('#modal_form').modal('show');
	$('.modal-title').text('Add Level');
}

function edit_level(id)
{
	save_method = 'update';
	$('#form')[0].reset();
	$('.form-group').removeClass('has-error');
	$('.help-block').empty();
	
	$.ajax({
		url: "<?php echo site_url('level/ajax_edit/')?>/" + id,
		type: "GET",
		dataType: "JSON",
		success: function(data)
		{
			$('[name="id"]').val(data.id);
			$('[name="description"]').val(data.description);
			$('#modal_form').modal('show');
			$('.modal-title').text('Edit Level');
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			alert('Error get data from ajax');
		}
	});
}

function reload_table()
{
	table.ajax.reload(null,false);
}

function save()
{
	var url;
	
	if(save_method == 'add') {
		url = "<?php echo site_url('level/ajax_add')?>";
	} else {
		url = "<?php echo site_url('level/ajax_update')?>";
	}
	
	$.ajax({
		url: url,
		type: "POST",
		data: $('#form').serialize(),
		dataType: "JSON",
		success: function(data)
		{
			$('#modal_form').modal('hide');
			reload_table();
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			alert('Error adding / update data');
		}
	});
}

function delete_level(id)
{
	if(confirm('Are you sure to delete this data?'))
	{
		$.ajax({
			url: "<?php echo site_url('level/ajax_delete')?>/"+id,
			type: "POST",
			dataType: "JSON",
			success: function(data)
			{
				$('#modal_form').modal('hide');
				reload_table();
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				alert('Error deleting data');
			}
		});
	}
}

</script>

<!-- Bootstrap Modal -->
<div class="modal fade" id="modal_form" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">Level Form</h3>
			</div>
			<div class="modal-body form">
				<form action="#" id="form" class="form-horizontal">
					<input type="hidden" value="" name="id" />
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-3">Description</label>
							<div class="col-md-9">
								<input name="description" placeholder="Description" class="form-control" type="text">
								<span class="help-block"></span>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" id="btnSave" onClick="save()" class="btn btn-primary">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
</body>
</html>