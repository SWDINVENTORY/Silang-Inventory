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

function populate(model, callback){
	Object.keys(model.data).forEach(function(v,i,a) {
		var value = model.map(v, model.data);
		$('#'+model.name+'-modal-form').find('input[name="'+v+'"]').val(value);
		$('#'+model.name+'-modal-form').find('select[name="'+v+'"]').val(value);
		$('#'+model.name+'-modal-form').find('textarea[name="'+v+'"]').val(value);
		$('#'+model.name+'-modal-form'+' #'+v).val(value);
		
		if(!$('#'+model.name+'-modal-form'+' #'+v).is('input')) {			
			$('#'+model.name+'-modal-form'+' #'+v).text(value);
		}
	});
	if(typeof callback != 'undefined' && typeof(callback) == 'function') {
		callback();
	}
}

function clear_form(model, callback) {
	$('#'+model+'-modal-form')[0].reset();
	$('#'+model+'-modal-form').find('input[name]')
		.removeAttr('disabled');
	$('#'+model+'-modal-form').find('select')
		.removeAttr('disabled');
	$('#'+model+'-modal-form').find('textarea')
		.removeAttr('disabled');
	if(typeof callback != 'undefined' && typeof(callback) == 'function') {
		callback();
	}
}
