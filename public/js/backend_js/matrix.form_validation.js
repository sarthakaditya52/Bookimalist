
$(document).ready(function(){
	$("#new_pwd").click(function()
	{
		var current_pwd=$("#current_pwd").val();
		$.ajax({
			type: 'get',
			url: '/admin/check-pwd',
			data:{current_pwd:current_pwd},
			success:function(resp)
			{
				//alert(resp);
				if (resp=="false") {
					$("#check_pwd").html("<font color='red'>Current Password is Incorrect</font>");
				}
				else if (resp=="true") {
					$("#check_pwd").html("<font color='green'>Current Password is Correct</font>");
				}
			},error:function(){
				alert("Error");
			}
		});
	});

	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();
	
	$('select').select2();
	
	// Form Validation
    $("#basic_validate").validate({
		rules:{
			required:{
				required:true
			},
			email:{
				required:true,
				email: true
			},
			date:{
				required:true,
				date: true
			},
			url:{
				required:true,
				url: true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});


    // Add Book Validation
    $("#add_book").validate({
        rules:{
            book_title:{
                required:true
            },
            book_isbn:{
                required:true,
            },
            book_image:{
                required:true,
            },
            book_price:{
                required:true,
                number:true
            },
            book_author:{
                required:true,
            },
            book_publisher:{
                required:true,
            },

        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });


    // Edit Category Validation
    $("#edit_book").validate({
        rules:{
            book_title:{
                required:true
            },
            book_isbn:{
                required:true,
            },
            book_price:{
                required:true,
                number:true
            },
            book_author:{
                required:true,
            },
            book_publisher:{
                required:true,
            },

        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });




    // Add Book Validation
    $("#add_category").validate({
        rules:{
            category_name:{
                required:true
            },
            url:{
                required:true,
            },
            main_category:{
                required:true,
            }
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });
	



	$("#number_validate").validate({
		rules:{
			min:{
				required: true,
				min:10
			},
			max:{
				required:true,
				max:24
			},
			number:{
				required:true,
				number:true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
	
	$("#password_validate").validate({
		rules:{
			current_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			new_pwd:{

				required: true,
				minlength:6,
				maxlength:20
			},
			confirm_pwd:{
				required:true,
				minlength:6,
				maxlength:20,
				equalTo:"#new_pwd"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});




	$(".deleteRecord").click(function () {
		var id=$(this).attr('rel');
		var deleteFunction=$(this).attr('rel1');
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        },
			function () {
                window.location.href = "/admin/" + deleteFunction + "/" + id;
            });
    });



    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '       <div class="control-group"><label class="control-label"></label><div class="field_wrapper"><div><input type="text" name="sku[]" id="sku" placeholder="SKU" style="width: 120px"/> <input type="text" name="edition[]" id="edition" placeholder="Edition" style="width: 120px"/> <input type="text" name="condition[]" id="condition" placeholder="Condition" style="width: 120px"/> <input type="text" name="price[]" id="price" placeholder="Price" style="width: 120px"/> <input type="text" name="stock[]" id="stock" placeholder="Stock" style="width: 120px"/><a href="javascript:void(0);" class="remove_button">Remove</a></div></div></div>'; //New input field html
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });


});
