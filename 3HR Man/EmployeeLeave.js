function printReport() {
    window.print();
}

function addRow() {
    const table = document.getElementById('leaveReportTable').getElementsByTagName('tbody')[0];
    const newRow = table.insertRow();

    newRow.innerHTML = `
        <td contenteditable="true">EMPXXX</td>
        <td contenteditable="true">New Employee</td>
        <td contenteditable="true">Leave Type</td>
        <td contenteditable="true">Status</td>
        <td contenteditable="true">0</td>
        <td>
            <button onclick="updateRow(this)">Update</button>
        </td>
    `;

    alert('New leave report added! Edit the fields and update as needed.');
}

function updateRow(button) {
    const row = button.closest('tr');
    const cells = row.querySelectorAll('td');

    const empID = prompt('Update Employee ID:', cells[0].innerText);
    const empName = prompt('Update Employee Name:', cells[1].innerText);
    const leaveType = prompt('Update Leave Type:', cells[2].innerText);
    const leaveStatus = prompt('Update Leave Status:', cells[3].innerText);
    const leaveBalance = prompt('Update Leave Balance (Days):', cells[4].innerText);

    if (empID && empName && leaveType && leaveStatus && leaveBalance) {
        cells[0].innerText = empID;
        cells[1].innerText = empName;
        cells[2].innerText = leaveType;
        cells[3].innerText = leaveStatus;
        cells[4].innerText = leaveBalance;
        alert('Row updated successfully!');
    } else {
        alert('Update canceled. All fields are required.');
    }
}


