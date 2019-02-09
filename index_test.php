<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
}

.navbar {
  overflow: hidden;
  background-color: #e9e9e9; 
}

.navbar a {
  float: left;
    display: block;
    color: black;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 17px;
}

.subnav {
  float: left;
  overflow: hidden;
}

.subnav .subnavbtn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: black;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.navbar a:hover, .subnav:hover .subnavbtn {
  background-color: #2196F3;
}

.subnav-content {
  display: none;
  position: absolute;
  left: 0;
  background-color: #2196F3;
  width: 100%;
  z-index: 1;
}

.subnav-content a {
  float: left;
  color: white;
  text-decoration: none;
}

.subnav-content a:hover {
  background-color: #eee;
  color: black;
}

.subnav:hover .subnav-content {
  display: block;
}

.navbar .login-container {
    float: right;
}

.navbar .login-container button {
    float: right;
    padding: 6px 10px;
    margin-top: 8px;
    margin-right: 16px;
    background-color: #555;
    color: white;
    font-size: 17px;
    border: none;
    cursor: pointer;
}

.navbar .login-container button:hover {
    background-color: green;
}

@media screen and (max-width: 600px) {
    .navbar .login-container {
        float: none;
    }
    .navbar a, .navbar input[type=text], .navbar .login-container button {
        float: none;
        display: block;
        text-align: left;
        width: 100%;
        margin: 0;
        padding: 14px;
    }
    .navbar input[type=text] {
        border: 1px solid #ccc;
    }
}
</style>
</head>
<body>

<div class="navbar">
  <a href="#home">Home</a>
  <div class="subnav">
    <button class="subnavbtn">About :</button>
    <div class="subnav-content">
      <a href="#company">Company</a>
      <a href="#team">Team</a>
      <a href="#careers">Careers</a>
    </div>
  </div> 
  <div class="subnav">
    <button class="subnavbtn">Services :</button>
    <div class="subnav-content">
      <a href="#bring">Bring</a>
      <a href="#deliver">Deliver</a>
      <a href="#package">Package</a>
      <a href="#express">Express</a>
    </div>
  </div> 
  <div class="subnav">
    <button class="subnavbtn">Partners :</button>
    <div class="subnav-content">
      <a href="#link1">Link 1</a>
      <a href="#link2">Link 2</a>
      <a href="#link3">Link 3</a>
      <a href="#link4">Link 4</a>
    </div>
  </div>
  <a href="#contact">Contact</a>
  
  
  <div class="login-container">
        <form action="action.php" method="post">
            <input type="hidden" name="action" value="logout">
            <button type="submit">Logout</button>
        </form>
  </div>
  
</div>

<div style="padding:0 16px">
  <h3>Subnav/dropdown menu inside a Navigation Bar</h3>
  <p>Hover over the "about", "services" or "partners" link to see the sub navigation menu.</p>
</div>

</body>
</html>
