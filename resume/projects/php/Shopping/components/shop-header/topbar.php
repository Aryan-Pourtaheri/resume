<?php session_start();  ?>

<!-- Topbar Start -->
<div class="container-fluid">
    <div class="row" style="background: #e53935;">
        <div class="col-lg-6 d-none d-lg-block">
            <!-- Optional content for the left side -->
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                <div class="btn-group">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <button type="button" class="btn btn-sm text-white dropdown-toggle d-flex align-items-center" data-toggle="dropdown" style="background: #b71c1c; border: none;">
                            <img 
                                src="<?php echo isset($_SESSION['profile_image']) && $_SESSION['profile_image'] ? htmlspecialchars($_SESSION['profile_image']) : './uploads/profile_pictures/9_desk.jpeg'; ?>" 
                                alt="Profile" 
                                class="rounded-circle" 
                                style="width: 40px; height: 40px; object-fit: cover; margin-right: 8px; border: 2px solid #fff; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);">
                            <span class="ml-2 font-weight-bold"><?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right shadow" style="border-top: 2px solid #e53935;">
                            <a class="dropdown-item" href="./profile.php"><i class="fa fa-user text-danger mr-2"></i>Profile</a>
                            <a class="dropdown-item" href="./_auth/logout.php"><i class="fa fa-sign-out-alt text-danger mr-2"></i>Logout</a>
                        </div>
                    <?php else: ?>
                        <button type="button" class="btn btn-sm text-white dropdown-toggle" data-toggle="dropdown" style="background: #b71c1c; border: none;">My Account</button>
                        <div class="dropdown-menu dropdown-menu-right shadow" style="border-top: 2px solid #e53935;">
                            <a class="dropdown-item" href="./_auth/login.php"><i class="fa fa-sign-in-alt text-danger mr-2"></i>Sign in</a>
                            <a class="dropdown-item" href="./_auth/register.php"><i class="fa fa-user-plus text-danger mr-2"></i>Sign up</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->