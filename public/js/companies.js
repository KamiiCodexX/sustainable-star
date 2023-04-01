$(document).ready( function () {
    // $('#myTable').DataTable();
    getCompanies();
    $('.js-example-basic-single').select2({
        placeholder: 'Select an option',
    });

    $('.js-example-basic-multiple').select2({
        placeholder: 'Select an option',
    });
});

function getCompanies()
{
    $.ajax({
        url: "http://localhost/sustainablestar/public/companies/get-companies",
        type: 'GET',
        success: function (result) {

            id = 1;
            result.data.forEach((e) => {
                e["actions"] = `<a data-id="${e['id']}" href="javascript:void(0)" class="delete-companies"><i class="fa fa-trash fs-4 text-danger" ></i></a>`;
                e["index"] = id;
                id++;
            });



            $('#myTable').DataTable( {
                data: result.data,
                columns: [
                    { data: 'index' },
                    { data: 'name' },
                    { data: 'owner.name' },
                    { data: 'actions'},
                ],
            });
        },
        error: function () {
            Swal.fire("Error!", "Something went wrong", 'error');

        }
    });
}

$(document).on('submit', '#add-company-form', function (e) {
    e.preventDefault();
    $("#add-company-form").parsley().validate();
    if ($("#add-company-form").parsley().isValid())
    {
        let formData = $("#add-company-form").serialize();
        // console.log(formData);
        $.ajax({
            url: "http://localhost/sustainablestar/public/companies/store",
            global: false,
            method: "POST",
            dataType: 'json',
            data: formData,
            success: function (result) {
                if (result.success) {
                    Swal.fire('Success!', result.message, 'success').then(function () {
                        $("#add-company-form").trigger("reset");
                        $(".js-example-basic-single").val('').trigger('change');
                        $(".js-example-basic-multiple").val('').trigger('change');
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

$(document).on('click', '.delete-companies', function(){
    let data_id = $(this).attr('data-id');
    Swal.fire({
        title: "Are you sure? You want to delete this Company?",
        icon: "question",
      text: "Note: This Company will be deleted permanently.",
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
            url: "http://localhost/sustainablestar/public/companies/delete",
            type: 'POST',
            data: {
                id: data_id
            },
            success: function (result){
                if(result.success){

                    Swal.fire("Success!", result.message, "success").then(() => {
                        $("#myTable").dataTable().fnDestroy();
                        getCompanies();
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
