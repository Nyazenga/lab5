<?php
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>E-rrigate</title>
    <link rel="stylesheet" href="../style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css" />
    <!-- Boxicons CDN Link -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style type="text/css">
        .cnnclass {
            border: 1px solid black;
            width: 350px;
            padding: 2px;
            background-color: #F3F3F3;
            margin-bottom: 1em;
        }

        .cnnclass a {
            text-decoration: none;
        }

        .newsclass {
            border: 1px solid orange;
            padding: 3px;
            background-color: lightyellow;
            margin-bottom: 1em;
            width: 350px;
        }

        .inline { 
        display: inline-block; 
        font-size: 35px;
        font-weight: 1000;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <ul class="nav-links">
            <li>
                <a href="#" class="active">
                    <i class='fas fa-user'></i>
                    <span class="links_name">Water Level</span>
                </a>
            </li>
            <li>
                <a href="tanks.php">
                    <i class='fas fa-tree'></i>
                    <span class="links_name">Tanks</span>
                </a>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard" style="color: #007bff;">Dashboard</span>
            </div>
    </nav>

        <div class="home-content">
            <div class="display">
                <div class="info">
                <div class="inline">Water Level: </div> <div class="inline" id="dbdata"></div>
                </div>
                <div class="info1">
                    <a class="btn btn-info m-1 float-right" onclick="openUrl('http://192.168.137.84/ON', 'Hi')">
                        <i class="fas fa-table fa-lg"></i>&nbsp;&nbsp;Automatic&nbsp;&nbsp;
                    </a>
                </div>
                <div class="info">
                    <a class="btn btn-info m-1 float-right"  onclick="openUrl('http://192.168.137.84/OFF', 'Hey')">
                        <i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;&nbsp;Manual&nbsp;&nbsp;&nbsp;</a>
                </div>
            </div>
        </div>
    </section>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="script.js"></script>

    <script>
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".sidebarBtn");
        sidebarBtn.onclick = function() {
            sidebar.classList.toggle("active");
            if (sidebar.classList.contains("active")) {
                sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else
                sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        }
    </script>

    <script type="text/javascript">
        var intervalId = window.setInterval(function(){
            updateByAJAX_dbData()
        }, 1000);

        function openUrl(url, title) {
            if (!title) {
                title = 'Just another window';
            }
            var x = window.open(url, title, 'toolbar=1,location=1,directories=1,status=1,menubar=1,scrollbars=1,resizable=1');

            x.blur();
            setTimeout(function(){
                x.close();
            },300);
        }


        function updateByAJAX_dbData(){
			const xhttp=new XMLHttpRequest();
			xhttp.onload=function(){
				document.getElementById("dbdata").innerText=this.responseText;
			}
			xhttp.open("GET", "/Lab5/lab5/frontend/Admin/retrieve.php");
			xhttp.send();
		}


        $(document).ready(function() {
            ShowAllUsers();

            function ShowAllUsers() {
                $.ajax({
                    url: ["../controller/manage-users.php"],
                    type: "POST",
                    data: {
                        action: "view"
                    },
                    success: function(response) {
                        // console.log(response);
                        $("#showUser").html(response);
                        $("table").DataTable();
                    }
                });
            }


            // insert ajax request
            $("#insert").click(function(e) {
                if ($("#form-data")[0].checkValidity) {
                    e.preventDefault();
                    $.ajax({
                        url: ["../controller/manage-users.php"],
                        type: "POST",
                        data: $("#form-data").serialize() + "&action=insert",
                        success: function(response) {

                            Swal.fire({
                                title: 'User added successfully!',
                                showConfirmButton: false,
                                type: 'success',
                                icon: 'success',
                                timer: 500,
                                timerProgressBar: true,
                            })

                            $("#addModal").modal("hide");
                            $("#form-data")[0].reset();
                            ShowAllUsers();

                        }
                    });
                }
            });


            // Edit user
            $("body").on("click", ".editBtn", function(e) {
                // console.log("working");
                e.preventDefault();
                edit_id = $(this).attr("id");
                $.ajax({
                    url: "../controller/manage-users.php",
                    type: "POST",
                    data: {
                        edit_id: edit_id
                    },
                    success: function(response) {
                        console.log(response);
                        data = JSON.parse(response);
                        // console.log(data);
                        $("#id").val(data.id);
                        $("#username").val(data.username);
                        $("#email").val(data.email);
                        $("#phone_number").val(data.phone_number);
                        $("#credit").val(data.credit);
                        $("#farm").val(data.farm);
                    }
                });
            });

            // Update ajax request
            $("#update").click(function(e) {
                if ($("#edit-form-data")[0].checkValidity) {
                    e.preventDefault();
                    $.ajax({
                        url: ["../controller/manage-users.php"],
                        type: "POST",
                        data: $("#edit-form-data").serialize() + "&action=update",
                        success: function(response) {

                            Swal.fire({
                                title: 'User updated successfully!',
                                showConfirmButton: false,
                                type: 'success',
                                icon: 'success',
                                timer: 800,
                                //timerProgressBar: true,
                            })

                            $("#editModal").modal("hide");
                            $("#edit-form-data")[0].reset();
                            ShowAllUsers();
                        }
                    });
                }
            });


            // Delete ajax request 
            $("body").on("click", ".delBtn", function(e) {
                e.preventDefault();
                var tr = $(this).closest("tr");
                del_id = $(this).attr("id");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '../controller/manage-users.php',
                            type: 'POST',
                            data: {
                                del_id: del_id
                            },
                            success: function(response) {
                                tr.css('background-color', '#ff6666');
                                Swal.fire({
                                    title: 'User deleted successfully!',
                                    showConfirmButton: false,
                                    type: 'success',
                                    icon: 'success',
                                    timer: 900,
                                    //timerProgressBar: true,
                                })
                                ShowAllUsers();
                            }
                        });

                    }
                })

            });


            // Show users detail  page
            $("body").on("click", ".infoBtn", function(event) {
                event.preventDefault();
                info_id = $(this).attr("id");
                $.ajax({
                    url: "../controller/manage-users.php",
                    type: "POST",
                    data: {
                        info_id: info_id
                    },
                    success: function(response) {
                        //console.log(response);
                        data = JSON.parse(response);
                        Swal.fire({
                            title: '<strong>User info : ID ' + data.id + '</strong>',
                            type: 'info',
                            html: '<b>Username:</b> ' + data.username + '<br>' +
                                '<b>Email:</b> ' + data.email + '<br>' +
                                '<b>Phone number:</b> ' + data.phone_number + '<br>' +
                                '<b>Credit:</b> ' + data.credit + '<br>' +
                                '<b>Farm:</b> ' + data.farm
                        })
                    }
                });
            });

        })
    </script>

</body>

</html>