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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Search</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
</head>

<body>
    <?php include('navbar.php');?>
    <br>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="panel-heading">
                        <div class="panel-title pull-left">
                            Traveler Details
                        </div>
                        <div class="panel-title pull-right">

                            <button type="button" class="btn btn-sm btn-primary btn-create" id="addProfileButton"
                            data-toggle="modal" data-target="#editProfileModal">
                            <i class="fa fa-plus"></i> Add New User
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#studentaddmodal">
                            ADD DATA
                        </button>

                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>
            <div class="card-body">
                <div class="card" style=" overflow-y: auto;">
                    <div id="user_details_result" class="card-body">

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
<!-- <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editProfileModalLabel"> Profile</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <form id="editProfileForm" onsubmit="submitForm(); return false;">
                <div class="row">
                    <div class="col-lg-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="firstName">First Name</label>

                            <input class="form-control" id="userId" value=" " name="userId" type="hidden">
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
                            <label for="contactNumber">Contact Number</label>
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
                <div class="form-group">
                    <label for="passportNumber">Passport Number</label>
                    <input type="text" class="form-control" id="passportNumber" name="passportNumber" placeholder="Enter Passport Number">
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
                        <label for="state">State</label>
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
            <input type="submit" class="btn btn-primary" id="submitBtn" value="Update User">

        </form>
    </div>
</div>
</div>
</div> -->

<div class="modal fade" id="studentaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Traveler Data </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <form action="adduser.php" method="POST">

            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="firstName">First Name</label>

                            <input class="form-control" id="userId" value=" " name="userId" type="hidden">
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
                            <label for="contactNumber">Contact Number</label>
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
                <div class="form-group">
                    <label for="passportNumber">Passport Number</label>
                    <input type="text" class="form-control" id="passportNumber" name="passportNumber" placeholder="Enter Passport Number">
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
                        <label for="state">State</label>
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
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="insertdata" class="btn btn-primary">Save Data</button>
        </div>
    </form>

</div>
</div>
</div>

<!-- EDIT POP UP FORM (Bootstrap MODAL) -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Edit Student Data </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <form action="updatecode.php" method="POST">

            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="firstName">First Name</label>

                            <input class="form-control" id="userId" value=" " name="userId" type="hidden">
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
                            <label for="contactNumber">Contact Number</label>
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
                <div class="form-group">
                    <label for="passportNumber">Passport Number</label>
                    <input type="text" class="form-control" id="passportNumber" name="passportNumber" placeholder="Enter Passport Number">
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
                        <label for="state">State</label>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="updatedata" class="btn btn-primary">Update Data</button>
            </div>
        </form>

    </div>
</div>
</div>

<script>
    var userId;
    $(document).ready(function() {
        var dataTable = $('#userTable').DataTable({
            responsive: true,
            scrollX: true,
            responsive: true,
            "lengthMenu": [
            [25, 50, 100, -1],
            [25, 50, 100, "All"]
            ],
        });

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
                    displayUserDetails(userData);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        function displayUserDetails(userData) {
            var table =
            "<table class='table table-bordered mt-4' id='userTable'>" +
            "<thead class='thead'>" +
            "<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Gender</th><th>DOB</th><th>Birth Place</th><th>Contact Number</th><th>Document Type</th><th>Passport Number</th><th>Nationality</th><th>Address</th><th>City</th><th>State</th><th>Zip</th><th>Action</th></tr>" +
            "</thead><tbody>";

            $.each(userData, function(index, userData) {

                // Display a single user data
                table += "<tr>";
                table += "<td>" + (userData.first_name || '') + "</td>";
                table += "<td>" + (userData.last_name || '') + "</td>";
                table += "<td>" + (userData.email || '') + "</td>";
                table += "<td>" + (userData.gender || '') + "</td>";
                table += "<td>" + (userData.date_of_birth || '') + "</td>";
                table += "<td>" + (userData.birth_place || '') + "</td>";
                table += "<td>" + (userData.contact_number || '') + "</td>";
                table += "<td>" + (userData.document_type || '') + "</td>";
                table += "<td>" + (userData.passport_number || '') + "</td>";
                table += "<td>" + (userData.nationality || '') + "</td>";
                table += "<td>" + (userData.address || '') + "</td>";
                table += "<td>" + (userData.city || '') + "</td>";
                table += "<td>" + (userData.state || '') + "</td>";
                table += "<td>" + (userData.zip || '') + "</td>";
                table += "<td><button class='btn btn-primary btn-edit' data-userid='" + userData
                .user_id +
                "' data-toggle='modal' data-target='#editProfileModal'>Edit</button></td>";

                table += "</tr>";
            });

            table += "</tbody></table>";

            $('#user_details_result').html(table);

            // If DataTable is already initialized, destroy it and reinitialize
            if ($.fn.DataTable.isDataTable('#userTable')) {
                $('#userTable').DataTable().clear().destroy();
            }

            // Initialize DataTable
            $('#userTable').DataTable({
                responsive: true
            });


        }
    });


</script>
<script>
    $(document).ready(function() {
    // ... existing code ...

    // Initialize DataTable
    var dataTable = $('#userTable').DataTable({
        responsive: true,
        scrollX: true,
        responsive: true,
        "lengthMenu": [
        [25, 50, 100, -1],
        [25, 50, 100, "All"]
        ],
    });

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
                displayUserDetails(userData);
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

    function displayUserDetails(userData) {
        var table =
        "<table class='table table-bordered mt-4' id='userTable'>" +
        "<thead class='thead'>" +
        "<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Gender</th><th>DOB</th><th>Birth Place</th><th>Contact Number</th><th>Document Type</th><th>Passport Number</th><th>Nationality</th><th>Address</th><th>City</th><th>State</th><th>Zip</th><th>Action</th><th></th></tr>" +
        "</thead><tbody>";

        $.each(userData, function(index, userData) {

                // Display a single user data
                table += "<tr>";
                table += "<td>" + (userData.first_name || '') + "</td>";
                table += "<td>" + (userData.last_name || '') + "</td>";
                table += "<td>" + (userData.email || '') + "</td>";
                table += "<td>" + (userData.gender || '') + "</td>";
                table += "<td>" + (userData.date_of_birth || '') + "</td>";
                table += "<td>" + (userData.birth_place || '') + "</td>";
                table += "<td>" + (userData.contact_number || '') + "</td>";
                table += "<td>" + (userData.document_type || '') + "</td>";
                table += "<td>" + (userData.passport_number || '') + "</td>";
                table += "<td>" + (userData.nationality || '') + "</td>";
                table += "<td>" + (userData.address || '') + "</td>";
                table += "<td>" + (userData.city || '') + "</td>";
                table += "<td>" + (userData.state || '') + "</td>";
                table += "<td>" + (userData.zip || '') + "</td>";
                table += "<td><button class='btn btn-primary btn-edit' data-userid='" + userData
                .user_id +
                "' data-toggle='modal' data-target='#editProfileModal'>Edit</button></td>";
               table += "<td><button type='button' class='btn btn-success editbtn'>EDIT</button></td>";



                table += "</tr>";
            });

        table += "</tbody></table>";

        $('#user_details_result').html(table);

            // If DataTable is already initialized, destroy it and reinitialize
            if ($.fn.DataTable.isDataTable('#userTable')) {
                $('#userTable').DataTable().clear().destroy();
            }

            // Initialize DataTable
            $('#userTable').DataTable({
                responsive: true
            });


        }


    // Add click event for the "Add New User" button
    $('#addProfileButton').on('click', function() {
        // Open the modal for adding a new user
        openAddPopup();
    });

    // ... existing code ...

    // Function to open the edit popup
    function openEditPopup(userId) {
        // Code to open the edit popup with the selected user data
        // You may need to fetch user data based on the userId and populate the form fields
        // Example: $.ajax({ /* Fetch user data */ });
        $('#editProfileModal').modal('show');
    }

    // Function to open the add popup
    function openAddPopup() {
        // Code to open the add popup for a new user
        $('#editProfileModal').modal('show');
    }

    // ... existing code ...
});

</script>

<script>
    $(document).ready(function () {

        $('.editbtn').on('click', function () {
            $('#editmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            $('#update_id').val(data[0]);
            $('#fname').val(data[1]);
            $('#lname').val(data[2]);
            $('#course').val(data[3]);
            $('#contact').val(data[4]);
        });
    });
</script>


</body>

</html>