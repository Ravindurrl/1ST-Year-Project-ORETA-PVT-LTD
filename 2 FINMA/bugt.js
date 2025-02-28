document.getElementById('investment-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const projectId = document.getElementById('project-id').value;
    const budgetAmount = document.getElementById('budget-amount').value;
    const investmentAmount = document.getElementById('investment-amount').value;
    const investmentDate = document.getElementById('investment-date').value;
    
    const table = document.getElementById('investment-records');
    const row = table.insertRow();
    
    const cell1 = row.insertCell(0);
    const cell2 = row.insertCell(1);
    const cell3 = row.insertCell(2);
    const cell4 = row.insertCell(3);
    const cell5 = row.insertCell(4);
    
    cell1.textContent = projectId;
    cell2.textContent = budgetAmount;
    cell3.textContent = investmentAmount;
    cell4.textContent = investmentDate;
    cell5.innerHTML = '<button onclick="editInvestment(this)">Edit</button><button onclick="deleteInvestment(this)">Delete</button>';
    
    document.getElementById('investment-form').reset();
});

function editInvestment(button) {
    const row = button.parentElement.parentElement;
    document.getElementById('project-id').value = row.cells[0].textContent;
    document.getElementById('budget-amount').value = row.cells[1].textContent;
    document.getElementById('investment-amount').value = row.cells[2].textContent;
    document.getElementById('investment-date').value = row.cells[3].textContent;
    
    row.remove();
}

function deleteInvestment(button) {
    const row = button.parentElement.parentElement;
    row.remove();
}

function goBack() {
    window.history.back();
}