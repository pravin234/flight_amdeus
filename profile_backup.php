<?php
session_start();
if (!isset($_SESSION['email'])) {
    // Redirect to the login page
    header("Location: index.php");
    exit();
}
$accessToken = @$_SESSION['access_token'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Travel Search</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />

    <link rel="stylesheet" type="text/css" href="style.css" />
    <style>
    .modal-dialog {
        max-width: 100 % !important;
        width: auto;
    }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <?php include('navbar.php');?>
    <div class="container">
        <div class="panel panel-default panel-table">
            <div class="panel-heading" style="color: red;">
                <div class="col col-xs-12">
                    <h3 class="panel-title">User Details
                    </h3>
                </div>
                <div class="col col-xs-6 text-right">
                    <button type="button" class="btn btn-sm btn-primary btn-create" id="editProfileButton"
                        data-toggle="modal" data-target="#editProfileModal">Update Profile</button>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-user-information">
                    <tbody>
                        <tr>
                            <td>First Name:</td>
                            <td id="profileFirstName"></td>
                        </tr>
                        <tr>
                            <td>Last Name:</td>
                            <td id="profileLastName"></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td id="profileEmail">08/25/2016</td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td>Gender</td>
                            <td id="profileGender"></td>
                        </tr>
                        <tr>
                            <td>DOB</td>
                            <td id="profileDateOfBirth"></td>
                        </tr>
                        <tr>
                            <td>BirthPlace</td>
                            <td id="profilebirthPlace"></td>
                        <tr>
                            <td>Contact Number</td>
                            <td id="profileContactNumber"></td>
                        </tr>
                        </tr>

                        <tr>
                            <td>documentType</td>
                            <td id="profileDocumentType"></td>
                        </tr>
                        <tr>
                            <td>Passport Number</td>
                            <td id="profilePassport_number"></td>
                        </tr>
                        <tr>
                            <td>Nationality</td>
                            <td id="profileNationality"></td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td id="profileAddress"></td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td id="profileCity"></td>
                        </tr>
                        <tr>
                            <td>State</td>
                            <td id="profileState"></td>
                        </tr>
                        <tr>
                            <td>Zip</td>
                            <td id="profileZip"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <div class="modal-body">
                    <form id="editProfileForm">
                        <div class="row">
                            <div class="col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="firstName">First Name</label>
                                    <input type="text" class="form-control" id="firstName" value=" " name="firstName"
                                        placeholder="First Name" />
                                </div>
                                <span id="firstNameError" class="error"></span>
                            </div>
                            <div class="col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="lastName">Middle Name</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName"
                                        placeholder="Last Name" />
                                </div>
                                <span id="lastNameError" class="error"></span>
                            </div>
                            <div class="col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email" id="email"
                                        placeholder="email" />
                                </div>
                                <span id="emailError" class="error"></span>
                            </div>
                            <div class="col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="Gender">Gender</label>
                                    <select class="form-control" name="gender" id="gender">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <span id="genderError" class="error"></span>
                            </div>
                            <div class="col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="dateOfBirth">Date of Birth</label>
                                    <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" />
                                </div>
                                <span id="edateOfBirthError" class="error"></span>
                            </div>
                            <div class="col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="birthPlace">Birth Place</label>
                                    <input type="text" class="form-control" id="birthPlace" name="birthPlace"
                                        placeholder="birthPlace" />
                                </div>
                                <span id="birthPlaceError" class="error"></span>
                            </div>
                            <div class="col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="contactNumber"></label>
                                    <input type="number" class="form-control" id="contactNumber" name="contactNumber"
                                        placeholder="9876543210" />
                                </div>
                                <span id="contactNumberError" class="error"></span>
                            </div>
                            <div class="col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="documentType" class="select">documentType</label>
                                    <select class="form-control" name="documentType" id="documentType"
                                        name="documentType"">
                                        <option value=" PASSPORT" selected>Passport</option>
                                        <option value="AADHAR">Aadhar</option>
                                    </select>
                                </div>
                                <span id="documentTypeError" class="error"></span>
                            </div>
                            <div class="col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="passport_number">PASSPORT Number</label>
                                    <input type="text" class="form-control" id="passportNumber" name="passportNumber"
                                        placeholder="passport_number" />
                                </div>
                                <span id="passport_numberError" class="error"></span>
                            </div>
                            <div class="col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="nationality">Nationality</label>
                                    <input type="text" class="form-control" id="nationality" name="nationality"
                                        placeholder="enter nationality" />
                                </div>
                                <span id="nationalityrError" class="error"></span>
                            </div>
                            <div class="col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="address" />
                                </div>
                                <span id="addressError" class="error"></span>
                            </div>
                            <div class="col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Address 2</label>
                                    <input type="text" class="form-control" id="address2" name="address2"
                                        placeholder="Apartment or Unit #" />
                                </div>
                                <span id="address2Error" class="error"></span>
                            </div>
                            <div class="col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="City" />
                                </div>
                                <span id="cityError" class="error"></span>
                            </div>
                            <div class="col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">State</label>
                                    <input type="text" class="form-control" id="state" name="state"
                                        placeholder="State" />
                                </div>
                                <span id="stateError" class="error"></span>
                            </div>
                            <div class="col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="zip">Zip</label>
                                    <input type="number" class="form-control" id="zip" name="zip"
                                        placeholder="Zip Number" />
                                </div>
                                <span id="city" class="error"></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        // Fetch user data from the server
        $.ajax({
            url: 'fetch_user_data.php',
            method: 'GET',
            data: {
                userId: <?php echo json_encode($_SESSION['user_id']); ?>
            },
            success: function(response) {
                var userData = JSON.parse(response);
                console.log(userData.email);
                if (userData) {
                    $("#profileFirstName").text(userData.first_name || '');
                    $("#profileLastName").text(userData.last_name || '');
                    $("#profileEmail").text(userData.email || '');
                    $("#profileGender").text(userData.gender || '');
                    $("#profileDateOfBirth").text(userData.date_of_birth || '');
                    $("#profilebirthPlace").text(userData.birth_place || '');
                    $("#profileContactNumber").text(userData.contact_number || '');
                    $("#profileDocumentType").text(userData.document_type || '');
                    $("#profilePassport_number").text(userData.passport_number || '');
                    $("#profileNationality").text(userData.nationality || '');
                    $("#profileAddress").text(userData.address || '');
                    $("#profileAddress2").text(userData.address2 || '');
                    $("#profileCity").text(userData.city || '');
                    $("#profileState").text(userData.state || '');
                    $("#profileZip").text(userData.zip || '');


                    $("#firstName").val(userData.first_name || '');
                    $("#lastName").val(userData.last_name || '');
                    $("#email").val(userData.email || '');
                    $("#gender").val(userData.gender || '');
                    $("#dateOfBirth").val(userData.date_of_birth || '');
                    $("#birthPlace").val(userData.birth_place || '');
                    $("#contactNumber").val(userData.contact_number || '');
                    $("#documentType").val(userData.document_type || '');
                    $("#passport_number").val(userData.passport_number || '');
                    $("#nationality").val(userData.nationality || '');
                    $("#address").val(userData.address || '');
                    $("#address2").val(userData.address2 || '');
                    $("#city").val(userData.city || '');
                    $("#state").val(userData.state || '');
                    $("#zip").val(userData.zip || '');


                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        // // Add validation rules
        // $("#myForm").validate({
        //     // Your validation rules here
        // });


        // $("#myForm").submit(function(event) {
        //     event.preventDefault();
        //     var formData = $(this).serialize();

        //     $.ajax({
        //         url: 'update_user.php',
        //         method: 'POST',
        //         data: formData,
        //         success: function(response) {
        //             alert(response);
        //         },
        //         error: function(xhr, status, error) {
        //             console.error(xhr.responseText);
        //         }
        //     });
        // });
    });

    $("#editProfileButton").click(function() {
        // Populate the modal form with existing data
        $("#editFirstName").val($("#profileFirstName").text());
        // Populate other fields as needed

        // Show the modal
        $("#editProfileModal").modal("show");
    });

    // Handle the form submission within the modal
    $(document).ready(function() {
        // Attach submit event to the form
        $("#editProfileForm").submit(function(e) {
            e.preventDefault();
            $('#editProfileForm').modal('hide');
            submitForm();
        });
    });

    function submitForm() {

        var formData = $("#editProfileForm").serialize();

        $.ajax({
            url: 'updateprofile.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.error("Error submitting form:", error);
            },
        });
    }
    </script>
</body>

</html>