// Selecting DOM elements
const container = document.querySelector(".container");
const btn_add = document.querySelector(".btn-add");
const input_task = document.querySelector(".input-task");

// Creating a container for the list
const list = document.createElement('div');
list.className = 'list';
container.appendChild(list);

// Load tasks from local storage when the page loads
document.addEventListener('DOMContentLoaded', () => {
  loadTasks();
});

// Function to save tasks array to local storage
function saveTasks(tasks) {
  localStorage.setItem('tasks', JSON.stringify(tasks));
}

// Function to load tasks array from local storage and create task elements
function loadTasks() {
  const savedTasks = localStorage.getItem('tasks');
  if (savedTasks) {
    const tasks = JSON.parse(savedTasks);

    // Clear existing tasks in the list
    list.innerHTML = "";

    // Create task elements for each task
    tasks.forEach(task => {
      createTaskElement(task);
    });
  }
}


// Function to create a task element and add it to the list
function createTaskElement(taskContent) {
  const list_item = document.createElement('div');
  const change_btn = document.createElement('div');
  const task = document.createElement('p');
  const btn_remove = document.createElement('button');
  const btn_edit = document.createElement('button');

  // Set up HTML and classes for task elements
  btn_edit.innerHTML = 'Edit';
  btn_remove.innerHTML = 'Remove';
  btn_remove.className = 'btn-remove';
  btn_edit.className = 'btn-edit';
  list_item.className = 'list-item';
  change_btn.className = 'change-btn';

  // Append elements to create the task structure
  list_item.appendChild(task);
  change_btn.appendChild(btn_edit);
  change_btn.appendChild(btn_remove);
  list_item.appendChild(change_btn);
  list.appendChild(list_item);

  // Set task content
  task.innerHTML = taskContent;

  // Add event listeners for remove and edit
  btn_remove.addEventListener("click", () => {
    list.removeChild(list_item);
    updateTasks();
  });

  btn_edit.addEventListener("click", () => {
    input_task.value = task.textContent;
    btn_add.textContent = "Edit";
    btn_add.removeEventListener("click", newItem);
    btn_add.addEventListener("click", () => {
      task.textContent = input_task.value;
      btn_add.textContent = "Add";
      btn_add.removeEventListener("click", editItem);
      btn_add.addEventListener("click", newItem);
      updateTasks();
    });
  });
}

// Function to update tasks array in local storage
function updateTasks() {
  const taskElements = document.querySelectorAll('.list-item p');
  const tasks = Array.from(taskElements).map(taskElement => taskElement.textContent);
  saveTasks(tasks);
}

// Function to add a new task
function newItem() {
  if (input_task.value !== "") {
    createTaskElement(input_task.value);
    input_task.value = "";
    updateTasks();
  }
}

// Add event listener for the "Add" button
btn_add.addEventListener("click", newItem);

// Create "Remove All" button element
const btn_removeAll = document.createElement('button');
btn_removeAll.className = 'Remove-All btn-remove';
btn_removeAll.textContent = 'Remove All';

// Event listener for the "Remove All" button
btn_removeAll.addEventListener("click", () => {
  // Remove all child elements from the list
  while (list.firstChild) {
    list.removeChild(list.firstChild);
  }
  updateTasks();
});

// Append the "Remove All" button to the container
container.appendChild(btn_removeAll);

// Attach event listeners to existing elements when the page loads
loadTasks();
