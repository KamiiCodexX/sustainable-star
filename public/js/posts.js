
    let myDropZone = Dropzone.options.myAwesomeDropzone = {
    url: '/post-uploads',
    previewsContainer: ".dropzone",
    uploadMultiple: true,
    parallelUploads: 100,
    maxFiles: 100,
    dictDefaultMessage: '<strong>Click or Drop Images</strong><br/> <span class="note needsclick">To set the profile image click the radio button</span><br/><span class="note needsclick"><strong>Only PNG, JPG and JPEG with max 5MB of size are allowed</strong></span>',
    }

$(document).on("click", ".uploadFileToPost", function (e) {
    e.preventDefault();
    if ($(".dropZoneView").hasClass("d-none"))
    {
        $(".dropZoneView").removeClass("d-none");
        $(".dropZoneView").addClass("d-display");
    }
    else {
        $(".dropZoneView").removeClass("d-display");
        $(".dropZoneView").addClass("d-none");
    }
});


$(document).on("click", ".post-remove", function () {
    let postID = $(this).attr('data-id');
    $(`#post-number-${postID}`).fadeOut(1000);
});


$(document).on('submit', '#create-post', function (e) {
    e.preventDefault();
    $("#create-post").parsley().validate();
    if ($("#create-post").parsley().isValid())
    {
        let formData = $("#create-post").serialize();
        // console.log(formData);
        $.ajax({
            url: "http://localhost/sustainable-star/public/posts/store",
            global: false,
            method: "POST",
            dataType: 'json',
            data: formData,
            success: function (result) {
                if (result.success) {
                    Swal.fire('Success!', result.message, 'success').then(function () {
                        $("#create-post").trigger("reset");
                        $(result.html).hide().prependTo("#post-view").fadeIn("slow");
                    });
                }else{
                    Swal.fire("Error!", result.message, 'error');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                return false;
            }
        });
    }
    else
    {
        Swal.fire('Invalid Form', 'Please fix validation errors!', 'error');

    }

});

$(document).on("click", ".remove-permission", function () {
    let delegateID = $(this).attr('data-id');
    $(this).parent().parent().parent().fadeOut(1000);
});

$(document).on('click', '.remove-permission', function(){
    let delegateID = $(this).attr('data-id');

    Swal.fire({
        title: "Are you sure? You want to delete this Delegate?",
        icon: "question",
      text: "Note: This Delegate will be deleted permanently.",
      type: "info",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: false,
    }).then(function (result) {
      if (result.value) {
          $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "http://localhost/sustainable-star/public/companies/deleteDelegates",
            type: 'POST',
            data: {
                id: delegateID
            },
            success: function (result){
                if(result.success){

                    Swal.fire("Success!", result.message, "success").then(() => {
                        $(this).parent().parent().parent().fadeOut(1000);
                    });
                }else{
                    Swal.fire("Error!!", result.message, "error");
                }
            },
            error: function () {
                Swal.fire("Something went Wrong.");
            }
        });
        }
    });

});

$(document).on('submit', 'form[id^="manage-permissions-"]', function (e) {
    e.preventDefault();
    let formData = $(this).serialize();
    console.log(formData);
    $.ajax({
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "http://localhost/sustainable-star/public/companies/storePermissions",
        global: false,
        method: "POST",
        dataType: 'json',
        data: formData,
        success: function (result) {
            if (result.success) {
                Swal.fire('Success!', result.message, 'success');
            }else{
                Swal.fire("Error!", result.message, 'error');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            return false;
        }
    });
});

$(document).on('submit', 'form[id^="allow-permission-"]', function (e) {
    e.preventDefault();
    let formData = $(this).serialize();
    console.log(formData);
    $.ajax({
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "http://localhost/sustainable-star/public/companies/storeDelegates",
        global: false,
        method: "POST",
        dataType: 'json',
        data: formData,
        success: function (result) {
            if (result.success) {
                Swal.fire('Success!', result.message, 'success').then(() => {
                    location.reload();
                });
            }else{
                Swal.fire("Error!", result.message, 'error');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            return false;
        }
    });
});
