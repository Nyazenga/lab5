<?php
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>WALEMO</title>
    <link rel="stylesheet" href="../style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
    <!-- Boxicons CDN Link -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style type="text/css">
        body {
            overflow-y: hidden; /* Hide vertical scrollbar */
            overflow-x: hidden; /* Hide horizontal scrollbar */
        }

        .inline {
            display: inline-block;
            font-size: 25px;
            font-weight: 500;
        }

        .display {
            justify-content: flex-end;
        }

        .circle {
            border: 1px black;
            width: 250px;
            padding: 2px;
            background-color: #fff;
            margin-right: 2em;
            box-shadow: 0 1px 1px rgb(0 0 0 / 10%);
        }

        .home-content {
            padding: 0 50px;
        }

        .text {
            display: flex;
            justify-content: center;
        }

        .text2 {
            font-size: 20px;
            color:#007bff;
        }

        .column {
            float: left;
            width: 50%;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <ul class="nav-links">
            <li>
                <a href="#" class="active">
                    <i class="fas fa-layer-group"></i>
                    <span class="links_name">Water Level</span>
                </a>
            </li>
            <li>
                <a href="tanks.php">
                    <i class='fas fa-box'></i>
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
        <div class="row">
            <div class="column">
                <div class="home-content">
                    <div class="">
                        <div class="info">
                            <div class="inline">Tank 1: </div>
                            <div class="text2" id="mode">Mode - AUTO: ON</div>
                        </div>
                    </div>
                    <div class="display">
                        <div class="circle">
                            <div class="text">Automatic:</div>
                            <div class="">
                                <a class="btn btn-success m-1 float-right" onclick="openUrl('http://192.168.137.84/AUTO', 'Mode - AUTO: ON')">
                                    <i class="fa fa-toggle-on"></i>&nbsp;&nbsp;&nbsp;&nbsp;ON&nbsp;&nbsp;&nbsp;</a>
                            </div>
                        </div>
                        <div class="circle">
                            <div class="text">Manual:</div>

                            <div class="">
                                <a class="btn btn-danger m-1 float-right" onclick="openUrl('http://192.168.137.84/OFF', 'Mode - AUTO: ON')">
                                    <i class="fa fa-toggle-off"></i>&nbsp;&nbsp;&nbsp;&nbsp;OFF&nbsp;&nbsp;&nbsp;</a>
                            </div>

                            <div class="">
                                <a class="btn btn-info m-1 float-right" onclick="openUrl('http://192.168.137.84/ON', 'Mode - MANUAL: ON')">
                                    <i class="fa fa-toggle-on"></i>&nbsp;&nbsp;&nbsp;&nbsp;ON&nbsp;&nbsp;&nbsp;</a>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="info">
                            <div class="inline">Water Level: </div>
                            <div class="inline text2" id="dbdata">Loading...</div>
                            <div class="inline text2">cm </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="column">
                <div class="home-content">
                    <div class="">
                        <div class="info">
                            <div class="inline">Tank 2: </div>
                            <div class="text2" id="mode2">Mode - AUTO: ON</div>
                        </div>
                    </div>
                    <div class="display">
                    <div class="circle">
                            <div class="text">Automatic:</div>
                            <div class="">
                                <a class="btn btn-success m-1 float-right" onclick="openUrl2('http://192.168.137.240/AUTO', 'Mode - AUTO: ON')">
                                    <i class="fa fa-toggle-on"></i>&nbsp;&nbsp;&nbsp;&nbsp;ON&nbsp;&nbsp;&nbsp;</a>
                            </div>
                        </div>
                        <div class="circle">
                            <div class="text">Manual:</div>

                            <div class="">
                                <a class="btn btn-danger m-1 float-right" onclick="openUrl2('http://192.168.137.240/OFF', 'Mode - AUTO: ON')">
                                    <i class="fa fa-toggle-off"></i>&nbsp;&nbsp;&nbsp;&nbsp;OFF&nbsp;&nbsp;&nbsp;</a>
                            </div>

                            <div class="">
                                <a class="btn btn-info m-1 float-right" onclick="openUrl2('http://192.168.137.240/ON', 'Mode - MANUAL: ON')">
                                    <i class="fa fa-toggle-on"></i>&nbsp;&nbsp;&nbsp;&nbsp;ON&nbsp;&nbsp;&nbsp;</a>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="info">
                            <div class="inline">Water Level: </div>
                            <div class="inline text2" id="dbdata2">Loading...</div>
                            <div class="inline text2">cm </div>
                        </div>
                    </div>
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
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
        var intervalId = window.setInterval(function() {
            updateByAJAX_dbData()
        }, 100);

        var intervalId = window.setInterval(function() {
            updateByAJAX_dbData2()
        }, 100);

        function openUrl(url, mode) {
            if (!mode) {
                title = 'WALEMO';
                
            }
            document.getElementById("mode").innerText = mode;
            var x = window.open(url, mode, 'toolbar=1,location=1,directories=1,status=1,menubar=1,scrollbars=1,resizable=1');
            x.blur();
            setTimeout(function() {
                x.close();
            }, 300);

        }

        function openUrl2(url, mode) {
            if (!mode) {
                title = 'WALEMO';
                
            }
            document.getElementById("mode2").innerText = mode;
            var x = window.open(url, mode, 'toolbar=1,location=1,directories=1,status=1,menubar=1,scrollbars=1,resizable=1');
            x.blur();
            setTimeout(function() {
                x.close();
            }, 300);

        }


        function updateByAJAX_dbData() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("dbdata").innerText = this.responseText;
            }
            xhttp.open("GET", "/Lab5/lab5/frontend/Admin/retrieve.php?id=1");
            xhttp.send();
        }

        function updateByAJAX_dbData2() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("dbdata2").innerText = this.responseText;
            }
            xhttp.open("GET", "/Lab5/lab5/frontend/Admin/retrieve.php?id=2");
            xhttp.send();
        }
    </script>

</body>

</html>