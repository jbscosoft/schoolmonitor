$(document).ready(function() {
    $('.updatedetails').change(function() {
        if(this.checked){
            $('.fname').attr('disabled',true);
            $('.sname').attr('disabled',true);
            $('.dob').attr('disabled',true);
            $('.gender').attr('disabled',true);
            $('.designation').attr('disabled',true);
            $('.email').attr('disabled',true);
            $('.phone1').attr('disabled',true);
            $('.phone2').attr('disabled',true);
            $('.changeCredentials').attr('disabled',true);
		}else{
            $('.fname').attr('disabled',false);
            $('.sname').attr('disabled',false);
            $('.dob').attr('disabled',false);
            $('.gender').attr('disabled',false);
            $('.designation').attr('disabled',false);
            $('.email').attr('disabled',false);
            $('.phone1').attr('disabled',false);
            $('.phone2').attr('disabled',false);
            $('.changeCredentials').attr('disabled',false);
		}
        
	});
    
});