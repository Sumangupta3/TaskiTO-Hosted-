// document.querySelector(".form").addEventListener('submit', e => {
//   e.preventDefault();

//   var xmlhttp = new XMLHttpRequest();
//   xmlhttp.open("GET", "http://localhost/new-to-do/api/get_array.php?email=sumanguptamenu@gmail.com");
//   xmlhttp.onload = () => {
//     const data = JSON.parse(xmlhttp.response);
//     console.log(JSON.parse(data["todoArray"])[0]);
//   };
//   xmlhttp.send();
// });


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

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "http://localhost/new-to-do/api/get_array.php?email=sumanguptamenu@gmail.com");
    xmlhttp.onload = () => {
      const data = JSON.parse(xmlhttp.response);
      toDoListArray = JSON.parse(data["todoArray"]);
    };
    xmlhttp.send();
    // give item a unique ID
    let itemId = String(Date.now());
    // get/assign input value
    let toDoItem = input.value;
    //pass ID and item into functions
    addItemToArray(itemId, toDoItem);
    addItemToDOM(itemId, toDoItem);
    // clear the input box. (this is default behaviour but we got rid of that)
    input.value = '';
  });

  ul.addEventListener('click', e => {
    let id = e.target.getAttribute('data-id')
    if (!id) return // user clicked in something else      
    //pass id through to functions
    removeItemFromDOM(id);
    removeItemFromArray(id);
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
    toDoListArray.push({ itemId, toDoItem });
    console.log("localhost");
    localStorage.setItem('itemsJson', JSON.stringify(toDoListArray));
    console.log(toDoListArray)
  }

  function removeItemFromDOM(id) {
    // get the list item by data ID
    var li = document.querySelector('[data-id="' + id + '"]');
    // remove list item
    ul.removeChild(li);
  }

  function removeItemFromArray(id) {
    // create a new toDoListArray with all li's that don't match the ID
    toDoListArray = toDoListArray.filter(item => item.itemId !== id);
    console.log(toDoListArray);
  }

})();

  
        