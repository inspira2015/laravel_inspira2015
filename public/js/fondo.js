function clicked($this){
	if($this.value == 1)
	{
		$('#amount').prop('disabled', false);	
	}
	else
	{
		$('#amount').val('');	
		$('#amount').prop('disabled', true);
	}
}