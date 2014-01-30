function changeModal(action) {
	$('#'+action.model+'-modal-form').attr('action', action.action);
	var modal_action = $('#'+action.model+'-modal-form')
		.parents('div.modal-content')
		.find('span.modal-form-action');
	modal_action.html(action.pr_button);
	modal_action.parents('button').attr('name', action.submit_name);
	$('#'+action.model+'-modal-form')
		.parents('div.modal-content')
		.find('#my-modal-label').html(action.modal_label);
	action.run();
}

function populate(model){
	Object.keys(model.data).forEach(function(v,i,a) {
		var value = model.map(v, model.data);
		$('#'+model.name+'-modal-form').find('input[name="'+v+'"]').val(value);
		$('#'+v).val(value);
	});	
}

function clear_form(model, callback) {
	$('#'+model+'-modal-form').find('input').val('');
	callback();
}
