let labelFormButton = document.getElementById('labelFormButton');
let labelForm = document.getElementById('labelForm');
let labelFormClose = document.getElementById('labelFormClose');

function displayLabelForm() {
    if (labelForm.style.display === 'none') {
        labelForm.style.display = 'block';
        labelFormButton.style.display = 'none';
    } else {
        labelForm.style.display = 'none';
        labelFormButton.style.display = 'block';
    }
}

labelFormButton.addEventListener('click', displayLabelForm);
labelFormClose.addEventListener('click', displayLabelForm);





