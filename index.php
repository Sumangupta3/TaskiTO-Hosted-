<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("location: ./credential/login.php");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MY TODO LIST</title>
  <script src="https://kit.fontawesome.com/328f9238c7.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/logindex.css">

</head>

<body>
  <nav class="navbar navbar-light bg-light ">
    <div class="container">
      <div class="navbar-brand brand">
        <img src="./asset/laptop.svg" alt="logo" class="hearder-img">
        <p class="header-title">TaskiTO</p>
      </div>
      <ul class="navbar-nav">
        <div class="dropdown">
          <div class="nav-item active current nav-link ">
            <!-- <i class="fas fa-chevron-down"></i> -->
            <?php echo $_SESSION['First Name'] ?>
            <i class="fas fa-chevron-down"></i>
          </div>
          <div class="dropdown-content">
            <a class="dropdown-item nav-link logout" href="./credential/logout.php">Logout</a>
          </div>
        </div>
      </ul>
    </div>
  </nav>
  <main>
    <section class="box">
      <div class="heading">
        <img src="./asset/laptop.svg" alt="logo" class="heading-img">
        <h1 class="heading-title">
          TaskiTO 
        </h1>
      </div>
      <!-- <h3><?php echo "Hey! " . $_SESSION['First Name'] ?></h3> -->
      <form class="form">
        <div>
          <label for="todo" class="form-label">
            ~ Today I need to ~
          </label>
          <input type="text" id="todo" name="to-do" size="30" class="form-input" required>
          <button class="button"><span>Submit</span></button>
        </div>
      </form>
      <div>
        <ul class="toDoList">
        </ul>
      </div>
    </section>
  </main>
  <footer class="footer">
    <div class="contact" id="contact">
      <div class="contact-item">
          <a href="mailto:sumanguptamenu@gmail.com" target="_blank"><i
                  class="icon-2 e-mail far fa-envelope fa-2x"></i></a>
      </div>
      <div class="contact-item">
          <a href="https://www.linkedin.com/in/suman-gupta-b27a27190/" target="_blank"><i
                  class="icon-2 linkdin fab fa-linkedin-in fa-2x"></i></a>
      </div>
      <div class="contact-item">
          <a href="https://www.instagram.com/hatersluver/" target="_blank"><i
                  class="icon-2 instagram fab fa-instagram fa-2x"></i></a>
      </div>
      <div class="made-by">
        <p class="made-by-me">
          © Suman Gupta | All Rights Reserved.
        </p>
      </div>
  </div>
  </footer>
  <script>
    function fetcharray(){
      return new Promise((resolve, reject) =>{

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "https://taskito.herokuapp.com/API/get_array.php?email=<?php echo $_SESSION['E-mail'] ?>");
        xmlhttp.onload = () => {
        const data = JSON.parse(xmlhttp.response);
        var toDoListArray = JSON.parse(data["todoArray"]);
        console.log(toDoListArray);
        resolve(toDoListArray);
        };
        xmlhttp.send();
      
      
      });
    }

    function buildlist(toDoListArr){
      return new Promise((resolve, reject) => {
        const ul = document.querySelector(".toDoList"); 
        for(var i = 0; i<toDoListArr.length ; i++){
          // create an li
          const li = document.createElement('li')
          console.log(toDoListArr[i]["itemId"]);
          li.setAttribute("data-id", toDoListArr[i]["itemId"]);
          // add toDoItem text to li
          li.innerText = toDoListArr[i]["toDoItem"];
          // add li to the DOM
          ul.appendChild(li);
        }
      });
    }
    console.log("iiiii")
    fetcharray()
      .then((array) => buildlist(array));
    // IEFE
    (() => { 
        // state variables
        let toDoListArray = [];
        // ui variables
        const form = document.querySelector(".form"); 
        const input = form.querySelector(".form-input");
        const ul = document.querySelector(".toDoList"); 
      
        // event listeners
        form.addEventListener('submit', e => {
          // prevent default behaviour - Page reload
          e.preventDefault();

          fetcharray()
              .then((array) => work(array));
        });
        function work(array){
          toDoListArray = array;
          // give item a unique ID
          let itemId = String(Date.now());
          // get/assign input value
          let toDoItem = input.value;
          //pass ID and item into functions
          addItemToDOM(itemId , toDoItem);
          addItemToArray(itemId, toDoItem);
          // clear the input box. (this is default behaviour but we got rid of that)
          input.value = '';
        }

        ul.addEventListener('click', e => {
          let id = e.target.getAttribute('data-id')
          if (!id) return // user clicked in something else      
          //pass id through to functions
          removeItemFromDOM(id);
          fetcharray()
            .then((array) => removeItemFromArray(array,id));
        });
        
        // functions 
        function addItemToDOM(itemId, toDoItem) {    
          // create an li
          const li = document.createElement('li')
          li.setAttribute("data-id", itemId);
          // add toDoItem text to li
          li.innerText = toDoItem
          // add li to the DOM
          ul.appendChild(li);
        }
        
        function addItemToArray(itemId, toDoItem) {
          // add item to array as an object with an ID so we can find and delete it later
          toDoListArray.push({ itemId, toDoItem});
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.open("GET", "https://taskito.herokuapp.com/API/updateArray.php?email=<?php echo $_SESSION['E-mail'] ?>&&finalArray="+JSON.stringify(toDoListArray));
          xmlhttp.send();

          console.log(toDoListArray)
        }
        
        function removeItemFromDOM(id) {
          // get the list item by data ID
          var li = document.querySelector('[data-id="' + id + '"]');
          // remove list item
          ul.removeChild(li);
        }
        
        function removeItemFromArray(array ,id) {
          // create a new toDoListArray with all li's that don't match the ID
          toDoListArray = array;
          toDoListArray = toDoListArray.filter(item => item.itemId !== id);
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.open("GET", "https://taskito.herokuapp.com/API/updateArray.php?email=<?php echo $_SESSION['E-mail'] ?>&&finalArray="+JSON.stringify(toDoListArray));
          xmlhttp.send();
          console.log(toDoListArray);
        }
        
    })();

  </script>
</body>

</html>