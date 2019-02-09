<?php
if(!defined("MAIN_FILE")) die;
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/topnav.css">


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

    <!-- <link rel="stylesheet" type="text/css" href="/DataTables/datatables.min.css"/>

    <script type="text/javascript" src="/DataTables/datatables.min.js"></script> -->

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
</head>
<body>

<div class="topnav">
    <a class="active" href="#home">Home</a>
    <a href="#accounts">Konta</a>
    <a href="#admins">Administratory</a>
    
    <div class="dropdown">
    <button class="dropbtn">Dropdown
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="#">Link 1</a>
      <a href="#">Link 2</a>
      <a href="#">Link 3</a>
    </div>
  </div>
    
    
    
    <a href="#waiting"><i class="icon-time"></i>Oczekujące organizatory <span class="badge badge-info" title="Nie ma">0</span></a>


    <div class="login-container">
        <form action="action.php" method="post">
            <input type="hidden" name="action" value="logout">
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

<div style="padding-left:16px">
    <h2>Responsive Admin Form in Navbar</h2>
    <p>Navigation menu with a login form and a submit button inside of it.</p>
    <p>Resize the browser window to see the responsive effect.</p>
</div>

<div style="margin: 10px;">
<table id="table_id" class="display compact" >
    <thead>
        <tr><th>Name</th><th>Surname</th><th>email</th><th>datetime reg</th><th>comments</th></tr>
    </thead>
    <tbody>
        <tr><td>Igor1</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor2</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor3</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor4</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor5</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor6</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor7</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor8</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor9</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor10</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor11</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor12</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor13</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor14</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor15</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor16</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor17</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor18</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor19</td><td>Andr</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor20</td><td>Andr</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor21</td><td>Andr</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor22</td><td>Andr</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor23</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor24</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor25</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor26</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor27</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor28</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor29</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor30</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor31</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor32</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor33</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor34</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor35</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor36</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor37</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor38</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor39</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
        <tr><td>Igor40</td><td>Tigor</td><td>tigor@mail.com</td><td>123</td><td>comments</td></tr>
    </tbody>
</table>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#table_id').DataTable({
            "ordering": true,
            "info":     false,
            "searching": true,
            "select": true,
            columnDefs: [
                {
                    targets: "_all",
                    className: 'dt-left'
                }
            ]
        });
    });
</script>
</body>
</html>