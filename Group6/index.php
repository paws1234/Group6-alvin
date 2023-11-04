<!DOCTYPE html>
<html>

<head>
    <?php session_start(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Lab</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/cf223ee5eb.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="icon" href="images/ctu5.png" type="image/x-icon">
    <!-- meta tag that disables caching for the page it is included on and it prevents the browser from storing a local copy. 
    This causes the browser to fetch a fresh copy of the page from the server each time the user visits. -->
    <meta http-equiv="Cache-control" content="no-cache">
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">


</head>

<body>
    <div class="ctn">
        <div class="slider">
            <div id="slides" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://scontent.fceb1-1.fna.fbcdn.net/v/t39.30808-6/306825486_1759839847708185_264014589913629738_n.jpg?stp=cp6_dst-jpg&_nc_cat=107&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeFMgbIlakZ47H1FVn2KmhB7e7n1a0IGhal7ufVrQgaFqQY7LnOLwH_gUo-cLWs6MnPpDi_gHe8NVxbtZJ7Iw5Yp&_nc_ohc=BK1y13j2voMAX8Dyeq4&_nc_ht=scontent.fceb1-1.fna&oh=00_AfA-WWfFjPhPOImCFnmOROv9ubI_10xKAJ3lqoM8LxK-2Q&oe=6548204Ehttps://scontent.fceb1-1.fna.fbcdn.net/v/t39.30808-6/306825486_1759839847708185_264014589913629738_n.jpg?stp=cp6_dst-jpg&_nc_cat=107&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeFMgbIlakZ47H1FVn2KmhB7e7n1a0IGhal7ufVrQgaFqQY7LnOLwH_gUo-cLWs6MnPpDi_gHe8NVxbtZJ7Iw5Yp&_nc_ohc=BK1y13j2voMAX8Dyeq4&_nc_ht=scontent.fceb1-1.fna&oh=00_AfA-WWfFjPhPOImCFnmOROv9ubI_10xKAJ3lqoM8LxK-2Q&oe=6548204E"
                            class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://scontent.fceb1-1.fna.fbcdn.net/v/t39.30808-6/337514661_137034369316434_6423063135988787623_n.jpg?stp=cp6_dst-jpg&_nc_cat=108&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeGqXTv3ZZl4jsiLXqXwmy-73BUJwPsKjRPcFQnA-wqNE15FoVLoat7jRadUdoqzNKZW5vJHicFLnJsBC-5tvi7Q&_nc_ohc=pOXXImdJbhcAX8I4N67&_nc_ht=scontent.fceb1-1.fna&oh=00_AfBarlqCgurnVumlW4_XCYyo9DV2M6EXfHtcoBafQ6bfKw&oe=6547A095"
                            class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://scontent.fceb1-2.fna.fbcdn.net/v/t39.30808-6/374763635_672541794903673_4330645766256566250_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeF2okyiPuYKr9gxmYmqlEiIwbyPYDdqS3zBvI9gN2pLfFAnBkIq6VVN_7lCrv5ExCC6WMxRl3xSX48jpecB3j5T&_nc_ohc=xR6tu7S7alcAX8YbxiS&_nc_ht=scontent.fceb1-2.fna&oh=00_AfAcrFxun03Ac2KvCIjk6wYVTOmYTPgIvy6BmrvNfHDlHg&oe=65481C4B"
                            class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://scontent.fceb1-2.fna.fbcdn.net/v/t39.30808-6/336650281_610075913921693_2587514029007065372_n.jpg?stp=cp6_dst-jpg&_nc_cat=109&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeHX7kqU33i7B1sPtgAM9-hvTW8dJmZj5KBNbx0mZmPkoHY0mvrwp_Zhs9edj0sh760hkrpeNXD8U-hbZwRide7a&_nc_ohc=c3IDd49UABgAX90-bDA&_nc_ht=scontent.fceb1-2.fna&oh=00_AfDbeWBrGPmKJXfx5WwMt7vbNgEg3oyEMv4fbS-XzgMoyQ&oe=654939B7"
                            class="d-block w-100" alt="...">
                    </div>
                </div>
            </div>
        </div>
        <div class="text">
            <h1>Welcome to the<br>Computer Lab <br>Reservation System</S></h1>
            <div class="bttn">
                <a class="login-button" data-bs-toggle="modal" data-bs-target="#login-modal"
                    data-bs-whatever="login-modal">
                    <div>Login</div>
                </a>
                <a class="reg-button" data-bs-toggle="modal" data-bs-target="#reg-modal" data-bs-whatever="reg-modal">
                    <div>Register</div>
                </a>
            </div>
        </div>
    </div>
    </div>
    <!------------------------------------ Login Modal ------------------------------------>
    <div class="modal fade" id="login-modal" tabindex="-1" aria-labelledby="login-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content primary">
                <div class="modal-header text-center">
                    <h1 class="modal-title fs-5 text-center">Login</h1>
                    <i class="fa-sharp fa-solid fa-xmark" data-bs-dismiss="modal" aria-label="Close"></i>
                </div>
                <?php
                if (isset($_SESSION['login_error'])) {
                    echo '<p class="error-message">' . $_SESSION['login_error'] . '</p>';
                    unset($_SESSION['login_error']);
                }
                ?>
                <div class="modal-body">
                    <form method="post" action="process_login.php">
                        <div class="mb-3">
                            <label for="Username" class="col-form-label">Username:</label>
                            <input type="text" name="username" class="form-control" id="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="Password" class="col-form-label">Password:</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                        <script>
                            console.log("User Role: <?php echo isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'Unknown'; ?>");
                        </script>
                        <div class="d-flex flex-column text-center align-items-center justify-content-center">
                            </button>
                            <button type="submit" class="login-submit btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!------------------------------------ Register Modal ------------------------------------>
    <div class="modal fade" id="reg-modal" tabindex="-1" aria-labelledby="login-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"
        style="max-width=80%;">
            <div class="modal-content primary">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Register</h1>
                    <i class="fa-sharp fa-solid fa-xmark" data-bs-dismiss="modal" aria-label="Close"></i>
                </div>
                <?php
                if (isset($_SESSION['registration_error'])) {
                    echo '<div class="error-message">' . $_SESSION['registration_error'] . '</div>';
                    unset($_SESSION['registration_error']);
                }
                ?>
                <div class="modal-body">
                    <form method="post" action="process-registration.php">
                        <div class="mb-3">
                            <label for="username" class="col-form-label">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="col-form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="col-form-label">Confirm Password:</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                required>
                        </div>
                        <div class="d-flex flex-column text-center align-items-center justify-content-center">
                            </button>
                            <input type="submit" class="login-submit btn btn-primary" value="Register">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
