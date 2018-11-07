<?php
echo '<div class="container-fluid bg-info">
        <div class="row">
            <h1 class="col-sm-9" style="display: flex; justify-content: center; align-items: center;">Organizacija kulturnih događaja</h1>

            <div class="col-sm-3 border border-dark" style="padding-top:15px">
                <form action="' . $_SERVER['REQUEST_URI'] . '" method="POST">
                    <div class="form-group">
                        <input type="text" name="user" class="form-control shadow" id="usr" placeholder="Korisničko ime..." value="'; echo $user . '" required/><span class="text-danger">'; echo $porukaU . '</span><br>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control shadow" id="pwd" name="pass" placeholder="Lozinka..." required/><span class="text-danger">'; echo $porukaP . '</span><br>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn bg-warning align-auto shadow" value="Uloguj se"/>
                    </div>
                    <a class="float-left text-white" href="signin.php">Prijavi se</a>
                    <a class="float-right text-white" href="reset.php">Reset lozinke</a>
                </form>
            </div>
        </div>
    </div>';