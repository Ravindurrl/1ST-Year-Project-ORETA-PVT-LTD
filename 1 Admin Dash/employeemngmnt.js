const employees = [];

// Open Add Employee Form
function openAddEmployeeForm() {
  document.getElementById("formTitle").innerText = "Add Employee";
  document.getElementById("employeeForm").reset();
  document.getElementById("employeeFormModal").style.display = "flex";
}

// Close the form
function closeForm() {
  document.getElementById("employeeFormModal").style.display = "none";
}

// Save Employee
function saveEmployee() {
  const id = document.getElementById("employeeId").value;
  const name = document.getElementById("employeeName").value;
  const telephone = document.getElementById("employeeTelephone").value;
  const email = document.getElementById("employeeEmail").value;

  employees.push({ id, name, telephone, email });
  renderEmployeeTable();
  closeForm();
}

// Render Employee Table
function renderEmployeeTable() {
  const tbody = document.getElementById("employeeList");
  tbody.innerHTML = "";
  employees.forEach((employee, index) => {
    const row = `<tr>
      <td>${employee.id}</td>
      <td>${employee.name}</td>
      <td>${employee.telephone}</td>
      <td>${employee.email}</td>
      <td>
        <button onclick="editEmployee(${index})">Edit</button>
        <button onclick="deleteEmployee(${index})">Delete</button>
      </td>
    </tr>`;
    tbody.innerHTML += row;
  });
}

// Edit Employee
function editEmployee(index) {
  const employee = employees[index];
  document.getElementById("formTitle").innerText = "Edit Employee";
  document.getElementById("employeeId").value = employee.id;
  document.getElementById("employeeName").value = employee.name;
  document.getElementById("employeeTelephone").value = employee.telephone;
  document.getElementById("employeeEmail").value = employee.email;
  document.getElementById("employeeFormModal").style.display = "flex";
}

// Delete Employee
function deleteEmployee(index) {
  employees.splice(index, 1);
  renderEmployeeTable();
}

// Initial Render
renderEmployeeTable();
