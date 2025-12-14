// Sélection des éléments HTML
const todoInput = document.querySelector(".todo-input"); // Champ de saisie de tâche
const todoList = document.querySelector(".todo-list"); // Liste des tâches
const todoButton = document.querySelector(".todo-button"); // Bouton d'ajout
const filterOption = document.querySelector(".filter-todo"); // Menu déroulant de filtre

// Écouteurs d'événements
document.addEventListener("DOMContentLoaded", getTodos); // Récupère les tâches au chargement
todoButton.addEventListener("click", addTodo); // Ajoute une tâche
todoList.addEventListener("click", deleteCheck); // Supprime ou coche une tâche
filterOption.addEventListener("input", filterTodo); // Filtre les tâches

// Fonction pour ajouter une tâche
function addTodo(event) {
    event.preventDefault(); // Empêche le rechargement de la page

    // Création de la div contenant la tâche
    const todoDiv = document.createElement("div");
    todoDiv.classList.add("todo");

    // Création de l'élément <li> contenant le texte
    const newTodo = document.createElement("li");
    newTodo.innerText = todoInput.value;
    newTodo.classList.add("todo-item");
    todoDiv.appendChild(newTodo);

    // Sauvegarde dans le localStorage
    saveLocalTodos(todoInput.value);

    // Bouton pour marquer comme complété
    const completedButton = document.createElement("button");
    completedButton.innerHTML = "<i class='fas fa-check fa-2x'></i>";
    completedButton.classList.add("completed-btn");
    todoDiv.appendChild(completedButton);

    // Bouton pour supprimer
    const deleteButton = document.createElement("button");
    deleteButton.innerHTML = "<i class='fas fa-trash fa-2x'></i>";
    deleteButton.classList.add("delete-btn");
    todoDiv.appendChild(deleteButton);

    // Ajout de l'élément dans la liste
    todoList.appendChild(todoDiv);

    // Réinitialisation du champ de saisie
    todoInput.value = "";
}

// Fonction pour gérer la suppression ou le marquage des tâches
function deleteCheck(e) {
    const item = e.target;

    // Suppression de la tâche
    if (item.classList[0] === "delete-btn") {
        const todo = item.parentElement;
        todo.classList.add("fall"); // Ajout animation CSS
        removeLocalTodos(todo); // Supprime du localStorage
        todo.addEventListener("transitionend", function() {
            todo.remove(); // Supprime du DOM après l’animation
        });
    }

    // Marquage comme complété
    if (item.classList[0] === "completed-btn") {
        const todo = item.parentElement;
        todo.classList.toggle("completed"); // Ajoute ou retire la classe "completed"
        updateLocalTodoStatus(todo); // Met à jour le localStorage
    }
}

// Fonction de filtrage des tâches
function filterTodo(e) {
    const todos = todoList.children;
    
    Array.from(todos).forEach(function (todo) {
        switch (e.target.value) {
            case "all":
                todo.style.display = "flex";
                break;
            case "completed":
                if (todo.classList.contains("completed")) {
                    todo.style.display = "flex";
                } else {
                    todo.style.display = "none";
                }
                break;
            case "uncompleted":
                if (!todo.classList.contains("completed")) {
                    todo.style.display = "flex";
                } else {
                    todo.style.display = "none";
                }
                break;
        }
    });
}

// Fonction pour sauvegarder une tâche dans le localStorage
function saveLocalTodos(todo) {
    let todos;
    if (localStorage.getItem('todos') == null) {
        todos = [];
    } else {
        todos = JSON.parse(localStorage.getItem('todos'));
    }

    todos.push({ text: todo, completed: false }); // Ajout sous forme d’objet
    localStorage.setItem('todos', JSON.stringify(todos));
}

// Fonction exécutée au chargement pour afficher les tâches sauvegardées
function getTodos() {
    let todos;
    if (localStorage.getItem('todos') == null) {
        todos = [];
    } else {
        todos = JSON.parse(localStorage.getItem('todos'));
    }

    // Création des éléments pour chaque tâche
    todos.forEach(function(todo) {
        const todoDiv = document.createElement("div");
        todoDiv.classList.add("todo");

        if (todo.completed) {
            todoDiv.classList.add("completed"); // Si elle est complétée, appliquer la classe
        }

        const newTodo = document.createElement("li");
        newTodo.innerText = todo.text;
        newTodo.classList.add("todo-item");
        todoDiv.appendChild(newTodo);

        const completedButton = document.createElement("button");
        completedButton.innerHTML = "<i class='fas fa-check fa-2x'></i>";
        completedButton.classList.add("completed-btn");
        todoDiv.appendChild(completedButton);

        const deleteButton = document.createElement("button");
        deleteButton.innerHTML = "<i class='fas fa-trash fa-2x'></i>";
        deleteButton.classList.add("delete-btn");
        todoDiv.appendChild(deleteButton);

        todoList.appendChild(todoDiv);
    });
}

// Fonction pour supprimer une tâche du localStorage
function removeLocalTodos(todo) {
    let todos;
    if (localStorage.getItem('todos') == null) {
        todos = [];
    } else {
        todos = JSON.parse(localStorage.getItem('todos'));
    }

    const todoIndex = todo.children[0].innerText;

    // Supprimer l'objet avec le texte correspondant
    todos = todos.filter(t => t.text !== todoIndex);
    localStorage.setItem('todos', JSON.stringify(todos));
}

// Fonction pour mettre à jour le statut "complété" dans le localStorage
function updateLocalTodoStatus(todo) {
    let todos;
    if (localStorage.getItem("todos") == null) {
        todos = [];
    } else {
        todos = JSON.parse(localStorage.getItem("todos"));
    }

    const todoText = todo.children[0].innerText;

    todos.forEach(function(t) {
        if (t.text === todoText) {
            t.completed = todo.classList.contains("completed"); // Mise à jour du statut
        }
    });

    localStorage.setItem("todos", JSON.stringify(todos));
}
