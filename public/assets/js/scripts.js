document.addEventListener('DOMContentLoaded', function() {
// Select the input element
const inputbd = document.querySelector('#birthday');

// Add an event listener to the input element
inputbd.addEventListener('input', function() {
// Get the current value of the input element
let value = this.value;
  
// Remove any non-numeric characters from the value
value = value.replace(/[^0-9]/g, '');

// Add the dots to the value
if (value.length > 2) {
  value = value.slice(0, 2) + '.' + value.slice(2);
}
if (value.length > 5) {
  value = value.slice(0, 5) + '.' + value.slice(5, 9);
}
if (value.length > 10) {
  value = value.slice(0, 10);
}

// Set the new value of the input element
this.value = value;
});

// Select the input element
const inputcalc = document.querySelector('#calc-num');

// Add an event listener to the input element
inputcalc.addEventListener('input', function() {
  // Get the current value of the input element
  let value = this.value;
  
  // Remove any non-numeric characters from the value
  value = value.replace(/[^0-9]/g, '');
  
  // Truncate the value to two digits
  value = value.slice(0, 2);
  
  // Set the new value of the input element
  this.value = value;
});

document.getElementById('calc-rest').addEventListener('change', function() {
  // Get selected vacancies from value of select element
  const vacancies = JSON.parse(this.value);
  

  // Clear previous options from vacancy select element
  const vacancySelect = document.getElementById('calc-vac');
  while (vacancySelect.options.length > 0) {
    vacancySelect.remove(0);
  }

  // Add initial disabled option to vacancy select element
  const initialOption = document.createElement('option');
  initialOption.disabled = true;
  initialOption.selected = true;
  initialOption.textContent = 'Выбрать вакансию';
  vacancySelect.appendChild(initialOption);

  // Add options for each vacancy to vacancy select element
  vacancies.forEach(function(vacancy) {
    const vacancyOption = document.createElement('option');
    vacancyOption.value = vacancy.price_per_hour;
    vacancyOption.textContent = vacancy.name;
    vacancySelect.appendChild(vacancyOption);
  });

  // Enable vacancy select element
  vacancySelect.disabled = false;
});

document.getElementById('cont-rest').addEventListener('change', function() {
  // Get selected vacancies from value of select element
  const vacancies = JSON.parse(this.value);
  

  // Clear previous options from vacancy select element
  const vacancySelect = document.getElementById('cont-vac');
  while (vacancySelect.options.length > 0) {
    vacancySelect.remove(0);
  }

  // Add initial disabled option to vacancy select element
  const initialOption = document.createElement('option');
  initialOption.disabled = true;
  initialOption.selected = true;
  initialOption.value = "";
  initialOption.textContent = 'Выбрать вакансию';
  vacancySelect.appendChild(initialOption);

  // Add options for each vacancy to vacancy select element
  vacancies.forEach(function(vacancy) {
    const vacancyOption = document.createElement('option');
    vacancyOption.value = vacancy.id;
    vacancyOption.textContent = vacancy.name;
    vacancySelect.appendChild(vacancyOption);
  });

  // Enable vacancy select element
  vacancySelect.disabled = false;
});


document.getElementById('calc-vac').addEventListener('change', function() {
  // Remove disabled class from num input element
  document.getElementById('calc-num').disabled = false;
  document.getElementById('calculate').disabled = false;
  document.getElementById('calculate').classList.remove('disabled');


});

document.getElementById('calculate').addEventListener('click', function(event) {
  // Prevent default behavior of link
  event.preventDefault();

  // Get numeric value from num input element
  let numValue = parseFloat(document.getElementById('calc-num').value.replace(',', '.'));

  // Check if value is between 4.5 and 40
  if (numValue >= 4.5 && numValue <= 40) {
    document.getElementById('calc-num-field').classList.remove('error');

    // Get vacancy value from select element
    let vacancyValue = parseFloat(document.getElementById('calc-vac').value);

    // Calculate salary
    let salary = vacancyValue * 7 * numValue;

    // Round salary to 2 decimal places
    let roundedSalary = Math.round(salary * 100) / 100;

    // Set result in result element
    document.getElementById('calc-result').textContent = roundedSalary;

    // Hide calculations-prepare element
    document.getElementById('calculations-prepare').classList.add('d-none');

    // Show calculations element
    document.getElementById('calculations').classList.remove('d-none');
  }
  else{
    document.getElementById('calc-num-field').classList.add('error');
    
  }
});

const form = document.getElementById('form');
form.addEventListener('submit', (event) => {
  event.preventDefault();
  // const selectedRest = JSON.parse(restSelect.value)[0];
  const formData = new FormData(form);
  const restValue = document.getElementById('cont-rest').value;
  const restData = JSON.parse(restValue);
  let restId;

  for (let i = 0; i < restData.length; i++) {
    restId = restData[i].rest_id;
    break;
  }
  formData.set('rest', restId);

  const data = {};
  for (const [key, value] of formData.entries()) {
    data[key] = value;
  }

  console.log(data);


  
  

  fetch('/api/v1/lead', {
    method: 'POST',
    body: formData
  })
  .then(response => {
    const successModal = new bootstrap.Modal(document.getElementById('successModal'), {});
    successModal.show();
    // handle the server response here
  })
  .catch(error => {
    alert('Ошибка')
    // handle errors here
  });
  

  

});




});

// // Select the input element
// const inputphone = document.querySelector('#phone');

// // Add an event listener to the input element
// inputphone.addEventListener('input', function() {
//   // Get the current value of the input element
//   let value = this.value;
  
//   // Remove any non-numeric characters from the value
//   value = value.replace(/[^0-9]/g, '');
  
//   // Add the plus sign and country code to the value
//   value = '+375 ' + value;
  
//   // Add the brackets around the area code
//   if (value.length > 7) {
//     value = value.slice(0, 7) + '(' + value.slice(7);
//   }
//   if (value.length > 10) {
//     value = value.slice(0, 10) + ')' + value.slice(10);
//   }
  
//   // Add the hyphens to the value
//   if (value.length > 13) {
//     value = value.slice(0, 13) + '-' + value.slice(13);
//   }
//   if (value.length > 16) {
//     value = value.slice(0, 16) + '-' + value.slice(16);
//   }
  
//   // Set the new value of the input element
//   this.value = value;
// });
