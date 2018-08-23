$(document).ready(function() {
    /* Global variables */
    var selectedId;
    var processing = false;

    /* Global Ajax settings */
    $.ajaxSetup({
        beforeSend:() =>{
            $(".submit-btn").prop("disabled", true);
            $(".close-modal-btn").prop("disabled", true);
        },
        error:(error)=>{
            console.log("There was an error:",error);
        },
        complete:() =>{
            $(".submit-btn").prop("disabled", false);
            $(".close-modal-btn").prop("disabled", false);
        }
    });


    /**
    $(".content-wrapper").css({'min-height':"569px"});
    
    window.addEventListener('resize',function(event){
        console.log("window has changed:",event);
        $(".content-wrapper").css({'min-height':'569px'})
    });
    */


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
    

    /***************************************************************************************
    *                                                                                      *
    *               Settings > Academic Settings > Global functions                        *
    *                                                                                      *
    ****************************************************************************************/
    /* Open the modal for adding a specific academics settings component:
    *   - college
    *   - department
    *   - programe
    *   - courseunit
    *   - lecturer
    */
    function openAddModal(btnClass,modalId){
        $("."+btnClass+"").on('click',function(event){
            event.preventDefault();
            $("#"+modalId+"").modal();
        });
    }

    /* Called when the add modal is being closed */
    function onCloseModal(closeBtnId){
        $("#"+closeBtnId+"").on('click',function(event){
            location.reload();
        });
    }
    
    /* Save data for a new academics settings component*/
    function saveNewData(formId,handler){
        $("#"+formId+"").on('submit',function(event){
            event.preventDefault();
            var data = $(this).serialize();
            $.ajax({
                type:'POST',
                data:data,
                url: "../config/route.php?token="+window.btoa(handler),
                success:(data) =>{
                    if(data){
                        $(".modal-alert-wrapper").html(data);
                    }
                }
            });
        });
        
    }

    /* On Editing an academics settings component item */
    function editItem(caller,dataSourceHandler,modalId){
        $("."+caller+"").on('click',function(event){
            event.preventDefault();
            var id = $(this).attr('data-id');
            selectedId = id;
            $.ajax({
                type:'GET',
                url: "../config/route.php?token="+window.btoa(dataSourceHandler)+"&id="+selectedId,
                success:(data) =>{
                    var obj = JSON.parse(data);
                    
                    /* Determine the fields to populate */
                    if(caller === "editCollege"){
                        $("#fullname").attr('value',obj['fullname']);
                        $("#shortname").attr('value',obj['shortname']);
                    }else if(caller === "editProgram"){
                        $("#pname").attr('value',obj['name']);
                        $("#category").attr('value',obj['category']);
                        $("#duration").attr('value',obj['duration']);
                        $("#gradLoad").attr('value',obj['gradLoad']);
                        $("#code").attr('value',obj['code']);
                    }
                }
            });
            /* Open modal */
            $("#"+modalId+"").modal();    
        });
    }


    /* On saving an academic settings component item changes */
    function saveItemEdits(formId,handler){
        $("#"+formId+"").on('submit',function(event){
            event.preventDefault();
            var data = $(this).serialize();
            $.ajax({
                type:'POST',
                data:data,
                url: "../config/route.php?token="+window.btoa(handler)+"&id="+selectedId,
                success:(data) =>{
                    $(".modal-alert-wrapper").html(data);
                    selectedId = null;
                }
            });        
        });
    }
    
    /* Show confirm delete modal for an academics settings component */
    function openConfrimDeleteModal(btnClass,modalId){
        $("."+btnClass+"").on('click',function(event){
            event.preventDefault();
            var id = $(this).attr('data-id');
            selectedId = id;
            $("#"+modalId+"").modal();
        });
    }

    /* On Deleting an academics settings component item */
    function deleteItem(btnClass,handler){
        $("."+btnClass+"").on('click',function(event){
            event.preventDefault();
            $.ajax({
                type:'GET',
                url: "../config/route.php?token="+window.btoa(handler)+"&id="+selectedId,
                success:(data) =>{
                    $(".modal-alert-wrapper").html(data);
                    location.reload();
                    selectedId = null;
                }
            });
        });        
    }


    /*
    *
    *   Academics settings: Colleges 
    */
    openAddModal("addCollege","addCollege");
    onCloseModal("closeNewCollege");
    saveNewData("newCollegeForm","insertCollege");
    editItem("editCollege","college_data","editCollege");
    onCloseModal("closeEditCollegeModal");
    saveItemEdits("saveCollegeEditsForm","updateCollege");
    openConfrimDeleteModal("confirmCollegeDelete","confirmCollegeDelete");
    deleteItem("deleteCollegeBtn","deleteCollege");
    onCloseModal("closeDeleteCollegeModal");
  


    /*
    *
    *   Academic settings: Department 
    */




    /*
    *
    *   Academic settings: Programme 
    */
    /* Add Programme Modal button listener */
    openAddModal("addProgram","addProgram");
    onCloseModal("closeNewProg");
    saveNewData("newProgForm","insertProgramme");
    editItem("editProgram","program_data","editProgram");
    onCloseModal("closeEditProgramModal");
    saveItemEdits("saveProgEditsForm","updateProgramme");
    openConfrimDeleteModal("confirmProgramDelete","confirmProgramDelete");
    deleteItem("deleteProgramBtn","deleteProgramme");
    onCloseModal("closeDeleteProgramModal");

        

    /*
    *
    *   Academic settings: View Course 
    */



    /*
    *
    *   Academic settings: Lecturers 
    */



});

