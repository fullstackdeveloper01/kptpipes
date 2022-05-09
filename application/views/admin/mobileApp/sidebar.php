    <div class="col-md-3">
        <ul class="nav navbar-pills navbar-pills-flat nav-tabs nav-stacked">
            <li class="<?= ($activemenu == "splash")?"active":""; ?>">
                <a href="<?= admin_url('mobileApp'); ?>" data-group="splash" > Splash Screen</a>
            </li>
            <li class="<?= ($activemenu == "intro")?"active":""; ?>">
                <a href="<?= admin_url('mobileApp/intro'); ?>" data-group="intro"> Intro</a>
            </li>
        </ul>
	</div>