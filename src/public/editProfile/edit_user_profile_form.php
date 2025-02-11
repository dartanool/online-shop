<html lang="en">
<body>
<!-- Navbar top -->
<div class="navbar-top">
    <div class="title">
        <h1>Profile</h1>
    </div>
</div>
<!-- End -->

<!-- Sidenav -->
<div class="sidenav">
    <div class="profile">
        <img src="https://imdezcode.files.wordpress.com/2020/02/imdezcode-logo.png" alt="" width="100" height="100">

        <div class="name">
            <?php echo $user['name'];?>
        </div>
    </div>
</div>
<!-- End -->
<!-- Main -->
<div class="main">
    <h2>Personal Information</h2>
    <form action="edit-user-profile" method="POST">
    <div class="card">
        <div class="card-body">
            <i class="fa fa-pen fa-xs edit"></i>
            <table>
                <tbody>
                <tr><td>Name</td>
                    <?php if (isset($errors['name'])): ?>
                        <td style="color: red"><?php echo $errors['name'];?></td>
                    <?php endif; ?>
                </tr>
                <td>
                    <div class="input-box">
                        <input type="text" name="name" placeholder="Username"  />
                    </div>
                </td>
                <tr>
                    <td>Email</td>
                    <?php if (isset($errors['email'])): ?>
                        <td style="color: red"><?php echo $errors['email'];?></td>
                    <?php endif; ?>
                </tr>
                <td>
                    <div class="input-box">
                        <input type="text" name="email" placeholder="Email" />
                    </div>
                </td>
                <tr>
                    <td>Password</td>
                    <?php if (isset($errors['password'])): ?>
                        <td style="color: red"><?php echo $errors['password'];?></td>
                    <?php endif; ?>
                </tr>
                <td>
                    <div class="input-box">
                        <input type="password" name="password" placeholder="Password" />
                    </div>
                </td>

                <tr>
                    <td>Check password</td>
                </tr>
                <td>
                    <div class="input-box">
                        <input type="password" name="checkPassword" placeholder="Confirm password" />
                    </div>
                </td>

                </tbody>
            </table>
<!--            <button type="submit" class="btn btn-primary btn-block btn-large">Save</button>-->
            <div class="input-box button">
                <input type="Submit" value="Save">
            </div>
        </div>
    </div>
    </form>
</div>
<!-- End -->
</body>
</html>


<style>
    /* Import Font Dancing Script */
    @import url(https://fonts.googleapis.com/css?family=Dancing+Script);

    * {
        margin: 0;
    }

    body {
        background-color: #e8f5ff;
        font-family: Arial;
        overflow: hidden;
    }

    /* NavbarTop */
    .navbar-top {
        background-color: #fff;
        color: #333;
        box-shadow: 0px 4px 8px 0px grey;
        height: 70px;
    }

    .title {
        padding-top: 15px;
        position: absolute;
        left: 45%;
    }



    /* End */

    /* Sidenav */
    .sidenav {
        background-color: #fff;
        color: #333;
        border-bottom-right-radius: 25px;
        height: 86%;
        left: 0;
        overflow-x: hidden;
        padding-top: 20px;
        position: absolute;
        top: 70px;
        width: 250px;
    }

    .profile {
        margin-bottom: 20px;
        margin-top: -12px;
        text-align: center;
    }

    .profile img {
        border-radius: 50%;
        box-shadow: 0px 0px 5px 1px grey;
    }

    .name {
        font-size: 20px;
        font-weight: bold;
        padding-top: 20px;
    }

    .url hr {
        margin-left: 20%;
        width: 60%;
    }

    .url a {
        color: #818181;
        display: block;
        font-size: 20px;
        margin: 10px 0;
        padding: 6px 8px;
        text-decoration: none;
    }

    .url a:hover, .url .active {
        background-color: #e8f5ff;
        border-radius: 28px;
        color: #000;
        margin-left: 14%;
        width: 65%;
    }

    /* End */

    /* Main */
    .main {
        margin-top: 2%;
        margin-left: 29%;
        font-size: 28px;
        padding: 0 10px;
        width: 58%;
    }

    .main .card {
        background-color: #fff;
        border-radius: 18px;
        box-shadow: 1px 1px 8px 0 grey;
        height: auto;
        margin-bottom: 20px;
        padding: 20px 0 20px 50px;
    }

    .main .card table {
        border: none;
        font-size: 16px;
        height: 270px;
        width: 80%;
    }
    .input-box.button input{
        color: #fff;
        letter-spacing: 1px;
        border: none;
        background: #4070f4;
        cursor: pointer;

        width: 15em; /* Ширина кнопки */
        height: 2em; /* Высота кнопки */
    }
    .input-box.button input:hover{
        background: #0e4bf1;
    }



</style>
