document.addEventListener('DOMContentLoaded', () => {
    const taskForm = document.getElementById('task-form');
    const taskInput = document.getElementById('task-input');
    const taskList = document.getElementById('task-list');

    const apiUrl = 'api.php';

    // Function to fetch and display tasks
    const fetchTasks = async () => {
        try {
            const response = await fetch(apiUrl);
            const tasks = await response.json();
            
            // Clear the current list
            taskList.innerHTML = '';

            // Add each task to the list
            tasks.forEach(task => {
                const li = document.createElement('li');
                li.innerHTML = `
                    <span>${escapeHTML(task.task)}</span>
                    <button class="delete-btn" data-id="${task.id}">Delete</button>
                `;
                taskList.appendChild(li);
            });
        } catch (error) {
            console.error('Error fetching tasks:', error);
        }
    };

    // Function to add a new task
    const addTask = async (taskText) => {
        try {
            const response = await fetch(apiUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'add', task: taskText })
            });
            const result = await response.json();
            if (result.success) {
                fetchTasks(); // Refresh the list
            } else {
                alert('Error adding task: ' + result.message);
            }
        } catch (error) {
            console.error('Error adding task:', error);
        }
    };

    // Function to delete a task
    const deleteTask = async (taskId) => {
        try {
            const response = await fetch(apiUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'delete', id: taskId })
            });
            const result = await response.json();
            if (result.success) {
                fetchTasks(); // Refresh the list
            } else {
                alert('Error deleting task: ' + result.message);
            }
        } catch (error) {
            console.error('Error deleting task:', error);
        }
    };

    // Event listener for form submission
    taskForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const taskText = taskInput.value.trim();
        if (taskText) {
            addTask(taskText);
            taskInput.value = ''; // Clear input field
        }
    });

    // Event listener for delete buttons (uses event delegation)
    taskList.addEventListener('click', (e) => {
        if (e.target.classList.contains('delete-btn')) {
            const taskId = e.target.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this task?')) {
                deleteTask(taskId);
            }
        }
    });

    // Simple function to escape HTML to prevent XSS
    const escapeHTML = (str) => {
        const p = document.createElement('p');
        p.appendChild(document.createTextNode(str));
        return p.innerHTML;
    };

    // Initial fetch of tasks when the page loads
    fetchTasks();
});
