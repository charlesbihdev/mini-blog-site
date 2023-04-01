<nav class="item nav-bar">
    <h1 class="umat-press">UMaTPress</h1>
    <h3 class="greetings">HELLO <?php echo strtoupper($r['firstname']); ?></h3>

    <div class="boxed">
        <h1 class="account-user">ACCOUNT - <?PHP echo $isadmin  ?></h1>

        <i class="fa fa-bell notifications fa-lg"></i>

        <img class="profile-img" src=".<?php echo $r['image']; ?>" alt="img" />
    </div>
</nav>