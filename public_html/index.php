<!DOCTYPE html>
<style>
  
  label{
    color: white;
  }

  input{
    margin-top: 5px;
  }
</style>

<html>
  <body>
    <!-- <div id = "login" style="background-color: maroon; width: 250px; height: 120px; text-align: center;"> -->
    <div id = "login" style="background-color: maroon; width: 400px; height: 200px; text-align: center; margin-left: 50%">
      
      <form id = "loginForm" style = "margin-top: 10px;">
        <p>
          <label style = "margin-top: 10px;"> Sign-in: </label>
          <br>
          <input id = "username" type = "text" title = "Please input a valid username" required/>
        </p>
        <p>
          <label> Password: </label>
          <br>
          <input id = "password" type = "password" title = "Please input a password" required/>
        </p>

      </form>

    </div>
  </body>
</html>