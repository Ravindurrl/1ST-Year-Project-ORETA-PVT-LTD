document.getElementById('salary-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const employeeId = document.getElementById('employee-id').value;
    const employeeName = document.getElementById('employee-name').value;
    const hoursWorked = parseFloat(document.getElementById('hours-worked').value);
    const hourlyRate = 2500;
    const salary = hoursWorked * hourlyRate;
    
    const table = document.getElementById('salary-records');
    const row = table.insertRow();
    
    const cell1 = row.insertCell(0);
    const cell2 = row.insertCell(1);
    const cell3 = row.insertCell(2);
    const cell4 = row.insertCell(3);
    const cell5 = row.insertCell(4);
    
    cell1.textContent = employeeId;
    cell2.textContent = employeeName;
    cell3.textContent = hoursWorked;
    cell4.textContent = salary;
    cell5.innerHTML = '<button onclick="editSalary(this)">Edit</button><button onclick="deleteSalary(this)">Delete</button>';
    
    document.getElementById('salary-form').reset();
    
    updateTotalSalary();
});

function editSalary(button) {
    const row = button.parentElement.parentElement;
    document.getElementById('employee-id').value = row.cells[0].textContent;
    document.getElementById('employee-name').value = row.cells[1].textContent;
    document.getElementById('hours-worked').value = row.cells[2].textContent;
    
    row.remove();
    updateTotalSalary();
}

function deleteSalary(button) {
    const row = button.parentElement.parentElement;
    row.remove();
    updateTotalSalary();
}

function updateTotalSalary() {
    const table = document.getElementById('salary-records');
    let totalSalary = 0;
    
    for (let i = 0; i < table.rows.length; i++) {
        totalSalary += parseFloat(table.rows[i].cells[3].textContent);
    }
    
    document.getElementById('total-salary').textContent = `Total Salary:Rs. ${totalSalary} `;
}

function goBack() {
    window.history.back();
}