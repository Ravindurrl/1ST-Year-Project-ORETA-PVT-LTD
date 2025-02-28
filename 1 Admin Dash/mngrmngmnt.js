const managers = [];

// Open Add Manager Form
function openAddManagerForm() {
  document.getElementById("formTitle").innerText = "Add Manager";
  document.getElementById("managerForm").reset();
  document.getElementById("managerFormModal").style.display = "flex";
}

// Close the form
function closeForm() {
  document.getElementById("managerFormModal").style.display = "none";
}

// Save Manager
function saveManager() {
  const id = document.getElementById("managerId").value;
  const name = document.getElementById("managerName").value;
  const address = document.getElementById("managerAddress").value;
  const email = document.getElementById("managerEmail").value;
  const birthDate = document.getElementById("managerBirthDate").value;
  const telephone = document.getElementById("managerTelephone").value;
  const salary = document.getElementById("managerSalary").value;
  const department = document.getElementById("managerDepartment").value;

  managers.push({ id, name, address, email, birthDate, telephone, salary, department });
  renderManagerTable();
  closeForm();
}

// Render Manager Table
function renderManagerTable() {
  const tbody = document.getElementById("managerList");
  tbody.innerHTML = "";
  managers.forEach((manager, index) => {
    const row = `<tr>
      <td>${manager.id}</td>
      <td>${manager.name}</td>
      <td>${manager.address}</td>
      <td>${manager.email}</td>
      <td>${manager.birthDate}</td>
      <td>${manager.telephone}</td>
      <td>${manager.salary}</td>
      <td>${manager.department}</td>
      <td>
        <button onclick="editManager(${index})">Edit</button>
        <button onclick="deleteManager(${index})">Delete</button>
      </td>
    </tr>`;
    tbody.innerHTML += row;
  });
}

// Edit Manager
function editManager(index) {
  const manager = managers[index];
  document.getElementById("formTitle").innerText = "Edit Manager";
  document.getElementById("managerId").value = manager.id;
  document.getElementById("managerName").value = manager.name;
  document.getElementById("managerAddress").value = manager.address;
  document.getElementById("managerEmail").value = manager.email;
  document.getElementById("managerBirthDate").value = manager.birthDate;
  document.getElementById("managerTelephone").value = manager.telephone;
  document.getElementById("managerSalary").value = manager.salary;
  document.getElementById("managerDepartment").value = manager.department;
  document.getElementById("managerFormModal").style.display = "flex";
}

// Delete Manager
function deleteManager(index) {
  managers.splice(index, 1);
  renderManagerTable();
}

// Initial Render
renderManagerTable();
