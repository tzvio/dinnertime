function initTagify(data) {
  var inputElem = document.querySelector('.search-ingridients') 
  var searchButton = document.querySelector('.searchButton');
  var tagify = new Tagify(inputElem, {
    whitelist: data,
    enforceWhitelist: true
  });
  searchButton.addEventListener('click',function (e) {
    var recipes = [];
    tagify.value.forEach((item) => {
      recipes.push(item.value);
    });
    searchIngridients(recipes);
  });
}

function outputSearchIngridients(data) {
  var recipeList = document.querySelector(".recipes");
  recipeList.innerHTML=data;
}

function searchIngridients(data) {
  fetch('/searchRecipesByIngridients', {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({data})
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.text();
  })
  .then(data => {
    outputSearchIngridients(data);
  })
  .catch(error => {
    console.error('Error:', error);
  });
}

fetch('/getAllIngridients')
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    initTagify(data);
  })
  .catch(error => {
    console.error('Error:', error);
  });

