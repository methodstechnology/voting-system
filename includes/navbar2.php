<header class="main-header">
  <nav class="navbar navbar-static-top">
    <div class="container">
      <div class="navbar-header">
        <a href="www.dazzleli.com" class="navbar-brand"><b>Dazzleli </b>HOME</a>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
          <i class="fa fa-bars"></i>
        </button>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
        <ul class="nav navbar-nav">
            <?php
           echo "
           <li><a href='https://wa.me/+2348115121428?text=I%20want%20to%20buy%20a%20voting%20code'>Buy Voting Code</a></li>
              <li><a href='https://www.youtube.com/shorts/Ht7cHb7ptQA'>How to Vote</a></li>
              ";
              ?>
          <?php
            if(isset($_SESSION['student'])){
              echo "
                <li><a href='index.php'>HOME</a></li>
                <li><a href='transaction.php'>TRANSACTION</a></li>
              ";
            } 
          ?>
        </ul>
      </div>
      <!-- /.navbar-collapse -->
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="user user-menu">
            <a href="">
              <img src="images/logo.png" class="user-image" alt="User Image">
             
            </a>
          </li>
         
        </ul>
      </div>
      <!-- /.navbar-custom-menu -->
    </div>
    <!-- /.container-fluid -->
  </nav>
</header>
