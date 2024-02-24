document.getElementById('add-instructor').addEventListener('click', function() {
    const instructorDiv = document.createElement('div');
    instructorDiv.className = 'input-group mb-2';

    const instructorInput = document.createElement('input');
    instructorInput.type = 'text';
    instructorInput.name = 'instructores[]';
    instructorInput.className = 'form-control';
    instructorInput.placeholder = 'Nombre del instructor';

    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'btn btn-outline-danger';
    removeButton.textContent = 'Eliminar';
    removeButton.addEventListener('click', function() {
        removeInstructor(removeButton);
    });

    instructorDiv.appendChild(instructorInput);
    instructorDiv.appendChild(removeButton);

    document.getElementById('instructores-list').appendChild(instructorDiv);
});

function removeInstructor(button) {
    button.parentElement.remove();
}


//JS PARA LA VISTA CONSULTAR
